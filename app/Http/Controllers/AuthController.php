<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //Membuat fitur Register
    public function register(Request $request)
    {
        //menangkap inputan
        $input = [
            'name' => $request->name,
            'email' => $request->email,
            'password' =>Hash::make($request->password)
        ];

        //Menginsert data table user
        $user = User::create($input);
        $data = [
            'message' => 'user is created successfully'
        ];
        //Mengirim response JSON
        return response()->json($data, 200);
    }

    //Membuat  fitur login
    public function login(Request $request)
    {
        $input = [
            'email' => $request->email,
            'password' => $request->password
        ];
        //Mengambil datauser (DB)
        $user = User::where('email', $input['email'])->first();

        //Membandingkan input user dengan data user (DB)
        $isloginSuccessfully = (
            $input['email'] == $user->email
            &&
            Hash::check($input['password'], $user->password)
        );

        if ($isloginSuccessfully) {
            $token = $user->createToken('auth_token');

            $data = [
                'message' => 'Login succesfully',
                'token' => $token->plainTextToken
            ];

            //Mengembalikan response JSON
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Username or Password is wrong'
            ];
            return response()->json($data, 401);
        }
    }
}


