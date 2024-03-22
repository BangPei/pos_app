@extends('layouts.main-layout')
@section('content-class')
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
@endsection

@section('content-child')
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
      <table class="table table-striped table-bordered table-sm " id="table-sku">
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
<script>

  $(document).ready(function(){
    tblSku = $('#table-sku').DataTable({
      processing:true,
      serverSide:true,
      ajax:{
        url:"{{ route('sku.index') }}",
        type:"GET",
      },
      columns:[
          {
              data:"code",
              defaultContent:"--"
          },
          {
              data:"name",
              defaultContent:"--",
          },
          {
              data:"total_item",
              defaultContent:"--"
          },
          {
              data: 'id',
              mRender: function(data, type, full) {
                  return `<a href="/sku/${data}/edit" title="Edit" class="btn btn-sm bg-gradient-primary edit-sku"><i class="fas fa-edit"></i></a></form>`
              }
          }
        ],
    })
  })

</script>

@endsection