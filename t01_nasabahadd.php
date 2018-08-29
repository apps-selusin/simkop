<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "t01_nasabahinfo.php" ?>
<?php include_once "t96_employeesinfo.php" ?>
<?php include_once "t02_angsurangridcls.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$t01_nasabah_add = NULL; // Initialize page object first

class ct01_nasabah_add extends ct01_nasabah {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{B3698D9B-8D4B-412E-A2E5-AFAD2FEE5A23}';

	// Table name
	var $TableName = 't01_nasabah';

	// Page object name
	var $PageObjName = 't01_nasabah_add';

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

		// Table object (t01_nasabah)
		if (!isset($GLOBALS["t01_nasabah"]) || get_class($GLOBALS["t01_nasabah"]) == "ct01_nasabah") {
			$GLOBALS["t01_nasabah"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t01_nasabah"];
		}

		// Table object (t96_employees)
		if (!isset($GLOBALS['t96_employees'])) $GLOBALS['t96_employees'] = new ct96_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

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
		// Create form object

		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->NoKontrak->SetVisibility();
		$this->Customer->SetVisibility();
		$this->Pekerjaan->SetVisibility();
		$this->Alamat->SetVisibility();
		$this->NoTelpHp->SetVisibility();
		$this->TglKontrak->SetVisibility();
		$this->MerkType->SetVisibility();
		$this->NoRangka->SetVisibility();
		$this->NoMesin->SetVisibility();
		$this->Warna->SetVisibility();
		$this->NoPol->SetVisibility();
		$this->Keterangan->SetVisibility();
		$this->AtasNama->SetVisibility();
		$this->Pinjaman->SetVisibility();
		$this->Denda->SetVisibility();
		$this->DispensasiDenda->SetVisibility();
		$this->LamaAngsuran->SetVisibility();
		$this->JumlahAngsuran->SetVisibility();

		// Set up multi page object
		$this->SetupMultiPages();

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

			// Get the keys for master table
			$sDetailTblVar = $this->getCurrentDetailTable();
			if ($sDetailTblVar <> "") {
				$DetailTblVar = explode(",", $sDetailTblVar);
				if (in_array("t02_angsuran", $DetailTblVar)) {

					// Process auto fill for detail table 't02_angsuran'
					if (preg_match('/^ft02_angsuran(grid|add|addopt|edit|update|search)$/', @$_POST["form"])) {
						if (!isset($GLOBALS["t02_angsuran_grid"])) $GLOBALS["t02_angsuran_grid"] = new ct02_angsuran_grid;
						$GLOBALS["t02_angsuran_grid"]->Page_Init();
						$this->Page_Terminate();
						exit();
					}
				}
			}
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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "t01_nasabahview.php")
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
	var $MultiPages; // Multi pages object

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

		// Set up detail parameters
		$this->SetupDetailParms();

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
					$this->Page_Terminate("t01_nasabahlist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetupDetailParms();
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					if ($this->getCurrentDetailTable() <> "") // Master/detail add
						$sReturnUrl = $this->GetDetailUrl();
					else
						$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "t01_nasabahlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "t01_nasabahview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to View page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values

					// Set up detail parameters
					$this->SetupDetailParms();
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
		$this->NoKontrak->CurrentValue = NULL;
		$this->NoKontrak->OldValue = $this->NoKontrak->CurrentValue;
		$this->Customer->CurrentValue = NULL;
		$this->Customer->OldValue = $this->Customer->CurrentValue;
		$this->Pekerjaan->CurrentValue = NULL;
		$this->Pekerjaan->OldValue = $this->Pekerjaan->CurrentValue;
		$this->Alamat->CurrentValue = NULL;
		$this->Alamat->OldValue = $this->Alamat->CurrentValue;
		$this->NoTelpHp->CurrentValue = NULL;
		$this->NoTelpHp->OldValue = $this->NoTelpHp->CurrentValue;
		$this->TglKontrak->CurrentValue = NULL;
		$this->TglKontrak->OldValue = $this->TglKontrak->CurrentValue;
		$this->MerkType->CurrentValue = NULL;
		$this->MerkType->OldValue = $this->MerkType->CurrentValue;
		$this->NoRangka->CurrentValue = NULL;
		$this->NoRangka->OldValue = $this->NoRangka->CurrentValue;
		$this->NoMesin->CurrentValue = NULL;
		$this->NoMesin->OldValue = $this->NoMesin->CurrentValue;
		$this->Warna->CurrentValue = NULL;
		$this->Warna->OldValue = $this->Warna->CurrentValue;
		$this->NoPol->CurrentValue = NULL;
		$this->NoPol->OldValue = $this->NoPol->CurrentValue;
		$this->Keterangan->CurrentValue = NULL;
		$this->Keterangan->OldValue = $this->Keterangan->CurrentValue;
		$this->AtasNama->CurrentValue = NULL;
		$this->AtasNama->OldValue = $this->AtasNama->CurrentValue;
		$this->Pinjaman->CurrentValue = NULL;
		$this->Pinjaman->OldValue = $this->Pinjaman->CurrentValue;
		$this->Denda->CurrentValue = NULL;
		$this->Denda->OldValue = $this->Denda->CurrentValue;
		$this->DispensasiDenda->CurrentValue = NULL;
		$this->DispensasiDenda->OldValue = $this->DispensasiDenda->CurrentValue;
		$this->LamaAngsuran->CurrentValue = NULL;
		$this->LamaAngsuran->OldValue = $this->LamaAngsuran->CurrentValue;
		$this->JumlahAngsuran->CurrentValue = NULL;
		$this->JumlahAngsuran->OldValue = $this->JumlahAngsuran->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->NoKontrak->FldIsDetailKey) {
			$this->NoKontrak->setFormValue($objForm->GetValue("x_NoKontrak"));
		}
		if (!$this->Customer->FldIsDetailKey) {
			$this->Customer->setFormValue($objForm->GetValue("x_Customer"));
		}
		if (!$this->Pekerjaan->FldIsDetailKey) {
			$this->Pekerjaan->setFormValue($objForm->GetValue("x_Pekerjaan"));
		}
		if (!$this->Alamat->FldIsDetailKey) {
			$this->Alamat->setFormValue($objForm->GetValue("x_Alamat"));
		}
		if (!$this->NoTelpHp->FldIsDetailKey) {
			$this->NoTelpHp->setFormValue($objForm->GetValue("x_NoTelpHp"));
		}
		if (!$this->TglKontrak->FldIsDetailKey) {
			$this->TglKontrak->setFormValue($objForm->GetValue("x_TglKontrak"));
			$this->TglKontrak->CurrentValue = ew_UnFormatDateTime($this->TglKontrak->CurrentValue, 7);
		}
		if (!$this->MerkType->FldIsDetailKey) {
			$this->MerkType->setFormValue($objForm->GetValue("x_MerkType"));
		}
		if (!$this->NoRangka->FldIsDetailKey) {
			$this->NoRangka->setFormValue($objForm->GetValue("x_NoRangka"));
		}
		if (!$this->NoMesin->FldIsDetailKey) {
			$this->NoMesin->setFormValue($objForm->GetValue("x_NoMesin"));
		}
		if (!$this->Warna->FldIsDetailKey) {
			$this->Warna->setFormValue($objForm->GetValue("x_Warna"));
		}
		if (!$this->NoPol->FldIsDetailKey) {
			$this->NoPol->setFormValue($objForm->GetValue("x_NoPol"));
		}
		if (!$this->Keterangan->FldIsDetailKey) {
			$this->Keterangan->setFormValue($objForm->GetValue("x_Keterangan"));
		}
		if (!$this->AtasNama->FldIsDetailKey) {
			$this->AtasNama->setFormValue($objForm->GetValue("x_AtasNama"));
		}
		if (!$this->Pinjaman->FldIsDetailKey) {
			$this->Pinjaman->setFormValue($objForm->GetValue("x_Pinjaman"));
		}
		if (!$this->Denda->FldIsDetailKey) {
			$this->Denda->setFormValue($objForm->GetValue("x_Denda"));
		}
		if (!$this->DispensasiDenda->FldIsDetailKey) {
			$this->DispensasiDenda->setFormValue($objForm->GetValue("x_DispensasiDenda"));
		}
		if (!$this->LamaAngsuran->FldIsDetailKey) {
			$this->LamaAngsuran->setFormValue($objForm->GetValue("x_LamaAngsuran"));
		}
		if (!$this->JumlahAngsuran->FldIsDetailKey) {
			$this->JumlahAngsuran->setFormValue($objForm->GetValue("x_JumlahAngsuran"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->NoKontrak->CurrentValue = $this->NoKontrak->FormValue;
		$this->Customer->CurrentValue = $this->Customer->FormValue;
		$this->Pekerjaan->CurrentValue = $this->Pekerjaan->FormValue;
		$this->Alamat->CurrentValue = $this->Alamat->FormValue;
		$this->NoTelpHp->CurrentValue = $this->NoTelpHp->FormValue;
		$this->TglKontrak->CurrentValue = $this->TglKontrak->FormValue;
		$this->TglKontrak->CurrentValue = ew_UnFormatDateTime($this->TglKontrak->CurrentValue, 7);
		$this->MerkType->CurrentValue = $this->MerkType->FormValue;
		$this->NoRangka->CurrentValue = $this->NoRangka->FormValue;
		$this->NoMesin->CurrentValue = $this->NoMesin->FormValue;
		$this->Warna->CurrentValue = $this->Warna->FormValue;
		$this->NoPol->CurrentValue = $this->NoPol->FormValue;
		$this->Keterangan->CurrentValue = $this->Keterangan->FormValue;
		$this->AtasNama->CurrentValue = $this->AtasNama->FormValue;
		$this->Pinjaman->CurrentValue = $this->Pinjaman->FormValue;
		$this->Denda->CurrentValue = $this->Denda->FormValue;
		$this->DispensasiDenda->CurrentValue = $this->DispensasiDenda->FormValue;
		$this->LamaAngsuran->CurrentValue = $this->LamaAngsuran->FormValue;
		$this->JumlahAngsuran->CurrentValue = $this->JumlahAngsuran->FormValue;
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
		$this->LoadDefaultValues();
		$row = array();
		$row['id'] = $this->id->CurrentValue;
		$row['NoKontrak'] = $this->NoKontrak->CurrentValue;
		$row['Customer'] = $this->Customer->CurrentValue;
		$row['Pekerjaan'] = $this->Pekerjaan->CurrentValue;
		$row['Alamat'] = $this->Alamat->CurrentValue;
		$row['NoTelpHp'] = $this->NoTelpHp->CurrentValue;
		$row['TglKontrak'] = $this->TglKontrak->CurrentValue;
		$row['MerkType'] = $this->MerkType->CurrentValue;
		$row['NoRangka'] = $this->NoRangka->CurrentValue;
		$row['NoMesin'] = $this->NoMesin->CurrentValue;
		$row['Warna'] = $this->Warna->CurrentValue;
		$row['NoPol'] = $this->NoPol->CurrentValue;
		$row['Keterangan'] = $this->Keterangan->CurrentValue;
		$row['AtasNama'] = $this->AtasNama->CurrentValue;
		$row['Pinjaman'] = $this->Pinjaman->CurrentValue;
		$row['Denda'] = $this->Denda->CurrentValue;
		$row['DispensasiDenda'] = $this->DispensasiDenda->CurrentValue;
		$row['LamaAngsuran'] = $this->LamaAngsuran->CurrentValue;
		$row['JumlahAngsuran'] = $this->JumlahAngsuran->CurrentValue;
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// NoKontrak
			$this->NoKontrak->EditAttrs["class"] = "form-control";
			$this->NoKontrak->EditCustomAttributes = "";
			$this->NoKontrak->EditValue = ew_HtmlEncode($this->NoKontrak->CurrentValue);
			$this->NoKontrak->PlaceHolder = ew_RemoveHtml($this->NoKontrak->FldCaption());

			// Customer
			$this->Customer->EditAttrs["class"] = "form-control";
			$this->Customer->EditCustomAttributes = "";
			$this->Customer->EditValue = ew_HtmlEncode($this->Customer->CurrentValue);
			$this->Customer->PlaceHolder = ew_RemoveHtml($this->Customer->FldCaption());

			// Pekerjaan
			$this->Pekerjaan->EditAttrs["class"] = "form-control";
			$this->Pekerjaan->EditCustomAttributes = "";
			$this->Pekerjaan->EditValue = ew_HtmlEncode($this->Pekerjaan->CurrentValue);
			$this->Pekerjaan->PlaceHolder = ew_RemoveHtml($this->Pekerjaan->FldCaption());

			// Alamat
			$this->Alamat->EditAttrs["class"] = "form-control";
			$this->Alamat->EditCustomAttributes = "";
			$this->Alamat->EditValue = ew_HtmlEncode($this->Alamat->CurrentValue);
			$this->Alamat->PlaceHolder = ew_RemoveHtml($this->Alamat->FldCaption());

			// NoTelpHp
			$this->NoTelpHp->EditAttrs["class"] = "form-control";
			$this->NoTelpHp->EditCustomAttributes = "";
			$this->NoTelpHp->EditValue = ew_HtmlEncode($this->NoTelpHp->CurrentValue);
			$this->NoTelpHp->PlaceHolder = ew_RemoveHtml($this->NoTelpHp->FldCaption());

			// TglKontrak
			$this->TglKontrak->EditAttrs["class"] = "form-control";
			$this->TglKontrak->EditCustomAttributes = "";
			$this->TglKontrak->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->TglKontrak->CurrentValue, 7));
			$this->TglKontrak->PlaceHolder = ew_RemoveHtml($this->TglKontrak->FldCaption());

			// MerkType
			$this->MerkType->EditAttrs["class"] = "form-control";
			$this->MerkType->EditCustomAttributes = "";
			$this->MerkType->EditValue = ew_HtmlEncode($this->MerkType->CurrentValue);
			$this->MerkType->PlaceHolder = ew_RemoveHtml($this->MerkType->FldCaption());

			// NoRangka
			$this->NoRangka->EditAttrs["class"] = "form-control";
			$this->NoRangka->EditCustomAttributes = "";
			$this->NoRangka->EditValue = ew_HtmlEncode($this->NoRangka->CurrentValue);
			$this->NoRangka->PlaceHolder = ew_RemoveHtml($this->NoRangka->FldCaption());

			// NoMesin
			$this->NoMesin->EditAttrs["class"] = "form-control";
			$this->NoMesin->EditCustomAttributes = "";
			$this->NoMesin->EditValue = ew_HtmlEncode($this->NoMesin->CurrentValue);
			$this->NoMesin->PlaceHolder = ew_RemoveHtml($this->NoMesin->FldCaption());

			// Warna
			$this->Warna->EditAttrs["class"] = "form-control";
			$this->Warna->EditCustomAttributes = "";
			$this->Warna->EditValue = ew_HtmlEncode($this->Warna->CurrentValue);
			$this->Warna->PlaceHolder = ew_RemoveHtml($this->Warna->FldCaption());

			// NoPol
			$this->NoPol->EditAttrs["class"] = "form-control";
			$this->NoPol->EditCustomAttributes = "";
			$this->NoPol->EditValue = ew_HtmlEncode($this->NoPol->CurrentValue);
			$this->NoPol->PlaceHolder = ew_RemoveHtml($this->NoPol->FldCaption());

			// Keterangan
			$this->Keterangan->EditAttrs["class"] = "form-control";
			$this->Keterangan->EditCustomAttributes = "";
			$this->Keterangan->EditValue = ew_HtmlEncode($this->Keterangan->CurrentValue);
			$this->Keterangan->PlaceHolder = ew_RemoveHtml($this->Keterangan->FldCaption());

			// AtasNama
			$this->AtasNama->EditAttrs["class"] = "form-control";
			$this->AtasNama->EditCustomAttributes = "";
			$this->AtasNama->EditValue = ew_HtmlEncode($this->AtasNama->CurrentValue);
			$this->AtasNama->PlaceHolder = ew_RemoveHtml($this->AtasNama->FldCaption());

			// Pinjaman
			$this->Pinjaman->EditAttrs["class"] = "form-control";
			$this->Pinjaman->EditCustomAttributes = "";
			$this->Pinjaman->EditValue = ew_HtmlEncode($this->Pinjaman->CurrentValue);
			$this->Pinjaman->PlaceHolder = ew_RemoveHtml($this->Pinjaman->FldCaption());
			if (strval($this->Pinjaman->EditValue) <> "" && is_numeric($this->Pinjaman->EditValue)) $this->Pinjaman->EditValue = ew_FormatNumber($this->Pinjaman->EditValue, -2, -2, -2, -2);

			// Denda
			$this->Denda->EditAttrs["class"] = "form-control";
			$this->Denda->EditCustomAttributes = "";
			$this->Denda->EditValue = ew_HtmlEncode($this->Denda->CurrentValue);
			$this->Denda->PlaceHolder = ew_RemoveHtml($this->Denda->FldCaption());
			if (strval($this->Denda->EditValue) <> "" && is_numeric($this->Denda->EditValue)) $this->Denda->EditValue = ew_FormatNumber($this->Denda->EditValue, -2, -2, -2, -2);

			// DispensasiDenda
			$this->DispensasiDenda->EditAttrs["class"] = "form-control";
			$this->DispensasiDenda->EditCustomAttributes = "";
			$this->DispensasiDenda->EditValue = ew_HtmlEncode($this->DispensasiDenda->CurrentValue);
			$this->DispensasiDenda->PlaceHolder = ew_RemoveHtml($this->DispensasiDenda->FldCaption());

			// LamaAngsuran
			$this->LamaAngsuran->EditAttrs["class"] = "form-control";
			$this->LamaAngsuran->EditCustomAttributes = "";
			$this->LamaAngsuran->EditValue = ew_HtmlEncode($this->LamaAngsuran->CurrentValue);
			$this->LamaAngsuran->PlaceHolder = ew_RemoveHtml($this->LamaAngsuran->FldCaption());

			// JumlahAngsuran
			$this->JumlahAngsuran->EditAttrs["class"] = "form-control";
			$this->JumlahAngsuran->EditCustomAttributes = "";
			$this->JumlahAngsuran->EditValue = ew_HtmlEncode($this->JumlahAngsuran->CurrentValue);
			$this->JumlahAngsuran->PlaceHolder = ew_RemoveHtml($this->JumlahAngsuran->FldCaption());
			if (strval($this->JumlahAngsuran->EditValue) <> "" && is_numeric($this->JumlahAngsuran->EditValue)) $this->JumlahAngsuran->EditValue = ew_FormatNumber($this->JumlahAngsuran->EditValue, -2, -2, -2, -2);

			// Add refer script
			// NoKontrak

			$this->NoKontrak->LinkCustomAttributes = "";
			$this->NoKontrak->HrefValue = "";

			// Customer
			$this->Customer->LinkCustomAttributes = "";
			$this->Customer->HrefValue = "";

			// Pekerjaan
			$this->Pekerjaan->LinkCustomAttributes = "";
			$this->Pekerjaan->HrefValue = "";

			// Alamat
			$this->Alamat->LinkCustomAttributes = "";
			$this->Alamat->HrefValue = "";

			// NoTelpHp
			$this->NoTelpHp->LinkCustomAttributes = "";
			$this->NoTelpHp->HrefValue = "";

			// TglKontrak
			$this->TglKontrak->LinkCustomAttributes = "";
			$this->TglKontrak->HrefValue = "";

			// MerkType
			$this->MerkType->LinkCustomAttributes = "";
			$this->MerkType->HrefValue = "";

			// NoRangka
			$this->NoRangka->LinkCustomAttributes = "";
			$this->NoRangka->HrefValue = "";

			// NoMesin
			$this->NoMesin->LinkCustomAttributes = "";
			$this->NoMesin->HrefValue = "";

			// Warna
			$this->Warna->LinkCustomAttributes = "";
			$this->Warna->HrefValue = "";

			// NoPol
			$this->NoPol->LinkCustomAttributes = "";
			$this->NoPol->HrefValue = "";

			// Keterangan
			$this->Keterangan->LinkCustomAttributes = "";
			$this->Keterangan->HrefValue = "";

			// AtasNama
			$this->AtasNama->LinkCustomAttributes = "";
			$this->AtasNama->HrefValue = "";

			// Pinjaman
			$this->Pinjaman->LinkCustomAttributes = "";
			$this->Pinjaman->HrefValue = "";

			// Denda
			$this->Denda->LinkCustomAttributes = "";
			$this->Denda->HrefValue = "";

			// DispensasiDenda
			$this->DispensasiDenda->LinkCustomAttributes = "";
			$this->DispensasiDenda->HrefValue = "";

			// LamaAngsuran
			$this->LamaAngsuran->LinkCustomAttributes = "";
			$this->LamaAngsuran->HrefValue = "";

			// JumlahAngsuran
			$this->JumlahAngsuran->LinkCustomAttributes = "";
			$this->JumlahAngsuran->HrefValue = "";
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
		if (!$this->Customer->FldIsDetailKey && !is_null($this->Customer->FormValue) && $this->Customer->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Customer->FldCaption(), $this->Customer->ReqErrMsg));
		}
		if (!$this->TglKontrak->FldIsDetailKey && !is_null($this->TglKontrak->FormValue) && $this->TglKontrak->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->TglKontrak->FldCaption(), $this->TglKontrak->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->TglKontrak->FormValue)) {
			ew_AddMessage($gsFormError, $this->TglKontrak->FldErrMsg());
		}
		if (!$this->MerkType->FldIsDetailKey && !is_null($this->MerkType->FormValue) && $this->MerkType->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->MerkType->FldCaption(), $this->MerkType->ReqErrMsg));
		}
		if (!$this->Pinjaman->FldIsDetailKey && !is_null($this->Pinjaman->FormValue) && $this->Pinjaman->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Pinjaman->FldCaption(), $this->Pinjaman->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->Pinjaman->FormValue)) {
			ew_AddMessage($gsFormError, $this->Pinjaman->FldErrMsg());
		}
		if (!$this->Denda->FldIsDetailKey && !is_null($this->Denda->FormValue) && $this->Denda->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Denda->FldCaption(), $this->Denda->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->Denda->FormValue)) {
			ew_AddMessage($gsFormError, $this->Denda->FldErrMsg());
		}
		if (!$this->DispensasiDenda->FldIsDetailKey && !is_null($this->DispensasiDenda->FormValue) && $this->DispensasiDenda->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->DispensasiDenda->FldCaption(), $this->DispensasiDenda->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->DispensasiDenda->FormValue)) {
			ew_AddMessage($gsFormError, $this->DispensasiDenda->FldErrMsg());
		}
		if (!$this->LamaAngsuran->FldIsDetailKey && !is_null($this->LamaAngsuran->FormValue) && $this->LamaAngsuran->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->LamaAngsuran->FldCaption(), $this->LamaAngsuran->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->LamaAngsuran->FormValue)) {
			ew_AddMessage($gsFormError, $this->LamaAngsuran->FldErrMsg());
		}
		if (!$this->JumlahAngsuran->FldIsDetailKey && !is_null($this->JumlahAngsuran->FormValue) && $this->JumlahAngsuran->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->JumlahAngsuran->FldCaption(), $this->JumlahAngsuran->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->JumlahAngsuran->FormValue)) {
			ew_AddMessage($gsFormError, $this->JumlahAngsuran->FldErrMsg());
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("t02_angsuran", $DetailTblVar) && $GLOBALS["t02_angsuran"]->DetailAdd) {
			if (!isset($GLOBALS["t02_angsuran_grid"])) $GLOBALS["t02_angsuran_grid"] = new ct02_angsuran_grid(); // get detail page object
			$GLOBALS["t02_angsuran_grid"]->ValidateGridForm();
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

		// Begin transaction
		if ($this->getCurrentDetailTable() <> "")
			$conn->BeginTrans();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// NoKontrak
		$this->NoKontrak->SetDbValueDef($rsnew, $this->NoKontrak->CurrentValue, "", FALSE);

		// Customer
		$this->Customer->SetDbValueDef($rsnew, $this->Customer->CurrentValue, "", FALSE);

		// Pekerjaan
		$this->Pekerjaan->SetDbValueDef($rsnew, $this->Pekerjaan->CurrentValue, NULL, FALSE);

		// Alamat
		$this->Alamat->SetDbValueDef($rsnew, $this->Alamat->CurrentValue, NULL, FALSE);

		// NoTelpHp
		$this->NoTelpHp->SetDbValueDef($rsnew, $this->NoTelpHp->CurrentValue, NULL, FALSE);

		// TglKontrak
		$this->TglKontrak->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->TglKontrak->CurrentValue, 7), ew_CurrentDate(), FALSE);

		// MerkType
		$this->MerkType->SetDbValueDef($rsnew, $this->MerkType->CurrentValue, "", FALSE);

		// NoRangka
		$this->NoRangka->SetDbValueDef($rsnew, $this->NoRangka->CurrentValue, NULL, FALSE);

		// NoMesin
		$this->NoMesin->SetDbValueDef($rsnew, $this->NoMesin->CurrentValue, NULL, FALSE);

		// Warna
		$this->Warna->SetDbValueDef($rsnew, $this->Warna->CurrentValue, NULL, FALSE);

		// NoPol
		$this->NoPol->SetDbValueDef($rsnew, $this->NoPol->CurrentValue, NULL, FALSE);

		// Keterangan
		$this->Keterangan->SetDbValueDef($rsnew, $this->Keterangan->CurrentValue, NULL, FALSE);

		// AtasNama
		$this->AtasNama->SetDbValueDef($rsnew, $this->AtasNama->CurrentValue, NULL, FALSE);

		// Pinjaman
		$this->Pinjaman->SetDbValueDef($rsnew, $this->Pinjaman->CurrentValue, 0, FALSE);

		// Denda
		$this->Denda->SetDbValueDef($rsnew, $this->Denda->CurrentValue, 0, FALSE);

		// DispensasiDenda
		$this->DispensasiDenda->SetDbValueDef($rsnew, $this->DispensasiDenda->CurrentValue, 0, FALSE);

		// LamaAngsuran
		$this->LamaAngsuran->SetDbValueDef($rsnew, $this->LamaAngsuran->CurrentValue, 0, FALSE);

		// JumlahAngsuran
		$this->JumlahAngsuran->SetDbValueDef($rsnew, $this->JumlahAngsuran->CurrentValue, 0, FALSE);

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

		// Add detail records
		if ($AddRow) {
			$DetailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("t02_angsuran", $DetailTblVar) && $GLOBALS["t02_angsuran"]->DetailAdd) {
				$GLOBALS["t02_angsuran"]->NoKontrak->setSessionValue($this->id->CurrentValue); // Set master key
				if (!isset($GLOBALS["t02_angsuran_grid"])) $GLOBALS["t02_angsuran_grid"] = new ct02_angsuran_grid(); // Get detail page object
				$Security->LoadCurrentUserLevel($this->ProjectID . "t02_angsuran"); // Load user level of detail table
				$AddRow = $GLOBALS["t02_angsuran_grid"]->GridInsert();
				$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$AddRow)
					$GLOBALS["t02_angsuran"]->NoKontrak->setSessionValue(""); // Clear master key if insert failed
			}
		}

		// Commit/Rollback transaction
		if ($this->getCurrentDetailTable() <> "") {
			if ($AddRow) {
				$conn->CommitTrans(); // Commit transaction
			} else {
				$conn->RollbackTrans(); // Rollback transaction
			}
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up detail parms based on QueryString
	function SetupDetailParms() {

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$this->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $this->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			$DetailTblVar = explode(",", $sDetailTblVar);
			if (in_array("t02_angsuran", $DetailTblVar)) {
				if (!isset($GLOBALS["t02_angsuran_grid"]))
					$GLOBALS["t02_angsuran_grid"] = new ct02_angsuran_grid;
				if ($GLOBALS["t02_angsuran_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["t02_angsuran_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["t02_angsuran_grid"]->CurrentMode = "add";
					$GLOBALS["t02_angsuran_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["t02_angsuran_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["t02_angsuran_grid"]->setStartRecordNumber(1);
					$GLOBALS["t02_angsuran_grid"]->NoKontrak->FldIsDetailKey = TRUE;
					$GLOBALS["t02_angsuran_grid"]->NoKontrak->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["t02_angsuran_grid"]->NoKontrak->setSessionValue($GLOBALS["t02_angsuran_grid"]->NoKontrak->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t01_nasabahlist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Set up multi pages
	function SetupMultiPages() {
		$pages = new cSubPages();
		$pages->Parent = "#" . $this->PageObjName;
		$pages->Add(0);
		$pages->Add(1);
		$pages->Add(2);
		$pages->Add(3);
		$this->MultiPages = $pages;
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
if (!isset($t01_nasabah_add)) $t01_nasabah_add = new ct01_nasabah_add();

// Page init
$t01_nasabah_add->Page_Init();

// Page main
$t01_nasabah_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t01_nasabah_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ft01_nasabahadd = new ew_Form("ft01_nasabahadd", "add");

// Validate form
ft01_nasabahadd.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t01_nasabah->NoKontrak->FldCaption(), $t01_nasabah->NoKontrak->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Customer");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t01_nasabah->Customer->FldCaption(), $t01_nasabah->Customer->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_TglKontrak");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t01_nasabah->TglKontrak->FldCaption(), $t01_nasabah->TglKontrak->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_TglKontrak");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t01_nasabah->TglKontrak->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_MerkType");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t01_nasabah->MerkType->FldCaption(), $t01_nasabah->MerkType->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Pinjaman");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t01_nasabah->Pinjaman->FldCaption(), $t01_nasabah->Pinjaman->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Pinjaman");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t01_nasabah->Pinjaman->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Denda");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t01_nasabah->Denda->FldCaption(), $t01_nasabah->Denda->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Denda");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t01_nasabah->Denda->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_DispensasiDenda");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t01_nasabah->DispensasiDenda->FldCaption(), $t01_nasabah->DispensasiDenda->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_DispensasiDenda");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t01_nasabah->DispensasiDenda->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_LamaAngsuran");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t01_nasabah->LamaAngsuran->FldCaption(), $t01_nasabah->LamaAngsuran->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_LamaAngsuran");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t01_nasabah->LamaAngsuran->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_JumlahAngsuran");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t01_nasabah->JumlahAngsuran->FldCaption(), $t01_nasabah->JumlahAngsuran->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_JumlahAngsuran");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t01_nasabah->JumlahAngsuran->FldErrMsg()) ?>");

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
ft01_nasabahadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft01_nasabahadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Multi-Page
ft01_nasabahadd.MultiPage = new ew_MultiPage("ft01_nasabahadd");

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t01_nasabah_add->ShowPageHeader(); ?>
<?php
$t01_nasabah_add->ShowMessage();
?>
<form name="ft01_nasabahadd" id="ft01_nasabahadd" class="<?php echo $t01_nasabah_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t01_nasabah_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t01_nasabah_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t01_nasabah">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($t01_nasabah_add->IsModal) ?>">
<div class="ewMultiPage"><!-- multi-page -->
<div class="box-group" id="t01_nasabah_add"><!-- multi-page accordion .box-group -->
	<div class="panel box<?php echo $t01_nasabah_add->MultiPages->PageStyle("1") ?>"><!-- multi-page accordion .panel .box -->
		<div class="box-header with-border">
			<h4 class="box-title">
				<a data-toggle="collapse" data-parent="<?php echo $t01_nasabah_add->MultiPages->Parent ?>" href="#tab_t01_nasabah1"><?php echo $t01_nasabah->PageCaption(1) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $t01_nasabah_add->MultiPages->PageStyle("1") ?>" id="tab_t01_nasabah1"><!-- multi-page accordion .panel-collapse -->
			<div class="box-body"><!-- multi-page accordion .box-body -->
<div class="ewAddDiv"><!-- page* -->
<?php if ($t01_nasabah->NoKontrak->Visible) { // NoKontrak ?>
	<div id="r_NoKontrak" class="form-group">
		<label id="elh_t01_nasabah_NoKontrak" for="x_NoKontrak" class="<?php echo $t01_nasabah_add->LeftColumnClass ?>"><?php echo $t01_nasabah->NoKontrak->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_nasabah_add->RightColumnClass ?>"><div<?php echo $t01_nasabah->NoKontrak->CellAttributes() ?>>
<span id="el_t01_nasabah_NoKontrak">
<input type="text" data-table="t01_nasabah" data-field="x_NoKontrak" data-page="1" name="x_NoKontrak" id="x_NoKontrak" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->NoKontrak->getPlaceHolder()) ?>" value="<?php echo $t01_nasabah->NoKontrak->EditValue ?>"<?php echo $t01_nasabah->NoKontrak->EditAttributes() ?>>
</span>
<?php echo $t01_nasabah->NoKontrak->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->Customer->Visible) { // Customer ?>
	<div id="r_Customer" class="form-group">
		<label id="elh_t01_nasabah_Customer" for="x_Customer" class="<?php echo $t01_nasabah_add->LeftColumnClass ?>"><?php echo $t01_nasabah->Customer->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_nasabah_add->RightColumnClass ?>"><div<?php echo $t01_nasabah->Customer->CellAttributes() ?>>
<span id="el_t01_nasabah_Customer">
<input type="text" data-table="t01_nasabah" data-field="x_Customer" data-page="1" name="x_Customer" id="x_Customer" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->Customer->getPlaceHolder()) ?>" value="<?php echo $t01_nasabah->Customer->EditValue ?>"<?php echo $t01_nasabah->Customer->EditAttributes() ?>>
</span>
<?php echo $t01_nasabah->Customer->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->TglKontrak->Visible) { // TglKontrak ?>
	<div id="r_TglKontrak" class="form-group">
		<label id="elh_t01_nasabah_TglKontrak" for="x_TglKontrak" class="<?php echo $t01_nasabah_add->LeftColumnClass ?>"><?php echo $t01_nasabah->TglKontrak->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_nasabah_add->RightColumnClass ?>"><div<?php echo $t01_nasabah->TglKontrak->CellAttributes() ?>>
<span id="el_t01_nasabah_TglKontrak">
<input type="text" data-table="t01_nasabah" data-field="x_TglKontrak" data-page="1" data-format="7" name="x_TglKontrak" id="x_TglKontrak" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->TglKontrak->getPlaceHolder()) ?>" value="<?php echo $t01_nasabah->TglKontrak->EditValue ?>"<?php echo $t01_nasabah->TglKontrak->EditAttributes() ?>>
<?php if (!$t01_nasabah->TglKontrak->ReadOnly && !$t01_nasabah->TglKontrak->Disabled && !isset($t01_nasabah->TglKontrak->EditAttrs["readonly"]) && !isset($t01_nasabah->TglKontrak->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateDateTimePicker("ft01_nasabahadd", "x_TglKontrak", {"ignoreReadonly":true,"useCurrent":false,"format":7});
</script>
<?php } ?>
</span>
<?php echo $t01_nasabah->TglKontrak->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->Pinjaman->Visible) { // Pinjaman ?>
	<div id="r_Pinjaman" class="form-group">
		<label id="elh_t01_nasabah_Pinjaman" for="x_Pinjaman" class="<?php echo $t01_nasabah_add->LeftColumnClass ?>"><?php echo $t01_nasabah->Pinjaman->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_nasabah_add->RightColumnClass ?>"><div<?php echo $t01_nasabah->Pinjaman->CellAttributes() ?>>
<span id="el_t01_nasabah_Pinjaman">
<input type="text" data-table="t01_nasabah" data-field="x_Pinjaman" data-page="1" name="x_Pinjaman" id="x_Pinjaman" size="30" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->Pinjaman->getPlaceHolder()) ?>" value="<?php echo $t01_nasabah->Pinjaman->EditValue ?>"<?php echo $t01_nasabah->Pinjaman->EditAttributes() ?>>
</span>
<?php echo $t01_nasabah->Pinjaman->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->Denda->Visible) { // Denda ?>
	<div id="r_Denda" class="form-group">
		<label id="elh_t01_nasabah_Denda" for="x_Denda" class="<?php echo $t01_nasabah_add->LeftColumnClass ?>"><?php echo $t01_nasabah->Denda->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_nasabah_add->RightColumnClass ?>"><div<?php echo $t01_nasabah->Denda->CellAttributes() ?>>
<span id="el_t01_nasabah_Denda">
<input type="text" data-table="t01_nasabah" data-field="x_Denda" data-page="1" name="x_Denda" id="x_Denda" size="30" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->Denda->getPlaceHolder()) ?>" value="<?php echo $t01_nasabah->Denda->EditValue ?>"<?php echo $t01_nasabah->Denda->EditAttributes() ?>>
</span>
<?php echo $t01_nasabah->Denda->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->DispensasiDenda->Visible) { // DispensasiDenda ?>
	<div id="r_DispensasiDenda" class="form-group">
		<label id="elh_t01_nasabah_DispensasiDenda" for="x_DispensasiDenda" class="<?php echo $t01_nasabah_add->LeftColumnClass ?>"><?php echo $t01_nasabah->DispensasiDenda->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_nasabah_add->RightColumnClass ?>"><div<?php echo $t01_nasabah->DispensasiDenda->CellAttributes() ?>>
<span id="el_t01_nasabah_DispensasiDenda">
<input type="text" data-table="t01_nasabah" data-field="x_DispensasiDenda" data-page="1" name="x_DispensasiDenda" id="x_DispensasiDenda" size="30" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->DispensasiDenda->getPlaceHolder()) ?>" value="<?php echo $t01_nasabah->DispensasiDenda->EditValue ?>"<?php echo $t01_nasabah->DispensasiDenda->EditAttributes() ?>>
</span>
<?php echo $t01_nasabah->DispensasiDenda->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->LamaAngsuran->Visible) { // LamaAngsuran ?>
	<div id="r_LamaAngsuran" class="form-group">
		<label id="elh_t01_nasabah_LamaAngsuran" for="x_LamaAngsuran" class="<?php echo $t01_nasabah_add->LeftColumnClass ?>"><?php echo $t01_nasabah->LamaAngsuran->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_nasabah_add->RightColumnClass ?>"><div<?php echo $t01_nasabah->LamaAngsuran->CellAttributes() ?>>
<span id="el_t01_nasabah_LamaAngsuran">
<input type="text" data-table="t01_nasabah" data-field="x_LamaAngsuran" data-page="1" name="x_LamaAngsuran" id="x_LamaAngsuran" size="30" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->LamaAngsuran->getPlaceHolder()) ?>" value="<?php echo $t01_nasabah->LamaAngsuran->EditValue ?>"<?php echo $t01_nasabah->LamaAngsuran->EditAttributes() ?>>
</span>
<?php echo $t01_nasabah->LamaAngsuran->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->JumlahAngsuran->Visible) { // JumlahAngsuran ?>
	<div id="r_JumlahAngsuran" class="form-group">
		<label id="elh_t01_nasabah_JumlahAngsuran" for="x_JumlahAngsuran" class="<?php echo $t01_nasabah_add->LeftColumnClass ?>"><?php echo $t01_nasabah->JumlahAngsuran->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_nasabah_add->RightColumnClass ?>"><div<?php echo $t01_nasabah->JumlahAngsuran->CellAttributes() ?>>
<span id="el_t01_nasabah_JumlahAngsuran">
<input type="text" data-table="t01_nasabah" data-field="x_JumlahAngsuran" data-page="1" name="x_JumlahAngsuran" id="x_JumlahAngsuran" size="30" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->JumlahAngsuran->getPlaceHolder()) ?>" value="<?php echo $t01_nasabah->JumlahAngsuran->EditValue ?>"<?php echo $t01_nasabah->JumlahAngsuran->EditAttributes() ?>>
</span>
<?php echo $t01_nasabah->JumlahAngsuran->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
			</div><!-- /multi-page accordion .box-body -->
		</div><!-- /multi-page accordion .panel-collapse -->
	</div><!-- /multi-page accordion .panel .box -->
	<div class="panel box<?php echo $t01_nasabah_add->MultiPages->PageStyle("2") ?>"><!-- multi-page accordion .panel .box -->
		<div class="box-header with-border">
			<h4 class="box-title">
				<a data-toggle="collapse" data-parent="<?php echo $t01_nasabah_add->MultiPages->Parent ?>" href="#tab_t01_nasabah2"><?php echo $t01_nasabah->PageCaption(2) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $t01_nasabah_add->MultiPages->PageStyle("2") ?>" id="tab_t01_nasabah2"><!-- multi-page accordion .panel-collapse -->
			<div class="box-body"><!-- multi-page accordion .box-body -->
<div class="ewAddDiv"><!-- page* -->
<?php if ($t01_nasabah->MerkType->Visible) { // MerkType ?>
	<div id="r_MerkType" class="form-group">
		<label id="elh_t01_nasabah_MerkType" for="x_MerkType" class="<?php echo $t01_nasabah_add->LeftColumnClass ?>"><?php echo $t01_nasabah->MerkType->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_nasabah_add->RightColumnClass ?>"><div<?php echo $t01_nasabah->MerkType->CellAttributes() ?>>
<span id="el_t01_nasabah_MerkType">
<input type="text" data-table="t01_nasabah" data-field="x_MerkType" data-page="2" name="x_MerkType" id="x_MerkType" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->MerkType->getPlaceHolder()) ?>" value="<?php echo $t01_nasabah->MerkType->EditValue ?>"<?php echo $t01_nasabah->MerkType->EditAttributes() ?>>
</span>
<?php echo $t01_nasabah->MerkType->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->NoRangka->Visible) { // NoRangka ?>
	<div id="r_NoRangka" class="form-group">
		<label id="elh_t01_nasabah_NoRangka" for="x_NoRangka" class="<?php echo $t01_nasabah_add->LeftColumnClass ?>"><?php echo $t01_nasabah->NoRangka->FldCaption() ?></label>
		<div class="<?php echo $t01_nasabah_add->RightColumnClass ?>"><div<?php echo $t01_nasabah->NoRangka->CellAttributes() ?>>
<span id="el_t01_nasabah_NoRangka">
<input type="text" data-table="t01_nasabah" data-field="x_NoRangka" data-page="2" name="x_NoRangka" id="x_NoRangka" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->NoRangka->getPlaceHolder()) ?>" value="<?php echo $t01_nasabah->NoRangka->EditValue ?>"<?php echo $t01_nasabah->NoRangka->EditAttributes() ?>>
</span>
<?php echo $t01_nasabah->NoRangka->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->NoMesin->Visible) { // NoMesin ?>
	<div id="r_NoMesin" class="form-group">
		<label id="elh_t01_nasabah_NoMesin" for="x_NoMesin" class="<?php echo $t01_nasabah_add->LeftColumnClass ?>"><?php echo $t01_nasabah->NoMesin->FldCaption() ?></label>
		<div class="<?php echo $t01_nasabah_add->RightColumnClass ?>"><div<?php echo $t01_nasabah->NoMesin->CellAttributes() ?>>
<span id="el_t01_nasabah_NoMesin">
<input type="text" data-table="t01_nasabah" data-field="x_NoMesin" data-page="2" name="x_NoMesin" id="x_NoMesin" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->NoMesin->getPlaceHolder()) ?>" value="<?php echo $t01_nasabah->NoMesin->EditValue ?>"<?php echo $t01_nasabah->NoMesin->EditAttributes() ?>>
</span>
<?php echo $t01_nasabah->NoMesin->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->Warna->Visible) { // Warna ?>
	<div id="r_Warna" class="form-group">
		<label id="elh_t01_nasabah_Warna" for="x_Warna" class="<?php echo $t01_nasabah_add->LeftColumnClass ?>"><?php echo $t01_nasabah->Warna->FldCaption() ?></label>
		<div class="<?php echo $t01_nasabah_add->RightColumnClass ?>"><div<?php echo $t01_nasabah->Warna->CellAttributes() ?>>
<span id="el_t01_nasabah_Warna">
<input type="text" data-table="t01_nasabah" data-field="x_Warna" data-page="2" name="x_Warna" id="x_Warna" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->Warna->getPlaceHolder()) ?>" value="<?php echo $t01_nasabah->Warna->EditValue ?>"<?php echo $t01_nasabah->Warna->EditAttributes() ?>>
</span>
<?php echo $t01_nasabah->Warna->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->NoPol->Visible) { // NoPol ?>
	<div id="r_NoPol" class="form-group">
		<label id="elh_t01_nasabah_NoPol" for="x_NoPol" class="<?php echo $t01_nasabah_add->LeftColumnClass ?>"><?php echo $t01_nasabah->NoPol->FldCaption() ?></label>
		<div class="<?php echo $t01_nasabah_add->RightColumnClass ?>"><div<?php echo $t01_nasabah->NoPol->CellAttributes() ?>>
<span id="el_t01_nasabah_NoPol">
<input type="text" data-table="t01_nasabah" data-field="x_NoPol" data-page="2" name="x_NoPol" id="x_NoPol" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->NoPol->getPlaceHolder()) ?>" value="<?php echo $t01_nasabah->NoPol->EditValue ?>"<?php echo $t01_nasabah->NoPol->EditAttributes() ?>>
</span>
<?php echo $t01_nasabah->NoPol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->Keterangan->Visible) { // Keterangan ?>
	<div id="r_Keterangan" class="form-group">
		<label id="elh_t01_nasabah_Keterangan" for="x_Keterangan" class="<?php echo $t01_nasabah_add->LeftColumnClass ?>"><?php echo $t01_nasabah->Keterangan->FldCaption() ?></label>
		<div class="<?php echo $t01_nasabah_add->RightColumnClass ?>"><div<?php echo $t01_nasabah->Keterangan->CellAttributes() ?>>
<span id="el_t01_nasabah_Keterangan">
<textarea data-table="t01_nasabah" data-field="x_Keterangan" data-page="2" name="x_Keterangan" id="x_Keterangan" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->Keterangan->getPlaceHolder()) ?>"<?php echo $t01_nasabah->Keterangan->EditAttributes() ?>><?php echo $t01_nasabah->Keterangan->EditValue ?></textarea>
</span>
<?php echo $t01_nasabah->Keterangan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->AtasNama->Visible) { // AtasNama ?>
	<div id="r_AtasNama" class="form-group">
		<label id="elh_t01_nasabah_AtasNama" for="x_AtasNama" class="<?php echo $t01_nasabah_add->LeftColumnClass ?>"><?php echo $t01_nasabah->AtasNama->FldCaption() ?></label>
		<div class="<?php echo $t01_nasabah_add->RightColumnClass ?>"><div<?php echo $t01_nasabah->AtasNama->CellAttributes() ?>>
<span id="el_t01_nasabah_AtasNama">
<input type="text" data-table="t01_nasabah" data-field="x_AtasNama" data-page="2" name="x_AtasNama" id="x_AtasNama" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->AtasNama->getPlaceHolder()) ?>" value="<?php echo $t01_nasabah->AtasNama->EditValue ?>"<?php echo $t01_nasabah->AtasNama->EditAttributes() ?>>
</span>
<?php echo $t01_nasabah->AtasNama->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
			</div><!-- /multi-page accordion .box-body -->
		</div><!-- /multi-page accordion .panel-collapse -->
	</div><!-- /multi-page accordion .panel .box -->
	<div class="panel box<?php echo $t01_nasabah_add->MultiPages->PageStyle("3") ?>"><!-- multi-page accordion .panel .box -->
		<div class="box-header with-border">
			<h4 class="box-title">
				<a data-toggle="collapse" data-parent="<?php echo $t01_nasabah_add->MultiPages->Parent ?>" href="#tab_t01_nasabah3"><?php echo $t01_nasabah->PageCaption(3) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $t01_nasabah_add->MultiPages->PageStyle("3") ?>" id="tab_t01_nasabah3"><!-- multi-page accordion .panel-collapse -->
			<div class="box-body"><!-- multi-page accordion .box-body -->
<div class="ewAddDiv"><!-- page* -->
<?php if ($t01_nasabah->Pekerjaan->Visible) { // Pekerjaan ?>
	<div id="r_Pekerjaan" class="form-group">
		<label id="elh_t01_nasabah_Pekerjaan" for="x_Pekerjaan" class="<?php echo $t01_nasabah_add->LeftColumnClass ?>"><?php echo $t01_nasabah->Pekerjaan->FldCaption() ?></label>
		<div class="<?php echo $t01_nasabah_add->RightColumnClass ?>"><div<?php echo $t01_nasabah->Pekerjaan->CellAttributes() ?>>
<span id="el_t01_nasabah_Pekerjaan">
<input type="text" data-table="t01_nasabah" data-field="x_Pekerjaan" data-page="3" name="x_Pekerjaan" id="x_Pekerjaan" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->Pekerjaan->getPlaceHolder()) ?>" value="<?php echo $t01_nasabah->Pekerjaan->EditValue ?>"<?php echo $t01_nasabah->Pekerjaan->EditAttributes() ?>>
</span>
<?php echo $t01_nasabah->Pekerjaan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->Alamat->Visible) { // Alamat ?>
	<div id="r_Alamat" class="form-group">
		<label id="elh_t01_nasabah_Alamat" for="x_Alamat" class="<?php echo $t01_nasabah_add->LeftColumnClass ?>"><?php echo $t01_nasabah->Alamat->FldCaption() ?></label>
		<div class="<?php echo $t01_nasabah_add->RightColumnClass ?>"><div<?php echo $t01_nasabah->Alamat->CellAttributes() ?>>
<span id="el_t01_nasabah_Alamat">
<textarea data-table="t01_nasabah" data-field="x_Alamat" data-page="3" name="x_Alamat" id="x_Alamat" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->Alamat->getPlaceHolder()) ?>"<?php echo $t01_nasabah->Alamat->EditAttributes() ?>><?php echo $t01_nasabah->Alamat->EditValue ?></textarea>
</span>
<?php echo $t01_nasabah->Alamat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->NoTelpHp->Visible) { // NoTelpHp ?>
	<div id="r_NoTelpHp" class="form-group">
		<label id="elh_t01_nasabah_NoTelpHp" for="x_NoTelpHp" class="<?php echo $t01_nasabah_add->LeftColumnClass ?>"><?php echo $t01_nasabah->NoTelpHp->FldCaption() ?></label>
		<div class="<?php echo $t01_nasabah_add->RightColumnClass ?>"><div<?php echo $t01_nasabah->NoTelpHp->CellAttributes() ?>>
<span id="el_t01_nasabah_NoTelpHp">
<input type="text" data-table="t01_nasabah" data-field="x_NoTelpHp" data-page="3" name="x_NoTelpHp" id="x_NoTelpHp" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->NoTelpHp->getPlaceHolder()) ?>" value="<?php echo $t01_nasabah->NoTelpHp->EditValue ?>"<?php echo $t01_nasabah->NoTelpHp->EditAttributes() ?>>
</span>
<?php echo $t01_nasabah->NoTelpHp->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
			</div><!-- /multi-page accordion .box-body -->
		</div><!-- /multi-page accordion .panel-collapse -->
	</div><!-- /multi-page accordion .panel .box -->
</div><!-- /multi-page accordion .box-group -->
</div><!-- /multi-page -->
<?php
	if (in_array("t02_angsuran", explode(",", $t01_nasabah->getCurrentDetailTable())) && $t02_angsuran->DetailAdd) {
?>
<?php if ($t01_nasabah->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("t02_angsuran", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "t02_angsurangrid.php" ?>
<?php } ?>
<?php if (!$t01_nasabah_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $t01_nasabah_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t01_nasabah_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
ft01_nasabahadd.Init();
</script>
<?php
$t01_nasabah_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t01_nasabah_add->Page_Terminate();
?>
