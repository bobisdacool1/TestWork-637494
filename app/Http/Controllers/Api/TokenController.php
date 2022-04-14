<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\NewTokenRequest;
use App\Models\User;
use App\Repositories\TokenRepository;

class TokenController extends ApiController
{
    public function new(NewTokenRequest $request)
    {
        $request->validated();

        $token = $this->repository->generateNewToken($request->user_id, $request->token_name);

        return response()->json(['token' => $token]);
    }

    protected function newRepository()
    {
        return new TokenRepository();
    }
}
