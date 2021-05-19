<?php


namespace App\Modules\Products\Controllers;


use App\Http\Controllers\Controller;
use App\Modules\Products\Entities\ProductEntity;
use App\Modules\Products\Helpers\ProductHelper;

class ProductController extends Controller
{
    /**
     * @var ProductEntity
     */
    protected ProductEntity $productEntity;

    /**
     * @var ProductHelper
     */
    protected ProductHelper $productHelper;

    public function __construct(ProductEntity $productEntity, ProductHelper $productHelper)
    {
        $this->productEntity = $productEntity;
        $this->productHelper = $productHelper;
    }

    public function index()
    {
        $requiredCols = $this->productEntity->getModel()->mappable;
        $mappableColumns = $this->productHelper->getAllMappableColumns();

        return view('products.index', compact('requiredCols', 'mappableColumns'));
    }
}
