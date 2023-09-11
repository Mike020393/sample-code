<?php

namespace App\Repositories\Models;

use App\Models\Product;
use App\Models\Category;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\ProductInterfaceRepository;

class ProductRepository extends BaseRepository implements ProductInterfaceRepository
{

    protected $model;

    public function __construct(Product $category)
    {
        $this->model = $category;
    }

    /**
     * getAllByTitleAndId
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllByTitleAndId()
    {
        return $this->model::pluck('title', 'id');
    }

    /**
     * parentCategory
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllCategory()
    {
        return $this->model::all();
    }
}
