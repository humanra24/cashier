<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Pengguna";
        $breadcrumb = [[
            'target' => route('admin-dashboard'),
            'label'  => 'Dashboard'
        ], [
            'target' => '',
            'label'  => 'Pengguna'
        ]];
        $btn = [
            "label"     => "Tambah User",
            'target'    => route('user.create')
        ];
        $user = User::where('level', 1)->orderBy('created_at', 'desc')->with('store')->get();
        $data = [
            'title'         => $title,
            'breadcrumb'    => $breadcrumb,
            'user'          => $user,
            'btn'           => $btn
        ];
        return view('admin.user.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Tambah Pengguna';
        $breadcrumb = [[
            'target' => route('dashboard'),
            'label'  => 'Dashboard'
        ], [
            'target' => route('user.index'),
            'label'  => 'Pengguna'
        ], [
            'target' => '',
            'label'  => 'Tambah'
        ]];

        $data = [
            'title'         => $title,
            'breadcrumb'    => $breadcrumb
        ];

        return view('admin.user.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "nama_pengguna" => 'required',
            "email" => 'required|email|unique:users,email',
            "password" => 'required|min:5|confirmed',
            "nama_toko" => 'required',
            "telegram" => 'required|regex:/(0)[0-9]{9}/|unique:stores,telegram',
            "alamat" => 'required',
        ]);

        $user = User::create([
            "name"  => $request->nama_pengguna,
            "email" => $request->email,
            "password"  => Hash::make($request->password)
        ]);

        Store::create([
            "name"  => $request->nama_toko,
            "telegram"  => $request->telegram,
            "address"   => $request->alamat,
            "user_id"   => $user->id
        ]);

        return redirect()->route('user.index')->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $title = 'Ubah Pengguna';
        $breadcrumb = [[
            'target' => route('dashboard'),
            'label'  => 'Dashboard'
        ], [
            'target' => route('user.index'),
            'label'  => 'Pengguna'
        ], [
            'target' => '',
            'label'  => 'Ubah'
        ]];

        $data = [
            'title'         => $title,
            'breadcrumb'    => $breadcrumb,
            'user'          => $user
        ];

        return view('admin.user.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            "nama_pengguna" => 'required',
            "email" => 'required|email|unique:users,email,' . $user->id . ',id',
            "password" => 'nullable|min:5|confirmed',
            "nama_toko" => 'required',
            "telegram" => 'required|regex:/(0)[0-9]{9}/|unique:stores,telegram,' . $user->id . ',user_id',
            "alamat" => 'required',
        ]);

        if ($request->password) {
            $user->update([
                "password"  => Hash::make($request->password)
            ]);
        }

        $store = Store::where('user_id', $user->id)->first();

        $user->update([
            "name"  => $request->nama_pengguna,
            "email" => $request->email,
        ]);

        $store->update([
            "name"  => $request->nama_toko,
            "telegram"  => $request->telegram,
            "address"   => $request->alamat,
        ]);

        return redirect()->route('user.index')->with('success', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success', 'Data berhasil dihapus!');
    }
}
