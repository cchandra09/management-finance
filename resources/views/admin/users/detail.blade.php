@extends('layouts.admin.app')
@section('title')
HIPHOP - REPORT
@endsection
@section('content')

<div class="content-body">
    <section class="ajax-datatable">
        <div class="card" style="padding: 20px">
            <form action="{{route('admin.users.detail', $id)}}" method="GET">
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
        
    </section>
    <section id="nav-filled">
        <div class="row match-height">
            <!-- Filled Tabs starts -->
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Filled</h4>
                    </div>
                    <div class="card-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab-fill" data-toggle="tab" href="#home-fill" role="tab" aria-controls="home-fill" aria-selected="true">Laporan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab-fill" data-toggle="tab" href="#profile-fill" role="tab" aria-controls="profile-fill" aria-selected="false">Data Transaksi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="messages-tab-fill" data-toggle="tab" href="#messages-fill" role="tab" aria-controls="messages-fill" aria-selected="false">Profile</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content pt-1">
                            <div class="tab-pane active" id="home-fill" role="tabpanel" aria-labelledby="home-tab-fill">
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
                                                       <td class="text-right">Selisih</td>
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
                            </div>
                            <div class="tab-pane" id="profile-fill" role="tabpanel" aria-labelledby="profile-tab-fill">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header border-bottom">
                                                <h4 class="card-title">Data Transaksi</h4>
                                                <form action="{{route('admin.users.detail', $id)}}" method="get">
                                                    <div class="row">
                                                        <div class="col-md-4 col-12">
                                                            <div class="form-group">
                                                                <select class="form-control" name="month" id="basicSelect">
                                                                    <option value="01">Januari</option>
                                                                    <option value="02">Febuari</option>
                                                                    <option value="03">Maret</option>
                                                                    <option value="04">April</option>
                                                                    <option value="05">Mei</option>
                                                                    <option value="06">Juni</option>
                                                                    <option value="07">Juli</option>
                                                                    <option value="08">Agustus</option>
                                                                    <option value="09">September</option>
                                                                    <option value="10">Oktober</option>
                                                                    <option value="11">November</option>
                                                                    <option value="12">Desember</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-12">
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
                                                                <button class="btn btn-primary btn-m">Lihat</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="card-datatable">
                                                <table class="datatables-ajax table">
                                                    <thead>
                                                        <tr>
                                                            <th>Tanggal Transaksi</th>
                                                            <th>Nominal</th>
                                                            <th>Status</th>
                                                            <th>Deskripsi</th>
                                                            <th>Kategori</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(count($transaction) < 1)
                                                            <tr>
                                                                <td colspan="6" class="text-center">Tidak Ada Data</td>
                                                            </tr>
                                                        
                                                        @endif
                                                        @foreach($transaction as $item)
                                                            <tr>
                                                                <td>{{$item->date_transaction}}</td>
                                                                <td>{{$item->amount}}</td>
                                                                <td>@if($item->status == "1") <span class="badge badge-pill badge-light-success mr-1">Masuk</span> @else <span class="badge badge-pill badge-light-danger mr-1">Keluar</span> @endif</td>
                                                                <td>{{$item->description}}</td>
                                                                <td>{{$item->Category->name}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="messages-fill" role="tabpanel" aria-labelledby="messages-tab-fill">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-12 d-flex flex-column justify-content-between border-container-lg">
                                            <div class="d-flex align-items-center user-total-numbers">
                                                <div class="d-flex align-items-center mr-2">
                                                    <div class="color-box bg-light-primary">
                                                        <i data-feather="dollar-sign" class="text-primary"></i>
                                                    </div>
                                                    <div class="ml-1">
                                                        <h5 class="mb-0">23.3k</h5>
                                                        <small>Pemasukan</small>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <div class="color-box bg-light-success">
                                                        <i data-feather="dollar-sign" class="text-primary"></i>
                                                    </div>
                                                    <div class="ml-1">
                                                        <h5 class="mb-0">$99.87K</h5>
                                                        <small>Annual Profit</small>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center ml-1">
                                                    <div class="color-box bg-light-success">
                                                        <i data-feather="dollar-sign" class="text-primary"></i>
                                                    </div>
                                                    <div class="ml-1">
                                                        <h5 class="mb-0">$99.87K</h5>
                                                        <small>Annual Profit</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-12 mt-2 mt-xl-0">
                                            <div class="user-info-wrapper">
                                                <div class="d-flex flex-wrap">
                                                    <div class="user-info-title">
                                                        <i data-feather="user" class="mr-1"></i>
                                                        {{-- <span class="card-text user-info-title font-weight-bold mb-0">Nama</span> --}}
                                                    </div>
                                                    <p class="card-text mb-0">{{$user->name}}</p>
                                                </div>
                                                <div class="d-flex flex-wrap my-50">
                                                    <div class="user-info-title">
                                                        <i data-feather="check" class="mr-1"></i>
                                                        {{-- <span class="card-text user-info-title font-weight-bold mb-0">Status</span> --}}
                                                    </div>
                                                    <p class="card-text mb-0">{{($user->status == 1) ? 'Masuk' : 'Keluar'}}</p>
                                                </div>
                                                <div class="d-flex flex-wrap my-50">
                                                    <div class="user-info-title">
                                                        <i data-feather="star" class="mr-1"></i>
                                                        {{-- <span class="card-text user-info-title font-weight-bold mb-0">Role</span> --}}
                                                    </div>
                                                    <p class="card-text mb-0">{{$user->role_name}}</p>
                                                </div>
                                                <div class="d-flex flex-wrap my-50">
                                                    <div class="user-info-title">
                                                        <i data-feather="phone" class="mr-1"></i>
                                                        {{-- <span class="card-text user-info-title font-weight-bold mb-0">No Hp</span> --}}
                                                    </div>
                                                    <p class="card-text mb-0">{{$user->no_hp}}</p>
                                                </div>
                                                <div class="d-flex flex-wrap">
                                                    <div class="user-info-title">
                                                        <i data-feather="mail" class="mr-1"></i>
                                                        {{-- <span class="card-text user-info-title font-weight-bold mb-0">email</span> --}}
                                                    </div>
                                                    <p class="card-text mb-0">{{$user->email}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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