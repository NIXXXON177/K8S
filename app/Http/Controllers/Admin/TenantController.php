<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::with('user')
            ->withCount('mediaFiles', 'screenBookings', 'zoneBookings')
            ->paginate(10);

        return view('admin.tenants.index', compact('tenants'));
    }
}
