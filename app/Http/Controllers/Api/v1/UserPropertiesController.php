<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\UserPropertiesStoreRequest;
use App\Http\Resources\v1\UserPropertyResource;
use App\Models\Property;
use App\Models\Address;
use App\Repositories\PropertyRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Models\User;
use Log;

/**
 * Class UserPropertiesController
 *
 */
class UserPropertiesController extends Controller
{
    public function __construct(protected PropertyRepositoryInterface $property_repository)
    {}
    
    /**
     * @OA\Get(
     *      path="/api/v1/user-properties",
     *      operationId="v1-user-properties-index",
     *      tags={"user properties"},
     *      summary="User Properties",
     *      description="get user properties",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       )
     *     )
     *
     * Returns App/Model/User
     */
    public function index(User $user) : JsonResponse
    {
        $public_fields = Property::getTableColumns();

        $user_properties = QueryBuilder::for(Property::class)
                        ->where('owner_id', $user->id)
                        ->allowedFilters([
                            AllowedFilter::exact('bedrooms'),
                        ])
                        ->allowedIncludes(['propertyType', 'listingType', 'rentListing', 'sellListing'])
                        ->select($public_fields)
                        ->allowedSorts($public_fields)
                        ->paginate(request('limit', 100))
                        ->appends(request()->query());

        return UserPropertyResource::collection($user_properties)
                ->additional(['meta' => [
                    'public_fields' => $public_fields
                ]])
                ->response()
                ->setStatusCode(Response::HTTP_OK);
    }

    public function store(User $user, UserPropertiesStoreRequest $request)
    { 
        //save the property and it's relationships
        $this->property_repository
        ->setData($request->only(['name','property_type_id', 'listing_type_id', 'description', 'bedrooms', 'bathrooms', 'is_public']))
        ->setUser($user->id)
        ->setAddress(Address::create($request->input('address')))
        ->setRentListing($request->input('rent_listing'))
        ->setSellListing($request->input('sell_listing'))
        ->saveInstance();

        return response([])->setStatusCode(Response::HTTP_CREATED);
    }
}
