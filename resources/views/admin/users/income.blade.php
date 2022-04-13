@extends('layouts.admin.app')
@section('title')
HIPHOP - INCOME
@endsection
@section('content')

<div class="content-body">
    <section id="ajax-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-datatable">
                        <table class="datatables-ajax table">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Nama</th>
                                    <th>Kode Angkringan</th>
                                    <th>Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($datas) < 1)
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak Ada Data</td>
                                    </tr>
                                @endif
                                @php
                                    $no  =1;
                                @endphp
                                @foreach($datas as $item)
                                    <tr>
                                        <td>{{$no++}}</td>
                                        <td>{{$item['name']}}</td>
                                        <td>{{$item['code_angkringan']}}</td>
                                        <td>{{$item['income']}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('scripts')

@endsection