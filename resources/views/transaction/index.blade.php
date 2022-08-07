@extends('layouts.main-layout')
@section('content-class')
  <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
@endsection

@section('content-child')
<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <h2 class="card-title">List Transaksi Keluar</h2>
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
            <th>Pembeli</th>
            <th>Total Item</th>
            <th>Total</th>
            <th>Kasir</th>
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
        url:"{{ route('transaction.index') }}",
        type:"GET",
      },
      columns:[
        {
            data:"code",
            defaultContent:"--"
        },
        {
            data:"created_at",
            defaultContent:"--",
            className:"text-center",
            mRender:function(data, type,full){
                return moment().format("DD MMMM YYYY HH:mm:ss")
            }
        },
        {
            data:"customer_name",
            defaultContent:"--"
        },
        {
            data:"total_item",
            defaultContent:"--"
        },
        {
            data:"amount",
            defaultContent:"0",
            mRender:function(data,type,full){
                return `Rp. ${formatNumber(data)}`
            }
        },
        {
            data:"created_by.name",
            defaultContent:"--",
        },
        {
		    data: 'id',
			mRender: function(data, type, full) {
				return `<a href="/transaction/${full.code}/show" title="Edit" class="btn bg-gradient-success edit-product"><i class="fas fa-edit"></i></a></form>`
				}
			}
        ],
        columnDefs: [
            { 
                className: "text-center",
                targets: [1,2,3,5]
            },
            { 
                className: "text-right",
                targets: [4]
            },
        ],
        order:[[1,'desc']]
    })
    $('div.dataTables_filter input', tblProduct.table().container()).focus();
  })
</script>
@endsection