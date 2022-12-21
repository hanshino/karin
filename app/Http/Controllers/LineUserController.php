<?php

namespace App\Http\Controllers;

use App\Http\Requests\Line\StoreUserRequest;
use App\Http\Resources\LineUserResource;
use App\Models\PlatformUser;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class LineUserController extends Controller
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

        return (new LineUserResource($lineUser))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
