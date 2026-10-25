<?php

return [
    /*
    |--------------------------------------------------------------------------
    | JWT Secret Key
    |--------------------------------------------------------------------------
    | Kunci rahasia untuk menandatangani dan memverifikasi token JWT dari API Auth.
    */
    'secret' => env('JWT_SECRET', '3Qs5g0nA9rxpXGIXI9OdVLVKZrVkMcIIn7KS6avl6z5nHhYVH25IcUIYotidfatU'),

    /*
    |--------------------------------------------------------------------------
    | JWT Algorithm
    |--------------------------------------------------------------------------
    | Algoritma hashing HMAC yang digunakan (contoh: HS256, HS384, HS512).
    */
    'algo' => env('JWT_ALGO', 'HS256'),
];
