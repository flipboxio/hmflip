<?php


return [
    'name' => 'DirectBankTransfer',
    'alias' => 'directbanktransfer',
    'logo' => 'Modules/DirectBankTransfer/Resources/assets/thumbnail.png',
    'options' => [
        ['label' => __('Settings'), 'type' => 'modal', 'url' => 'bank.edit'],
    ],

   /**
     * Direct Bank Transfer data validation
     */
    'validation' => [
        'rules' => [
            'name'              => 'required',
            'account_name'      => 'required',
            'iban'              => 'required',
            'bank_name'         => 'required',
            'country'           => 'required',
            'status'            => 'required'
           
        ],
        'attributes' => [
            'name'              => __('Name'),
            'account_name'      => __('Account Name'),
            'iban'              => __('Account Number'),
            'bank_name'         => __('Bank Name'),
            'country'           => __('Country'),
            'status'            => __('Status')
        ]
    ],
    'fields' => [
        'name' => [
            'label' => __('Display Name'),
            'type' => 'text',
            'required' => true
        ],
        'account_name' => [
            'label' => __('Account Name'),
            'type' => 'text',
            'required' => true
        ],
        'iban' => [
            'label' => __('Account Number'),
            'type' => 'text',
            'required' => true
        ],
        'swift_code' => [
            'label' => __('Swift Code'),
            'type' => 'text',
        ],
        'routing_no' => [
            'label' => __('Routing Number'),
            'type' => 'text',
        ],
        'bank_name' => [
            'label' => __('Bank Name'),
            'type' => 'text',
            'required' => true
        ],
        'branch_name' => [
            'label' => __('Branch Name'),
            'type' => 'text',
        ],
        'branch_city' => [
            'label' => __('City of the branch'),
            'type' => 'text',
        ],
        'branch_address' => [
            'label' => __('Branch Address'),
            'type' => 'text',
        ],
        'country' => [
            'label' => __('Country'),
            'type' => 'text',
            'required' => true, 
        ],
        'logo' => [
            'label' => __('Bank Logo'),
            'type' => 'file',
        ],
        'instruction' => [
            'label' => __('Instruction'),
            'type' => 'textarea',
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

    'store_route' => 'bank.store',
];
