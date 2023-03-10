<?php

namespace App\Http\Controllers;

use App\Models\Selling;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function selling()
    {
        $transaction = Selling::where('user_id', auth()->user()->id)
            ->latest('created_at')
            ->with('details')
            ->first();
        $data = [
            'store'     => [
                'name' => auth()->user()->store->name,
                'address' => auth()->user()->store->address
            ],
            'transaction'      => $transaction
        ];
        return view('print.selling', compact('data'));
    }

    public function sellingPrint($code)
    {
        $transaction = Selling::where('user_id', auth()->user()->id)
            ->where('code', $code)
            ->with('details');
        if ($transaction->count()) {
            $data = [
                'store'     => [
                    'name' => auth()->user()->store->name,
                    'address' => auth()->user()->store->address
                ],
                'transaction'      => $transaction->first()
            ];
            return view('print.selling', compact('data'));
        } else {
            abort(404);
        }
    }
}
