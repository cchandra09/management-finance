<html>
<head>
	<title>Laporan</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
        h1{
            font-size: 24px;
            font-family: Arial, Helvetica, sans-serif
        }
        h5{
            font-size: 18px;
            font-family: Arial, Helvetica, sans-serif
        }
	</style>
    <h1>Laporan {{$user->name}}</h1>
    <h5>{{$start_date}} - {{$end_date}}</h5>
	<table class="datatables-ajax table mt-3">
        <tr>
            <td>No</td>
            <td class="text-left">Tanggal</td>
            <td class="text-left">Makanan</td>
            <td class="text-left">Harga</td>
            <td class="text-left">Qty</td>
            <td class="text-left">Total</td>
        </tr>
         @php $no = 1; @endphp
         @foreach($transaction as $item)

            <tr>
                <td>{{$no++}}</td>
                <td>{{$item->date_transaction}}</td>
                <td>{{$item->name}}</td>
                <td>{{$item->price }}</td>
                <td>{{$item->qty}}</td>
                <td>{{$item->total}}</td>
            </tr>
            <tr>
                <td colspan="5">Total Nominal Transaksi</td>
                <td>{{$total_transaction}}</td>
            </tr>

         @endforeach
    </table>
 
</body>
</html>