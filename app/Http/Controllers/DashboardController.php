<?php

namespace App\Http\Controllers;

use App\Models\Selling;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $title = "Dashboard";
        $breadcrumb = [[
            'target' => '',
            'label'  => 'Dashboard'
        ]];

        $purchase = Purchase::where('user_id', auth()->user()->id)
            ->with('details')
            ->whereBetween('created_at', [Carbon::now()->format('Y-m-d') . ' 00:00:00', Carbon::now()->format('Y-m-d') . ' 23:59:59']);

        $selling = Selling::where('user_id', auth()->user()->id)
            ->with('details')
            ->whereBetween('created_at', [Carbon::now()->format('Y-m-d') . ' 00:00:00', Carbon::now()->format('Y-m-d') . ' 23:59:59']);

        $data = [
            'title'         => $title,
            'breadcrumb'    => $breadcrumb,
            'purchase'      => [
                'count'     => $purchase->count(),
                'total'     => $purchase->get()->sum('total')
            ],
            'selling'      => [
                'count'     => $selling->count(),
                'total'     => $selling->get()->sum('total')
            ]
        ];
        return view('dashboard.index', compact('data'));
    }
}
