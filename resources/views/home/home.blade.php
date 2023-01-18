@extends('layouts.main-layout')

@section('content-child')
{{-- <h1>Dashboard</h1> --}}
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