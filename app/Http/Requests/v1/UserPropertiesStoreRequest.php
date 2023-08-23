<?php

namespace App\Http\Requests\v1;

use App\Models\City;
use App\Models\ListingType;
use App\Models\PropertyType;
use Illuminate\Foundation\Http\FormRequest;
use Log;

class UserPropertiesStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return !!auth()->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $listing_types = ListingType::select('id', 'name')->get()->pluck('id', 'name');
        $rent_id = $listing_types['rent'] ?? '';
        $sell_id = $listing_types['sell'] ?? '';
        
        return [
            'name'              => 'required',
            'description'       => 'required',
            'bedrooms'          => 'required|integer|min:0',
            'bathrooms'         => 'required|integer|min:0',
            'property_type_id'  => 'required|exists:'.PropertyType::class.',id',
            'listing_type_id'   => 'required|exists:'.ListingType::class.',id',
            'address.*'         => 'required',
            'address.city_id'   => 'required|exists:'.City::class.',id',
            'address.street_name' => 'required',
            'address.street_nr'   => 'required',
            'address.postcode'    => 'required',
            'rent_listing.price_weekly'     => 'exclude_unless:listing_type_id,'.$rent_id.'|required_without:rent_listing.price_monthly|integer',
            'rent_listing.price_monthly'    => 'exclude_unless:listing_type_id,'.$rent_id.'|required_without:rent_listing.price_weekly|integer',
            'rent_listing.deposit'          => 'required_if:listing_type_id,'.$rent_id.'|integer',
            'rent_listing.minimum_tenancy'  => 'required_if:listing_type_id,'.$rent_id.'|integer',
            'sell_listing.price'            => 'required_if:listing_type_id,'.$sell_id.'|integer',
        ];
    }
}
