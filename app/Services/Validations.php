<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait Validations
{
    private static $errorArray;

    public static $CreateBeneficiaryValidation = [
        [
            "name"          => "required|string",
            'gender'        => "required|string",
            'email'         => "required|string",
            'phone_number'  => "required|string",
            'date_of_birth' => "required|string",
            'profile_pic'   => "required|string",
            'onboarding_date'   => "required|string",
            'home_address'      => "required",
            "business_address"  => "required"
        ],
        [
            "name.required"             => "Beneficiary name is required",
            'gender.required'           => "Let's know the beneficiary's gender",
            'phone_number.required'     => "The gender field for beneficiary is required",
            'date_of_birth.required'    => "Please provide date of birth for beneficiary",
            'home_address.required'     => "Home address of beneficiary is required",
            "business_address.required" => "Business address of beneficiary is required"
        ]
    ];
    public static $CreateGuarantorValidation = [
        [
            "name"              => "required|string",
            'gender'            => "required|string",
            'phone_number'      => "required|string",
            'beneficiary_id'    => "required|string",
            'home_address'      => "required|string",
            "business_address"  => "required|string"
        ],
        [
            "name.required"             => "Guarantors name is required",
            'gender.required'           => "Let's know your guarantor gender",
            'phone_number.required'     => "The gender field for guarantor is required",
            'beneficiary_id.required'   => "For which beneficiary, please provide beneficiary id",
            'home_address.required'     => "Home address of guarantor is required",
            'id_means.required'         => "Means of identification for guarantor is required",
            "business_address.required" => "Business address of guarantor is required"
        ]
    ];
    public static $AddressValidationRule = [
        [
            "address"       => "required|string",
            "local_govt"    => "required|string",
        ]
    ];

    public static $PaymentHistoryValidationRule = [
        [
            "beneficiary_id"       => "string",
            "order_id"         => "string",
        ]
    ];
    public static $OrderHistoryValidationRule = [
        [
            "beneficiary_id"       => "string",
        ]
    ];


    /**
     * Error message method
     * @param Mixed $errorArray
     * @return Mixed or null
     */
    public static function formatError($errorArray)
    {
        Validations::$errorArray = collect($errorArray);
        return Validations::$errorArray->map(function ($error) {
            return $error[0];
        });
    }


    /**
     * Validation of parameters for requests
     *
     * @param Request $request: The request body as sent recieved the client
     * @return Mixed or null
     */
    public static function validateRequest(Request $request, array $validationRule)
    {
        $validation = Validator::make($request->all(), $validationRule[0], $validationRule[1] ?? []);

        if ($validation->fails()) return Validations::formatError($validation->errors());
        return false;
    }

    public static function validateArrayParams(array $request, array $validationRule)
    {
        $validation = Validator::make($request, $validationRule[0], $validationRule[1] ?? []);

        if ($validation->fails()) return Validations::formatError($validation->errors());
        return false;
    }
}
