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
                        <input value="{{ $dailyTask->date }}" required readonly disabled type="text" class="form-control" name="date" id="date">
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
                <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="" id="total-scann"></label>
                        <input autofocus="true" type="text" name="scanner" id="scanner" class="form-control" >
                    </div>
                </div>
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-sm" id="table-daily-task">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Resi</th>
                                <th>Jam Scan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            {{-- <div class="row">
                <div class="col md-12 text-center">
                    <button type="button" onclick="saveDailyTaskReceipt()" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div> --}}
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
<script src="/js/constant.js"></script>

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
            // searching:false,
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
                    data:"created_at",
                    mRender:function(data,type,full){
                        return moment(data).format('DD MMM YYYY HH:mm:ss')
                    }
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
                    searchable: false,
                    orderable: false,
                    targets: 0,
                },
                {
                    width:"10%",
                    className:"text-center",
                    targets:[0,3]
                },
                {
                    width:"20%",
                    className:"text-right",
                    targets:[2]
                },
            ]
        });

        tableNumber(tblReceipt)

        $('#date').datepicker({
            uiLibrary:'bootstrap',
            value:moment("{{ $dailyTask->date }}").format('DD MMMM YYYY')
        })

        $('#table-daily-task').on('click', '.delete-receipt', function() {
            let rc = tblReceipt.row($(this).parents('tr')).data();
            let data = tblReceipt.row($(this).parents('tr')).index();
            var result = confirm(`Yakin ingin menghapus No Resi ${rc.number} ?`);
            if (result) {
                deleteReceipt(rc.number)
            }
        });

        $('#scanner').on('keypress',function(e){
            if(e.keyCode == 13){
                if ($('#scanner').val()!="") {
                    let isValidated=validReceipt($('#scanner').val())
                    if (isValidated) {     
                        let receipt = {
                            daily_task_id: $('#id').val(),
                            number:$('#scanner').val()
                        }
                        postReceipt(receipt);
                    }else{
                        toastr.error("Resi Tidak Valid")
                    }
                    $('#scanner').val('')
                }
            }
        })
        getDailyTask();
    })

    function getDailyTask(){
        ajax(null, `${baseApi}/daily-task/${$('#id').val()}`, "GET",
            function(item) {
                dailyTask = item;
                $('#total-scann').html(`Total Scan = ${dailyTask.receipts.length} / ${dailyTask.total_package}`)
                reloadJsonDataTable(tblReceipt,dailyTask.receipts)
                $('#scanner').focus();
            },
        )
    }

    function receiptHandler() {
        ajax(dailyTask, `${baseApi}/daily-task/${dailyTask.id}`, "PUT",
            function(json){
                console.log('ok')
                $('#scanner').val('')
                $('#total-scann').html(`Total Scan = ${dailyTask.receipts.length} / ${dailyTask.total_package}`)
            },
            function(err){
                dailyTask.receipts.splice(receipt, 1);
                toastr.error(err?.responseJSON?.message??"Tidak Dapat Mengakses Server")
                $('#scanner').val('')
                $('#total-scann').html(`Total Scan = ${dailyTask.receipts.length} / ${dailyTask.total_package}`)
            }
        )
    }

    function postReceipt(receipt) {
        ajax(receipt, `${baseApi}/daily-task/receipt/${dailyTask.id}`, "POST",
            function(json){
                getDailyTask()
                $('#scanner').val('')
                $('#total-scann').html(`Total Scan = ${dailyTask.receipts.length} / ${dailyTask.total_package}`)
            },
            function(err){
                toastr.error(err?.responseJSON?.message??"Tidak Dapat Mengakses Server")
                $('#scanner').val('')
                getDailyTask()
                $('#total-scann').html(`Total Scan = ${dailyTask.receipts.length} / ${dailyTask.total_package}`)
            }
        )
    }
    function deleteReceipt(number) {
        ajax(null, `${baseApi}/daily-task/receipt/${number}`, "DELETE",
            function(json){
                getDailyTask()
                $('#scanner').val('')
                $('#total-scann').html(`Total Scan = ${dailyTask.receipts.length} / ${dailyTask.total_package}`)
            },
            function(err){
                toastr.error(err?.responseJSON?.message??"Tidak Dapat Mengakses Server")
                $('#scanner').val('')
                getDailyTask()
                $('#total-scann').html(`Total Scan = ${dailyTask.receipts.length} / ${dailyTask.total_package}`)
            }
        )
    }

    function saveDailyTaskReceipt(){
        dailyTask.id = $('#id').val(),
        dailyTask.date=moment($('#date').val(),'DD MMMM YYYY').format('YYYY-MM-DD'),
        dailyTask.total_package=parseInt($('#total').val()),
        dailyTask.status=0,
        dailyTask.expedition={
            id:$('#expedition').attr('data-id')
        }

        if (dailyTask.receipts.length ==0) {
            toastr.error('Silahkan masukan nomor Resi');
            return false;
        }
        ajax(dailyTask, `${baseApi}/daily-task/${dailyTask.id}`, "PUT",
            function(json){
                toastr.success('Data Berhasil Tersimpan')
            setTimeout(() => {
                location.reload()
            }, 500);
            }
        )
    }
</script>
@endsection

