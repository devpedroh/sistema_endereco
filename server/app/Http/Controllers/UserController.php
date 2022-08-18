<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Repositories\Contracts\UserRepositoryInterface;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller {

    public function index (UserRepositoryInterface $user, Request $req) {
        $userData = $req->user();

        if (intval($user->get($userData->id, 'permission')) === 1) {
            return response()->json($user->findAll(), 200);
        }

        return response()->json(['message' => 'Você não tem permissão para realizar esta ação'], 401);
    }

    public function store (UserRepositoryInterface $user, UserCreateRequest $req) {
        $userData = $req->user();

        if (intval($user->get($userData->id, 'permission')) === 1) {
            $input = $req->validated();
            $data = [
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => bcrypt($input['password'])
            ];
            return response()->json($user->create($data), 200);
        }

        return response()->json(['message' => 'Você não tem permissão para realizar esta ação'], 401);
    }

    public function show (UserRepositoryInterface $user, Request $req, $id) {
        $userData = $req->user();

        if (intval($user->get($userData->id, 'permission')) === 1) {
            if (!$id) {
                return response()->json(['message' => 'Usuário informado não é válido'], 403);
            }

            return response()->json($user->find($id), 200);
        }

        return response()->json(['message' => 'Você não tem permissão para realizar esta ação'], 401);
    }

    public function edit (UserRepositoryInterface $user, Request $req, $id) {
        $userData = $req->user();

        if (intval($user->get($userData->id, 'permission')) === 1) {
            return response()->json($user->find($id), 200);
        }

        return response()->json(['message' => 'Você não tem permissão para realizar esta ação'], 401);
    }

    public function update (UserRepositoryInterface $user, UserUpdateRequest $req, $id) {
        $userData = $req->user();

        if (intval($user->get($userData->id, 'permission')) === 1) {
            $input = $req->validated();
            if (isset($input['password'])) {
                $data = [
                    'name' => $input['name'],
                    'email' => $input['email'],
                    'password' => bcrypt($input['password']),
                    'permission' => $input['permission']
                ];
            } else {
                $data = [
                    'name' => $input['name'],
                    'email' => $input['email'],
                    'permission' => $input['permission']
                ];
            }
            return response()->json($user->update($data, $id), 200);
        }

        return response()->json(['message' => 'Você não tem permissão para realizar esta ação'], 401);
    }

    public function destroy (UserRepositoryInterface $user, Request $req, $id) {
        $userData = $req->user();

        if (intval($user->get($userData->id, 'permission')) === 1) {
            return response()->json($user->delete($id), 200);
        }

        return response()->json(['message' => 'Você não tem permissão para realizar esta ação'], 401);
    }

    public function login (UserRepositoryInterface $user, LoginRequest $req) {
        $input = $req->validated();

        $userData = $user->where(['email' => $input['email']]);
        if (!$userData) {
            return response()->json(['message' => 'Usuário não encontrado'], 401);
        }

        if (!password_verify($input['password'], $userData->password)) {
            return response()->json(['message' => 'Usuário ou senha inválida'], 401);
        }

        $userData->token = $userData->createToken($userData->id)->accessToken;
        return response()->json($userData, 200);
    }

    public function register (UserRepositoryInterface $user, UserCreateRequest $req) {
        $input = $req->validated();

        $data = [
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => bcrypt($input['password'])
        ];
        $userData = $user->create($data);

        $userData->token = $userData->createToken($userData->id)->accessToken;
        return response()->json($userData, 200);
    }

    public function get (Request $req) {
        $user = $req->user();
        $user->token = $user->token();
        return response()->json($req->user(), 200);
    }

    public function logout (Request $req) {
        $token = $req->user()->token();
        $token->revoke();
        return response()->json('Deslogado com sucesso', 200);
    }

}
