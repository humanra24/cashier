@extends('admin.base.index')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div id="alert">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ session('success') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-striped" style="width:100%">
                            <thead>
                                <th>Pengguna</th>
                                <th>Email</th>
                                <th class="text-nowrap">Toko</th>
                                <th class="text-nowrap">Telegram</th>
                                <th>Alamat</th>
                                <th class="text-center" data-orderable="false">Aksi</th>
                            </thead>
                            <tbody>
                                @foreach ($data['user'] as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->store->name }}</td>
                                        <td>{{ $item->store->telegram }}</td>
                                        <td>{{ $item->store->address }}</td>
                                        <td class="text-center d-flex">
                                            <a href="{{ route('user.edit', ['user' => $item->id]) }}"
                                                class="text-warning me-3">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form class="deleteForm"
                                                action="{{ route('user.destroy', ['user' => $item->id]) }}" method="post">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="text-danger bg-transparent border-0"><i
                                                        class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
