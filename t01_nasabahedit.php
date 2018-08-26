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

$t01_nasabah_edit = NULL; // Initialize page object first

class ct01_nasabah_edit extends ct01_nasabah {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{B3698D9B-8D4B-412E-A2E5-AFAD2FEE5A23}';

	// Table name
	var $TableName = 't01_nasabah';

	// Page object name
	var $PageObjName = 't01_nasabah_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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
		if (!$Security->CanEdit()) {
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
		$this->id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->id->Visible = FALSE;
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
					$this->Page_Terminate("t01_nasabahlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "t01_nasabahlist.php")
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
			$this->TglKontrak->CurrentValue = ew_UnFormatDateTime($this->TglKontrak->CurrentValue, 0);
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
		$this->id->CurrentValue = $this->id->FormValue;
		$this->NoKontrak->CurrentValue = $this->NoKontrak->FormValue;
		$this->Customer->CurrentValue = $this->Customer->FormValue;
		$this->Pekerjaan->CurrentValue = $this->Pekerjaan->FormValue;
		$this->Alamat->CurrentValue = $this->Alamat->FormValue;
		$this->NoTelpHp->CurrentValue = $this->NoTelpHp->FormValue;
		$this->TglKontrak->CurrentValue = $this->TglKontrak->FormValue;
		$this->TglKontrak->CurrentValue = ew_UnFormatDateTime($this->TglKontrak->CurrentValue, 0);
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

		// Keterangan
		$this->Keterangan->ViewValue = $this->Keterangan->CurrentValue;
		$this->Keterangan->ViewCustomAttributes = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

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
			$this->TglKontrak->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->TglKontrak->CurrentValue, 8));
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
			if (strval($this->Pinjaman->EditValue) <> "" && is_numeric($this->Pinjaman->EditValue)) $this->Pinjaman->EditValue = ew_FormatNumber($this->Pinjaman->EditValue, -2, -1, -2, 0);

			// Denda
			$this->Denda->EditAttrs["class"] = "form-control";
			$this->Denda->EditCustomAttributes = "";
			$this->Denda->EditValue = ew_HtmlEncode($this->Denda->CurrentValue);
			$this->Denda->PlaceHolder = ew_RemoveHtml($this->Denda->FldCaption());
			if (strval($this->Denda->EditValue) <> "" && is_numeric($this->Denda->EditValue)) $this->Denda->EditValue = ew_FormatNumber($this->Denda->EditValue, -2, -1, -2, 0);

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
			if (strval($this->JumlahAngsuran->EditValue) <> "" && is_numeric($this->JumlahAngsuran->EditValue)) $this->JumlahAngsuran->EditValue = ew_FormatNumber($this->JumlahAngsuran->EditValue, -2, -1, -2, 0);

			// Edit refer script
			// id

			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";

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
		if (!ew_CheckDateDef($this->TglKontrak->FormValue)) {
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

			// Customer
			$this->Customer->SetDbValueDef($rsnew, $this->Customer->CurrentValue, "", $this->Customer->ReadOnly);

			// Pekerjaan
			$this->Pekerjaan->SetDbValueDef($rsnew, $this->Pekerjaan->CurrentValue, NULL, $this->Pekerjaan->ReadOnly);

			// Alamat
			$this->Alamat->SetDbValueDef($rsnew, $this->Alamat->CurrentValue, NULL, $this->Alamat->ReadOnly);

			// NoTelpHp
			$this->NoTelpHp->SetDbValueDef($rsnew, $this->NoTelpHp->CurrentValue, NULL, $this->NoTelpHp->ReadOnly);

			// TglKontrak
			$this->TglKontrak->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->TglKontrak->CurrentValue, 0), ew_CurrentDate(), $this->TglKontrak->ReadOnly);

			// MerkType
			$this->MerkType->SetDbValueDef($rsnew, $this->MerkType->CurrentValue, "", $this->MerkType->ReadOnly);

			// NoRangka
			$this->NoRangka->SetDbValueDef($rsnew, $this->NoRangka->CurrentValue, NULL, $this->NoRangka->ReadOnly);

			// NoMesin
			$this->NoMesin->SetDbValueDef($rsnew, $this->NoMesin->CurrentValue, NULL, $this->NoMesin->ReadOnly);

			// Warna
			$this->Warna->SetDbValueDef($rsnew, $this->Warna->CurrentValue, NULL, $this->Warna->ReadOnly);

			// NoPol
			$this->NoPol->SetDbValueDef($rsnew, $this->NoPol->CurrentValue, NULL, $this->NoPol->ReadOnly);

			// Keterangan
			$this->Keterangan->SetDbValueDef($rsnew, $this->Keterangan->CurrentValue, NULL, $this->Keterangan->ReadOnly);

			// AtasNama
			$this->AtasNama->SetDbValueDef($rsnew, $this->AtasNama->CurrentValue, NULL, $this->AtasNama->ReadOnly);

			// Pinjaman
			$this->Pinjaman->SetDbValueDef($rsnew, $this->Pinjaman->CurrentValue, 0, $this->Pinjaman->ReadOnly);

			// Denda
			$this->Denda->SetDbValueDef($rsnew, $this->Denda->CurrentValue, 0, $this->Denda->ReadOnly);

			// DispensasiDenda
			$this->DispensasiDenda->SetDbValueDef($rsnew, $this->DispensasiDenda->CurrentValue, 0, $this->DispensasiDenda->ReadOnly);

			// LamaAngsuran
			$this->LamaAngsuran->SetDbValueDef($rsnew, $this->LamaAngsuran->CurrentValue, 0, $this->LamaAngsuran->ReadOnly);

			// JumlahAngsuran
			$this->JumlahAngsuran->SetDbValueDef($rsnew, $this->JumlahAngsuran->CurrentValue, 0, $this->JumlahAngsuran->ReadOnly);

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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t01_nasabahlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($t01_nasabah_edit)) $t01_nasabah_edit = new ct01_nasabah_edit();

// Page init
$t01_nasabah_edit->Page_Init();

// Page main
$t01_nasabah_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t01_nasabah_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = ft01_nasabahedit = new ew_Form("ft01_nasabahedit", "edit");

// Validate form
ft01_nasabahedit.Validate = function() {
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
			if (elm && !ew_CheckDateDef(elm.value))
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
ft01_nasabahedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft01_nasabahedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t01_nasabah_edit->ShowPageHeader(); ?>
<?php
$t01_nasabah_edit->ShowMessage();
?>
<form name="ft01_nasabahedit" id="ft01_nasabahedit" class="<?php echo $t01_nasabah_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t01_nasabah_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t01_nasabah_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t01_nasabah">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($t01_nasabah_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($t01_nasabah->id->Visible) { // id ?>
	<div id="r_id" class="form-group">
		<label id="elh_t01_nasabah_id" class="<?php echo $t01_nasabah_edit->LeftColumnClass ?>"><?php echo $t01_nasabah->id->FldCaption() ?></label>
		<div class="<?php echo $t01_nasabah_edit->RightColumnClass ?>"><div<?php echo $t01_nasabah->id->CellAttributes() ?>>
<span id="el_t01_nasabah_id">
<span<?php echo $t01_nasabah->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t01_nasabah->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="t01_nasabah" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($t01_nasabah->id->CurrentValue) ?>">
<?php echo $t01_nasabah->id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->NoKontrak->Visible) { // NoKontrak ?>
	<div id="r_NoKontrak" class="form-group">
		<label id="elh_t01_nasabah_NoKontrak" for="x_NoKontrak" class="<?php echo $t01_nasabah_edit->LeftColumnClass ?>"><?php echo $t01_nasabah->NoKontrak->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_nasabah_edit->RightColumnClass ?>"><div<?php echo $t01_nasabah->NoKontrak->CellAttributes() ?>>
<span id="el_t01_nasabah_NoKontrak">
<input type="text" data-table="t01_nasabah" data-field="x_NoKontrak" name="x_NoKontrak" id="x_NoKontrak" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->NoKontrak->getPlaceHolder()) ?>" value="<?php echo $t01_nasabah->NoKontrak->EditValue ?>"<?php echo $t01_nasabah->NoKontrak->EditAttributes() ?>>
</span>
<?php echo $t01_nasabah->NoKontrak->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->Customer->Visible) { // Customer ?>
	<div id="r_Customer" class="form-group">
		<label id="elh_t01_nasabah_Customer" for="x_Customer" class="<?php echo $t01_nasabah_edit->LeftColumnClass ?>"><?php echo $t01_nasabah->Customer->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_nasabah_edit->RightColumnClass ?>"><div<?php echo $t01_nasabah->Customer->CellAttributes() ?>>
<span id="el_t01_nasabah_Customer">
<input type="text" data-table="t01_nasabah" data-field="x_Customer" name="x_Customer" id="x_Customer" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->Customer->getPlaceHolder()) ?>" value="<?php echo $t01_nasabah->Customer->EditValue ?>"<?php echo $t01_nasabah->Customer->EditAttributes() ?>>
</span>
<?php echo $t01_nasabah->Customer->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->Pekerjaan->Visible) { // Pekerjaan ?>
	<div id="r_Pekerjaan" class="form-group">
		<label id="elh_t01_nasabah_Pekerjaan" for="x_Pekerjaan" class="<?php echo $t01_nasabah_edit->LeftColumnClass ?>"><?php echo $t01_nasabah->Pekerjaan->FldCaption() ?></label>
		<div class="<?php echo $t01_nasabah_edit->RightColumnClass ?>"><div<?php echo $t01_nasabah->Pekerjaan->CellAttributes() ?>>
<span id="el_t01_nasabah_Pekerjaan">
<input type="text" data-table="t01_nasabah" data-field="x_Pekerjaan" name="x_Pekerjaan" id="x_Pekerjaan" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->Pekerjaan->getPlaceHolder()) ?>" value="<?php echo $t01_nasabah->Pekerjaan->EditValue ?>"<?php echo $t01_nasabah->Pekerjaan->EditAttributes() ?>>
</span>
<?php echo $t01_nasabah->Pekerjaan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->Alamat->Visible) { // Alamat ?>
	<div id="r_Alamat" class="form-group">
		<label id="elh_t01_nasabah_Alamat" for="x_Alamat" class="<?php echo $t01_nasabah_edit->LeftColumnClass ?>"><?php echo $t01_nasabah->Alamat->FldCaption() ?></label>
		<div class="<?php echo $t01_nasabah_edit->RightColumnClass ?>"><div<?php echo $t01_nasabah->Alamat->CellAttributes() ?>>
<span id="el_t01_nasabah_Alamat">
<textarea data-table="t01_nasabah" data-field="x_Alamat" name="x_Alamat" id="x_Alamat" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->Alamat->getPlaceHolder()) ?>"<?php echo $t01_nasabah->Alamat->EditAttributes() ?>><?php echo $t01_nasabah->Alamat->EditValue ?></textarea>
</span>
<?php echo $t01_nasabah->Alamat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->NoTelpHp->Visible) { // NoTelpHp ?>
	<div id="r_NoTelpHp" class="form-group">
		<label id="elh_t01_nasabah_NoTelpHp" for="x_NoTelpHp" class="<?php echo $t01_nasabah_edit->LeftColumnClass ?>"><?php echo $t01_nasabah->NoTelpHp->FldCaption() ?></label>
		<div class="<?php echo $t01_nasabah_edit->RightColumnClass ?>"><div<?php echo $t01_nasabah->NoTelpHp->CellAttributes() ?>>
<span id="el_t01_nasabah_NoTelpHp">
<input type="text" data-table="t01_nasabah" data-field="x_NoTelpHp" name="x_NoTelpHp" id="x_NoTelpHp" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->NoTelpHp->getPlaceHolder()) ?>" value="<?php echo $t01_nasabah->NoTelpHp->EditValue ?>"<?php echo $t01_nasabah->NoTelpHp->EditAttributes() ?>>
</span>
<?php echo $t01_nasabah->NoTelpHp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->TglKontrak->Visible) { // TglKontrak ?>
	<div id="r_TglKontrak" class="form-group">
		<label id="elh_t01_nasabah_TglKontrak" for="x_TglKontrak" class="<?php echo $t01_nasabah_edit->LeftColumnClass ?>"><?php echo $t01_nasabah->TglKontrak->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_nasabah_edit->RightColumnClass ?>"><div<?php echo $t01_nasabah->TglKontrak->CellAttributes() ?>>
<span id="el_t01_nasabah_TglKontrak">
<input type="text" data-table="t01_nasabah" data-field="x_TglKontrak" name="x_TglKontrak" id="x_TglKontrak" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->TglKontrak->getPlaceHolder()) ?>" value="<?php echo $t01_nasabah->TglKontrak->EditValue ?>"<?php echo $t01_nasabah->TglKontrak->EditAttributes() ?>>
</span>
<?php echo $t01_nasabah->TglKontrak->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->MerkType->Visible) { // MerkType ?>
	<div id="r_MerkType" class="form-group">
		<label id="elh_t01_nasabah_MerkType" for="x_MerkType" class="<?php echo $t01_nasabah_edit->LeftColumnClass ?>"><?php echo $t01_nasabah->MerkType->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_nasabah_edit->RightColumnClass ?>"><div<?php echo $t01_nasabah->MerkType->CellAttributes() ?>>
<span id="el_t01_nasabah_MerkType">
<input type="text" data-table="t01_nasabah" data-field="x_MerkType" name="x_MerkType" id="x_MerkType" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->MerkType->getPlaceHolder()) ?>" value="<?php echo $t01_nasabah->MerkType->EditValue ?>"<?php echo $t01_nasabah->MerkType->EditAttributes() ?>>
</span>
<?php echo $t01_nasabah->MerkType->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->NoRangka->Visible) { // NoRangka ?>
	<div id="r_NoRangka" class="form-group">
		<label id="elh_t01_nasabah_NoRangka" for="x_NoRangka" class="<?php echo $t01_nasabah_edit->LeftColumnClass ?>"><?php echo $t01_nasabah->NoRangka->FldCaption() ?></label>
		<div class="<?php echo $t01_nasabah_edit->RightColumnClass ?>"><div<?php echo $t01_nasabah->NoRangka->CellAttributes() ?>>
<span id="el_t01_nasabah_NoRangka">
<input type="text" data-table="t01_nasabah" data-field="x_NoRangka" name="x_NoRangka" id="x_NoRangka" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->NoRangka->getPlaceHolder()) ?>" value="<?php echo $t01_nasabah->NoRangka->EditValue ?>"<?php echo $t01_nasabah->NoRangka->EditAttributes() ?>>
</span>
<?php echo $t01_nasabah->NoRangka->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->NoMesin->Visible) { // NoMesin ?>
	<div id="r_NoMesin" class="form-group">
		<label id="elh_t01_nasabah_NoMesin" for="x_NoMesin" class="<?php echo $t01_nasabah_edit->LeftColumnClass ?>"><?php echo $t01_nasabah->NoMesin->FldCaption() ?></label>
		<div class="<?php echo $t01_nasabah_edit->RightColumnClass ?>"><div<?php echo $t01_nasabah->NoMesin->CellAttributes() ?>>
<span id="el_t01_nasabah_NoMesin">
<input type="text" data-table="t01_nasabah" data-field="x_NoMesin" name="x_NoMesin" id="x_NoMesin" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->NoMesin->getPlaceHolder()) ?>" value="<?php echo $t01_nasabah->NoMesin->EditValue ?>"<?php echo $t01_nasabah->NoMesin->EditAttributes() ?>>
</span>
<?php echo $t01_nasabah->NoMesin->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->Warna->Visible) { // Warna ?>
	<div id="r_Warna" class="form-group">
		<label id="elh_t01_nasabah_Warna" for="x_Warna" class="<?php echo $t01_nasabah_edit->LeftColumnClass ?>"><?php echo $t01_nasabah->Warna->FldCaption() ?></label>
		<div class="<?php echo $t01_nasabah_edit->RightColumnClass ?>"><div<?php echo $t01_nasabah->Warna->CellAttributes() ?>>
<span id="el_t01_nasabah_Warna">
<input type="text" data-table="t01_nasabah" data-field="x_Warna" name="x_Warna" id="x_Warna" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->Warna->getPlaceHolder()) ?>" value="<?php echo $t01_nasabah->Warna->EditValue ?>"<?php echo $t01_nasabah->Warna->EditAttributes() ?>>
</span>
<?php echo $t01_nasabah->Warna->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->NoPol->Visible) { // NoPol ?>
	<div id="r_NoPol" class="form-group">
		<label id="elh_t01_nasabah_NoPol" for="x_NoPol" class="<?php echo $t01_nasabah_edit->LeftColumnClass ?>"><?php echo $t01_nasabah->NoPol->FldCaption() ?></label>
		<div class="<?php echo $t01_nasabah_edit->RightColumnClass ?>"><div<?php echo $t01_nasabah->NoPol->CellAttributes() ?>>
<span id="el_t01_nasabah_NoPol">
<input type="text" data-table="t01_nasabah" data-field="x_NoPol" name="x_NoPol" id="x_NoPol" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->NoPol->getPlaceHolder()) ?>" value="<?php echo $t01_nasabah->NoPol->EditValue ?>"<?php echo $t01_nasabah->NoPol->EditAttributes() ?>>
</span>
<?php echo $t01_nasabah->NoPol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->Keterangan->Visible) { // Keterangan ?>
	<div id="r_Keterangan" class="form-group">
		<label id="elh_t01_nasabah_Keterangan" for="x_Keterangan" class="<?php echo $t01_nasabah_edit->LeftColumnClass ?>"><?php echo $t01_nasabah->Keterangan->FldCaption() ?></label>
		<div class="<?php echo $t01_nasabah_edit->RightColumnClass ?>"><div<?php echo $t01_nasabah->Keterangan->CellAttributes() ?>>
<span id="el_t01_nasabah_Keterangan">
<textarea data-table="t01_nasabah" data-field="x_Keterangan" name="x_Keterangan" id="x_Keterangan" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->Keterangan->getPlaceHolder()) ?>"<?php echo $t01_nasabah->Keterangan->EditAttributes() ?>><?php echo $t01_nasabah->Keterangan->EditValue ?></textarea>
</span>
<?php echo $t01_nasabah->Keterangan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->AtasNama->Visible) { // AtasNama ?>
	<div id="r_AtasNama" class="form-group">
		<label id="elh_t01_nasabah_AtasNama" for="x_AtasNama" class="<?php echo $t01_nasabah_edit->LeftColumnClass ?>"><?php echo $t01_nasabah->AtasNama->FldCaption() ?></label>
		<div class="<?php echo $t01_nasabah_edit->RightColumnClass ?>"><div<?php echo $t01_nasabah->AtasNama->CellAttributes() ?>>
<span id="el_t01_nasabah_AtasNama">
<input type="text" data-table="t01_nasabah" data-field="x_AtasNama" name="x_AtasNama" id="x_AtasNama" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->AtasNama->getPlaceHolder()) ?>" value="<?php echo $t01_nasabah->AtasNama->EditValue ?>"<?php echo $t01_nasabah->AtasNama->EditAttributes() ?>>
</span>
<?php echo $t01_nasabah->AtasNama->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->Pinjaman->Visible) { // Pinjaman ?>
	<div id="r_Pinjaman" class="form-group">
		<label id="elh_t01_nasabah_Pinjaman" for="x_Pinjaman" class="<?php echo $t01_nasabah_edit->LeftColumnClass ?>"><?php echo $t01_nasabah->Pinjaman->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_nasabah_edit->RightColumnClass ?>"><div<?php echo $t01_nasabah->Pinjaman->CellAttributes() ?>>
<span id="el_t01_nasabah_Pinjaman">
<input type="text" data-table="t01_nasabah" data-field="x_Pinjaman" name="x_Pinjaman" id="x_Pinjaman" size="30" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->Pinjaman->getPlaceHolder()) ?>" value="<?php echo $t01_nasabah->Pinjaman->EditValue ?>"<?php echo $t01_nasabah->Pinjaman->EditAttributes() ?>>
</span>
<?php echo $t01_nasabah->Pinjaman->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->Denda->Visible) { // Denda ?>
	<div id="r_Denda" class="form-group">
		<label id="elh_t01_nasabah_Denda" for="x_Denda" class="<?php echo $t01_nasabah_edit->LeftColumnClass ?>"><?php echo $t01_nasabah->Denda->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_nasabah_edit->RightColumnClass ?>"><div<?php echo $t01_nasabah->Denda->CellAttributes() ?>>
<span id="el_t01_nasabah_Denda">
<input type="text" data-table="t01_nasabah" data-field="x_Denda" name="x_Denda" id="x_Denda" size="30" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->Denda->getPlaceHolder()) ?>" value="<?php echo $t01_nasabah->Denda->EditValue ?>"<?php echo $t01_nasabah->Denda->EditAttributes() ?>>
</span>
<?php echo $t01_nasabah->Denda->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->DispensasiDenda->Visible) { // DispensasiDenda ?>
	<div id="r_DispensasiDenda" class="form-group">
		<label id="elh_t01_nasabah_DispensasiDenda" for="x_DispensasiDenda" class="<?php echo $t01_nasabah_edit->LeftColumnClass ?>"><?php echo $t01_nasabah->DispensasiDenda->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_nasabah_edit->RightColumnClass ?>"><div<?php echo $t01_nasabah->DispensasiDenda->CellAttributes() ?>>
<span id="el_t01_nasabah_DispensasiDenda">
<input type="text" data-table="t01_nasabah" data-field="x_DispensasiDenda" name="x_DispensasiDenda" id="x_DispensasiDenda" size="30" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->DispensasiDenda->getPlaceHolder()) ?>" value="<?php echo $t01_nasabah->DispensasiDenda->EditValue ?>"<?php echo $t01_nasabah->DispensasiDenda->EditAttributes() ?>>
</span>
<?php echo $t01_nasabah->DispensasiDenda->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->LamaAngsuran->Visible) { // LamaAngsuran ?>
	<div id="r_LamaAngsuran" class="form-group">
		<label id="elh_t01_nasabah_LamaAngsuran" for="x_LamaAngsuran" class="<?php echo $t01_nasabah_edit->LeftColumnClass ?>"><?php echo $t01_nasabah->LamaAngsuran->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_nasabah_edit->RightColumnClass ?>"><div<?php echo $t01_nasabah->LamaAngsuran->CellAttributes() ?>>
<span id="el_t01_nasabah_LamaAngsuran">
<input type="text" data-table="t01_nasabah" data-field="x_LamaAngsuran" name="x_LamaAngsuran" id="x_LamaAngsuran" size="30" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->LamaAngsuran->getPlaceHolder()) ?>" value="<?php echo $t01_nasabah->LamaAngsuran->EditValue ?>"<?php echo $t01_nasabah->LamaAngsuran->EditAttributes() ?>>
</span>
<?php echo $t01_nasabah->LamaAngsuran->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->JumlahAngsuran->Visible) { // JumlahAngsuran ?>
	<div id="r_JumlahAngsuran" class="form-group">
		<label id="elh_t01_nasabah_JumlahAngsuran" for="x_JumlahAngsuran" class="<?php echo $t01_nasabah_edit->LeftColumnClass ?>"><?php echo $t01_nasabah->JumlahAngsuran->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_nasabah_edit->RightColumnClass ?>"><div<?php echo $t01_nasabah->JumlahAngsuran->CellAttributes() ?>>
<span id="el_t01_nasabah_JumlahAngsuran">
<input type="text" data-table="t01_nasabah" data-field="x_JumlahAngsuran" name="x_JumlahAngsuran" id="x_JumlahAngsuran" size="30" placeholder="<?php echo ew_HtmlEncode($t01_nasabah->JumlahAngsuran->getPlaceHolder()) ?>" value="<?php echo $t01_nasabah->JumlahAngsuran->EditValue ?>"<?php echo $t01_nasabah->JumlahAngsuran->EditAttributes() ?>>
</span>
<?php echo $t01_nasabah->JumlahAngsuran->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$t01_nasabah_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $t01_nasabah_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t01_nasabah_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
ft01_nasabahedit.Init();
</script>
<?php
$t01_nasabah_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t01_nasabah_edit->Page_Terminate();
?>