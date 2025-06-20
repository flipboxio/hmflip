<?php

return [
    'name' => 'Paytr',

    'alias' => 'paytr',

    'logo' => 'Modules/Paytr/Resources/assets/paytr.png',

    // Paytr addon settings

    'options' => [
        ['label' => __('Settings'), 'type' => 'modal', 'url' => 'paytr.edit'],
        ['label' => __('Paytr Documentation'), 'target' => '_blank', 'url' => 'https://dev.paytr.com/en']
    ],

    /**
     * Paytr data validation
     */
    'validation' => [
        'rules' => [
            'name'          => 'required',
            'merchantId'    => 'required',
            'merchantKey'   => 'required',
            'merchantSalt'  => 'required',
            'callbackURL'   => 'required',
            'sandbox'       => 'required',
        ],
        'attributes' => [
            'name'          => __('Display Name'),
            'merchantId'    => __('Merchant Id'),
            'merchantKey'   => __('Merchant Key'),
            'merchantSalt'  => __('Merchant Salt'),
            'callbackURL'   => __('Callback URL'),
            'sandbox'       => __('Please specify sandbox enabled/disabled.')
        ]
    ],
    'fields' => [
        'name' => [
            'label'         => __('Display Name'),
            'type'          => 'text',
            'required'      => true
        ],
        'merchantId' => [
            'label'         => __('Merchant Id'),
            'type'          => 'text',
            'required'      => true
        ],
        'merchantKey' => [
            'label'         => __('Merchant Key'),
            'type'          => 'text',
            'required'      => true
        ],
        'merchantSalt' => [
            'label'         => __('Merchant Salt'),
            'type'          => 'text',
            'required'      => true
        ],
        'callbackURL' => [
            'label'         => __('Callback URL'),
            'type'          => 'url',
            'required'      => true
        ],
        'instruction' => [
            'label'         => __('Instruction'),
            'type'          => 'textarea',
        ],
        'sandbox' => [
            'label'         => __('Sandbox'),
            'type'          => 'select',
            'required'      => true,
            'options' => [
                'Enabled'   => 1,
                'Disabled'  =>  0
            ]
        ],
        'status' => [
            'label'         => __('Status'),
            'type'          => 'select',
            'required'      => true,
            'options' => [
                'Active'    => 1,
                'Inactive'  =>  0
            ]
        ]
    ],

    'store_route' => 'paytr.store',
    'iFrameResizeJS' => 'https://www.paytr.com/js/iframeResizer.min.js',
    'supportCurrencies' => ['TL', 'EUR', 'USD', 'GBP', 'RUB', 'TRY'],

];