@extends('layout.layout')
@section('content')
<div class="m-5">
  <div class="flex-grow-1 container-p-y m-5">
    <div class="h3">Kritik dan Saran</div>
    <div class="card">
        <div class="p-3">
            <div class="card-body">
                @session('alert.berhasil')
                    <div class="alert alert-success alert-dismissible" role="alert">
                    Data Berhasil Ditambahkan!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endsession
                <form action="{{route('inputdata.store')}}" method="POST">
                    @csrf
                    <label class="mb-2">Masukkan kritik dan saran anda</label>
                    <textarea class="form-control mb-3" id="" cols="30" rows="6" name="komentar"></textarea>
                    <button type="submit" class="btn btn-success text-dark">Simpan</button>
                </form>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection