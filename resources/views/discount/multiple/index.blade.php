@extends('layouts.main-layout')
@section('content-class')
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
@endsection

@section('content-child')
<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <h2 class="card-title">Paket Diskon</h2>
      <div class="card-tools">
        <a class="btn btn-primary" href="/multiple-discount/create">
          <i class="fas fa-plus-circle"></i> Tambah
        </a>
      </div>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-striped table-bordered table-sm " id="table-discount">
        <thead>
          <tr>
            <th>Nama Promosi</th>
            <th>Paket</th>
            <th>Jumlah Produk</th>
            <th>Status</th>
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
<script>
    $(document).ready(function(){
      tableDiscount= $('#table-discount').DataTable({
        processing:true,
        serverSide:true,
        ajax:{
          url:"{{ route('multiple-discount.index') }}",
          type:"GET",
        },
        columns:[
          {
            data:"name",
            defaultContent:"--"
          },
          {
            data:"min_qty",
            defaultContent:"--",
            mRender:function(data,type,full){
              return `${data} Pcs - Diskon Rp. ${formatNumber(full.discount)}`
            }
          },
          {
            data:"details",
            defaultContent:"--",
            mRender:function(data,type,full){
              return `${data.length} Product`
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
                  return `<a href="/multiple-discount/${data}/edit" title="Edit" class="btn btn-sm bg-gradient-primary edit-discount"><i class="fas fa-edit"></i></a>`
              }
          }
        ],
      })
    })
  </script>
@endsection