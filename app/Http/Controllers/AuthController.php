<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Mail; 
use Illuminate\Support\Facades\Auth; 
use App\Models\User; 
use Validator; 
use JWTAuth; 
class AuthController extends Controller
{
/** 
     * Get a JWT via given credentials. 
     * 
     * @return \Illuminate\Http\JsonResponse 
     */ 
    public function login(Request $request){ 
         
{
    // Validation des données envoyées
    $request->validate([
        'email' => 'required|string|email|max:100',
        'password' => 'required|string|min:6',
    ]);

    // Tentative de connexion avec les informations fournies
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        // Si l'utilisateur est authentifié, retourner une réponse avec les informations de l'utilisateur
        $user = Auth::user();
        return response()->json([
            'message' => 'Login successful.',
            'user' => $user
        ], 200);
    }

    // Si les informations sont incorrectes, retourner une erreur
    return response()->json([
        'message' => 'Invalid credentials.',
    ], 401); // Code HTTP 401 : Unauthorized
}
         
    } 
 
        /** 
     * Register a User. 
     * 
     * @return \Illuminate\Http\JsonResponse 
     */ 
 
     public function register(Request $request)
     {
         // Validation des données envoyées
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|between:2,100', 
        'email' => 'required|string|email|max:100|unique:users,email', // Ajouter le champ email spécifiquement
        'password' => 'required|string|min:6', // Minimum 6 caractères pour plus de sécurité
        'role' => 'required|string|in:admin,user',  // Role doit être admin ou user
    ]);

    // Si la validation échoue, renvoyer un message d'erreur
    if ($validator->fails()) {
        return response()->json($validator->errors()->toJson(), 400); 
    }

    // Création de l'utilisateur avec mot de passe crypté
    $user = User::create(array_merge(
        $validator->validated(),
        ['password' => bcrypt($request->password)]
    ));

    // Envoi de l'email de vérification (à compléter avec une fonction réelle)
    // Mail::to($user->email)->send(new VerificationEmail($user));

    // Réponse de succès avec message
    return response()->json([
        'message' => 'User successfully registered. Please verify your email.',
        'user' => $user
    ], 201);
}

     
 
   
 
    
     
    /** 
     * Log the user out (Invalidate the token). 
     * 
     * @return \Illuminate\Http\JsonResponse 
     */ 
    public function logout() { 
        $this->guard()->logout(); 
        return response()->json([ 
            'status' => 'success', 
            'msg' => 'Logged out Successfully.' 
        ], 200); 
    } 
 
    /** 
    * Return auth guard 
    */ 
    private function guard() 
    { 
        return Auth::guard(); 
    } 
 
    /** 
     * Refresh a token. 
     * 
     * @return \Illuminate\Http\JsonResponse 
     */ 
    public function refresh() { 
return $this->createNewToken(auth('api')->refresh()); 
    } 
 
    /** 
     * Get the authenticated User. 
     * 
     * @return \Illuminate\Http\JsonResponse 
     */ 
    public function userProfile() { 
         return response()->json(auth('api')->user()); 
 
    } 
 
/** 
* Get the token array structure. 
* 
* @param  string $token 
* 
* @return \Illuminate\Http\JsonResponse 
*/ 
protected function createNewToken($token){ 
return response()->json([ 
'access_token' => $token, 
'token_type' => 'bearer', 
'expires_in' => auth('api')->factory()->getTTL() * 60, 
'user' => auth()->user() 
]); 
} 
}
