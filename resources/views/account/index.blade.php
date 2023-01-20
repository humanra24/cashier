@extends('base.index')

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
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Pengguna</h3>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Pengguna</label>
                                <input type="text" disabled value="{{ auth()->user()->name }}" class="form-control"
                                    id="name" name="name" aria-describedby="nameHelp">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Pengguna</label>
                                <input type="email" disabled value="{{ auth()->user()->email }}" class="form-control"
                                    id="email" name="email" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <a href="{{ route('account.change-password') }}">Ganti Password</a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h3>Toko</h3>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Toko</label>
                                <input type="text" disabled value="{{ auth()->user()->store->name }}"
                                    class="form-control" id="name" name="name" aria-describedby="nameHelp">
                            </div>
                            <div class="mb-3">
                                <label for="telegram" class="form-label">Nomor Telegram</label>
                                <input type="text" disabled value="{{ auth()->user()->store->telegram }}"
                                    class="form-control" id="telegram" name="telegram" aria-describedby="telegramHelp">
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <textarea name="address" disabled id="address" class="form-control" rows="5">{{ auth()->user()->store->address }}</textarea>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
