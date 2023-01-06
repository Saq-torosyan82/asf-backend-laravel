<?php

return [

    /*
    |--------------------------------------------------------------------------
    | AppSection Section Payment Container
    |--------------------------------------------------------------------------
    |
    |
    |
    */

    'reminders' => [
        'days_before' => [
            'first_reminder' => env('SEND_FIRST_PAYMENT_REMINDER_DAYS_BEFORE', 5),
            'second_reminder' => env('SEND_SECOND_PAYMENT_REMINDER_DAYS_BEFORE', 1),
            'payment_confirmation' => env('SEND_PAYMENT_CONFIRMATION_DAYS_BEFORE', 0),
        ]
    ],
    'confirm_payment_route' => env('MAIN_URL') . '/confirm-payment'
];
