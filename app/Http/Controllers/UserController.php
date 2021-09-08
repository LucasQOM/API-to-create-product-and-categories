<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(UserRegisterRequest $request)
    {
        try {

            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
            $user = User::create($input);
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['name'] =  $user->name;

        }catch (\Exception $e){
            if (env('APP_DEBUG')){
                throw new HttpResponseException(response()->json(['status' => 500, 'data' => $e->getMessage()]));
            } else
                throw new HttpResponseException(response()->json(['status' => 500, 'data' => 'Ocorreu um erro ao se cadastrar']));
        }

        return response()->json(['status' => 201, 'data' => $success, 'message' => 'Cadastrado com sucesso!']);
    }

    public function login(UserLoginRequest $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            $success['name'] =  $user->name;

            return response()->json(['status' => 200, 'data' => $success, 'message' => 'Logado com sucesso!']);
        }
        else{
            return response()->json(['status' => 404, 'data' => 'Ocorreu um erro!']);
        }
    }
}
