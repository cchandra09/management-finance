<?php

function getMonths()
{
    return [
        '01' => "Januari",
        '02' => "Febuari",
        '03' => "Maret",
        '04' => "April",
        '05' => "Mei",
        '06' => "Juni",
        '07' => "Juli",
        '08' => "Agustus",
        '09' => "September",
        '10' => "Oktober",
        '11' => "November",
        '12' => "Desember",
    ];
}
// function getMonths()
// {
//     return [
//         '01' => __('time.months.01'),
//         '02' => __('time.months.02'),
//         '03' => __('time.months.03'),
//         '04' => __('time.months.04'),
//         '05' => __('time.months.05'),
//         '06' => __('time.months.06'),
//         '07' => __('time.months.07'),
//         '08' => __('time.months.08'),
//         '09' => __('time.months.09'),
//         '10' => __('time.months.10'),
//         '11' => __('time.months.11'),
//         '12' => __('time.months.12'),
//     ];
// }
function getMonthsName()
{
    return [
        '01' => "Januari",
        '02' => "Febuari",
        '03' => "Maret",
        '04' => "April",
        '05' => "Mei",
        '06' => "Juni",
        '07' => "Juli",
        '08' => "Agustus",
        '09' => "September",
        '10' => "Oktober",
        '11' => "November",
        '12' => "Desember",
    ];
}

function getYears()
{
    $yearRange = range(2018, date('Y'));
    foreach ($yearRange as $year) {
        $years[$year] = $year;
    }

    return $years;
}

function monthNumber($number)
{
    return str_pad($number, 2, '0', STR_PAD_LEFT);
}

function monthId($monthNumber)
{
    if (is_null($monthNumber)) {
        return $monthNumber;
    }

    $months = getMonths();
    $monthNumber = monthNumber($monthNumber);

    return $months[$monthNumber];
}
