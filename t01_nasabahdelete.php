<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "t01_nasabahinfo.php" ?>
<?php include_once "t96_employeesinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$t01_nasabah_delete = NULL; // Initialize page object first

class ct01_nasabah_delete extends ct01_nasabah {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{B3698D9B-8D4B-412E-A2E5-AFAD2FEE5A23}';

	// Table name
	var $TableName = 't01_nasabah';

	// Page object name
	var $PageObjName = 't01_nasabah_delete';

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

		// Table object (t01_nasabah)
		if (!isset($GLOBALS["t01_nasabah"]) || get_class($GLOBALS["t01_nasabah"]) == "ct01_nasabah") {
			$GLOBALS["t01_nasabah"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t01_nasabah"];
		}

		// Table object (t96_employees)
		if (!isset($GLOBALS['t96_employees'])) $GLOBALS['t96_employees'] = new ct96_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't01_nasabah', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("t01_nasabahlist.php"));
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
		$this->NoKontrak->SetVisibility();
		$this->Customer->SetVisibility();
		$this->Pekerjaan->SetVisibility();
		$this->NoTelpHp->SetVisibility();
		$this->TglKontrak->SetVisibility();
		$this->MerkType->SetVisibility();
		$this->NoRangka->SetVisibility();
		$this->NoMesin->SetVisibility();
		$this->Warna->SetVisibility();
		$this->NoPol->SetVisibility();
		$this->AtasNama->SetVisibility();
		$this->Pinjaman->SetVisibility();
		$this->Denda->SetVisibility();
		$this->DispensasiDenda->SetVisibility();
		$this->LamaAngsuran->SetVisibility();
		$this->JumlahAngsuran->SetVisibility();

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
		global $EW_EXPORT, $t01_nasabah;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t01_nasabah);
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

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("t01_nasabahlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in t01_nasabah class, t01_nasabahinfo.php

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
				$this->Page_Terminate("t01_nasabahlist.php"); // Return to list
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
		$this->NoKontrak->setDbValue($row['NoKontrak']);
		$this->Customer->setDbValue($row['Customer']);
		$this->Pekerjaan->setDbValue($row['Pekerjaan']);
		$this->Alamat->setDbValue($row['Alamat']);
		$this->NoTelpHp->setDbValue($row['NoTelpHp']);
		$this->TglKontrak->setDbValue($row['TglKontrak']);
		$this->MerkType->setDbValue($row['MerkType']);
		$this->NoRangka->setDbValue($row['NoRangka']);
		$this->NoMesin->setDbValue($row['NoMesin']);
		$this->Warna->setDbValue($row['Warna']);
		$this->NoPol->setDbValue($row['NoPol']);
		$this->Keterangan->setDbValue($row['Keterangan']);
		$this->AtasNama->setDbValue($row['AtasNama']);
		$this->Pinjaman->setDbValue($row['Pinjaman']);
		$this->Denda->setDbValue($row['Denda']);
		$this->DispensasiDenda->setDbValue($row['DispensasiDenda']);
		$this->LamaAngsuran->setDbValue($row['LamaAngsuran']);
		$this->JumlahAngsuran->setDbValue($row['JumlahAngsuran']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['NoKontrak'] = NULL;
		$row['Customer'] = NULL;
		$row['Pekerjaan'] = NULL;
		$row['Alamat'] = NULL;
		$row['NoTelpHp'] = NULL;
		$row['TglKontrak'] = NULL;
		$row['MerkType'] = NULL;
		$row['NoRangka'] = NULL;
		$row['NoMesin'] = NULL;
		$row['Warna'] = NULL;
		$row['NoPol'] = NULL;
		$row['Keterangan'] = NULL;
		$row['AtasNama'] = NULL;
		$row['Pinjaman'] = NULL;
		$row['Denda'] = NULL;
		$row['DispensasiDenda'] = NULL;
		$row['LamaAngsuran'] = NULL;
		$row['JumlahAngsuran'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->NoKontrak->DbValue = $row['NoKontrak'];
		$this->Customer->DbValue = $row['Customer'];
		$this->Pekerjaan->DbValue = $row['Pekerjaan'];
		$this->Alamat->DbValue = $row['Alamat'];
		$this->NoTelpHp->DbValue = $row['NoTelpHp'];
		$this->TglKontrak->DbValue = $row['TglKontrak'];
		$this->MerkType->DbValue = $row['MerkType'];
		$this->NoRangka->DbValue = $row['NoRangka'];
		$this->NoMesin->DbValue = $row['NoMesin'];
		$this->Warna->DbValue = $row['Warna'];
		$this->NoPol->DbValue = $row['NoPol'];
		$this->Keterangan->DbValue = $row['Keterangan'];
		$this->AtasNama->DbValue = $row['AtasNama'];
		$this->Pinjaman->DbValue = $row['Pinjaman'];
		$this->Denda->DbValue = $row['Denda'];
		$this->DispensasiDenda->DbValue = $row['DispensasiDenda'];
		$this->LamaAngsuran->DbValue = $row['LamaAngsuran'];
		$this->JumlahAngsuran->DbValue = $row['JumlahAngsuran'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->Pinjaman->FormValue == $this->Pinjaman->CurrentValue && is_numeric(ew_StrToFloat($this->Pinjaman->CurrentValue)))
			$this->Pinjaman->CurrentValue = ew_StrToFloat($this->Pinjaman->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Denda->FormValue == $this->Denda->CurrentValue && is_numeric(ew_StrToFloat($this->Denda->CurrentValue)))
			$this->Denda->CurrentValue = ew_StrToFloat($this->Denda->CurrentValue);

		// Convert decimal values if posted back
		if ($this->JumlahAngsuran->FormValue == $this->JumlahAngsuran->CurrentValue && is_numeric(ew_StrToFloat($this->JumlahAngsuran->CurrentValue)))
			$this->JumlahAngsuran->CurrentValue = ew_StrToFloat($this->JumlahAngsuran->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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

		// NoTelpHp
		$this->NoTelpHp->ViewValue = $this->NoTelpHp->CurrentValue;
		$this->NoTelpHp->ViewCustomAttributes = "";

		// TglKontrak
		$this->TglKontrak->ViewValue = $this->TglKontrak->CurrentValue;
		$this->TglKontrak->ViewValue = ew_FormatDateTime($this->TglKontrak->ViewValue, 0);
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

		// AtasNama
		$this->AtasNama->ViewValue = $this->AtasNama->CurrentValue;
		$this->AtasNama->ViewCustomAttributes = "";

		// Pinjaman
		$this->Pinjaman->ViewValue = $this->Pinjaman->CurrentValue;
		$this->Pinjaman->ViewCustomAttributes = "";

		// Denda
		$this->Denda->ViewValue = $this->Denda->CurrentValue;
		$this->Denda->ViewCustomAttributes = "";

		// DispensasiDenda
		$this->DispensasiDenda->ViewValue = $this->DispensasiDenda->CurrentValue;
		$this->DispensasiDenda->ViewCustomAttributes = "";

		// LamaAngsuran
		$this->LamaAngsuran->ViewValue = $this->LamaAngsuran->CurrentValue;
		$this->LamaAngsuran->ViewCustomAttributes = "";

		// JumlahAngsuran
		$this->JumlahAngsuran->ViewValue = $this->JumlahAngsuran->CurrentValue;
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
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t01_nasabahlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($t01_nasabah_delete)) $t01_nasabah_delete = new ct01_nasabah_delete();

// Page init
$t01_nasabah_delete->Page_Init();

// Page main
$t01_nasabah_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t01_nasabah_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ft01_nasabahdelete = new ew_Form("ft01_nasabahdelete", "delete");

// Form_CustomValidate event
ft01_nasabahdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft01_nasabahdelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t01_nasabah_delete->ShowPageHeader(); ?>
<?php
$t01_nasabah_delete->ShowMessage();
?>
<form name="ft01_nasabahdelete" id="ft01_nasabahdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t01_nasabah_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t01_nasabah_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t01_nasabah">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($t01_nasabah_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($t01_nasabah->id->Visible) { // id ?>
		<th class="<?php echo $t01_nasabah->id->HeaderCellClass() ?>"><span id="elh_t01_nasabah_id" class="t01_nasabah_id"><?php echo $t01_nasabah->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_nasabah->NoKontrak->Visible) { // NoKontrak ?>
		<th class="<?php echo $t01_nasabah->NoKontrak->HeaderCellClass() ?>"><span id="elh_t01_nasabah_NoKontrak" class="t01_nasabah_NoKontrak"><?php echo $t01_nasabah->NoKontrak->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_nasabah->Customer->Visible) { // Customer ?>
		<th class="<?php echo $t01_nasabah->Customer->HeaderCellClass() ?>"><span id="elh_t01_nasabah_Customer" class="t01_nasabah_Customer"><?php echo $t01_nasabah->Customer->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_nasabah->Pekerjaan->Visible) { // Pekerjaan ?>
		<th class="<?php echo $t01_nasabah->Pekerjaan->HeaderCellClass() ?>"><span id="elh_t01_nasabah_Pekerjaan" class="t01_nasabah_Pekerjaan"><?php echo $t01_nasabah->Pekerjaan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_nasabah->NoTelpHp->Visible) { // NoTelpHp ?>
		<th class="<?php echo $t01_nasabah->NoTelpHp->HeaderCellClass() ?>"><span id="elh_t01_nasabah_NoTelpHp" class="t01_nasabah_NoTelpHp"><?php echo $t01_nasabah->NoTelpHp->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_nasabah->TglKontrak->Visible) { // TglKontrak ?>
		<th class="<?php echo $t01_nasabah->TglKontrak->HeaderCellClass() ?>"><span id="elh_t01_nasabah_TglKontrak" class="t01_nasabah_TglKontrak"><?php echo $t01_nasabah->TglKontrak->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_nasabah->MerkType->Visible) { // MerkType ?>
		<th class="<?php echo $t01_nasabah->MerkType->HeaderCellClass() ?>"><span id="elh_t01_nasabah_MerkType" class="t01_nasabah_MerkType"><?php echo $t01_nasabah->MerkType->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_nasabah->NoRangka->Visible) { // NoRangka ?>
		<th class="<?php echo $t01_nasabah->NoRangka->HeaderCellClass() ?>"><span id="elh_t01_nasabah_NoRangka" class="t01_nasabah_NoRangka"><?php echo $t01_nasabah->NoRangka->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_nasabah->NoMesin->Visible) { // NoMesin ?>
		<th class="<?php echo $t01_nasabah->NoMesin->HeaderCellClass() ?>"><span id="elh_t01_nasabah_NoMesin" class="t01_nasabah_NoMesin"><?php echo $t01_nasabah->NoMesin->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_nasabah->Warna->Visible) { // Warna ?>
		<th class="<?php echo $t01_nasabah->Warna->HeaderCellClass() ?>"><span id="elh_t01_nasabah_Warna" class="t01_nasabah_Warna"><?php echo $t01_nasabah->Warna->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_nasabah->NoPol->Visible) { // NoPol ?>
		<th class="<?php echo $t01_nasabah->NoPol->HeaderCellClass() ?>"><span id="elh_t01_nasabah_NoPol" class="t01_nasabah_NoPol"><?php echo $t01_nasabah->NoPol->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_nasabah->AtasNama->Visible) { // AtasNama ?>
		<th class="<?php echo $t01_nasabah->AtasNama->HeaderCellClass() ?>"><span id="elh_t01_nasabah_AtasNama" class="t01_nasabah_AtasNama"><?php echo $t01_nasabah->AtasNama->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_nasabah->Pinjaman->Visible) { // Pinjaman ?>
		<th class="<?php echo $t01_nasabah->Pinjaman->HeaderCellClass() ?>"><span id="elh_t01_nasabah_Pinjaman" class="t01_nasabah_Pinjaman"><?php echo $t01_nasabah->Pinjaman->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_nasabah->Denda->Visible) { // Denda ?>
		<th class="<?php echo $t01_nasabah->Denda->HeaderCellClass() ?>"><span id="elh_t01_nasabah_Denda" class="t01_nasabah_Denda"><?php echo $t01_nasabah->Denda->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_nasabah->DispensasiDenda->Visible) { // DispensasiDenda ?>
		<th class="<?php echo $t01_nasabah->DispensasiDenda->HeaderCellClass() ?>"><span id="elh_t01_nasabah_DispensasiDenda" class="t01_nasabah_DispensasiDenda"><?php echo $t01_nasabah->DispensasiDenda->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_nasabah->LamaAngsuran->Visible) { // LamaAngsuran ?>
		<th class="<?php echo $t01_nasabah->LamaAngsuran->HeaderCellClass() ?>"><span id="elh_t01_nasabah_LamaAngsuran" class="t01_nasabah_LamaAngsuran"><?php echo $t01_nasabah->LamaAngsuran->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_nasabah->JumlahAngsuran->Visible) { // JumlahAngsuran ?>
		<th class="<?php echo $t01_nasabah->JumlahAngsuran->HeaderCellClass() ?>"><span id="elh_t01_nasabah_JumlahAngsuran" class="t01_nasabah_JumlahAngsuran"><?php echo $t01_nasabah->JumlahAngsuran->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$t01_nasabah_delete->RecCnt = 0;
$i = 0;
while (!$t01_nasabah_delete->Recordset->EOF) {
	$t01_nasabah_delete->RecCnt++;
	$t01_nasabah_delete->RowCnt++;

	// Set row properties
	$t01_nasabah->ResetAttrs();
	$t01_nasabah->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$t01_nasabah_delete->LoadRowValues($t01_nasabah_delete->Recordset);

	// Render row
	$t01_nasabah_delete->RenderRow();
?>
	<tr<?php echo $t01_nasabah->RowAttributes() ?>>
<?php if ($t01_nasabah->id->Visible) { // id ?>
		<td<?php echo $t01_nasabah->id->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_delete->RowCnt ?>_t01_nasabah_id" class="t01_nasabah_id">
<span<?php echo $t01_nasabah->id->ViewAttributes() ?>>
<?php echo $t01_nasabah->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_nasabah->NoKontrak->Visible) { // NoKontrak ?>
		<td<?php echo $t01_nasabah->NoKontrak->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_delete->RowCnt ?>_t01_nasabah_NoKontrak" class="t01_nasabah_NoKontrak">
<span<?php echo $t01_nasabah->NoKontrak->ViewAttributes() ?>>
<?php echo $t01_nasabah->NoKontrak->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_nasabah->Customer->Visible) { // Customer ?>
		<td<?php echo $t01_nasabah->Customer->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_delete->RowCnt ?>_t01_nasabah_Customer" class="t01_nasabah_Customer">
<span<?php echo $t01_nasabah->Customer->ViewAttributes() ?>>
<?php echo $t01_nasabah->Customer->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_nasabah->Pekerjaan->Visible) { // Pekerjaan ?>
		<td<?php echo $t01_nasabah->Pekerjaan->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_delete->RowCnt ?>_t01_nasabah_Pekerjaan" class="t01_nasabah_Pekerjaan">
<span<?php echo $t01_nasabah->Pekerjaan->ViewAttributes() ?>>
<?php echo $t01_nasabah->Pekerjaan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_nasabah->NoTelpHp->Visible) { // NoTelpHp ?>
		<td<?php echo $t01_nasabah->NoTelpHp->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_delete->RowCnt ?>_t01_nasabah_NoTelpHp" class="t01_nasabah_NoTelpHp">
<span<?php echo $t01_nasabah->NoTelpHp->ViewAttributes() ?>>
<?php echo $t01_nasabah->NoTelpHp->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_nasabah->TglKontrak->Visible) { // TglKontrak ?>
		<td<?php echo $t01_nasabah->TglKontrak->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_delete->RowCnt ?>_t01_nasabah_TglKontrak" class="t01_nasabah_TglKontrak">
<span<?php echo $t01_nasabah->TglKontrak->ViewAttributes() ?>>
<?php echo $t01_nasabah->TglKontrak->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_nasabah->MerkType->Visible) { // MerkType ?>
		<td<?php echo $t01_nasabah->MerkType->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_delete->RowCnt ?>_t01_nasabah_MerkType" class="t01_nasabah_MerkType">
<span<?php echo $t01_nasabah->MerkType->ViewAttributes() ?>>
<?php echo $t01_nasabah->MerkType->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_nasabah->NoRangka->Visible) { // NoRangka ?>
		<td<?php echo $t01_nasabah->NoRangka->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_delete->RowCnt ?>_t01_nasabah_NoRangka" class="t01_nasabah_NoRangka">
<span<?php echo $t01_nasabah->NoRangka->ViewAttributes() ?>>
<?php echo $t01_nasabah->NoRangka->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_nasabah->NoMesin->Visible) { // NoMesin ?>
		<td<?php echo $t01_nasabah->NoMesin->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_delete->RowCnt ?>_t01_nasabah_NoMesin" class="t01_nasabah_NoMesin">
<span<?php echo $t01_nasabah->NoMesin->ViewAttributes() ?>>
<?php echo $t01_nasabah->NoMesin->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_nasabah->Warna->Visible) { // Warna ?>
		<td<?php echo $t01_nasabah->Warna->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_delete->RowCnt ?>_t01_nasabah_Warna" class="t01_nasabah_Warna">
<span<?php echo $t01_nasabah->Warna->ViewAttributes() ?>>
<?php echo $t01_nasabah->Warna->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_nasabah->NoPol->Visible) { // NoPol ?>
		<td<?php echo $t01_nasabah->NoPol->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_delete->RowCnt ?>_t01_nasabah_NoPol" class="t01_nasabah_NoPol">
<span<?php echo $t01_nasabah->NoPol->ViewAttributes() ?>>
<?php echo $t01_nasabah->NoPol->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_nasabah->AtasNama->Visible) { // AtasNama ?>
		<td<?php echo $t01_nasabah->AtasNama->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_delete->RowCnt ?>_t01_nasabah_AtasNama" class="t01_nasabah_AtasNama">
<span<?php echo $t01_nasabah->AtasNama->ViewAttributes() ?>>
<?php echo $t01_nasabah->AtasNama->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_nasabah->Pinjaman->Visible) { // Pinjaman ?>
		<td<?php echo $t01_nasabah->Pinjaman->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_delete->RowCnt ?>_t01_nasabah_Pinjaman" class="t01_nasabah_Pinjaman">
<span<?php echo $t01_nasabah->Pinjaman->ViewAttributes() ?>>
<?php echo $t01_nasabah->Pinjaman->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_nasabah->Denda->Visible) { // Denda ?>
		<td<?php echo $t01_nasabah->Denda->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_delete->RowCnt ?>_t01_nasabah_Denda" class="t01_nasabah_Denda">
<span<?php echo $t01_nasabah->Denda->ViewAttributes() ?>>
<?php echo $t01_nasabah->Denda->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_nasabah->DispensasiDenda->Visible) { // DispensasiDenda ?>
		<td<?php echo $t01_nasabah->DispensasiDenda->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_delete->RowCnt ?>_t01_nasabah_DispensasiDenda" class="t01_nasabah_DispensasiDenda">
<span<?php echo $t01_nasabah->DispensasiDenda->ViewAttributes() ?>>
<?php echo $t01_nasabah->DispensasiDenda->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_nasabah->LamaAngsuran->Visible) { // LamaAngsuran ?>
		<td<?php echo $t01_nasabah->LamaAngsuran->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_delete->RowCnt ?>_t01_nasabah_LamaAngsuran" class="t01_nasabah_LamaAngsuran">
<span<?php echo $t01_nasabah->LamaAngsuran->ViewAttributes() ?>>
<?php echo $t01_nasabah->LamaAngsuran->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_nasabah->JumlahAngsuran->Visible) { // JumlahAngsuran ?>
		<td<?php echo $t01_nasabah->JumlahAngsuran->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_delete->RowCnt ?>_t01_nasabah_JumlahAngsuran" class="t01_nasabah_JumlahAngsuran">
<span<?php echo $t01_nasabah->JumlahAngsuran->ViewAttributes() ?>>
<?php echo $t01_nasabah->JumlahAngsuran->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$t01_nasabah_delete->Recordset->MoveNext();
}
$t01_nasabah_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t01_nasabah_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ft01_nasabahdelete.Init();
</script>
<?php
$t01_nasabah_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t01_nasabah_delete->Page_Terminate();
?>