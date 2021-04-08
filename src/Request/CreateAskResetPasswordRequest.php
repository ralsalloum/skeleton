<?php


namespace App\Request;


class CreateAskResetPasswordRequest
{
    private $email;

    private $code;

    private $expiresAt;

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code): void
    {
        $this->code = $code;
    }

    /**
     * @param mixed $expiresAt
     */
    public function setExpiresAt($expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }

}