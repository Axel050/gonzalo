<?php



namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

  public function logout(Request $request)
  {
    $user = $request->user();

    if (!$user || !$user->currentAccessToken()) {
      return response()->json([
        'message' => 'Unauthenticated'
      ], 401);
    }

    info('LOGOUT HIT', [
      'user_id' => $user->id,
      'token_id' => $user->currentAccessToken()->id,
    ]);

    $user->currentAccessToken()->delete();

    return response()->json([
      'message' => 'Logout exitoso'
    ]);
  }


  public function login(Request $request)
  {

    $request->validate([
      'email' => 'required|email',
      'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
      return response()->json([
        'message' => 'Credenciales inválidas'
      ], 401);
    }

    // borrar tokens viejos (opcional)
    $user->tokens()->delete();

    $token = $user->createToken('mobile-app')->plainTextToken;

    return response()->json([
      'token' => $token,
      'user' => [
        'id' => $user->id,
        'email' => $user->email,
        'rol' => $user->roles->pluck('name'),
      ]
    ]);
  }
}
