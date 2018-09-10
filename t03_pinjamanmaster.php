<?php

// NoKontrak
// TglKontrak
// nasabah_id
// Pinjaman
// Bunga
// Denda
// DispensasiDenda
// LamaAngsuran
// JumlahAngsuran
// NoKontrakRefTo

?>
<?php if ($t03_pinjaman->Visible) { ?>
<div class="ewMasterDiv">
<table id="tbl_t03_pinjamanmaster" class="table ewViewTable ewMasterTable ewVertical">
	<tbody>
<?php if ($t03_pinjaman->NoKontrak->Visible) { // NoKontrak ?>
		<tr id="r_NoKontrak">
			<td class="col-sm-2"><?php echo $t03_pinjaman->NoKontrak->FldCaption() ?></td>
			<td<?php echo $t03_pinjaman->NoKontrak->CellAttributes() ?>>
<span id="el_t03_pinjaman_NoKontrak">
<span<?php echo $t03_pinjaman->NoKontrak->ViewAttributes() ?>>
<?php echo $t03_pinjaman->NoKontrak->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t03_pinjaman->TglKontrak->Visible) { // TglKontrak ?>
		<tr id="r_TglKontrak">
			<td class="col-sm-2"><?php echo $t03_pinjaman->TglKontrak->FldCaption() ?></td>
			<td<?php echo $t03_pinjaman->TglKontrak->CellAttributes() ?>>
<span id="el_t03_pinjaman_TglKontrak">
<span<?php echo $t03_pinjaman->TglKontrak->ViewAttributes() ?>>
<?php echo $t03_pinjaman->TglKontrak->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t03_pinjaman->nasabah_id->Visible) { // nasabah_id ?>
		<tr id="r_nasabah_id">
			<td class="col-sm-2"><?php echo $t03_pinjaman->nasabah_id->FldCaption() ?></td>
			<td<?php echo $t03_pinjaman->nasabah_id->CellAttributes() ?>>
<span id="el_t03_pinjaman_nasabah_id">
<span<?php echo $t03_pinjaman->nasabah_id->ViewAttributes() ?>>
<?php echo $t03_pinjaman->nasabah_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t03_pinjaman->Pinjaman->Visible) { // Pinjaman ?>
		<tr id="r_Pinjaman">
			<td class="col-sm-2"><?php echo $t03_pinjaman->Pinjaman->FldCaption() ?></td>
			<td<?php echo $t03_pinjaman->Pinjaman->CellAttributes() ?>>
<span id="el_t03_pinjaman_Pinjaman">
<span<?php echo $t03_pinjaman->Pinjaman->ViewAttributes() ?>>
<?php echo $t03_pinjaman->Pinjaman->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t03_pinjaman->Bunga->Visible) { // Bunga ?>
		<tr id="r_Bunga">
			<td class="col-sm-2"><?php echo $t03_pinjaman->Bunga->FldCaption() ?></td>
			<td<?php echo $t03_pinjaman->Bunga->CellAttributes() ?>>
<span id="el_t03_pinjaman_Bunga">
<span<?php echo $t03_pinjaman->Bunga->ViewAttributes() ?>>
<?php echo $t03_pinjaman->Bunga->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t03_pinjaman->Denda->Visible) { // Denda ?>
		<tr id="r_Denda">
			<td class="col-sm-2"><?php echo $t03_pinjaman->Denda->FldCaption() ?></td>
			<td<?php echo $t03_pinjaman->Denda->CellAttributes() ?>>
<span id="el_t03_pinjaman_Denda">
<span<?php echo $t03_pinjaman->Denda->ViewAttributes() ?>>
<?php echo $t03_pinjaman->Denda->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t03_pinjaman->DispensasiDenda->Visible) { // DispensasiDenda ?>
		<tr id="r_DispensasiDenda">
			<td class="col-sm-2"><?php echo $t03_pinjaman->DispensasiDenda->FldCaption() ?></td>
			<td<?php echo $t03_pinjaman->DispensasiDenda->CellAttributes() ?>>
<span id="el_t03_pinjaman_DispensasiDenda">
<span<?php echo $t03_pinjaman->DispensasiDenda->ViewAttributes() ?>>
<?php echo $t03_pinjaman->DispensasiDenda->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t03_pinjaman->LamaAngsuran->Visible) { // LamaAngsuran ?>
		<tr id="r_LamaAngsuran">
			<td class="col-sm-2"><?php echo $t03_pinjaman->LamaAngsuran->FldCaption() ?></td>
			<td<?php echo $t03_pinjaman->LamaAngsuran->CellAttributes() ?>>
<span id="el_t03_pinjaman_LamaAngsuran">
<span<?php echo $t03_pinjaman->LamaAngsuran->ViewAttributes() ?>>
<?php echo $t03_pinjaman->LamaAngsuran->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t03_pinjaman->JumlahAngsuran->Visible) { // JumlahAngsuran ?>
		<tr id="r_JumlahAngsuran">
			<td class="col-sm-2"><?php echo $t03_pinjaman->JumlahAngsuran->FldCaption() ?></td>
			<td<?php echo $t03_pinjaman->JumlahAngsuran->CellAttributes() ?>>
<span id="el_t03_pinjaman_JumlahAngsuran">
<span<?php echo $t03_pinjaman->JumlahAngsuran->ViewAttributes() ?>>
<?php echo $t03_pinjaman->JumlahAngsuran->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t03_pinjaman->NoKontrakRefTo->Visible) { // NoKontrakRefTo ?>
		<tr id="r_NoKontrakRefTo">
			<td class="col-sm-2"><?php echo $t03_pinjaman->NoKontrakRefTo->FldCaption() ?></td>
			<td<?php echo $t03_pinjaman->NoKontrakRefTo->CellAttributes() ?>>
<span id="el_t03_pinjaman_NoKontrakRefTo">
<span<?php echo $t03_pinjaman->NoKontrakRefTo->ViewAttributes() ?>>
<?php echo $t03_pinjaman->NoKontrakRefTo->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>
