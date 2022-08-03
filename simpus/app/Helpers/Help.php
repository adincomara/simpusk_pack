<?php

function hitung_umur($tanggal_lahir){
    $tanggal_lahir = date('Y-m-d', strtotime($tanggal_lahir));
	$birthDate = new DateTime($tanggal_lahir);
    // return $birthDate;
	$today = new DateTime("today");
	if ($birthDate > $today) {
	    exit("0 tahun");
	}
	$y = $today->diff($birthDate)->y;
	$m = $today->diff($birthDate)->m;
	$d = $today->diff($birthDate)->d;
	return $y." tahun ";
}
function hari_sekarang(){
    setlocale(LC_TIME, 'id_ID');
    \Carbon\Carbon::setLocale('id');
    $now = \Carbon\Carbon::parse(date('Y-m-d'));
    return \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y');;
}
function tes(){
    return "testing";
}
function format_uang($angka){
    $hasil=number_format($angka,0,',','.');
	return $hasil;
}
?>
