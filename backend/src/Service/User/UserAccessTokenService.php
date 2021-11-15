<?php


namespace App\Service\User;


use App\Model\User;
use App\Model\UserAccessToken;
use App\Model\UserAccessTokenQuery;
use App\Service\User\Exception\ReachedMaximumAttemptsGenerateUniqueToken;

class UserAccessTokenService
{
    const GENERATE_UNIQUE_TOKEN_ATTEMPTS = 100;
    const TOKEN_LIFETIME = 2592000; // 30 days

    public function createAccessToken(User $user)
    {
        $accessToken = new UserAccessToken();
        $accessToken->setUser($user);
        $accessToken->setToken($this->generateUniqueToken());
        $accessToken->setExpiredAt(new \DateTime(sprintf('+%d seconds', static::TOKEN_LIFETIME)));
        $accessToken->save();

        return $accessToken;
    }

    public function findAccessToken(string $token)
    {
        return UserAccessTokenQuery::create()->findOneByToken($token);
    }

    public function isAccessTokenExpired(UserAccessToken $accessToken)
    {
        if (!$accessToken->getExpiredAt()) {
            return false;
        }

        return $accessToken->getExpiredAt() < new \DateTime('now');
    }

    public function generateUniqueToken(): string
    {
        $attempts = static::GENERATE_UNIQUE_TOKEN_ATTEMPTS;

        while ($token = $this->generateRandomToken() and $attempts-- > 0) {
            if (!$this->findAccessToken($token)) {
                return $token;
            }
        }

        throw new ReachedMaximumAttemptsGenerateUniqueToken();
    }

    public function generateRandomToken(): string
    {
        return bin2hex(random_bytes(32));
    }
}
