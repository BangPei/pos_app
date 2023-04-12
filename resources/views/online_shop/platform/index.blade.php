@extends('layouts.main-layout')
@section('content-class')
  <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
@endsection

@section('content-child')
<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <h2 class="card-title">Platform</h2>
      <div class="card-tools">
        <a class="btn btn-primary" data-toggle="modal" data-target="#modal-paltform" data-backdrop="static" data-keyboard="false">
            <i class="fas fa-plus-circle"></i> Tambah
        </a>
      </div>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-striped table-bordered table-sm " id="table-platform">
        <thead>
          <tr>
            <th>Platform</th>
            <th>Status</th>
            <th>Tgl Update</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>


<div class="modal fade" id="modal-paltform" tabindex="-1">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title">Form Tugas Harian</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form autocomplete="OFF" id="form-platform">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label for="name">Platform</label>
                <input required type="text" class="form-control text-right" name="name" id="name" >
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 text-right">
              <button type="submit" class="btn btn-primary"> Simpan </button>
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
<script src="/plugins/moment/moment.min.js"></script>
<script src="/plugins/jquery-blockUI/js/jquery.blockUI.js"></script>
<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function(){
        tblPlatform = $('#table-platform').DataTable({
            processing:true,
            serverSide:true,
            ajax:{
                url:"{{ route('platform.index') }}",
                type:"GET",
            },
            columns:[
                {
                    data:"name",
                    defaultContent:"--",
                },
                {
                    data:"is_active",
                    className:"text-center",
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
                    data: 'updated_at',
                    defaultContent:"--",
                    className:"text-center",
                    mRender:function(data, type,full){
                        return moment(data).format("DD MMMM YYYY HH:mm:ss")
                    }
                },
            ],
        })

        $('#table-platform').on('click', '.custom-control-input', function() {
            let platform = tblPlatform.row($(this).parents('tr')).data();
            let bool = $(this).prop('checked');
            platform.is_active = bool?1:0;
            ajax(platform, `{{URL::to('/platform/status')}}`, "PUT",
                function(json) {
                    console.log(json)
            })
        });
    })
</script>
@endsection
