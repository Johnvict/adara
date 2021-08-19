<?php

namespace App\Http\Controllers;

use App\Models\LocalGovt;
use App\Models\State;
use App\Traits\ResponseFormats;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use ResponseFormats;

    protected function respondWithToken($token, $data)
    {
        $data['token'] = $token;
        $data['token_type'] = 'bearer';
        $data['expires_in'] = Auth::factory()->getTTL() * 60;
        return $data;
    }

    public function states()
    {
        $states = State::all();
        return self::returnSuccess($states);
    }

    public function local_govt()
    {
        $states = LocalGovt::all();
        return self::returnSuccess($states);
    }
}
