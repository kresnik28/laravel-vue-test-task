<?php


namespace App\Modules\Attributes\Entities;


use App\Entities\ModelEntity;
use App\Modules\Attributes\Models\Attribute;

/**
 * Class AttributeEntity
 * @package App\Modules\Attributes\Entities
 */
class AttributeEntity extends ModelEntity
{

    /**
     * @return string
     */
    protected function model(): string
    {
        return Attribute::class;
    }

    /**
     * @param array $data
     */
    public function create(array $data)
    {
        $this->model->create(['name' => $data['name']]);
    }

    /**
     * @return array
     */
    public function getAllNames()
    {
        return $this->model->select('name')->get()->pluck('name')->toArray();
    }
}
