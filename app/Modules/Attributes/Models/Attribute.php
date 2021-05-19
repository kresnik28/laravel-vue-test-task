<?php


namespace App\Modules\Attributes\Models;


use App\Modules\Products\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Attribute extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name'];

    /**
     * @return BelongsToMany
     */
    public function values(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_attribute_values')->withPivot('value');
    }
}
