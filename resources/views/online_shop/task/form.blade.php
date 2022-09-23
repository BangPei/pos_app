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
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@include('component.base')
@endsection

@section('content-script')
<script src="/plugins/moment/moment.min.js"></script>
<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/plugins/dataTables-checkboxes/js/dataTables.checkboxes.min.js"></script>

<script>
    let dailyTask ={
        id : null,
        date:null,
        total_package:0,
        expedition:null,
        receipts:[]
    };
    $(document).ready(function(){
        tblReceipt = $('#table-daily-task').DataTable({
            bInfo:false,
            paginate:false,
            searching:false,
            data:dailyTask.receipts,
            columns:[
                {
                    data:'id',
                    defaultContent:"-"
                },
                {
                    data:"number",
                },
                {
                    data:null,
                    mRender:function(data,type,full){
                        return `<a class="btn btn-danger delete-receipt"><i class="fa fa-trash"></i></a>`
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

        $('#table-daily-task').on('click', '.delete-receipt', function() {
            let data = tblReceipt.row($(this).parents('tr')).data();
            dailyTask.receipts.splice(data, 1);
            reloadJsonDataTable(tblReceipt,dailyTask.receipts)
        });

        $('#scanner').on('keypress',function(e){
            if(e.keyCode == 13){
                if ($('#scanner').val()!="") {
                    if (dailyTask.receipts.some(val => val.number === $('#scanner').val())){
                        toastr.error('Nomor Resi Sudah Diinput')
                        return false;
                    }
                    let idx = 0;
                    let receipt = {
                        id:dailyTask.receipts.length ==0?1:Math.max(...dailyTask.receipts.map(o => o.id+1)),
                        number:$('#scanner').val()
                    }
                    dailyTask.receipts.push(receipt);
                    reloadJsonDataTable(tblReceipt,dailyTask.receipts)
                    $('#scanner').val('')
                }
            }
        })

        saveDailyTaskReceipt()
        getDailyTask();
    })

    function getDailyTask(){
        ajax(null, `${baseApi}/daily-task/${$('#id').val()}`, "GET",
            function(item) {
                dailyTask = item;
                reloadJsonDataTable(tblReceipt,dailyTask.receipts)
            },function(json){
            console.log(json)
            },
        )
    }

    function saveDailyTaskReceipt(){
        formValid($('#form-daily-task'),function(){
            
            dailyTask.id = $('#id').val(),
            dailyTask.date=moment($('#date').val(),'DD MMMM YYYY').format('YYYY-MM-DD'),
            dailyTask.total_package=parseInt($('#total').val()),
            dailyTask.status=0,
            dailyTask.expedition={
                id:$('#expedition').attr('data-id')
            }

            ajax(dailyTask, `${baseApi}/daily-task/${dailyTask.id}`, "PUT",
                function(item) {
                    console.log(item);
                },function(json){
                console.log(json)
                },
            )
            
        })
    }
</script>
@endsection

