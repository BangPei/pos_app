@extends('layouts.main-layout')
@section('content-class')
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
@endsection

@section('content-child')
<div class="col-md-12">
    @if (session()->has('message'))
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">{{ session('message') }}</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                </button>
            </div>
            <!-- /.card-tools -->
        </div>
    </div>
    @endif
</div>
<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <h2 class="card-title">List Satuan</h2>
      <div class="card-tools">
        <a class="btn btn-primary" id="btn-add" data-toggle="modal" data-target="#modal-description" data-backdrop="static" data-keyboard="false">
          <i class="fas fa-plus-circle"></i> Tambah
        </a>
      </div>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-striped table-bordered table-sm " id="table-uom">
        <thead>
          <tr>
            <th>Kategori</th>
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
    tblUom=$('#table-uom').DataTable({
      processing:true,
      serverSide:true,
      ajax:{
        url:"{{ route('uom.index') }}",
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
						return `<a data-toggle="modal" data-target="#modal-description" title="Edit" class="btn bg-gradient-success edit-uom"><i class="fas fa-edit"></i></a>
                <form action="/uom/${data}" method="POST" class="d-inline">
                  @method('DELETE')
                  @csrf
                  <button title="${full.is_active ==1?'Non Aktifkan':'Aktifkan'}" onclick="return confirm('Apakah Yakin Ingin ${full.is_active ==1?'Non Aktifkan':'Mengaktifkan'} Satuan ini?')" class="btn ${full.is_active ==1?'bg-gradient-danger':'bg-gradient-primary'}">
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
    $('div.dataTables_filter input', tblUom.table().container()).focus();
    $('#table-uom').on('click','.edit-uom',function() {
      let data = tblUom.row($(this).parents('tr')).data();
      $('#id').val(data.id??'--');
      $('#name').val(data.name??'--');
      $('#description').val(data.description??'');
      $('#form-method').append(`
        @method('put')
      `)
      $('#form-description').attr('action',`/uom/${data.id}`)
    })

    $('#btn-add').on('click',function(){
      $('#form-description').attr('action','/uom')
      $('#form-method').append(`
        @method('post')
      `)
    })
  })
</script>
@endsection