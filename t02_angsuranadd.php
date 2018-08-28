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

$t02_angsuran_add = NULL; // Initialize page object first

class ct02_angsuran_add extends ct02_angsuran {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{B3698D9B-8D4B-412E-A2E5-AFAD2FEE5A23}';

	// Table name
	var $TableName = 't02_angsuran';

	// Page object name
	var $PageObjName = 't02_angsuran_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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

		// Is modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanAdd()) {
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
		// Create form object

		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->nasabah_id->SetVisibility();
		$this->Tanggal->SetVisibility();
		$this->AngsuranPokok->SetVisibility();
		$this->AngsuranBunga->SetVisibility();
		$this->AngsuranTotal->SetVisibility();
		$this->SisaHutang->SetVisibility();
		$this->TanggalBayar->SetVisibility();
		$this->TotalDenda->SetVisibility();
		$this->Terlambat->SetVisibility();
		$this->Keterangan->SetVisibility();

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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "t02_angsuranview.php")
						$row["view"] = "1";
				} else { // List page should not be shown as modal => error
					$row["error"] = $this->getFailureMessage();
					$this->clearFailureMessage();
				}
				header("Content-Type: application/json; charset=utf-8");
				echo ew_ConvertToUtf8(ew_ArrayToJson(array($row)));
			} else {
				ew_SaveDebugMsg();
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewAddForm form-horizontal";

		// Set up master/detail parameters
		$this->SetupMasterParms();

		// Set up current action
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["id"] != "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->setKey("id", $this->id->CurrentValue); // Set up key
			} else {
				$this->setKey("id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Load old record / default values
		$loaded = $this->LoadOldRecord();

		// Load form values
		if (@$_POST["a_add"] <> "") {
			$this->LoadFormValues(); // Load form values
		}

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Blank record
				break;
			case "C": // Copy an existing record
				if (!$loaded) { // Record not loaded
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("t02_angsuranlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "t02_angsuranlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "t02_angsuranview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to View page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->id->CurrentValue = NULL;
		$this->id->OldValue = $this->id->CurrentValue;
		$this->nasabah_id->CurrentValue = NULL;
		$this->nasabah_id->OldValue = $this->nasabah_id->CurrentValue;
		$this->Tanggal->CurrentValue = NULL;
		$this->Tanggal->OldValue = $this->Tanggal->CurrentValue;
		$this->AngsuranPokok->CurrentValue = NULL;
		$this->AngsuranPokok->OldValue = $this->AngsuranPokok->CurrentValue;
		$this->AngsuranBunga->CurrentValue = NULL;
		$this->AngsuranBunga->OldValue = $this->AngsuranBunga->CurrentValue;
		$this->AngsuranTotal->CurrentValue = NULL;
		$this->AngsuranTotal->OldValue = $this->AngsuranTotal->CurrentValue;
		$this->SisaHutang->CurrentValue = NULL;
		$this->SisaHutang->OldValue = $this->SisaHutang->CurrentValue;
		$this->TanggalBayar->CurrentValue = NULL;
		$this->TanggalBayar->OldValue = $this->TanggalBayar->CurrentValue;
		$this->TotalDenda->CurrentValue = NULL;
		$this->TotalDenda->OldValue = $this->TotalDenda->CurrentValue;
		$this->Terlambat->CurrentValue = NULL;
		$this->Terlambat->OldValue = $this->Terlambat->CurrentValue;
		$this->Keterangan->CurrentValue = NULL;
		$this->Keterangan->OldValue = $this->Keterangan->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->nasabah_id->FldIsDetailKey) {
			$this->nasabah_id->setFormValue($objForm->GetValue("x_nasabah_id"));
		}
		if (!$this->Tanggal->FldIsDetailKey) {
			$this->Tanggal->setFormValue($objForm->GetValue("x_Tanggal"));
			$this->Tanggal->CurrentValue = ew_UnFormatDateTime($this->Tanggal->CurrentValue, 0);
		}
		if (!$this->AngsuranPokok->FldIsDetailKey) {
			$this->AngsuranPokok->setFormValue($objForm->GetValue("x_AngsuranPokok"));
		}
		if (!$this->AngsuranBunga->FldIsDetailKey) {
			$this->AngsuranBunga->setFormValue($objForm->GetValue("x_AngsuranBunga"));
		}
		if (!$this->AngsuranTotal->FldIsDetailKey) {
			$this->AngsuranTotal->setFormValue($objForm->GetValue("x_AngsuranTotal"));
		}
		if (!$this->SisaHutang->FldIsDetailKey) {
			$this->SisaHutang->setFormValue($objForm->GetValue("x_SisaHutang"));
		}
		if (!$this->TanggalBayar->FldIsDetailKey) {
			$this->TanggalBayar->setFormValue($objForm->GetValue("x_TanggalBayar"));
			$this->TanggalBayar->CurrentValue = ew_UnFormatDateTime($this->TanggalBayar->CurrentValue, 0);
		}
		if (!$this->TotalDenda->FldIsDetailKey) {
			$this->TotalDenda->setFormValue($objForm->GetValue("x_TotalDenda"));
		}
		if (!$this->Terlambat->FldIsDetailKey) {
			$this->Terlambat->setFormValue($objForm->GetValue("x_Terlambat"));
		}
		if (!$this->Keterangan->FldIsDetailKey) {
			$this->Keterangan->setFormValue($objForm->GetValue("x_Keterangan"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->nasabah_id->CurrentValue = $this->nasabah_id->FormValue;
		$this->Tanggal->CurrentValue = $this->Tanggal->FormValue;
		$this->Tanggal->CurrentValue = ew_UnFormatDateTime($this->Tanggal->CurrentValue, 0);
		$this->AngsuranPokok->CurrentValue = $this->AngsuranPokok->FormValue;
		$this->AngsuranBunga->CurrentValue = $this->AngsuranBunga->FormValue;
		$this->AngsuranTotal->CurrentValue = $this->AngsuranTotal->FormValue;
		$this->SisaHutang->CurrentValue = $this->SisaHutang->FormValue;
		$this->TanggalBayar->CurrentValue = $this->TanggalBayar->FormValue;
		$this->TanggalBayar->CurrentValue = ew_UnFormatDateTime($this->TanggalBayar->CurrentValue, 0);
		$this->TotalDenda->CurrentValue = $this->TotalDenda->FormValue;
		$this->Terlambat->CurrentValue = $this->Terlambat->FormValue;
		$this->Keterangan->CurrentValue = $this->Keterangan->FormValue;
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
		$this->LoadDefaultValues();
		$row = array();
		$row['id'] = $this->id->CurrentValue;
		$row['nasabah_id'] = $this->nasabah_id->CurrentValue;
		$row['Tanggal'] = $this->Tanggal->CurrentValue;
		$row['AngsuranPokok'] = $this->AngsuranPokok->CurrentValue;
		$row['AngsuranBunga'] = $this->AngsuranBunga->CurrentValue;
		$row['AngsuranTotal'] = $this->AngsuranTotal->CurrentValue;
		$row['SisaHutang'] = $this->SisaHutang->CurrentValue;
		$row['TanggalBayar'] = $this->TanggalBayar->CurrentValue;
		$row['TotalDenda'] = $this->TotalDenda->CurrentValue;
		$row['Terlambat'] = $this->Terlambat->CurrentValue;
		$row['Keterangan'] = $this->Keterangan->CurrentValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id")) <> "")
			$this->id->CurrentValue = $this->getKey("id"); // id
		else
			$bValidKey = FALSE;

		// Load old record
		$this->OldRecordset = NULL;
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
		}
		$this->LoadRowValues($this->OldRecordset); // Load row values
		return $bValidKey;
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

		// Keterangan
		$this->Keterangan->ViewValue = $this->Keterangan->CurrentValue;
		$this->Keterangan->ViewCustomAttributes = "";

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

			// Keterangan
			$this->Keterangan->LinkCustomAttributes = "";
			$this->Keterangan->HrefValue = "";
			$this->Keterangan->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// nasabah_id
			$this->nasabah_id->EditAttrs["class"] = "form-control";
			$this->nasabah_id->EditCustomAttributes = "";
			if ($this->nasabah_id->getSessionValue() <> "") {
				$this->nasabah_id->CurrentValue = $this->nasabah_id->getSessionValue();
			$this->nasabah_id->ViewValue = $this->nasabah_id->CurrentValue;
			$this->nasabah_id->ViewCustomAttributes = "";
			} else {
			$this->nasabah_id->EditValue = ew_HtmlEncode($this->nasabah_id->CurrentValue);
			$this->nasabah_id->PlaceHolder = ew_RemoveHtml($this->nasabah_id->FldCaption());
			}

			// Tanggal
			$this->Tanggal->EditAttrs["class"] = "form-control";
			$this->Tanggal->EditCustomAttributes = "";
			$this->Tanggal->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Tanggal->CurrentValue, 8));
			$this->Tanggal->PlaceHolder = ew_RemoveHtml($this->Tanggal->FldCaption());

			// AngsuranPokok
			$this->AngsuranPokok->EditAttrs["class"] = "form-control";
			$this->AngsuranPokok->EditCustomAttributes = "";
			$this->AngsuranPokok->EditValue = ew_HtmlEncode($this->AngsuranPokok->CurrentValue);
			$this->AngsuranPokok->PlaceHolder = ew_RemoveHtml($this->AngsuranPokok->FldCaption());
			if (strval($this->AngsuranPokok->EditValue) <> "" && is_numeric($this->AngsuranPokok->EditValue)) $this->AngsuranPokok->EditValue = ew_FormatNumber($this->AngsuranPokok->EditValue, -2, -1, -2, 0);

			// AngsuranBunga
			$this->AngsuranBunga->EditAttrs["class"] = "form-control";
			$this->AngsuranBunga->EditCustomAttributes = "";
			$this->AngsuranBunga->EditValue = ew_HtmlEncode($this->AngsuranBunga->CurrentValue);
			$this->AngsuranBunga->PlaceHolder = ew_RemoveHtml($this->AngsuranBunga->FldCaption());
			if (strval($this->AngsuranBunga->EditValue) <> "" && is_numeric($this->AngsuranBunga->EditValue)) $this->AngsuranBunga->EditValue = ew_FormatNumber($this->AngsuranBunga->EditValue, -2, -1, -2, 0);

			// AngsuranTotal
			$this->AngsuranTotal->EditAttrs["class"] = "form-control";
			$this->AngsuranTotal->EditCustomAttributes = "";
			$this->AngsuranTotal->EditValue = ew_HtmlEncode($this->AngsuranTotal->CurrentValue);
			$this->AngsuranTotal->PlaceHolder = ew_RemoveHtml($this->AngsuranTotal->FldCaption());
			if (strval($this->AngsuranTotal->EditValue) <> "" && is_numeric($this->AngsuranTotal->EditValue)) $this->AngsuranTotal->EditValue = ew_FormatNumber($this->AngsuranTotal->EditValue, -2, -1, -2, 0);

			// SisaHutang
			$this->SisaHutang->EditAttrs["class"] = "form-control";
			$this->SisaHutang->EditCustomAttributes = "";
			$this->SisaHutang->EditValue = ew_HtmlEncode($this->SisaHutang->CurrentValue);
			$this->SisaHutang->PlaceHolder = ew_RemoveHtml($this->SisaHutang->FldCaption());
			if (strval($this->SisaHutang->EditValue) <> "" && is_numeric($this->SisaHutang->EditValue)) $this->SisaHutang->EditValue = ew_FormatNumber($this->SisaHutang->EditValue, -2, -1, -2, 0);

			// TanggalBayar
			$this->TanggalBayar->EditAttrs["class"] = "form-control";
			$this->TanggalBayar->EditCustomAttributes = "";
			$this->TanggalBayar->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->TanggalBayar->CurrentValue, 8));
			$this->TanggalBayar->PlaceHolder = ew_RemoveHtml($this->TanggalBayar->FldCaption());

			// TotalDenda
			$this->TotalDenda->EditAttrs["class"] = "form-control";
			$this->TotalDenda->EditCustomAttributes = "";
			$this->TotalDenda->EditValue = ew_HtmlEncode($this->TotalDenda->CurrentValue);
			$this->TotalDenda->PlaceHolder = ew_RemoveHtml($this->TotalDenda->FldCaption());
			if (strval($this->TotalDenda->EditValue) <> "" && is_numeric($this->TotalDenda->EditValue)) $this->TotalDenda->EditValue = ew_FormatNumber($this->TotalDenda->EditValue, -2, -1, -2, 0);

			// Terlambat
			$this->Terlambat->EditAttrs["class"] = "form-control";
			$this->Terlambat->EditCustomAttributes = "";
			$this->Terlambat->EditValue = ew_HtmlEncode($this->Terlambat->CurrentValue);
			$this->Terlambat->PlaceHolder = ew_RemoveHtml($this->Terlambat->FldCaption());

			// Keterangan
			$this->Keterangan->EditAttrs["class"] = "form-control";
			$this->Keterangan->EditCustomAttributes = "";
			$this->Keterangan->EditValue = ew_HtmlEncode($this->Keterangan->CurrentValue);
			$this->Keterangan->PlaceHolder = ew_RemoveHtml($this->Keterangan->FldCaption());

			// Add refer script
			// nasabah_id

			$this->nasabah_id->LinkCustomAttributes = "";
			$this->nasabah_id->HrefValue = "";

			// Tanggal
			$this->Tanggal->LinkCustomAttributes = "";
			$this->Tanggal->HrefValue = "";

			// AngsuranPokok
			$this->AngsuranPokok->LinkCustomAttributes = "";
			$this->AngsuranPokok->HrefValue = "";

			// AngsuranBunga
			$this->AngsuranBunga->LinkCustomAttributes = "";
			$this->AngsuranBunga->HrefValue = "";

			// AngsuranTotal
			$this->AngsuranTotal->LinkCustomAttributes = "";
			$this->AngsuranTotal->HrefValue = "";

			// SisaHutang
			$this->SisaHutang->LinkCustomAttributes = "";
			$this->SisaHutang->HrefValue = "";

			// TanggalBayar
			$this->TanggalBayar->LinkCustomAttributes = "";
			$this->TanggalBayar->HrefValue = "";

			// TotalDenda
			$this->TotalDenda->LinkCustomAttributes = "";
			$this->TotalDenda->HrefValue = "";

			// Terlambat
			$this->Terlambat->LinkCustomAttributes = "";
			$this->Terlambat->HrefValue = "";

			// Keterangan
			$this->Keterangan->LinkCustomAttributes = "";
			$this->Keterangan->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD || $this->RowType == EW_ROWTYPE_EDIT || $this->RowType == EW_ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->SetupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->nasabah_id->FldIsDetailKey && !is_null($this->nasabah_id->FormValue) && $this->nasabah_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nasabah_id->FldCaption(), $this->nasabah_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->nasabah_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->nasabah_id->FldErrMsg());
		}
		if (!$this->Tanggal->FldIsDetailKey && !is_null($this->Tanggal->FormValue) && $this->Tanggal->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Tanggal->FldCaption(), $this->Tanggal->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->Tanggal->FormValue)) {
			ew_AddMessage($gsFormError, $this->Tanggal->FldErrMsg());
		}
		if (!$this->AngsuranPokok->FldIsDetailKey && !is_null($this->AngsuranPokok->FormValue) && $this->AngsuranPokok->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->AngsuranPokok->FldCaption(), $this->AngsuranPokok->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->AngsuranPokok->FormValue)) {
			ew_AddMessage($gsFormError, $this->AngsuranPokok->FldErrMsg());
		}
		if (!$this->AngsuranBunga->FldIsDetailKey && !is_null($this->AngsuranBunga->FormValue) && $this->AngsuranBunga->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->AngsuranBunga->FldCaption(), $this->AngsuranBunga->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->AngsuranBunga->FormValue)) {
			ew_AddMessage($gsFormError, $this->AngsuranBunga->FldErrMsg());
		}
		if (!$this->AngsuranTotal->FldIsDetailKey && !is_null($this->AngsuranTotal->FormValue) && $this->AngsuranTotal->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->AngsuranTotal->FldCaption(), $this->AngsuranTotal->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->AngsuranTotal->FormValue)) {
			ew_AddMessage($gsFormError, $this->AngsuranTotal->FldErrMsg());
		}
		if (!$this->SisaHutang->FldIsDetailKey && !is_null($this->SisaHutang->FormValue) && $this->SisaHutang->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->SisaHutang->FldCaption(), $this->SisaHutang->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->SisaHutang->FormValue)) {
			ew_AddMessage($gsFormError, $this->SisaHutang->FldErrMsg());
		}
		if (!$this->TanggalBayar->FldIsDetailKey && !is_null($this->TanggalBayar->FormValue) && $this->TanggalBayar->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->TanggalBayar->FldCaption(), $this->TanggalBayar->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->TanggalBayar->FormValue)) {
			ew_AddMessage($gsFormError, $this->TanggalBayar->FldErrMsg());
		}
		if (!ew_CheckNumber($this->TotalDenda->FormValue)) {
			ew_AddMessage($gsFormError, $this->TotalDenda->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Terlambat->FormValue)) {
			ew_AddMessage($gsFormError, $this->Terlambat->FldErrMsg());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// nasabah_id
		$this->nasabah_id->SetDbValueDef($rsnew, $this->nasabah_id->CurrentValue, 0, FALSE);

		// Tanggal
		$this->Tanggal->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Tanggal->CurrentValue, 0), ew_CurrentDate(), FALSE);

		// AngsuranPokok
		$this->AngsuranPokok->SetDbValueDef($rsnew, $this->AngsuranPokok->CurrentValue, 0, FALSE);

		// AngsuranBunga
		$this->AngsuranBunga->SetDbValueDef($rsnew, $this->AngsuranBunga->CurrentValue, 0, FALSE);

		// AngsuranTotal
		$this->AngsuranTotal->SetDbValueDef($rsnew, $this->AngsuranTotal->CurrentValue, 0, FALSE);

		// SisaHutang
		$this->SisaHutang->SetDbValueDef($rsnew, $this->SisaHutang->CurrentValue, 0, FALSE);

		// TanggalBayar
		$this->TanggalBayar->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->TanggalBayar->CurrentValue, 0), ew_CurrentDate(), FALSE);

		// TotalDenda
		$this->TotalDenda->SetDbValueDef($rsnew, $this->TotalDenda->CurrentValue, NULL, FALSE);

		// Terlambat
		$this->Terlambat->SetDbValueDef($rsnew, $this->Terlambat->CurrentValue, NULL, FALSE);

		// Keterangan
		$this->Keterangan->SetDbValueDef($rsnew, $this->Keterangan->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
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
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t02_angsuran_add)) $t02_angsuran_add = new ct02_angsuran_add();

// Page init
$t02_angsuran_add->Page_Init();

// Page main
$t02_angsuran_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t02_angsuran_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ft02_angsuranadd = new ew_Form("ft02_angsuranadd", "add");

// Validate form
ft02_angsuranadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_nasabah_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t02_angsuran->nasabah_id->FldCaption(), $t02_angsuran->nasabah_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nasabah_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t02_angsuran->nasabah_id->FldErrMsg()) ?>");
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
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
ft02_angsuranadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft02_angsuranadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t02_angsuran_add->ShowPageHeader(); ?>
<?php
$t02_angsuran_add->ShowMessage();
?>
<form name="ft02_angsuranadd" id="ft02_angsuranadd" class="<?php echo $t02_angsuran_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t02_angsuran_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t02_angsuran_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t02_angsuran">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($t02_angsuran_add->IsModal) ?>">
<?php if ($t02_angsuran->getCurrentMasterTable() == "t01_nasabah") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="t01_nasabah">
<input type="hidden" name="fk_id" value="<?php echo $t02_angsuran->nasabah_id->getSessionValue() ?>">
<?php } ?>
<div class="ewAddDiv"><!-- page* -->
<?php if ($t02_angsuran->nasabah_id->Visible) { // nasabah_id ?>
	<div id="r_nasabah_id" class="form-group">
		<label id="elh_t02_angsuran_nasabah_id" for="x_nasabah_id" class="<?php echo $t02_angsuran_add->LeftColumnClass ?>"><?php echo $t02_angsuran->nasabah_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t02_angsuran_add->RightColumnClass ?>"><div<?php echo $t02_angsuran->nasabah_id->CellAttributes() ?>>
<?php if ($t02_angsuran->nasabah_id->getSessionValue() <> "") { ?>
<span id="el_t02_angsuran_nasabah_id">
<span<?php echo $t02_angsuran->nasabah_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_angsuran->nasabah_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_nasabah_id" name="x_nasabah_id" value="<?php echo ew_HtmlEncode($t02_angsuran->nasabah_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_t02_angsuran_nasabah_id">
<input type="text" data-table="t02_angsuran" data-field="x_nasabah_id" name="x_nasabah_id" id="x_nasabah_id" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->nasabah_id->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->nasabah_id->EditValue ?>"<?php echo $t02_angsuran->nasabah_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $t02_angsuran->nasabah_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t02_angsuran->Tanggal->Visible) { // Tanggal ?>
	<div id="r_Tanggal" class="form-group">
		<label id="elh_t02_angsuran_Tanggal" for="x_Tanggal" class="<?php echo $t02_angsuran_add->LeftColumnClass ?>"><?php echo $t02_angsuran->Tanggal->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t02_angsuran_add->RightColumnClass ?>"><div<?php echo $t02_angsuran->Tanggal->CellAttributes() ?>>
<span id="el_t02_angsuran_Tanggal">
<input type="text" data-table="t02_angsuran" data-field="x_Tanggal" name="x_Tanggal" id="x_Tanggal" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->Tanggal->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->Tanggal->EditValue ?>"<?php echo $t02_angsuran->Tanggal->EditAttributes() ?>>
</span>
<?php echo $t02_angsuran->Tanggal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t02_angsuran->AngsuranPokok->Visible) { // AngsuranPokok ?>
	<div id="r_AngsuranPokok" class="form-group">
		<label id="elh_t02_angsuran_AngsuranPokok" for="x_AngsuranPokok" class="<?php echo $t02_angsuran_add->LeftColumnClass ?>"><?php echo $t02_angsuran->AngsuranPokok->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t02_angsuran_add->RightColumnClass ?>"><div<?php echo $t02_angsuran->AngsuranPokok->CellAttributes() ?>>
<span id="el_t02_angsuran_AngsuranPokok">
<input type="text" data-table="t02_angsuran" data-field="x_AngsuranPokok" name="x_AngsuranPokok" id="x_AngsuranPokok" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranPokok->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->AngsuranPokok->EditValue ?>"<?php echo $t02_angsuran->AngsuranPokok->EditAttributes() ?>>
</span>
<?php echo $t02_angsuran->AngsuranPokok->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t02_angsuran->AngsuranBunga->Visible) { // AngsuranBunga ?>
	<div id="r_AngsuranBunga" class="form-group">
		<label id="elh_t02_angsuran_AngsuranBunga" for="x_AngsuranBunga" class="<?php echo $t02_angsuran_add->LeftColumnClass ?>"><?php echo $t02_angsuran->AngsuranBunga->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t02_angsuran_add->RightColumnClass ?>"><div<?php echo $t02_angsuran->AngsuranBunga->CellAttributes() ?>>
<span id="el_t02_angsuran_AngsuranBunga">
<input type="text" data-table="t02_angsuran" data-field="x_AngsuranBunga" name="x_AngsuranBunga" id="x_AngsuranBunga" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranBunga->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->AngsuranBunga->EditValue ?>"<?php echo $t02_angsuran->AngsuranBunga->EditAttributes() ?>>
</span>
<?php echo $t02_angsuran->AngsuranBunga->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t02_angsuran->AngsuranTotal->Visible) { // AngsuranTotal ?>
	<div id="r_AngsuranTotal" class="form-group">
		<label id="elh_t02_angsuran_AngsuranTotal" for="x_AngsuranTotal" class="<?php echo $t02_angsuran_add->LeftColumnClass ?>"><?php echo $t02_angsuran->AngsuranTotal->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t02_angsuran_add->RightColumnClass ?>"><div<?php echo $t02_angsuran->AngsuranTotal->CellAttributes() ?>>
<span id="el_t02_angsuran_AngsuranTotal">
<input type="text" data-table="t02_angsuran" data-field="x_AngsuranTotal" name="x_AngsuranTotal" id="x_AngsuranTotal" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranTotal->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->AngsuranTotal->EditValue ?>"<?php echo $t02_angsuran->AngsuranTotal->EditAttributes() ?>>
</span>
<?php echo $t02_angsuran->AngsuranTotal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t02_angsuran->SisaHutang->Visible) { // SisaHutang ?>
	<div id="r_SisaHutang" class="form-group">
		<label id="elh_t02_angsuran_SisaHutang" for="x_SisaHutang" class="<?php echo $t02_angsuran_add->LeftColumnClass ?>"><?php echo $t02_angsuran->SisaHutang->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t02_angsuran_add->RightColumnClass ?>"><div<?php echo $t02_angsuran->SisaHutang->CellAttributes() ?>>
<span id="el_t02_angsuran_SisaHutang">
<input type="text" data-table="t02_angsuran" data-field="x_SisaHutang" name="x_SisaHutang" id="x_SisaHutang" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->SisaHutang->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->SisaHutang->EditValue ?>"<?php echo $t02_angsuran->SisaHutang->EditAttributes() ?>>
</span>
<?php echo $t02_angsuran->SisaHutang->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t02_angsuran->TanggalBayar->Visible) { // TanggalBayar ?>
	<div id="r_TanggalBayar" class="form-group">
		<label id="elh_t02_angsuran_TanggalBayar" for="x_TanggalBayar" class="<?php echo $t02_angsuran_add->LeftColumnClass ?>"><?php echo $t02_angsuran->TanggalBayar->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t02_angsuran_add->RightColumnClass ?>"><div<?php echo $t02_angsuran->TanggalBayar->CellAttributes() ?>>
<span id="el_t02_angsuran_TanggalBayar">
<input type="text" data-table="t02_angsuran" data-field="x_TanggalBayar" name="x_TanggalBayar" id="x_TanggalBayar" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->TanggalBayar->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->TanggalBayar->EditValue ?>"<?php echo $t02_angsuran->TanggalBayar->EditAttributes() ?>>
</span>
<?php echo $t02_angsuran->TanggalBayar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t02_angsuran->TotalDenda->Visible) { // TotalDenda ?>
	<div id="r_TotalDenda" class="form-group">
		<label id="elh_t02_angsuran_TotalDenda" for="x_TotalDenda" class="<?php echo $t02_angsuran_add->LeftColumnClass ?>"><?php echo $t02_angsuran->TotalDenda->FldCaption() ?></label>
		<div class="<?php echo $t02_angsuran_add->RightColumnClass ?>"><div<?php echo $t02_angsuran->TotalDenda->CellAttributes() ?>>
<span id="el_t02_angsuran_TotalDenda">
<input type="text" data-table="t02_angsuran" data-field="x_TotalDenda" name="x_TotalDenda" id="x_TotalDenda" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->TotalDenda->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->TotalDenda->EditValue ?>"<?php echo $t02_angsuran->TotalDenda->EditAttributes() ?>>
</span>
<?php echo $t02_angsuran->TotalDenda->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t02_angsuran->Terlambat->Visible) { // Terlambat ?>
	<div id="r_Terlambat" class="form-group">
		<label id="elh_t02_angsuran_Terlambat" for="x_Terlambat" class="<?php echo $t02_angsuran_add->LeftColumnClass ?>"><?php echo $t02_angsuran->Terlambat->FldCaption() ?></label>
		<div class="<?php echo $t02_angsuran_add->RightColumnClass ?>"><div<?php echo $t02_angsuran->Terlambat->CellAttributes() ?>>
<span id="el_t02_angsuran_Terlambat">
<input type="text" data-table="t02_angsuran" data-field="x_Terlambat" name="x_Terlambat" id="x_Terlambat" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->Terlambat->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->Terlambat->EditValue ?>"<?php echo $t02_angsuran->Terlambat->EditAttributes() ?>>
</span>
<?php echo $t02_angsuran->Terlambat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t02_angsuran->Keterangan->Visible) { // Keterangan ?>
	<div id="r_Keterangan" class="form-group">
		<label id="elh_t02_angsuran_Keterangan" for="x_Keterangan" class="<?php echo $t02_angsuran_add->LeftColumnClass ?>"><?php echo $t02_angsuran->Keterangan->FldCaption() ?></label>
		<div class="<?php echo $t02_angsuran_add->RightColumnClass ?>"><div<?php echo $t02_angsuran->Keterangan->CellAttributes() ?>>
<span id="el_t02_angsuran_Keterangan">
<textarea data-table="t02_angsuran" data-field="x_Keterangan" name="x_Keterangan" id="x_Keterangan" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->Keterangan->getPlaceHolder()) ?>"<?php echo $t02_angsuran->Keterangan->EditAttributes() ?>><?php echo $t02_angsuran->Keterangan->EditValue ?></textarea>
</span>
<?php echo $t02_angsuran->Keterangan->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$t02_angsuran_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $t02_angsuran_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t02_angsuran_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
ft02_angsuranadd.Init();
</script>
<?php
$t02_angsuran_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t02_angsuran_add->Page_Terminate();
?>
