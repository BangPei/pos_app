@extends('layouts.main-layout')

@section('content-class')
  <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
@endsection

@section('content-child')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Form Tugas Harian</h2>
        </div>
        <div class="card-body ">
            <form autocomplete="off" form-validate=true id="form-daily-task">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="date">Tanggal</label>
                            <input required  type="text" autofocus="true" class="form-control" name="date" id="date">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="total">Total Paket</label>
                            <input placeholder="0" type="text" class="form-control" name="total" id="total">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12 text-right">
                        <a class="btn btn-primary" id="btn-add-task">
                            <i class="fa fa-plus"></i> Tugas Harian
                        </a>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered table-sm" id="table-daily-task">
                            <thead>
                                <tr>
                                    <th>Expedisi</th>
                                    <th>Total Paket</th>
                                    <th>Total Scan</th>
                                    <th>Pesanan Batal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col md-12 text-center">
                        <button type="button" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('content-script')
<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/plugins/dataTables-checkboxes/js/dataTables.checkboxes.min.js"></script>

<script>
    $(document).ready(function(){
        tblTask = $('#table-daily-task').dataTable({
            bInfo:false,
            paginate:false,
            searching:false,
        });
    })
</script>
@endsection

