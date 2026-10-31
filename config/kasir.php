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




    'courier_name'        => env('KASIR_COURIER_NAME'),
    'courier_phone'       => env('KASIR_COURIER_PHONE'),
    'min_delivery_items'  => env('KASIR_MIN_DELIVERY_ITEMS', 20),
];



