<?php

namespace App\Http\Controllers;

use App\Models\Selling;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function purchase(Request $request)
    {
        if ($request->tanggal_mulai || $request->tanggal_akhir) {
            $validated = $request->validate([
                'tanggal_mulai' => 'required|date',
                'tanggal_akhir' => 'required|date|after_or_equal:' . $request->tanggal_mulai,
            ]);
            $start_date = Carbon::parse($request->tanggal_mulai)->format('Y-m-d');
            $end_date = Carbon::parse($request->tanggal_akhir)->format('Y-m-d');
        } else {
            $start_date = Carbon::now()->format('Y-m-d');
            $end_date = Carbon::now()->format('Y-m-d');
        }

        $title = 'Laporan Pembelian';

        $breadcrumb = [[
            'target' => route('dashboard'),
            'label'  => 'Dashboard'
        ], [
            'target' => '',
            'label'  => 'Laporan Pembelian'
        ]];

        $report = Purchase::orderBy('created_at', 'desc')
            ->where('user_id', auth()->user()->id)
            ->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
            ->get();

        $start_date = Carbon::parse($start_date)->format('d-m-Y');
        $end_date = Carbon::parse($end_date)->format('d-m-Y');

        $data = [
            'title'         => $title,
            'breadcrumb'    => $breadcrumb,
            'report'        => $report,
            'start_date'    => $start_date,
            'end_date'      => $end_date
        ];

        return view('report.purchase.index', compact('data'));
    }

    public function purchaseDetail($code)
    {

        $report = Purchase::where('code', $code)
            ->with('details')
            ->first();

        $title = "Detail Laporan Pembelian ($report->code)";

        $breadcrumb = [[
            'target' => route('dashboard'),
            'label'  => 'Dashboard'
        ], [
            'target' => route('report.purchase'),
            'label'  => 'Laporan Pembelian'
        ], [
            'target'    => '',
            'label'     => 'Detail Laporan Pembelian'
        ]];

        $data = [
            'title'         => $title,
            'breadcrumb'    => $breadcrumb,
            'report'        => $report
        ];

        return view('report.purchase.detail', compact('data'));
    }

    public function selling(Request $request)
    {
        if ($request->tanggal_mulai || $request->tanggal_akhir) {
            $validated = $request->validate([
                'tanggal_mulai' => 'required|date',
                'tanggal_akhir' => 'required|date|after_or_equal:' . $request->tanggal_mulai,
            ]);
            $start_date = Carbon::parse($request->tanggal_mulai)->format('Y-m-d');
            $end_date = Carbon::parse($request->tanggal_akhir)->format('Y-m-d');
        } else {
            $start_date = Carbon::now()->format('Y-m-d');
            $end_date = Carbon::now()->format('Y-m-d');
        }

        $title = 'Laporan Penjualan';

        $breadcrumb = [[
            'target' => route('dashboard'),
            'label'  => 'Dashboard'
        ], [
            'target' => '',
            'label'  => 'Laporan Penjualan'
        ]];

        $report = Selling::orderBy('created_at', 'desc')
            ->where('user_id', auth()->user()->id)
            ->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
            ->get();

        $start_date = Carbon::parse($start_date)->format('d-m-Y');
        $end_date = Carbon::parse($end_date)->format('d-m-Y');

        $data = [
            'title'         => $title,
            'breadcrumb'    => $breadcrumb,
            'report'        => $report,
            'start_date'    => $start_date,
            'end_date'      => $end_date
        ];

        return view('report.selling.index', compact('data'));
    }

    public function sellingDetail($code)
    {

        $report = Selling::where('code', $code)
            ->with('details')
            ->first();

        $title = "Detail Laporan Penjualan ($report->code)";

        $breadcrumb = [[
            'target' => route('dashboard'),
            'label'  => 'Dashboard'
        ], [
            'target' => route('report.selling'),
            'label'  => 'Laporan Penjualan'
        ], [
            'target'    => '',
            'label'     => 'Detail Laporan Penjualan'
        ]];

        $data = [
            'title'         => $title,
            'breadcrumb'    => $breadcrumb,
            'report'        => $report
        ];

        return view('report.selling.detail', compact('data'));
    }
}
