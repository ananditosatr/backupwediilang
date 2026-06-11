<?php

namespace App\Services;

/**
 * QRIS helper to convert a static QRIS payload to dynamic and recalculate CRC16.
 */
class QrisService
{
    /**
     * Convert a raw QRIS string (EMV TLV) from static to dynamic and insert amount (Tag 54).
     *
     * @param string $rawPayload Original QRIS raw string (including existing CRC tag)
     * @param float|int $amount Numeric amount in IDR.
     * @param array|null $options Optional conversion settings: ['fee' => ['type' => 'fixed'|'percentage', 'value' => number]].
     * @return string Modified QRIS payload with Tag 01 = 12, Tag 54 inserted, and CRC (Tag 63) recalculated.
     */
    public static function makeDynamic(string $rawPayload, $amount, ?array $options = null): string
    {
        $payload = $rawPayload;

        // Strip existing CRC tag at the end.
        $pos = strrpos($payload, '63');
        if ($pos !== false && substr($payload, $pos, 4) === '6304') {
            $payload = substr($payload, 0, $pos);
        }

        $fields = [];
        $i = 0;
        $lenTotal = strlen($payload);
        while ($i + 4 <= $lenTotal) {
            $tag = substr($payload, $i, 2);
            $i += 2;
            $lenStr = substr($payload, $i, 2);
            $i += 2;
            $valueLen = intval($lenStr, 10);

            if ($i + $valueLen > $lenTotal) {
                break;
            }

            $value = substr($payload, $i, $valueLen);
            $i += $valueLen;

            if ($tag === '63') {
                break;
            }

            $fields[] = ['tag' => $tag, 'len' => $lenStr, 'value' => $value];
        }

        $amountStr = rtrim(rtrim(number_format((float)$amount, 2, '.', ''), '0'), '.');

        $fee = $options['fee'] ?? null;
        $feeElements = [];
        if (is_array($fee) && isset($fee['type'], $fee['value'])) {
            if ($fee['type'] === 'fixed') {
                $feeElements[] = ['tag' => '55', 'len' => '02', 'value' => '02'];
                $feeValue = (string) $fee['value'];
                $feeElements[] = ['tag' => '56', 'len' => sprintf('%02d', strlen($feeValue)), 'value' => $feeValue];
            } elseif ($fee['type'] === 'percentage') {
                $feeElements[] = ['tag' => '55', 'len' => '02', 'value' => '03'];
                $feeValue = (string) $fee['value'];
                $feeElements[] = ['tag' => '57', 'len' => sprintf('%02d', strlen($feeValue)), 'value' => $feeValue];
            }
        }

        $newFields = [];
        $inserted = false;

        foreach ($fields as $field) {
            if ($field['tag'] === '01') {
                $field['value'] = '12';
                $field['len'] = sprintf('%02d', strlen($field['value']));
            }

            if ($field['tag'] === '58' && ! $inserted) {
                $newFields[] = ['tag' => '54', 'len' => sprintf('%02d', strlen($amountStr)), 'value' => $amountStr];
                foreach ($feeElements as $feeElement) {
                    $newFields[] = $feeElement;
                }
                $inserted = true;
            }

            $newFields[] = $field;
        }

        if (! $inserted) {
            $newFields[] = ['tag' => '54', 'len' => sprintf('%02d', strlen($amountStr)), 'value' => $amountStr];
            foreach ($feeElements as $feeElement) {
                $newFields[] = $feeElement;
            }
        }

        $newPayload = '';
        foreach ($newFields as $field) {
            $newPayload .= $field['tag'] . $field['len'] . $field['value'];
        }

        $toCrc = $newPayload . '6304';
        $crc = strtoupper(self::crc16Ccitt($toCrc));

        return $toCrc . $crc;
    }

    /**
     * Compute CRC16-CCITT (polynomial 0x1021) with init 0xFFFF, no XOR out.
     * Returns 4-char uppercase hex string.
     *
     * @param string $data
     * @return string
     */
    public static function crc16Ccitt(string $data): string
    {
        $crc = 0xFFFF;
        $len = strlen($data);
        for ($i = 0; $i < $len; $i++) {
            $crc ^= (ord($data[$i]) << 8);
            for ($j = 0; $j < 8; $j++) {
                if (($crc & 0x8000) !== 0) {
                    $crc = (($crc << 1) & 0xFFFF) ^ 0x1021;
                } else {
                    $crc = ($crc << 1) & 0xFFFF;
                }
            }
        }
        return str_pad(strtoupper(dechex($crc & 0xFFFF)), 4, '0', STR_PAD_LEFT);
    }
}
