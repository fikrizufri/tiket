<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function payload()
    {
        return response()->json(auth()->payload());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
        ]);
        if ($validator->fails()) {
            $response = ['message' => $validator->errors()->all()];
            return response($response, 422);
        }

        $nama = $request->nama;
        $email    = $request->email;
        $password = $request->password;
        $hp = $request->hp;

        $customerRole = Role::where('slug', 'customer')->first();

        try {
            $customerUser = new User();
            $customerUser->nama = $nama;
            $customerUser->username = $nama;
            $customerUser->slug = Str::slug($nama);
            $customerUser->email = $email;
            $customerUser->password = bcrypt($password);
            $customerUser->hp = $hp;
            // $customerUser->icon = 'default-icon.png';
            $customerUser->save();

            $customerUser->role()->attach($customerRole);

            $response = ['message' => 'You have been successfully logged out!'];
            return response($response, 200);
        } catch (\Throwable $th) {
            $response = ['message' => 'something error'];
            return response($response, 422);
        }
    }
}
