<?php

namespace App\Controller;

use App\AutoMapping;
use App\Request\CategoryCreateRequest;
use App\Request\CategoryUpdateRequest;
use App\Request\DeleteRequest;
use App\Request\GetByIdRequest;
use App\Service\CategoryService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CategoryController extends BaseController
{
    private $categoryService;
    private $autoMapping;
    private $validator;

    public function __construct(ValidatorInterface $validator, CategoryService $categoryService, AutoMapping $autoMapping, SerializerInterface $serializer)
    {
        parent::__construct($serializer);
        $this->categoryService = $categoryService;
        $this->autoMapping = $autoMapping;
        $this->validator = $validator;
    }

    /**
     * @Route("api/category", name="createCategory", methods={"POST"})
     * 
     * @OA\Tag(name="Category")
     */
    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        
        $request = $this->autoMapping->map(\stdClass::class, CategoryCreateRequest::class, (object) $data);

        $violations = $this->validator->validate($request);

        if (\count($violations) > 0) 
        {
            $violationsString = (string) $violations;

            return new JsonResponse($violationsString, Response::HTTP_OK);
        }

        $result = $this->categoryService->create($request);

        return $this->response($result, self::CREATE);
    }

    /**
     * @Route("api/category", name="updateCategory", methods={"PUT"})
     * 
     * @OA\Tag(name="Category")
     */
    public function update(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $request = $this->autoMapping->map(\stdClass::class, CategoryUpdateRequest::class, (object) $data);

        $violations = $this->validator->validate($request);

        if (\count($violations) > 0) 
        {
            $violationsString = (string) $violations;

            return new JsonResponse($violationsString, Response::HTTP_OK);
        }

        $result = $this->categoryService->update($request);

        return $this->response($result, self::UPDATE);
    }

    /**
     * @Route("api/category/{id}", name="deleteCategory", methods={"DELETE"})
     * 
     * @OA\Tag(name="Category")
     */
    public function delete(Request $request)
    {
        $request = new DeleteRequest($request->get('id'));

        $result = $this->categoryService->delete($request);

        return $this->response($result, self::DELETE);
    }

    /**
     * @Route("api/categories", name="getAllCategories", methods={"GET"})
     * 
     * @OA\Tag(name="Category")
     */
    public function getAllCategories()
    {
        $result = $this->categoryService->getAll();

        return $this->response($result, self::FETCH);
    }

    /**
     * @Route("api/category/{id}", name="getCategoryById", methods={"GET"})
     * 
     * @OA\Tag(name="Category")
     */
    public function getCategoryById(Request $request)
    {
        $request = new GetByIdRequest($request->get('id'));

        $result = $this->categoryService->getCategoryById($request);

        return $this->response($result, self::FETCH);
    }
}
