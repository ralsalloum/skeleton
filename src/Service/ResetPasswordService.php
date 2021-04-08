<?php

namespace App\Service;

use App\AutoMapping;
use App\Manager\ResetPasswordManager;
use App\Request\CreateAskResetPasswordRequest;
use App\Request\UpdatePasswordRequest;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResetPasswordService
{
    private $autoMapping;
    private $resetPasswordManager;

    public function __construct(AutoMapping $autoMapping, ResetPasswordManager $resetPasswordManager)
    {
        $this->autoMapping = $autoMapping;
        $this->resetPasswordManager = $resetPasswordManager;
    }

    public function askResetPassword(CreateAskResetPasswordRequest $request, MailerInterface $mailer)
    {
        return $this->resetPasswordManager->askResetPassword($request, $mailer);
    }

    public function resetPassword(UpdatePasswordRequest $request, UserPasswordEncoderInterface $encoder)
    {
        return $this->resetPasswordManager->resetPassword($request, $encoder);
    }
}