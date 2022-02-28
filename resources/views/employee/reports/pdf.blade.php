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
    <h1>Laporan Tahunan</h1>
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
 
</body>
</html>