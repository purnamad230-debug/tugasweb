<?php

namespace App\Services;

use App\Models\Menu;

class MenuService
{
    public function create($data)
    {
        return Menu::create($data);
    }
}