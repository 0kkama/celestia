<?php


namespace App\Service\User\Context;


class RegisterUserContext
{
    protected string $email;
    protected string $password;

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return RegisterUserContext
     */
    public function setEmail(string $email): RegisterUserContext
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return RegisterUserContext
     */
    public function setPassword(string $password): RegisterUserContext
    {
        $this->password = $password;
        return $this;
    }
}
