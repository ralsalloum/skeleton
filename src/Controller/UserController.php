<?php

namespace App\Controller;

use App\AutoMapping;
use App\Request\UserProfileCreateRequest;
use App\Request\UserProfileUpdateRequest;
use App\Request\UserRegisterRequest;
use App\Service\UserService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use stdClass;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends BaseController
{
    private $autoMapping;
    private $validator;
    private $userService;

    public function __construct(SerializerInterface $serializer, AutoMapping $autoMapping, ValidatorInterface $validator, UserService $userService)
    {
        parent::__construct($serializer);
        $this->autoMapping = $autoMapping;
        $this->validator = $validator;
        $this->userService = $userService;
    }

    /**
     * @Route("api/user", name="userRegister", methods={"POST"})
     * 
     * @OA\Tag(name="UserProfile")
     */
    public function userRegister(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $request = $this->autoMapping->map(stdClass::class,UserRegisterRequest::class,(object)$data);

        $violations = $this->validator->validate($request);
        if (\count($violations) > 0) {
            $violationsString = (string) $violations;

            return new JsonResponse($violationsString, Response::HTTP_OK);
        }

        $response = $this->userService->userRegister($request);

        return $this->response($response, self::CREATE);
    }

    /**
     * @Route("api/userprofile", name="updateUserProfile", methods={"PUT"})
     * 
     * @OA\Tag(name="UserProfile")

     * @Security(name="Bearer")
     */
    public function updateUserProfile(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $request = $this->autoMapping->map(stdClass::class,UserProfileUpdateRequest::class,(object)$data);
        $request->setUserID($this->getUserId());

        $response = $this->userService->userProfileUpdate($request);

        return $this->response($response, self::UPDATE);
    }

    /**
     * @Route("api/userprofile", name="getUserProfileByID",methods={"GET"})
     *
     * @OA\Tag(name="UserProfile")
     * 
     * @OA\Response(
     *      response=200,
     *      description="Returns the profile of signed-in user"
     * )
     * 
     * @Security(name="Bearer")
     */
    public function getUserProfileByID()
    {
        $response = $this->userService->getUserProfileByUserID($this->getUserId());

        return $this->response($response,self::FETCH);
    }
}
