<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends ApiController
{
    public function generateToken(User $user, $msg = "Utilisateur connecté avec success")
    {
        $success["token"] = $user->createToken("LaravelSanctumAuth")->plainTextToken;
        $success["name"] = $user->name;

        // echo response()->json($success);
        return $this->handleResponse($success, $msg);
    }

    public function login(Request $request)
    {
        if (Auth::attempt([
            "email" => $request->email,
            "password" => $request->password,
        ])) {
            //$this->generateToken(Auth::user());

            $user = Auth::user();
            $success["token"] = $user->createToken("LaravelSanctumAuth")->plainTextToken;
            $success["name"] = $user->name;
            return $this->handleResponse($success, "Utilisateur connecté avec success");

        } else {
            return $this->handleError("Non Autorisé. Attention!", ['error' => "Mauvais identifants"]);
        }
    }

    public function register(Request $request)
    {
        // validate data
        $validate_data = Validator::make($request->all(), [
            "name" => 'required',
            "email" => 'required|email',
            "password" => 'required',
            "confirm_password" => 'required|same:password',
        ]);

        if($validate_data->fails()){
            return $this->handleError($validate_data->errors());
        }

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password),
        ]);

        // $this->generateToken(Auth::user(), "Votre compte a été créé avec success");

        $user = Auth::user();
        $success["token"] = $user->createToken("LaravelSanctumAuth")->plainTextToken;
        $success["name"] = $user->name;
        return $this->handleResponse($success, "Votre compte a été créé avec success");
    }
}
