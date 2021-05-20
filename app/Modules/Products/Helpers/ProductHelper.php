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
     * @param $file
     * @return Reader
     * @throws \League\Csv\Exception
     */
    public function createProductsCsv($file): Reader
    {
        return Reader::createFromFileObject(new \SplFileObject($file))->setHeaderOffset(0);
    }

}
