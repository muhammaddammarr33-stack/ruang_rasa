<?php
return [
    'mode' => 'mailhog', // ganti ke 'gmail' kalau mau kirim ke email asli

    'gmail' => [
        'host' => 'smtp.gmail.com',
        'port' => 587,
        'user' => 'emailkamu@gmail.com',       // ubah ke email kamu
        'pass' => 'app_password_gmailmu'       // ubah ke App Password Gmail
    ],

    'mailhog' => [
        'host' => 'localhost',
        'port' => 1025
    ]
];
