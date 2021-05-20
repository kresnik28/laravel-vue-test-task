<?php


namespace App\Modules\Products\Controllers;


use App\Http\Controllers\Controller;
use App\Modules\Products\Entities\ProductEntity;
use App\Modules\Products\Helpers\ProductHelper;
use App\Modules\Products\Services\ProductImportService;

/**
 * Class ProductController
 * @package App\Modules\Products\Controllers
 */
class ProductController extends Controller
{
    /**
     * @var ProductImportService
     */
    protected ProductImportService $productImportService;

    /**
     * ProductController constructor.
     * @param ProductImportService $productImportService
     */
    public function __construct(ProductImportService $productImportService)
    {
        $this->productImportService = $productImportService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $requiredCols = $this->productImportService->mappable;

        return view('products.index', compact('requiredCols'));
    }
}
