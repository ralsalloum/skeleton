<?php

namespace App\Controller;

use App\AutoMapping;
use App\Request\CreateAskResetPasswordRequest;
use App\Request\UpdatePasswordRequest;
use App\Service\ResetPasswordService;
use stdClass;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ResetPasswordController extends BaseController
{
    private $autoMapping;
    private $validator;
    private $resetPasswordService;

    public function __construct(SerializerInterface $serializer, AutoMapping $autoMapping, ValidatorInterface $validator,
     ResetPasswordService $resetPasswordService)
    {
        parent::__construct($serializer);

        $this->autoMapping = $autoMapping;
        $this->validator = $validator;
        $this->resetPasswordService = $resetPasswordService;
    }

    /**
     * @Route("/askresetpassword", name="app_forgotten_password", methods={"POST"})
     * @param Request $request
     * @param MailerInterface $mailer
     * @return JsonResponse
     */
    public function askResetPassword(Request $request, MailerInterface $mailer)
    {
        $data = json_decode($request->getContent(), true);

        $request = $this->autoMapping->map(stdClass::class, CreateAskResetPasswordRequest::class, (object)$data);

        $response = $this->resetPasswordService->askResetPassword($request, $mailer);

        return $this->response($response, self::CREATE);

    }

    /**
     * @Route("/resetpassword", name="app_reset_password", methods={"POST"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function resetPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $data = json_decode($request->getContent(), true);

        $request = $this->autoMapping->map(stdClass::class, UpdatePasswordRequest::class, (object)$data);

        $response = $this->resetPasswordService->resetPassword($request, $passwordEncoder);

        return $this->response($response, self::UPDATE);

    }
}