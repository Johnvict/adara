<?php

namespace App\Http\Controllers;

use App\Models\BeneficiaryAddress;
use App\Models\Beneficiary;
use App\Models\Guarantors;
use App\Models\GuarantorsAddress;
use App\Models\User;
use App\Services\Utility;
use App\Traits\ResponseFormats;
use App\Services\Validations;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BeneficiaryController extends Controller
{
    use ResponseFormats, Validations, Utility;

    public function createBeneficiary(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name"          => "required|string",
            "gender"        => "required|string",
            "email"         => "required|string",
            "phone_number"  => "required|regex:/(0)[0-9]/|not_regex:/[a-z]/|distinct|min:11",
            "dob"           => "required|string",
            "onboarding_date"   => "required|string",
            "profile_pic"       => "required|string",

            'home_address'  => 'required|array|min:1',
            "home_address.address"    => "required|string",
            "home_address.local_govt_id" => "required|integer",
            "home_address.state_id" => "required|integer",

            "business_address"  => 'required|array|min:1',
            "business_address.address"       => "required|string",
            "business_address.local_govt_id"    => "required|integer",
            "business_address.state_id"    => "required|integer"
        ]);

        if ($validator->fails()) return self::returnFailed($validator->errors()->first());

        DB::beginTransaction();

        try {
            $image = self::upload($request->profile_pic);

            if ($image["status"] == "02") return self::returnFailed("File type not allowed. Only png, jpg, pdf, jpeg required");
            if ($image["status"] == "00") $profile_pic = $image["fileName"];

            $beneficiary = Beneficiary::create([
                "name"      => $request->name,
                "gender"    => $request->gender,
                "email"     => $request->email,
                "phone_number"  => $request->phone_number,
                "dob"           => $request->dob,
                "onboarding_date"   => $request->onboarding_date,
                "profile_pic"   => $profile_pic
            ]);

            $home = $beneficiary->addresses()->create([
                "address"       => $request->home_address['address'],
                "local_govt_id" => $request->home_address['local_govt_id'],
                "state_id"      => $request->home_address['state_id'],
                "type"          => "home",
            ]);

            $business = $beneficiary->addresses()->create([
                "address"       => $request->business_address['address'],
                "local_govt_id" => $request->business_address['local_govt_id'],
                "state_id"      => $request->business_address['state_id'],
                "type"          => "business"
            ]);

            DB::commit();
            return self::returnCreatedSuccessfully(['beneficiary' => $beneficiary, 'home_address' => $home, 'business_address' => $business]);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error("Error creating beneficiary: " . $exception->getMessage());
            return self::returnSystemFailure("Could not create beneficiary: Server Error");
        }
    }


    public function viewBeneficiaries()
    {
        $user = Auth::user();
        if (!$user) return self::returnunauthorized("opps! you're not authorized to perform this action");

        $ben = Beneficiary::all();

        return self::returnSuccess($ben);
    }


    public function singleBeneficiary($id)
    {
        $user = Auth::user();
        if (!$user) return self::returnunauthorized("opps! you're not authorized to perform this action");

        $response = Beneficiary::with('guarantors')
            ->where('id', $id)
            ->first();

        if (!$response) return self::returnNotFound();
        return self::returnSuccess($response);
    }


    public function deactivateBeneficiary(Request $request)
    {
        return self::changeUserActiveStatus($request, 1);
    }

    public function activateBeneficiary(Request $request)
    {
        return self::changeUserActiveStatus($request, 0, "admin");
    }

    private static function changeUserActiveStatus(Request $request, $status, $role = "user")
    {
        $validator = Validator::make($request->all(), [
            'phone'        => 'required|numeric|digits:11',
            'id'        => 'required|numeric|min:1'
        ]);

        if ($validator->fails()) return self::returnFailed($validator->errors()->first());

        $beneficiary = Beneficiary::find($request->id);

        if ($beneficiary) {
            if ($beneficiary->phone == $request->phone) {
                $beneficiary->update([
                    "is_active"     => $status,
                    "is_suspended"  => !$status
                ]);
                return self::returnSuccess();
            }
        }

        return self::returnNotFound("no found with this credential");
    }
}
