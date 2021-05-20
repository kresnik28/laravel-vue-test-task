<?php


namespace App\Modules\Products\Models;


use App\Modules\Attributes\Models\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Product
 * @package App\Modules\Products\Models
 */
class Product extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'external_id',
        'brand',
        'variant',
        'url',
        'price',
        'description',
        'published_at'
    ];


    /**
     * @return BelongsToMany
     */
    public function attributeValues(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'product_attribute_values')->withPivot('value');
    }
}
