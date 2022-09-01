@extends('layouts.main-layout')
@section('content-class')
  <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
@endsection

@section('content-child')
<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <h2 class="card-title">List Pembelian Barang</h2>
      <div class="card-tools">
        <a class="btn btn-primary" href="/transaction/create">
            <i class="fas fa-plus-circle"></i> Tambah
        </a>
      </div>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-striped table-bordered table-sm " id="table-order">
        <thead>
          <tr>
            <th>Code</th>
            <th>Tanggal</th>
            <th>Supplier</th>
            <th>No. Tlp</th>
            <th>Total Item</th>
            <th>Total</th>
            <th>Aksi</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
@endsection

@section('content-script')
<script src="/plugins/moment/moment.min.js"></script>
<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script>
  $(document).ready(function(){
    tblProduct = $('#table-order').DataTable({
      processing:true,
      serverSide:true,
      ajax:{
        url:"{{ route('purchase-order.index') }}",
        type:"GET",
      },
      columns:[
        {
            data:"code",
            defaultContent:"--"
        },
        {
            data:"date_time",
            defaultContent:"--",
            mRender:function(data, type,full){
                return moment(data).format("DD MMMM YYYY HH:mm")
            }
        },
        {
            data:"supplier.name",
            defaultContent:"--"
        },
        {
            data:"supplier.phone",
            defaultContent:"--"
        },
        {
            data:"total_item",
            defaultContent:"0",
            mRender:function(data,type,full){
                return `Rp. ${formatNumber(data)}`
            }
        },
        {
            data:"amount",
            defaultContent:"0",
            mRender:function(data,type,full){
                return `Rp. ${formatNumber(data)}`
            }
        },
        
        {
            data: 'id',
            mRender: function(data, type, full) {
                return `<a href="/purchase-order/${full.code}/edit" title="Edit" class="btn btn-sm bg-gradient-primary edit-product"><i class="fas fa-edit"></i></a></form>`
            }
        }
        ],
        order:[[1,'desc']]
    })
    $('div.dataTables_filter input', tblProduct.table().container()).focus();
  })
</script>
@endsection