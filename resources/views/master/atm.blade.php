@extends('layouts.main-layout')
@section('content-class')
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
@endsection

@section('content-child')
<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <h2 class="card-title">List Bank ATM</h2>
      <div class="card-tools">
        <a class="btn btn-primary" id="btn-add" data-toggle="modal" data-target="#modal-description" data-backdrop="static" data-keyboard="false">
          <i class="fas fa-plus-circle"></i> Tambah
        </a>
      </div>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-striped table-bordered table-sm " id="table-bank">
        <thead>
          <tr>
            <th>BANK</th>
            <th>Deskripsi</th>
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
    atmTable= $('#table-bank').DataTable({
      processing:true,
      serverSide:true,
      ajax:{
        url:"{{ route('atm.index') }}",
        type:"GET",
      },
      columns:[
        {
          data:"name",
          defaultContent:"--"
        },
        {
          data:"description",
          defaultContent:"--"
        },
        {
          data:"is_active",
          defaultContent:"--",
          mRender:function(data,type,full){
            return `<div class="badge badge-${data==1?'success':'danger'}">${data==1?'Aktif':'Tidak Aktif'}</div>`
          }
        },
        {
			data: 'id',
			mRender: function(data, type, full) {
				return `<a data-toggle="modal" data-target="#modal-description" title="Edit" class="btn bg-gradient-success edit-atm"><i class="fas fa-edit"></i></a>
                <form action="/atm/${data}" method="POST" class="d-inline">
                @method('DELETE')
                @csrf
                <button title="${full.is_active ==1?'Non Aktifkan':'Aktifkan'}" onclick="return confirm('Apakah Yakin Ingin ${full.is_active ==1?'Non Aktifkan':'Mengaktifkan'} Kategory ini?')" class="btn ${full.is_active ==1?'bg-gradient-danger':'bg-gradient-primary'}">
                    ${full.is_active ==1?'<i class="fas fa-times"></i>':'<i class="fas fa-check"></i>'}
                </button>
                </form>`
			}
		}
      ],
      columnDefs: [
          { 
            className: "text-center",
            targets: [2,3]
          },
        ],
      order:[[0,'asc']]
    })
    $('div.dataTables_filter input', atmTable.table().container()).focus();
    $('#table-bank').on('click','.edit-atm',function() {
      let data = atmTable.row($(this).parents('tr')).data();
      $('#id').val(data.id??'--');
      $('#name').val(data.name??'--');
      $('#description').val(data.description??'');
      $('#form-method').append(`
        @method('put')
      `)
      $('#form-description').attr('action',`/atm/${data.id}`)
    })

    $('#btn-add').on('click',function(){
      $('#form-description').attr('action','/atm')
      $('#form-method').append(`
        @method('post')
      `)
    })
  })
</script>
@endsection