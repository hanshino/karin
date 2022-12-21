<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\PlatformUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LineUserControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_store_success()
    {
        $lineUser = PlatformUser::factory()
            ->useLineUser()
            ->make();

        $response = $this->json('POST', '/api/line-user', [
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
}
