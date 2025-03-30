<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Jobs\RecoveryPasswordEmail;
use App\Models\User;
use App\Repositories\UserRepository\UserRepository;
use App\Services\UserService\UserService;

class AuthController extends Controller
{

    public $userService;

    public function __construct()
    {
        $this->userService  = new UserService(new UserRepository(new User()));
    }

    public function register(Request $request)
    {
        $rules = [
            'name'          => 'required',
            'email'         => 'required|unique:users|email',
            'password'      => 'required',
        ];

        $input     = $request->all();
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'error' => $validator->messages()
                ],
                404
            );
        }

        $email    = $request->email;
        $password = $request->password;
        $name     = $request->name;

        $userData = [
            'name'              => $name,
            'email'             => $email,
            'password'          => Hash::make($password),
        ];

        $user = $this->userService->create($userData);

        Auth::login($user);

        $token          = Auth::user()->createToken('APIToken');

        $explodeToken  = explode("|", $token->plainTextToken);

        $bearerToken   = $explodeToken[1];

        $user->update(['api_token' => $bearerToken]);

        return response()->json(
            [
                'success' =>  true,
                "token"   =>  $bearerToken,
                "name" => $user->name,
            ],
            200
        );
    }



    public function login(Request $request)
    {
        $request->validate([
            'email'         => 'required',
            'password'      => 'required',
        ]);

        $email = $request->email;
        $password = $request->password;

        $user = $this->userService->getUserByEmail($email);

        if (!$user) {
            return response()->json(['success' => false, 'error' => 'E-mail inexistente em nossa base de dados.'], 404);
        }

        $credentials = [
            'email'      => $email,
            'password'   => $password

        ];

        if (!Auth::attempt($credentials)) {
            return response()->json(['success' => false, 'error' => "E-mail ou senha inválidos!"], 404);
        }

        $user = Auth::user();

        $token          = Auth::user()->createToken('APIToken');
        $explodeToken  = explode("|", $token->plainTextToken);
        $bearerToken   = $explodeToken[1];

        $this->userService->update($user->id, ['api_token' => $bearerToken]);

        return response()->json(
            [
                'success' => true,
                "id" => $user->id,
                "token" => $user->api_token,
                "name" => $user->name,
            ],
            200
        );
    }



    public function recoveryPassword(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->email;

        $user = $this->userService->getUserByEmail($email);

        if (empty($user)) {
            return response()->json(['success' => false, 'error' => 'E-mail inexistente em nossa base de dados.']);
        }

        $pin = rand(111111, 999999);

        $newPassword =  Hash::make($pin);

        $this->userService->update($user->id, ['password' => $newPassword]);

        RecoveryPasswordEmail::dispatch($email, $pin);

        return response()->json([
            'success' => true,
            "message" => 'Senha atualizada com sucesso, configura o seu e-mail para mais informações.'
        ], 200);
    }
}
