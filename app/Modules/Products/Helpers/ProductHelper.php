<?php


namespace App\Modules\Products\Helpers;


use App\Modules\Attributes\Entities\AttributeEntity;
use App\Modules\Products\Entities\ProductEntity;
use App\Modules\Products\Models\Product;
use League\Csv\Reader;

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
     * @return array
     */
    public function getAllMappableColumns()
    {
        $attributes = $this->attributeEntity->getAllNames();
        return array_merge($this->productEntity->getModel()->mappable, $attributes);
    }

    /**
     * @param array $data
     * @throws \Exception
     */
    public function createProductsCsv(array $data)
    {
        try {
            $mapping = json_decode($data['mapping_data'], true);
            $csv = Reader::createFromFileObject(new \SplFileObject($data['products_file']))->setHeaderOffset(0);

            foreach ($csv as $item) {
                $product = $this->productEntity->create(
                    [
                        'external_id' => $item[$mapping['external_id']],
                        'brand' => $item[$mapping['brand']],
                        'variant' => $item[$mapping['variant']],
                        'url' => $item[$mapping['url']],
                        'price' => $item[$mapping['price']],
                        'description' => $item[$mapping['description']],
                        'published_at' => $item[$mapping['published_at']]
                    ]
                );

                $this->setAttributeValues($product, $mapping, $item);
            }
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * @param Product $product
     * @param array $mapping
     * @param array $data
     */
    private function setAttributeValues(Product $product, array $mapping, array $data)
    {
        $attributes = $this->attributeEntity->getAll();
        $values = [];
        foreach ($attributes as $attribute) {
            if (isset($data[$mapping[$attribute->name]])) {
                $value = $data[$mapping[$attribute->name]];
                $values[$attribute->id] = ['value' => $value];
            }
        }
        $product->attributeValues()->sync($values);
    }
}
