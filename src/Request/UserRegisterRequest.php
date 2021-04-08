<?php


namespace App\Request;


class UserRegisterRequest
{
    private $userID;

    private $roles = [];

    private $password;

    private $email;

    private $userName;

    /**
     * @return mixed
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * @param mixed $userID
     */
    public function setUserID($userID): void
    {
        $this->userID = $userID;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

     /**
     * @return mixed
     */ 
    public function getEmail()
    {
        return $this->email;
    }

   /**
     * @param mixed $email
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
}
