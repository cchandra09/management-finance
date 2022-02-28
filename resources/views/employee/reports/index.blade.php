@extends('layouts.employee.app')
@section('title')
HIPHOP - REPORT
@endsection
@section('content')

<div class="content-body">
    <section class="ajax-datatable">
        <div class="card" style="padding: 20px">
            <form action="{{route('employee.report')}}" method="GET">
                <div class="row">
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <select class="form-control" name="year" id="basicSelect">
                                @foreach(getYears() as $year)
                                    <option value="{{$year}}">{{$year}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <button class="btn btn-primary btn-m">Lihat Laporan</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">Report</h3></div>
                <div class="panel-body">
                    <strong>{{ 'Rp' }}</strong>
                    <div id="yearly-chart" style="height: 250px;"></div>
                    <div class="text-center"><strong>Bulan</strong></div>
                </div>
            </div>
        </div>
    </section>
    <section id="ajax-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <h4 class="card-title">Laporan Transaksi</h4>
                        <form action="{{route('employee.report.print')}}" method="GET">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <select class="form-control" name="year" id="basicSelect">
                                            @foreach(getYears() as $year)
                                                <option value="{{$year}}">{{$year}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-m">Print</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-datatable">
                       <table class="datatables-ajax table">
                           <tr>
                               <td class="text-left">Bulan</td>
                               <td class="text-left">Transaksi</td>
                               <td class="text-right">Pemasukan</td>
                               <td class="text-right">Pengeluaran</td>
                               <td class="text-right">Pendapatan</td>
                           </tr>
                            @php $chartData = []; @endphp
                            @foreach(getMonthsName() as $monthNumber => $monthName)
                            @php
                                $any = isset($data[$monthNumber]);
                            @endphp
                            <tr>
                                <td class="text-left">{{ monthId($monthNumber) }}</td>
                                <td class="text-left">{{ $any ? $data[$monthNumber]->count : 0 }}</td>
                                <td class="text-right">{{ formatNumber($income = ($any ? $data[$monthNumber]->income : 0)) }}</td>
                                <td class="text-right">{{ formatNumber($spending = ($any ? $data[$monthNumber]->spending : 0)) }}</td>
                                <td class="text-right">{{ formatNumber($difference = ($any ? $data[$monthNumber]->difference : 0)) }}</td>
                            </tr>
                            @php
                                $chartData[] = ['month' => monthId($monthNumber), 'income' => $income, 'spending' => $spending, 'difference' => $difference];
                            @endphp
                            @endforeach
                       </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('scripts')
<link rel="stylesheet" href="{{ asset('css/plugins/morris.css') }}">
<script src="{{ asset('js/plugins/raphael.min.js') }}"></script>
<script src="{{ asset('js/plugins/morris.min.js') }}"></script>
<script>
    (function() {
        new Morris.Line({
            element: 'yearly-chart',
            data: {!! collect($chartData)->toJson() !!},
            xkey: 'month',
            ykeys: ['income', 'spending', 'difference'],
            labels: ["Tranksasi Masuk {{ 'Rp' }}", "Transaksi Keluar {{ 'Rp' }}", "Selisih {{ 'Rp' }}"],
            parseTime:false,
            lineColors: ['green', 'orange', 'blue'],
            goals: [0],
            goalLineColors : ['red'],
            smooth: true,
            lineWidth: 2,
        });
    })();
    </script>
@endsection