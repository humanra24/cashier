@extends('base.index')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('account.change-password') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="passwordSekarang" class="form-label">Password Sekarang</label>
                            <input type="password" class="form-control  @error('password_sekarang') is-invalid @enderror"
                                id="passwordSekarang" name="password_sekarang" value="{{ old('password_sekarang') }}"
                                aria-describedby="passwordSekarangHelp">
                            @error('password_sekarang')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="passwordBaru" class="form-label">Password Baru</label>
                            <input type="password" class="form-control @error('password_baru') is-invalid @enderror"
                                id="passwordBaru" name="password_baru" aria-describedby="passwordBaruHelp">
                            @error('password_baru')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="PasswordBaru" class="form-label">Konfirmasi Password Sekarang</label>
                            <input type="password" class="form-control" id="PasswordBaruConfirmation"
                                name="password_baru_confirmation" aria-describedby="PasswordBaruConfirmationHelp">
                        </div>
                        <div class="d-grid d-md-flex">
                            <button type="submit" class="btn btn-primary">Ganti Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
