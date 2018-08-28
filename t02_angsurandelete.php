<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "t02_angsuraninfo.php" ?>
<?php include_once "t01_nasabahinfo.php" ?>
<?php include_once "t96_employeesinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$t02_angsuran_delete = NULL; // Initialize page object first

class ct02_angsuran_delete extends ct02_angsuran {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{B3698D9B-8D4B-412E-A2E5-AFAD2FEE5A23}';

	// Table name
	var $TableName = 't02_angsuran';

	// Page object name
	var $PageObjName = 't02_angsuran_delete';

	// Page headings
	var $Heading = '';
	var $Subheading = '';

	// Page heading
	function PageHeading() {
		global $Language;
		if ($this->Heading <> "")
			return $this->Heading;
		if (method_exists($this, "TableCaption"))
			return $this->TableCaption();
		return "";
	}

	// Page subheading
	function PageSubheading() {
		global $Language;
		if ($this->Subheading <> "")
			return $this->Subheading;
		if ($this->TableName)
			return $Language->Phrase($this->PageID);
		return "";
	}

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}
	var $AuditTrailOnAdd = TRUE;
	var $AuditTrailOnEdit = TRUE;
	var $AuditTrailOnDelete = TRUE;
	var $AuditTrailOnView = FALSE;
	var $AuditTrailOnViewData = FALSE;
	var $AuditTrailOnSearch = FALSE;

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (t02_angsuran)
		if (!isset($GLOBALS["t02_angsuran"]) || get_class($GLOBALS["t02_angsuran"]) == "ct02_angsuran") {
			$GLOBALS["t02_angsuran"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t02_angsuran"];
		}

		// Table object (t01_nasabah)
		if (!isset($GLOBALS['t01_nasabah'])) $GLOBALS['t01_nasabah'] = new ct01_nasabah();

		// Table object (t96_employees)
		if (!isset($GLOBALS['t96_employees'])) $GLOBALS['t96_employees'] = new ct96_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't02_angsuran', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"]))
			$GLOBALS["gTimer"] = new cTimer();

		// Debug message
		ew_LoadDebugMsg();

		// Open connection
		if (!isset($conn))
			$conn = ew_Connect($this->DBID);

		// User table object (t96_employees)
		if (!isset($UserTable)) {
			$UserTable = new ct96_employees();
			$UserTableConn = Conn($UserTable->DBID);
		}
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("t02_angsuranlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->id->Visible = FALSE;
		$this->nasabah_id->SetVisibility();
		$this->Tanggal->SetVisibility();
		$this->AngsuranPokok->SetVisibility();
		$this->AngsuranBunga->SetVisibility();
		$this->AngsuranTotal->SetVisibility();
		$this->SisaHutang->SetVisibility();
		$this->TanggalBayar->SetVisibility();
		$this->TotalDenda->SetVisibility();
		$this->Terlambat->SetVisibility();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $t02_angsuran;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t02_angsuran);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		// Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			ew_SaveDebugMsg();
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up master/detail parameters
		$this->SetupMasterParms();

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("t02_angsuranlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in t02_angsuran class, t02_angsuraninfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("t02_angsuranlist.php"); // Return to list
			}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->ListSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues($rs = NULL) {
		if ($rs && !$rs->EOF)
			$row = $rs->fields;
		else
			$row = $this->NewRow(); 

		// Call Row Selected event
		$this->Row_Selected($row);
		if (!$rs || $rs->EOF)
			return;
		$this->id->setDbValue($row['id']);
		$this->nasabah_id->setDbValue($row['nasabah_id']);
		$this->Tanggal->setDbValue($row['Tanggal']);
		$this->AngsuranPokok->setDbValue($row['AngsuranPokok']);
		$this->AngsuranBunga->setDbValue($row['AngsuranBunga']);
		$this->AngsuranTotal->setDbValue($row['AngsuranTotal']);
		$this->SisaHutang->setDbValue($row['SisaHutang']);
		$this->TanggalBayar->setDbValue($row['TanggalBayar']);
		$this->TotalDenda->setDbValue($row['TotalDenda']);
		$this->Terlambat->setDbValue($row['Terlambat']);
		$this->Keterangan->setDbValue($row['Keterangan']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['nasabah_id'] = NULL;
		$row['Tanggal'] = NULL;
		$row['AngsuranPokok'] = NULL;
		$row['AngsuranBunga'] = NULL;
		$row['AngsuranTotal'] = NULL;
		$row['SisaHutang'] = NULL;
		$row['TanggalBayar'] = NULL;
		$row['TotalDenda'] = NULL;
		$row['Terlambat'] = NULL;
		$row['Keterangan'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->nasabah_id->DbValue = $row['nasabah_id'];
		$this->Tanggal->DbValue = $row['Tanggal'];
		$this->AngsuranPokok->DbValue = $row['AngsuranPokok'];
		$this->AngsuranBunga->DbValue = $row['AngsuranBunga'];
		$this->AngsuranTotal->DbValue = $row['AngsuranTotal'];
		$this->SisaHutang->DbValue = $row['SisaHutang'];
		$this->TanggalBayar->DbValue = $row['TanggalBayar'];
		$this->TotalDenda->DbValue = $row['TotalDenda'];
		$this->Terlambat->DbValue = $row['Terlambat'];
		$this->Keterangan->DbValue = $row['Keterangan'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->AngsuranPokok->FormValue == $this->AngsuranPokok->CurrentValue && is_numeric(ew_StrToFloat($this->AngsuranPokok->CurrentValue)))
			$this->AngsuranPokok->CurrentValue = ew_StrToFloat($this->AngsuranPokok->CurrentValue);

		// Convert decimal values if posted back
		if ($this->AngsuranBunga->FormValue == $this->AngsuranBunga->CurrentValue && is_numeric(ew_StrToFloat($this->AngsuranBunga->CurrentValue)))
			$this->AngsuranBunga->CurrentValue = ew_StrToFloat($this->AngsuranBunga->CurrentValue);

		// Convert decimal values if posted back
		if ($this->AngsuranTotal->FormValue == $this->AngsuranTotal->CurrentValue && is_numeric(ew_StrToFloat($this->AngsuranTotal->CurrentValue)))
			$this->AngsuranTotal->CurrentValue = ew_StrToFloat($this->AngsuranTotal->CurrentValue);

		// Convert decimal values if posted back
		if ($this->SisaHutang->FormValue == $this->SisaHutang->CurrentValue && is_numeric(ew_StrToFloat($this->SisaHutang->CurrentValue)))
			$this->SisaHutang->CurrentValue = ew_StrToFloat($this->SisaHutang->CurrentValue);

		// Convert decimal values if posted back
		if ($this->TotalDenda->FormValue == $this->TotalDenda->CurrentValue && is_numeric(ew_StrToFloat($this->TotalDenda->CurrentValue)))
			$this->TotalDenda->CurrentValue = ew_StrToFloat($this->TotalDenda->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// nasabah_id
		// Tanggal
		// AngsuranPokok
		// AngsuranBunga
		// AngsuranTotal
		// SisaHutang
		// TanggalBayar
		// TotalDenda
		// Terlambat
		// Keterangan

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// nasabah_id
		$this->nasabah_id->ViewValue = $this->nasabah_id->CurrentValue;
		$this->nasabah_id->ViewCustomAttributes = "";

		// Tanggal
		$this->Tanggal->ViewValue = $this->Tanggal->CurrentValue;
		$this->Tanggal->ViewValue = ew_FormatDateTime($this->Tanggal->ViewValue, 0);
		$this->Tanggal->ViewCustomAttributes = "";

		// AngsuranPokok
		$this->AngsuranPokok->ViewValue = $this->AngsuranPokok->CurrentValue;
		$this->AngsuranPokok->ViewCustomAttributes = "";

		// AngsuranBunga
		$this->AngsuranBunga->ViewValue = $this->AngsuranBunga->CurrentValue;
		$this->AngsuranBunga->ViewCustomAttributes = "";

		// AngsuranTotal
		$this->AngsuranTotal->ViewValue = $this->AngsuranTotal->CurrentValue;
		$this->AngsuranTotal->ViewCustomAttributes = "";

		// SisaHutang
		$this->SisaHutang->ViewValue = $this->SisaHutang->CurrentValue;
		$this->SisaHutang->ViewCustomAttributes = "";

		// TanggalBayar
		$this->TanggalBayar->ViewValue = $this->TanggalBayar->CurrentValue;
		$this->TanggalBayar->ViewValue = ew_FormatDateTime($this->TanggalBayar->ViewValue, 0);
		$this->TanggalBayar->ViewCustomAttributes = "";

		// TotalDenda
		$this->TotalDenda->ViewValue = $this->TotalDenda->CurrentValue;
		$this->TotalDenda->ViewCustomAttributes = "";

		// Terlambat
		$this->Terlambat->ViewValue = $this->Terlambat->CurrentValue;
		$this->Terlambat->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// nasabah_id
			$this->nasabah_id->LinkCustomAttributes = "";
			$this->nasabah_id->HrefValue = "";
			$this->nasabah_id->TooltipValue = "";

			// Tanggal
			$this->Tanggal->LinkCustomAttributes = "";
			$this->Tanggal->HrefValue = "";
			$this->Tanggal->TooltipValue = "";

			// AngsuranPokok
			$this->AngsuranPokok->LinkCustomAttributes = "";
			$this->AngsuranPokok->HrefValue = "";
			$this->AngsuranPokok->TooltipValue = "";

			// AngsuranBunga
			$this->AngsuranBunga->LinkCustomAttributes = "";
			$this->AngsuranBunga->HrefValue = "";
			$this->AngsuranBunga->TooltipValue = "";

			// AngsuranTotal
			$this->AngsuranTotal->LinkCustomAttributes = "";
			$this->AngsuranTotal->HrefValue = "";
			$this->AngsuranTotal->TooltipValue = "";

			// SisaHutang
			$this->SisaHutang->LinkCustomAttributes = "";
			$this->SisaHutang->HrefValue = "";
			$this->SisaHutang->TooltipValue = "";

			// TanggalBayar
			$this->TanggalBayar->LinkCustomAttributes = "";
			$this->TanggalBayar->HrefValue = "";
			$this->TanggalBayar->TooltipValue = "";

			// TotalDenda
			$this->TotalDenda->LinkCustomAttributes = "";
			$this->TotalDenda->HrefValue = "";
			$this->TotalDenda->TooltipValue = "";

			// Terlambat
			$this->Terlambat->LinkCustomAttributes = "";
			$this->Terlambat->HrefValue = "";
			$this->Terlambat->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();
		if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteBegin")); // Batch delete begin

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['id'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		}
		if (!$DeleteRows) {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteSuccess")); // Batch delete success
		} else {
			$conn->RollbackTrans(); // Rollback changes
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteRollback")); // Batch delete rollback
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up master/detail based on QueryString
	function SetupMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "t01_nasabah") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_id"] <> "") {
					$GLOBALS["t01_nasabah"]->id->setQueryStringValue($_GET["fk_id"]);
					$this->nasabah_id->setQueryStringValue($GLOBALS["t01_nasabah"]->id->QueryStringValue);
					$this->nasabah_id->setSessionValue($this->nasabah_id->QueryStringValue);
					if (!is_numeric($GLOBALS["t01_nasabah"]->id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		} elseif (isset($_POST[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_POST[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "t01_nasabah") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_id"] <> "") {
					$GLOBALS["t01_nasabah"]->id->setFormValue($_POST["fk_id"]);
					$this->nasabah_id->setFormValue($GLOBALS["t01_nasabah"]->id->FormValue);
					$this->nasabah_id->setSessionValue($this->nasabah_id->FormValue);
					if (!is_numeric($GLOBALS["t01_nasabah"]->id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			if (!$this->IsAddOrEdit()) {
				$this->StartRec = 1;
				$this->setStartRecordNumber($this->StartRec);
			}

			// Clear previous master key from Session
			if ($sMasterTblVar <> "t01_nasabah") {
				if ($this->nasabah_id->CurrentValue == "") $this->nasabah_id->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t02_angsuranlist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t02_angsuran_delete)) $t02_angsuran_delete = new ct02_angsuran_delete();

// Page init
$t02_angsuran_delete->Page_Init();

// Page main
$t02_angsuran_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t02_angsuran_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ft02_angsurandelete = new ew_Form("ft02_angsurandelete", "delete");

// Form_CustomValidate event
ft02_angsurandelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft02_angsurandelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t02_angsuran_delete->ShowPageHeader(); ?>
<?php
$t02_angsuran_delete->ShowMessage();
?>
<form name="ft02_angsurandelete" id="ft02_angsurandelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t02_angsuran_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t02_angsuran_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t02_angsuran">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($t02_angsuran_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($t02_angsuran->id->Visible) { // id ?>
		<th class="<?php echo $t02_angsuran->id->HeaderCellClass() ?>"><span id="elh_t02_angsuran_id" class="t02_angsuran_id"><?php echo $t02_angsuran->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t02_angsuran->nasabah_id->Visible) { // nasabah_id ?>
		<th class="<?php echo $t02_angsuran->nasabah_id->HeaderCellClass() ?>"><span id="elh_t02_angsuran_nasabah_id" class="t02_angsuran_nasabah_id"><?php echo $t02_angsuran->nasabah_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t02_angsuran->Tanggal->Visible) { // Tanggal ?>
		<th class="<?php echo $t02_angsuran->Tanggal->HeaderCellClass() ?>"><span id="elh_t02_angsuran_Tanggal" class="t02_angsuran_Tanggal"><?php echo $t02_angsuran->Tanggal->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t02_angsuran->AngsuranPokok->Visible) { // AngsuranPokok ?>
		<th class="<?php echo $t02_angsuran->AngsuranPokok->HeaderCellClass() ?>"><span id="elh_t02_angsuran_AngsuranPokok" class="t02_angsuran_AngsuranPokok"><?php echo $t02_angsuran->AngsuranPokok->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t02_angsuran->AngsuranBunga->Visible) { // AngsuranBunga ?>
		<th class="<?php echo $t02_angsuran->AngsuranBunga->HeaderCellClass() ?>"><span id="elh_t02_angsuran_AngsuranBunga" class="t02_angsuran_AngsuranBunga"><?php echo $t02_angsuran->AngsuranBunga->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t02_angsuran->AngsuranTotal->Visible) { // AngsuranTotal ?>
		<th class="<?php echo $t02_angsuran->AngsuranTotal->HeaderCellClass() ?>"><span id="elh_t02_angsuran_AngsuranTotal" class="t02_angsuran_AngsuranTotal"><?php echo $t02_angsuran->AngsuranTotal->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t02_angsuran->SisaHutang->Visible) { // SisaHutang ?>
		<th class="<?php echo $t02_angsuran->SisaHutang->HeaderCellClass() ?>"><span id="elh_t02_angsuran_SisaHutang" class="t02_angsuran_SisaHutang"><?php echo $t02_angsuran->SisaHutang->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t02_angsuran->TanggalBayar->Visible) { // TanggalBayar ?>
		<th class="<?php echo $t02_angsuran->TanggalBayar->HeaderCellClass() ?>"><span id="elh_t02_angsuran_TanggalBayar" class="t02_angsuran_TanggalBayar"><?php echo $t02_angsuran->TanggalBayar->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t02_angsuran->TotalDenda->Visible) { // TotalDenda ?>
		<th class="<?php echo $t02_angsuran->TotalDenda->HeaderCellClass() ?>"><span id="elh_t02_angsuran_TotalDenda" class="t02_angsuran_TotalDenda"><?php echo $t02_angsuran->TotalDenda->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t02_angsuran->Terlambat->Visible) { // Terlambat ?>
		<th class="<?php echo $t02_angsuran->Terlambat->HeaderCellClass() ?>"><span id="elh_t02_angsuran_Terlambat" class="t02_angsuran_Terlambat"><?php echo $t02_angsuran->Terlambat->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$t02_angsuran_delete->RecCnt = 0;
$i = 0;
while (!$t02_angsuran_delete->Recordset->EOF) {
	$t02_angsuran_delete->RecCnt++;
	$t02_angsuran_delete->RowCnt++;

	// Set row properties
	$t02_angsuran->ResetAttrs();
	$t02_angsuran->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$t02_angsuran_delete->LoadRowValues($t02_angsuran_delete->Recordset);

	// Render row
	$t02_angsuran_delete->RenderRow();
?>
	<tr<?php echo $t02_angsuran->RowAttributes() ?>>
<?php if ($t02_angsuran->id->Visible) { // id ?>
		<td<?php echo $t02_angsuran->id->CellAttributes() ?>>
<span id="el<?php echo $t02_angsuran_delete->RowCnt ?>_t02_angsuran_id" class="t02_angsuran_id">
<span<?php echo $t02_angsuran->id->ViewAttributes() ?>>
<?php echo $t02_angsuran->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t02_angsuran->nasabah_id->Visible) { // nasabah_id ?>
		<td<?php echo $t02_angsuran->nasabah_id->CellAttributes() ?>>
<span id="el<?php echo $t02_angsuran_delete->RowCnt ?>_t02_angsuran_nasabah_id" class="t02_angsuran_nasabah_id">
<span<?php echo $t02_angsuran->nasabah_id->ViewAttributes() ?>>
<?php echo $t02_angsuran->nasabah_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t02_angsuran->Tanggal->Visible) { // Tanggal ?>
		<td<?php echo $t02_angsuran->Tanggal->CellAttributes() ?>>
<span id="el<?php echo $t02_angsuran_delete->RowCnt ?>_t02_angsuran_Tanggal" class="t02_angsuran_Tanggal">
<span<?php echo $t02_angsuran->Tanggal->ViewAttributes() ?>>
<?php echo $t02_angsuran->Tanggal->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t02_angsuran->AngsuranPokok->Visible) { // AngsuranPokok ?>
		<td<?php echo $t02_angsuran->AngsuranPokok->CellAttributes() ?>>
<span id="el<?php echo $t02_angsuran_delete->RowCnt ?>_t02_angsuran_AngsuranPokok" class="t02_angsuran_AngsuranPokok">
<span<?php echo $t02_angsuran->AngsuranPokok->ViewAttributes() ?>>
<?php echo $t02_angsuran->AngsuranPokok->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t02_angsuran->AngsuranBunga->Visible) { // AngsuranBunga ?>
		<td<?php echo $t02_angsuran->AngsuranBunga->CellAttributes() ?>>
<span id="el<?php echo $t02_angsuran_delete->RowCnt ?>_t02_angsuran_AngsuranBunga" class="t02_angsuran_AngsuranBunga">
<span<?php echo $t02_angsuran->AngsuranBunga->ViewAttributes() ?>>
<?php echo $t02_angsuran->AngsuranBunga->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t02_angsuran->AngsuranTotal->Visible) { // AngsuranTotal ?>
		<td<?php echo $t02_angsuran->AngsuranTotal->CellAttributes() ?>>
<span id="el<?php echo $t02_angsuran_delete->RowCnt ?>_t02_angsuran_AngsuranTotal" class="t02_angsuran_AngsuranTotal">
<span<?php echo $t02_angsuran->AngsuranTotal->ViewAttributes() ?>>
<?php echo $t02_angsuran->AngsuranTotal->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t02_angsuran->SisaHutang->Visible) { // SisaHutang ?>
		<td<?php echo $t02_angsuran->SisaHutang->CellAttributes() ?>>
<span id="el<?php echo $t02_angsuran_delete->RowCnt ?>_t02_angsuran_SisaHutang" class="t02_angsuran_SisaHutang">
<span<?php echo $t02_angsuran->SisaHutang->ViewAttributes() ?>>
<?php echo $t02_angsuran->SisaHutang->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t02_angsuran->TanggalBayar->Visible) { // TanggalBayar ?>
		<td<?php echo $t02_angsuran->TanggalBayar->CellAttributes() ?>>
<span id="el<?php echo $t02_angsuran_delete->RowCnt ?>_t02_angsuran_TanggalBayar" class="t02_angsuran_TanggalBayar">
<span<?php echo $t02_angsuran->TanggalBayar->ViewAttributes() ?>>
<?php echo $t02_angsuran->TanggalBayar->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t02_angsuran->TotalDenda->Visible) { // TotalDenda ?>
		<td<?php echo $t02_angsuran->TotalDenda->CellAttributes() ?>>
<span id="el<?php echo $t02_angsuran_delete->RowCnt ?>_t02_angsuran_TotalDenda" class="t02_angsuran_TotalDenda">
<span<?php echo $t02_angsuran->TotalDenda->ViewAttributes() ?>>
<?php echo $t02_angsuran->TotalDenda->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t02_angsuran->Terlambat->Visible) { // Terlambat ?>
		<td<?php echo $t02_angsuran->Terlambat->CellAttributes() ?>>
<span id="el<?php echo $t02_angsuran_delete->RowCnt ?>_t02_angsuran_Terlambat" class="t02_angsuran_Terlambat">
<span<?php echo $t02_angsuran->Terlambat->ViewAttributes() ?>>
<?php echo $t02_angsuran->Terlambat->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$t02_angsuran_delete->Recordset->MoveNext();
}
$t02_angsuran_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t02_angsuran_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ft02_angsurandelete.Init();
</script>
<?php
$t02_angsuran_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t02_angsuran_delete->Page_Terminate();
?>
