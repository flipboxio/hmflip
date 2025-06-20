<?php

return [
    'name' => 'Paystack',

    'alias' => 'paystack',

    'logo' => 'Modules/Paystack/Resources/assets/paystack.png',

    'options' => [
        ['label' => __('Settings'), 'type' => 'modal', 'url' => 'paystack.edit'],
        ['label' => __('Paystack Documentation'), 'target' => '_blank', 'url' => 'https://paystack.com/docs/payments']
    ],

    'validation' => [
        'rules' => [
            'name' => 'required',
            'secretKey' => 'required',
            'publicKey' => 'required',
            'sandbox' => 'required',
        ],
        'attributes' => [
            'secretKey' => __('Secret Key'),
            'publicKey' => __('Public Key'),
            'sandbox' => __('Please specify sandbox enabled/disabled.')
        ]
    ],
    'fields' => [
        'name' => [
            'label' => __('Display Name'),
            'type' => 'text',
            'required' => true
        ],
        'secretKey' => [
            'label' => __('Secret Key'),
            'type' => 'text',
            'required' => true
        ],
        'publicKey' => [
            'label' => __('Public Key'),
            'type' => 'text',
            'required' => true
        ],
        'instruction' => [
            'label' => __('Instruction'),
            'type' => 'textarea',
        ],
        'sandbox' => [
            'label' => __('Sandbox'),
            'type' => 'select',
            'required' => true,
            'options' => [
                'Enabled' => 1,
                'Disabled' =>  0
            ]
        ],
        'status' => [
            'label' => 'Status',
            'type' => 'select',
            'required' => true,
            'options' => [
                'Active' => 1,
                'Inactive' =>  0
            ],
        ]
    ],

    'ssl_verify_host' => false,

    'ssl_verify_peer' => false,


    'store_route' => 'paystack.store',
];
