@extends('layouts.main-layout')

@section('content-class')
  <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
@endsection

@section('content-child')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Form Pencarian</h2>
        </div>
        <div class="card-body ">
          <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="expedition">Expedisi</label>
                    <select name="expedition" id="expedition" class="form-control select2">
                        <option value="" selected>Semua Expedisi</option>
                        @foreach ($expeditions as $e)
                            <option {{ Request::query('expedition')==$e->id?'selected':'' }} value="{{$e->id}}">{{$e->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="date">Tanggal</label>
                    <div class="input-group mb-3">
                      <input value="{{ Request::query('date')}}" readonly type="text" class="form-control date-picker" id="date" name="date">
                      <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2"><i class="fa fa-home"></i></span>
                      </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <a href="javascript:void(0)" onclick="getData()" class="btn btn-primary" style="margin-top: 32px !important"><i class="fa fa-search"></i> Submit</a>
            </div>
          </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body table-responsive">
          <table class="table table-striped table-bordered table-sm "style="width: 100% !important" id="table-daily-task">
            <thead>
              <tr>
                <th>Tanggal</th>
                <th>Expedisi</th>
                <th>Total Paket</th>
                <th>Total Scan</th>
                <th>Dibawa</th>
                <th>Pending</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
          </table>
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

        initDataTable("{{ route('search-task.index') }}","GET")
    })

    
    function getData(){
      let data = {
        _token:'{{ csrf_token() }}',
        expedition:$('#expedition').val(),
        date:moment($('#date').val(),"DD MMMM YYYY").format('YYYY-MM-DD')
      }
      const u = new URLSearchParams(data).toString();
      $('#table-daily-task').DataTable().destroy();
      initDataTable(`${baseUrl}/search-task/get?${u}`,"POST")
    }
    function initDataTable(url,method) {
      tblDailyTask = $('#table-daily-task').DataTable({
          processing:true,
          serverSide:true,
          ajax:{
            url:url,
            type:method,
          },
          columns:[
            {
                data:"date",
                defaultContent:"--",
                className:"text-center",
                mRender:function(data, type,full){
                    return moment(data).format("DD MMMM YYYY")
                }
            },
            {
                data:"expedition.name",
                defaultContent:"--",
            },
            {
              data: 'total_package',
              defaultContent:"0",
              mRender:function(data,type,full){
                return `<input !important;" class="form-control total_package number2 text-right" value="${data}">`
              }
            },
            {
              data: 'id',
              defaultContent:"0",
              mRender:function(data,type,full){
                return full.receipts.length;
              }
            },
            {
              data: 'picked',
              defaultContent:"0",
              mRender:function(data,type,full){
                return `<input !important;" class="form-control picked number2 text-right" value="${data}">`
              }
            },
            {
              data: 'left',
              defaultContent:"0",
            },
            {
              data: 'status',
              mRender: function(data, type, full) {
                return `<span class="badge badge-${data?"success":"primary"}">${data?'Selesai':"Sedang Berjalan"}</span>`
                }
            },
            {
              data: 'id',
              mRender: function(data, type, full) {
                return `
                <a title="Finish" class="btn btn-sm bg-gradient-success finish-daily-task"><i class="fas fa-check"></i></a>
                <a href="/daily-task/${data}/edit?platform=${full.expedition.alias}" title="Lihat Detail" class="btn btn-sm bg-gradient-primary edit-daily-task"><i class="fas fa-eye"></i></a>`
                }
            }
          ],
          columnDefs:[
            {
              className:"text-center",
              targets:[0,2,3,5,7]
            },
            {
              width:"10%",
              targets:[2,4,6]
            }
          ]
        })
    }
</script>
@endsection