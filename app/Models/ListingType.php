<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ListingType extends Model
{
    use HasFactory;

    protected $table = 'listing_types';
    
    /**
     * Relationships
     */
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

}
