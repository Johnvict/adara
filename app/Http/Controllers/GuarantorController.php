<?php

namespace App\Http\Controllers;

use App\Models\BeneficiaryAddress;
use App\Models\Beneficiary;
use App\Models\Guarantor;
use App\Models\Guarantors;
use App\Models\GuarantorsAddress;
use App\Services\Utility;
use App\Traits\ResponseFormats;
use App\Services\Validations;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class GuarantorController extends Controller
{
    use ResponseFormats, Validations, Utility;

    public function createGuarantor(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "name"          => "required|string",
            "phone_number"  => "required|regex:/(0)[0-9]/|not_regex:/[a-z]/|distinct|min:11",
            "home_address"  => "required|string",
            "work_address"  => "required|string",
            "occupation"    => "required|string",
            "file"          => "required|string",
        ]);

        if ($validator->fails()) return self::returnFailed($validator->errors()->first());

        $super = Auth::user();
        if ($super->role != "superadmin") return self::returnFailed("you're not authorized to perform this action");

        $beneficiary = Beneficiary::find($id);

        DB::beginTransaction();

        try {
            $image = self::upload($request->file);

            if ($image["status"] == "02") return self::returnFailed("File type not allowed. Only png, jpg, pdf, jpeg required");
            if ($image["status"] == "00") $file = $image["fileName"];

            $guarantor = $beneficiary->guarantors()->updateOrCreate([
                "name"          => $request->name,
                "phone_number"  => $request->phone_number,
                "home_address"  => $request->home_address,
                "work_address"  => $request->work_address,
                "occupation"    => $request->occupation,
                "file"          => $file
            ]);

            DB::commit();
            return self::returnCreatedSuccessfully($guarantor);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error("Error creating guarantor: " . $exception->getMessage());
            return self::returnSystemFailure("Could not create guarantor: Server Error");
        }
    }

    public function updateBeneficiary(Request $request, $id)
    {
        $request->validate([
            "name"          => "required|string",
            "phone_number"  => "required|regex:/(0)[0-9]/|not_regex:/[a-z]/|distinct|min:11",
            "home_address"  => "required|string",
            "work_address"  => "required|string",
            "occupation"    => "required|string",
            "file"          => "required|string",
        ]);

        $super = Auth::user();
        if ($super->role != "superadmin") return self::returnFailed("you're not authorized to perform this action");

        $beneficiary = Beneficiary::find($id);

        DB::beginTransaction();

        try {
            if ($request->has('file')) {
                $image = self::upload($request->file);

                if ($image["status"] == "02") return self::returnFailed("File type not allowed. Only png, jpg, pdf, jpeg required");
                if ($image["status"] == "00") $file = $image["fileName"];
            }

            $guarantor = $beneficiary->guarantors()->update([
                "name"          => $request->name,
                "phone_number"  => $request->phone_number,
                "home_address"  => $request->home_address,
                "work_address"  => $request->work_address,
                "occupation"    => $request->occupation,
                "file"          => $file
            ]);

            DB::commit();
            return self::returnCreatedSuccessfully($guarantor);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error("Error updating guarantor: " . $exception->getMessage());
            return self::returnSystemFailure("Could not create guarantor: Server Error");
        }
    }
}
