@extends('layouts.main-layout')

@section('content-class')
  <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
@endsection

@section('content-child')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Laporan Harian</h2>
        </div>
        <div class="card-body ">
          <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="date">Tanggal</label>
                    <div class="input-group mb-3">
                      <input value="{{ Request::query('date')}}" readonly type="text" class="form-control" id="date" name="date">
                      <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar-alt"></i></span>
                      </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <a href="javascript:void(0)" onclick="" class="btn btn-primary" style="margin-top: 32px !important"><i class="fa fa-search"></i> Submit</a>
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
        $('#date').datepicker({
            uiLibrary: 'bootstrap',
            format:"dd mmmm yyyy",
            // value:moment().format("DD MMMM YYYY")
        })
    })
</script>
@endsection
