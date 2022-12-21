<?php

namespace App\Http\Controllers\Line;

use App\Http\Controllers\Controller;
use App\Http\Requests\Line\StoreUserRequest;
use App\Http\Resources\Line\UserResource;
use App\Models\PlatformUser;
use App\Models\User;
use App\Rules\LineId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $attributes = $request->validated();
        DB::beginTransaction();

        try {
            $lineUser = new PlatformUser([
                'platform' => 'line',
                'platform_id' => $attributes['userId'],
                'display_name' => $attributes['displayName'],
                'picture_url' => $attributes['pictureUrl'],
                'status_message' => $attributes['statusMessage'],
            ]);

            $user = new User([
                'name' => $attributes['displayName'],
                'avatar' => $attributes['pictureUrl'],
            ]);

            // 關聯用戶和平台用戶
            $user->save();
            $lineUser->user()->associate($user)->save();

            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
            throw $throwable;
        }

        return (new UserResource($lineUser))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $userId
     * @return \Illuminate\Http\Response
     */
    public function show(string $userId)
    {
        $validator = Validator::make(['userId' => $userId], [
            'userId' => [LineId::user()],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $lineUser = PlatformUser::where('platform', 'line')
            ->where('platform_id', $userId)
            ->firstOrFail();

        return new UserResource($lineUser);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
