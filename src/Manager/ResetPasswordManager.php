<?php

namespace App\Manager;

use App\AutoMapping;
use App\Entity\ResetPasswordRequestEntity;
use App\Repository\ResetPasswordRequestEntityRepository;
use App\Request\CreateAskResetPasswordRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResetPasswordManager
{
    private $autoMapping;
    private $entityManager;
    private $resetPasswordRequestEntityRepository;
    private $encoder;
    private $userManager;

    public function __construct(AutoMapping $autoMapping, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder, 
    UserManager $userManager, ResetPasswordRequestEntityRepository $resetPasswordRequestEntityRepository)
    {
        $this->autoMapping = $autoMapping;
        $this->entityManager = $entityManager;
        $this->encoder = $encoder;
        $this->userManager = $userManager;
        $this->resetPasswordRequestEntityRepository = $resetPasswordRequestEntityRepository;
    }

    public function create(CreateAskResetPasswordRequest $request)
    {
        $resetPasswordRequestEntity = $this->autoMapping->map(CreateAskResetPasswordRequest::class, ResetPasswordRequestEntity::class, $request);
        
        $this->entityManager->persist($resetPasswordRequestEntity);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return $resetPasswordRequestEntity;
    }

    public function checkResetRequest($email, $code)
    {
        return $this->resetPasswordRequestEntityRepository->getResetPasswordRequestByEmailAndCode($email, $code);
    }

    public function askResetPassword($request, $mailer)
    {
        $user = $this->userManager->getUserByEmail($request->getEmail());

        if($user != null)
        {
            $code = $this->resetCode();

            $request->setCode($code);
            $request->setExpiresAt(new \DateTime('+1 hour'));
            
            $this->create($request);

            $message = (new TemplatedEmail())
                ->from('auto-reply@SkeletonProject.com')
                ->to($request->getEmail())
                ->subject("Reset Password Code")
                ->htmlTemplate('email/ResetPasswordCode.html.twig')
                ->context(
                        [
                            'userEmail' => $request->getEmail(),
                            'code' => $code
                        ]);
                        
            $mailer->send($message);

            return "Your request was being registered. An email was being sent to you";
        }
    }

    public function resetPassword($request, $encoder)
    {
        $result = $this->checkResetRequest($request->getEmail(), $request->getcode());

        $currentDate = new \DateTime('Now');

        if($result != null)
        {
            if($currentDate < $result->getExpiresAt())
            {
                $user = $this->userManager->getUserByEmail($request->getEmail());

                if($user != null)
                {
                    $user->setPassword($encoder->encodePassword($user, $request->getPassword()));

                    $this->entityManager->flush();

                    return "Your password was being re-set successfully.";
                }

                return $result;
            }
            else
            {
                return "The entered code expired!";
            }
        }
        else
        {
            return "Either the email or the code is wrong!";
        }
    }

    public function resetCode()
    {
        $data = random_int(0, 9) . random_int(0, 9) . random_int(0, 9) . random_int(0, 9);

        return  vsprintf('%s%s%s%s', str_split(($data)));
    }

}