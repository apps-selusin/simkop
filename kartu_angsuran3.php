<?php
    include "userfn14.php";

    $rsnew = array(
        "id" => 1,
        "TglKontrak" => "2018-09-29",
        "Pinjaman" => 10400000,
        "LamaAngsuran" => 12,
        "JumlahAngsuran" => 1100000
    );

    $pinjaman_id     = $rsnew["id"];
    $AngsuranTanggal = $_GET["TglKontrak"]; //$rsnew["TglKontrak"];
    $AngsuranTgl     = substr($AngsuranTanggal, -2); //substr($rsnew["TglKontrak"], -2);
    $AngsuranPokok   = round($rsnew["Pinjaman"] / $rsnew["LamaAngsuran"], -3);
    $AngsuranBunga   = $rsnew["JumlahAngsuran"] - $AngsuranPokok;
    $AngsuranTotal   = $AngsuranPokok + $AngsuranBunga;
    $SisaHutang      = $rsnew["Pinjaman"]; // - $AngsuranTotal;

    echo "
    <table border='1'>
        <tr>
            <th>pinjaman_id</th>
            <th>Angsuran Ke</th>
            <th>Angsuran Tanggal</th>
            <th>Angsuran Pokok</th>
            <th>Angsuran Bunga</th>
            <th>Total Angsuran</th>
            <th>Sisa Hutang</th>
        <tr>
    ";

    $AngsuranPokokTotal = 0;
    $AngsuranBungaTotal = 0;
    $AngsuranTotalGrand = 0;
	for ($AngsuranKe = 1; $AngsuranKe <= $rsnew["LamaAngsuran"]; $AngsuranKe++) {
        $AngsuranTanggal = f_TanggalAngsuran($AngsuranTanggal, $AngsuranTgl);
        
		/*$q = "insert into t02_angsuran (
			NoKontrak,
			Tanggal,
			AngsuranPokok,
			AngsuranBunga,
			AngsuranTotal,
			SisaHutang
			) values (
			'".$NoKontrak."',
			'".$dTanggal."',
			".$AngsuranPokok.",
			".$AngsuranBunga.",
			".$AngsuranTotal.",
			".$SisaHutang."
			)";
        ew_Execute($q);*/

        $AngsuranPokokTotal += $AngsuranPokok;
        
        if ($AngsuranPokokTotal >= $rsnew["Pinjaman"]) {
            $AngsuranPokok = $AngsuranPokok - ($AngsuranPokokTotal - $rsnew["Pinjaman"]);
            $AngsuranPokokTotal = $AngsuranPokokTotal - ($AngsuranPokokTotal - $rsnew["Pinjaman"]);
        }
        $SisaHutang -= $AngsuranPokok;

        $AngsuranBunga = $AngsuranTotal - $AngsuranPokok;
        $AngsuranBungaTotal += $AngsuranBunga;
        $AngsuranTotalGrand += $AngsuranTotal;

        echo "
            <tr>
                <td>".$pinjaman_id."</td>
                <td>".$AngsuranKe."</td>
                <td>".$AngsuranTanggal."</td>
                <td>".$AngsuranPokok."</td>
                <td>".$AngsuranBunga."</td>
                <td>".$AngsuranTotal."</td>
                <td>".$SisaHutang."</td>
            </tr>
        ";
        
    }
    echo "
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>".$AngsuranPokokTotal."</td>
            <td>".$AngsuranBungaTotal."</td>
            <td>".$AngsuranTotalGrand."</td>
            <td>&nbsp;</td>
        <tr>
    </table>";
?>