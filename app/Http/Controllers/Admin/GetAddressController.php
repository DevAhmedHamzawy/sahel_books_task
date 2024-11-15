<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class GetAddressController extends Controller
{
    public function index($id)
    {
        return response()->json(User::find($id)->address);
    }
}
