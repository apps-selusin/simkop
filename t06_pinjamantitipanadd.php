<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "t06_pinjamantitipaninfo.php" ?>
<?php include_once "t03_pinjamaninfo.php" ?>
<?php include_once "t96_employeesinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$t06_pinjamantitipan_add = NULL; // Initialize page object first

class ct06_pinjamantitipan_add extends ct06_pinjamantitipan {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{B3698D9B-8D4B-412E-A2E5-AFAD2FEE5A23}';

	// Table name
	var $TableName = 't06_pinjamantitipan';

	// Page object name
	var $PageObjName = 't06_pinjamantitipan_add';

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

		// Table object (t06_pinjamantitipan)
		if (!isset($GLOBALS["t06_pinjamantitipan"]) || get_class($GLOBALS["t06_pinjamantitipan"]) == "ct06_pinjamantitipan") {
			$GLOBALS["t06_pinjamantitipan"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t06_pinjamantitipan"];
		}

		// Table object (t03_pinjaman)
		if (!isset($GLOBALS['t03_pinjaman'])) $GLOBALS['t03_pinjaman'] = new ct03_pinjaman();

		// Table object (t96_employees)
		if (!isset($GLOBALS['t96_employees'])) $GLOBALS['t96_employees'] = new ct96_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't06_pinjamantitipan', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("t06_pinjamantitipanlist.php"));
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
		$this->pinjaman_id->SetVisibility();
		$this->Tanggal->SetVisibility();
		$this->Keterangan->SetVisibility();
		$this->Masuk->SetVisibility();
		$this->Keluar->SetVisibility();
		$this->Sisa->SetVisibility();

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
		global $EW_EXPORT, $t06_pinjamantitipan;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t06_pinjamantitipan);
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
					if ($pageName == "t06_pinjamantitipanview.php")
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
					$this->Page_Terminate("t06_pinjamantitipanlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "t06_pinjamantitipanlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "t06_pinjamantitipanview.php")
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
		$this->pinjaman_id->CurrentValue = NULL;
		$this->pinjaman_id->OldValue = $this->pinjaman_id->CurrentValue;
		$this->Tanggal->CurrentValue = NULL;
		$this->Tanggal->OldValue = $this->Tanggal->CurrentValue;
		$this->Keterangan->CurrentValue = NULL;
		$this->Keterangan->OldValue = $this->Keterangan->CurrentValue;
		$this->Masuk->CurrentValue = 0.00;
		$this->Keluar->CurrentValue = 0.00;
		$this->Sisa->CurrentValue = 0.00;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->pinjaman_id->FldIsDetailKey) {
			$this->pinjaman_id->setFormValue($objForm->GetValue("x_pinjaman_id"));
		}
		if (!$this->Tanggal->FldIsDetailKey) {
			$this->Tanggal->setFormValue($objForm->GetValue("x_Tanggal"));
			$this->Tanggal->CurrentValue = ew_UnFormatDateTime($this->Tanggal->CurrentValue, 7);
		}
		if (!$this->Keterangan->FldIsDetailKey) {
			$this->Keterangan->setFormValue($objForm->GetValue("x_Keterangan"));
		}
		if (!$this->Masuk->FldIsDetailKey) {
			$this->Masuk->setFormValue($objForm->GetValue("x_Masuk"));
		}
		if (!$this->Keluar->FldIsDetailKey) {
			$this->Keluar->setFormValue($objForm->GetValue("x_Keluar"));
		}
		if (!$this->Sisa->FldIsDetailKey) {
			$this->Sisa->setFormValue($objForm->GetValue("x_Sisa"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->pinjaman_id->CurrentValue = $this->pinjaman_id->FormValue;
		$this->Tanggal->CurrentValue = $this->Tanggal->FormValue;
		$this->Tanggal->CurrentValue = ew_UnFormatDateTime($this->Tanggal->CurrentValue, 7);
		$this->Keterangan->CurrentValue = $this->Keterangan->FormValue;
		$this->Masuk->CurrentValue = $this->Masuk->FormValue;
		$this->Keluar->CurrentValue = $this->Keluar->FormValue;
		$this->Sisa->CurrentValue = $this->Sisa->FormValue;
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
		$this->pinjaman_id->setDbValue($row['pinjaman_id']);
		$this->Tanggal->setDbValue($row['Tanggal']);
		$this->Keterangan->setDbValue($row['Keterangan']);
		$this->Masuk->setDbValue($row['Masuk']);
		$this->Keluar->setDbValue($row['Keluar']);
		$this->Sisa->setDbValue($row['Sisa']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['id'] = $this->id->CurrentValue;
		$row['pinjaman_id'] = $this->pinjaman_id->CurrentValue;
		$row['Tanggal'] = $this->Tanggal->CurrentValue;
		$row['Keterangan'] = $this->Keterangan->CurrentValue;
		$row['Masuk'] = $this->Masuk->CurrentValue;
		$row['Keluar'] = $this->Keluar->CurrentValue;
		$row['Sisa'] = $this->Sisa->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->pinjaman_id->DbValue = $row['pinjaman_id'];
		$this->Tanggal->DbValue = $row['Tanggal'];
		$this->Keterangan->DbValue = $row['Keterangan'];
		$this->Masuk->DbValue = $row['Masuk'];
		$this->Keluar->DbValue = $row['Keluar'];
		$this->Sisa->DbValue = $row['Sisa'];
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

		if ($this->Masuk->FormValue == $this->Masuk->CurrentValue && is_numeric(ew_StrToFloat($this->Masuk->CurrentValue)))
			$this->Masuk->CurrentValue = ew_StrToFloat($this->Masuk->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Keluar->FormValue == $this->Keluar->CurrentValue && is_numeric(ew_StrToFloat($this->Keluar->CurrentValue)))
			$this->Keluar->CurrentValue = ew_StrToFloat($this->Keluar->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Sisa->FormValue == $this->Sisa->CurrentValue && is_numeric(ew_StrToFloat($this->Sisa->CurrentValue)))
			$this->Sisa->CurrentValue = ew_StrToFloat($this->Sisa->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// pinjaman_id
		// Tanggal
		// Keterangan
		// Masuk
		// Keluar
		// Sisa

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// pinjaman_id
		$this->pinjaman_id->ViewValue = $this->pinjaman_id->CurrentValue;
		if (strval($this->pinjaman_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->pinjaman_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `NoKontrak` AS `DispFld`, `TglKontrak` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t03_pinjaman`";
		$sWhereWrk = "";
		$this->pinjaman_id->LookupFilters = array("df2" => "7");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pinjaman_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = ew_FormatDateTime($rswrk->fields('Disp2Fld'), 7);
				$this->pinjaman_id->ViewValue = $this->pinjaman_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pinjaman_id->ViewValue = $this->pinjaman_id->CurrentValue;
			}
		} else {
			$this->pinjaman_id->ViewValue = NULL;
		}
		$this->pinjaman_id->ViewCustomAttributes = "";

		// Tanggal
		$this->Tanggal->ViewValue = $this->Tanggal->CurrentValue;
		$this->Tanggal->ViewValue = ew_FormatDateTime($this->Tanggal->ViewValue, 7);
		$this->Tanggal->ViewCustomAttributes = "";

		// Keterangan
		$this->Keterangan->ViewValue = $this->Keterangan->CurrentValue;
		$this->Keterangan->ViewCustomAttributes = "";

		// Masuk
		$this->Masuk->ViewValue = $this->Masuk->CurrentValue;
		$this->Masuk->ViewValue = ew_FormatNumber($this->Masuk->ViewValue, 2, -2, -2, -2);
		$this->Masuk->CellCssStyle .= "text-align: right;";
		$this->Masuk->ViewCustomAttributes = "";

		// Keluar
		$this->Keluar->ViewValue = $this->Keluar->CurrentValue;
		$this->Keluar->ViewValue = ew_FormatNumber($this->Keluar->ViewValue, 2, -2, -2, -2);
		$this->Keluar->CellCssStyle .= "text-align: right;";
		$this->Keluar->ViewCustomAttributes = "";

		// Sisa
		$this->Sisa->ViewValue = $this->Sisa->CurrentValue;
		$this->Sisa->ViewValue = ew_FormatNumber($this->Sisa->ViewValue, 2, -2, -2, -2);
		$this->Sisa->CellCssStyle .= "text-align: right;";
		$this->Sisa->ViewCustomAttributes = "";

			// pinjaman_id
			$this->pinjaman_id->LinkCustomAttributes = "";
			$this->pinjaman_id->HrefValue = "";
			$this->pinjaman_id->TooltipValue = "";

			// Tanggal
			$this->Tanggal->LinkCustomAttributes = "";
			$this->Tanggal->HrefValue = "";
			$this->Tanggal->TooltipValue = "";

			// Keterangan
			$this->Keterangan->LinkCustomAttributes = "";
			$this->Keterangan->HrefValue = "";
			$this->Keterangan->TooltipValue = "";

			// Masuk
			$this->Masuk->LinkCustomAttributes = "";
			$this->Masuk->HrefValue = "";
			$this->Masuk->TooltipValue = "";

			// Keluar
			$this->Keluar->LinkCustomAttributes = "";
			$this->Keluar->HrefValue = "";
			$this->Keluar->TooltipValue = "";

			// Sisa
			$this->Sisa->LinkCustomAttributes = "";
			$this->Sisa->HrefValue = "";
			$this->Sisa->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// pinjaman_id
			$this->pinjaman_id->EditAttrs["class"] = "form-control";
			$this->pinjaman_id->EditCustomAttributes = "";
			if ($this->pinjaman_id->getSessionValue() <> "") {
				$this->pinjaman_id->CurrentValue = $this->pinjaman_id->getSessionValue();
			$this->pinjaman_id->ViewValue = $this->pinjaman_id->CurrentValue;
			if (strval($this->pinjaman_id->CurrentValue) <> "") {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->pinjaman_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `id`, `NoKontrak` AS `DispFld`, `TglKontrak` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t03_pinjaman`";
			$sWhereWrk = "";
			$this->pinjaman_id->LookupFilters = array("df2" => "7");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->pinjaman_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$arwrk[2] = ew_FormatDateTime($rswrk->fields('Disp2Fld'), 7);
					$this->pinjaman_id->ViewValue = $this->pinjaman_id->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->pinjaman_id->ViewValue = $this->pinjaman_id->CurrentValue;
				}
			} else {
				$this->pinjaman_id->ViewValue = NULL;
			}
			$this->pinjaman_id->ViewCustomAttributes = "";
			} else {
			$this->pinjaman_id->EditValue = ew_HtmlEncode($this->pinjaman_id->CurrentValue);
			if (strval($this->pinjaman_id->CurrentValue) <> "") {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->pinjaman_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `id`, `NoKontrak` AS `DispFld`, `TglKontrak` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t03_pinjaman`";
			$sWhereWrk = "";
			$this->pinjaman_id->LookupFilters = array("df2" => "7");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->pinjaman_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$arwrk[2] = ew_HtmlEncode(ew_FormatDateTime($rswrk->fields('Disp2Fld'), 7));
					$this->pinjaman_id->EditValue = $this->pinjaman_id->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->pinjaman_id->EditValue = ew_HtmlEncode($this->pinjaman_id->CurrentValue);
				}
			} else {
				$this->pinjaman_id->EditValue = NULL;
			}
			$this->pinjaman_id->PlaceHolder = ew_RemoveHtml($this->pinjaman_id->FldCaption());
			}

			// Tanggal
			$this->Tanggal->EditAttrs["class"] = "form-control";
			$this->Tanggal->EditCustomAttributes = "";
			$this->Tanggal->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Tanggal->CurrentValue, 7));
			$this->Tanggal->PlaceHolder = ew_RemoveHtml($this->Tanggal->FldCaption());

			// Keterangan
			$this->Keterangan->EditAttrs["class"] = "form-control";
			$this->Keterangan->EditCustomAttributes = "";
			$this->Keterangan->EditValue = ew_HtmlEncode($this->Keterangan->CurrentValue);
			$this->Keterangan->PlaceHolder = ew_RemoveHtml($this->Keterangan->FldCaption());

			// Masuk
			$this->Masuk->EditAttrs["class"] = "form-control";
			$this->Masuk->EditCustomAttributes = "";
			$this->Masuk->EditValue = ew_HtmlEncode($this->Masuk->CurrentValue);
			$this->Masuk->PlaceHolder = ew_RemoveHtml($this->Masuk->FldCaption());
			if (strval($this->Masuk->EditValue) <> "" && is_numeric($this->Masuk->EditValue)) $this->Masuk->EditValue = ew_FormatNumber($this->Masuk->EditValue, -2, -2, -2, -2);

			// Keluar
			$this->Keluar->EditAttrs["class"] = "form-control";
			$this->Keluar->EditCustomAttributes = "";
			$this->Keluar->EditValue = ew_HtmlEncode($this->Keluar->CurrentValue);
			$this->Keluar->PlaceHolder = ew_RemoveHtml($this->Keluar->FldCaption());
			if (strval($this->Keluar->EditValue) <> "" && is_numeric($this->Keluar->EditValue)) $this->Keluar->EditValue = ew_FormatNumber($this->Keluar->EditValue, -2, -2, -2, -2);

			// Sisa
			$this->Sisa->EditAttrs["class"] = "form-control";
			$this->Sisa->EditCustomAttributes = "";
			$this->Sisa->EditValue = ew_HtmlEncode($this->Sisa->CurrentValue);
			$this->Sisa->PlaceHolder = ew_RemoveHtml($this->Sisa->FldCaption());
			if (strval($this->Sisa->EditValue) <> "" && is_numeric($this->Sisa->EditValue)) $this->Sisa->EditValue = ew_FormatNumber($this->Sisa->EditValue, -2, -2, -2, -2);

			// Add refer script
			// pinjaman_id

			$this->pinjaman_id->LinkCustomAttributes = "";
			$this->pinjaman_id->HrefValue = "";

			// Tanggal
			$this->Tanggal->LinkCustomAttributes = "";
			$this->Tanggal->HrefValue = "";

			// Keterangan
			$this->Keterangan->LinkCustomAttributes = "";
			$this->Keterangan->HrefValue = "";

			// Masuk
			$this->Masuk->LinkCustomAttributes = "";
			$this->Masuk->HrefValue = "";

			// Keluar
			$this->Keluar->LinkCustomAttributes = "";
			$this->Keluar->HrefValue = "";

			// Sisa
			$this->Sisa->LinkCustomAttributes = "";
			$this->Sisa->HrefValue = "";
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
		if (!$this->pinjaman_id->FldIsDetailKey && !is_null($this->pinjaman_id->FormValue) && $this->pinjaman_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->pinjaman_id->FldCaption(), $this->pinjaman_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->pinjaman_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->pinjaman_id->FldErrMsg());
		}
		if (!$this->Tanggal->FldIsDetailKey && !is_null($this->Tanggal->FormValue) && $this->Tanggal->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Tanggal->FldCaption(), $this->Tanggal->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->Tanggal->FormValue)) {
			ew_AddMessage($gsFormError, $this->Tanggal->FldErrMsg());
		}
		if (!ew_CheckNumber($this->Masuk->FormValue)) {
			ew_AddMessage($gsFormError, $this->Masuk->FldErrMsg());
		}
		if (!ew_CheckNumber($this->Keluar->FormValue)) {
			ew_AddMessage($gsFormError, $this->Keluar->FldErrMsg());
		}
		if (!ew_CheckNumber($this->Sisa->FormValue)) {
			ew_AddMessage($gsFormError, $this->Sisa->FldErrMsg());
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

		// pinjaman_id
		$this->pinjaman_id->SetDbValueDef($rsnew, $this->pinjaman_id->CurrentValue, 0, FALSE);

		// Tanggal
		$this->Tanggal->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Tanggal->CurrentValue, 7), ew_CurrentDate(), FALSE);

		// Keterangan
		$this->Keterangan->SetDbValueDef($rsnew, $this->Keterangan->CurrentValue, NULL, FALSE);

		// Masuk
		$this->Masuk->SetDbValueDef($rsnew, $this->Masuk->CurrentValue, 0, strval($this->Masuk->CurrentValue) == "");

		// Keluar
		$this->Keluar->SetDbValueDef($rsnew, $this->Keluar->CurrentValue, 0, strval($this->Keluar->CurrentValue) == "");

		// Sisa
		$this->Sisa->SetDbValueDef($rsnew, $this->Sisa->CurrentValue, 0, strval($this->Sisa->CurrentValue) == "");

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
			if ($sMasterTblVar == "t03_pinjaman") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_id"] <> "") {
					$GLOBALS["t03_pinjaman"]->id->setQueryStringValue($_GET["fk_id"]);
					$this->pinjaman_id->setQueryStringValue($GLOBALS["t03_pinjaman"]->id->QueryStringValue);
					$this->pinjaman_id->setSessionValue($this->pinjaman_id->QueryStringValue);
					if (!is_numeric($GLOBALS["t03_pinjaman"]->id->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "t03_pinjaman") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_id"] <> "") {
					$GLOBALS["t03_pinjaman"]->id->setFormValue($_POST["fk_id"]);
					$this->pinjaman_id->setFormValue($GLOBALS["t03_pinjaman"]->id->FormValue);
					$this->pinjaman_id->setSessionValue($this->pinjaman_id->FormValue);
					if (!is_numeric($GLOBALS["t03_pinjaman"]->id->FormValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "t03_pinjaman") {
				if ($this->pinjaman_id->CurrentValue == "") $this->pinjaman_id->setSessionValue("");
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t06_pinjamantitipanlist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_pinjaman_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `NoKontrak` AS `DispFld`, `TglKontrak` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t03_pinjaman`";
			$sWhereWrk = "{filter}";
			$fld->LookupFilters = array("df2" => "7");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->pinjaman_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_pinjaman_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id`, `NoKontrak` AS `DispFld`, `TglKontrak` AS `Disp2Fld` FROM `t03_pinjaman`";
			$sWhereWrk = "`NoKontrak` LIKE '{query_value}%' OR CONCAT(COALESCE(`NoKontrak`, ''),'" . ew_ValueSeparator(1, $this->pinjaman_id) . "',COALESCE(" . ew_CastDateFieldForLike('`TglKontrak`', 7, "DB") . ",'')) LIKE '{query_value}%'";
			$fld->LookupFilters = array("df2" => "7");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->pinjaman_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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
if (!isset($t06_pinjamantitipan_add)) $t06_pinjamantitipan_add = new ct06_pinjamantitipan_add();

// Page init
$t06_pinjamantitipan_add->Page_Init();

// Page main
$t06_pinjamantitipan_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t06_pinjamantitipan_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ft06_pinjamantitipanadd = new ew_Form("ft06_pinjamantitipanadd", "add");

// Validate form
ft06_pinjamantitipanadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_pinjaman_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t06_pinjamantitipan->pinjaman_id->FldCaption(), $t06_pinjamantitipan->pinjaman_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pinjaman_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t06_pinjamantitipan->pinjaman_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Tanggal");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t06_pinjamantitipan->Tanggal->FldCaption(), $t06_pinjamantitipan->Tanggal->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Tanggal");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t06_pinjamantitipan->Tanggal->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Masuk");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t06_pinjamantitipan->Masuk->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Keluar");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t06_pinjamantitipan->Keluar->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Sisa");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t06_pinjamantitipan->Sisa->FldErrMsg()) ?>");

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
ft06_pinjamantitipanadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft06_pinjamantitipanadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ft06_pinjamantitipanadd.Lists["x_pinjaman_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_NoKontrak","x_TglKontrak","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t03_pinjaman"};
ft06_pinjamantitipanadd.Lists["x_pinjaman_id"].Data = "<?php echo $t06_pinjamantitipan_add->pinjaman_id->LookupFilterQuery(FALSE, "add") ?>";
ft06_pinjamantitipanadd.AutoSuggests["x_pinjaman_id"] = <?php echo json_encode(array("data" => "ajax=autosuggest&" . $t06_pinjamantitipan_add->pinjaman_id->LookupFilterQuery(TRUE, "add"))) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t06_pinjamantitipan_add->ShowPageHeader(); ?>
<?php
$t06_pinjamantitipan_add->ShowMessage();
?>
<form name="ft06_pinjamantitipanadd" id="ft06_pinjamantitipanadd" class="<?php echo $t06_pinjamantitipan_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t06_pinjamantitipan_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t06_pinjamantitipan_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t06_pinjamantitipan">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($t06_pinjamantitipan_add->IsModal) ?>">
<?php if ($t06_pinjamantitipan->getCurrentMasterTable() == "t03_pinjaman") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="t03_pinjaman">
<input type="hidden" name="fk_id" value="<?php echo $t06_pinjamantitipan->pinjaman_id->getSessionValue() ?>">
<?php } ?>
<div class="ewAddDiv"><!-- page* -->
<?php if ($t06_pinjamantitipan->pinjaman_id->Visible) { // pinjaman_id ?>
	<div id="r_pinjaman_id" class="form-group">
		<label id="elh_t06_pinjamantitipan_pinjaman_id" class="<?php echo $t06_pinjamantitipan_add->LeftColumnClass ?>"><?php echo $t06_pinjamantitipan->pinjaman_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t06_pinjamantitipan_add->RightColumnClass ?>"><div<?php echo $t06_pinjamantitipan->pinjaman_id->CellAttributes() ?>>
<?php if ($t06_pinjamantitipan->pinjaman_id->getSessionValue() <> "") { ?>
<span id="el_t06_pinjamantitipan_pinjaman_id">
<span<?php echo $t06_pinjamantitipan->pinjaman_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t06_pinjamantitipan->pinjaman_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_pinjaman_id" name="x_pinjaman_id" value="<?php echo ew_HtmlEncode($t06_pinjamantitipan->pinjaman_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_t06_pinjamantitipan_pinjaman_id">
<?php
$wrkonchange = trim(" " . @$t06_pinjamantitipan->pinjaman_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t06_pinjamantitipan->pinjaman_id->EditAttrs["onchange"] = "";
?>
<span id="as_x_pinjaman_id" style="white-space: nowrap; z-index: 8980">
	<input type="text" name="sv_x_pinjaman_id" id="sv_x_pinjaman_id" value="<?php echo $t06_pinjamantitipan->pinjaman_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t06_pinjamantitipan->pinjaman_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t06_pinjamantitipan->pinjaman_id->getPlaceHolder()) ?>"<?php echo $t06_pinjamantitipan->pinjaman_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t06_pinjamantitipan" data-field="x_pinjaman_id" data-value-separator="<?php echo $t06_pinjamantitipan->pinjaman_id->DisplayValueSeparatorAttribute() ?>" name="x_pinjaman_id" id="x_pinjaman_id" value="<?php echo ew_HtmlEncode($t06_pinjamantitipan->pinjaman_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
ft06_pinjamantitipanadd.CreateAutoSuggest({"id":"x_pinjaman_id","forceSelect":false});
</script>
</span>
<?php } ?>
<?php echo $t06_pinjamantitipan->pinjaman_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t06_pinjamantitipan->Tanggal->Visible) { // Tanggal ?>
	<div id="r_Tanggal" class="form-group">
		<label id="elh_t06_pinjamantitipan_Tanggal" for="x_Tanggal" class="<?php echo $t06_pinjamantitipan_add->LeftColumnClass ?>"><?php echo $t06_pinjamantitipan->Tanggal->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t06_pinjamantitipan_add->RightColumnClass ?>"><div<?php echo $t06_pinjamantitipan->Tanggal->CellAttributes() ?>>
<span id="el_t06_pinjamantitipan_Tanggal">
<input type="text" data-table="t06_pinjamantitipan" data-field="x_Tanggal" data-format="7" name="x_Tanggal" id="x_Tanggal" placeholder="<?php echo ew_HtmlEncode($t06_pinjamantitipan->Tanggal->getPlaceHolder()) ?>" value="<?php echo $t06_pinjamantitipan->Tanggal->EditValue ?>"<?php echo $t06_pinjamantitipan->Tanggal->EditAttributes() ?>>
<?php if (!$t06_pinjamantitipan->Tanggal->ReadOnly && !$t06_pinjamantitipan->Tanggal->Disabled && !isset($t06_pinjamantitipan->Tanggal->EditAttrs["readonly"]) && !isset($t06_pinjamantitipan->Tanggal->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateDateTimePicker("ft06_pinjamantitipanadd", "x_Tanggal", {"ignoreReadonly":true,"useCurrent":false,"format":7});
</script>
<?php } ?>
</span>
<?php echo $t06_pinjamantitipan->Tanggal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t06_pinjamantitipan->Keterangan->Visible) { // Keterangan ?>
	<div id="r_Keterangan" class="form-group">
		<label id="elh_t06_pinjamantitipan_Keterangan" for="x_Keterangan" class="<?php echo $t06_pinjamantitipan_add->LeftColumnClass ?>"><?php echo $t06_pinjamantitipan->Keterangan->FldCaption() ?></label>
		<div class="<?php echo $t06_pinjamantitipan_add->RightColumnClass ?>"><div<?php echo $t06_pinjamantitipan->Keterangan->CellAttributes() ?>>
<span id="el_t06_pinjamantitipan_Keterangan">
<textarea data-table="t06_pinjamantitipan" data-field="x_Keterangan" name="x_Keterangan" id="x_Keterangan" cols="15" rows="4" placeholder="<?php echo ew_HtmlEncode($t06_pinjamantitipan->Keterangan->getPlaceHolder()) ?>"<?php echo $t06_pinjamantitipan->Keterangan->EditAttributes() ?>><?php echo $t06_pinjamantitipan->Keterangan->EditValue ?></textarea>
</span>
<?php echo $t06_pinjamantitipan->Keterangan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t06_pinjamantitipan->Masuk->Visible) { // Masuk ?>
	<div id="r_Masuk" class="form-group">
		<label id="elh_t06_pinjamantitipan_Masuk" for="x_Masuk" class="<?php echo $t06_pinjamantitipan_add->LeftColumnClass ?>"><?php echo $t06_pinjamantitipan->Masuk->FldCaption() ?></label>
		<div class="<?php echo $t06_pinjamantitipan_add->RightColumnClass ?>"><div<?php echo $t06_pinjamantitipan->Masuk->CellAttributes() ?>>
<span id="el_t06_pinjamantitipan_Masuk">
<input type="text" data-table="t06_pinjamantitipan" data-field="x_Masuk" name="x_Masuk" id="x_Masuk" size="10" placeholder="<?php echo ew_HtmlEncode($t06_pinjamantitipan->Masuk->getPlaceHolder()) ?>" value="<?php echo $t06_pinjamantitipan->Masuk->EditValue ?>"<?php echo $t06_pinjamantitipan->Masuk->EditAttributes() ?>>
</span>
<?php echo $t06_pinjamantitipan->Masuk->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t06_pinjamantitipan->Keluar->Visible) { // Keluar ?>
	<div id="r_Keluar" class="form-group">
		<label id="elh_t06_pinjamantitipan_Keluar" for="x_Keluar" class="<?php echo $t06_pinjamantitipan_add->LeftColumnClass ?>"><?php echo $t06_pinjamantitipan->Keluar->FldCaption() ?></label>
		<div class="<?php echo $t06_pinjamantitipan_add->RightColumnClass ?>"><div<?php echo $t06_pinjamantitipan->Keluar->CellAttributes() ?>>
<span id="el_t06_pinjamantitipan_Keluar">
<input type="text" data-table="t06_pinjamantitipan" data-field="x_Keluar" name="x_Keluar" id="x_Keluar" size="10" placeholder="<?php echo ew_HtmlEncode($t06_pinjamantitipan->Keluar->getPlaceHolder()) ?>" value="<?php echo $t06_pinjamantitipan->Keluar->EditValue ?>"<?php echo $t06_pinjamantitipan->Keluar->EditAttributes() ?>>
</span>
<?php echo $t06_pinjamantitipan->Keluar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t06_pinjamantitipan->Sisa->Visible) { // Sisa ?>
	<div id="r_Sisa" class="form-group">
		<label id="elh_t06_pinjamantitipan_Sisa" for="x_Sisa" class="<?php echo $t06_pinjamantitipan_add->LeftColumnClass ?>"><?php echo $t06_pinjamantitipan->Sisa->FldCaption() ?></label>
		<div class="<?php echo $t06_pinjamantitipan_add->RightColumnClass ?>"><div<?php echo $t06_pinjamantitipan->Sisa->CellAttributes() ?>>
<span id="el_t06_pinjamantitipan_Sisa">
<input type="text" data-table="t06_pinjamantitipan" data-field="x_Sisa" name="x_Sisa" id="x_Sisa" size="10" placeholder="<?php echo ew_HtmlEncode($t06_pinjamantitipan->Sisa->getPlaceHolder()) ?>" value="<?php echo $t06_pinjamantitipan->Sisa->EditValue ?>"<?php echo $t06_pinjamantitipan->Sisa->EditAttributes() ?>>
</span>
<?php echo $t06_pinjamantitipan->Sisa->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$t06_pinjamantitipan_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $t06_pinjamantitipan_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t06_pinjamantitipan_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
ft06_pinjamantitipanadd.Init();
</script>
<?php
$t06_pinjamantitipan_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t06_pinjamantitipan_add->Page_Terminate();
?>
