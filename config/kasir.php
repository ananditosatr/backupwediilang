<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Kasir Courier Settings
    |--------------------------------------------------------------------------
    |
    | These values are used in printed documents such as invoice and delivery
    | notes. Change them in your .env file if you need to update the courier
    | information without editing the templates.
    |
    */

    'courier_name'         => env('KASIR_COURIER_NAME', 'Satria'),
    'courier_phone'        => env('KASIR_COURIER_PHONE', '08784493357'),
    'min_delivery_amount'  => env('KASIR_MIN_DELIVERY_AMOUNT', 300000),
    'min_delivery_items'   => env('KASIR_MIN_DELIVERY_ITEMS', 1),
    // Static QRIS payload (merchant static QR). Set in .env as KASIR_QRIS_STATIC_PAYLOAD.
    'qris_static_payload'  => env('KASIR_QRIS_STATIC_PAYLOAD', '00020101021126690021ID.CO.BANKMANDIRI.WWW01189360000801263415700211712634157000303UKE51440014ID.CO.QRIS.WWW0215ID10232733334690303UKE5204274153033605802ID5918Rumah Cake Suprezz6014Sidoarjo (Kab)61056125762070703A016304A4D0'),
];
