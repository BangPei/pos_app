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
            <th>Nama</th>
            <th>Kategori</th>
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
          data:"name",
          defaultContent:"--"
        },
        {
          data:"category.name",
          defaultContent:"--"
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
						return `<a href="/product/${full.id}/edit" title="Edit" class="btn btn-sm bg-gradient-primary edit-product"><i class="fas fa-edit"></i></a>`
					}
				}
      ],
      columnDefs: [
          { 
            className: "text-center",
            targets: [1,2,3]
          },
        ],
      order:[[3,'desc'],[0,'asc']]
    })
    $('div.dataTables_filter input', tblProduct.table().container()).focus();

    $('#table-product').on('click','.custom-control-input',function() {
      let bool = $(this).prop('checked');
      let data = tblProduct.row($(this).parents('tr')).data();
      data.is_active = bool?1:0;
      data.category_id = data.category.id;
      ajax(data, `{{URL::to('/product/status')}}`, "PUT",
          function(json) {
            tblProduct.clear().draw();
      })
    })
  })
</script>
@endsection