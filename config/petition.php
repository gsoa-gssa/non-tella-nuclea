<?php

return [
    /**
     * Application default user
     */
    'default_user' => [
        'name' => env("PET_ADMIN_NAME", "Admin"),
        'email' => env("PET_ADMIN_EMAIL", "admin@localhost"),
        'password' => env("PET_ADMIN_PASSWORD", "password")
    ],
];
