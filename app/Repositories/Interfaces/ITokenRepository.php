<?php


namespace App\Repositories\Interfaces;


interface ITokenRepository
{
    public function generateNewToken(int $userId, string $tokenName);
}
