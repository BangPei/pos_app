@extends('layouts.main-layout')
@section('content-class')
  <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  {{-- <link rel="stylesheet" href="plugins/gijgo/gijgo.css"> --}}
  <style>
    span.select2{
      width: 100% !important;
    }
  </style>
@endsection

@section('content-child')
<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <h2 class="card-title">List Tugas Harian</h2>
      <div class="card-tools">
        <a class="btn btn-primary" data-toggle="modal" data-target="#modal-daily-task" data-backdrop="static" data-keyboard="false">
            <i class="fas fa-plus-circle"></i> Tambah
        </a>
      </div>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-striped table-bordered table-sm " id="table-daily-task">
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


<div class="modal fade" id="modal-daily-task" tabindex="-1">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title">Form Tugas Harian</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form autocomplete="OFF" id="form-task">
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label for="date">Tanggal</label>
                <input required readonly type="text" class="form-control" name="date" id="date" >
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label for="expedition">Expedisi</label>
                <select required name="expedition" id="expedition" width="100%" class="form-control select2">
                  <option value="" disabled selected>--Pilih Expedisi--</option>
                  @foreach ($expeditions as $ex)
                      <option value="{{ $ex->id }}">{{ $ex->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label for="total_package">Total Paket</label>
                <input required type="text" class="form-control text-right number2" name="total_package" id="total_package" >
              </div>
            </div>
          </div>
          <hr>
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
{{-- <script src="/plugins/gijgo/gijgo.js"></script> --}}
<script>
  $(document).ready(function(){
    tblDailyTask = $('#table-daily-task').DataTable({
      processing:true,
      serverSide:true,
      ajax:{
        url:"{{ route('daily-task.index') }}",
        type:"GET",
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

    $('#table-daily-task').on('change','.total_package',function() {
      let data = tblDailyTask.row($(this).parents('tr')).data();
      let val = $(this).val()==""?0:parseInt($(this).val())
      let date = moment(data.date).format('YYYY-MM-DD')
      let picked = data.picked;
      $.blockUI({ message: "Silahkan Tunggu !!" });
      ajax({total_package:val,date:date,picked:picked}, `${baseApi}/daily-task/total/${data.id}`, "PATCH",  
        function(json) {
          toastr.success('Berhasil')
          location.reload();
        },
        function(err){
          toastr.error(err?.responseJSON?.message??"Tidak Dapat Mengakses Server")
          $.unblockUI()
        })
    })
    $('#table-daily-task').on('change','.picked',function() {
      let data = tblDailyTask.row($(this).parents('tr')).data();
      let val = $(this).val()==""?0:parseInt($(this).val())
      let date = moment(data.date).format('YYYY-MM-DD')
      let total_package = data.total_package
      $.blockUI({ message: "Silahkan Tunggu !!" });
      ajax({picked:val,date:date,total_package:total_package}, `${baseApi}/daily-task/picked/${data.id}`, "PATCH",  
        function(json) {
          toastr.success('Berhasil')
          location.reload();
        },
        function(err){
          toastr.error(err?.responseJSON?.message??"Tidak Dapat Mengakses Server")
          $.unblockUI()
        })
    })

    $('#table-daily-task').on('click','.finish-daily-task',function() {
      let data = tblDailyTask.row($(this).parents('tr')).data();
      let date = moment(data.date).format('YYYY-MM-DD')
      $.blockUI({ message: "Silahkan Tunggu !!" });
      ajax({date:date}, `${baseApi}/daily-task/finish/${data.id}`, "PATCH",  
        function(json) {
          toastr.success('Berhasil')
          location.reload();
        },
        function(err){
          toastr.error(err?.responseJSON?.message??"Tidak Dapat Mengakses Server")
          $.unblockUI()
        })
    })

    $('#date').datepicker({
      uiLibrary: 'bootstrap',
      format:"dd mmmm yyyy",
      value:moment().format("DD MMMM YYYY")
    })

    keyupTableNumber($('#table-daily-task'))

    saveDailyTask();
  })

  function saveDailyTask(){
    formValid($('#form-task'),function(){
      let dailyTask = {
        expedition:{
          id:$('#expedition').val(),
        },
        total_package:$('#total_package').val(),
        date:moment($('#date').val(),"DD MMMM YYYY").format('YYYY-MM-DD')
      }
      ajax(dailyTask, `${baseApi}/daily-task`, "POST",
        function(json) {
          toastr.success('Berhasil Menambah Tugas Harian')
          setTimeout(() => {
              location.reload()
          }, 500);
        })
    })
  }
</script>
@endsection