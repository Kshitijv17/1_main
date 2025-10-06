<?php

return [

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    // 🔐 Authentication Guards
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'api' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ],
        'vendor' => [
            'driver' => 'session',
            'provider' => 'vendors',
        ],
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
    ],

    // 🧬 User Providers
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
            'table' => 'users',
        ],
        'vendors' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
            'table' => 'users',
        ],
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
            'table' => 'users',
        ],
    ],

    // 🔑 Password Reset Settings
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
        'vendors' => [
            'provider' => 'vendors',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
        'admins' => [
            'provider' => 'admins',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    // 🕒 Password Confirmation Timeout
    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
