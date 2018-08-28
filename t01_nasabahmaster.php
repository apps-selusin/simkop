<?php

// NoKontrak
// Customer
// TglKontrak
// Pinjaman
// Denda
// DispensasiDenda
// LamaAngsuran
// JumlahAngsuran

?>
<?php if ($t01_nasabah->Visible) { ?>
<div class="ewMasterDiv">
<table id="tbl_t01_nasabahmaster" class="table ewViewTable ewMasterTable ewVertical">
	<tbody>
<?php if ($t01_nasabah->NoKontrak->Visible) { // NoKontrak ?>
		<tr id="r_NoKontrak">
			<td class="col-sm-2"><?php echo $t01_nasabah->NoKontrak->FldCaption() ?></td>
			<td<?php echo $t01_nasabah->NoKontrak->CellAttributes() ?>>
<span id="el_t01_nasabah_NoKontrak">
<span<?php echo $t01_nasabah->NoKontrak->ViewAttributes() ?>>
<?php echo $t01_nasabah->NoKontrak->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t01_nasabah->Customer->Visible) { // Customer ?>
		<tr id="r_Customer">
			<td class="col-sm-2"><?php echo $t01_nasabah->Customer->FldCaption() ?></td>
			<td<?php echo $t01_nasabah->Customer->CellAttributes() ?>>
<span id="el_t01_nasabah_Customer">
<span<?php echo $t01_nasabah->Customer->ViewAttributes() ?>>
<?php echo $t01_nasabah->Customer->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t01_nasabah->TglKontrak->Visible) { // TglKontrak ?>
		<tr id="r_TglKontrak">
			<td class="col-sm-2"><?php echo $t01_nasabah->TglKontrak->FldCaption() ?></td>
			<td<?php echo $t01_nasabah->TglKontrak->CellAttributes() ?>>
<span id="el_t01_nasabah_TglKontrak">
<span<?php echo $t01_nasabah->TglKontrak->ViewAttributes() ?>>
<?php echo $t01_nasabah->TglKontrak->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t01_nasabah->Pinjaman->Visible) { // Pinjaman ?>
		<tr id="r_Pinjaman">
			<td class="col-sm-2"><?php echo $t01_nasabah->Pinjaman->FldCaption() ?></td>
			<td<?php echo $t01_nasabah->Pinjaman->CellAttributes() ?>>
<span id="el_t01_nasabah_Pinjaman">
<span<?php echo $t01_nasabah->Pinjaman->ViewAttributes() ?>>
<?php echo $t01_nasabah->Pinjaman->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t01_nasabah->Denda->Visible) { // Denda ?>
		<tr id="r_Denda">
			<td class="col-sm-2"><?php echo $t01_nasabah->Denda->FldCaption() ?></td>
			<td<?php echo $t01_nasabah->Denda->CellAttributes() ?>>
<span id="el_t01_nasabah_Denda">
<span<?php echo $t01_nasabah->Denda->ViewAttributes() ?>>
<?php echo $t01_nasabah->Denda->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t01_nasabah->DispensasiDenda->Visible) { // DispensasiDenda ?>
		<tr id="r_DispensasiDenda">
			<td class="col-sm-2"><?php echo $t01_nasabah->DispensasiDenda->FldCaption() ?></td>
			<td<?php echo $t01_nasabah->DispensasiDenda->CellAttributes() ?>>
<span id="el_t01_nasabah_DispensasiDenda">
<span<?php echo $t01_nasabah->DispensasiDenda->ViewAttributes() ?>>
<?php echo $t01_nasabah->DispensasiDenda->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t01_nasabah->LamaAngsuran->Visible) { // LamaAngsuran ?>
		<tr id="r_LamaAngsuran">
			<td class="col-sm-2"><?php echo $t01_nasabah->LamaAngsuran->FldCaption() ?></td>
			<td<?php echo $t01_nasabah->LamaAngsuran->CellAttributes() ?>>
<span id="el_t01_nasabah_LamaAngsuran">
<span<?php echo $t01_nasabah->LamaAngsuran->ViewAttributes() ?>>
<?php echo $t01_nasabah->LamaAngsuran->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t01_nasabah->JumlahAngsuran->Visible) { // JumlahAngsuran ?>
		<tr id="r_JumlahAngsuran">
			<td class="col-sm-2"><?php echo $t01_nasabah->JumlahAngsuran->FldCaption() ?></td>
			<td<?php echo $t01_nasabah->JumlahAngsuran->CellAttributes() ?>>
<span id="el_t01_nasabah_JumlahAngsuran">
<span<?php echo $t01_nasabah->JumlahAngsuran->ViewAttributes() ?>>
<?php echo $t01_nasabah->JumlahAngsuran->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>
