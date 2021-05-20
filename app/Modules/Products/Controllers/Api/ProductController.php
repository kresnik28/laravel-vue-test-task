<?php


namespace App\Modules\Products\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Modules\Products\Helpers\ProductHelper;
use App\Modules\Products\Services\ProductImportService;
use App\Modules\Products\Validators\StoreProductsCsv;

/**
 * Class ProductController
 * @package App\Modules\Products\Controllers\Api
 */
class ProductController extends Controller
{
    /**
     * @var ProductImportService
     */
    private ProductImportService $productImportService;

    /**
     * ProductController constructor.
     */
    public function __construct(ProductImportService $productImportService)
    {
        $this->productImportService = $productImportService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMappableColumns(): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->productImportService->getAllMappableColumns());
    }

    /**
     * @param StoreProductsCsv $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeProductsCsv(StoreProductsCsv $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->all();
        $result = $this->productImportService->importCsv($data);

        return response()->json($result);
    }
}
