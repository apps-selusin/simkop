<?php

// Customer
// Pekerjaan
// Alamat
// NoTelpHp

?>
<?php if ($t01_nasabah->Visible) { ?>
<div class="ewMasterDiv">
<table id="tbl_t01_nasabahmaster" class="table ewViewTable ewMasterTable ewVertical">
	<tbody>
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
<?php if ($t01_nasabah->Pekerjaan->Visible) { // Pekerjaan ?>
		<tr id="r_Pekerjaan">
			<td class="col-sm-2"><?php echo $t01_nasabah->Pekerjaan->FldCaption() ?></td>
			<td<?php echo $t01_nasabah->Pekerjaan->CellAttributes() ?>>
<span id="el_t01_nasabah_Pekerjaan">
<span<?php echo $t01_nasabah->Pekerjaan->ViewAttributes() ?>>
<?php echo $t01_nasabah->Pekerjaan->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t01_nasabah->Alamat->Visible) { // Alamat ?>
		<tr id="r_Alamat">
			<td class="col-sm-2"><?php echo $t01_nasabah->Alamat->FldCaption() ?></td>
			<td<?php echo $t01_nasabah->Alamat->CellAttributes() ?>>
<span id="el_t01_nasabah_Alamat">
<span<?php echo $t01_nasabah->Alamat->ViewAttributes() ?>>
<?php echo $t01_nasabah->Alamat->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t01_nasabah->NoTelpHp->Visible) { // NoTelpHp ?>
		<tr id="r_NoTelpHp">
			<td class="col-sm-2"><?php echo $t01_nasabah->NoTelpHp->FldCaption() ?></td>
			<td<?php echo $t01_nasabah->NoTelpHp->CellAttributes() ?>>
<span id="el_t01_nasabah_NoTelpHp">
<span<?php echo $t01_nasabah->NoTelpHp->ViewAttributes() ?>>
<?php echo $t01_nasabah->NoTelpHp->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>
