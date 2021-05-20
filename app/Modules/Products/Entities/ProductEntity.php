<?php


namespace App\Modules\Products\Entities;


use App\Entities\ModelEntity;
use App\Modules\Products\Models\Product;

/**
 * Class ProductEntity
 * @package App\Modules\Products\Entities
 */
class ProductEntity extends ModelEntity
{

    /**
     * @return string
     */
    protected function model(): string
    {
        return Product::class;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->model->create($data);
    }
}
