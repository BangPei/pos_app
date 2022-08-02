@extends('layouts.main-layout')
@section('content-class')
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
@endsection

@section('content-child')
<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <h2 class="card-title">Form Penjualan</h2>
      <div class="card-tools">
        <a class="btn btn-primary" id="btn-product" data-toggle="modal" data-target="#modal-product" data-backdrop="static" data-keyboard="false">
          <i class="fas fa-eye"></i> List Product
        </a>
      </div>
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
                <th>Diskon</th>
                <th>#</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-product" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title">List Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body table-responsive">
        <table class="table table-striped table-bordered" id="table-product">
          <thead>
            <tr>
              <th>Barcode</th>
              <th>Nama</th>
              <th>Satuan</th>
              <th>Kategori</th>
              <th>Harga</th>
              <th>Aksi</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection

@section('content-script')
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script>
  let dsDetail = [];
  $(document).ready(function(){
    tblOrder = $('#table-order').DataTable({
      paging: false,
      searching: false,
      ordering:  false,
      select: true,
      data:dsDetail,
      columns:[
        {
          data:null,
          defaultContent:"--"
        },
        {
          data:"product.name",
          defaultContent:"--"
        },
        {
          data:"product.uom.name",
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
          data:"discount",
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
            targets: [3,4,5,6]
          },
        ],
    })

    tblProduct = $('#table-product').DataTable({
      processing:true,
      serverSide:true,
      ajax:{
        url:"{{ route('product.index') }}",
        type:"GET",
      },
      columns:[
        {
          data:"barcode",
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
          data:"category.name",
          defaultContent:"--"
        },
        {
          data:"price",
          defaultContent:"0",
          mRender:function(data,type,full){
            return `Rp. ${formatNumber(data)}`
          }
        },
        {
					data: 'id',
					mRender: function(data, type, full) {
						return `<a href="/product/${full.barcode}/edit" title="Edit" class="btn bg-gradient-success edit-product"><i class="fas fa-edit"></i></a>
                <form action="/product/${full.barcode}" method="POST" class="d-inline">
                  @method('DELETE')
                  @csrf
                  <button title="${full.is_active ==1?'Non Aktifkan':'Aktifkan'}" onclick="return confirm('Apakah Yakin Ingin ${full.is_active ==1?'Non Aktifkan':'Mengaktifkan'} Produk ini?')" class="btn ${full.is_active ==1?'bg-gradient-danger':'bg-gradient-primary'}">
                    ${full.is_active ==1?'<i class="fas fa-times"></i>':'<i class="fas fa-check"></i>'}
                  </button>
                </form>`
					}
				}
      ],
      columnDefs: [
          { 
            className: "text-center",
            targets: [2,3,5]
          },
        ],
    })
    $('div.dataTables_filter input', tblProduct.table().container()).focus();
  })
</script>
@endsection
