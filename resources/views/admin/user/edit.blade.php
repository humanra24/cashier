@extends('admin.base.index')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('user.update', ['user' => $data['user']->id]) }}" method="post">
                        @method('put')
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <h3>Pengguna</h3>
                                <div class="mb-3">
                                    <label for="nama_pengguna" class="form-label">Nama Pengguna<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama_pengguna') is-invalid @enderror"
                                        id="nama_pengguna" name="nama_pengguna" aria-describedby="nama_penggunaHelp"
                                        value="{{ old('nama_pengguna', $data['user']->name) }}" />
                                    @error('nama_pengguna')
                                        <div id="nama_penggunaHelp" class="form-text text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control @error('email')
                                        is-invalid
                                    @enderror"
                                        id="email" name="email" aria-describedby="emailHelp"
                                        value="{{ old('email', $data['user']->email) }}" />
                                    @error('email')
                                        <div id="emailHelp" class="form-text text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password<span
                                            class="text-danger">*</span></label>
                                    <input type="password"
                                        class="form-control @error('password')
                                        is-invalid
                                    @enderror"
                                        id="password" name="password" aria-describedby="passwordHelp" />
                                    @error('password')
                                        <div id="passwordHelp" class="form-text text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password<span
                                            class="text-danger">*</span></label>
                                    <input type="password"
                                        class="form-control @error('password_confirmation')
                                        is-invalid
                                    @enderror"
                                        id="password_confirmation" name="password_confirmation"
                                        aria-describedby="password_confirmationHelp" />
                                    @error('password_confirmation')
                                        <div id="password_confirmationHelp" class="form-text text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h3>Toko</h3>
                                <div class="mb-3">
                                    <label for="nama_toko" class="form-label">Nama Toko<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama_toko') is-invalid @enderror"
                                        id="nama_toko" name="nama_toko" aria-describedby="nama_tokoHelp"
                                        value="{{ old('nama_toko', $data['user']->store->name) }}" />
                                    @error('nama_toko')
                                        <div id="nama_tokoHelp" class="form-text text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="telegram" class="form-label">Telegram<span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control @error('telegram')
                                        is-invalid
                                    @enderror"
                                        id="telegram" name="telegram" aria-describedby="telegramHelp"
                                        value="{{ old('telegram', $data['user']->store->telegram) }}" />
                                    @error('telegram')
                                        <div id="telegramHelp" class="form-text text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat<span
                                            class="text-danger">*</span></label>
                                    <textarea name="alamat" id="" rows="4"
                                        class="form-control @error('alamat')
                                    is-invalid
                                @enderror">{{ old('alamat', $data['user']->store->address) }}</textarea>
                                    @error('alamat')
                                        <div id="alamatHelp" class="form-text text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="d-grid d-md-flex gap-2 mt-3">
                            <button type="submit" class="btn btn-primary">Ubah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
