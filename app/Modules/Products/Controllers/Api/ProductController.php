<?php


namespace App\Modules\Products\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Modules\Products\Helpers\ProductHelper;
use App\Modules\Products\Validators\StoreProductsCsv;

/**
 * Class ProductController
 * @package App\Modules\Products\Controllers\Api
 */
class ProductController extends Controller
{
    /**
     * @var ProductHelper
     */
    private ProductHelper $productHelper;

    /**
     * ProductController constructor.
     */
    public function __construct(ProductHelper $productHelper)
    {
        $this->productHelper = $productHelper;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMappableColumns()
    {
        return response()->json($this->productHelper->getAllMappableColumns());
    }

    /**
     * @param StoreProductsCsv $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeProductsCsv(StoreProductsCsv $request): \Illuminate\Http\JsonResponse
    {
        //validating json data
        $data = json_decode($request->get('mapping_data'), true);

        $validation = (new StoreProductsCsv())->validateDataArray($data);

        if (!$validation['success']) {
            return response()->json($validation, 422);
        }
        $data = $request->all();
        $this->productHelper->createProductsCsv($data);

        return response()->json(['success' => true]);
    }
}
