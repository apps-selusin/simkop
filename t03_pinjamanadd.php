<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "t03_pinjamaninfo.php" ?>
<?php include_once "t96_employeesinfo.php" ?>
<?php include_once "t04_angsurangridcls.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$t03_pinjaman_add = NULL; // Initialize page object first

class ct03_pinjaman_add extends ct03_pinjaman {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{B3698D9B-8D4B-412E-A2E5-AFAD2FEE5A23}';

	// Table name
	var $TableName = 't03_pinjaman';

	// Page object name
	var $PageObjName = 't03_pinjaman_add';

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

		// Table object (t03_pinjaman)
		if (!isset($GLOBALS["t03_pinjaman"]) || get_class($GLOBALS["t03_pinjaman"]) == "ct03_pinjaman") {
			$GLOBALS["t03_pinjaman"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t03_pinjaman"];
		}

		// Table object (t96_employees)
		if (!isset($GLOBALS['t96_employees'])) $GLOBALS['t96_employees'] = new ct96_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't03_pinjaman', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("t03_pinjamanlist.php"));
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
		$this->TglKontrak->SetVisibility();
		$this->nasabah_id->SetVisibility();
		$this->jaminan_id->SetVisibility();
		$this->Pinjaman->SetVisibility();
		$this->Denda->SetVisibility();
		$this->DispensasiDenda->SetVisibility();
		$this->LamaAngsuran->SetVisibility();
		$this->JumlahAngsuran->SetVisibility();
		$this->NoKontrakRefTo->SetVisibility();

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
				if (in_array("t04_angsuran", $DetailTblVar)) {

					// Process auto fill for detail table 't04_angsuran'
					if (preg_match('/^ft04_angsuran(grid|add|addopt|edit|update|search)$/', @$_POST["form"])) {
						if (!isset($GLOBALS["t04_angsuran_grid"])) $GLOBALS["t04_angsuran_grid"] = new ct04_angsuran_grid;
						$GLOBALS["t04_angsuran_grid"]->Page_Init();
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
		global $EW_EXPORT, $t03_pinjaman;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t03_pinjaman);
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
					if ($pageName == "t03_pinjamanview.php")
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
					$this->Page_Terminate("t03_pinjamanlist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetupDetailParms();
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->GetViewUrl();
					if (ew_GetPageName($sReturnUrl) == "t03_pinjamanlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "t03_pinjamanview.php")
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
		$this->TglKontrak->CurrentValue = NULL;
		$this->TglKontrak->OldValue = $this->TglKontrak->CurrentValue;
		$this->nasabah_id->CurrentValue = NULL;
		$this->nasabah_id->OldValue = $this->nasabah_id->CurrentValue;
		$this->jaminan_id->CurrentValue = NULL;
		$this->jaminan_id->OldValue = $this->jaminan_id->CurrentValue;
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
		$this->NoKontrakRefTo->CurrentValue = NULL;
		$this->NoKontrakRefTo->OldValue = $this->NoKontrakRefTo->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->NoKontrak->FldIsDetailKey) {
			$this->NoKontrak->setFormValue($objForm->GetValue("x_NoKontrak"));
		}
		if (!$this->TglKontrak->FldIsDetailKey) {
			$this->TglKontrak->setFormValue($objForm->GetValue("x_TglKontrak"));
			$this->TglKontrak->CurrentValue = ew_UnFormatDateTime($this->TglKontrak->CurrentValue, 7);
		}
		if (!$this->nasabah_id->FldIsDetailKey) {
			$this->nasabah_id->setFormValue($objForm->GetValue("x_nasabah_id"));
		}
		if (!$this->jaminan_id->FldIsDetailKey) {
			$this->jaminan_id->setFormValue($objForm->GetValue("x_jaminan_id"));
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
		if (!$this->NoKontrakRefTo->FldIsDetailKey) {
			$this->NoKontrakRefTo->setFormValue($objForm->GetValue("x_NoKontrakRefTo"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->NoKontrak->CurrentValue = $this->NoKontrak->FormValue;
		$this->TglKontrak->CurrentValue = $this->TglKontrak->FormValue;
		$this->TglKontrak->CurrentValue = ew_UnFormatDateTime($this->TglKontrak->CurrentValue, 7);
		$this->nasabah_id->CurrentValue = $this->nasabah_id->FormValue;
		$this->jaminan_id->CurrentValue = $this->jaminan_id->FormValue;
		$this->Pinjaman->CurrentValue = $this->Pinjaman->FormValue;
		$this->Denda->CurrentValue = $this->Denda->FormValue;
		$this->DispensasiDenda->CurrentValue = $this->DispensasiDenda->FormValue;
		$this->LamaAngsuran->CurrentValue = $this->LamaAngsuran->FormValue;
		$this->JumlahAngsuran->CurrentValue = $this->JumlahAngsuran->FormValue;
		$this->NoKontrakRefTo->CurrentValue = $this->NoKontrakRefTo->FormValue;
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
		$this->TglKontrak->setDbValue($row['TglKontrak']);
		$this->nasabah_id->setDbValue($row['nasabah_id']);
		if (array_key_exists('EV__nasabah_id', $rs->fields)) {
			$this->nasabah_id->VirtualValue = $rs->fields('EV__nasabah_id'); // Set up virtual field value
		} else {
			$this->nasabah_id->VirtualValue = ""; // Clear value
		}
		$this->jaminan_id->setDbValue($row['jaminan_id']);
		if (array_key_exists('EV__jaminan_id', $rs->fields)) {
			$this->jaminan_id->VirtualValue = $rs->fields('EV__jaminan_id'); // Set up virtual field value
		} else {
			$this->jaminan_id->VirtualValue = ""; // Clear value
		}
		$this->Pinjaman->setDbValue($row['Pinjaman']);
		$this->Denda->setDbValue($row['Denda']);
		$this->DispensasiDenda->setDbValue($row['DispensasiDenda']);
		$this->LamaAngsuran->setDbValue($row['LamaAngsuran']);
		$this->JumlahAngsuran->setDbValue($row['JumlahAngsuran']);
		$this->NoKontrakRefTo->setDbValue($row['NoKontrakRefTo']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['id'] = $this->id->CurrentValue;
		$row['NoKontrak'] = $this->NoKontrak->CurrentValue;
		$row['TglKontrak'] = $this->TglKontrak->CurrentValue;
		$row['nasabah_id'] = $this->nasabah_id->CurrentValue;
		$row['jaminan_id'] = $this->jaminan_id->CurrentValue;
		$row['Pinjaman'] = $this->Pinjaman->CurrentValue;
		$row['Denda'] = $this->Denda->CurrentValue;
		$row['DispensasiDenda'] = $this->DispensasiDenda->CurrentValue;
		$row['LamaAngsuran'] = $this->LamaAngsuran->CurrentValue;
		$row['JumlahAngsuran'] = $this->JumlahAngsuran->CurrentValue;
		$row['NoKontrakRefTo'] = $this->NoKontrakRefTo->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->NoKontrak->DbValue = $row['NoKontrak'];
		$this->TglKontrak->DbValue = $row['TglKontrak'];
		$this->nasabah_id->DbValue = $row['nasabah_id'];
		$this->jaminan_id->DbValue = $row['jaminan_id'];
		$this->Pinjaman->DbValue = $row['Pinjaman'];
		$this->Denda->DbValue = $row['Denda'];
		$this->DispensasiDenda->DbValue = $row['DispensasiDenda'];
		$this->LamaAngsuran->DbValue = $row['LamaAngsuran'];
		$this->JumlahAngsuran->DbValue = $row['JumlahAngsuran'];
		$this->NoKontrakRefTo->DbValue = $row['NoKontrakRefTo'];
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
		// TglKontrak
		// nasabah_id
		// jaminan_id
		// Pinjaman
		// Denda
		// DispensasiDenda
		// LamaAngsuran
		// JumlahAngsuran
		// NoKontrakRefTo

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// NoKontrak
		$this->NoKontrak->ViewValue = $this->NoKontrak->CurrentValue;
		$this->NoKontrak->ViewCustomAttributes = "";

		// TglKontrak
		$this->TglKontrak->ViewValue = $this->TglKontrak->CurrentValue;
		$this->TglKontrak->ViewValue = ew_FormatDateTime($this->TglKontrak->ViewValue, 7);
		$this->TglKontrak->ViewCustomAttributes = "";

		// nasabah_id
		if ($this->nasabah_id->VirtualValue <> "") {
			$this->nasabah_id->ViewValue = $this->nasabah_id->VirtualValue;
		} else {
		if (strval($this->nasabah_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->nasabah_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `Customer` AS `DispFld`, `NoTelpHp` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t01_nasabah`";
		$sWhereWrk = "";
		$this->nasabah_id->LookupFilters = array("dx1" => '`Customer`', "dx2" => '`NoTelpHp`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->nasabah_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->nasabah_id->ViewValue = $this->nasabah_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->nasabah_id->ViewValue = $this->nasabah_id->CurrentValue;
			}
		} else {
			$this->nasabah_id->ViewValue = NULL;
		}
		}
		$this->nasabah_id->ViewCustomAttributes = "";

		// jaminan_id
		if ($this->jaminan_id->VirtualValue <> "") {
			$this->jaminan_id->ViewValue = $this->jaminan_id->VirtualValue;
		} else {
		if (strval($this->jaminan_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->jaminan_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `MerkType` AS `DispFld`, `NoPol` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t02_jaminan`";
		$sWhereWrk = "";
		$this->jaminan_id->LookupFilters = array("dx1" => '`MerkType`', "dx2" => '`NoPol`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->jaminan_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->jaminan_id->ViewValue = $this->jaminan_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->jaminan_id->ViewValue = $this->jaminan_id->CurrentValue;
			}
		} else {
			$this->jaminan_id->ViewValue = NULL;
		}
		}
		$this->jaminan_id->ViewCustomAttributes = "";

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
		$this->DispensasiDenda->ViewValue = ew_FormatNumber($this->DispensasiDenda->ViewValue, 0, -2, -2, -2);
		$this->DispensasiDenda->CellCssStyle .= "text-align: right;";
		$this->DispensasiDenda->ViewCustomAttributes = "";

		// LamaAngsuran
		$this->LamaAngsuran->ViewValue = $this->LamaAngsuran->CurrentValue;
		$this->LamaAngsuran->ViewValue = ew_FormatNumber($this->LamaAngsuran->ViewValue, 0, -2, -2, -2);
		$this->LamaAngsuran->CellCssStyle .= "text-align: right;";
		$this->LamaAngsuran->ViewCustomAttributes = "";

		// JumlahAngsuran
		$this->JumlahAngsuran->ViewValue = $this->JumlahAngsuran->CurrentValue;
		$this->JumlahAngsuran->ViewValue = ew_FormatNumber($this->JumlahAngsuran->ViewValue, 2, -2, -2, -2);
		$this->JumlahAngsuran->CellCssStyle .= "text-align: right;";
		$this->JumlahAngsuran->ViewCustomAttributes = "";

		// NoKontrakRefTo
		$this->NoKontrakRefTo->ViewValue = $this->NoKontrakRefTo->CurrentValue;
		$this->NoKontrakRefTo->ViewCustomAttributes = "";

			// NoKontrak
			$this->NoKontrak->LinkCustomAttributes = "";
			$this->NoKontrak->HrefValue = "";
			$this->NoKontrak->TooltipValue = "";

			// TglKontrak
			$this->TglKontrak->LinkCustomAttributes = "";
			$this->TglKontrak->HrefValue = "";
			$this->TglKontrak->TooltipValue = "";

			// nasabah_id
			$this->nasabah_id->LinkCustomAttributes = "";
			$this->nasabah_id->HrefValue = "";
			$this->nasabah_id->TooltipValue = "";

			// jaminan_id
			$this->jaminan_id->LinkCustomAttributes = "";
			$this->jaminan_id->HrefValue = "";
			$this->jaminan_id->TooltipValue = "";

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

			// NoKontrakRefTo
			$this->NoKontrakRefTo->LinkCustomAttributes = "";
			$this->NoKontrakRefTo->HrefValue = "";
			$this->NoKontrakRefTo->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// NoKontrak
			$this->NoKontrak->EditAttrs["class"] = "form-control";
			$this->NoKontrak->EditCustomAttributes = "";
			$this->NoKontrak->EditValue = ew_HtmlEncode($this->NoKontrak->CurrentValue);
			$this->NoKontrak->PlaceHolder = ew_RemoveHtml($this->NoKontrak->FldCaption());

			// TglKontrak
			$this->TglKontrak->EditAttrs["class"] = "form-control";
			$this->TglKontrak->EditCustomAttributes = "";
			$this->TglKontrak->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->TglKontrak->CurrentValue, 7));
			$this->TglKontrak->PlaceHolder = ew_RemoveHtml($this->TglKontrak->FldCaption());

			// nasabah_id
			$this->nasabah_id->EditCustomAttributes = "";
			if (trim(strval($this->nasabah_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->nasabah_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `Customer` AS `DispFld`, `NoTelpHp` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `t01_nasabah`";
			$sWhereWrk = "";
			$this->nasabah_id->LookupFilters = array("dx1" => '`Customer`', "dx2" => '`NoTelpHp`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->nasabah_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
				$this->nasabah_id->ViewValue = $this->nasabah_id->DisplayValue($arwrk);
			} else {
				$this->nasabah_id->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->nasabah_id->EditValue = $arwrk;

			// jaminan_id
			$this->jaminan_id->EditCustomAttributes = "";
			if (trim(strval($this->jaminan_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->jaminan_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `MerkType` AS `DispFld`, `NoPol` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `t02_jaminan`";
			$sWhereWrk = "";
			$this->jaminan_id->LookupFilters = array("dx1" => '`MerkType`', "dx2" => '`NoPol`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->jaminan_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
				$this->jaminan_id->ViewValue = $this->jaminan_id->DisplayValue($arwrk);
			} else {
				$this->jaminan_id->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->jaminan_id->EditValue = $arwrk;

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

			// NoKontrakRefTo
			$this->NoKontrakRefTo->EditAttrs["class"] = "form-control";
			$this->NoKontrakRefTo->EditCustomAttributes = "";
			$this->NoKontrakRefTo->EditValue = ew_HtmlEncode($this->NoKontrakRefTo->CurrentValue);
			$this->NoKontrakRefTo->PlaceHolder = ew_RemoveHtml($this->NoKontrakRefTo->FldCaption());

			// Add refer script
			// NoKontrak

			$this->NoKontrak->LinkCustomAttributes = "";
			$this->NoKontrak->HrefValue = "";

			// TglKontrak
			$this->TglKontrak->LinkCustomAttributes = "";
			$this->TglKontrak->HrefValue = "";

			// nasabah_id
			$this->nasabah_id->LinkCustomAttributes = "";
			$this->nasabah_id->HrefValue = "";

			// jaminan_id
			$this->jaminan_id->LinkCustomAttributes = "";
			$this->jaminan_id->HrefValue = "";

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

			// NoKontrakRefTo
			$this->NoKontrakRefTo->LinkCustomAttributes = "";
			$this->NoKontrakRefTo->HrefValue = "";
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
		if (!$this->TglKontrak->FldIsDetailKey && !is_null($this->TglKontrak->FormValue) && $this->TglKontrak->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->TglKontrak->FldCaption(), $this->TglKontrak->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->TglKontrak->FormValue)) {
			ew_AddMessage($gsFormError, $this->TglKontrak->FldErrMsg());
		}
		if (!$this->nasabah_id->FldIsDetailKey && !is_null($this->nasabah_id->FormValue) && $this->nasabah_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nasabah_id->FldCaption(), $this->nasabah_id->ReqErrMsg));
		}
		if (!$this->jaminan_id->FldIsDetailKey && !is_null($this->jaminan_id->FormValue) && $this->jaminan_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->jaminan_id->FldCaption(), $this->jaminan_id->ReqErrMsg));
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
		if (!ew_CheckInteger($this->NoKontrakRefTo->FormValue)) {
			ew_AddMessage($gsFormError, $this->NoKontrakRefTo->FldErrMsg());
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("t04_angsuran", $DetailTblVar) && $GLOBALS["t04_angsuran"]->DetailAdd) {
			if (!isset($GLOBALS["t04_angsuran_grid"])) $GLOBALS["t04_angsuran_grid"] = new ct04_angsuran_grid(); // get detail page object
			$GLOBALS["t04_angsuran_grid"]->ValidateGridForm();
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

		// TglKontrak
		$this->TglKontrak->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->TglKontrak->CurrentValue, 7), ew_CurrentDate(), FALSE);

		// nasabah_id
		$this->nasabah_id->SetDbValueDef($rsnew, $this->nasabah_id->CurrentValue, 0, FALSE);

		// jaminan_id
		$this->jaminan_id->SetDbValueDef($rsnew, $this->jaminan_id->CurrentValue, 0, FALSE);

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

		// NoKontrakRefTo
		$this->NoKontrakRefTo->SetDbValueDef($rsnew, $this->NoKontrakRefTo->CurrentValue, NULL, FALSE);

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
			if (in_array("t04_angsuran", $DetailTblVar) && $GLOBALS["t04_angsuran"]->DetailAdd) {
				$GLOBALS["t04_angsuran"]->pinjaman_id->setSessionValue($this->id->CurrentValue); // Set master key
				if (!isset($GLOBALS["t04_angsuran_grid"])) $GLOBALS["t04_angsuran_grid"] = new ct04_angsuran_grid(); // Get detail page object
				$Security->LoadCurrentUserLevel($this->ProjectID . "t04_angsuran"); // Load user level of detail table
				$AddRow = $GLOBALS["t04_angsuran_grid"]->GridInsert();
				$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$AddRow)
					$GLOBALS["t04_angsuran"]->pinjaman_id->setSessionValue(""); // Clear master key if insert failed
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
			if (in_array("t04_angsuran", $DetailTblVar)) {
				if (!isset($GLOBALS["t04_angsuran_grid"]))
					$GLOBALS["t04_angsuran_grid"] = new ct04_angsuran_grid;
				if ($GLOBALS["t04_angsuran_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["t04_angsuran_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["t04_angsuran_grid"]->CurrentMode = "add";
					$GLOBALS["t04_angsuran_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["t04_angsuran_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["t04_angsuran_grid"]->setStartRecordNumber(1);
					$GLOBALS["t04_angsuran_grid"]->pinjaman_id->FldIsDetailKey = TRUE;
					$GLOBALS["t04_angsuran_grid"]->pinjaman_id->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["t04_angsuran_grid"]->pinjaman_id->setSessionValue($GLOBALS["t04_angsuran_grid"]->pinjaman_id->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t03_pinjamanlist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_nasabah_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `Customer` AS `DispFld`, `NoTelpHp` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t01_nasabah`";
			$sWhereWrk = "{filter}";
			$fld->LookupFilters = array("dx1" => '`Customer`', "dx2" => '`NoTelpHp`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->nasabah_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_jaminan_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `MerkType` AS `DispFld`, `NoPol` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t02_jaminan`";
			$sWhereWrk = "{filter}";
			$fld->LookupFilters = array("dx1" => '`MerkType`', "dx2" => '`NoPol`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->jaminan_id, $sWhereWrk); // Call Lookup Selecting
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
if (!isset($t03_pinjaman_add)) $t03_pinjaman_add = new ct03_pinjaman_add();

// Page init
$t03_pinjaman_add->Page_Init();

// Page main
$t03_pinjaman_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t03_pinjaman_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ft03_pinjamanadd = new ew_Form("ft03_pinjamanadd", "add");

// Validate form
ft03_pinjamanadd.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t03_pinjaman->NoKontrak->FldCaption(), $t03_pinjaman->NoKontrak->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_TglKontrak");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t03_pinjaman->TglKontrak->FldCaption(), $t03_pinjaman->TglKontrak->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_TglKontrak");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t03_pinjaman->TglKontrak->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_nasabah_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t03_pinjaman->nasabah_id->FldCaption(), $t03_pinjaman->nasabah_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_jaminan_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t03_pinjaman->jaminan_id->FldCaption(), $t03_pinjaman->jaminan_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Pinjaman");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t03_pinjaman->Pinjaman->FldCaption(), $t03_pinjaman->Pinjaman->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Pinjaman");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t03_pinjaman->Pinjaman->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Denda");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t03_pinjaman->Denda->FldCaption(), $t03_pinjaman->Denda->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Denda");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t03_pinjaman->Denda->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_DispensasiDenda");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t03_pinjaman->DispensasiDenda->FldCaption(), $t03_pinjaman->DispensasiDenda->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_DispensasiDenda");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t03_pinjaman->DispensasiDenda->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_LamaAngsuran");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t03_pinjaman->LamaAngsuran->FldCaption(), $t03_pinjaman->LamaAngsuran->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_LamaAngsuran");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t03_pinjaman->LamaAngsuran->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_JumlahAngsuran");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t03_pinjaman->JumlahAngsuran->FldCaption(), $t03_pinjaman->JumlahAngsuran->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_JumlahAngsuran");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t03_pinjaman->JumlahAngsuran->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_NoKontrakRefTo");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t03_pinjaman->NoKontrakRefTo->FldErrMsg()) ?>");

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
ft03_pinjamanadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft03_pinjamanadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ft03_pinjamanadd.Lists["x_nasabah_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_Customer","x_NoTelpHp","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t01_nasabah"};
ft03_pinjamanadd.Lists["x_nasabah_id"].Data = "<?php echo $t03_pinjaman_add->nasabah_id->LookupFilterQuery(FALSE, "add") ?>";
ft03_pinjamanadd.Lists["x_jaminan_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_MerkType","x_NoPol","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t02_jaminan"};
ft03_pinjamanadd.Lists["x_jaminan_id"].Data = "<?php echo $t03_pinjaman_add->jaminan_id->LookupFilterQuery(FALSE, "add") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t03_pinjaman_add->ShowPageHeader(); ?>
<?php
$t03_pinjaman_add->ShowMessage();
?>
<form name="ft03_pinjamanadd" id="ft03_pinjamanadd" class="<?php echo $t03_pinjaman_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t03_pinjaman_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t03_pinjaman_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t03_pinjaman">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($t03_pinjaman_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($t03_pinjaman->NoKontrak->Visible) { // NoKontrak ?>
	<div id="r_NoKontrak" class="form-group">
		<label id="elh_t03_pinjaman_NoKontrak" for="x_NoKontrak" class="<?php echo $t03_pinjaman_add->LeftColumnClass ?>"><?php echo $t03_pinjaman->NoKontrak->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t03_pinjaman_add->RightColumnClass ?>"><div<?php echo $t03_pinjaman->NoKontrak->CellAttributes() ?>>
<span id="el_t03_pinjaman_NoKontrak">
<input type="text" data-table="t03_pinjaman" data-field="x_NoKontrak" name="x_NoKontrak" id="x_NoKontrak" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->NoKontrak->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->NoKontrak->EditValue ?>"<?php echo $t03_pinjaman->NoKontrak->EditAttributes() ?>>
</span>
<?php echo $t03_pinjaman->NoKontrak->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t03_pinjaman->TglKontrak->Visible) { // TglKontrak ?>
	<div id="r_TglKontrak" class="form-group">
		<label id="elh_t03_pinjaman_TglKontrak" for="x_TglKontrak" class="<?php echo $t03_pinjaman_add->LeftColumnClass ?>"><?php echo $t03_pinjaman->TglKontrak->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t03_pinjaman_add->RightColumnClass ?>"><div<?php echo $t03_pinjaman->TglKontrak->CellAttributes() ?>>
<span id="el_t03_pinjaman_TglKontrak">
<input type="text" data-table="t03_pinjaman" data-field="x_TglKontrak" data-format="7" name="x_TglKontrak" id="x_TglKontrak" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->TglKontrak->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->TglKontrak->EditValue ?>"<?php echo $t03_pinjaman->TglKontrak->EditAttributes() ?>>
<?php if (!$t03_pinjaman->TglKontrak->ReadOnly && !$t03_pinjaman->TglKontrak->Disabled && !isset($t03_pinjaman->TglKontrak->EditAttrs["readonly"]) && !isset($t03_pinjaman->TglKontrak->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateDateTimePicker("ft03_pinjamanadd", "x_TglKontrak", {"ignoreReadonly":true,"useCurrent":false,"format":7});
</script>
<?php } ?>
</span>
<?php echo $t03_pinjaman->TglKontrak->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t03_pinjaman->nasabah_id->Visible) { // nasabah_id ?>
	<div id="r_nasabah_id" class="form-group">
		<label id="elh_t03_pinjaman_nasabah_id" for="x_nasabah_id" class="<?php echo $t03_pinjaman_add->LeftColumnClass ?>"><?php echo $t03_pinjaman->nasabah_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t03_pinjaman_add->RightColumnClass ?>"><div<?php echo $t03_pinjaman->nasabah_id->CellAttributes() ?>>
<span id="el_t03_pinjaman_nasabah_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next(":not([disabled])").click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_nasabah_id"><?php echo (strval($t03_pinjaman->nasabah_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t03_pinjaman->nasabah_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t03_pinjaman->nasabah_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_nasabah_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t03_pinjaman->nasabah_id->ReadOnly || $t03_pinjaman->nasabah_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t03_pinjaman" data-field="x_nasabah_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t03_pinjaman->nasabah_id->DisplayValueSeparatorAttribute() ?>" name="x_nasabah_id" id="x_nasabah_id" value="<?php echo $t03_pinjaman->nasabah_id->CurrentValue ?>"<?php echo $t03_pinjaman->nasabah_id->EditAttributes() ?>>
<?php if (AllowAdd(CurrentProjectID() . "t01_nasabah") && !$t03_pinjaman->nasabah_id->ReadOnly) { ?>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $t03_pinjaman->nasabah_id->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x_nasabah_id',url:'t01_nasabahaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x_nasabah_id"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $t03_pinjaman->nasabah_id->FldCaption() ?></span></button>
<?php } ?>
</span>
<?php echo $t03_pinjaman->nasabah_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t03_pinjaman->jaminan_id->Visible) { // jaminan_id ?>
	<div id="r_jaminan_id" class="form-group">
		<label id="elh_t03_pinjaman_jaminan_id" for="x_jaminan_id" class="<?php echo $t03_pinjaman_add->LeftColumnClass ?>"><?php echo $t03_pinjaman->jaminan_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t03_pinjaman_add->RightColumnClass ?>"><div<?php echo $t03_pinjaman->jaminan_id->CellAttributes() ?>>
<span id="el_t03_pinjaman_jaminan_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next(":not([disabled])").click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_jaminan_id"><?php echo (strval($t03_pinjaman->jaminan_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t03_pinjaman->jaminan_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t03_pinjaman->jaminan_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_jaminan_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t03_pinjaman->jaminan_id->ReadOnly || $t03_pinjaman->jaminan_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t03_pinjaman" data-field="x_jaminan_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t03_pinjaman->jaminan_id->DisplayValueSeparatorAttribute() ?>" name="x_jaminan_id" id="x_jaminan_id" value="<?php echo $t03_pinjaman->jaminan_id->CurrentValue ?>"<?php echo $t03_pinjaman->jaminan_id->EditAttributes() ?>>
<?php if (AllowAdd(CurrentProjectID() . "t02_jaminan") && !$t03_pinjaman->jaminan_id->ReadOnly) { ?>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $t03_pinjaman->jaminan_id->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x_jaminan_id',url:'t02_jaminanaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x_jaminan_id"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $t03_pinjaman->jaminan_id->FldCaption() ?></span></button>
<?php } ?>
</span>
<?php echo $t03_pinjaman->jaminan_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t03_pinjaman->Pinjaman->Visible) { // Pinjaman ?>
	<div id="r_Pinjaman" class="form-group">
		<label id="elh_t03_pinjaman_Pinjaman" for="x_Pinjaman" class="<?php echo $t03_pinjaman_add->LeftColumnClass ?>"><?php echo $t03_pinjaman->Pinjaman->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t03_pinjaman_add->RightColumnClass ?>"><div<?php echo $t03_pinjaman->Pinjaman->CellAttributes() ?>>
<span id="el_t03_pinjaman_Pinjaman">
<input type="text" data-table="t03_pinjaman" data-field="x_Pinjaman" name="x_Pinjaman" id="x_Pinjaman" size="30" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->Pinjaman->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->Pinjaman->EditValue ?>"<?php echo $t03_pinjaman->Pinjaman->EditAttributes() ?>>
</span>
<?php echo $t03_pinjaman->Pinjaman->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t03_pinjaman->Denda->Visible) { // Denda ?>
	<div id="r_Denda" class="form-group">
		<label id="elh_t03_pinjaman_Denda" for="x_Denda" class="<?php echo $t03_pinjaman_add->LeftColumnClass ?>"><?php echo $t03_pinjaman->Denda->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t03_pinjaman_add->RightColumnClass ?>"><div<?php echo $t03_pinjaman->Denda->CellAttributes() ?>>
<span id="el_t03_pinjaman_Denda">
<input type="text" data-table="t03_pinjaman" data-field="x_Denda" name="x_Denda" id="x_Denda" size="30" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->Denda->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->Denda->EditValue ?>"<?php echo $t03_pinjaman->Denda->EditAttributes() ?>>
</span>
<?php echo $t03_pinjaman->Denda->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t03_pinjaman->DispensasiDenda->Visible) { // DispensasiDenda ?>
	<div id="r_DispensasiDenda" class="form-group">
		<label id="elh_t03_pinjaman_DispensasiDenda" for="x_DispensasiDenda" class="<?php echo $t03_pinjaman_add->LeftColumnClass ?>"><?php echo $t03_pinjaman->DispensasiDenda->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t03_pinjaman_add->RightColumnClass ?>"><div<?php echo $t03_pinjaman->DispensasiDenda->CellAttributes() ?>>
<span id="el_t03_pinjaman_DispensasiDenda">
<input type="text" data-table="t03_pinjaman" data-field="x_DispensasiDenda" name="x_DispensasiDenda" id="x_DispensasiDenda" size="30" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->DispensasiDenda->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->DispensasiDenda->EditValue ?>"<?php echo $t03_pinjaman->DispensasiDenda->EditAttributes() ?>>
</span>
<?php echo $t03_pinjaman->DispensasiDenda->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t03_pinjaman->LamaAngsuran->Visible) { // LamaAngsuran ?>
	<div id="r_LamaAngsuran" class="form-group">
		<label id="elh_t03_pinjaman_LamaAngsuran" for="x_LamaAngsuran" class="<?php echo $t03_pinjaman_add->LeftColumnClass ?>"><?php echo $t03_pinjaman->LamaAngsuran->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t03_pinjaman_add->RightColumnClass ?>"><div<?php echo $t03_pinjaman->LamaAngsuran->CellAttributes() ?>>
<span id="el_t03_pinjaman_LamaAngsuran">
<input type="text" data-table="t03_pinjaman" data-field="x_LamaAngsuran" name="x_LamaAngsuran" id="x_LamaAngsuran" size="30" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->LamaAngsuran->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->LamaAngsuran->EditValue ?>"<?php echo $t03_pinjaman->LamaAngsuran->EditAttributes() ?>>
</span>
<?php echo $t03_pinjaman->LamaAngsuran->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t03_pinjaman->JumlahAngsuran->Visible) { // JumlahAngsuran ?>
	<div id="r_JumlahAngsuran" class="form-group">
		<label id="elh_t03_pinjaman_JumlahAngsuran" for="x_JumlahAngsuran" class="<?php echo $t03_pinjaman_add->LeftColumnClass ?>"><?php echo $t03_pinjaman->JumlahAngsuran->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t03_pinjaman_add->RightColumnClass ?>"><div<?php echo $t03_pinjaman->JumlahAngsuran->CellAttributes() ?>>
<span id="el_t03_pinjaman_JumlahAngsuran">
<input type="text" data-table="t03_pinjaman" data-field="x_JumlahAngsuran" name="x_JumlahAngsuran" id="x_JumlahAngsuran" size="30" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->JumlahAngsuran->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->JumlahAngsuran->EditValue ?>"<?php echo $t03_pinjaman->JumlahAngsuran->EditAttributes() ?>>
</span>
<?php echo $t03_pinjaman->JumlahAngsuran->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t03_pinjaman->NoKontrakRefTo->Visible) { // NoKontrakRefTo ?>
	<div id="r_NoKontrakRefTo" class="form-group">
		<label id="elh_t03_pinjaman_NoKontrakRefTo" for="x_NoKontrakRefTo" class="<?php echo $t03_pinjaman_add->LeftColumnClass ?>"><?php echo $t03_pinjaman->NoKontrakRefTo->FldCaption() ?></label>
		<div class="<?php echo $t03_pinjaman_add->RightColumnClass ?>"><div<?php echo $t03_pinjaman->NoKontrakRefTo->CellAttributes() ?>>
<span id="el_t03_pinjaman_NoKontrakRefTo">
<input type="text" data-table="t03_pinjaman" data-field="x_NoKontrakRefTo" name="x_NoKontrakRefTo" id="x_NoKontrakRefTo" size="30" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->NoKontrakRefTo->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->NoKontrakRefTo->EditValue ?>"<?php echo $t03_pinjaman->NoKontrakRefTo->EditAttributes() ?>>
</span>
<?php echo $t03_pinjaman->NoKontrakRefTo->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php
	if (in_array("t04_angsuran", explode(",", $t03_pinjaman->getCurrentDetailTable())) && $t04_angsuran->DetailAdd) {
?>
<?php if ($t03_pinjaman->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("t04_angsuran", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "t04_angsurangrid.php" ?>
<?php } ?>
<?php if (!$t03_pinjaman_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $t03_pinjaman_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t03_pinjaman_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
ft03_pinjamanadd.Init();
</script>
<?php
$t03_pinjaman_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t03_pinjaman_add->Page_Terminate();
?>
