<?php


namespace App\Modules\Attributes\Controllers\Api;


use App\Modules\Attributes\Entities\AttributeEntity;
use Illuminate\Http\Request;

/**
 * Class AttributeController
 * @package App\Modules\Attributes\Controllers\Api
 */
class AttributeController
{
    /**
     * @var AttributeEntity
     */
    protected AttributeEntity $attributeEntity;

    /**
     * AttributeController constructor.
     * @param AttributeEntity $attributeEntity
     */
    public function __construct(AttributeEntity $attributeEntity)
    {
        $this->attributeEntity = $attributeEntity;
    }

    /**
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->toArray();

        $this->attributeEntity->create($data);
        return response()->json(['success' => true]);
    }
}
