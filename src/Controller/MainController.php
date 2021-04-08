<?php


namespace App\Controller;


use App\AutoMapping;
use App\Entity\SettingEntity;
use App\Entity\UserEntity;
use App\Entity\UserProfileEntity;
use App\Request\FilterRequest;
use App\Service\MainService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MainController extends BaseController
{
    private $autoMapping;
    private $validator;
    private $mainService;

    public function __construct(SerializerInterface $serializer, AutoMapping $autoMapping, ValidatorInterface $validator,
                                MainService $mainService)
    {
        parent::__construct($serializer);
        $this->autoMapping = $autoMapping;
        $this->validator = $validator;
        $this->mainService = $mainService;
    }

    /**
     * @Route("members", name="searchByBrand", methods={"GET"})
     */
    public function getAllMembers()
    {
        $result = $this->mainService->getAllMembers();

        return $this->response($result, self::FETCH);
    }

    /**
     * @Route("/eraseall", name="deleteAllData", methods={"DELETE"})
     */
    public function eraseAllData()
    {
        try
        {
            $em = $this->getDoctrine()->getManager();

            // $usersProfiles = $em->getRepository(UserProfileEntity::class)->createQueryBuilder('profile')
            //     ->delete()
            //     ->getQuery()
            //     ->execute();

            // $users = $em->getRepository(UserEntity::class)->createQueryBuilder('user')
            //     ->delete()
            //     ->getQuery()
            //     ->execute();

            // $setting = $em->getRepository(SettingEntity::class)->createQueryBuilder('setting')
            //     ->delete()
            //     ->getQuery()
            //     ->execute();
            
        }
        catch (\Exception $ex)
        {
            return $this->json($ex);
        }

        return new Response("All Database information were being deleted");
    }

}