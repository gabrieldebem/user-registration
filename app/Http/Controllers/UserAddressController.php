<?php

namespace App\Http\Controllers;

use App\Enums\State;
use App\Http\Requests\StoreUserAddressRequest;
use App\Http\Requests\UpdateUserAddressRequest;
use App\Models\User;
use App\Models\UserAddress;
use App\Services\UserAddressService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;

class UserAddressController extends Controller
{

    public function __construct(private UserAddressService $addressService)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $address = QueryBuilder::for(UserAddress::class)
            ->allowedFilters(['city', 'state', 'user_id'])
            ->allowedSorts('created_at')
            ->get();

        return response()->json($address);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param User $user
     * @param StoreUserAddressRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserAddressRequest $request): JsonResponse
    {
        $address = $this->addressService
            ->create(
                userId: currentUser()->id,
                zipcode: $request->input('zipcode'),
                address: $request->input('address'),
                number: $request->input('number'),
                district: $request->input('district'),
                city: $request->input('district'),
                state: State::from($request->input('state')),
                complement: $request->input('complement') ?? null
            )->getAddress();

        return response()->json($address);
    }

    /**
     * Display the specified resource.
     *
     * @param UserAddress $userAddress
     * @return JsonResponse
     */
    public function show(UserAddress $userAddress): JsonResponse
    {
        return response()->json($userAddress);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserAddressRequest $request
     * @param UserAddress $userAddress
     * @return JsonResponse
     */
    public function update(UserAddress $userAddress, UpdateUserAddressRequest $request): JsonResponse
    {
        $address = $this->addressService
            ->setAddress($userAddress)
            ->update($request->all())
            ->getAddress();

        return response()->json($address);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param UserAddress $userAddress
     * @return Response
     */
    public function destroy(UserAddress $userAddress): Response
    {
        $userAddress->delete();

        return response()->noContent();
    }
}
