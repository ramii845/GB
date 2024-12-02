<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
{
$request->validate([
'name' => 'required',
'email' => 'required|email|unique:users,email',
'password' => 'required|min:4',
'role' => 'required'
]);
$user = User::create([
'name' => $request->name,
'email' => $request->email,
'role' => $request->role,
'password' => Hash::make($request->password),
]);
$token = $user->createToken('token-name')->plainTextToken;
return response()->json([
'status' => true,
'message' => 'User Created Successfully',
'token' => $token
], 200);
}
}