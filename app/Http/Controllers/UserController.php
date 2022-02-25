<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\QueryBuilder;
use Throwable;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $user = QueryBuilder::for(User::class)
            ->allowedFilters(['first_name', 'cpf'])
            ->allowedSorts('birth_date', 'created_at')
            ->get();

        return response()->json($user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = $this->userService->create(
            email: $request->input('email'),
            password: Hash::make($request->input('password')),
            first_name: $request->input('first_name'),
            last_name: $request->input('last_name'),
            cpf: $request->input('cpf'),
            rg: $request->input('rg'),
            birth_date: Carbon::parse($request->input('birth_date')),
            phone: $request->input('phone'),
            cellphone: $request->input('cellphone')
        )->getUser();

        return response()->json($user);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $updatedUser = $this->userService
            ->setUser($user)
            ->update($request->all())
            ->getUser();

        return response()->json($updatedUser);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     * @throws Throwable
     */
    public function destroy(User $user): Response
    {
        $user->deleteOrFail();

        return response()->noContent();
    }
}
