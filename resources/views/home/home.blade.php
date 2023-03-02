@extends('layouts.main-layout')

@section('content-child')
<div class="col-lg-3 col-6">
  <!-- small box -->
  <div class="small-box bg-info">
    <div class="inner">
      <h3>{{ number_format($subtotal) }}</h3>

      <p>New Orders</p>
    </div>
    <div class="icon">
      <i class="ion ion-bag"></i>
    </div>
    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
  </div>
</div>
<div class="col-lg-3 col-6">
  <!-- small box -->
  <div class="small-box bg-info">
    <div class="inner">
      <h3>150</h3>

      <p>New Orders</p>
    </div>
    <div class="icon">
      <i class="ion ion-bag"></i>
    </div>
    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
  </div>
</div>
<div class="col-lg-3 col-6">
  <!-- small box -->
  <div class="small-box bg-info">
    <div class="inner">
      <h3>150</h3>

      <p>New Orders</p>
    </div>
    <div class="icon">
      <i class="ion ion-bag"></i>
    </div>
    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
  </div>
</div>
<div class="col-lg-3 col-6">
  <!-- small box -->
  <div class="small-box bg-info">
    <div class="inner">
      <h3>150</h3>

      <p>New Orders</p>
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
        ajax(null, `${baseApi}/tiktok-order`, "GET",
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