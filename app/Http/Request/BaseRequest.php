<?php

namespace App\Http\Request;

use Illuminate\Http\Request;

class BaseRequest extends Request
{
    public function expectsJson(): bool
    {
        return true;
    }

    public function wantsJson(): bool
    {
        return true;
    }
}