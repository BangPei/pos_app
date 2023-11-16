@extends('layouts.main-layout')

@section('content-class')
  <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
@endsection

@section('content-child')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">{{ $title }}</h2>
        </div>
        <div class="card-body">
          <form action="" method="">
            <div class="row">
              <div class="col-4">
                  <div class="form-group">
                      <label for="date">Tanggal</label>
                      <div class="input-group mb-3" style="flex-wrap: nowrap !important;">
                        <input value="{{ $date }}" readonly type="text" autocomplete="off" placeholder="Masukan Tanggal" class="form-control" id="date" name="date">
                        <div class="input-group-append">
                          <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar-alt"></i></span>
                        </div>
                      </div>
                  </div>
              </div>
              <div class="col-md-4">
                <button class="btn btn-primary" style="margin-top: 32px !important" type="submit"><i class="fa fa-search"></i> Submit</button>
              </div>
              <div class="col-md-4">
                <div class="row">
                  <div class="col-6 text-center" style="display: grid">
                    <dt>Transaksi</dt>
                    <label for="" style="font-size: x-large">{{ number_format($total['data']) }}</label>
                  </div>
                  <div class="col-6 text-center" style="display: grid">
                    <dt>Total (Rp.)</dt>
                    <label for="" style="font-size: x-large">{{ number_format($total['amount']) }}</label>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body table-responsive">
          <table class="table table-striped table-bordered table-sm "style="width: 100% !important" id="table-daily">
            <thead>
              <tr>
                <th class="text-right">No</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Jam</th>
                <th class="text-right">Transaksi</th>
                <th class="text-right">Total (.Rp)</th>
                <th class="text-center">Detail</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($directSales as $ds)
                  <tr>
                      <td class="text-right">{{ $loop->index+1 }}</td>
                      <td class="text-center">{{ $date }}</td>
                      <td class="text-center text-bold {{ $ds['amount'] ==0?'text-danger':'text-default'}}">{{ $ds['hour'].":00"}}</td>
                      <td class="text-right">{{ number_format($ds['data']) }}</td>
                      <td class="text-right">{{ number_format($ds['amount']) }}</td>
                      <td class="text-center {{ $ds['amount'] ==0?'':'dt-control'}}"></td>
                  </tr>
              @endforeach
            </tbody>
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
  let dsDetail = [];
    $(document).ready(function(){
        $('#date').datepicker({
            uiLibrary: 'bootstrap',
            format:"dd mmmm yyyy",
            // value:moment().format("DD MMMM YYYY")
        })
        table = $('table').DataTable({
                paging: false,
                searching: false,
                ordering:  false,
                bInfo : false
              })
        table.on('click', 'td.dt-control', function (e) {
            let tr = e.target.closest('tr');
            let row = table.row(tr);
        
            if (row.child.isShown()) {
                row.child.hide();
            }else {
              let data  = row.data();
              let date = moment(data[1],"DD MMMM YYYY").format("YYYY-MM-DD")
              let hour = data[2].split(':')[0]
              
              let ds=dsDetail.filter(e=>e.date == `${date} ${hour}`)
              if (ds.length == 0) {
                getDsByDateHour(date,hour,row);
              }else{
                row.child(format(ds[0])).show();
              }

            }
        });
    })

    function getDsByDateHour(date,hour,row){
      ajax(null, `{{URL::to('/transaction/date/hour/${date}/${hour}')}}`, "GET",function(json) {
          let data = {
            date:`${date} ${hour}`,
            details : json
          }
          dsDetail.push(data)
          row.child(format(data)).show();
      })
    }

    function format(d) {
      let dataRow =`
      <div class="m-3">
      <table class="table table-striped table-bordered table-sm ">
        <thead>
          <tr>
            <th>Code</th>
            <th>Tanggal</th>
            <th>Total Item</th>
            <th>Total</th>
            <th>Pembayaran</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
      `;
      d.details.forEach(e=>{
        dataRow += `
        <tr>
            <td>${e.code}</td>
            <td>${moment(e.date).format('DD MMM YYYY HH:mm:ss')}</td>
            <td>${e.total_item}</td>
            <td>${formatNumber(e.amount)}</td>
            <td>${e.payment_type.name}</td>
            <td>
              <a href="/transaction/${e.code}/edit" title="Edit" target="_blank" rel="noopener noreferrer" class="btn btn-sm bg-gradient-primary edit-product"><i class="fas fa-edit"></i></a></form>
            </td>
        </tr>
        `
      })
      dataRow +="</tbody></table></div>"
      return dataRow;
    }
</script>
@endsection
