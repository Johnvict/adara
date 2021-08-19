<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Beneficiary;
use App\Models\User;
use App\Traits\ResponseFormats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    use ResponseFormats;

    public function loginAdmin(Request $request)
    {
        $this->validate($request, [
            'email_phone'   => 'required|string',
            'password'      => 'required|string',
        ]);

        try {
            $login_type = filter_var($request->email_phone, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone_number';
            $credentials = [$login_type => $request->email_phone, 'password' => $request->password];

            $token = Auth::attempt($credentials);
            if (!$token) return self::returnUnauthorized("invalid credentials");


            $user = Auth::user();
            $data = $this->respondWithToken($token, $user);

            return self::returnSuccess($data);
        } catch (JWTException $e) {
            return self::returnFailed($e->getMessage());
        }
    }


    public function changePassword(Request $request)
    {
        $user = auth()->user();
        if (!$user) return self::returnUnauthorized("invalid user");

        $validator = Validator::make($request->all(), [
            "old_password"  => "required",
            "password"      => "required|confirmed"
        ]);

        if ($validator->fails()) return self::returnFailed($validator->errors()->first());

        if ($request->old_password == $request->password) return self::returnFailed("can't use the same password");

        if (!Hash::check($request->old_password, $user->password)) return self::returnFailed("Invalid password");

        $user->password = Hash::make($request->password);
        $user->save();

        return self::returnSuccess("password updated successfully");
    }


    public function createAdmin(Request $request)
    {
        $validator = Validator::make($request->all(),  [
            "name"      => "required|string",
            "gender"    => "required|string",
            "email"     => "required|string",
            "phone_number" => "required|string",
            "password"  => "required|string",
        ]);

        if ($validator->fails()) return self::returnFailed($validator->errors()->first());

        $super = Auth::user();

        if ($super->role != "superadmin") return self::returnFailed("you're not authorized to perform this action");

        $request->merge(['password' => Hash::make($request->password)]);

        $admin = User::create([
            "name"      => $request->name,
            "gender"    => $request->gender,
            "email"     => $request->email,
            "phone_number" => $request->phone_number,
            "password"  => $request->password,
        ]);

        return self::returnCreatedSuccessfully($admin);
    }

    public function viewAdmins()
    {
        $super = Auth::user();
        if ($super->role != "superadmin") return self::returnFailed("you're not authorized to perform this action");

        $admins = User::where('role', 'admin')->get();

        return self::returnSuccess($admins);
    }

    public function viewAdmin($id)
    {
        $super = Auth::user();
        if ($super->role != "superadmin") return self::returnFailed("you're not authorized to perform this action");

        $admin = User::where(['id' => $id, "role" => "admin"])->first();

        if (!$admin) return self::returnNotFound();
        return self::returnSuccess($admin);
    }

    public function updateAdmin(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "name"      => "string",
            "gender"    => "string",
            "email"     => "string",
            "phone_number"  => "string",
        ]);

        if ($validator->fails()) return self::returnFailed($validator->errors()->first());

        $super = Auth::user();
        if ($super->role != "superadmin") return self::returnFailed("you're not authorized to perform this action");

        $admin = User::where('id', $id)->first();

        $update = $admin::update($request->all());

        return self::returnSuccess($update);
    }
}
