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
            data:"name",
            defaultContent:"--"
          },
          {
            data:"name",
            defaultContent:"--",
          },
          {
            data:"name",
            defaultContent:"--",
          },
          {
              data: 'id',
              mRender: function(data, type, full) {
                  return `<a data-toggle="modal" data-target="#modal-description" title="Edit" class="btn bg-gradient-success edit-atm"><i class="fas fa-edit"></i></a>
                  <form action="/bank/${data}" method="POST" class="d-inline">
                  @method('DELETE')
                  @csrf
                  <button title="${full.is_active ==1?'Non Aktifkan':'Aktifkan'}" onclick="return confirm('Apakah Yakin Ingin ${full.is_active ==1?'Non Aktifkan':'Mengaktifkan'} Kategory ini?')" class="btn ${full.is_active ==1?'bg-gradient-danger':'bg-gradient-primary'}">
                      ${full.is_active ==1?'<i class="fas fa-times"></i>':'<i class="fas fa-check"></i>'}
                  </button>
                  </form>`
              }
          }
        ],
      })
    })
  </script>
@endsection