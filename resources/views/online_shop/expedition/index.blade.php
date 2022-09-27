@extends('layouts.main-layout')
@section('content-class')
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
@endsection

@section('content-child')
<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <h2 class="card-title">List Expedisi</h2>
      <div class="card-tools">
        <a class="btn btn-primary" data-toggle="modal" data-target="#modal-expedition" data-backdrop="static" data-keyboard="false">
            <i class="fas fa-plus-circle"></i> Tambah
        </a>
      </div>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-striped table-bordered table-sm " id="table-expedition">
        <thead>
          <tr>
            <th>Expedisi</th>
            <th>Alias</th>
            <th>Sumber</th>
            <th>Aksi</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-expedition" tabindex="-1">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title">Form Expedisi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-expedition" form-validate=true>
          <div class="row">
            <div class="col-12">
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="expedition">Nama Expedisi</label>
                    <input required type="text" class="form-control" id="expedition" name="expedition" placeholder="Nama Expedisi">
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="alias">Alias</label>
                    <input required type="text" class="form-control" id="alias" name="alias" placeholder="Nama Expedisi">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <div class="form-group">
                    <label for="description" class="col-form-label">Sumber Platform</label>
                    <textarea placeholder="Online Shop" class="form-control" name="description" id="description"></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 text-right">
              <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@include('component.base')
@endsection

@section('content-script')
<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script>
  let expeditionId;
  $(document).ready(function(){
    tblExpedition = $('#table-expedition').DataTable({
        processing:true,
        serverSide:true,
        ajax:{
            url:"{{ route('expedition.index') }}",
            type:"GET",
        },
        columns:[
            {
                data:"name",
                defaultContent:"--"
            },
            {
                data:"alias",
                defaultContent:"--"
            },
            {
                data:"description",
                defaultContent:"--"
            },
            {
	    	    data: 'id',
	    	    mRender: function(data, type, full) {
	    	        return `<a data-toggle="modal" data-target="#modal-expedition" data-backdrop="static" data-keyboard="false" title="Edit" class="btn btn-sm bg-gradient-primary edit-expedition"><i class="fas fa-edit"></i></a>`
	    	    }
	    	}
        ],
        order:[[0,'asc']]
    })
    $('#table-expedition').on('click','.edit-expedition',function() {
      let data = tblExpedition.row($(this).parents('tr')).data();
      expeditionId = data.id;
      $('#expedition').val(data.name??'--');
      $('#description').val(data.description??'--');
      $('#alias').val(data.alias??'--');
      console.log(data);

    })

    saveExpedition();
  })

  function saveExpedition() {
      formValid($('#form-expedition'),function(){
        let method = expeditionId?"PUT":"POST"
        let expedition = {
          id:expeditionId,
          name:$('#expedition').val(),
          description:$('#description').val(),
          alias:$('#alias').val(),
        }
        let url = expeditionId?`${baseApi}/expedition/${expedition.id}`:`${baseApi}/expedition`
        ajax(expedition, url, method,
          function(json) {
            toastr.success('Data Berhasil Diprosess')
            setTimeout(() => {
                location.reload()
            }, 1000);
          })
      })
  }
</script>
@endsection