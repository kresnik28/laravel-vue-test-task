<?php


namespace App\Modules\Products\Validators;


use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreProductsCsv
 * @package App\Modules\Products\Validators
 */
class StoreProductsCsv extends FormRequest
{

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

            'mapping_data.external_id' => ['required', 'string', 'max:200'],
            'mapping_data.brand' => ['required', 'string', 'max:200'],
            'mapping_data.variant' => ['required', 'string', 'max:200'],
            'mapping_data.url' => ['required', 'string', 'max:200'],
            'mapping_data.price' => ['required', 'string', 'max:200'],
            'mapping_data.description' => ['required', 'string', 'max:200'],
            'mapping_data.published_at' => ['required', 'string', 'max:200'],
        ];
    }
}
