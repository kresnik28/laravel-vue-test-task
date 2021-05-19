<?php


namespace App\Modules\Products\Validators;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

/**
 * Class StoreProductsCsv
 * @package App\Modules\Products\Validators
 */
class StoreProductsCsv extends FormRequest
{
    //code fields are used to determine the relationship between files and data
    //because its impossible to validate json object when content type is multipart/form-data
    private array $dataRules =
        [
            'external_id' => ['required', 'string', 'max:200'],
            'brand' => ['required', 'string', 'max:200'],
            'variant' => ['required', 'string', 'max:200'],
            'url' => ['required', 'string', 'max:200'],
            'price' => ['required', 'string', 'max:200'],
            'description' => ['required', 'string', 'max:200'],
            'published_at' => ['required', 'string', 'max:200'],
        ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'products_file' => 'required',
            'data' => 'json'
        ];
    }

    /**
     * @param array $data
     * @return array
     */
    public function validateDataArray(array $data): array
    {
        $validator = Validator::make($data, $this->dataRules);
        if ($validator->fails()) {
            return [
                'success' => false,
                'error_messages' => $validator->getMessageBag()->getMessages()
            ];
        }
        return ['success' => true];
    }
}
