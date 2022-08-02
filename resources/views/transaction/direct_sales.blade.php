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
        <div class="col-md-4 col-sm-12">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <input type="text" name="barcode-1" autofocus placeholder="Scann Barcode" class="form-control">
              </div>
            </div>
          </div>
          <hr style="margin:0 !important">
          <div class="row pt-1">
            <div class="col-sm-12">
              <div class="form-group">
                <input type="text" name="barcode-2" autofocus placeholder="Scann Barcode" class="form-control">
              </div>
            </div>
            <div class="col-md-8 col-sm-12">
              <div class="form-group">
                <input type="text" name="name" readonly autofocus placeholder="Nama Barang" class="form-control">
              </div>
            </div>
            <div class="col-md-4 col-sm-12">
              <div class="form-group">
                <input type="text" name="qty" autofocus placeholder="Qty" class="form-control">
              </div>
            </div>
            <div class="col-sm-12"><a href="#" class="btn btn-block btn-primary">input</a></div>
          </div>
        </div>
        <div class="col-md-8 col-sm-12">
          <table class="table table-striped table-bordered table-sm " id="table-order">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Satuan</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('content-script')
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script>
  $(document).ready(function(){
    tblOrder = $('#table-order').DataTable({
      paging: false,
      searching: false,
      ordering:  false,
      select: true,
      columns:[
        {
          data:null,
          defaultContent:"--"
        },
        {
          data:"name",
          defaultContent:"--"
        },
        {
          data:"uom.name",
          defaultContent:"--"
        },
        {
          data:"qty",
          defaultContent:"0"
        },
        {
          data:"price",
          defaultContent:"0",
          mRender:function(data,type,full){
            return `Rp. ${formatNumber(data)}`
          }
        },
        {
          data:"total",
          defaultContent:"0",
          mRender:function(data,type,full){
            return `Rp. ${formatNumber(data)}`
          }
        },
        {
					data: null,
					mRender: function(data, type, full) {
						return `<a href="#" title="Hapus" class="btn bg-gradient-danger delete-product"><i class="fas fa-trash"></i></a>`
					}
				}
      ],
      columnDefs: [
          { 
            className: "text-right",
            targets: [3,4,5]
          },
        ],
    })
  })
</script>
@endsection
