<?php

return [
    'name' => 'YooKassa',

    'alias' => 'yookassa',

    'logo' => 'Modules/YooKassa/Resources/assets/yookassa.png',

    // YooKassa addon settings

    'options' => [
        ['label' => __('Settings'), 'type' => 'modal', 'url' => 'yookassa.edit'],
        ['label' => __('YooKassa Documentation'), 'target' => '_blank', 'url' => 'https://yookassa.ru/']
    ],

    /**
     * Yookassa data validation
     */
    'validation' => [
        'rules' => [
            'name' => 'required',
            'storeId' => 'required',
            'secretKey' => 'required',
            'sandbox' => 'required',
        ],
        'attributes' => [
            'name'          => __('Display Name'),
            'storeId' => __('Store Id'),
            'secretKey' => __('Secret Key'),
            'sandbox' => __('Please specify sandbox enabled/disabled.')
        ]
    ],
    'fields' => [
        'name' => [
            'label'         => __('Display Name'),
            'type'          => 'text',
            'required'      => true
        ],
        'storeId' => [
            'label' => __('Store Id'),
            'type' => 'text',
            'required' => true
        ],
        'secretKey' => [
            'label' => __('Secret Key'),
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
            'label' => __('Status'),
            'type' => 'select',
            'required' => true,
            'options' => [
                'Active' => 1,
                'Inactive' =>  0
            ]
        ]
    ],

    'store_route' => 'yookassa.store',

];
