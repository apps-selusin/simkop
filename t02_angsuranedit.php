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

$t02_angsuran_edit = NULL; // Initialize page object first

class ct02_angsuran_edit extends ct02_angsuran {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{B3698D9B-8D4B-412E-A2E5-AFAD2FEE5A23}';

	// Table name
	var $TableName = 't02_angsuran';

	// Page object name
	var $PageObjName = 't02_angsuran_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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
		if (!$Security->CanEdit()) {
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
		$this->id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->id->Visible = FALSE;
		$this->NoKontrak->SetVisibility();
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
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gbSkipHeaderFooter;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewEditForm form-horizontal";
		$sReturnUrl = "";
		$loaded = FALSE;
		$postBack = FALSE;

		// Set up current action and primary key
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			if ($this->CurrentAction <> "I") // Not reload record, handle as postback
				$postBack = TRUE;

			// Load key from Form
			if ($objForm->HasValue("x_id")) {
				$this->id->setFormValue($objForm->GetValue("x_id"));
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (isset($_GET["id"])) {
				$this->id->setQueryStringValue($_GET["id"]);
				$loadByQuery = TRUE;
			} else {
				$this->id->CurrentValue = NULL;
			}
		}

		// Set up master detail parameters
		$this->SetupMasterParms();

		// Load current record
		$loaded = $this->LoadRow();

		// Process form if post back
		if ($postBack) {
			$this->LoadFormValues(); // Get form values
		}

		// Validate form if post back
		if ($postBack) {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$loaded) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("t02_angsuranlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "t02_angsuranlist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetupStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
		if (!$this->NoKontrak->FldIsDetailKey) {
			$this->NoKontrak->setFormValue($objForm->GetValue("x_NoKontrak"));
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
		$this->id->CurrentValue = $this->id->FormValue;
		$this->NoKontrak->CurrentValue = $this->NoKontrak->FormValue;
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
		$this->NoKontrak->setDbValue($row['NoKontrak']);
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
		$row['NoKontrak'] = NULL;
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
		$this->NoKontrak->DbValue = $row['NoKontrak'];
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
		// NoKontrak
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

		// NoKontrak
		$this->NoKontrak->ViewValue = $this->NoKontrak->CurrentValue;
		$this->NoKontrak->ViewCustomAttributes = "";

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

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// NoKontrak
			$this->NoKontrak->LinkCustomAttributes = "";
			$this->NoKontrak->HrefValue = "";
			$this->NoKontrak->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// NoKontrak
			$this->NoKontrak->EditAttrs["class"] = "form-control";
			$this->NoKontrak->EditCustomAttributes = "";
			if ($this->NoKontrak->getSessionValue() <> "") {
				$this->NoKontrak->CurrentValue = $this->NoKontrak->getSessionValue();
			$this->NoKontrak->ViewValue = $this->NoKontrak->CurrentValue;
			$this->NoKontrak->ViewCustomAttributes = "";
			} else {
			$this->NoKontrak->EditValue = ew_HtmlEncode($this->NoKontrak->CurrentValue);
			$this->NoKontrak->PlaceHolder = ew_RemoveHtml($this->NoKontrak->FldCaption());
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

			// Edit refer script
			// id

			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";

			// NoKontrak
			$this->NoKontrak->LinkCustomAttributes = "";
			$this->NoKontrak->HrefValue = "";

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
		if (!$this->NoKontrak->FldIsDetailKey && !is_null($this->NoKontrak->FormValue) && $this->NoKontrak->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->NoKontrak->FldCaption(), $this->NoKontrak->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->NoKontrak->FormValue)) {
			ew_AddMessage($gsFormError, $this->NoKontrak->FldErrMsg());
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

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// NoKontrak
			$this->NoKontrak->SetDbValueDef($rsnew, $this->NoKontrak->CurrentValue, "", $this->NoKontrak->ReadOnly);

			// Tanggal
			$this->Tanggal->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Tanggal->CurrentValue, 0), ew_CurrentDate(), $this->Tanggal->ReadOnly);

			// AngsuranPokok
			$this->AngsuranPokok->SetDbValueDef($rsnew, $this->AngsuranPokok->CurrentValue, 0, $this->AngsuranPokok->ReadOnly);

			// AngsuranBunga
			$this->AngsuranBunga->SetDbValueDef($rsnew, $this->AngsuranBunga->CurrentValue, 0, $this->AngsuranBunga->ReadOnly);

			// AngsuranTotal
			$this->AngsuranTotal->SetDbValueDef($rsnew, $this->AngsuranTotal->CurrentValue, 0, $this->AngsuranTotal->ReadOnly);

			// SisaHutang
			$this->SisaHutang->SetDbValueDef($rsnew, $this->SisaHutang->CurrentValue, 0, $this->SisaHutang->ReadOnly);

			// TanggalBayar
			$this->TanggalBayar->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->TanggalBayar->CurrentValue, 0), ew_CurrentDate(), $this->TanggalBayar->ReadOnly);

			// TotalDenda
			$this->TotalDenda->SetDbValueDef($rsnew, $this->TotalDenda->CurrentValue, NULL, $this->TotalDenda->ReadOnly);

			// Terlambat
			$this->Terlambat->SetDbValueDef($rsnew, $this->Terlambat->CurrentValue, NULL, $this->Terlambat->ReadOnly);

			// Keterangan
			$this->Keterangan->SetDbValueDef($rsnew, $this->Keterangan->CurrentValue, NULL, $this->Keterangan->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
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
					$this->NoKontrak->setQueryStringValue($GLOBALS["t01_nasabah"]->id->QueryStringValue);
					$this->NoKontrak->setSessionValue($this->NoKontrak->QueryStringValue);
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
					$this->NoKontrak->setFormValue($GLOBALS["t01_nasabah"]->id->FormValue);
					$this->NoKontrak->setSessionValue($this->NoKontrak->FormValue);
					if (!is_numeric($GLOBALS["t01_nasabah"]->id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);
			$this->setSessionWhere($this->GetDetailFilter());

			// Reset start record counter (new master key)
			if (!$this->IsAddOrEdit()) {
				$this->StartRec = 1;
				$this->setStartRecordNumber($this->StartRec);
			}

			// Clear previous master key from Session
			if ($sMasterTblVar <> "t01_nasabah") {
				if ($this->NoKontrak->CurrentValue == "") $this->NoKontrak->setSessionValue("");
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
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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
if (!isset($t02_angsuran_edit)) $t02_angsuran_edit = new ct02_angsuran_edit();

// Page init
$t02_angsuran_edit->Page_Init();

// Page main
$t02_angsuran_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t02_angsuran_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = ft02_angsuranedit = new ew_Form("ft02_angsuranedit", "edit");

// Validate form
ft02_angsuranedit.Validate = function() {
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
ft02_angsuranedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft02_angsuranedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t02_angsuran_edit->ShowPageHeader(); ?>
<?php
$t02_angsuran_edit->ShowMessage();
?>
<form name="ft02_angsuranedit" id="ft02_angsuranedit" class="<?php echo $t02_angsuran_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t02_angsuran_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t02_angsuran_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t02_angsuran">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($t02_angsuran_edit->IsModal) ?>">
<?php if ($t02_angsuran->getCurrentMasterTable() == "t01_nasabah") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="t01_nasabah">
<input type="hidden" name="fk_id" value="<?php echo $t02_angsuran->NoKontrak->getSessionValue() ?>">
<?php } ?>
<div class="ewEditDiv"><!-- page* -->
<?php if ($t02_angsuran->id->Visible) { // id ?>
	<div id="r_id" class="form-group">
		<label id="elh_t02_angsuran_id" class="<?php echo $t02_angsuran_edit->LeftColumnClass ?>"><?php echo $t02_angsuran->id->FldCaption() ?></label>
		<div class="<?php echo $t02_angsuran_edit->RightColumnClass ?>"><div<?php echo $t02_angsuran->id->CellAttributes() ?>>
<span id="el_t02_angsuran_id">
<span<?php echo $t02_angsuran->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_angsuran->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="t02_angsuran" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($t02_angsuran->id->CurrentValue) ?>">
<?php echo $t02_angsuran->id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t02_angsuran->NoKontrak->Visible) { // NoKontrak ?>
	<div id="r_NoKontrak" class="form-group">
		<label id="elh_t02_angsuran_NoKontrak" for="x_NoKontrak" class="<?php echo $t02_angsuran_edit->LeftColumnClass ?>"><?php echo $t02_angsuran->NoKontrak->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t02_angsuran_edit->RightColumnClass ?>"><div<?php echo $t02_angsuran->NoKontrak->CellAttributes() ?>>
<?php if ($t02_angsuran->NoKontrak->getSessionValue() <> "") { ?>
<span id="el_t02_angsuran_NoKontrak">
<span<?php echo $t02_angsuran->NoKontrak->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_angsuran->NoKontrak->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_NoKontrak" name="x_NoKontrak" value="<?php echo ew_HtmlEncode($t02_angsuran->NoKontrak->CurrentValue) ?>">
<?php } else { ?>
<span id="el_t02_angsuran_NoKontrak">
<input type="text" data-table="t02_angsuran" data-field="x_NoKontrak" name="x_NoKontrak" id="x_NoKontrak" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->NoKontrak->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->NoKontrak->EditValue ?>"<?php echo $t02_angsuran->NoKontrak->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $t02_angsuran->NoKontrak->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t02_angsuran->Tanggal->Visible) { // Tanggal ?>
	<div id="r_Tanggal" class="form-group">
		<label id="elh_t02_angsuran_Tanggal" for="x_Tanggal" class="<?php echo $t02_angsuran_edit->LeftColumnClass ?>"><?php echo $t02_angsuran->Tanggal->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t02_angsuran_edit->RightColumnClass ?>"><div<?php echo $t02_angsuran->Tanggal->CellAttributes() ?>>
<span id="el_t02_angsuran_Tanggal">
<input type="text" data-table="t02_angsuran" data-field="x_Tanggal" name="x_Tanggal" id="x_Tanggal" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->Tanggal->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->Tanggal->EditValue ?>"<?php echo $t02_angsuran->Tanggal->EditAttributes() ?>>
</span>
<?php echo $t02_angsuran->Tanggal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t02_angsuran->AngsuranPokok->Visible) { // AngsuranPokok ?>
	<div id="r_AngsuranPokok" class="form-group">
		<label id="elh_t02_angsuran_AngsuranPokok" for="x_AngsuranPokok" class="<?php echo $t02_angsuran_edit->LeftColumnClass ?>"><?php echo $t02_angsuran->AngsuranPokok->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t02_angsuran_edit->RightColumnClass ?>"><div<?php echo $t02_angsuran->AngsuranPokok->CellAttributes() ?>>
<span id="el_t02_angsuran_AngsuranPokok">
<input type="text" data-table="t02_angsuran" data-field="x_AngsuranPokok" name="x_AngsuranPokok" id="x_AngsuranPokok" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranPokok->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->AngsuranPokok->EditValue ?>"<?php echo $t02_angsuran->AngsuranPokok->EditAttributes() ?>>
</span>
<?php echo $t02_angsuran->AngsuranPokok->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t02_angsuran->AngsuranBunga->Visible) { // AngsuranBunga ?>
	<div id="r_AngsuranBunga" class="form-group">
		<label id="elh_t02_angsuran_AngsuranBunga" for="x_AngsuranBunga" class="<?php echo $t02_angsuran_edit->LeftColumnClass ?>"><?php echo $t02_angsuran->AngsuranBunga->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t02_angsuran_edit->RightColumnClass ?>"><div<?php echo $t02_angsuran->AngsuranBunga->CellAttributes() ?>>
<span id="el_t02_angsuran_AngsuranBunga">
<input type="text" data-table="t02_angsuran" data-field="x_AngsuranBunga" name="x_AngsuranBunga" id="x_AngsuranBunga" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranBunga->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->AngsuranBunga->EditValue ?>"<?php echo $t02_angsuran->AngsuranBunga->EditAttributes() ?>>
</span>
<?php echo $t02_angsuran->AngsuranBunga->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t02_angsuran->AngsuranTotal->Visible) { // AngsuranTotal ?>
	<div id="r_AngsuranTotal" class="form-group">
		<label id="elh_t02_angsuran_AngsuranTotal" for="x_AngsuranTotal" class="<?php echo $t02_angsuran_edit->LeftColumnClass ?>"><?php echo $t02_angsuran->AngsuranTotal->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t02_angsuran_edit->RightColumnClass ?>"><div<?php echo $t02_angsuran->AngsuranTotal->CellAttributes() ?>>
<span id="el_t02_angsuran_AngsuranTotal">
<input type="text" data-table="t02_angsuran" data-field="x_AngsuranTotal" name="x_AngsuranTotal" id="x_AngsuranTotal" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->AngsuranTotal->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->AngsuranTotal->EditValue ?>"<?php echo $t02_angsuran->AngsuranTotal->EditAttributes() ?>>
</span>
<?php echo $t02_angsuran->AngsuranTotal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t02_angsuran->SisaHutang->Visible) { // SisaHutang ?>
	<div id="r_SisaHutang" class="form-group">
		<label id="elh_t02_angsuran_SisaHutang" for="x_SisaHutang" class="<?php echo $t02_angsuran_edit->LeftColumnClass ?>"><?php echo $t02_angsuran->SisaHutang->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t02_angsuran_edit->RightColumnClass ?>"><div<?php echo $t02_angsuran->SisaHutang->CellAttributes() ?>>
<span id="el_t02_angsuran_SisaHutang">
<input type="text" data-table="t02_angsuran" data-field="x_SisaHutang" name="x_SisaHutang" id="x_SisaHutang" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->SisaHutang->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->SisaHutang->EditValue ?>"<?php echo $t02_angsuran->SisaHutang->EditAttributes() ?>>
</span>
<?php echo $t02_angsuran->SisaHutang->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t02_angsuran->TanggalBayar->Visible) { // TanggalBayar ?>
	<div id="r_TanggalBayar" class="form-group">
		<label id="elh_t02_angsuran_TanggalBayar" for="x_TanggalBayar" class="<?php echo $t02_angsuran_edit->LeftColumnClass ?>"><?php echo $t02_angsuran->TanggalBayar->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t02_angsuran_edit->RightColumnClass ?>"><div<?php echo $t02_angsuran->TanggalBayar->CellAttributes() ?>>
<span id="el_t02_angsuran_TanggalBayar">
<input type="text" data-table="t02_angsuran" data-field="x_TanggalBayar" name="x_TanggalBayar" id="x_TanggalBayar" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->TanggalBayar->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->TanggalBayar->EditValue ?>"<?php echo $t02_angsuran->TanggalBayar->EditAttributes() ?>>
</span>
<?php echo $t02_angsuran->TanggalBayar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t02_angsuran->TotalDenda->Visible) { // TotalDenda ?>
	<div id="r_TotalDenda" class="form-group">
		<label id="elh_t02_angsuran_TotalDenda" for="x_TotalDenda" class="<?php echo $t02_angsuran_edit->LeftColumnClass ?>"><?php echo $t02_angsuran->TotalDenda->FldCaption() ?></label>
		<div class="<?php echo $t02_angsuran_edit->RightColumnClass ?>"><div<?php echo $t02_angsuran->TotalDenda->CellAttributes() ?>>
<span id="el_t02_angsuran_TotalDenda">
<input type="text" data-table="t02_angsuran" data-field="x_TotalDenda" name="x_TotalDenda" id="x_TotalDenda" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->TotalDenda->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->TotalDenda->EditValue ?>"<?php echo $t02_angsuran->TotalDenda->EditAttributes() ?>>
</span>
<?php echo $t02_angsuran->TotalDenda->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t02_angsuran->Terlambat->Visible) { // Terlambat ?>
	<div id="r_Terlambat" class="form-group">
		<label id="elh_t02_angsuran_Terlambat" for="x_Terlambat" class="<?php echo $t02_angsuran_edit->LeftColumnClass ?>"><?php echo $t02_angsuran->Terlambat->FldCaption() ?></label>
		<div class="<?php echo $t02_angsuran_edit->RightColumnClass ?>"><div<?php echo $t02_angsuran->Terlambat->CellAttributes() ?>>
<span id="el_t02_angsuran_Terlambat">
<input type="text" data-table="t02_angsuran" data-field="x_Terlambat" name="x_Terlambat" id="x_Terlambat" size="30" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->Terlambat->getPlaceHolder()) ?>" value="<?php echo $t02_angsuran->Terlambat->EditValue ?>"<?php echo $t02_angsuran->Terlambat->EditAttributes() ?>>
</span>
<?php echo $t02_angsuran->Terlambat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t02_angsuran->Keterangan->Visible) { // Keterangan ?>
	<div id="r_Keterangan" class="form-group">
		<label id="elh_t02_angsuran_Keterangan" for="x_Keterangan" class="<?php echo $t02_angsuran_edit->LeftColumnClass ?>"><?php echo $t02_angsuran->Keterangan->FldCaption() ?></label>
		<div class="<?php echo $t02_angsuran_edit->RightColumnClass ?>"><div<?php echo $t02_angsuran->Keterangan->CellAttributes() ?>>
<span id="el_t02_angsuran_Keterangan">
<textarea data-table="t02_angsuran" data-field="x_Keterangan" name="x_Keterangan" id="x_Keterangan" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($t02_angsuran->Keterangan->getPlaceHolder()) ?>"<?php echo $t02_angsuran->Keterangan->EditAttributes() ?>><?php echo $t02_angsuran->Keterangan->EditValue ?></textarea>
</span>
<?php echo $t02_angsuran->Keterangan->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$t02_angsuran_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $t02_angsuran_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t02_angsuran_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
ft02_angsuranedit.Init();
</script>
<?php
$t02_angsuran_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t02_angsuran_edit->Page_Terminate();
?>
