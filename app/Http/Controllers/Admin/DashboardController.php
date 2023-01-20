<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $title = "Dashboard";
        $breadcrumb = [[
            'target' => '',
            'label'  => 'Dashboard'
        ]];
        $data = [
            'title'         => $title,
            'breadcrumb'    => $breadcrumb
        ];
        return view('admin.dashboard.index', compact('data'));
    }
}
