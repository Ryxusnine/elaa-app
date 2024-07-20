@extends('layout.layout')
@section('content')
<div class="card p-5 m-5">
    @session('alert.berhasil')
        <div class="alert alert-success alert-dismissible" role="alert">
            Data Berhasil Ditambahkan!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endsession
    <div class="table-responsive text-nowrap">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Ulasan</th>
            <th class="text-center">Sentimen</th>
            <th class="text-center">Hasil Analisis</th>
            <th class="text-center">Create At</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @php
              $no = 1;
          @endphp
            @foreach ($viewanalisis as $data)
            <tr>
              <td style="white-space: wrap">{{$no++}}</td>
              <td style="white-space: wrap">{{$data->ulasan}}</td>
                <td class="text-center">
                  <span class="badge {{ strtoupper($data->sentimen) == 'NETRAL' ? 'bg-dark' : (strtoupper($data->sentimen) == 'NEGATIVE' ? 'bg-danger' : 'bg-success') }}">{{ strtoupper($data->sentimen) }}</span>
                </td>
                <td class="text-center">
                  <span class="badge {{ strtoupper($data->analisis) == 'NETRAL' ? 'bg-dark' : (strtoupper($data->analisis) == 'NEGATIVE' ? 'bg-danger' : 'bg-success') }}">{{ strtoupper($data->analisis) }}</span>
                </td>
              <td class="text-center">{{$data->created_at?->format('d-M-Y')}}</td>
            </tr>
            @endforeach
        </tbody>
      </table>

      <div class="d-flex justify-content-center mt-5">
        {{ $viewanalisis->links() }}
      </div>
    </div>
  </div>
@endsection