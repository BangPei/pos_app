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
@include('component.base')
@endsection

@section('content-script')
<script src="/plugins/jquery-blockUI/js/jquery.blockUI.js"></script>
<script src="js/script.js"></script>
<script>
    $(document).ready(function(){
        ajax(null, `${baseApi}/shopee-order`, "GET",
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