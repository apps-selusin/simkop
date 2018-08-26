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

$t01_nasabah_view = NULL; // Initialize page object first

class ct01_nasabah_view extends ct01_nasabah {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = '{B3698D9B-8D4B-412E-A2E5-AFAD2FEE5A23}';

	// Table name
	var $TableName = 't01_nasabah';

	// Page object name
	var $PageObjName = 't01_nasabah_view';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;
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
		$KeyUrl = "";
		if (@$_GET["id"] <> "") {
			$this->RecKey["id"] = $_GET["id"];
			$KeyUrl .= "&amp;id=" . urlencode($this->RecKey["id"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (t96_employees)
		if (!isset($GLOBALS['t96_employees'])) $GLOBALS['t96_employees'] = new ct96_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

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

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
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
		if (!$Security->CanView()) {
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
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $RecCnt;
	var $RecKey = array();
	var $IsModal = FALSE;
	var $Recordset;
	var $MultiPages; // Multi pages object

	//
	// Page main
	//
	function Page_Main() {
		global $Language, $gbSkipHeaderFooter, $EW_EXPORT;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id"] <> "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->RecKey["id"] = $this->id->QueryStringValue;
			} elseif (@$_POST["id"] <> "") {
				$this->id->setFormValue($_POST["id"]);
				$this->RecKey["id"] = $this->id->FormValue;
			} else {
				$sReturnUrl = "t01_nasabahlist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "t01_nasabahlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "t01_nasabahlist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("ViewPageAddLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->AddUrl) . "'});\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());

		// Edit
		$item = &$option->Add("edit");
		$editcaption = ew_HtmlTitle($Language->Phrase("ViewPageEditLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->EditUrl) . "'});\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "" && $Security->CanEdit());

		// Copy
		$item = &$option->Add("copy");
		$copycaption = ew_HtmlTitle($Language->Phrase("ViewPageCopyLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,btn:'AddBtn',url:'" . ew_HtmlEncode($this->CopyUrl) . "'});\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		$item->Visible = ($this->CopyUrl <> "" && $Security->CanAdd());

		// Delete
		$item = &$option->Add("delete");
		if ($this->IsModal) // Handle as inline delete
			$item->Body = "<a onclick=\"return ew_ConfirmDelete(this);\" class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode(ew_UrlAddQuery($this->DeleteUrl, "a_delete=1")) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "" && $Security->CanDelete());

		// Set up action default
		$option = &$options["action"];
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
		$option->UseImageAndText = TRUE;
		$option->UseDropDownButton = FALSE;
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
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
		if ($this->AuditTrailOnView) $this->WriteAuditTrailOnView($row);
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
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t01_nasabahlist.php"), "", $this->TableVar, TRUE);
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url);
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

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

		//$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t01_nasabah_view)) $t01_nasabah_view = new ct01_nasabah_view();

// Page init
$t01_nasabah_view->Page_Init();

// Page main
$t01_nasabah_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t01_nasabah_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = ft01_nasabahview = new ew_Form("ft01_nasabahview", "view");

// Form_CustomValidate event
ft01_nasabahview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft01_nasabahview.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Multi-Page
ft01_nasabahview.MultiPage = new ew_MultiPage("ft01_nasabahview");

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $t01_nasabah_view->ExportOptions->Render("body") ?>
<?php
	foreach ($t01_nasabah_view->OtherOptions as &$option)
		$option->Render("body");
?>
<div class="clearfix"></div>
</div>
<?php $t01_nasabah_view->ShowPageHeader(); ?>
<?php
$t01_nasabah_view->ShowMessage();
?>
<form name="ft01_nasabahview" id="ft01_nasabahview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t01_nasabah_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t01_nasabah_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t01_nasabah">
<input type="hidden" name="modal" value="<?php echo intval($t01_nasabah_view->IsModal) ?>">
<?php if ($t01_nasabah->Export == "") { ?>
<div class="ewMultiPage">
<div class="box-group" id="t01_nasabah_view">
<?php } ?>
<?php if ($t01_nasabah->Export == "") { ?>
	<div class="panel box<?php echo $t01_nasabah_view->MultiPages->PageStyle("1") ?>">
		<div class="box-header with-border">
			<h4 class="box-title">
				<a data-toggle="collapse" data-parent="<?php echo $t01_nasabah_view->MultiPages->Parent ?>" href="#tab_t01_nasabah1"><?php echo $t01_nasabah->PageCaption(1) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $t01_nasabah_view->MultiPages->PageStyle("1") ?>" id="tab_t01_nasabah1">
			<div class="box-body no-padding">
<?php } ?>
<table class="table table-striped table-bordered table-hover table-condensed ewViewTable">
<?php if ($t01_nasabah->NoKontrak->Visible) { // NoKontrak ?>
	<tr id="r_NoKontrak">
		<td class="col-sm-2"><span id="elh_t01_nasabah_NoKontrak"><?php echo $t01_nasabah->NoKontrak->FldCaption() ?></span></td>
		<td data-name="NoKontrak"<?php echo $t01_nasabah->NoKontrak->CellAttributes() ?>>
<span id="el_t01_nasabah_NoKontrak" data-page="1">
<span<?php echo $t01_nasabah->NoKontrak->ViewAttributes() ?>>
<?php echo $t01_nasabah->NoKontrak->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t01_nasabah->Customer->Visible) { // Customer ?>
	<tr id="r_Customer">
		<td class="col-sm-2"><span id="elh_t01_nasabah_Customer"><?php echo $t01_nasabah->Customer->FldCaption() ?></span></td>
		<td data-name="Customer"<?php echo $t01_nasabah->Customer->CellAttributes() ?>>
<span id="el_t01_nasabah_Customer" data-page="1">
<span<?php echo $t01_nasabah->Customer->ViewAttributes() ?>>
<?php echo $t01_nasabah->Customer->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t01_nasabah->TglKontrak->Visible) { // TglKontrak ?>
	<tr id="r_TglKontrak">
		<td class="col-sm-2"><span id="elh_t01_nasabah_TglKontrak"><?php echo $t01_nasabah->TglKontrak->FldCaption() ?></span></td>
		<td data-name="TglKontrak"<?php echo $t01_nasabah->TglKontrak->CellAttributes() ?>>
<span id="el_t01_nasabah_TglKontrak" data-page="1">
<span<?php echo $t01_nasabah->TglKontrak->ViewAttributes() ?>>
<?php echo $t01_nasabah->TglKontrak->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t01_nasabah->MerkType->Visible) { // MerkType ?>
	<tr id="r_MerkType">
		<td class="col-sm-2"><span id="elh_t01_nasabah_MerkType"><?php echo $t01_nasabah->MerkType->FldCaption() ?></span></td>
		<td data-name="MerkType"<?php echo $t01_nasabah->MerkType->CellAttributes() ?>>
<span id="el_t01_nasabah_MerkType" data-page="1">
<span<?php echo $t01_nasabah->MerkType->ViewAttributes() ?>>
<?php echo $t01_nasabah->MerkType->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t01_nasabah->Pinjaman->Visible) { // Pinjaman ?>
	<tr id="r_Pinjaman">
		<td class="col-sm-2"><span id="elh_t01_nasabah_Pinjaman"><?php echo $t01_nasabah->Pinjaman->FldCaption() ?></span></td>
		<td data-name="Pinjaman"<?php echo $t01_nasabah->Pinjaman->CellAttributes() ?>>
<span id="el_t01_nasabah_Pinjaman" data-page="1">
<span<?php echo $t01_nasabah->Pinjaman->ViewAttributes() ?>>
<?php echo $t01_nasabah->Pinjaman->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t01_nasabah->Denda->Visible) { // Denda ?>
	<tr id="r_Denda">
		<td class="col-sm-2"><span id="elh_t01_nasabah_Denda"><?php echo $t01_nasabah->Denda->FldCaption() ?></span></td>
		<td data-name="Denda"<?php echo $t01_nasabah->Denda->CellAttributes() ?>>
<span id="el_t01_nasabah_Denda" data-page="1">
<span<?php echo $t01_nasabah->Denda->ViewAttributes() ?>>
<?php echo $t01_nasabah->Denda->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t01_nasabah->DispensasiDenda->Visible) { // DispensasiDenda ?>
	<tr id="r_DispensasiDenda">
		<td class="col-sm-2"><span id="elh_t01_nasabah_DispensasiDenda"><?php echo $t01_nasabah->DispensasiDenda->FldCaption() ?></span></td>
		<td data-name="DispensasiDenda"<?php echo $t01_nasabah->DispensasiDenda->CellAttributes() ?>>
<span id="el_t01_nasabah_DispensasiDenda" data-page="1">
<span<?php echo $t01_nasabah->DispensasiDenda->ViewAttributes() ?>>
<?php echo $t01_nasabah->DispensasiDenda->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t01_nasabah->LamaAngsuran->Visible) { // LamaAngsuran ?>
	<tr id="r_LamaAngsuran">
		<td class="col-sm-2"><span id="elh_t01_nasabah_LamaAngsuran"><?php echo $t01_nasabah->LamaAngsuran->FldCaption() ?></span></td>
		<td data-name="LamaAngsuran"<?php echo $t01_nasabah->LamaAngsuran->CellAttributes() ?>>
<span id="el_t01_nasabah_LamaAngsuran" data-page="1">
<span<?php echo $t01_nasabah->LamaAngsuran->ViewAttributes() ?>>
<?php echo $t01_nasabah->LamaAngsuran->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t01_nasabah->JumlahAngsuran->Visible) { // JumlahAngsuran ?>
	<tr id="r_JumlahAngsuran">
		<td class="col-sm-2"><span id="elh_t01_nasabah_JumlahAngsuran"><?php echo $t01_nasabah->JumlahAngsuran->FldCaption() ?></span></td>
		<td data-name="JumlahAngsuran"<?php echo $t01_nasabah->JumlahAngsuran->CellAttributes() ?>>
<span id="el_t01_nasabah_JumlahAngsuran" data-page="1">
<span<?php echo $t01_nasabah->JumlahAngsuran->ViewAttributes() ?>>
<?php echo $t01_nasabah->JumlahAngsuran->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($t01_nasabah->Export == "") { ?>
			</div>
		</div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->Export == "") { ?>
	<div class="panel box<?php echo $t01_nasabah_view->MultiPages->PageStyle("2") ?>">
		<div class="box-header with-border">
			<h4 class="box-title">
				<a data-toggle="collapse" data-parent="<?php echo $t01_nasabah_view->MultiPages->Parent ?>" href="#tab_t01_nasabah2"><?php echo $t01_nasabah->PageCaption(2) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $t01_nasabah_view->MultiPages->PageStyle("2") ?>" id="tab_t01_nasabah2">
			<div class="box-body no-padding">
<?php } ?>
<table class="table table-striped table-bordered table-hover table-condensed ewViewTable">
<?php if ($t01_nasabah->NoRangka->Visible) { // NoRangka ?>
	<tr id="r_NoRangka">
		<td class="col-sm-2"><span id="elh_t01_nasabah_NoRangka"><?php echo $t01_nasabah->NoRangka->FldCaption() ?></span></td>
		<td data-name="NoRangka"<?php echo $t01_nasabah->NoRangka->CellAttributes() ?>>
<span id="el_t01_nasabah_NoRangka" data-page="2">
<span<?php echo $t01_nasabah->NoRangka->ViewAttributes() ?>>
<?php echo $t01_nasabah->NoRangka->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t01_nasabah->NoMesin->Visible) { // NoMesin ?>
	<tr id="r_NoMesin">
		<td class="col-sm-2"><span id="elh_t01_nasabah_NoMesin"><?php echo $t01_nasabah->NoMesin->FldCaption() ?></span></td>
		<td data-name="NoMesin"<?php echo $t01_nasabah->NoMesin->CellAttributes() ?>>
<span id="el_t01_nasabah_NoMesin" data-page="2">
<span<?php echo $t01_nasabah->NoMesin->ViewAttributes() ?>>
<?php echo $t01_nasabah->NoMesin->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t01_nasabah->Warna->Visible) { // Warna ?>
	<tr id="r_Warna">
		<td class="col-sm-2"><span id="elh_t01_nasabah_Warna"><?php echo $t01_nasabah->Warna->FldCaption() ?></span></td>
		<td data-name="Warna"<?php echo $t01_nasabah->Warna->CellAttributes() ?>>
<span id="el_t01_nasabah_Warna" data-page="2">
<span<?php echo $t01_nasabah->Warna->ViewAttributes() ?>>
<?php echo $t01_nasabah->Warna->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t01_nasabah->NoPol->Visible) { // NoPol ?>
	<tr id="r_NoPol">
		<td class="col-sm-2"><span id="elh_t01_nasabah_NoPol"><?php echo $t01_nasabah->NoPol->FldCaption() ?></span></td>
		<td data-name="NoPol"<?php echo $t01_nasabah->NoPol->CellAttributes() ?>>
<span id="el_t01_nasabah_NoPol" data-page="2">
<span<?php echo $t01_nasabah->NoPol->ViewAttributes() ?>>
<?php echo $t01_nasabah->NoPol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t01_nasabah->Keterangan->Visible) { // Keterangan ?>
	<tr id="r_Keterangan">
		<td class="col-sm-2"><span id="elh_t01_nasabah_Keterangan"><?php echo $t01_nasabah->Keterangan->FldCaption() ?></span></td>
		<td data-name="Keterangan"<?php echo $t01_nasabah->Keterangan->CellAttributes() ?>>
<span id="el_t01_nasabah_Keterangan" data-page="2">
<span<?php echo $t01_nasabah->Keterangan->ViewAttributes() ?>>
<?php echo $t01_nasabah->Keterangan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t01_nasabah->AtasNama->Visible) { // AtasNama ?>
	<tr id="r_AtasNama">
		<td class="col-sm-2"><span id="elh_t01_nasabah_AtasNama"><?php echo $t01_nasabah->AtasNama->FldCaption() ?></span></td>
		<td data-name="AtasNama"<?php echo $t01_nasabah->AtasNama->CellAttributes() ?>>
<span id="el_t01_nasabah_AtasNama" data-page="2">
<span<?php echo $t01_nasabah->AtasNama->ViewAttributes() ?>>
<?php echo $t01_nasabah->AtasNama->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($t01_nasabah->Export == "") { ?>
			</div>
		</div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->Export == "") { ?>
	<div class="panel box<?php echo $t01_nasabah_view->MultiPages->PageStyle("3") ?>">
		<div class="box-header with-border">
			<h4 class="box-title">
				<a data-toggle="collapse" data-parent="<?php echo $t01_nasabah_view->MultiPages->Parent ?>" href="#tab_t01_nasabah3"><?php echo $t01_nasabah->PageCaption(3) ?></a>
			</h4>
		</div>
		<div class="panel-collapse collapse<?php echo $t01_nasabah_view->MultiPages->PageStyle("3") ?>" id="tab_t01_nasabah3">
			<div class="box-body no-padding">
<?php } ?>
<table class="table table-striped table-bordered table-hover table-condensed ewViewTable">
<?php if ($t01_nasabah->Pekerjaan->Visible) { // Pekerjaan ?>
	<tr id="r_Pekerjaan">
		<td class="col-sm-2"><span id="elh_t01_nasabah_Pekerjaan"><?php echo $t01_nasabah->Pekerjaan->FldCaption() ?></span></td>
		<td data-name="Pekerjaan"<?php echo $t01_nasabah->Pekerjaan->CellAttributes() ?>>
<span id="el_t01_nasabah_Pekerjaan" data-page="3">
<span<?php echo $t01_nasabah->Pekerjaan->ViewAttributes() ?>>
<?php echo $t01_nasabah->Pekerjaan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t01_nasabah->Alamat->Visible) { // Alamat ?>
	<tr id="r_Alamat">
		<td class="col-sm-2"><span id="elh_t01_nasabah_Alamat"><?php echo $t01_nasabah->Alamat->FldCaption() ?></span></td>
		<td data-name="Alamat"<?php echo $t01_nasabah->Alamat->CellAttributes() ?>>
<span id="el_t01_nasabah_Alamat" data-page="3">
<span<?php echo $t01_nasabah->Alamat->ViewAttributes() ?>>
<?php echo $t01_nasabah->Alamat->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t01_nasabah->NoTelpHp->Visible) { // NoTelpHp ?>
	<tr id="r_NoTelpHp">
		<td class="col-sm-2"><span id="elh_t01_nasabah_NoTelpHp"><?php echo $t01_nasabah->NoTelpHp->FldCaption() ?></span></td>
		<td data-name="NoTelpHp"<?php echo $t01_nasabah->NoTelpHp->CellAttributes() ?>>
<span id="el_t01_nasabah_NoTelpHp" data-page="3">
<span<?php echo $t01_nasabah->NoTelpHp->ViewAttributes() ?>>
<?php echo $t01_nasabah->NoTelpHp->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($t01_nasabah->Export == "") { ?>
			</div>
		</div>
	</div>
<?php } ?>
<?php if ($t01_nasabah->Export == "") { ?>
</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ft01_nasabahview.Init();
</script>
<?php
$t01_nasabah_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t01_nasabah_view->Page_Terminate();
?>
