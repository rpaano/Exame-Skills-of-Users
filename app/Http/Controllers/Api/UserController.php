<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $users = User::query()->whereHas('skills')->with('skills')
            ->when($request->name, function (Builder $query, $name) {
                $query->where("name", "like", "%$name%");
            })
            ->get();

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserStoreRequest $request
     * @return Application|ResponseFactory|Response
     * @throws Exception
     */
    public function store(UserStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::query()->create(['name' => $request->name]);
            $user->skills()->attach($request->skills);

            DB::commit();
        } catch (Exception $exception){
            DB::rollBack();
            return $this->failure(__("Create failed"), $exception->getMessage());
        }

        return $this->success(__("Successfully Stored"));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserUpdateRequest $request
     * @param User $user
     * @return Response
     */
    public function update(UserUpdateRequest $request, User $user): Response
    {
        DB::beginTransaction();
        try {
            $user->when($request->name, function ($query, $name) use($user) {
                $user->update(['name' => $name]);
            })->when($request->remove_skills, function (Builder $query, $skills) use($user) {
                $user->skills()->detach($skills);
            })->when($request->add_skills, function (Builder $query, $skills) use($user) {
                $user->skills()->attach($skills);
            });

            DB::commit();
        } catch (Exception $exception){
            DB::rollBack();
            return $this->failure(__("Update failed"), $exception->getMessage());
        }

        return $this->success(__("Successfully updated"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     */
    public function destroy(User $user): Response
    {
        DB::beginTransaction();
        try {
            $user->deleteOrFail();
            DB::commit();
        } catch (Exception $exception){
            DB::rollBack();
            return $this->failure(__("Delete failed"), $exception->getMessage());
        } catch (\Throwable $exception) {
            DB::rollBack();

            return $this->failure(__("Delete failed"), $exception->getMessage());
        }

        return $this->success(__("Successfully deleted"));
    }
}
