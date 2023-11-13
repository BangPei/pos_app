@extends('layouts.main-layout')

@section('content-child')
<div class="col-lg-3 col-6">
  <!-- small box -->
  <div class="small-box bg-info">
    <div class="inner">
      <h3>Rp. {{ number_format($subtotal) }}</h3>
      <p>Pendapatan</p>
    </div>
    <div class="icon">
      <i class="fa fa-dollar-sign"></i>
    </div>
    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
  </div>
</div>
<div class="col-lg-3 col-6">
  <!-- small box -->
  <div class="small-box bg-success">
    <div class="inner">
      <h3>{{ number_format($totalOrder) }}</h3>

      <p>Total Transaksi</p>
    </div>
    <div class="icon">
      <i class="ion ion-bag"></i>
    </div>
    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
  </div>
</div>
<div class="col-lg-3 col-6">
  <!-- small box -->
  <div class="small-box bg-warning">
    <div class="inner">
      <h3>{{ number_format($totalProduct) }}</h3>

      <p>Total Produk</p>
    </div>
    <div class="icon">
      <i class="ion ion-bag"></i>
    </div>
    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
  </div>
</div>
<div class="col-lg-3 col-6">
  <!-- small box -->
  <div class="small-box bg-danger">
    <div class="inner">
      <h3>{{ number_format($stock) }}</h3>

      <p>Stok Habis</p>
    </div>
    <div class="icon">
      <i class="ion ion-bag"></i>
    </div>
    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
  </div>
</div>
<div class="col-md-6 col-12">
  <div class="card">
    <div class="card-header">
      <h2 class="card-title">Penjualan Perminggu</h2>
    </div>
    <div class="card-body">
      <table class="table table-sm table-bordered table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th class="text-right">Total Transaksi</th>
            <th class="text-right">Total (Rp.)</th>
          </tr>
        </thead>
        <tbody>
          <?php $transWeek->sortBy(function ($ds) {
            return $ds['transDate'];
        })?>
          @foreach ($transWeek as $tran)
           <tr>
            <td>{{ $loop->index+1 }}</td>
            <td>{{ date_format(date_create($tran['transDate']),"d M Y") }}</td>
            <td class="text-right">{{ number_format($tran['data']) }}</td>
            <td class="text-right">{{ number_format($tran['amount']) }}</td>
           </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="col-md-6 col-12">
  <div class="card">
    <div class="card-header border-0">
      <div class="d-flex justify-content-between">
        <h3 class="card-title">Penjualan Perminggu</h3>
        {{-- <a href="javascript:void(0);">View Report</a> --}}
      </div>
    </div>
    <div class="card-body">

      <div class="position-relative mb-4">
        <canvas id="visitors-chart" height="245"></canvas>
      </div>

      <div class="d-flex flex-row justify-content-end">
        <span class="mr-2">
          <i class="fas fa-square text-primary"></i> This Week
        </span>
      </div>
    </div>
  </div>
</div>
<div class="col-12">
  <div class="row">
    <div class="col-lg-6 col-12">
      <div class="card">
        <div class="card-header">
          <h2 class="card-title">Penjualan Tahun - {{ date('Y', time()) }}</h2>
        </div>
        <div class="card-body">
          <table class="table table-sm table-bordered table-striped">
            <thead>
              <tr>
                <th>No</th>
                <th>Bulan</th>
                <th class="text-right">Total Transaksi</th>
                <th class="text-right">Total (Rp.)</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($trans[(string)date('Y', time())] as $tran)
               <tr>
                <td>{{ $loop->index+1}}</td>
                <td>{{ $tran['month'] }}</td>
                <td class="text-right">{{ number_format($tran['data']) }}</td>
                <td class="text-right">{{ number_format($tran['amount']) }}</td>
               </tr>
              @endforeach
            </tbody>
          </table>
          <hr>
          <div class="row">
            <div class="col-6 text-left font-weight-bold">Grand Total :</div>
            <div class="col-6 text-right font-weight-bold">{{ number_format($trans['total'.(string)date('Y', time())]) }}</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6 col-12">
      <div class="card">
        <div class="card-header">
          <h2 class="card-title">Penjualan Tahun - {{ date('Y', time())-1 }}</h2>
        </div>
        <div class="card-body">
          <table class="table table-sm table-bordered table-striped">
            <thead>
              <tr>
                <th>No</th>
                <th>Bulan</th>
                <th class="text-right">Total Transaksi</th>
                <th class="text-right">Total (Rp.)</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($trans[(string)(date('Y', time())-1)] as $tran)
               <tr>
                <td>{{ $loop->index+1}}</td>
                <td>{{ $tran['month'] }}</td>
                <td class="text-right">{{ number_format($tran['data']) }}</td>
                <td class="text-right">{{ number_format($tran['amount']) }}</td>
               </tr>
              @endforeach
            </tbody>
          </table>
          <hr>
          <div class="row">
            <div class="col-6 text-left font-weight-bold">Grand Total :</div>
            <div class="col-6 text-right font-weight-bold">{{ number_format($trans['total'.(string)(date('Y', time())-1)]) }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- <p>{{ $trans[(string)date('Y', time())] }}</p> --}}
</div>
@include('component.base')
@endsection

@section('content-script')
<script src="/plugins/moment/moment.min.js"></script>
<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/jquery-blockUI/js/jquery.blockUI.js"></script>
<script src="js/script.js"></script>
<script src="plugins/chart.js/Chart.min.js"></script>

<script>
  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }
  var mode = 'index';
  var intersect = true;
  let transWeek = `<?=isset($transWeek)?$transWeek:[]?>`;
    $(document).ready(function(){
      $('table').DataTable({
        paging: false,
        searching: false,
        ordering:  false,
        bInfo : false
      })
        ajax(null, `${baseApi}/lazada-order`, "GET",
        function(json) {
          toastr.success('Berhasil')
          $.unblockUI()
        },
        function(err){
          toastr.error(err?.responseJSON?.message??"Tidak Dapat Mengakses Server")
          $.unblockUI()
        })
        getChart();
    })

    function getChart(){
      var $visitorsChart = $('#visitors-chart')
      // eslint-disable-next-line no-unused-vars
      let labels = []
      let data = []
      let trans = JSON.parse(transWeek);
      trans.sort((a, b) => {
      let da = new Date(a.transDate),
          db = new Date(b.transDate);
          return da - db;
      });
      for (let i = 0; i < trans.length; i++) {
        const e = trans[i];
        labels.push(moment(e.transDate).format('DD MMM'));
        data.push(e.amount);
      }

      var visitorsChart = new Chart($visitorsChart, {
        data: {
          labels: labels,
          datasets: [{
            type: 'line',
            data: data,
            backgroundColor: 'transparent',
            borderColor: '#007bff',
            pointBorderColor: '#007bff',
            pointBackgroundColor: '#007bff',
            fill: false
            // pointHoverBackgroundColor: '#007bff',
            // pointHoverBorderColor    : '#007bff'
          }]
        },
        options: {
          maintainAspectRatio: false,
          tooltips: {
            mode: mode,
            intersect: intersect
          },
          hover: {
            mode: mode,
            intersect: intersect
          },
          legend: {
            display: false
          },
          scales: {
            yAxes: [{
              // display: false,
              gridLines: {
                display: true,
                lineWidth: '4px',
                color: 'rgba(0, 0, 0, .2)',
                zeroLineColor: 'transparent'
              },
              ticks: $.extend({
                beginAtZero: true,
                suggestedMax: 200
              }, ticksStyle)
            }],
            xAxes: [{
              display: true,
              gridLines: {
                display: false
              },
              ticks: ticksStyle
            }]
          }
        }
      })
    }
</script>
@endsection