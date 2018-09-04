<?php
echo "KARTU ANGSURAN PINJAMAN";
$tgl=date("Y-m-d");  //ngambil tanggal dari sistem
?>

<table border=0>
<form method=post action="proses.php" name=angsur>
<tr><td>Nama :</td>
<td><input type=text name=nama></td></tr>
<tr><td>NIP :</td>
<td><input type=text name=nip></td></tr>
<tr><td>Tanggal :</td>
<td><input type=text name=tgl value=<?php echo $tgl?>></td></tr>
<tr><td>Pinjaman</td>
<td><input type=text name=pokok></td></tr>
<tr><td>Lama Pinjam</td>
<td><input type=text name=jangka></td></tr>
<tr><td><input type=submit value=CETAK></td></tr>
</form>
</table>