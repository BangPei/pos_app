@extends('layouts.main-layout')
@section('content-class')
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
@endsection

@section('content-child')
<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <h2 class="card-title">Form Penjualan</h2>
      {{-- <div class="card-tools">
        <a class="btn btn-primary" id="btn-add" data-toggle="modal" data-target="#modal-description" data-backdrop="static" data-keyboard="false">
          <i class="fas fa-plus-circle"></i> Tambah
        </a>
      </div> --}}
    </div>
    <div class="card-body table-responsive">
      <div class="row">
        <div class="col-4">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <input type="text" name="barcode-1" autofocus placeholder="Scann Barcode" class="form-control">
              </div>
            </div>
          </div>
          <hr style="margin:0 !important">
          <div class="row">

          </div>
        </div>
        <div class="col-8"></div>
      </div>
    </div>
  </div>
</div>

@endsection
