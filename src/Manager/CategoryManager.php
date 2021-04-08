<?php
namespace App\Manager;

use App\AutoMapping;

use App\Entity\CategoryEntity;
use App\Repository\CategoryEntityRepository;
use App\Request\CategoryCreateRequest;
use App\Request\CategoryUpdateRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Request\GetByIdRequest;
use App\Request\DeleteRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Flex\Response;


class CategoryManager
{
    private $entityManager;
    private $categoryEntityRepository;
    private $autoMapping;   

    public function __construct(EntityManagerInterface $entityManagerInterface, CategoryEntityRepository $categoryEntityRepository, 
    AutoMapping $autoMapping)
    {
        $this->entityManager = $entityManagerInterface;
        $this->categoryEntityRepository = $categoryEntityRepository;
        $this->autoMapping = $autoMapping;
    }

    public function create(CategoryCreateRequest $request)
    {
        $categoryEntity = $this->autoMapping->map(CategoryCreateRequest::class, CategoryEntity::class, $request);
        
        $this->entityManager->persist($categoryEntity);
        $this->entityManager->flush();
        $this->entityManager->clear();
        
        return $categoryEntity;
    }
    
    public function update(CategoryUpdateRequest $request)
    {
        $categoryEntity = $this->categoryEntityRepository->getCategoryById($request->getId());
        
        if (!$categoryEntity) 
        {
           
        } 
        else 
        {
            $categoryEntity = $this->autoMapping->mapToObject(CategoryUpdateRequest::class, CategoryEntity::class, 
            $request, $categoryEntity);

            $this->entityManager->flush();

            return $categoryEntity;
        }
    } 
    
    public function delete(DeleteRequest $request)
    {
        $category = $this->categoryEntityRepository->getCategoryById($request->getId());

        if (!$category)
        {
            return $category;
        }
        else
        {
            $this->entityManager->remove($category);
            $this->entityManager->flush();
        }

        return $category;
    }

    public function getAll()
    {
        return $this->categoryEntityRepository->getAll();
    }

    public function getCategoryById(GetByIdRequest $request)
    {
        return $this->categoryEntityRepository->getCategoryById($request->getId());
    }

}
