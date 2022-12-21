<?php

namespace Tests\Feature\Http\Controllers\Line;

use App\Models\PlatformUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * 測試成功新增平台用戶
     * @return void
     * @group line-user
     */
    public function test_store_success()
    {
        $lineUser = PlatformUser::factory()
            ->useLineUser()
            ->make();

        $response = $this->json('POST', '/api/line/user', [
            'userId' => $lineUser->platform_id,
            'displayName' => $lineUser->display_name,
            'pictureUrl' => $lineUser->picture_url,
            'statusMessage' => $lineUser->status_message,
        ]);

        /** 斷言*/
        $response->assertStatus(201);
        $this->assertEquals($lineUser->platform_id, $response->json('data.userId'));
        $this->assertEquals($lineUser->display_name, $response->json('data.displayName'));
        $this->assertEquals($lineUser->picture_url, $response->json('data.pictureUrl'));
        $this->assertEquals($lineUser->status_message, $response->json('data.statusMessage'));

        $this->assertDatabaseHas('platform_users', [
            'platform' => 'line',
            'platform_id' => $lineUser->platform_id,
            'display_name' => $lineUser->display_name,
            'picture_url' => $lineUser->picture_url,
            'status_message' => $lineUser->status_message,
        ]);

        $this->assertDatabaseHas('users', [
            'name' => $lineUser->display_name,
            'avatar' => $lineUser->picture_url,
        ]);
    }

    /**
     * 測試新增平台用戶時，參數錯誤的情況
     * @return void
     * @group line-user
     */
    public function test_store_bad_request()
    {
        $response = $this->json('POST', '/api/line/user', []);

        $response->assertStatus(422);
        $this->assertArrayHasKey('userId', $response->json('errors'));
        $this->assertArrayHasKey('displayName', $response->json('errors'));
    }

    /**
     * 測試新增平台用戶時，平台用戶已存在的情況
     * @return void
     * @group line-user
     */
    public function test_store_duplicate()
    {
        $lineUser = PlatformUser::factory()
            ->useLineUser()
            ->create();

        $response = $this->json('POST', '/api/line/user', [
            'userId' => $lineUser->platform_id,
            'displayName' => $lineUser->display_name,
            'pictureUrl' => $lineUser->picture_url,
            'statusMessage' => $lineUser->status_message,
        ]);

        $response->assertStatus(422);
        $this->assertArrayHasKey('userId', $response->json('errors'));
        $this->assertEquals('The user id has already been taken.', $response->json('errors.userId.0'));
    }

    /**
     * 測試成功取得平台用戶
     * @return void
     * @group line-user
     */
    public function test_show_success()
    {
        $lineUser = PlatformUser::factory()
            ->useLineUser()
            ->create();

        $response = $this->json('GET', '/api/line/user/' . $lineUser->platform_id);

        $response->assertStatus(200);
        $this->assertEquals($lineUser->platform_id, $response->json('data.userId'));
        $this->assertEquals($lineUser->display_name, $response->json('data.displayName'));
        $this->assertEquals($lineUser->picture_url, $response->json('data.pictureUrl'));
        $this->assertEquals($lineUser->status_message, $response->json('data.statusMessage'));
    }

    /**
     * 測試取得平台用戶時，平台用戶不存在的情況
     * @return void
     * @group line-user
     */
    public function test_show_not_found()
    {
        $lineUser = PlatformUser::factory()
            ->useLineUser()
            ->make();

        $response = $this->json('GET', '/api/line/user/' . $lineUser->platform_id);
        $response->assertStatus(404);
    }

    /**
     * 測試取得平台用戶時，平台用戶 ID 格式錯誤的情況
     * @return void
     * @group line-user
     */
    public function test_show_invalid_id()
    {
        $response = $this->json('GET', '/api/line/user/' . $this->faker->uuid);
        $response->assertStatus(422);
    }
}
