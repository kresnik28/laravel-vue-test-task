<?php


namespace App\Modules\Attributes\Entities;


use App\Entities\ModelEntity;
use App\Modules\Attributes\Models\Attribute;

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
}
