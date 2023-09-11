<?php

namespace App\Services\Back\Educations;

use App\Services\Back\Services;
use App\Services\Traits\CrudableService;
use App\Repositories\Contracts\ProductInterfaceRepository;

class ProductAdminService extends Services
{
    use CrudableService;

    protected $path = 'admin.pages.product';
    protected $route = 'admin.product';

    protected $productRepository;
    protected $categoryAdminService;

    public function __construct(ProductInterfaceRepository $productRepository, CategoryAdminService $categoryAdminService)
    {
        $this->repository = $productRepository;
        $this->categoryAdminService = $categoryAdminService;
    }

    /**
     * create prepare for view
     *
     * @return array
     */
    public function create()
    {
        return [
            'categories' => $this->categoryAdminService->index()
        ];
    }

    /**
     * create prepare for view
     * @param int $course_id
     * @return array
     */
    public function edit($product_id) {
        return [
            'categories' => $this->categoryAdminService->index(),
            'product' => $this->repository->findById($product_id)
        ];
    }
}
