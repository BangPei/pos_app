@extends('layouts.main-layout')
@section('content-class')
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
@endsection

@section('content-child')
<div class="col-md-12">
    @if (session()->has('message'))
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">{{ session('message') }}</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                </button>
            </div>
            <!-- /.card-tools -->
        </div>
    </div>
    @endif
</div>
<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <h2 class="card-title">Daftar Sku Online Shope</h2>
      <div class="card-tools">
        <a class="btn btn-primary" href="sku/create">
          <i class="fas fa-plus-circle"></i> Tambah
        </a>
      </div>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-striped table-bordered table-sm " id="table-uom">
        <thead>
          <tr>
            <th>Code</th>
            <th>Nama</th>
            <th>Total Produk</th>
            <th>Aksi</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
@include('component.modal-description')
@endsection

@section('content-script')
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="js/script.js"></script>

@endsection