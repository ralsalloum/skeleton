<?php


namespace App\Service;


use App\AutoMapping;
use App\Entity\CategoryEntity;
use App\Manager\CategoryManager;
use App\Request\CategoryCreateRequest;
use App\Response\CategoryCreateResponse;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CategoryService
{
    private $categoryManager;
    private $autoMapping;
    private $params;

    public function __construct(CategoryManager $categoryManager, AutoMapping $autoMapping, ParameterBagInterface $params)
    {
        $this->categoryManager =$categoryManager;
        $this->autoMapping = $autoMapping;

        $this->params = $params->get('upload_base_url') . '/';
    }

    public function create($request)
    {  
        $categoryResult = $this->categoryManager->create($request);

        return $this->autoMapping->map(CategoryEntity::class, CategoryCreateResponse::class, $categoryResult);
    }

    public function update($request)
    {
        $categoryResult = $this->categoryManager->update($request);

        return $this->autoMapping->map(CategoryEntity::class, CategoryCreateResponse::class, $categoryResult);
    }

    public function delete($request)
    {
        $result = $this->categoryManager->delete($request);

        if(!($result instanceof CategoryEntity))
        {
            return $result;
        }

        return $this->autoMapping->map(CategoryEntity::class, CategoryCreateResponse::class, $result);
    }
    
    public function getAll()
    {
        $response=[];

        $result = $this->categoryManager->getAll();

        foreach ($result as $row)
        {
            $response[] = $this->autoMapping->map('array', CategoryCreateResponse::class, $row);
        }

        return $response;
    }

    public function getCategoryById($request)
    {
        $result = $this->categoryManager->getCategoryById($request);

        return $this->autoMapping->map(CategoryEntity::class, CategoryCreateResponse::class, $result);
    }

}