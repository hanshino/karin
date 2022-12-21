<?php

namespace App\Http\Requests\Line;

use App\Facade\Bouncer;
use App\Models\PlatformUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'userId' => [
                'required',
                'string',
                'max:255',
                Rule::unique('platform_users', 'platform_id')->where('platform', 'line')
            ],
            'displayName' => ['required', 'string', 'max:40'],
            'pictureUrl' => ['required', 'string', 'max:255'],
            'statusMessage' => ['required', 'string', 'max:255'],
        ];
    }
}
