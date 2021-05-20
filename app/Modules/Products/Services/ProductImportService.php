<?php


namespace App\Modules\Products\Services;


use App\Modules\Attributes\Entities\AttributeEntity;
use App\Modules\Products\Entities\ProductEntity;
use App\Modules\Products\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use League\Csv\Reader;

/**
 * Class ProductImportService
 * @package App\Modules\Products\Services
 */
class ProductImportService
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
     * @var array
     */
    protected array $mapping;

    /**
     * @var array
     */
    public array $mappable = [
        'external_id',
        'brand',
        'variant',
        'url',
        'price',
        'description',
        'published_at'
    ];


    /**
     * ProductImportService constructor.
     * @param AttributeEntity $attributeEntity
     * @param ProductEntity $productEntity
     */
    public function __construct(
        AttributeEntity $attributeEntity,
        ProductEntity $productEntity
    ) {
        $this->attributeEntity = $attributeEntity;
        $this->productEntity = $productEntity;
    }

    /**
     * @return array
     */
    public function getAllMappableColumns(): array
    {
        $attributes = $this->attributeEntity->getAllNames();
        return array_merge($this->mappable, $attributes);
    }

    /**
     * @param array $data
     * @return array
     */
    public function importCsv(array $data)
    {
        try {
            $csv = $this->readCsvFile($data['products_file']);
        } catch (\Exception $ex) {
            return [
                'success' => false,
                'message' => 'Cant read data from csv file'
            ];
        }
        $this->mapping = $data['mapping_data'];

        $logging = ['skipped' => 0, 'imported' => 0];

        foreach ($csv as $item) {
            $this->importProduct($item) ? $logging['imported']++ : $logging['skipped']++;
        }

        return [
            'success' => true,
            'message' => "imported: {$logging['imported']}, skipped: {$logging['skipped']}"
        ];
    }

    /**
     * @param $item
     * @return bool
     */
    private function importProduct($item): bool
    {
        try {
            $validation = $this->validateImportData($item);
            if ($validation !== true) {
                return false;
            }
            $product = $this->productEntity->create(
                [
                    'external_id' => $item[$this->mapping['external_id']],
                    'brand' => $item[$this->mapping['brand']],
                    'variant' => $item[$this->mapping['variant']],
                    'url' => $item[$this->mapping['url']],
                    'price' => $item[$this->mapping['price']],
                    'description' => $item[$this->mapping['description']],
                    'published_at' => $item[$this->mapping['published_at']]
                ]
            );

            $this->setAttributeValues($product, $item);

            return true;
        } catch (\Exception $exception) {
            Log::warning($exception);
            return false;
        }
    }

    /**
     * @param $file
     * @return Reader
     * @throws \League\Csv\Exception
     */
    private function readCsvFile($file): Reader
    {
        return Reader::createFromFileObject(new \SplFileObject($file))->setHeaderOffset(0);
    }

    /**
     * @param array $data
     * @return array|bool
     */
    private function validateImportData(array $data)
    {
        $validationRules = [
            $this->mapping['external_id'] => 'required|numeric',
            $this->mapping['brand'] => 'required|string',
            $this->mapping['variant'] => 'required|string',
            $this->mapping['url'] => 'required|string',
            $this->mapping['price'] => 'required|numeric',
            $this->mapping['description'] => 'string',
            $this->mapping['published_at'] => 'required|numeric'
        ];
        $validator = Validator::make($data, $validationRules);
        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => $validator->getMessageBag()->getMessages()
            ];
        }
        return true;
    }


    /**
     * @param Product $product
     * @param array $data
     */
    private function setAttributeValues(Product $product, array $data)
    {
        $attributes = $this->attributeEntity->getAll();
        $values = [];
        foreach ($attributes as $attribute) {
            if (!isset($data[$this->mapping[$attribute->name]])) {
                continue;
            }

            $value = $data[$this->mapping[$attribute->name]];

            if (strlen($value) < 255) {
                $values[$attribute->id] = ['value' => $value];
            }
        }
        $product->attributeValues()->sync($values);
    }
}
