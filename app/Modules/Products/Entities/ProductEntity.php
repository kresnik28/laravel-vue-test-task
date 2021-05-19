<?php


namespace App\Modules\Products\Entities;


use App\Entities\ModelEntity;
use App\Modules\Products\Models\Product;

class ProductEntity extends ModelEntity
{

    protected function model(): string
    {
        return Product::class;
    }
}
