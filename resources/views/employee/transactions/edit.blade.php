@extends('layouts.employee.app')
@section('title')
HIPHOP - EDIT TRANSAKSI
@endsection
@section('content')

<div class="content-body">
    <section id="multiple-column-form">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tambah Transaksi</h4>
                    </div>
                    <div class="card-body">
                        <form class="form" action="{{route('employee.transaction.update', $transaction->id)}}" method="POST">
                            <div class="row">
                                @csrf
                                @method('PUT')
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="first-name-column">Tanggal Transaksi</label>
                                        <input type="text" value="{{$transaction->date_transaction}}" id="fp-default" name="date_transaction" class="form-control flatpickr-basic flatpickr-input active" placeholder="YYYY-MM-DD" readonly="readonly">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="last-name-column">Kategori</label>
                                        <select class="form-control" name="category_id" id="basicSelect">
                                            <option value="{{$transaction->category_id}}">{{$transaction->Category->name}}</option>
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="amount">Nominal</label>
                                        <input type="text" id="amount" value="{{$transaction->amount}}" name="amount" class="form-control" placeholder="Nominal" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="last-name-column">Status</label>
                                            <select class="form-control" name="status" id="basicSelect">
                                                <option value="{{$transaction->status}}">{{($transaction->status == "in") ? 'Masuk' : 'Keluar'}}</option>
                                                <option>-- Pilih Status --</option>
                                                <option value="in">Masuk</option>
                                                <option value="out">Keluar</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="company-column">Deskripsi</label>
                                        <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3" placeholder="Textarea">{{$transaction->description}}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary mr-1">Submit</button>
                                    <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('scripts')

@endsection