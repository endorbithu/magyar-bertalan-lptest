<?php

namespace App\Contracts\Services;

use Illuminate\Http\Request;

interface LpSaveInstantInterface
{
    public function __construct(Request $data);

    public function save();
}
