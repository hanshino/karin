<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class LineId implements Rule
{
    protected string $type;

    protected function __construct(string $type)
    {
        $this->type = $type;
    }

    public static function user()
    {
        return new self('user');
    }

    public static function group()
    {
        return new self('group');
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        switch ($this->type) {
            case 'user':
                return preg_match('/^U[a-f0-9]{32}$/', $value);
            case 'group':
                return preg_match('/^C[a-f0-9]{32}$/', $value);
            default:
                return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Must be the following format ^[UC][a-f0-9]{32}$';
    }
}
