@extends('layouts.main-layout')
@section('content-class')
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
@endsection

@section('content-child')
<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <h2 class="card-title">List Produk</h2>
      <div class="card-tools">
        <a class="btn btn-primary" href="/product/create">
            <i class="fas fa-plus-circle"></i> Tambah
        </a>
      </div>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-striped table-bordered table-sm " id="table-product">
        <thead>
          <tr>
            <th>Barcode</th>
            <th>Nama</th>
            <th>Satuan</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
@endsection

@section('content-script')
<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script>
  $(document).ready(function(){
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
          data:"is_active",
          defaultContent:"--",
          mRender:function(data,type,full){
            // return `<div class="badge badge-${data==1?'success':'danger'}">${data==1?'Aktif':'Tidak Aktif'}</div>`
            return `<div class="custom-control custom-switch">
                      <input type="checkbox" ${data?'checked':''} name="my-switch" class="custom-control-input" id="switch-${full.id}">
                      <label class="custom-control-label" for="switch-${full.id}"></label>
                    </div>`
          }
        },
        {
					data: 'id',
					mRender: function(data, type, full) {
						return `<a href="/product/${full.barcode}/edit" title="Edit" class="btn btn-sm bg-gradient-primary edit-product"><i class="fas fa-edit"></i></a>
                <form action="/product/${full.barcode}" method="POST" class="d-inline">
                  @method('DELETE')
                  @csrf
                  <button title="${full.is_active ==1?'Non Aktifkan':'Aktifkan'}" onclick="return confirm('Apakah Yakin Ingin ${full.is_active ==1?'Non Aktifkan':'Mengaktifkan'} Produk ini?')" class="btn btn-sm ${full.is_active ==1?'bg-gradient-danger':'bg-gradient-primary'}">
                    ${full.is_active ==1?'<i class="fas fa-times"></i>':'<i class="fas fa-check"></i>'}
                  </button>
                </form>`
					}
				}
      ],
      columnDefs: [
          { 
            className: "text-center",
            targets: [2,3,5,6]
          },
          { 
            className: "text-right",
            targets: [4]
          },
        ],
      order:[[1,'asc']]
    })
    $('div.dataTables_filter input', tblProduct.table().container()).focus();

    $('#table-product').on('click','.custom-control-input',function() {
      let bool = $(this).prop('checked');
      let data = tblProduct.row($(this).parents('tr')).data();
      data.is_active = bool?1:0;
      data.category_id = data.category.id;
      data.uom_id = data.uom.id;
      data["_token"]= "{{ csrf_token() }}";
      $.ajax({
          url:`{{URL::to('/product/status')}}`,
          type:"PUT",
          data:data,
          dataType:"json",
          success:function (item) {
            tblProduct.clear().draw();
          },
          error:function(params){
            console.log(params)
          }
      })
    })
  })
</script>
@endsection