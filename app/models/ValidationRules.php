<?php

namespace app\models;

class ValidationRules
{

    protected static $rules = [

        'admin' => [

            'admin_name' => [
                'required',
                'max_length:70',
                'chars'
            ],

            'admin_phone' => [
                'phone'
            ],

            'admin_email' => [
                'email',
                'chars'
            ],

            'admin_tech_name' => [
                'max_length:70',
                'chars'
            ],

            'admin_tech_phone' => [
                'phone'
            ],

            'admin_tech_email' => [
                'email',
                'chars'
            ],

            'admin_acc_name' => [
                'max_length:70',
                'chars'
            ],

            'admin_acc_phone' => [
                'phone'
            ],

            'admin_acc_email' => [
                'email',
                'chars'
            ]

        ],

        'landlord' => [

            'landlord_name' => [
                'required',
                'max_length:70',
                'chars'
            ],

            'landlord_address' => [
                'required',
                'max_length:70',
                'chars'
            ],

            'landlord_email' => [
                'email',
                'chars'
            ],

            'landlord_phone_number' => [
                'phone'
            ],

            'landlord_account' => [

            ]


        ],

        'tenant' => [

            'tenant_name' => [
                'required',
                'max_length:70',
                'chars'
            ],

            'tenant_address' => [
                'required',
                'max_length:70',
                'chars'
            ],

            'tenant_email' => [
                'email',
                'chars'
            ],

            'tenant_phone_number' => [
                'phone'
            ],

            'tenant_account' => [

            ]



        ],

        'calculation' => [

            'calculation_name' => [
                'required',
                'max_length:70',
                'chars',
                'calc_exists'// make only for specific user
            ],

            'calculation_description' => [
                'max_length:250',
                'chars'
            ],



        ],

        'elsupplier' => [

            'elsupplier_name' => [
                'required',
                'max_length:70',
                'chars',

            ],

            'elsupplier_add_info' => [
                'max_length:200',
                'chars'

            ]


        ],

        'property' => [

            'property_address' => [
                'required',
                'max_length:150',
                'chars',
            ],

            'property_type' => [
                'required',
                'max_length:100',
                'chars'
            ]



        ],


        'modal-login' => [

            'userEmail' => [
                'required',
                'email',
                'max_length:80',
                'chars',
            ],

            'userPassword' => [
                'required',

            ]


        ],

        'settings' => [

            'user_name' => [
                'required',
                'max_length:20',
                'chars',
            ]

        ],

        'change-password' => [

            'password' => [
                'required'
            ],

            'new_password' => [
                'required'
            ],

            'new_password_repeat' => [
                'required'
            ]


        ]

    ];


    /**
     * Returns validation rules for specific form name
     *
     * @param string $formName
     * @return array|false|mixed
     */
    public static function getValidationRules(string $formName){

        if (isset(self::$rules[$formName])){

            return self::$rules[$formName];

        }

        return false;
    }








}