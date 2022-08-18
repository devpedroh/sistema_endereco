<?php

namespace App\Http\Controllers;

use App\Http\Requests\CepCreateRequest;
use App\Http\Requests\CepUpdateRequest;
use App\Repositories\Contracts\CepRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Canducci\Cep\Cep as CepExternal;
use Canducci\Cep\Endereco as EnderecoExternal;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CepController extends Controller {

    public function index (UserRepositoryInterface $user, CepRepositoryInterface $cepLocal, Request $req) {
        $userData = $req->user();

        if (intval($user->get($userData->id, 'permission')) === 1) {
            return response()->json($cepLocal->findAll(), 200);
        }

        return response()->json(['message' => 'Você não tem permissão para realizar esta ação'], 401);
    }

    public function store (UserRepositoryInterface $user, CepRepositoryInterface $cepLocal, CepCreateRequest $req) {
        $userData = $req->user();

        if (intval($user->get($userData->id, 'permission')) === 1) {
            $input = $req->validated();
            return response()->json($cepLocal->create($input), 200);
        }

        return response()->json(['message' => 'Você não tem permissão para realizar esta ação'], 401);
    }

    public function showCep (CepRepositoryInterface $cepLocal, CepExternal $cepExternal, $cep) {
        if (!$cep) {
            return response()->json(['message' => 'CEP informado não é válido'], 403);
        }

        $data = $cepLocal->where(['numero' => $cep]);
        if (!$data) {
            $data = $cepExternal->find($cep)->getCepModel();
        }

        return response()->json($data, 200);
    }

    public function showEndereco (EnderecoExternal $enderecoExternal, $endereco) {
        if (!$endereco) {
            return response()->json(['message' => 'Endereço informado não é válido'], 403);
        }

        $search = explode(',', $endereco);
        $data = $enderecoExternal->find($search[2], $search[1], $search[0])->getCepModels();

        return response()->json($data, 200);
    }

    public function edit (UserRepositoryInterface $user, CepRepositoryInterface $cepLocal, Request $req, $id) {
        $userData = $req->user();

        if (intval($user->get($userData->id, 'permission')) === 1) {
            return response()->json($cepLocal->find($id), 200);
        }

        return response()->json(['message' => 'Você não tem permissão para realizar esta ação'], 401);
    }

    public function update (UserRepositoryInterface $user, CepRepositoryInterface $cepLocal, CepUpdateRequest $req, $id) {
        $userData = $req->user();

        if (intval($user->get($userData->id, 'permission')) === 1) {
            $input = $req->validated();
            $data = [
                'logradouro' => (array_key_exists('logradouro', $input) ? $input['logradouro'] : ''),
                'complemento' => (array_key_exists('complemento', $input) ? $input['complemento'] : ''),
                'bairro' => (array_key_exists('bairro', $input) ? $input['bairro'] : ''),
                'localidade' => $input['localidade'],
                'uf' => $input['uf'],
                'ddd' => $input['ddd']
            ];
            return response()->json($cepLocal->update($data, $id), 200);
        }

        return response()->json(['message' => 'Você não tem permissão para realizar esta ação'], 401);
    }

    public function destroy (UserRepositoryInterface $user, CepRepositoryInterface $cepLocal, Request $req, $id) {
        $userData = $req->user();

        if (intval($user->get($userData->id, 'permission')) === 1) {
            return response()->json($cepLocal->delete($id), 200);
        }

        return response()->json(['message' => 'Você não tem permissão para realizar esta ação'], 401);
    }

}
