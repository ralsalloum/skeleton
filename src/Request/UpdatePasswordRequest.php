<?php


namespace App\Request;


class UpdatePasswordRequest
{
    private $email;

    private $code;

    private $password;

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

}