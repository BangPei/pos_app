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
        <a class="btn btn-primary" href="/expedition/create">
            <i class="fas fa-plus-circle"></i> Tambah
        </a>
      </div>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-striped table-bordered table-sm " id="table-expedition">
        <thead>
          <tr>
            <th>Expedisi</th>
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
	    	    data: 'id',
	    	    mRender: function(data, type, full) {
	    	        return `<a href="/product/${full.barcode}/edit" title="Edit" class="btn btn-sm bg-gradient-primary edit-product"><i class="fas fa-edit"></i></a>`
	    	    }
	    	}
        ],
        columnDefs: [
            { 
                className: "text-center",
                targets: [0,1]
            },
        ],
        order:[[0,'asc']]
    })

    ajax(null, `http://192.168.0.104:8000/api/expedition`, "GET",
        function(json) {
           console.log(json);
    },function(err){
        console.log(err)
    })
  })
</script>
@endsection