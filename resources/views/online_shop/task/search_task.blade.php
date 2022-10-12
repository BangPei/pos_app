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
                        <select name="exedition" id="exedition" class="form-control select2">
                            <option value="" selected disabled>Pilih Expedisi</option>
                            @foreach ($expeditions as $e)
                                <option value="{{$e->id}}">{{$e->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="date">Tanggal</label>
                        <input type="text" class="form-control" id="date" name="date">
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-primary" style="margin-top: 32px !important"><i class="fa fa-search"></i> Submit</button>
                </div>
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

        $('#date').datepicker({
            uiLibrary: 'bootstrap',
            format:"dd mmmm yyyy",
            value:moment().format("DD MMMM YYYY")
        })
    })
</script>
@endsection