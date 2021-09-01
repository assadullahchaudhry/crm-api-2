<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::select('id', 'name')->get();

        return response()->json([
            'status' => 'success',
            'roles' => $roles
        ]);

    }
}
