@extends('layouts.main-layout')
@section('content-class')
  <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
@endsection

@section('content-child')
<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <h2 class="card-title">List Tugas Harian</h2>
      <div class="card-tools">
        <a class="btn btn-primary" href="/daily-task/create">
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
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
@endsection

@section('content-script')
<script src="/plugins/moment/moment.min.js"></script>
<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
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
                return moment(data).format("DD MMMM YYYY HH:mm:ss")
            }
        },
        {
            data:"expedition.name",
            defaultContent:"--",
        },
        {
          data: 'id',
          defaultContent:"0",
          mRender:function(data,type,full){
            return full.receipts.length;
          }
        },
        {
          data: 'status',
          mRender: function(data, type, full) {
            return data?'Selesai':"On Progress"
            }
        },
        {
          data: 'id',
          mRender: function(data, type, full) {
            return `<a href="" title="Edit" class="btn btn-sm bg-gradient-primary edit-daily-task"><i class="fas fa-edit"></i></a></form>`
            }
        }
        ],
    })
  })
</script>
@endsection