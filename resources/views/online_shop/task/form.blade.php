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
                            <label for="expedition">Expedisi</label>
                            <input  value="{{ $dailyTask->id }}" readonly type="text" class="form-control d-none" name="id" id="id">
                            <input data-id="{{ $dailyTask->expedition->id }}" value="{{ $dailyTask->expedition->name }}" required readonly type="text" class="form-control" name="expedition" id="expedition">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="date">Tanggal</label>
                            <input value="{{ $dailyTask->date }}" required readonly disabled type="text" autofocus="true" class="form-control" name="date" id="date">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="total">Total Paket</label>
                            <input value="{{ $dailyTask->total_package }}" readonly placeholder="0" type="text" class="form-control text-right" name="total" id="total">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group" style="width: 40% !important">
                            <input type="text" name="scanner" id="scanner" class="form-control" >
                        </div>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered table-sm" id="table-daily-task">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Resi</th>
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
<script src="/plugins/moment/moment.min.js"></script>
<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/plugins/dataTables-checkboxes/js/dataTables.checkboxes.min.js"></script>

<script>
    $(document).ready(function(){
        tblTask = $('#table-daily-task').dataTable({
            bInfo:false,
            paginate:false,
            searching:false,
            data:[],
            columns:[
                {
                    data:null,
                },
                {
                    data:"number",
                },
                {
                    data:null,
                    mRender:function(data,type,full){
                        return `<a class="btn btn-danger"><i class="fa fa-trash"></i></a>`
                    }
                },
            ],
            columnDefs:[
                {
                    width:"10%",
                    className:"text-center",
                    targets:[0,2]
                }
            ]
        });

        $('#date').datepicker({
            uiLibrary:'bootstrap',
            value:moment("{{ $dailyTask->date }}").format('DD MMMM YYYY')
        })

        $('#scanner').on('keypress',function(e){
            if(e.keyCode == 13){
                let dailyTask ={
                    id : $('#id').val(),
                    date:moment($('#date').val(),'DD MMMM YYYY').format('YYYY-MM-DD'),
                    total_package:$('#total_package').val(),
                    expedition:{
                        id:$('#expedition').attr('data-id')
                    },
                    receipts:[
                        {
                            number:$('#scanner').val()
                        }
                    ]
                };
                
                ajax(dailyTask, `{{URL::to('daily-task/update')}}`, "PUT",
                    function(item) {
                        console.log(item);
                },function(json){
                    console.log(json)
                })
            }
        })
    })
</script>
@endsection

