<?php


namespace App\Modules\Products\Helpers;


use App\Modules\Attributes\Entities\AttributeEntity;
use App\Modules\Products\Entities\ProductEntity;
use App\Modules\Products\Models\Product;
use League\Csv\Reader;

/**
 * Class ProductHelper
 * @package App\Modules\Products\Helpers
 */
class ProductHelper
{

    /**
     * @var AttributeEntity
     */
    protected AttributeEntity $attributeEntity;

    /**
     * @var ProductEntity
     */
    protected ProductEntity $productEntity;

    /**
     * ProductHelper constructor.
     */
    public function __construct(AttributeEntity $attributeEntity, ProductEntity $productEntity)
    {
        $this->attributeEntity = $attributeEntity;
        $this->productEntity = $productEntity;
    }

    /**
     * @return Reader
     * @throws \League\Csv\Exception
     */
    public function createProductsCsv($file): Reader
    {
        return Reader::createFromFileObject(new \SplFileObject($file))->setHeaderOffset(0);
    }

}
