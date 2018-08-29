<?php include_once "t96_employeesinfo.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t02_angsuran_grid)) $t02_angsuran_grid = new ct02_angsuran_grid();

// Page init
$t02_angsuran_grid->Page_Init();

// Page main
$t02_angsuran_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t02_angsuran_grid->Page_Render();
?>
<?php if ($t02_angsuran->Export == "") { ?>
<script type="text/javascript">

// Form object
var ft02_angsurangrid = new ew_Form("ft02_angsurangrid", "grid");
ft02_angsurangrid.FormKeyCountName = '<?php echo $t02_angsuran_grid->FormKeyCountName ?>';

// Validate form
ft02_angsurangrid.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			elm = this.GetElements("x" + infix + "_NoKontrak");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t02_angsuran->NoKontrak->FldCaption(), $t02_angsuran->NoKontrak->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_NoKontrak");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t02_angsuran->NoKontrak->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Tanggal");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t02_angsuran->Tanggal->FldCaption(), $t02_angsuran->Tanggal->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Tanggal");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t02_angsuran->Tanggal->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_AngsuranPokok");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t02_angsuran->AngsuranPokok->FldCaption(), $t02_angsuran->AngsuranPokok->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_AngsuranPokok");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t02_angsuran->AngsuranPokok->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_AngsuranBunga");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t02_angsuran->AngsuranBunga->FldCaption(), $t02_angsuran->AngsuranBunga->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_AngsuranBunga");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t02_angsuran->AngsuranBunga->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_AngsuranTotal");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t02_angsuran->AngsuranTotal->FldCaption(), $t02_angsuran->AngsuranTotal->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_AngsuranTotal");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t02_angsuran->AngsuranTotal->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_SisaHutang");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t02_angsuran->SisaHutang->FldCaption(), $t02_angsuran->SisaHutang->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_SisaHutang");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t02_angsuran->SisaHutang->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_TanggalBayar");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t02_angsuran->TanggalBayar->FldCaption(), $t02_angsuran->TanggalBayar->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_TanggalBayar");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t02_angsuran->TanggalBayar->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_TotalDenda");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t02_angsuran->TotalDenda->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Terlambat");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t02_angsuran->Terlambat->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ft02_angsurangrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "NoKontrak", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Tanggal", false)) return false;
	if (ew_ValueChanged(fobj, infix, "AngsuranPokok", false)) return false;
	if (ew_ValueChanged(fobj, infix, "AngsuranBunga", false)) return false;
	if (ew_ValueChanged(fobj, infix, "AngsuranTotal", false)) return false;
	if (ew_ValueChanged(fobj, infix, "SisaHutang", false)) return false;
	if (ew_ValueChanged(fobj, infix, "TanggalBayar", false)) return false;
	if (ew_ValueChanged(fobj, infix, "TotalDenda", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Terlambat", false)) return false;
	return true;
}

// Form_CustomValidate event
ft02_angsurangrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft02_angsurangrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($t02_angsuran->CurrentAction == "gridadd") {
	if ($t02_angsuran->CurrentMode == "copy") {
		$bSelectLimit = $t02_angsuran_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$t02_angsuran_grid->TotalRecs = $t02_angsuran->ListRecordCount();
			$t02_angsuran_grid->Recordset = $t02_angsuran_grid->LoadRecordset($t02_angsuran_grid->StartRec-1, $t02_angsuran_grid->DisplayRecs);
		} else {
			if ($t02_angsuran_grid->Recordset = $t02_angsuran_grid->LoadRecordset())
				$t02_angsuran_grid->TotalRecs = $t02_angsuran_grid->Recordset->RecordCount();
		}
		$t02_angsuran_grid->StartRec = 1;
		$t02_angsuran_grid->DisplayRecs = $t02_angsuran_grid->TotalRecs;
	} else {
		$t02_angsuran->CurrentFilter = "0=1";
		$t02_angsuran_grid->StartRec = 1;
		$t02_angsuran_grid->DisplayRecs = $t02_angsuran->GridAddRowCount;
	}
	$t02_angsuran_grid->TotalRecs = $t02_angsuran_grid->DisplayRecs;
	$t02_angsuran_grid->StopRec = $t02_angsuran_grid->DisplayRecs;
} else {
	$bSelectLimit = $t02_angsuran_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t02_angsuran_grid->TotalRecs <= 0)
			$t02_angsuran_grid->TotalRecs = $t02_angsuran->ListRecordCount();
	} else {
		if (!$t02_angsuran_grid->Recordset && ($t02_angsuran_grid->Recordset = $t02_angsuran_grid->LoadRecordset()))
			$t02_angsuran_grid->TotalRecs = $t02_angsuran_grid->Recordset->RecordCount();
	}
	$t02_angsuran_grid->StartRec = 1;
	$t02_angsuran_grid->DisplayRecs = $t02_angsuran_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$t02_angsuran_grid->Recordset = $t02_angsuran_grid->LoadRecordset($t02_angsuran_grid->StartRec-1, $t02_angsuran_grid->DisplayRecs);

	// Set no record found message
	if ($t02_angsuran->CurrentAction == "" && $t02_angsuran_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$t02_angsuran_grid->setWarningMessage(ew_DeniedMsg());
		if ($t02_angsuran_grid->SearchWhere == "0=101")
			$t02_angsuran_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t02_angsuran_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$t02_angsuran_grid->RenderOtherOptions();
?>
<?php $t02_angsuran_grid->ShowPageHeader(); ?>
<?php
$t02_angsuran_grid->ShowMessage();
?>
<?php if ($t02_angsuran_grid->TotalRecs > 0 || $t02_angsuran->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($t02_angsuran_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> t02_angsuran">
<div id="ft02_angsurangrid" class="ewForm ewListForm form-inline">
<div id="gmp_t02_angsuran" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_t02_angsurangrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$t02_angsuran_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t02_angsuran_grid->RenderListOptions();

// Render list options (header, left)
$t02_angsuran_grid->ListOptions->Render("header", "left");
?>
<?php if ($t02_angsuran->id->Visible) { // id ?>
	<?php if ($t02_angsuran->SortUrl($t02_angsuran->id) == "") { ?>
		<th data-name="id" class="<?php echo $t02_angsuran->id->HeaderCellClass() ?>"><div id="elh_t02_angsuran_id" class="t02_angsuran_id"><div class="ewTableHeaderCaption"><?php echo $t02_angsuran->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id" class="<?php echo $t02_angsuran->id->HeaderCellClass() ?>"><div><div id="elh_t02_angsuran_id" class="t02_angsuran_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_angsuran->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_angsuran->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_angsuran->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_angsuran->NoKontrak->Visible) { // NoKontrak ?>
	<?php if ($t02_angsuran->SortUrl($t02_angsuran->NoKontrak) == "") { ?>
		<th data-name="NoKontrak" class="<?php echo $t02_angsuran->NoKontrak->HeaderCellClass() ?>"><div id="elh_t02_angsuran_NoKontrak" class="t02_angsuran_NoKontrak"><div class="ewTableHeaderCaption"><?php echo $t02_angsuran->NoKontrak->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NoKontrak" class="<?php echo $t02_angsuran->NoKontrak->HeaderCellClass() ?>"><div><div id="elh_t02_angsuran_NoKontrak" class="t02_angsuran_NoKontrak">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_angsuran->NoKontrak->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_angsuran->NoKontrak->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_angsuran->NoKontrak->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_angsuran->Tanggal->Visible) { // Tanggal ?>
	<?php if ($t02_angsuran->SortUrl($t02_angsuran->Tanggal) == "") { ?>
		<th data-name="Tanggal" class="<?php echo $t02_angsuran->Tanggal->HeaderCellClass() ?>"><div id="elh_t02_angsuran_Tanggal" class="t02_angsuran_Tanggal"><div class="ewTableHeaderCaption"><?php echo $t02_angsuran->Tanggal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Tanggal" class="<?php echo $t02_angsuran->Tanggal->HeaderCellClass() ?>"><div><div id="elh_t02_angsuran_Tanggal" class="t02_angsuran_Tanggal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_angsuran->Tanggal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_angsuran->Tanggal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_angsuran->Tanggal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_angsuran->AngsuranPokok->Visible) { // AngsuranPokok ?>
	<?php if ($t02_angsuran->SortUrl($t02_angsuran->AngsuranPokok) == "") { ?>
		<th data-name="AngsuranPokok" class="<?php echo $t02_angsuran->AngsuranPokok->HeaderCellClass() ?>"><div id="elh_t02_angsuran_AngsuranPokok" class="t02_angsuran_AngsuranPokok"><div class="ewTableHeaderCaption"><?php echo $t02_angsuran->AngsuranPokok->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="AngsuranPokok" class="<?php echo $t02_angsuran->AngsuranPokok->HeaderCellClass() ?>"><div><div id="elh_t02_angsuran_AngsuranPokok" class="t02_angsuran_AngsuranPokok">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_angsuran->AngsuranPokok->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_angsuran->AngsuranPokok->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_angsuran->AngsuranPokok->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_angsuran->AngsuranBunga->Visible) { // AngsuranBunga ?>
	<?php if ($t02_angsuran->SortUrl($t02_angsuran->AngsuranBunga) == "") { ?>
		<th data-name="AngsuranBunga" class="<?php echo $t02_angsuran->AngsuranBunga->HeaderCellClass() ?>"><div id="elh_t02_angsuran_AngsuranBunga" class="t02_angsuran_AngsuranBunga"><div class="ewTableHeaderCaption"><?php echo $t02_angsuran->AngsuranBunga->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="AngsuranBunga" class="<?php echo $t02_angsuran->AngsuranBunga->HeaderCellClass() ?>"><div><div id="elh_t02_angsuran_AngsuranBunga" class="t02_angsuran_AngsuranBunga">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_angsuran->AngsuranBunga->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_angsuran->AngsuranBunga->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_angsuran->AngsuranBunga->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_angsuran->AngsuranTotal->Visible) { // AngsuranTotal ?>
	<?php if ($t02_angsuran->SortUrl($t02_angsuran->AngsuranTotal) == "") { ?>
		<th data-name="AngsuranTotal" class="<?php echo $t02_angsuran->AngsuranTotal->HeaderCellClass() ?>"><div id="elh_t02_angsuran_AngsuranTotal" class="t02_angsuran_AngsuranTotal"><div class="ewTableHeaderCaption"><?php echo $t02_angsuran->AngsuranTotal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="AngsuranTotal" class="<?php echo $t02_angsuran->AngsuranTotal->HeaderCellClass() ?>"><div><div id="elh_t02_angsuran_AngsuranTotal" class="t02_angsuran_AngsuranTotal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_angsuran->AngsuranTotal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_angsuran->AngsuranTotal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_angsuran->AngsuranTotal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_angsuran->SisaHutang->Visible) { // SisaHutang ?>
	<?php if ($t02_angsuran->SortUrl($t02_angsuran->SisaHutang) == "") { ?>
		<th data-name="SisaHutang" class="<?php echo $t02_angsuran->SisaHutang->HeaderCellClass() ?>"><div id="elh_t02_angsuran_SisaHutang" class="t02_angsuran_SisaHutang"><div class="ewTableHeaderCaption"><?php echo $t02_angsuran->SisaHutang->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="SisaHutang" class="<?php echo $t02_angsuran->SisaHutang->HeaderCellClass() ?>"><div><div id="elh_t02_angsuran_SisaHutang" class="t02_angsuran_SisaHutang">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_angsuran->SisaHutang->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_angsuran->SisaHutang->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_angsuran->SisaHutang->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_angsuran->TanggalBayar->Visible) { // TanggalBayar ?>
	<?php if ($t02_angsuran->SortUrl($t02_angsuran->TanggalBayar) == "") { ?>
		<th data-name="TanggalBayar" class="<?php echo $t02_angsuran->TanggalBayar->HeaderCellClass() ?>"><div id="elh_t02_angsuran_TanggalBayar" class="t02_angsuran_TanggalBayar"><div class="ewTableHeaderCaption"><?php echo $t02_angsuran->TanggalBayar->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="TanggalBayar" class="<?php echo $t02_angsuran->TanggalBayar->HeaderCellClass() ?>"><div><div id="elh_t02_angsuran_TanggalBayar" class="t02_angsuran_TanggalBayar">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_angsuran->TanggalBayar->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_angsuran->TanggalBayar->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_angsuran->TanggalBayar->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_angsuran->TotalDenda->Visible) { // TotalDenda ?>
	<?php if ($t02_angsuran->SortUrl($t02_angsuran->TotalDenda) == "") { ?>
		<th data-name="TotalDenda" class="<?php echo $t02_angsuran->TotalDenda->HeaderCellClass() ?>"><div id="elh_t02_angsuran_TotalDenda" class="t02_angsuran_TotalDenda"><div class="ewTableHeaderCaption"><?php echo $t02_angsuran->TotalDenda->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="TotalDenda" class="<?php echo $t02_angsuran->TotalDenda->HeaderCellClass() ?>"><div><div id="elh_t02_angsuran_TotalDenda" class="t02_angsuran_TotalDenda">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_angsuran->TotalDenda->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_angsuran->TotalDenda->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_angsuran->TotalDenda->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_angsuran->Terlambat->Visible) { // Terlambat ?>
	<?php if ($t02_angsuran->SortUrl($t02_angsuran->Terlambat) == "") { ?>
		<th data-name="Terlambat" class="<?php echo $t02_angsuran->Terlambat->HeaderCellClass() ?>"><div id="elh_t02_angsuran_Terlambat" class="t02_angsuran_Terlambat"><div class="ewTableHeaderCaption"><?php echo $t02_angsuran->Terlambat->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Terlambat" class="<?php echo $t02_angsuran->Terlambat->HeaderCellClass() ?>"><div><div id="elh_t02_angsuran_Terlambat" class="t02_angsuran_Terlambat">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_angsuran->Terlambat->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_angsuran->Terlambat->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_angsuran->Terlambat->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$t02_angsuran_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$t02_angsuran_grid->StartRec = 1;
$t02_angsuran_grid->StopRec = $t02_angsuran_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t02_angsuran_grid->FormKeyCountName) && ($t02_angsuran->CurrentAction == "gridadd" || $t02_angsuran->CurrentAction == "gridedit" || $t02_angsuran->CurrentAction == "F")) {
		$t02_angsuran_grid->KeyCount = $objForm->GetValue($t02_angsuran_grid->FormKeyCountName);
		$t02_angsuran_grid->StopRec = $t02_angsuran_grid->StartRec + $t02_angsuran_grid->KeyCount - 1;
	}
}
$t02_angsuran_grid->RecCnt = $t02_angsuran_grid->StartRec - 1;
if ($t02_angsuran_grid->Recordset && !$t02_angsuran_grid->Recordset->EOF) {
	$t02_angsuran_grid->Recordset->MoveFirst();
	$bSelectLimit = $t02_angsuran_grid->UseSelectLimit;
	if (!$bSelectLimit && $t02_angsuran_grid->StartRec > 1)
		$t02_angsuran_grid->Recordset->Move($t02_angsuran_grid->StartRec - 1);
} elseif (!$t02_angsuran->AllowAddDeleteRow && $t02_angsuran_grid->StopRec == 0) {
	$t02_angsuran_grid->StopRec = $t02_angsuran->GridAddRowCount;
}

// Initialize aggregate
$t02_angsuran->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t02_angsuran->ResetAttrs();
$t02_angsuran_grid->RenderRow();
if ($t02_angsuran->CurrentAction == "gridadd")
	$t02_angsuran_grid->RowIndex = 0;
if ($t02_angsuran->CurrentAction == "gridedit")
	$t02_angsuran_grid->RowIndex = 0;
while ($t02_angsuran_grid->RecCnt < $t02_angsuran_grid->StopRec) {
	$t02_angsuran_grid->RecCnt++;
	if (intval($t02_angsuran_grid->RecCnt) >= intval($t02_angsuran_grid->StartRec)) {
		$t02_angsuran_grid->RowCnt++;
		if ($t02_angsuran->CurrentAction == "gridadd" || $t02_angsuran->CurrentAction == "gridedit" || $t02_angsuran->CurrentAction == "F") {
			$t02_angsuran_grid->RowIndex++;
			$objForm->Index = $t02_angsuran_grid->RowIndex;
			if ($objForm->HasValue($t02_angsuran_grid->FormActionName))
				$t02_angsuran_grid->RowAction = strval($objForm->GetValue($t02_angsuran_grid->FormActionName));
			elseif ($t02_angsuran->CurrentAction == "gridadd")
				$t02_angsuran_grid->RowAction = "insert";
			else
				$t02_angsuran_grid->RowAction = "";
		}

		// Set up key count
		$t02_angsuran_grid->KeyCount = $t02_angsuran_grid->RowIndex;

		// Init row class and style
		$t02_angsuran->ResetAttrs();
		$t02_angsuran->CssClass = "";
		if ($t02_angsuran->CurrentAction == "gridadd") {
			if ($t02_angsuran->CurrentMode == "copy") {
				$t02_angsuran_grid->LoadRowValues($t02_angsuran_grid->Recordset); // Load row values
				$t02_angsuran_grid->SetRecordKey($t02_angsuran_grid->RowOldKey, $t02_angsuran_grid->Recordset); // Set old record key
			} else {
				$t02_angsuran_grid->LoadRowValues(); // Load default values
				$t02_angsuran_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$t02_angsuran_grid->LoadRowValues($t02_angsuran_grid->Recordset); // Load row values
		}
		$t02_angsuran->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t02_angsuran->CurrentAction == "gridadd") // Grid add
			$t02_angsuran->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t02_angsuran->CurrentAction == "gridadd" && $t02_angsuran->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t02_angsuran_grid->RestoreCurrentRowFormValues($t02_angsuran_grid->RowIndex); // Restore form values
		if ($t02_angsuran->CurrentAction == "gridedit") { // Grid edit
			if ($t02_angsuran->EventCancelled) {
				$t02_angsuran_grid->RestoreCurrentRowFormValues($t02_angsuran_grid->RowIndex); // Restore form values
			}
			if ($t02_angsuran_grid->RowAction == "insert")
				$t02_angsuran->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t02_angsuran->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t02_angsuran->CurrentAction == "gridedit" && ($t02_angsuran->RowType == EW_ROWTYPE_EDIT || $t02_angsuran->RowType == EW_ROWTYPE_ADD) && $t02_angsuran->EventCancelled) // Update failed
			$t02_angsuran_grid->RestoreCurrentRowFormValues($t02_angsuran_grid->RowIndex); // Restore form values
		if ($t02_angsuran->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t02_angsuran_grid->EditRowCnt++;
		if ($t02_angsuran->CurrentAction == "F") // Confirm row
			$t02_angsuran_grid->RestoreCurrentRowFormValues($t02_angsuran_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$t02_angsuran->RowAttrs = array_merge($t02_angsuran->RowAttrs, array('data-rowindex'=>$t02_angsuran_grid->RowCnt, 'id'=>'r' . $t02_angsuran_grid->RowCnt . '_t02_angsuran', 'data-rowtype'=>$t02_angsuran->RowType));

		// Render row
		$t02_angsuran_grid->RenderRow();

		// Render list options
		$t02_angsuran_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t02_angsuran_grid->RowAction <> "delete" && $t02_angsuran_grid->RowAction <> "insertdelete" && !($t02_angsuran_grid->RowAction == "insert" && $t02_angsuran->CurrentAction == "F" && $t02_angsuran_grid->EmptyRow())) {
?>
	<tr<?php echo $t02_angsuran->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t02_angsuran_grid->ListOptions->Render("body", "left", $t02_angsuran_grid->RowCnt);
?>
	<?php if ($t02_angsuran->id->Visible) { // id ?>
		<td data-name="id"<?php echo $t02_angsuran->id->CellAttributes() ?>>
<?php if ($t02_angsuran->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t02_angsuran" data-field="x_id" name="o<?php echo $t02_angsuran_grid->RowIndex ?>_id" id="o<?php echo $t02_angsuran_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t02_angsuran->id->OldValue) ?>">
<?php } ?>
<?php if ($t02_angsuran->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_angsuran_grid->RowCnt ?>_t02_angsuran_id" class="form-group t02_angsuran_id">
<span<?php echo $t02_angsuran->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_angsuran->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="t02_angsuran" data-field="x_id" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_id" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t02_angsuran->id->CurrentValue) ?>">
<?php } ?>
<?php if ($t02_angsuran->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_angsuran_grid->RowCnt ?>_t02_angsuran_id" class="t02_angsuran_id">
<span<?php echo $t02_angsuran->id->ViewAttributes() ?>>
<?php echo $t02_angsuran->id->ListViewValue() ?></span>
</span>
<?php if ($t02_angsuran->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t02_angsuran" data-field="x_id" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_id" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t02_angsuran->id->FormValue) ?>">
<input type="hidden" data-table="t02_angsuran" data-field="x_id" name="o<?php echo $t02_angsuran_grid->RowIndex ?>_id" id="o<?php echo $t02_angsuran_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t02_angsuran->id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t02_angsuran" data-field="x_id" name="ft02_angsurangrid$x<?php echo $t02_angsuran_grid->RowIndex ?>_id" id="ft02_angsurangrid$x<?php echo $t02_angsuran_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t02_angsuran->id->FormValue) ?>">
<input type="hidden" data-table="t02_angsuran" data-field="x_id" name="ft02_angsurangrid$o<?php echo $t02_angsuran_grid->RowIndex ?>_id" id="ft02_angsurangrid$o<?php echo $t02_angsuran_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t02_angsuran->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_angsuran->NoKontrak->Visible) { // NoKontrak ?>
		<td data-name="NoKontrak"<?php echo $t02_angsuran->NoKontrak->CellAttributes() ?>>
<?php if ($t02_angsuran->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($t02_angsuran->NoKontrak->getSessionValue() <> "") { ?>
<span id="el<?php echo $t02_angsuran_grid->RowCnt ?>_t02_angsuran_NoKontrak" class="form-group t02_angsuran_NoKontrak">
<span<?php echo $t02_angsuran->NoKontrak->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_angsuran->NoKontrak->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_NoKontrak" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_NoKontrak" value="<?php echo ew_HtmlEncode($t02_angsuran->NoKontrak->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t02_angsuran_grid->RowCnt ?>_t02_angsuran_NoKontrak" class="form-group t02_angsuran_NoKontrak">
<input type="text" data-table="t02_angsuran" data-field="x_NoKontrak" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_NoKontrak" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_NoKontrak" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->NoKontrak->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->NoKontrak->EditValue ?>"<?php echo $t02_angsuran->NoKontrak->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="t02_angsuran" data-field="x_NoKontrak" name="o<?php echo $t02_angsuran_grid->RowIndex ?>_NoKontrak" id="o<?php echo $t02_angsuran_grid->RowIndex ?>_NoKontrak" value="<?php echo ew_HtmlEncode($t02_angsuran->NoKontrak->OldValue) ?>">
<?php } ?>
<?php if ($t02_angsuran->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($t02_angsuran->NoKontrak->getSessionValue() <> "") { ?>
<span id="el<?php echo $t02_angsuran_grid->RowCnt ?>_t02_angsuran_NoKontrak" class="form-group t02_angsuran_NoKontrak">
<span<?php echo $t02_angsuran->NoKontrak->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_angsuran->NoKontrak->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_NoKontrak" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_NoKontrak" value="<?php echo ew_HtmlEncode($t02_angsuran->NoKontrak->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t02_angsuran_grid->RowCnt ?>_t02_angsuran_NoKontrak" class="form-group t02_angsuran_NoKontrak">
<input type="text" data-table="t02_angsuran" data-field="x_NoKontrak" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_NoKontrak" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_NoKontrak" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->NoKontrak->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->NoKontrak->EditValue ?>"<?php echo $t02_angsuran->NoKontrak->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($t02_angsuran->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_angsuran_grid->RowCnt ?>_t02_angsuran_NoKontrak" class="t02_angsuran_NoKontrak">
<span<?php echo $t02_angsuran->NoKontrak->ViewAttributes() ?>>
<?php echo $t02_angsuran->NoKontrak->ListViewValue() ?></span>
</span>
<?php if ($t02_angsuran->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t02_angsuran" data-field="x_NoKontrak" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_NoKontrak" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_NoKontrak" value="<?php echo ew_HtmlEncode($t02_angsuran->NoKontrak->FormValue) ?>">
<input type="hidden" data-table="t02_angsuran" data-field="x_NoKontrak" name="o<?php echo $t02_angsuran_grid->RowIndex ?>_NoKontrak" id="o<?php echo $t02_angsuran_grid->RowIndex ?>_NoKontrak" value="<?php echo ew_HtmlEncode($t02_angsuran->NoKontrak->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t02_angsuran" data-field="x_NoKontrak" name="ft02_angsurangrid$x<?php echo $t02_angsuran_grid->RowIndex ?>_NoKontrak" id="ft02_angsurangrid$x<?php echo $t02_angsuran_grid->RowIndex ?>_NoKontrak" value="<?php echo ew_HtmlEncode($t02_angsuran->NoKontrak->FormValue) ?>">
<input type="hidden" data-table="t02_angsuran" data-field="x_NoKontrak" name="ft02_angsurangrid$o<?php echo $t02_angsuran_grid->RowIndex ?>_NoKontrak" id="ft02_angsurangrid$o<?php echo $t02_angsuran_grid->RowIndex ?>_NoKontrak" value="<?php echo ew_HtmlEncode($t02_angsuran->NoKontrak->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_angsuran->Tanggal->Visible) { // Tanggal ?>
		<td data-name="Tanggal"<?php echo $t02_angsuran->Tanggal->CellAttributes() ?>>
<?php if ($t02_angsuran->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_angsuran_grid->RowCnt ?>_t02_angsuran_Tanggal" class="form-group t02_angsuran_Tanggal">
<input type="text" data-table="t02_angsuran" data-field="x_Tanggal" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_Tanggal" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_Tanggal" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->Tanggal->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->Tanggal->EditValue ?>"<?php echo $t02_angsuran->Tanggal->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_angsuran" data-field="x_Tanggal" name="o<?php echo $t02_angsuran_grid->RowIndex ?>_Tanggal" id="o<?php echo $t02_angsuran_grid->RowIndex ?>_Tanggal" value="<?php echo ew_HtmlEncode($t02_angsuran->Tanggal->OldValue) ?>">
<?php } ?>
<?php if ($t02_angsuran->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_angsuran_grid->RowCnt ?>_t02_angsuran_Tanggal" class="form-group t02_angsuran_Tanggal">
<input type="text" data-table="t02_angsuran" data-field="x_Tanggal" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_Tanggal" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_Tanggal" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->Tanggal->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->Tanggal->EditValue ?>"<?php echo $t02_angsuran->Tanggal->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_angsuran->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_angsuran_grid->RowCnt ?>_t02_angsuran_Tanggal" class="t02_angsuran_Tanggal">
<span<?php echo $t02_angsuran->Tanggal->ViewAttributes() ?>>
<?php echo $t02_angsuran->Tanggal->ListViewValue() ?></span>
</span>
<?php if ($t02_angsuran->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t02_angsuran" data-field="x_Tanggal" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_Tanggal" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_Tanggal" value="<?php echo ew_HtmlEncode($t02_angsuran->Tanggal->FormValue) ?>">
<input type="hidden" data-table="t02_angsuran" data-field="x_Tanggal" name="o<?php echo $t02_angsuran_grid->RowIndex ?>_Tanggal" id="o<?php echo $t02_angsuran_grid->RowIndex ?>_Tanggal" value="<?php echo ew_HtmlEncode($t02_angsuran->Tanggal->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t02_angsuran" data-field="x_Tanggal" name="ft02_angsurangrid$x<?php echo $t02_angsuran_grid->RowIndex ?>_Tanggal" id="ft02_angsurangrid$x<?php echo $t02_angsuran_grid->RowIndex ?>_Tanggal" value="<?php echo ew_HtmlEncode($t02_angsuran->Tanggal->FormValue) ?>">
<input type="hidden" data-table="t02_angsuran" data-field="x_Tanggal" name="ft02_angsurangrid$o<?php echo $t02_angsuran_grid->RowIndex ?>_Tanggal" id="ft02_angsurangrid$o<?php echo $t02_angsuran_grid->RowIndex ?>_Tanggal" value="<?php echo ew_HtmlEncode($t02_angsuran->Tanggal->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_angsuran->AngsuranPokok->Visible) { // AngsuranPokok ?>
		<td data-name="AngsuranPokok"<?php echo $t02_angsuran->AngsuranPokok->CellAttributes() ?>>
<?php if ($t02_angsuran->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_angsuran_grid->RowCnt ?>_t02_angsuran_AngsuranPokok" class="form-group t02_angsuran_AngsuranPokok">
<input type="text" data-table="t02_angsuran" data-field="x_AngsuranPokok" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranPokok" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranPokok" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranPokok->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->AngsuranPokok->EditValue ?>"<?php echo $t02_angsuran->AngsuranPokok->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_angsuran" data-field="x_AngsuranPokok" name="o<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranPokok" id="o<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranPokok" value="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranPokok->OldValue) ?>">
<?php } ?>
<?php if ($t02_angsuran->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_angsuran_grid->RowCnt ?>_t02_angsuran_AngsuranPokok" class="form-group t02_angsuran_AngsuranPokok">
<input type="text" data-table="t02_angsuran" data-field="x_AngsuranPokok" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranPokok" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranPokok" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranPokok->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->AngsuranPokok->EditValue ?>"<?php echo $t02_angsuran->AngsuranPokok->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_angsuran->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_angsuran_grid->RowCnt ?>_t02_angsuran_AngsuranPokok" class="t02_angsuran_AngsuranPokok">
<span<?php echo $t02_angsuran->AngsuranPokok->ViewAttributes() ?>>
<?php echo $t02_angsuran->AngsuranPokok->ListViewValue() ?></span>
</span>
<?php if ($t02_angsuran->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t02_angsuran" data-field="x_AngsuranPokok" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranPokok" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranPokok" value="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranPokok->FormValue) ?>">
<input type="hidden" data-table="t02_angsuran" data-field="x_AngsuranPokok" name="o<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranPokok" id="o<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranPokok" value="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranPokok->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t02_angsuran" data-field="x_AngsuranPokok" name="ft02_angsurangrid$x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranPokok" id="ft02_angsurangrid$x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranPokok" value="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranPokok->FormValue) ?>">
<input type="hidden" data-table="t02_angsuran" data-field="x_AngsuranPokok" name="ft02_angsurangrid$o<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranPokok" id="ft02_angsurangrid$o<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranPokok" value="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranPokok->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_angsuran->AngsuranBunga->Visible) { // AngsuranBunga ?>
		<td data-name="AngsuranBunga"<?php echo $t02_angsuran->AngsuranBunga->CellAttributes() ?>>
<?php if ($t02_angsuran->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_angsuran_grid->RowCnt ?>_t02_angsuran_AngsuranBunga" class="form-group t02_angsuran_AngsuranBunga">
<input type="text" data-table="t02_angsuran" data-field="x_AngsuranBunga" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranBunga" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranBunga" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranBunga->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->AngsuranBunga->EditValue ?>"<?php echo $t02_angsuran->AngsuranBunga->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_angsuran" data-field="x_AngsuranBunga" name="o<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranBunga" id="o<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranBunga" value="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranBunga->OldValue) ?>">
<?php } ?>
<?php if ($t02_angsuran->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_angsuran_grid->RowCnt ?>_t02_angsuran_AngsuranBunga" class="form-group t02_angsuran_AngsuranBunga">
<input type="text" data-table="t02_angsuran" data-field="x_AngsuranBunga" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranBunga" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranBunga" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranBunga->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->AngsuranBunga->EditValue ?>"<?php echo $t02_angsuran->AngsuranBunga->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_angsuran->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_angsuran_grid->RowCnt ?>_t02_angsuran_AngsuranBunga" class="t02_angsuran_AngsuranBunga">
<span<?php echo $t02_angsuran->AngsuranBunga->ViewAttributes() ?>>
<?php echo $t02_angsuran->AngsuranBunga->ListViewValue() ?></span>
</span>
<?php if ($t02_angsuran->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t02_angsuran" data-field="x_AngsuranBunga" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranBunga" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranBunga" value="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranBunga->FormValue) ?>">
<input type="hidden" data-table="t02_angsuran" data-field="x_AngsuranBunga" name="o<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranBunga" id="o<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranBunga" value="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranBunga->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t02_angsuran" data-field="x_AngsuranBunga" name="ft02_angsurangrid$x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranBunga" id="ft02_angsurangrid$x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranBunga" value="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranBunga->FormValue) ?>">
<input type="hidden" data-table="t02_angsuran" data-field="x_AngsuranBunga" name="ft02_angsurangrid$o<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranBunga" id="ft02_angsurangrid$o<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranBunga" value="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranBunga->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_angsuran->AngsuranTotal->Visible) { // AngsuranTotal ?>
		<td data-name="AngsuranTotal"<?php echo $t02_angsuran->AngsuranTotal->CellAttributes() ?>>
<?php if ($t02_angsuran->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_angsuran_grid->RowCnt ?>_t02_angsuran_AngsuranTotal" class="form-group t02_angsuran_AngsuranTotal">
<input type="text" data-table="t02_angsuran" data-field="x_AngsuranTotal" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranTotal" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranTotal" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranTotal->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->AngsuranTotal->EditValue ?>"<?php echo $t02_angsuran->AngsuranTotal->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_angsuran" data-field="x_AngsuranTotal" name="o<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranTotal" id="o<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranTotal" value="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranTotal->OldValue) ?>">
<?php } ?>
<?php if ($t02_angsuran->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_angsuran_grid->RowCnt ?>_t02_angsuran_AngsuranTotal" class="form-group t02_angsuran_AngsuranTotal">
<input type="text" data-table="t02_angsuran" data-field="x_AngsuranTotal" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranTotal" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranTotal" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranTotal->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->AngsuranTotal->EditValue ?>"<?php echo $t02_angsuran->AngsuranTotal->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_angsuran->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_angsuran_grid->RowCnt ?>_t02_angsuran_AngsuranTotal" class="t02_angsuran_AngsuranTotal">
<span<?php echo $t02_angsuran->AngsuranTotal->ViewAttributes() ?>>
<?php echo $t02_angsuran->AngsuranTotal->ListViewValue() ?></span>
</span>
<?php if ($t02_angsuran->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t02_angsuran" data-field="x_AngsuranTotal" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranTotal" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranTotal" value="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranTotal->FormValue) ?>">
<input type="hidden" data-table="t02_angsuran" data-field="x_AngsuranTotal" name="o<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranTotal" id="o<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranTotal" value="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranTotal->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t02_angsuran" data-field="x_AngsuranTotal" name="ft02_angsurangrid$x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranTotal" id="ft02_angsurangrid$x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranTotal" value="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranTotal->FormValue) ?>">
<input type="hidden" data-table="t02_angsuran" data-field="x_AngsuranTotal" name="ft02_angsurangrid$o<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranTotal" id="ft02_angsurangrid$o<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranTotal" value="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranTotal->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_angsuran->SisaHutang->Visible) { // SisaHutang ?>
		<td data-name="SisaHutang"<?php echo $t02_angsuran->SisaHutang->CellAttributes() ?>>
<?php if ($t02_angsuran->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_angsuran_grid->RowCnt ?>_t02_angsuran_SisaHutang" class="form-group t02_angsuran_SisaHutang">
<input type="text" data-table="t02_angsuran" data-field="x_SisaHutang" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_SisaHutang" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_SisaHutang" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->SisaHutang->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->SisaHutang->EditValue ?>"<?php echo $t02_angsuran->SisaHutang->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_angsuran" data-field="x_SisaHutang" name="o<?php echo $t02_angsuran_grid->RowIndex ?>_SisaHutang" id="o<?php echo $t02_angsuran_grid->RowIndex ?>_SisaHutang" value="<?php echo ew_HtmlEncode($t02_angsuran->SisaHutang->OldValue) ?>">
<?php } ?>
<?php if ($t02_angsuran->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_angsuran_grid->RowCnt ?>_t02_angsuran_SisaHutang" class="form-group t02_angsuran_SisaHutang">
<input type="text" data-table="t02_angsuran" data-field="x_SisaHutang" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_SisaHutang" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_SisaHutang" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->SisaHutang->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->SisaHutang->EditValue ?>"<?php echo $t02_angsuran->SisaHutang->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_angsuran->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_angsuran_grid->RowCnt ?>_t02_angsuran_SisaHutang" class="t02_angsuran_SisaHutang">
<span<?php echo $t02_angsuran->SisaHutang->ViewAttributes() ?>>
<?php echo $t02_angsuran->SisaHutang->ListViewValue() ?></span>
</span>
<?php if ($t02_angsuran->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t02_angsuran" data-field="x_SisaHutang" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_SisaHutang" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_SisaHutang" value="<?php echo ew_HtmlEncode($t02_angsuran->SisaHutang->FormValue) ?>">
<input type="hidden" data-table="t02_angsuran" data-field="x_SisaHutang" name="o<?php echo $t02_angsuran_grid->RowIndex ?>_SisaHutang" id="o<?php echo $t02_angsuran_grid->RowIndex ?>_SisaHutang" value="<?php echo ew_HtmlEncode($t02_angsuran->SisaHutang->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t02_angsuran" data-field="x_SisaHutang" name="ft02_angsurangrid$x<?php echo $t02_angsuran_grid->RowIndex ?>_SisaHutang" id="ft02_angsurangrid$x<?php echo $t02_angsuran_grid->RowIndex ?>_SisaHutang" value="<?php echo ew_HtmlEncode($t02_angsuran->SisaHutang->FormValue) ?>">
<input type="hidden" data-table="t02_angsuran" data-field="x_SisaHutang" name="ft02_angsurangrid$o<?php echo $t02_angsuran_grid->RowIndex ?>_SisaHutang" id="ft02_angsurangrid$o<?php echo $t02_angsuran_grid->RowIndex ?>_SisaHutang" value="<?php echo ew_HtmlEncode($t02_angsuran->SisaHutang->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_angsuran->TanggalBayar->Visible) { // TanggalBayar ?>
		<td data-name="TanggalBayar"<?php echo $t02_angsuran->TanggalBayar->CellAttributes() ?>>
<?php if ($t02_angsuran->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_angsuran_grid->RowCnt ?>_t02_angsuran_TanggalBayar" class="form-group t02_angsuran_TanggalBayar">
<input type="text" data-table="t02_angsuran" data-field="x_TanggalBayar" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_TanggalBayar" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_TanggalBayar" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->TanggalBayar->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->TanggalBayar->EditValue ?>"<?php echo $t02_angsuran->TanggalBayar->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_angsuran" data-field="x_TanggalBayar" name="o<?php echo $t02_angsuran_grid->RowIndex ?>_TanggalBayar" id="o<?php echo $t02_angsuran_grid->RowIndex ?>_TanggalBayar" value="<?php echo ew_HtmlEncode($t02_angsuran->TanggalBayar->OldValue) ?>">
<?php } ?>
<?php if ($t02_angsuran->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_angsuran_grid->RowCnt ?>_t02_angsuran_TanggalBayar" class="form-group t02_angsuran_TanggalBayar">
<input type="text" data-table="t02_angsuran" data-field="x_TanggalBayar" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_TanggalBayar" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_TanggalBayar" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->TanggalBayar->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->TanggalBayar->EditValue ?>"<?php echo $t02_angsuran->TanggalBayar->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_angsuran->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_angsuran_grid->RowCnt ?>_t02_angsuran_TanggalBayar" class="t02_angsuran_TanggalBayar">
<span<?php echo $t02_angsuran->TanggalBayar->ViewAttributes() ?>>
<?php echo $t02_angsuran->TanggalBayar->ListViewValue() ?></span>
</span>
<?php if ($t02_angsuran->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t02_angsuran" data-field="x_TanggalBayar" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_TanggalBayar" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_TanggalBayar" value="<?php echo ew_HtmlEncode($t02_angsuran->TanggalBayar->FormValue) ?>">
<input type="hidden" data-table="t02_angsuran" data-field="x_TanggalBayar" name="o<?php echo $t02_angsuran_grid->RowIndex ?>_TanggalBayar" id="o<?php echo $t02_angsuran_grid->RowIndex ?>_TanggalBayar" value="<?php echo ew_HtmlEncode($t02_angsuran->TanggalBayar->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t02_angsuran" data-field="x_TanggalBayar" name="ft02_angsurangrid$x<?php echo $t02_angsuran_grid->RowIndex ?>_TanggalBayar" id="ft02_angsurangrid$x<?php echo $t02_angsuran_grid->RowIndex ?>_TanggalBayar" value="<?php echo ew_HtmlEncode($t02_angsuran->TanggalBayar->FormValue) ?>">
<input type="hidden" data-table="t02_angsuran" data-field="x_TanggalBayar" name="ft02_angsurangrid$o<?php echo $t02_angsuran_grid->RowIndex ?>_TanggalBayar" id="ft02_angsurangrid$o<?php echo $t02_angsuran_grid->RowIndex ?>_TanggalBayar" value="<?php echo ew_HtmlEncode($t02_angsuran->TanggalBayar->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_angsuran->TotalDenda->Visible) { // TotalDenda ?>
		<td data-name="TotalDenda"<?php echo $t02_angsuran->TotalDenda->CellAttributes() ?>>
<?php if ($t02_angsuran->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_angsuran_grid->RowCnt ?>_t02_angsuran_TotalDenda" class="form-group t02_angsuran_TotalDenda">
<input type="text" data-table="t02_angsuran" data-field="x_TotalDenda" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_TotalDenda" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_TotalDenda" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->TotalDenda->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->TotalDenda->EditValue ?>"<?php echo $t02_angsuran->TotalDenda->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_angsuran" data-field="x_TotalDenda" name="o<?php echo $t02_angsuran_grid->RowIndex ?>_TotalDenda" id="o<?php echo $t02_angsuran_grid->RowIndex ?>_TotalDenda" value="<?php echo ew_HtmlEncode($t02_angsuran->TotalDenda->OldValue) ?>">
<?php } ?>
<?php if ($t02_angsuran->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_angsuran_grid->RowCnt ?>_t02_angsuran_TotalDenda" class="form-group t02_angsuran_TotalDenda">
<input type="text" data-table="t02_angsuran" data-field="x_TotalDenda" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_TotalDenda" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_TotalDenda" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->TotalDenda->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->TotalDenda->EditValue ?>"<?php echo $t02_angsuran->TotalDenda->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_angsuran->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_angsuran_grid->RowCnt ?>_t02_angsuran_TotalDenda" class="t02_angsuran_TotalDenda">
<span<?php echo $t02_angsuran->TotalDenda->ViewAttributes() ?>>
<?php echo $t02_angsuran->TotalDenda->ListViewValue() ?></span>
</span>
<?php if ($t02_angsuran->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t02_angsuran" data-field="x_TotalDenda" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_TotalDenda" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_TotalDenda" value="<?php echo ew_HtmlEncode($t02_angsuran->TotalDenda->FormValue) ?>">
<input type="hidden" data-table="t02_angsuran" data-field="x_TotalDenda" name="o<?php echo $t02_angsuran_grid->RowIndex ?>_TotalDenda" id="o<?php echo $t02_angsuran_grid->RowIndex ?>_TotalDenda" value="<?php echo ew_HtmlEncode($t02_angsuran->TotalDenda->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t02_angsuran" data-field="x_TotalDenda" name="ft02_angsurangrid$x<?php echo $t02_angsuran_grid->RowIndex ?>_TotalDenda" id="ft02_angsurangrid$x<?php echo $t02_angsuran_grid->RowIndex ?>_TotalDenda" value="<?php echo ew_HtmlEncode($t02_angsuran->TotalDenda->FormValue) ?>">
<input type="hidden" data-table="t02_angsuran" data-field="x_TotalDenda" name="ft02_angsurangrid$o<?php echo $t02_angsuran_grid->RowIndex ?>_TotalDenda" id="ft02_angsurangrid$o<?php echo $t02_angsuran_grid->RowIndex ?>_TotalDenda" value="<?php echo ew_HtmlEncode($t02_angsuran->TotalDenda->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_angsuran->Terlambat->Visible) { // Terlambat ?>
		<td data-name="Terlambat"<?php echo $t02_angsuran->Terlambat->CellAttributes() ?>>
<?php if ($t02_angsuran->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_angsuran_grid->RowCnt ?>_t02_angsuran_Terlambat" class="form-group t02_angsuran_Terlambat">
<input type="text" data-table="t02_angsuran" data-field="x_Terlambat" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_Terlambat" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_Terlambat" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->Terlambat->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->Terlambat->EditValue ?>"<?php echo $t02_angsuran->Terlambat->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_angsuran" data-field="x_Terlambat" name="o<?php echo $t02_angsuran_grid->RowIndex ?>_Terlambat" id="o<?php echo $t02_angsuran_grid->RowIndex ?>_Terlambat" value="<?php echo ew_HtmlEncode($t02_angsuran->Terlambat->OldValue) ?>">
<?php } ?>
<?php if ($t02_angsuran->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_angsuran_grid->RowCnt ?>_t02_angsuran_Terlambat" class="form-group t02_angsuran_Terlambat">
<input type="text" data-table="t02_angsuran" data-field="x_Terlambat" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_Terlambat" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_Terlambat" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->Terlambat->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->Terlambat->EditValue ?>"<?php echo $t02_angsuran->Terlambat->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_angsuran->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_angsuran_grid->RowCnt ?>_t02_angsuran_Terlambat" class="t02_angsuran_Terlambat">
<span<?php echo $t02_angsuran->Terlambat->ViewAttributes() ?>>
<?php echo $t02_angsuran->Terlambat->ListViewValue() ?></span>
</span>
<?php if ($t02_angsuran->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t02_angsuran" data-field="x_Terlambat" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_Terlambat" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_Terlambat" value="<?php echo ew_HtmlEncode($t02_angsuran->Terlambat->FormValue) ?>">
<input type="hidden" data-table="t02_angsuran" data-field="x_Terlambat" name="o<?php echo $t02_angsuran_grid->RowIndex ?>_Terlambat" id="o<?php echo $t02_angsuran_grid->RowIndex ?>_Terlambat" value="<?php echo ew_HtmlEncode($t02_angsuran->Terlambat->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t02_angsuran" data-field="x_Terlambat" name="ft02_angsurangrid$x<?php echo $t02_angsuran_grid->RowIndex ?>_Terlambat" id="ft02_angsurangrid$x<?php echo $t02_angsuran_grid->RowIndex ?>_Terlambat" value="<?php echo ew_HtmlEncode($t02_angsuran->Terlambat->FormValue) ?>">
<input type="hidden" data-table="t02_angsuran" data-field="x_Terlambat" name="ft02_angsurangrid$o<?php echo $t02_angsuran_grid->RowIndex ?>_Terlambat" id="ft02_angsurangrid$o<?php echo $t02_angsuran_grid->RowIndex ?>_Terlambat" value="<?php echo ew_HtmlEncode($t02_angsuran->Terlambat->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t02_angsuran_grid->ListOptions->Render("body", "right", $t02_angsuran_grid->RowCnt);
?>
	</tr>
<?php if ($t02_angsuran->RowType == EW_ROWTYPE_ADD || $t02_angsuran->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft02_angsurangrid.UpdateOpts(<?php echo $t02_angsuran_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t02_angsuran->CurrentAction <> "gridadd" || $t02_angsuran->CurrentMode == "copy")
		if (!$t02_angsuran_grid->Recordset->EOF) $t02_angsuran_grid->Recordset->MoveNext();
}
?>
<?php
	if ($t02_angsuran->CurrentMode == "add" || $t02_angsuran->CurrentMode == "copy" || $t02_angsuran->CurrentMode == "edit") {
		$t02_angsuran_grid->RowIndex = '$rowindex$';
		$t02_angsuran_grid->LoadRowValues();

		// Set row properties
		$t02_angsuran->ResetAttrs();
		$t02_angsuran->RowAttrs = array_merge($t02_angsuran->RowAttrs, array('data-rowindex'=>$t02_angsuran_grid->RowIndex, 'id'=>'r0_t02_angsuran', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t02_angsuran->RowAttrs["class"], "ewTemplate");
		$t02_angsuran->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t02_angsuran_grid->RenderRow();

		// Render list options
		$t02_angsuran_grid->RenderListOptions();
		$t02_angsuran_grid->StartRowCnt = 0;
?>
	<tr<?php echo $t02_angsuran->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t02_angsuran_grid->ListOptions->Render("body", "left", $t02_angsuran_grid->RowIndex);
?>
	<?php if ($t02_angsuran->id->Visible) { // id ?>
		<td data-name="id">
<?php if ($t02_angsuran->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_t02_angsuran_id" class="form-group t02_angsuran_id">
<span<?php echo $t02_angsuran->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_angsuran->id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t02_angsuran" data-field="x_id" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_id" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t02_angsuran->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t02_angsuran" data-field="x_id" name="o<?php echo $t02_angsuran_grid->RowIndex ?>_id" id="o<?php echo $t02_angsuran_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t02_angsuran->id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_angsuran->NoKontrak->Visible) { // NoKontrak ?>
		<td data-name="NoKontrak">
<?php if ($t02_angsuran->CurrentAction <> "F") { ?>
<?php if ($t02_angsuran->NoKontrak->getSessionValue() <> "") { ?>
<span id="el$rowindex$_t02_angsuran_NoKontrak" class="form-group t02_angsuran_NoKontrak">
<span<?php echo $t02_angsuran->NoKontrak->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_angsuran->NoKontrak->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_NoKontrak" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_NoKontrak" value="<?php echo ew_HtmlEncode($t02_angsuran->NoKontrak->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_t02_angsuran_NoKontrak" class="form-group t02_angsuran_NoKontrak">
<input type="text" data-table="t02_angsuran" data-field="x_NoKontrak" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_NoKontrak" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_NoKontrak" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->NoKontrak->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->NoKontrak->EditValue ?>"<?php echo $t02_angsuran->NoKontrak->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_t02_angsuran_NoKontrak" class="form-group t02_angsuran_NoKontrak">
<span<?php echo $t02_angsuran->NoKontrak->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_angsuran->NoKontrak->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t02_angsuran" data-field="x_NoKontrak" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_NoKontrak" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_NoKontrak" value="<?php echo ew_HtmlEncode($t02_angsuran->NoKontrak->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t02_angsuran" data-field="x_NoKontrak" name="o<?php echo $t02_angsuran_grid->RowIndex ?>_NoKontrak" id="o<?php echo $t02_angsuran_grid->RowIndex ?>_NoKontrak" value="<?php echo ew_HtmlEncode($t02_angsuran->NoKontrak->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_angsuran->Tanggal->Visible) { // Tanggal ?>
		<td data-name="Tanggal">
<?php if ($t02_angsuran->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t02_angsuran_Tanggal" class="form-group t02_angsuran_Tanggal">
<input type="text" data-table="t02_angsuran" data-field="x_Tanggal" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_Tanggal" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_Tanggal" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->Tanggal->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->Tanggal->EditValue ?>"<?php echo $t02_angsuran->Tanggal->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t02_angsuran_Tanggal" class="form-group t02_angsuran_Tanggal">
<span<?php echo $t02_angsuran->Tanggal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_angsuran->Tanggal->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t02_angsuran" data-field="x_Tanggal" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_Tanggal" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_Tanggal" value="<?php echo ew_HtmlEncode($t02_angsuran->Tanggal->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t02_angsuran" data-field="x_Tanggal" name="o<?php echo $t02_angsuran_grid->RowIndex ?>_Tanggal" id="o<?php echo $t02_angsuran_grid->RowIndex ?>_Tanggal" value="<?php echo ew_HtmlEncode($t02_angsuran->Tanggal->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_angsuran->AngsuranPokok->Visible) { // AngsuranPokok ?>
		<td data-name="AngsuranPokok">
<?php if ($t02_angsuran->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t02_angsuran_AngsuranPokok" class="form-group t02_angsuran_AngsuranPokok">
<input type="text" data-table="t02_angsuran" data-field="x_AngsuranPokok" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranPokok" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranPokok" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranPokok->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->AngsuranPokok->EditValue ?>"<?php echo $t02_angsuran->AngsuranPokok->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t02_angsuran_AngsuranPokok" class="form-group t02_angsuran_AngsuranPokok">
<span<?php echo $t02_angsuran->AngsuranPokok->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_angsuran->AngsuranPokok->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t02_angsuran" data-field="x_AngsuranPokok" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranPokok" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranPokok" value="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranPokok->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t02_angsuran" data-field="x_AngsuranPokok" name="o<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranPokok" id="o<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranPokok" value="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranPokok->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_angsuran->AngsuranBunga->Visible) { // AngsuranBunga ?>
		<td data-name="AngsuranBunga">
<?php if ($t02_angsuran->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t02_angsuran_AngsuranBunga" class="form-group t02_angsuran_AngsuranBunga">
<input type="text" data-table="t02_angsuran" data-field="x_AngsuranBunga" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranBunga" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranBunga" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranBunga->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->AngsuranBunga->EditValue ?>"<?php echo $t02_angsuran->AngsuranBunga->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t02_angsuran_AngsuranBunga" class="form-group t02_angsuran_AngsuranBunga">
<span<?php echo $t02_angsuran->AngsuranBunga->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_angsuran->AngsuranBunga->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t02_angsuran" data-field="x_AngsuranBunga" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranBunga" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranBunga" value="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranBunga->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t02_angsuran" data-field="x_AngsuranBunga" name="o<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranBunga" id="o<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranBunga" value="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranBunga->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_angsuran->AngsuranTotal->Visible) { // AngsuranTotal ?>
		<td data-name="AngsuranTotal">
<?php if ($t02_angsuran->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t02_angsuran_AngsuranTotal" class="form-group t02_angsuran_AngsuranTotal">
<input type="text" data-table="t02_angsuran" data-field="x_AngsuranTotal" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranTotal" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranTotal" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranTotal->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->AngsuranTotal->EditValue ?>"<?php echo $t02_angsuran->AngsuranTotal->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t02_angsuran_AngsuranTotal" class="form-group t02_angsuran_AngsuranTotal">
<span<?php echo $t02_angsuran->AngsuranTotal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_angsuran->AngsuranTotal->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t02_angsuran" data-field="x_AngsuranTotal" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranTotal" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranTotal" value="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranTotal->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t02_angsuran" data-field="x_AngsuranTotal" name="o<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranTotal" id="o<?php echo $t02_angsuran_grid->RowIndex ?>_AngsuranTotal" value="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranTotal->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_angsuran->SisaHutang->Visible) { // SisaHutang ?>
		<td data-name="SisaHutang">
<?php if ($t02_angsuran->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t02_angsuran_SisaHutang" class="form-group t02_angsuran_SisaHutang">
<input type="text" data-table="t02_angsuran" data-field="x_SisaHutang" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_SisaHutang" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_SisaHutang" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->SisaHutang->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->SisaHutang->EditValue ?>"<?php echo $t02_angsuran->SisaHutang->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t02_angsuran_SisaHutang" class="form-group t02_angsuran_SisaHutang">
<span<?php echo $t02_angsuran->SisaHutang->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_angsuran->SisaHutang->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t02_angsuran" data-field="x_SisaHutang" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_SisaHutang" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_SisaHutang" value="<?php echo ew_HtmlEncode($t02_angsuran->SisaHutang->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t02_angsuran" data-field="x_SisaHutang" name="o<?php echo $t02_angsuran_grid->RowIndex ?>_SisaHutang" id="o<?php echo $t02_angsuran_grid->RowIndex ?>_SisaHutang" value="<?php echo ew_HtmlEncode($t02_angsuran->SisaHutang->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_angsuran->TanggalBayar->Visible) { // TanggalBayar ?>
		<td data-name="TanggalBayar">
<?php if ($t02_angsuran->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t02_angsuran_TanggalBayar" class="form-group t02_angsuran_TanggalBayar">
<input type="text" data-table="t02_angsuran" data-field="x_TanggalBayar" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_TanggalBayar" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_TanggalBayar" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->TanggalBayar->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->TanggalBayar->EditValue ?>"<?php echo $t02_angsuran->TanggalBayar->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t02_angsuran_TanggalBayar" class="form-group t02_angsuran_TanggalBayar">
<span<?php echo $t02_angsuran->TanggalBayar->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_angsuran->TanggalBayar->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t02_angsuran" data-field="x_TanggalBayar" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_TanggalBayar" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_TanggalBayar" value="<?php echo ew_HtmlEncode($t02_angsuran->TanggalBayar->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t02_angsuran" data-field="x_TanggalBayar" name="o<?php echo $t02_angsuran_grid->RowIndex ?>_TanggalBayar" id="o<?php echo $t02_angsuran_grid->RowIndex ?>_TanggalBayar" value="<?php echo ew_HtmlEncode($t02_angsuran->TanggalBayar->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_angsuran->TotalDenda->Visible) { // TotalDenda ?>
		<td data-name="TotalDenda">
<?php if ($t02_angsuran->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t02_angsuran_TotalDenda" class="form-group t02_angsuran_TotalDenda">
<input type="text" data-table="t02_angsuran" data-field="x_TotalDenda" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_TotalDenda" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_TotalDenda" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->TotalDenda->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->TotalDenda->EditValue ?>"<?php echo $t02_angsuran->TotalDenda->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t02_angsuran_TotalDenda" class="form-group t02_angsuran_TotalDenda">
<span<?php echo $t02_angsuran->TotalDenda->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_angsuran->TotalDenda->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t02_angsuran" data-field="x_TotalDenda" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_TotalDenda" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_TotalDenda" value="<?php echo ew_HtmlEncode($t02_angsuran->TotalDenda->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t02_angsuran" data-field="x_TotalDenda" name="o<?php echo $t02_angsuran_grid->RowIndex ?>_TotalDenda" id="o<?php echo $t02_angsuran_grid->RowIndex ?>_TotalDenda" value="<?php echo ew_HtmlEncode($t02_angsuran->TotalDenda->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_angsuran->Terlambat->Visible) { // Terlambat ?>
		<td data-name="Terlambat">
<?php if ($t02_angsuran->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t02_angsuran_Terlambat" class="form-group t02_angsuran_Terlambat">
<input type="text" data-table="t02_angsuran" data-field="x_Terlambat" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_Terlambat" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_Terlambat" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->Terlambat->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->Terlambat->EditValue ?>"<?php echo $t02_angsuran->Terlambat->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t02_angsuran_Terlambat" class="form-group t02_angsuran_Terlambat">
<span<?php echo $t02_angsuran->Terlambat->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_angsuran->Terlambat->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t02_angsuran" data-field="x_Terlambat" name="x<?php echo $t02_angsuran_grid->RowIndex ?>_Terlambat" id="x<?php echo $t02_angsuran_grid->RowIndex ?>_Terlambat" value="<?php echo ew_HtmlEncode($t02_angsuran->Terlambat->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t02_angsuran" data-field="x_Terlambat" name="o<?php echo $t02_angsuran_grid->RowIndex ?>_Terlambat" id="o<?php echo $t02_angsuran_grid->RowIndex ?>_Terlambat" value="<?php echo ew_HtmlEncode($t02_angsuran->Terlambat->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t02_angsuran_grid->ListOptions->Render("body", "right", $t02_angsuran_grid->RowIndex);
?>
<script type="text/javascript">
ft02_angsurangrid.UpdateOpts(<?php echo $t02_angsuran_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($t02_angsuran->CurrentMode == "add" || $t02_angsuran->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t02_angsuran_grid->FormKeyCountName ?>" id="<?php echo $t02_angsuran_grid->FormKeyCountName ?>" value="<?php echo $t02_angsuran_grid->KeyCount ?>">
<?php echo $t02_angsuran_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t02_angsuran->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t02_angsuran_grid->FormKeyCountName ?>" id="<?php echo $t02_angsuran_grid->FormKeyCountName ?>" value="<?php echo $t02_angsuran_grid->KeyCount ?>">
<?php echo $t02_angsuran_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t02_angsuran->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ft02_angsurangrid">
</div>
<?php

// Close recordset
if ($t02_angsuran_grid->Recordset)
	$t02_angsuran_grid->Recordset->Close();
?>
<?php if ($t02_angsuran_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($t02_angsuran_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($t02_angsuran_grid->TotalRecs == 0 && $t02_angsuran->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t02_angsuran_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t02_angsuran->Export == "") { ?>
<script type="text/javascript">
ft02_angsurangrid.Init();
</script>
<?php } ?>
<?php
$t02_angsuran_grid->Page_Terminate();
?>
