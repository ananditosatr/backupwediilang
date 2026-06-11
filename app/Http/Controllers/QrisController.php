<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\QrisService;
use Illuminate\Support\Facades\Log;

class QrisController extends Controller
{
    /**
     * Return PNG image of QR for given amount (query param `amount`).
     * Falls back to qrcode.js rendering on frontend.
     */
    public function png(Request $request)
    {
        $amount = $request->query('amount');
        if (is_null($amount)) {
            return response()->json(['error' => 'amount required'], 400);
        }

        $static = config('kasir.qris_static_payload');
        if (empty($static)) {
            return response()->json(['error' => 'no static payload configured'], 500);
        }

        $dynamic = QrisService::makeDynamic($static, $amount);
        return response()->json(['qris_payload' => $dynamic]);
    }

    /**
     * Generate QR, save as PNG to public/images, and return URL
     */
    public function generate(Request $request)
    {
        $amount = $request->query('amount');
        if (is_null($amount)) {
            return response()->json(['error' => 'amount required'], 400);
        }

        $static = config('kasir.qris_static_payload');
        if (empty($static)) {
            return response()->json(['error' => 'no static payload configured'], 500);
        }

        $dynamic = QrisService::makeDynamic($static, $amount);
        
        // Try to save image from frontend-generated base64 or generate URL
        $filename = public_path("/images/qris_{$amount}.png");
        $url = url("/images/qris_{$amount}.png");
        
        // Check if file already exists
        if (file_exists($filename)) {
            return response()->json(['url' => $url, 'cached' => true]);
        }
        
        // Return URL with directive to generate on frontend
        return response()->json([
            'url' => $url,
            'qris_payload' => $dynamic,
            'instruction' => 'save_from_frontend'
        ]);
    }

    /**
     * Save QR code image from frontend base64
     */
    public function saveImage(Request $request)
    {
        $amount = $request->post('amount');
        $imageData = $request->post('image');
        
        if (!$amount || !$imageData) {
            return response()->json(['error' => 'amount and image required'], 400);
        }

        // Remove data URI prefix if present
        if (strpos($imageData, 'data:image/png;base64,') === 0) {
            $imageData = substr($imageData, strlen('data:image/png;base64,'));
        }

        $filename = public_path("/images/qris_{$amount}.png");
        
        try {
            $png = base64_decode($imageData, true);
            if ($png === false) {
                return response()->json(['error' => 'invalid base64'], 400);
            }
            
            file_put_contents($filename, $png);
            return response()->json(['url' => url("/images/qris_{$amount}.png"), 'saved' => true]);
        } catch (\Throwable $e) {
            Log::error('Failed to save QR image: ' . $e->getMessage());
            return response()->json(['error' => 'save failed'], 500);
        }
    }
}
