<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Modules\Attributes\Entities\AttributeEntity;

class AttributesTableSeeder extends Seeder
{
    /**
     * @var AttributeEntity
     */
    protected AttributeEntity $attributeEntity;

    public function __construct(AttributeEntity $attributeEntity)
    {
        $this->attributeEntity = $attributeEntity;
    }

    /**
     * Seed the attributes table.
     *
     * @return void
     */
    public function run()
    {
        $attributes = [
            ['name' => 'name'],
            ['name' => 'product_id'],
            ['name' => 'active'],
            ['name' => 'country'],
            ['name' => 'store_id'],
        ];
        foreach ($attributes as $attribute) {
            $this->attributeEntity->create($attribute);
        }
    }
}
