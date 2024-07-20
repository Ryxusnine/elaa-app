@extends('layout.layout')
@section('content')
<div class="m-5">

  @if(session('prediction'))
    <div class="flex-grow-1 container-p-y m-5">
      <div class="row">
        <div class="col-lg-4">
          <div class="card">
            <div class="card-body text-center py-5">
              <h4 class="mb-3">Hasil Prediksi Sentimen</h4>
              <h2>{{ strtoupper(session('prediction')['analisis'] ) }}</h2>
            </div>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="card h-100">
            <div class="card-body text-center py-5 d-flex align-items-center">
              <h4 class="mb-3 w-100">
                "{{ session('prediction')['ulasan'] }}"
              </h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif

  <div class="flex-grow-1 container-p-y m-5">
    <div class="row">
        <div class="col-lg-12">
          <div class="h3">Input Data Analisis</div>
          <div class="card">
              <div class="p-3">
                  <div class="card-body">
                      <form action="{{route('dashboard.analisis')}}" method="POST">
                          @csrf
                          <label class="mb-2">Isi komentar anda sebagai data analisis sentimen kami</label>
                          <textarea class="form-control mb-3" id="" cols="30" rows="6" name="ulasan"></textarea>
                          
                          <label class="mb-2">Sentimen</label>
                          <select name="sentimen" class="form-control mb-3">
                            <option value="netral">Netral</option>
                            <option value="negative">Negatif</option>
                            <option value="positive">Positif</option>
                          </select>
      
                          <button type="submit" class="btn btn-success text-dark">Tambah</button>
                      </form>
                    </div>
                  </div>
              </div>
          </div>  
        </div>
    </div>
    
    <div class="row mx-5">
      <div class="col-lg-6">
        <div class="card p-5 mt-0">
          <h5 class="card-header m-0 me-2 pb-3">Total Sentimen</h5>
          <div 
            data-positive="{{ $sentimen['positive'] }}"
            data-negative="{{ $sentimen['negative'] }}"
            data-netral="{{ $sentimen['netral'] }}"
            id="totalSentimen" 
            class="px-2"></div>
        </div>
      </div>
  
      <div class="col-lg-6">
        <div class="card p-5 mt-0">
          <h5 class="card-header m-0 me-2 pb-3">Total Hasil Analisis</h5>
          <div 
            data-positive="{{ $analisis['positive'] }}"
            data-negative="{{ $analisis['negative'] }}"
            data-netral="{{ $analisis['netral'] }}"
            id="totalAnalisis" 
            class="px-2"></div>
        </div>
      </div>
    </div>
</div>
@endsection