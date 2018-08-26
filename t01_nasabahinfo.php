<?php

// Global variable for table object
$t01_nasabah = NULL;

//
// Table class for t01_nasabah
//
class ct01_nasabah extends cTable {
	var $AuditTrailOnAdd = TRUE;
	var $AuditTrailOnEdit = TRUE;
	var $AuditTrailOnDelete = TRUE;
	var $AuditTrailOnView = FALSE;
	var $AuditTrailOnViewData = FALSE;
	var $AuditTrailOnSearch = FALSE;
	var $id;
	var $NoKontrak;
	var $Customer;
	var $Pekerjaan;
	var $Alamat;
	var $NoTelpHp;
	var $TglKontrak;
	var $MerkType;
	var $NoRangka;
	var $NoMesin;
	var $Warna;
	var $NoPol;
	var $Keterangan;
	var $AtasNama;
	var $Pinjaman;
	var $Denda;
	var $DispensasiDenda;
	var $LamaAngsuran;
	var $JumlahAngsuran;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 't01_nasabah';
		$this->TableName = 't01_nasabah';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`t01_nasabah`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
		$this->ExportWordColumnWidth = NULL; // Cell width (PHPWord only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = TRUE; // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// id
		$this->id = new cField('t01_nasabah', 't01_nasabah', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// NoKontrak
		$this->NoKontrak = new cField('t01_nasabah', 't01_nasabah', 'x_NoKontrak', 'NoKontrak', '`NoKontrak`', '`NoKontrak`', 200, -1, FALSE, '`NoKontrak`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NoKontrak->Sortable = TRUE; // Allow sort
		$this->fields['NoKontrak'] = &$this->NoKontrak;

		// Customer
		$this->Customer = new cField('t01_nasabah', 't01_nasabah', 'x_Customer', 'Customer', '`Customer`', '`Customer`', 200, -1, FALSE, '`Customer`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Customer->Sortable = TRUE; // Allow sort
		$this->fields['Customer'] = &$this->Customer;

		// Pekerjaan
		$this->Pekerjaan = new cField('t01_nasabah', 't01_nasabah', 'x_Pekerjaan', 'Pekerjaan', '`Pekerjaan`', '`Pekerjaan`', 200, -1, FALSE, '`Pekerjaan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Pekerjaan->Sortable = TRUE; // Allow sort
		$this->fields['Pekerjaan'] = &$this->Pekerjaan;

		// Alamat
		$this->Alamat = new cField('t01_nasabah', 't01_nasabah', 'x_Alamat', 'Alamat', '`Alamat`', '`Alamat`', 201, -1, FALSE, '`Alamat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Alamat->Sortable = TRUE; // Allow sort
		$this->fields['Alamat'] = &$this->Alamat;

		// NoTelpHp
		$this->NoTelpHp = new cField('t01_nasabah', 't01_nasabah', 'x_NoTelpHp', 'NoTelpHp', '`NoTelpHp`', '`NoTelpHp`', 200, -1, FALSE, '`NoTelpHp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NoTelpHp->Sortable = TRUE; // Allow sort
		$this->fields['NoTelpHp'] = &$this->NoTelpHp;

		// TglKontrak
		$this->TglKontrak = new cField('t01_nasabah', 't01_nasabah', 'x_TglKontrak', 'TglKontrak', '`TglKontrak`', ew_CastDateFieldForLike('`TglKontrak`', 7, "DB"), 133, 7, FALSE, '`TglKontrak`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TglKontrak->Sortable = TRUE; // Allow sort
		$this->TglKontrak->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['TglKontrak'] = &$this->TglKontrak;

		// MerkType
		$this->MerkType = new cField('t01_nasabah', 't01_nasabah', 'x_MerkType', 'MerkType', '`MerkType`', '`MerkType`', 200, -1, FALSE, '`MerkType`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->MerkType->Sortable = TRUE; // Allow sort
		$this->fields['MerkType'] = &$this->MerkType;

		// NoRangka
		$this->NoRangka = new cField('t01_nasabah', 't01_nasabah', 'x_NoRangka', 'NoRangka', '`NoRangka`', '`NoRangka`', 200, -1, FALSE, '`NoRangka`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NoRangka->Sortable = TRUE; // Allow sort
		$this->fields['NoRangka'] = &$this->NoRangka;

		// NoMesin
		$this->NoMesin = new cField('t01_nasabah', 't01_nasabah', 'x_NoMesin', 'NoMesin', '`NoMesin`', '`NoMesin`', 200, -1, FALSE, '`NoMesin`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NoMesin->Sortable = TRUE; // Allow sort
		$this->fields['NoMesin'] = &$this->NoMesin;

		// Warna
		$this->Warna = new cField('t01_nasabah', 't01_nasabah', 'x_Warna', 'Warna', '`Warna`', '`Warna`', 200, -1, FALSE, '`Warna`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Warna->Sortable = TRUE; // Allow sort
		$this->fields['Warna'] = &$this->Warna;

		// NoPol
		$this->NoPol = new cField('t01_nasabah', 't01_nasabah', 'x_NoPol', 'NoPol', '`NoPol`', '`NoPol`', 200, -1, FALSE, '`NoPol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NoPol->Sortable = TRUE; // Allow sort
		$this->fields['NoPol'] = &$this->NoPol;

		// Keterangan
		$this->Keterangan = new cField('t01_nasabah', 't01_nasabah', 'x_Keterangan', 'Keterangan', '`Keterangan`', '`Keterangan`', 201, -1, FALSE, '`Keterangan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Keterangan->Sortable = TRUE; // Allow sort
		$this->fields['Keterangan'] = &$this->Keterangan;

		// AtasNama
		$this->AtasNama = new cField('t01_nasabah', 't01_nasabah', 'x_AtasNama', 'AtasNama', '`AtasNama`', '`AtasNama`', 200, -1, FALSE, '`AtasNama`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->AtasNama->Sortable = TRUE; // Allow sort
		$this->fields['AtasNama'] = &$this->AtasNama;

		// Pinjaman
		$this->Pinjaman = new cField('t01_nasabah', 't01_nasabah', 'x_Pinjaman', 'Pinjaman', '`Pinjaman`', '`Pinjaman`', 4, -1, FALSE, '`Pinjaman`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Pinjaman->Sortable = TRUE; // Allow sort
		$this->Pinjaman->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Pinjaman'] = &$this->Pinjaman;

		// Denda
		$this->Denda = new cField('t01_nasabah', 't01_nasabah', 'x_Denda', 'Denda', '`Denda`', '`Denda`', 131, -1, FALSE, '`Denda`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Denda->Sortable = TRUE; // Allow sort
		$this->Denda->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Denda'] = &$this->Denda;

		// DispensasiDenda
		$this->DispensasiDenda = new cField('t01_nasabah', 't01_nasabah', 'x_DispensasiDenda', 'DispensasiDenda', '`DispensasiDenda`', '`DispensasiDenda`', 16, -1, FALSE, '`DispensasiDenda`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->DispensasiDenda->Sortable = TRUE; // Allow sort
		$this->DispensasiDenda->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['DispensasiDenda'] = &$this->DispensasiDenda;

		// LamaAngsuran
		$this->LamaAngsuran = new cField('t01_nasabah', 't01_nasabah', 'x_LamaAngsuran', 'LamaAngsuran', '`LamaAngsuran`', '`LamaAngsuran`', 16, -1, FALSE, '`LamaAngsuran`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->LamaAngsuran->Sortable = TRUE; // Allow sort
		$this->LamaAngsuran->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['LamaAngsuran'] = &$this->LamaAngsuran;

		// JumlahAngsuran
		$this->JumlahAngsuran = new cField('t01_nasabah', 't01_nasabah', 'x_JumlahAngsuran', 'JumlahAngsuran', '`JumlahAngsuran`', '`JumlahAngsuran`', 4, -1, FALSE, '`JumlahAngsuran`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->JumlahAngsuran->Sortable = TRUE; // Allow sort
		$this->JumlahAngsuran->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['JumlahAngsuran'] = &$this->JumlahAngsuran;
	}

	// Field Visibility
	function GetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Column CSS classes
	var $LeftColumnClass = "col-sm-2 control-label ewLabel";
	var $RightColumnClass = "col-sm-10";
	var $OffsetColumnClass = "col-sm-10 col-sm-offset-2";

	// Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
	function SetLeftColumnClass($class) {
		if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
			$this->LeftColumnClass = $class . " control-label ewLabel";
			$this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - intval($match[2]));
			$this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace($match[1], $match[1] + "-offset", $class);
		}
	}

	// Multiple column sort
	function UpdateSort(&$ofld, $ctrl) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			if ($ctrl) {
				$sOrderBy = $this->getSessionOrderBy();
				if (strpos($sOrderBy, $sSortField . " " . $sLastSort) !== FALSE) {
					$sOrderBy = str_replace($sSortField . " " . $sLastSort, $sSortField . " " . $sThisSort, $sOrderBy);
				} else {
					if ($sOrderBy <> "") $sOrderBy .= ", ";
					$sOrderBy .= $sSortField . " " . $sThisSort;
				}
				$this->setSessionOrderBy($sOrderBy); // Save to Session
			} else {
				$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
			}
		} else {
			if (!$ctrl) $ofld->setSort("");
		}
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`t01_nasabah`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$filter = $this->CurrentFilter;
		$filter = $this->ApplyUserIDFilters($filter);
		$sort = $this->getSessionOrderBy();
		return $this->GetSQL($filter, $sort);
	}

	// Table SQL with List page filter
	var $UseSessionForListSQL = TRUE;

	function ListSQL() {
		$sFilter = $this->UseSessionForListSQL ? $this->getSessionWhere() : "";
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSelect = $this->getSqlSelect();
		$sSort = $this->UseSessionForListSQL ? $this->getSessionOrderBy() : "";
		return ew_BuildSelectSql($sSelect, $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sql) {
		$cnt = -1;
		$pattern = "/^SELECT \* FROM/i";
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match($pattern, $sql)) {
			$sql = "SELECT COUNT(*) FROM" . preg_replace($pattern, "", $sql);
		} else {
			$sql = "SELECT COUNT(*) FROM (" . $sql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($filter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $filter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = ew_BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function ListRecordCount() {
		$filter = $this->getSessionWhere();
		ew_AddFilter($filter, $this->CurrentFilter);
		$filter = $this->ApplyUserIDFilters($filter);
		$this->Recordset_Selecting($filter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = ew_BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
		$cnt = $this->TryGetRecordCount($sql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		$names = preg_replace('/,+$/', "", $names);
		$values = preg_replace('/,+$/', "", $values);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		$bInsert = $conn->Execute($this->InsertSQL($rs));
		if ($bInsert) {

			// Get insert id if necessary
			$this->id->setDbValue($conn->Insert_ID());
			$rs['id'] = $this->id->DbValue;
			if ($this->AuditTrailOnAdd)
				$this->WriteAuditTrailOnAdd($rs);
		}
		return $bInsert;
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		$sql = preg_replace('/,+$/', "", $sql);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bUpdate = $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
		if ($bUpdate && $this->AuditTrailOnEdit) {
			$rsaudit = $rs;
			$fldname = 'id';
			if (!array_key_exists($fldname, $rsaudit)) $rsaudit[$fldname] = $rsold[$fldname];
			$this->WriteAuditTrailOnEdit($rsold, $rsaudit);
		}
		return $bUpdate;
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('id', $rs))
				ew_AddFilter($where, ew_QuotedName('id', $this->DBID) . '=' . ew_QuotedValue($rs['id'], $this->id->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$bDelete = TRUE;
		$conn = &$this->Connection();
		if ($bDelete)
			$bDelete = $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
		if ($bDelete && $this->AuditTrailOnDelete)
			$this->WriteAuditTrailOnDelete($rs);
		return $bDelete;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`id` = @id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->id->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->id->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@id@", ew_AdjustSql($this->id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "t01_nasabahlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "t01_nasabahview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "t01_nasabahedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "t01_nasabahadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "t01_nasabahlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("t01_nasabahview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("t01_nasabahview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "t01_nasabahadd.php?" . $this->UrlParm($parm);
		else
			$url = "t01_nasabahadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("t01_nasabahedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("t01_nasabahadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("t01_nasabahdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "id:" . ew_VarToJson($this->id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->id->CurrentValue)) {
			$sUrl .= "id=" . urlencode($this->id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = $_POST["key_m"];
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = $_GET["key_m"];
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsPost();
			if ($isPost && isset($_POST["id"]))
				$arKeys[] = $_POST["id"];
			elseif (isset($_GET["id"]))
				$arKeys[] = $_GET["id"];
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->id->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($filter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $filter;
		//$sql = $this->SQL();

		$sql = $this->GetSQL($filter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->id->setDbValue($rs->fields('id'));
		$this->NoKontrak->setDbValue($rs->fields('NoKontrak'));
		$this->Customer->setDbValue($rs->fields('Customer'));
		$this->Pekerjaan->setDbValue($rs->fields('Pekerjaan'));
		$this->Alamat->setDbValue($rs->fields('Alamat'));
		$this->NoTelpHp->setDbValue($rs->fields('NoTelpHp'));
		$this->TglKontrak->setDbValue($rs->fields('TglKontrak'));
		$this->MerkType->setDbValue($rs->fields('MerkType'));
		$this->NoRangka->setDbValue($rs->fields('NoRangka'));
		$this->NoMesin->setDbValue($rs->fields('NoMesin'));
		$this->Warna->setDbValue($rs->fields('Warna'));
		$this->NoPol->setDbValue($rs->fields('NoPol'));
		$this->Keterangan->setDbValue($rs->fields('Keterangan'));
		$this->AtasNama->setDbValue($rs->fields('AtasNama'));
		$this->Pinjaman->setDbValue($rs->fields('Pinjaman'));
		$this->Denda->setDbValue($rs->fields('Denda'));
		$this->DispensasiDenda->setDbValue($rs->fields('DispensasiDenda'));
		$this->LamaAngsuran->setDbValue($rs->fields('LamaAngsuran'));
		$this->JumlahAngsuran->setDbValue($rs->fields('JumlahAngsuran'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// id
		// NoKontrak
		// Customer
		// Pekerjaan
		// Alamat
		// NoTelpHp
		// TglKontrak
		// MerkType
		// NoRangka
		// NoMesin
		// Warna
		// NoPol
		// Keterangan
		// AtasNama
		// Pinjaman
		// Denda
		// DispensasiDenda
		// LamaAngsuran
		// JumlahAngsuran
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// NoKontrak
		$this->NoKontrak->ViewValue = $this->NoKontrak->CurrentValue;
		$this->NoKontrak->ViewCustomAttributes = "";

		// Customer
		$this->Customer->ViewValue = $this->Customer->CurrentValue;
		$this->Customer->ViewCustomAttributes = "";

		// Pekerjaan
		$this->Pekerjaan->ViewValue = $this->Pekerjaan->CurrentValue;
		$this->Pekerjaan->ViewCustomAttributes = "";

		// Alamat
		$this->Alamat->ViewValue = $this->Alamat->CurrentValue;
		$this->Alamat->ViewCustomAttributes = "";

		// NoTelpHp
		$this->NoTelpHp->ViewValue = $this->NoTelpHp->CurrentValue;
		$this->NoTelpHp->ViewCustomAttributes = "";

		// TglKontrak
		$this->TglKontrak->ViewValue = $this->TglKontrak->CurrentValue;
		$this->TglKontrak->ViewValue = ew_FormatDateTime($this->TglKontrak->ViewValue, 7);
		$this->TglKontrak->ViewCustomAttributes = "";

		// MerkType
		$this->MerkType->ViewValue = $this->MerkType->CurrentValue;
		$this->MerkType->ViewCustomAttributes = "";

		// NoRangka
		$this->NoRangka->ViewValue = $this->NoRangka->CurrentValue;
		$this->NoRangka->ViewCustomAttributes = "";

		// NoMesin
		$this->NoMesin->ViewValue = $this->NoMesin->CurrentValue;
		$this->NoMesin->ViewCustomAttributes = "";

		// Warna
		$this->Warna->ViewValue = $this->Warna->CurrentValue;
		$this->Warna->ViewCustomAttributes = "";

		// NoPol
		$this->NoPol->ViewValue = $this->NoPol->CurrentValue;
		$this->NoPol->ViewCustomAttributes = "";

		// Keterangan
		$this->Keterangan->ViewValue = $this->Keterangan->CurrentValue;
		$this->Keterangan->ViewCustomAttributes = "";

		// AtasNama
		$this->AtasNama->ViewValue = $this->AtasNama->CurrentValue;
		$this->AtasNama->ViewCustomAttributes = "";

		// Pinjaman
		$this->Pinjaman->ViewValue = $this->Pinjaman->CurrentValue;
		$this->Pinjaman->ViewValue = ew_FormatNumber($this->Pinjaman->ViewValue, 2, -2, -2, -2);
		$this->Pinjaman->CellCssStyle .= "text-align: right;";
		$this->Pinjaman->ViewCustomAttributes = "";

		// Denda
		$this->Denda->ViewValue = $this->Denda->CurrentValue;
		$this->Denda->ViewValue = ew_FormatNumber($this->Denda->ViewValue, 2, -2, -2, -2);
		$this->Denda->CellCssStyle .= "text-align: right;";
		$this->Denda->ViewCustomAttributes = "";

		// DispensasiDenda
		$this->DispensasiDenda->ViewValue = $this->DispensasiDenda->CurrentValue;
		$this->DispensasiDenda->CellCssStyle .= "text-align: right;";
		$this->DispensasiDenda->ViewCustomAttributes = "";

		// LamaAngsuran
		$this->LamaAngsuran->ViewValue = $this->LamaAngsuran->CurrentValue;
		$this->LamaAngsuran->CellCssStyle .= "text-align: right;";
		$this->LamaAngsuran->ViewCustomAttributes = "";

		// JumlahAngsuran
		$this->JumlahAngsuran->ViewValue = $this->JumlahAngsuran->CurrentValue;
		$this->JumlahAngsuran->ViewValue = ew_FormatNumber($this->JumlahAngsuran->ViewValue, 2, -2, -2, -2);
		$this->JumlahAngsuran->CellCssStyle .= "text-align: right;";
		$this->JumlahAngsuran->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// NoKontrak
		$this->NoKontrak->LinkCustomAttributes = "";
		$this->NoKontrak->HrefValue = "";
		$this->NoKontrak->TooltipValue = "";

		// Customer
		$this->Customer->LinkCustomAttributes = "";
		$this->Customer->HrefValue = "";
		$this->Customer->TooltipValue = "";

		// Pekerjaan
		$this->Pekerjaan->LinkCustomAttributes = "";
		$this->Pekerjaan->HrefValue = "";
		$this->Pekerjaan->TooltipValue = "";

		// Alamat
		$this->Alamat->LinkCustomAttributes = "";
		$this->Alamat->HrefValue = "";
		$this->Alamat->TooltipValue = "";

		// NoTelpHp
		$this->NoTelpHp->LinkCustomAttributes = "";
		$this->NoTelpHp->HrefValue = "";
		$this->NoTelpHp->TooltipValue = "";

		// TglKontrak
		$this->TglKontrak->LinkCustomAttributes = "";
		$this->TglKontrak->HrefValue = "";
		$this->TglKontrak->TooltipValue = "";

		// MerkType
		$this->MerkType->LinkCustomAttributes = "";
		$this->MerkType->HrefValue = "";
		$this->MerkType->TooltipValue = "";

		// NoRangka
		$this->NoRangka->LinkCustomAttributes = "";
		$this->NoRangka->HrefValue = "";
		$this->NoRangka->TooltipValue = "";

		// NoMesin
		$this->NoMesin->LinkCustomAttributes = "";
		$this->NoMesin->HrefValue = "";
		$this->NoMesin->TooltipValue = "";

		// Warna
		$this->Warna->LinkCustomAttributes = "";
		$this->Warna->HrefValue = "";
		$this->Warna->TooltipValue = "";

		// NoPol
		$this->NoPol->LinkCustomAttributes = "";
		$this->NoPol->HrefValue = "";
		$this->NoPol->TooltipValue = "";

		// Keterangan
		$this->Keterangan->LinkCustomAttributes = "";
		$this->Keterangan->HrefValue = "";
		$this->Keterangan->TooltipValue = "";

		// AtasNama
		$this->AtasNama->LinkCustomAttributes = "";
		$this->AtasNama->HrefValue = "";
		$this->AtasNama->TooltipValue = "";

		// Pinjaman
		$this->Pinjaman->LinkCustomAttributes = "";
		$this->Pinjaman->HrefValue = "";
		$this->Pinjaman->TooltipValue = "";

		// Denda
		$this->Denda->LinkCustomAttributes = "";
		$this->Denda->HrefValue = "";
		$this->Denda->TooltipValue = "";

		// DispensasiDenda
		$this->DispensasiDenda->LinkCustomAttributes = "";
		$this->DispensasiDenda->HrefValue = "";
		$this->DispensasiDenda->TooltipValue = "";

		// LamaAngsuran
		$this->LamaAngsuran->LinkCustomAttributes = "";
		$this->LamaAngsuran->HrefValue = "";
		$this->LamaAngsuran->TooltipValue = "";

		// JumlahAngsuran
		$this->JumlahAngsuran->LinkCustomAttributes = "";
		$this->JumlahAngsuran->HrefValue = "";
		$this->JumlahAngsuran->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();

		// Save data for Custom Template
		$this->Rows[] = $this->CustomTemplateFieldValues();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// id
		$this->id->EditAttrs["class"] = "form-control";
		$this->id->EditCustomAttributes = "";
		$this->id->EditValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// NoKontrak
		$this->NoKontrak->EditAttrs["class"] = "form-control";
		$this->NoKontrak->EditCustomAttributes = "";
		$this->NoKontrak->EditValue = $this->NoKontrak->CurrentValue;
		$this->NoKontrak->PlaceHolder = ew_RemoveHtml($this->NoKontrak->FldCaption());

		// Customer
		$this->Customer->EditAttrs["class"] = "form-control";
		$this->Customer->EditCustomAttributes = "";
		$this->Customer->EditValue = $this->Customer->CurrentValue;
		$this->Customer->PlaceHolder = ew_RemoveHtml($this->Customer->FldCaption());

		// Pekerjaan
		$this->Pekerjaan->EditAttrs["class"] = "form-control";
		$this->Pekerjaan->EditCustomAttributes = "";
		$this->Pekerjaan->EditValue = $this->Pekerjaan->CurrentValue;
		$this->Pekerjaan->PlaceHolder = ew_RemoveHtml($this->Pekerjaan->FldCaption());

		// Alamat
		$this->Alamat->EditAttrs["class"] = "form-control";
		$this->Alamat->EditCustomAttributes = "";
		$this->Alamat->EditValue = $this->Alamat->CurrentValue;
		$this->Alamat->PlaceHolder = ew_RemoveHtml($this->Alamat->FldCaption());

		// NoTelpHp
		$this->NoTelpHp->EditAttrs["class"] = "form-control";
		$this->NoTelpHp->EditCustomAttributes = "";
		$this->NoTelpHp->EditValue = $this->NoTelpHp->CurrentValue;
		$this->NoTelpHp->PlaceHolder = ew_RemoveHtml($this->NoTelpHp->FldCaption());

		// TglKontrak
		$this->TglKontrak->EditAttrs["class"] = "form-control";
		$this->TglKontrak->EditCustomAttributes = "";
		$this->TglKontrak->EditValue = ew_FormatDateTime($this->TglKontrak->CurrentValue, 7);
		$this->TglKontrak->PlaceHolder = ew_RemoveHtml($this->TglKontrak->FldCaption());

		// MerkType
		$this->MerkType->EditAttrs["class"] = "form-control";
		$this->MerkType->EditCustomAttributes = "";
		$this->MerkType->EditValue = $this->MerkType->CurrentValue;
		$this->MerkType->PlaceHolder = ew_RemoveHtml($this->MerkType->FldCaption());

		// NoRangka
		$this->NoRangka->EditAttrs["class"] = "form-control";
		$this->NoRangka->EditCustomAttributes = "";
		$this->NoRangka->EditValue = $this->NoRangka->CurrentValue;
		$this->NoRangka->PlaceHolder = ew_RemoveHtml($this->NoRangka->FldCaption());

		// NoMesin
		$this->NoMesin->EditAttrs["class"] = "form-control";
		$this->NoMesin->EditCustomAttributes = "";
		$this->NoMesin->EditValue = $this->NoMesin->CurrentValue;
		$this->NoMesin->PlaceHolder = ew_RemoveHtml($this->NoMesin->FldCaption());

		// Warna
		$this->Warna->EditAttrs["class"] = "form-control";
		$this->Warna->EditCustomAttributes = "";
		$this->Warna->EditValue = $this->Warna->CurrentValue;
		$this->Warna->PlaceHolder = ew_RemoveHtml($this->Warna->FldCaption());

		// NoPol
		$this->NoPol->EditAttrs["class"] = "form-control";
		$this->NoPol->EditCustomAttributes = "";
		$this->NoPol->EditValue = $this->NoPol->CurrentValue;
		$this->NoPol->PlaceHolder = ew_RemoveHtml($this->NoPol->FldCaption());

		// Keterangan
		$this->Keterangan->EditAttrs["class"] = "form-control";
		$this->Keterangan->EditCustomAttributes = "";
		$this->Keterangan->EditValue = $this->Keterangan->CurrentValue;
		$this->Keterangan->PlaceHolder = ew_RemoveHtml($this->Keterangan->FldCaption());

		// AtasNama
		$this->AtasNama->EditAttrs["class"] = "form-control";
		$this->AtasNama->EditCustomAttributes = "";
		$this->AtasNama->EditValue = $this->AtasNama->CurrentValue;
		$this->AtasNama->PlaceHolder = ew_RemoveHtml($this->AtasNama->FldCaption());

		// Pinjaman
		$this->Pinjaman->EditAttrs["class"] = "form-control";
		$this->Pinjaman->EditCustomAttributes = "";
		$this->Pinjaman->EditValue = $this->Pinjaman->CurrentValue;
		$this->Pinjaman->PlaceHolder = ew_RemoveHtml($this->Pinjaman->FldCaption());
		if (strval($this->Pinjaman->EditValue) <> "" && is_numeric($this->Pinjaman->EditValue)) $this->Pinjaman->EditValue = ew_FormatNumber($this->Pinjaman->EditValue, -2, -2, -2, -2);

		// Denda
		$this->Denda->EditAttrs["class"] = "form-control";
		$this->Denda->EditCustomAttributes = "";
		$this->Denda->EditValue = $this->Denda->CurrentValue;
		$this->Denda->PlaceHolder = ew_RemoveHtml($this->Denda->FldCaption());
		if (strval($this->Denda->EditValue) <> "" && is_numeric($this->Denda->EditValue)) $this->Denda->EditValue = ew_FormatNumber($this->Denda->EditValue, -2, -2, -2, -2);

		// DispensasiDenda
		$this->DispensasiDenda->EditAttrs["class"] = "form-control";
		$this->DispensasiDenda->EditCustomAttributes = "";
		$this->DispensasiDenda->EditValue = $this->DispensasiDenda->CurrentValue;
		$this->DispensasiDenda->PlaceHolder = ew_RemoveHtml($this->DispensasiDenda->FldCaption());

		// LamaAngsuran
		$this->LamaAngsuran->EditAttrs["class"] = "form-control";
		$this->LamaAngsuran->EditCustomAttributes = "";
		$this->LamaAngsuran->EditValue = $this->LamaAngsuran->CurrentValue;
		$this->LamaAngsuran->PlaceHolder = ew_RemoveHtml($this->LamaAngsuran->FldCaption());

		// JumlahAngsuran
		$this->JumlahAngsuran->EditAttrs["class"] = "form-control";
		$this->JumlahAngsuran->EditCustomAttributes = "";
		$this->JumlahAngsuran->EditValue = $this->JumlahAngsuran->CurrentValue;
		$this->JumlahAngsuran->PlaceHolder = ew_RemoveHtml($this->JumlahAngsuran->FldCaption());
		if (strval($this->JumlahAngsuran->EditValue) <> "" && is_numeric($this->JumlahAngsuran->EditValue)) $this->JumlahAngsuran->EditValue = ew_FormatNumber($this->JumlahAngsuran->EditValue, -2, -2, -2, -2);

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->NoKontrak->Exportable) $Doc->ExportCaption($this->NoKontrak);
					if ($this->Customer->Exportable) $Doc->ExportCaption($this->Customer);
					if ($this->Pekerjaan->Exportable) $Doc->ExportCaption($this->Pekerjaan);
					if ($this->Alamat->Exportable) $Doc->ExportCaption($this->Alamat);
					if ($this->NoTelpHp->Exportable) $Doc->ExportCaption($this->NoTelpHp);
					if ($this->TglKontrak->Exportable) $Doc->ExportCaption($this->TglKontrak);
					if ($this->MerkType->Exportable) $Doc->ExportCaption($this->MerkType);
					if ($this->NoRangka->Exportable) $Doc->ExportCaption($this->NoRangka);
					if ($this->NoMesin->Exportable) $Doc->ExportCaption($this->NoMesin);
					if ($this->Warna->Exportable) $Doc->ExportCaption($this->Warna);
					if ($this->NoPol->Exportable) $Doc->ExportCaption($this->NoPol);
					if ($this->Keterangan->Exportable) $Doc->ExportCaption($this->Keterangan);
					if ($this->AtasNama->Exportable) $Doc->ExportCaption($this->AtasNama);
					if ($this->Pinjaman->Exportable) $Doc->ExportCaption($this->Pinjaman);
					if ($this->Denda->Exportable) $Doc->ExportCaption($this->Denda);
					if ($this->DispensasiDenda->Exportable) $Doc->ExportCaption($this->DispensasiDenda);
					if ($this->LamaAngsuran->Exportable) $Doc->ExportCaption($this->LamaAngsuran);
					if ($this->JumlahAngsuran->Exportable) $Doc->ExportCaption($this->JumlahAngsuran);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->NoKontrak->Exportable) $Doc->ExportCaption($this->NoKontrak);
					if ($this->Customer->Exportable) $Doc->ExportCaption($this->Customer);
					if ($this->Pekerjaan->Exportable) $Doc->ExportCaption($this->Pekerjaan);
					if ($this->NoTelpHp->Exportable) $Doc->ExportCaption($this->NoTelpHp);
					if ($this->TglKontrak->Exportable) $Doc->ExportCaption($this->TglKontrak);
					if ($this->MerkType->Exportable) $Doc->ExportCaption($this->MerkType);
					if ($this->NoRangka->Exportable) $Doc->ExportCaption($this->NoRangka);
					if ($this->NoMesin->Exportable) $Doc->ExportCaption($this->NoMesin);
					if ($this->Warna->Exportable) $Doc->ExportCaption($this->Warna);
					if ($this->NoPol->Exportable) $Doc->ExportCaption($this->NoPol);
					if ($this->AtasNama->Exportable) $Doc->ExportCaption($this->AtasNama);
					if ($this->Pinjaman->Exportable) $Doc->ExportCaption($this->Pinjaman);
					if ($this->Denda->Exportable) $Doc->ExportCaption($this->Denda);
					if ($this->DispensasiDenda->Exportable) $Doc->ExportCaption($this->DispensasiDenda);
					if ($this->LamaAngsuran->Exportable) $Doc->ExportCaption($this->LamaAngsuran);
					if ($this->JumlahAngsuran->Exportable) $Doc->ExportCaption($this->JumlahAngsuran);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->NoKontrak->Exportable) $Doc->ExportField($this->NoKontrak);
						if ($this->Customer->Exportable) $Doc->ExportField($this->Customer);
						if ($this->Pekerjaan->Exportable) $Doc->ExportField($this->Pekerjaan);
						if ($this->Alamat->Exportable) $Doc->ExportField($this->Alamat);
						if ($this->NoTelpHp->Exportable) $Doc->ExportField($this->NoTelpHp);
						if ($this->TglKontrak->Exportable) $Doc->ExportField($this->TglKontrak);
						if ($this->MerkType->Exportable) $Doc->ExportField($this->MerkType);
						if ($this->NoRangka->Exportable) $Doc->ExportField($this->NoRangka);
						if ($this->NoMesin->Exportable) $Doc->ExportField($this->NoMesin);
						if ($this->Warna->Exportable) $Doc->ExportField($this->Warna);
						if ($this->NoPol->Exportable) $Doc->ExportField($this->NoPol);
						if ($this->Keterangan->Exportable) $Doc->ExportField($this->Keterangan);
						if ($this->AtasNama->Exportable) $Doc->ExportField($this->AtasNama);
						if ($this->Pinjaman->Exportable) $Doc->ExportField($this->Pinjaman);
						if ($this->Denda->Exportable) $Doc->ExportField($this->Denda);
						if ($this->DispensasiDenda->Exportable) $Doc->ExportField($this->DispensasiDenda);
						if ($this->LamaAngsuran->Exportable) $Doc->ExportField($this->LamaAngsuran);
						if ($this->JumlahAngsuran->Exportable) $Doc->ExportField($this->JumlahAngsuran);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->NoKontrak->Exportable) $Doc->ExportField($this->NoKontrak);
						if ($this->Customer->Exportable) $Doc->ExportField($this->Customer);
						if ($this->Pekerjaan->Exportable) $Doc->ExportField($this->Pekerjaan);
						if ($this->NoTelpHp->Exportable) $Doc->ExportField($this->NoTelpHp);
						if ($this->TglKontrak->Exportable) $Doc->ExportField($this->TglKontrak);
						if ($this->MerkType->Exportable) $Doc->ExportField($this->MerkType);
						if ($this->NoRangka->Exportable) $Doc->ExportField($this->NoRangka);
						if ($this->NoMesin->Exportable) $Doc->ExportField($this->NoMesin);
						if ($this->Warna->Exportable) $Doc->ExportField($this->Warna);
						if ($this->NoPol->Exportable) $Doc->ExportField($this->NoPol);
						if ($this->AtasNama->Exportable) $Doc->ExportField($this->AtasNama);
						if ($this->Pinjaman->Exportable) $Doc->ExportField($this->Pinjaman);
						if ($this->Denda->Exportable) $Doc->ExportField($this->Denda);
						if ($this->DispensasiDenda->Exportable) $Doc->ExportField($this->DispensasiDenda);
						if ($this->LamaAngsuran->Exportable) $Doc->ExportField($this->LamaAngsuran);
						if ($this->JumlahAngsuran->Exportable) $Doc->ExportField($this->JumlahAngsuran);
					}
					$Doc->EndExportRow($RowCnt);
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 't01_nasabah';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 't01_nasabah';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['id'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserID();
		foreach (array_keys($rs) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") {
					$newvalue = $Language->Phrase("PasswordMask"); // Password Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) {
					if (EW_AUDIT_TRAIL_TO_DATABASE)
						$newvalue = $rs[$fldname];
					else
						$newvalue = "[MEMO]"; // Memo Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) {
					$newvalue = "[XML]"; // XML Field
				} else {
					$newvalue = $rs[$fldname];
				}
				ew_WriteAuditTrail("log", $dt, $id, $usr, "A", $table, $fldname, $key, "", $newvalue);
			}
		}
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 't01_nasabah';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['id'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserID();
		foreach (array_keys($rsnew) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && array_key_exists($fldname, $rsold) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldDataType == EW_DATATYPE_DATE) { // DateTime field
					$modified = (ew_FormatDateTime($rsold[$fldname], 0) <> ew_FormatDateTime($rsnew[$fldname], 0));
				} else {
					$modified = !ew_CompareValue($rsold[$fldname], $rsnew[$fldname]);
				}
				if ($modified) {
					if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") { // Password Field
						$oldvalue = $Language->Phrase("PasswordMask");
						$newvalue = $Language->Phrase("PasswordMask");
					} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) { // Memo field
						if (EW_AUDIT_TRAIL_TO_DATABASE) {
							$oldvalue = $rsold[$fldname];
							$newvalue = $rsnew[$fldname];
						} else {
							$oldvalue = "[MEMO]";
							$newvalue = "[MEMO]";
						}
					} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) { // XML field
						$oldvalue = "[XML]";
						$newvalue = "[XML]";
					} else {
						$oldvalue = $rsold[$fldname];
						$newvalue = $rsnew[$fldname];
					}
					ew_WriteAuditTrail("log", $dt, $id, $usr, "U", $table, $fldname, $key, $oldvalue, $newvalue);
				}
			}
		}
	}

	// Write Audit Trail (delete page)
	function WriteAuditTrailOnDelete(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnDelete) return;
		$table = 't01_nasabah';

		// Get key value
		$key = "";
		if ($key <> "")
			$key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['id'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$curUser = CurrentUserID();
		foreach (array_keys($rs) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") {
					$oldvalue = $Language->Phrase("PasswordMask"); // Password Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) {
					if (EW_AUDIT_TRAIL_TO_DATABASE)
						$oldvalue = $rs[$fldname];
					else
						$oldvalue = "[MEMO]"; // Memo field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) {
					$oldvalue = "[XML]"; // XML field
				} else {
					$oldvalue = $rs[$fldname];
				}
				ew_WriteAuditTrail("log", $dt, $id, $curUser, "D", $table, $fldname, $key, $oldvalue, "");
			}
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>);

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
