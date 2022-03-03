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
	</style>
    <h1>Laporan {{$user->name}}</h1>
	<table class="datatables-ajax table">
        <tr>
            <td>No</td>
            <td class="text-left">Tanggal</td>
            <td class="text-right">Nominal</td>
            <td class="text-right">Status</td>
            <td class="text-right">Deskripsi</td>
        </tr>
         @php $no = 1; @endphp
         @foreach($transaction as $item)

            <tr>
                <td>{{$no++}}</td>
                <td>{{$item->date_transaction}}</td>
                <td>{{$item->amount}}</td>
                <td>{{($item->status == 1) ? 'MASUK' : 'KELUAR'}}</td>
                <td>{{$item->description}}</td>
            </tr>

         @endforeach
    </table>
 
</body>
</html>