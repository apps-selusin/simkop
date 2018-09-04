<?php
$nama_bln=array(1=>"January", "Februari", "Maret", "April", "Mei", "Juni", "Juli", 
"Agustus", "September", "Oktober", "November", "Desember");
echo $nama=$_POST["nama"];
$nip=$_POST["nip"];
$tgl=$_POST["tgl"];

//memecah tanggal dari sistem jadi $tanggal,$bulan,$tahun…

list($awal,$tengah,$akhir)=explode("-",$tgl,3);
echo $tanggal=$akhir;
echo "-";
if ($tengah < 10) {
$bulan=str_replace("0","",$tengah);
}else{
$bulan=$tengah;
}

//$bulan=$tengah;
echo $nama_bln[$bulan];
echo "-";
echo $tahun=$awal;

$pokok=$_POST["pokok"];
$jangka=$_POST["jangka"];


//rumus hitung pokok yang harus di bayar tiap bulan
$pokok_b=($pokok / $jangka);


/*
pembulatan pokok angsuran
**/
$sisa = $pokok_b % 100;
if ($sisa > 0) {
    $bulat= 100 - $sisa;
    $hasil=$pokok_b + $bulat;
}
else{
$hasil=$pokok_b;
}


//rumus hitung bunga atau jasa flat 2 % per bulan
$jasa=($pokok*0.02);


/*
pembulatan Jasa angsuran
**/
$sisa_j = $jasa % 100;
if ($sisa_j > 0){
echo $bulat_j= 100 - $sisa_j;
$hasil_j=$jasa+ $bulat_j;
}
else{
$hasil_j=$jasa;
}


//total yang harus dibayar tiap bula (pokok+jasa)
$total=($hasil+$hasil_j);

?>
<BR><b>KARTU ANGSURAN
<table border=1>
<tr><td>Angsuran Ke-</td><td colspan="3">Angsuran</td><td>Saldo Pokok</td><td>Rencana Pelunasan</td><td>TTD</td></tr>
<tr><td></td><td>Pokok</td><td>Jasa</td><td>Total</td><td></td><td></td><td></td></tr>
<?php
$angsur=$pokok;
for($i=1;$i<=$jangka;$i++){
$angsur=$angsur - floor($hasil);
$bulan=$bulan+1;
if ($bulan > 12){
$bulan=1;
$tahun=$tahun+1;
}else{
$bulan=$bulan;
}
?>
<tr><td><?php echo $i ;?></td>
<td><?php echo floor($hasil);?></td>
<td><?php echo floor($hasil_j);?></td>
<td><?php echo floor($total );?></td>
<td><?php echo $angsur ;?></td>
<td><?php echo $tanggal;echo "-";echo $nama_bln[$bulan];echo "-";echo $tahun ;?></td>
<td></td></tr>
<?php
}
?>
</table>