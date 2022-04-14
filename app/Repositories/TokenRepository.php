<?php


namespace App\Repositories;


use App\Models\User;
use App\Repositories\Interfaces\ITokenRepository;

class TokenRepository extends Repository implements ITokenRepository
{
    public function generateNewToken(int $userId, string $tokenName)
    {
        try {
            $user = User::where('id', $userId)->first();
            return $user->newApiToken($tokenName);

        } catch (\Exception $e) {
            abort(400, $e->getMessage());
        }
    }
}
