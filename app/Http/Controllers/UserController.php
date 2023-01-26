<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function store(UserStoreRequest $request)
    {
        $request->merge(['password' => Hash::make($request->input('password'))]);

        $user = User::create($request->all());

        return response()->json($user, Response::HTTP_CREATED);
    }
    public function prueba() {
        return ["prueba" => true];
    }
}
