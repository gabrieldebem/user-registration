<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Exception;
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
     * @throws Exception
     */
    public function index(): JsonResponse
    {
        if (! isSuperUser()) {
            throw new Exception("Não autorizado.", 401);
        }
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
     * @throws Exception
     */
    public function show(User $user): JsonResponse
    {
        if (! isSuperUser()) {
            throw new Exception("Não autorizado.", 401);
        }
        return response()->json($user);
    }

    /**
     * Return the current logged account.
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        return response()->json(currentUser());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function update(UpdateUserRequest $request): JsonResponse
    {
        $updatedUser = $this->userService
            ->setUser(currentUser())
            ->update($request->all())
            ->getUser();

        return response()->json($updatedUser);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     * @throws Throwable
     */
    public function destroy(): Response
    {
        currentUser()->deleteOrFail();

        return response()->noContent();
    }
}
