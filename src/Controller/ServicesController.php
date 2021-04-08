<?php


namespace App\Controller;


use App\AutoMapping;
use App\Request\DeleteRequest;
use App\Request\ServiceCreateRequest;
use App\Request\ServiceUpdateRequest;
use App\Service\ServicesService;
use stdClass;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ServicesController extends BaseController
{
    private $autoMapping;
    private $servicesService;
    private $validator;

    public function __construct(SerializerInterface $serializer, AutoMapping $autoMapping, ValidatorInterface $validator,
     ServicesService $servicesService)
    {
        parent::__construct($serializer);
        $this->autoMapping = $autoMapping;
        $this->servicesService = $servicesService;
        $this->validator = $validator;
    }

    /**
     * @Route("service", name="createService", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $request = $this->autoMapping->map(stdClass::class, ServiceCreateRequest::class, (object)$data);

        $request->setCreatedBy($this->getUserId());

        $violations = $this->validator->validate($request);

        if (\count($violations) > 0)
        {
            $violationsString = (string) $violations;

            return new JsonResponse($violationsString, Response::HTTP_OK);
        }

        $response = $this->servicesService->create($request);

        return $this->response($response, self::CREATE);
    }

    /**
     * @Route("service", name="updateService", methods={"PUT"})
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $request = $this->autoMapping->map(\stdClass::class, ServiceUpdateRequest::class, (object) $data);

        $violations = $this->validator->validate($request);

        if (\count($violations) > 0)
        {
            $violationsString = (string) $violations;

            return new JsonResponse($violationsString, Response::HTTP_OK);
        }

        $result = $this->servicesService->update($request);

        return $this->response($result, self::UPDATE);
    }

    /**
     * @Route("service/{id}", name="deleteService", methods={"DELETE"})
     */
    public function delete(Request $request)
    {
        $request = new DeleteRequest($request->get('id'));

        $result = $this->servicesService->delete($request);

        return $this->response("The item has been deleted!", self::DELETE);
    }

    /**
     * @Route("services/{categoryID}", name="getServicesByCategoryID", methods={"GET"})
     * @return JsonResponse
     */
    public function getServicesByCategoryID($categoryID)
    {
        $result = $this->servicesService->getServicesByCategoryID($categoryID);

        return $this->response($result, self::FETCH);
    }

    /**
     * @Route("myservices", name="getServicesOfSignedInUser", methods={"GET"})
     * @return JsonResponse
     */
    public function getServicesOfUser()
    {
        $result = $this->servicesService->getServicesOfUser($this->getUserId());

        return $this->response($result, self::FETCH);
    }

    /**
     * @Route("servicesbyid/{serviceID}", name="getServicesBySpecificAccount", methods={"GET"})
     */
    public function getServicesBySpecificAccount($serviceID)
    {
        $result = $this->servicesService->getServicesBySpecificAccount($serviceID);

        return $this->response($result, self::FETCH);
    }
}