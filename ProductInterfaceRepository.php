<?php

namespace App\Repositories\Contracts;

interface ProductInterfaceRepository
{
    /**
     * getAllByTitleAndId
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllByTitleAndId();
}
