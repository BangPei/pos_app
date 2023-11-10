@extends('layouts.main-layout')

@section('content-child')
<div class="col-lg-3 col-6">
  <!-- small box -->
  <div class="small-box bg-info">
    <div class="inner">
      <h3>Rp. {{ number_format($subtotal) }}</h3>
      <p>Pendapatan</p>
    </div>
    <div class="icon">
      <i class="fa fa-dollar-sign"></i>
    </div>
    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
  </div>
</div>
<div class="col-lg-3 col-6">
  <!-- small box -->
  <div class="small-box bg-success">
    <div class="inner">
      <h3>{{ number_format($totalOrder) }}</h3>

      <p>Total Transaksi</p>
    </div>
    <div class="icon">
      <i class="ion ion-bag"></i>
    </div>
    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
  </div>
</div>
<div class="col-lg-3 col-6">
  <!-- small box -->
  <div class="small-box bg-warning">
    <div class="inner">
      <h3>{{ number_format($totalProduct) }}</h3>

      <p>Total Produk</p>
    </div>
    <div class="icon">
      <i class="ion ion-bag"></i>
    </div>
    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
  </div>
</div>
<div class="col-lg-3 col-6">
  <!-- small box -->
  <div class="small-box bg-danger">
    <div class="inner">
      <h3>{{ number_format($stock) }}</h3>

      <p>Stok Habis</p>
    </div>
    <div class="icon">
      <i class="ion ion-bag"></i>
    </div>
    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
  </div>
</div>
<div class="col-12">
  <div class="row">
    <div class="col-lg-6 col-12">
      <div class="card">
        <div class="card-header">
          <h2 class="card-title">Penjualan Tahun - {{ date('Y', time()) }}</h2>
        </div>
        <div class="card-body">
          <table class="table table-sm">
            <thead>
              <tr>
                <th>No</th>
                <th>Bulan</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($trans[(string)date('Y', time())] as $tran)
               <tr>
                <td>{{ $loop->index+1}}</td>
                <td>{{ $tran['month'] }}</td>
                <td>{{ number_format($tran['amount']) }}</td>
               </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-lg-6 col-12">
      <div class="card">
        <div class="card-header">
          <h2 class="card-title">Penjualan Tahun - {{ date('Y', time())-1 }}</h2>
        </div>
        <div class="card-body">
          <table class="table table-sm">
            <thead>
              <tr>
                <th>No</th>
                <th>Bulan</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($trans[(string)(date('Y', time())-1)] as $tran)
               <tr>
                <td>{{ $loop->index+1}}</td>
                <td>{{ $tran['month'] }}</td>
                <td>{{ number_format($tran['amount']) }}</td>
               </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  {{-- <p>{{ $trans[(string)date('Y', time())] }}</p> --}}
</div>
@include('component.base')
@endsection

@section('content-script')
<script src="/plugins/jquery-blockUI/js/jquery.blockUI.js"></script>
<script src="js/script.js"></script>
<script>
    $(document).ready(function(){
        ajax(null, `${baseApi}/lazada-order`, "GET",
        function(json) {
            console.log(json)
          toastr.success('Berhasil')
          $.unblockUI()
        },
        function(err){
            console.log(err)
          toastr.error(err?.responseJSON?.message??"Tidak Dapat Mengakses Server")
          $.unblockUI()
        })
    })
</script>
@endsection