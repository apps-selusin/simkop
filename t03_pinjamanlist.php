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
<?php include_once "t05_pinjamanjaminangridcls.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$t03_pinjaman_list = NULL; // Initialize page object first

class ct03_pinjaman_list extends ct03_pinjaman {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{B3698D9B-8D4B-412E-A2E5-AFAD2FEE5A23}';

	// Table name
	var $TableName = 't03_pinjaman';

	// Page object name
	var $PageObjName = 't03_pinjaman_list';

	// Grid form hidden field names
	var $FormName = 'ft03_pinjamanlist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

		// Table object (t03_pinjaman)
		if (!isset($GLOBALS["t03_pinjaman"]) || get_class($GLOBALS["t03_pinjaman"]) == "ct03_pinjaman") {
			$GLOBALS["t03_pinjaman"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t03_pinjaman"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "t03_pinjamanadd.php?" . EW_TABLE_SHOW_DETAIL . "=";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "t03_pinjamandelete.php";
		$this->MultiUpdateUrl = "t03_pinjamanupdate.php";

		// Table object (t96_employees)
		if (!isset($GLOBALS['t96_employees'])) $GLOBALS['t96_employees'] = new ct96_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption ft03_pinjamanlistsrch";

		// List actions
		$this->ListActions = new cListActions();
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
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			$this->Page_Terminate(ew_GetUrl("index.php"));
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

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();
		$this->NoKontrak->SetVisibility();
		$this->TglKontrak->SetVisibility();
		$this->nasabah_id->SetVisibility();
		$this->Pinjaman->SetVisibility();
		$this->LamaAngsuran->SetVisibility();
		$this->Bunga->SetVisibility();
		$this->Denda->SetVisibility();
		$this->DispensasiDenda->SetVisibility();
		$this->AngsuranTotal->SetVisibility();
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
				if (in_array("t05_pinjamanjaminan", $DetailTblVar)) {

					// Process auto fill for detail table 't05_pinjamanjaminan'
					if (preg_match('/^ft05_pinjamanjaminan(grid|add|addopt|edit|update|search)$/', @$_POST["form"])) {
						if (!isset($GLOBALS["t05_pinjamanjaminan_grid"])) $GLOBALS["t05_pinjamanjaminan_grid"] = new ct05_pinjamanjaminan_grid;
						$GLOBALS["t05_pinjamanjaminan_grid"]->Page_Init();
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

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
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
			ew_SaveDebugMsg();
			header("Location: " . $url);
		}
		exit();
	}

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $AutoHidePager = EW_AUTO_HIDE_PAGER;
	var $AutoHidePageSizeSelector = EW_AUTO_HIDE_PAGE_SIZE_SELECTOR;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security, $EW_EXPORT;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Set up records per page
			$this->SetupDisplayRecs();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->BasicSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Process filter list
			$this->ProcessFilterList();

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->Command <> "json" && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetupSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($this->Command <> "json" && $this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		if ($this->Command <> "json")
			$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif ($this->Command <> "json") {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter
		if ($this->Command == "json") {
			$this->UseSessionForListSQL = FALSE; // Do not use session for ListSQL
			$this->CurrentFilter = $sFilter;
		} else {
			$this->setSessionWhere($sFilter);
			$this->CurrentFilter = "";
		}

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->ListRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	// Set up number of records displayed per page
	function SetupDisplayRecs() {
		$sWrk = @$_GET[EW_TABLE_REC_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->DisplayRecs = intval($sWrk);
			} else {
				if (strtolower($sWrk) == "all") { // Display all records
					$this->DisplayRecs = -1;
				} else {
					$this->DisplayRecs = 20; // Non-numeric, load default
				}
			}
			$this->setRecordsPerPage($this->DisplayRecs); // Save to Session

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Initialize
		$sFilterList = "";
		$sSavedFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->id->AdvancedSearch->ToJson(), ","); // Field id
		$sFilterList = ew_Concat($sFilterList, $this->NoKontrak->AdvancedSearch->ToJson(), ","); // Field NoKontrak
		$sFilterList = ew_Concat($sFilterList, $this->TglKontrak->AdvancedSearch->ToJson(), ","); // Field TglKontrak
		$sFilterList = ew_Concat($sFilterList, $this->nasabah_id->AdvancedSearch->ToJson(), ","); // Field nasabah_id
		$sFilterList = ew_Concat($sFilterList, $this->Pinjaman->AdvancedSearch->ToJson(), ","); // Field Pinjaman
		$sFilterList = ew_Concat($sFilterList, $this->LamaAngsuran->AdvancedSearch->ToJson(), ","); // Field LamaAngsuran
		$sFilterList = ew_Concat($sFilterList, $this->Bunga->AdvancedSearch->ToJson(), ","); // Field Bunga
		$sFilterList = ew_Concat($sFilterList, $this->Denda->AdvancedSearch->ToJson(), ","); // Field Denda
		$sFilterList = ew_Concat($sFilterList, $this->DispensasiDenda->AdvancedSearch->ToJson(), ","); // Field DispensasiDenda
		$sFilterList = ew_Concat($sFilterList, $this->AngsuranPokok->AdvancedSearch->ToJson(), ","); // Field AngsuranPokok
		$sFilterList = ew_Concat($sFilterList, $this->AngsuranBunga->AdvancedSearch->ToJson(), ","); // Field AngsuranBunga
		$sFilterList = ew_Concat($sFilterList, $this->AngsuranTotal->AdvancedSearch->ToJson(), ","); // Field AngsuranTotal
		$sFilterList = ew_Concat($sFilterList, $this->NoKontrakRefTo->AdvancedSearch->ToJson(), ","); // Field NoKontrakRefTo
		if ($this->BasicSearch->Keyword <> "") {
			$sWrk = "\"" . EW_TABLE_BASIC_SEARCH . "\":\"" . ew_JsEncode2($this->BasicSearch->Keyword) . "\",\"" . EW_TABLE_BASIC_SEARCH_TYPE . "\":\"" . ew_JsEncode2($this->BasicSearch->Type) . "\"";
			$sFilterList = ew_Concat($sFilterList, $sWrk, ",");
		}
		$sFilterList = preg_replace('/,$/', "", $sFilterList);

		// Return filter list in json
		if ($sFilterList <> "")
			$sFilterList = "\"data\":{" . $sFilterList . "}";
		if ($sSavedFilterList <> "") {
			if ($sFilterList <> "")
				$sFilterList .= ",";
			$sFilterList .= "\"filters\":" . $sSavedFilterList;
		}
		return ($sFilterList <> "") ? "{" . $sFilterList . "}" : "null";
	}

	// Process filter list
	function ProcessFilterList() {
		global $UserProfile;
		if (@$_POST["ajax"] == "savefilters") { // Save filter request (Ajax)
			$filters = @$_POST["filters"];
			$UserProfile->SetSearchFilters(CurrentUserName(), "ft03_pinjamanlistsrch", $filters);

			// Clean output buffer
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			echo ew_ArrayToJson(array(array("success" => TRUE))); // Success
			$this->Page_Terminate();
			exit();
		} elseif (@$_POST["cmd"] == "resetfilter") {
			$this->RestoreFilterList();
		}
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(@$_POST["filter"], TRUE);
		$this->Command = "search";

		// Field id
		$this->id->AdvancedSearch->SearchValue = @$filter["x_id"];
		$this->id->AdvancedSearch->SearchOperator = @$filter["z_id"];
		$this->id->AdvancedSearch->SearchCondition = @$filter["v_id"];
		$this->id->AdvancedSearch->SearchValue2 = @$filter["y_id"];
		$this->id->AdvancedSearch->SearchOperator2 = @$filter["w_id"];
		$this->id->AdvancedSearch->Save();

		// Field NoKontrak
		$this->NoKontrak->AdvancedSearch->SearchValue = @$filter["x_NoKontrak"];
		$this->NoKontrak->AdvancedSearch->SearchOperator = @$filter["z_NoKontrak"];
		$this->NoKontrak->AdvancedSearch->SearchCondition = @$filter["v_NoKontrak"];
		$this->NoKontrak->AdvancedSearch->SearchValue2 = @$filter["y_NoKontrak"];
		$this->NoKontrak->AdvancedSearch->SearchOperator2 = @$filter["w_NoKontrak"];
		$this->NoKontrak->AdvancedSearch->Save();

		// Field TglKontrak
		$this->TglKontrak->AdvancedSearch->SearchValue = @$filter["x_TglKontrak"];
		$this->TglKontrak->AdvancedSearch->SearchOperator = @$filter["z_TglKontrak"];
		$this->TglKontrak->AdvancedSearch->SearchCondition = @$filter["v_TglKontrak"];
		$this->TglKontrak->AdvancedSearch->SearchValue2 = @$filter["y_TglKontrak"];
		$this->TglKontrak->AdvancedSearch->SearchOperator2 = @$filter["w_TglKontrak"];
		$this->TglKontrak->AdvancedSearch->Save();

		// Field nasabah_id
		$this->nasabah_id->AdvancedSearch->SearchValue = @$filter["x_nasabah_id"];
		$this->nasabah_id->AdvancedSearch->SearchOperator = @$filter["z_nasabah_id"];
		$this->nasabah_id->AdvancedSearch->SearchCondition = @$filter["v_nasabah_id"];
		$this->nasabah_id->AdvancedSearch->SearchValue2 = @$filter["y_nasabah_id"];
		$this->nasabah_id->AdvancedSearch->SearchOperator2 = @$filter["w_nasabah_id"];
		$this->nasabah_id->AdvancedSearch->Save();

		// Field Pinjaman
		$this->Pinjaman->AdvancedSearch->SearchValue = @$filter["x_Pinjaman"];
		$this->Pinjaman->AdvancedSearch->SearchOperator = @$filter["z_Pinjaman"];
		$this->Pinjaman->AdvancedSearch->SearchCondition = @$filter["v_Pinjaman"];
		$this->Pinjaman->AdvancedSearch->SearchValue2 = @$filter["y_Pinjaman"];
		$this->Pinjaman->AdvancedSearch->SearchOperator2 = @$filter["w_Pinjaman"];
		$this->Pinjaman->AdvancedSearch->Save();

		// Field LamaAngsuran
		$this->LamaAngsuran->AdvancedSearch->SearchValue = @$filter["x_LamaAngsuran"];
		$this->LamaAngsuran->AdvancedSearch->SearchOperator = @$filter["z_LamaAngsuran"];
		$this->LamaAngsuran->AdvancedSearch->SearchCondition = @$filter["v_LamaAngsuran"];
		$this->LamaAngsuran->AdvancedSearch->SearchValue2 = @$filter["y_LamaAngsuran"];
		$this->LamaAngsuran->AdvancedSearch->SearchOperator2 = @$filter["w_LamaAngsuran"];
		$this->LamaAngsuran->AdvancedSearch->Save();

		// Field Bunga
		$this->Bunga->AdvancedSearch->SearchValue = @$filter["x_Bunga"];
		$this->Bunga->AdvancedSearch->SearchOperator = @$filter["z_Bunga"];
		$this->Bunga->AdvancedSearch->SearchCondition = @$filter["v_Bunga"];
		$this->Bunga->AdvancedSearch->SearchValue2 = @$filter["y_Bunga"];
		$this->Bunga->AdvancedSearch->SearchOperator2 = @$filter["w_Bunga"];
		$this->Bunga->AdvancedSearch->Save();

		// Field Denda
		$this->Denda->AdvancedSearch->SearchValue = @$filter["x_Denda"];
		$this->Denda->AdvancedSearch->SearchOperator = @$filter["z_Denda"];
		$this->Denda->AdvancedSearch->SearchCondition = @$filter["v_Denda"];
		$this->Denda->AdvancedSearch->SearchValue2 = @$filter["y_Denda"];
		$this->Denda->AdvancedSearch->SearchOperator2 = @$filter["w_Denda"];
		$this->Denda->AdvancedSearch->Save();

		// Field DispensasiDenda
		$this->DispensasiDenda->AdvancedSearch->SearchValue = @$filter["x_DispensasiDenda"];
		$this->DispensasiDenda->AdvancedSearch->SearchOperator = @$filter["z_DispensasiDenda"];
		$this->DispensasiDenda->AdvancedSearch->SearchCondition = @$filter["v_DispensasiDenda"];
		$this->DispensasiDenda->AdvancedSearch->SearchValue2 = @$filter["y_DispensasiDenda"];
		$this->DispensasiDenda->AdvancedSearch->SearchOperator2 = @$filter["w_DispensasiDenda"];
		$this->DispensasiDenda->AdvancedSearch->Save();

		// Field AngsuranPokok
		$this->AngsuranPokok->AdvancedSearch->SearchValue = @$filter["x_AngsuranPokok"];
		$this->AngsuranPokok->AdvancedSearch->SearchOperator = @$filter["z_AngsuranPokok"];
		$this->AngsuranPokok->AdvancedSearch->SearchCondition = @$filter["v_AngsuranPokok"];
		$this->AngsuranPokok->AdvancedSearch->SearchValue2 = @$filter["y_AngsuranPokok"];
		$this->AngsuranPokok->AdvancedSearch->SearchOperator2 = @$filter["w_AngsuranPokok"];
		$this->AngsuranPokok->AdvancedSearch->Save();

		// Field AngsuranBunga
		$this->AngsuranBunga->AdvancedSearch->SearchValue = @$filter["x_AngsuranBunga"];
		$this->AngsuranBunga->AdvancedSearch->SearchOperator = @$filter["z_AngsuranBunga"];
		$this->AngsuranBunga->AdvancedSearch->SearchCondition = @$filter["v_AngsuranBunga"];
		$this->AngsuranBunga->AdvancedSearch->SearchValue2 = @$filter["y_AngsuranBunga"];
		$this->AngsuranBunga->AdvancedSearch->SearchOperator2 = @$filter["w_AngsuranBunga"];
		$this->AngsuranBunga->AdvancedSearch->Save();

		// Field AngsuranTotal
		$this->AngsuranTotal->AdvancedSearch->SearchValue = @$filter["x_AngsuranTotal"];
		$this->AngsuranTotal->AdvancedSearch->SearchOperator = @$filter["z_AngsuranTotal"];
		$this->AngsuranTotal->AdvancedSearch->SearchCondition = @$filter["v_AngsuranTotal"];
		$this->AngsuranTotal->AdvancedSearch->SearchValue2 = @$filter["y_AngsuranTotal"];
		$this->AngsuranTotal->AdvancedSearch->SearchOperator2 = @$filter["w_AngsuranTotal"];
		$this->AngsuranTotal->AdvancedSearch->Save();

		// Field NoKontrakRefTo
		$this->NoKontrakRefTo->AdvancedSearch->SearchValue = @$filter["x_NoKontrakRefTo"];
		$this->NoKontrakRefTo->AdvancedSearch->SearchOperator = @$filter["z_NoKontrakRefTo"];
		$this->NoKontrakRefTo->AdvancedSearch->SearchCondition = @$filter["v_NoKontrakRefTo"];
		$this->NoKontrakRefTo->AdvancedSearch->SearchValue2 = @$filter["y_NoKontrakRefTo"];
		$this->NoKontrakRefTo->AdvancedSearch->SearchOperator2 = @$filter["w_NoKontrakRefTo"];
		$this->NoKontrakRefTo->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->NoKontrak, $arKeywords, $type);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSQL(&$Where, &$Fld, $arKeywords, $type) {
		global $EW_BASIC_SEARCH_IGNORE_PATTERN;
		$sDefCond = ($type == "OR") ? "OR" : "AND";
		$arSQL = array(); // Array for SQL parts
		$arCond = array(); // Array for search conditions
		$cnt = count($arKeywords);
		$j = 0; // Number of SQL parts
		for ($i = 0; $i < $cnt; $i++) {
			$Keyword = $arKeywords[$i];
			$Keyword = trim($Keyword);
			if ($EW_BASIC_SEARCH_IGNORE_PATTERN <> "") {
				$Keyword = preg_replace($EW_BASIC_SEARCH_IGNORE_PATTERN, "\\", $Keyword);
				$ar = explode("\\", $Keyword);
			} else {
				$ar = array($Keyword);
			}
			foreach ($ar as $Keyword) {
				if ($Keyword <> "") {
					$sWrk = "";
					if ($Keyword == "OR" && $type == "") {
						if ($j > 0)
							$arCond[$j-1] = "OR";
					} elseif ($Keyword == EW_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NULL";
					} elseif ($Keyword == EW_NOT_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NOT NULL";
					} elseif ($Fld->FldIsVirtual) {
						$sWrk = $Fld->FldVirtualExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					} elseif ($Fld->FldDataType != EW_DATATYPE_NUMBER || is_numeric($Keyword)) {
						$sWrk = $Fld->FldBasicSearchExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					}
					if ($sWrk <> "") {
						$arSQL[$j] = $sWrk;
						$arCond[$j] = $sDefCond;
						$j += 1;
					}
				}
			}
		}
		$cnt = count($arSQL);
		$bQuoted = FALSE;
		$sSql = "";
		if ($cnt > 0) {
			for ($i = 0; $i < $cnt-1; $i++) {
				if ($arCond[$i] == "OR") {
					if (!$bQuoted) $sSql .= "(";
					$bQuoted = TRUE;
				}
				$sSql .= $arSQL[$i];
				if ($bQuoted && $arCond[$i] <> "OR") {
					$sSql .= ")";
					$bQuoted = FALSE;
				}
				$sSql .= " " . $arCond[$i] . " ";
			}
			$sSql .= $arSQL[$cnt-1];
			if ($bQuoted)
				$sSql .= ")";
		}
		if ($sSql <> "") {
			if ($Where <> "") $Where .= " OR ";
			$Where .= "(" . $sSql . ")";
		}
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere($Default = FALSE) {
		global $Security;
		$sSearchStr = "";
		if (!$Security->CanSearch()) return "";
		$sSearchKeyword = ($Default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
		$sSearchType = ($Default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;

		// Get search SQL
		if ($sSearchKeyword <> "") {
			$ar = $this->BasicSearch->KeywordList($Default);

			// Search keyword in any fields
			if (($sSearchType == "OR" || $sSearchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
				foreach ($ar as $sKeyword) {
					if ($sKeyword <> "") {
						if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
						$sSearchStr .= "(" . $this->BasicSearchSQL(array($sKeyword), $sSearchType) . ")";
					}
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL($ar, $sSearchType);
			}
			if (!$Default && in_array($this->Command, array("", "reset", "resetall"))) $this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();
	}

	// Set up sort parameters
	function SetupSortOrder() {

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = @$_GET["order"];
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->NoKontrak, $bCtrl); // NoKontrak
			$this->UpdateSort($this->TglKontrak, $bCtrl); // TglKontrak
			$this->UpdateSort($this->nasabah_id, $bCtrl); // nasabah_id
			$this->UpdateSort($this->Pinjaman, $bCtrl); // Pinjaman
			$this->UpdateSort($this->LamaAngsuran, $bCtrl); // LamaAngsuran
			$this->UpdateSort($this->Bunga, $bCtrl); // Bunga
			$this->UpdateSort($this->Denda, $bCtrl); // Denda
			$this->UpdateSort($this->DispensasiDenda, $bCtrl); // DispensasiDenda
			$this->UpdateSort($this->AngsuranTotal, $bCtrl); // AngsuranTotal
			$this->UpdateSort($this->NoKontrakRefTo, $bCtrl); // NoKontrakRefTo
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->setSessionOrderByList($sOrderBy);
				$this->NoKontrak->setSort("");
				$this->TglKontrak->setSort("");
				$this->nasabah_id->setSort("");
				$this->Pinjaman->setSort("");
				$this->LamaAngsuran->setSort("");
				$this->Bunga->setSort("");
				$this->Denda->setSort("");
				$this->DispensasiDenda->setSort("");
				$this->AngsuranTotal->setSort("");
				$this->NoKontrakRefTo->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = TRUE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanAdd();
		$item->OnLeft = TRUE;

		// "delete"
		$item = &$this->ListOptions->Add("delete");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanDelete();
		$item->OnLeft = TRUE;

		// "detail_t04_angsuran"
		$item = &$this->ListOptions->Add("detail_t04_angsuran");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 't04_angsuran') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["t04_angsuran_grid"])) $GLOBALS["t04_angsuran_grid"] = new ct04_angsuran_grid;

		// "detail_t05_pinjamanjaminan"
		$item = &$this->ListOptions->Add("detail_t05_pinjamanjaminan");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 't05_pinjamanjaminan') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["t05_pinjamanjaminan_grid"])) $GLOBALS["t05_pinjamanjaminan_grid"] = new ct05_pinjamanjaminan_grid;

		// Multiple details
		if ($this->ShowMultipleDetails) {
			$item = &$this->ListOptions->Add("details");
			$item->CssClass = "text-nowrap";
			$item->Visible = $this->ShowMultipleDetails;
			$item->OnLeft = TRUE;
			$item->ShowInButtonGroup = FALSE;
		}

		// Set up detail pages
		$pages = new cSubPages();
		$pages->Add("t04_angsuran");
		$pages->Add("t05_pinjamanjaminan");
		$this->DetailPages = $pages;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssClass = "text-nowrap";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = TRUE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->MoveTo(0);
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// "sequence"
		$item = &$this->ListOptions->Add("sequence");
		$item->CssClass = "text-nowrap";
		$item->Visible = TRUE;
		$item->OnLeft = TRUE; // Always on left
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// Call ListOptions_Rendering event
		$this->ListOptions_Rendering();

		// "sequence"
		$oListOpt = &$this->ListOptions->Items["sequence"];
		$oListOpt->Body = ew_FormatSeqNo($this->RecCnt);

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		$copycaption = ew_HtmlTitle($Language->Phrase("CopyLink"));
		if ($Security->CanAdd()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "delete"
		$oListOpt = &$this->ListOptions->Items["delete"];
		if ($Security->CanDelete())
			$oListOpt->Body = "<a class=\"ewRowLink ewDelete\"" . "" . " title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("DeleteLink") . "</a>";
		else
			$oListOpt->Body = "";

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt && $this->Export == "" && $this->CurrentAction == "") {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default btn-sm ewActions\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}
		$DetailViewTblVar = "";
		$DetailCopyTblVar = "";
		$DetailEditTblVar = "";

		// "detail_t04_angsuran"
		$oListOpt = &$this->ListOptions->Items["detail_t04_angsuran"];
		if ($Security->AllowList(CurrentProjectID() . 't04_angsuran')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("t04_angsuran", "TblCaption");
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("t04_angsuranlist.php?" . EW_TABLE_SHOW_MASTER . "=t03_pinjaman&fk_id=" . urlencode(strval($this->id->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["t04_angsuran_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 't04_angsuran')) {
				$caption = $Language->Phrase("MasterDetailEditLink");
				$url = $this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=t04_angsuran");
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . ew_HtmlImageAndText($caption) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "t04_angsuran";
			}
			if ($GLOBALS["t04_angsuran_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 't04_angsuran')) {
				$caption = $Language->Phrase("MasterDetailCopyLink");
				$url = $this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=t04_angsuran");
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . ew_HtmlImageAndText($caption) . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "t04_angsuran";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}

		// "detail_t05_pinjamanjaminan"
		$oListOpt = &$this->ListOptions->Items["detail_t05_pinjamanjaminan"];
		if ($Security->AllowList(CurrentProjectID() . 't05_pinjamanjaminan')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("t05_pinjamanjaminan", "TblCaption");
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("t05_pinjamanjaminanlist.php?" . EW_TABLE_SHOW_MASTER . "=t03_pinjaman&fk_id=" . urlencode(strval($this->id->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["t05_pinjamanjaminan_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 't05_pinjamanjaminan')) {
				$caption = $Language->Phrase("MasterDetailEditLink");
				$url = $this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=t05_pinjamanjaminan");
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . ew_HtmlImageAndText($caption) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "t05_pinjamanjaminan";
			}
			if ($GLOBALS["t05_pinjamanjaminan_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 't05_pinjamanjaminan')) {
				$caption = $Language->Phrase("MasterDetailCopyLink");
				$url = $this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=t05_pinjamanjaminan");
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . ew_HtmlImageAndText($caption) . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "t05_pinjamanjaminan";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}
		if ($this->ShowMultipleDetails) {
			$body = $Language->Phrase("MultipleMasterDetails");
			$body = "<div class=\"btn-group\">";
			$links = "";
			if ($DetailViewTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailViewTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			}
			if ($DetailEditTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailEditTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			}
			if ($DetailCopyTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailCopyTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewMasterDetail\" title=\"" . ew_HtmlTitle($Language->Phrase("MultipleMasterDetails")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("MultipleMasterDetails") . "<b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu ewMenu\">". $links . "</ul>";
			}
			$body .= "</div>";

			// Multiple details
			$oListOpt = &$this->ListOptions->Items["details"];
			$oListOpt->Body = $body;
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" class=\"ewMultiSelect\" value=\"" . ew_HtmlEncode($this->id->CurrentValue) . "\" onclick=\"ew_ClickMultiCheckbox(event);\">";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("AddLink"));
		$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());
		$option = $options["detail"];
		$DetailTableLink = "";
		$item = &$option->Add("detailadd_t04_angsuran");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=t04_angsuran");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["t04_angsuran"]->TableCaption();
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["t04_angsuran"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 't04_angsuran') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "t04_angsuran";
		}
		$item = &$option->Add("detailadd_t05_pinjamanjaminan");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=t05_pinjamanjaminan");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["t05_pinjamanjaminan"]->TableCaption();
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["t05_pinjamanjaminan"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 't05_pinjamanjaminan') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "t05_pinjamanjaminan";
		}

		// Add multiple details
		if ($this->ShowMultipleDetails) {
			$item = &$option->Add("detailsadd");
			$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailTableLink);
			$caption = $Language->Phrase("AddMasterDetailLink");
			$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
			$item->Visible = ($DetailTableLink <> "" && $Security->CanAdd());

			// Hide single master/detail items
			$ar = explode(",", $DetailTableLink);
			$cnt = count($ar);
			for ($i = 0; $i < $cnt; $i++) {
				if ($item = &$option->GetItem("detailadd_" . $ar[$i]))
					$item->Visible = FALSE;
			}
		}
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = FALSE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"ft03_pinjamanlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"ft03_pinjamanlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.ft03_pinjamanlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			$this->CurrentAction = ""; // Clear action
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Search button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = ($this->SearchWhere <> "") ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"ft03_pinjamanlistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
		global $Security;
		if (!$Security->CanSearch()) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}
	}

	function SetupListOptionsExt() {
		global $Security, $Language;
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "" && $this->Command == "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
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
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderByList())));
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
		$this->TglKontrak->setDbValue($row['TglKontrak']);
		$this->nasabah_id->setDbValue($row['nasabah_id']);
		if (array_key_exists('EV__nasabah_id', $rs->fields)) {
			$this->nasabah_id->VirtualValue = $rs->fields('EV__nasabah_id'); // Set up virtual field value
		} else {
			$this->nasabah_id->VirtualValue = ""; // Clear value
		}
		$this->Pinjaman->setDbValue($row['Pinjaman']);
		$this->LamaAngsuran->setDbValue($row['LamaAngsuran']);
		$this->Bunga->setDbValue($row['Bunga']);
		$this->Denda->setDbValue($row['Denda']);
		$this->DispensasiDenda->setDbValue($row['DispensasiDenda']);
		$this->AngsuranPokok->setDbValue($row['AngsuranPokok']);
		$this->AngsuranBunga->setDbValue($row['AngsuranBunga']);
		$this->AngsuranTotal->setDbValue($row['AngsuranTotal']);
		$this->NoKontrakRefTo->setDbValue($row['NoKontrakRefTo']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['NoKontrak'] = NULL;
		$row['TglKontrak'] = NULL;
		$row['nasabah_id'] = NULL;
		$row['Pinjaman'] = NULL;
		$row['LamaAngsuran'] = NULL;
		$row['Bunga'] = NULL;
		$row['Denda'] = NULL;
		$row['DispensasiDenda'] = NULL;
		$row['AngsuranPokok'] = NULL;
		$row['AngsuranBunga'] = NULL;
		$row['AngsuranTotal'] = NULL;
		$row['NoKontrakRefTo'] = NULL;
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
		$this->Pinjaman->DbValue = $row['Pinjaman'];
		$this->LamaAngsuran->DbValue = $row['LamaAngsuran'];
		$this->Bunga->DbValue = $row['Bunga'];
		$this->Denda->DbValue = $row['Denda'];
		$this->DispensasiDenda->DbValue = $row['DispensasiDenda'];
		$this->AngsuranPokok->DbValue = $row['AngsuranPokok'];
		$this->AngsuranBunga->DbValue = $row['AngsuranBunga'];
		$this->AngsuranTotal->DbValue = $row['AngsuranTotal'];
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

		// Convert decimal values if posted back
		if ($this->Pinjaman->FormValue == $this->Pinjaman->CurrentValue && is_numeric(ew_StrToFloat($this->Pinjaman->CurrentValue)))
			$this->Pinjaman->CurrentValue = ew_StrToFloat($this->Pinjaman->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Bunga->FormValue == $this->Bunga->CurrentValue && is_numeric(ew_StrToFloat($this->Bunga->CurrentValue)))
			$this->Bunga->CurrentValue = ew_StrToFloat($this->Bunga->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Denda->FormValue == $this->Denda->CurrentValue && is_numeric(ew_StrToFloat($this->Denda->CurrentValue)))
			$this->Denda->CurrentValue = ew_StrToFloat($this->Denda->CurrentValue);

		// Convert decimal values if posted back
		if ($this->AngsuranTotal->FormValue == $this->AngsuranTotal->CurrentValue && is_numeric(ew_StrToFloat($this->AngsuranTotal->CurrentValue)))
			$this->AngsuranTotal->CurrentValue = ew_StrToFloat($this->AngsuranTotal->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// NoKontrak
		// TglKontrak
		// nasabah_id
		// Pinjaman
		// LamaAngsuran
		// Bunga
		// Denda
		// DispensasiDenda
		// AngsuranPokok
		// AngsuranBunga
		// AngsuranTotal
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

		// Pinjaman
		$this->Pinjaman->ViewValue = $this->Pinjaman->CurrentValue;
		$this->Pinjaman->ViewValue = ew_FormatNumber($this->Pinjaman->ViewValue, 2, -2, -2, -2);
		$this->Pinjaman->CellCssStyle .= "text-align: right;";
		$this->Pinjaman->ViewCustomAttributes = "";

		// LamaAngsuran
		$this->LamaAngsuran->ViewValue = $this->LamaAngsuran->CurrentValue;
		$this->LamaAngsuran->ViewValue = ew_FormatNumber($this->LamaAngsuran->ViewValue, 0, -2, -2, -2);
		$this->LamaAngsuran->CellCssStyle .= "text-align: right;";
		$this->LamaAngsuran->ViewCustomAttributes = "";

		// Bunga
		$this->Bunga->ViewValue = $this->Bunga->CurrentValue;
		$this->Bunga->ViewValue = ew_FormatNumber($this->Bunga->ViewValue, 2, -2, -2, -2);
		$this->Bunga->CellCssStyle .= "text-align: right;";
		$this->Bunga->ViewCustomAttributes = "";

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

		// AngsuranPokok
		$this->AngsuranPokok->ViewValue = $this->AngsuranPokok->CurrentValue;
		$this->AngsuranPokok->ViewValue = ew_FormatNumber($this->AngsuranPokok->ViewValue, 2, -2, -2, -2);
		$this->AngsuranPokok->CellCssStyle .= "text-align: right;";
		$this->AngsuranPokok->ViewCustomAttributes = "";

		// AngsuranBunga
		$this->AngsuranBunga->ViewValue = $this->AngsuranBunga->CurrentValue;
		$this->AngsuranBunga->ViewValue = ew_FormatNumber($this->AngsuranBunga->ViewValue, 2, -2, -2, -2);
		$this->AngsuranBunga->CellCssStyle .= "text-align: right;";
		$this->AngsuranBunga->ViewCustomAttributes = "";

		// AngsuranTotal
		$this->AngsuranTotal->ViewValue = $this->AngsuranTotal->CurrentValue;
		$this->AngsuranTotal->ViewValue = ew_FormatNumber($this->AngsuranTotal->ViewValue, 2, -2, -2, -2);
		$this->AngsuranTotal->CellCssStyle .= "text-align: right;";
		$this->AngsuranTotal->ViewCustomAttributes = "";

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

			// Pinjaman
			$this->Pinjaman->LinkCustomAttributes = "";
			$this->Pinjaman->HrefValue = "";
			$this->Pinjaman->TooltipValue = "";

			// LamaAngsuran
			$this->LamaAngsuran->LinkCustomAttributes = "";
			$this->LamaAngsuran->HrefValue = "";
			$this->LamaAngsuran->TooltipValue = "";

			// Bunga
			$this->Bunga->LinkCustomAttributes = "";
			$this->Bunga->HrefValue = "";
			$this->Bunga->TooltipValue = "";

			// Denda
			$this->Denda->LinkCustomAttributes = "";
			$this->Denda->HrefValue = "";
			$this->Denda->TooltipValue = "";

			// DispensasiDenda
			$this->DispensasiDenda->LinkCustomAttributes = "";
			$this->DispensasiDenda->HrefValue = "";
			$this->DispensasiDenda->TooltipValue = "";

			// AngsuranTotal
			$this->AngsuranTotal->LinkCustomAttributes = "";
			$this->AngsuranTotal->HrefValue = "";
			$this->AngsuranTotal->TooltipValue = "";

			// NoKontrakRefTo
			$this->NoKontrakRefTo->LinkCustomAttributes = "";
			$this->NoKontrakRefTo->HrefValue = "";
			$this->NoKontrakRefTo->TooltipValue = "";
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
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
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
		// hapus button tambah data

		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Body = "";
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendering event
	function ListOptions_Rendering() {

		//$GLOBALS["xxx_grid"]->DetailAdd = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailEdit = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailView = (...condition...); // Set to TRUE or FALSE conditionally

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example:
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
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
if (!isset($t03_pinjaman_list)) $t03_pinjaman_list = new ct03_pinjaman_list();

// Page init
$t03_pinjaman_list->Page_Init();

// Page main
$t03_pinjaman_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t03_pinjaman_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = ft03_pinjamanlist = new ew_Form("ft03_pinjamanlist", "list");
ft03_pinjamanlist.FormKeyCountName = '<?php echo $t03_pinjaman_list->FormKeyCountName ?>';

// Form_CustomValidate event
ft03_pinjamanlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft03_pinjamanlist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ft03_pinjamanlist.Lists["x_nasabah_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_Customer","x_NoTelpHp","",""],"ParentFields":[],"ChildFields":["t05_pinjamanjaminan x_jaminan_id"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t01_nasabah"};
ft03_pinjamanlist.Lists["x_nasabah_id"].Data = "<?php echo $t03_pinjaman_list->nasabah_id->LookupFilterQuery(FALSE, "list") ?>";

// Form object for search
var CurrentSearchForm = ft03_pinjamanlistsrch = new ew_Form("ft03_pinjamanlistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php if ($t03_pinjaman_list->TotalRecs > 0 && $t03_pinjaman_list->ExportOptions->Visible()) { ?>
<?php $t03_pinjaman_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($t03_pinjaman_list->SearchOptions->Visible()) { ?>
<?php $t03_pinjaman_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($t03_pinjaman_list->FilterOptions->Visible()) { ?>
<?php $t03_pinjaman_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $t03_pinjaman_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t03_pinjaman_list->TotalRecs <= 0)
			$t03_pinjaman_list->TotalRecs = $t03_pinjaman->ListRecordCount();
	} else {
		if (!$t03_pinjaman_list->Recordset && ($t03_pinjaman_list->Recordset = $t03_pinjaman_list->LoadRecordset()))
			$t03_pinjaman_list->TotalRecs = $t03_pinjaman_list->Recordset->RecordCount();
	}
	$t03_pinjaman_list->StartRec = 1;
	if ($t03_pinjaman_list->DisplayRecs <= 0 || ($t03_pinjaman->Export <> "" && $t03_pinjaman->ExportAll)) // Display all records
		$t03_pinjaman_list->DisplayRecs = $t03_pinjaman_list->TotalRecs;
	if (!($t03_pinjaman->Export <> "" && $t03_pinjaman->ExportAll))
		$t03_pinjaman_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$t03_pinjaman_list->Recordset = $t03_pinjaman_list->LoadRecordset($t03_pinjaman_list->StartRec-1, $t03_pinjaman_list->DisplayRecs);

	// Set no record found message
	if ($t03_pinjaman->CurrentAction == "" && $t03_pinjaman_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$t03_pinjaman_list->setWarningMessage(ew_DeniedMsg());
		if ($t03_pinjaman_list->SearchWhere == "0=101")
			$t03_pinjaman_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t03_pinjaman_list->setWarningMessage($Language->Phrase("NoRecord"));
	}

	// Audit trail on search
	if ($t03_pinjaman_list->AuditTrailOnSearch && $t03_pinjaman_list->Command == "search" && !$t03_pinjaman_list->RestoreSearch) {
		$searchparm = ew_ServerVar("QUERY_STRING");
		$searchsql = $t03_pinjaman_list->getSessionWhere();
		$t03_pinjaman_list->WriteAuditTrailOnSearch($searchparm, $searchsql);
	}
$t03_pinjaman_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($t03_pinjaman->Export == "" && $t03_pinjaman->CurrentAction == "") { ?>
<form name="ft03_pinjamanlistsrch" id="ft03_pinjamanlistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($t03_pinjaman_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="ft03_pinjamanlistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="t03_pinjaman">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($t03_pinjaman_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($t03_pinjaman_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $t03_pinjaman_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($t03_pinjaman_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($t03_pinjaman_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($t03_pinjaman_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($t03_pinjaman_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("SearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $t03_pinjaman_list->ShowPageHeader(); ?>
<?php
$t03_pinjaman_list->ShowMessage();
?>
<?php if ($t03_pinjaman_list->TotalRecs > 0 || $t03_pinjaman->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($t03_pinjaman_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> t03_pinjaman">
<div class="box-header ewGridUpperPanel">
<?php if ($t03_pinjaman->CurrentAction <> "gridadd" && $t03_pinjaman->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t03_pinjaman_list->Pager)) $t03_pinjaman_list->Pager = new cPrevNextPager($t03_pinjaman_list->StartRec, $t03_pinjaman_list->DisplayRecs, $t03_pinjaman_list->TotalRecs, $t03_pinjaman_list->AutoHidePager) ?>
<?php if ($t03_pinjaman_list->Pager->RecordCount > 0 && $t03_pinjaman_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t03_pinjaman_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t03_pinjaman_list->PageUrl() ?>start=<?php echo $t03_pinjaman_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t03_pinjaman_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t03_pinjaman_list->PageUrl() ?>start=<?php echo $t03_pinjaman_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t03_pinjaman_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t03_pinjaman_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t03_pinjaman_list->PageUrl() ?>start=<?php echo $t03_pinjaman_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t03_pinjaman_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t03_pinjaman_list->PageUrl() ?>start=<?php echo $t03_pinjaman_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t03_pinjaman_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($t03_pinjaman_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $t03_pinjaman_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $t03_pinjaman_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $t03_pinjaman_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($t03_pinjaman_list->TotalRecs > 0 && (!$t03_pinjaman_list->AutoHidePageSizeSelector || $t03_pinjaman_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="t03_pinjaman">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($t03_pinjaman_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($t03_pinjaman_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($t03_pinjaman_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($t03_pinjaman_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="200"<?php if ($t03_pinjaman_list->DisplayRecs == 200) { ?> selected<?php } ?>>200</option>
<option value="ALL"<?php if ($t03_pinjaman->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t03_pinjaman_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<form name="ft03_pinjamanlist" id="ft03_pinjamanlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t03_pinjaman_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t03_pinjaman_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t03_pinjaman">
<div id="gmp_t03_pinjaman" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($t03_pinjaman_list->TotalRecs > 0 || $t03_pinjaman->CurrentAction == "gridedit") { ?>
<table id="tbl_t03_pinjamanlist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$t03_pinjaman_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t03_pinjaman_list->RenderListOptions();

// Render list options (header, left)
$t03_pinjaman_list->ListOptions->Render("header", "left");
?>
<?php if ($t03_pinjaman->NoKontrak->Visible) { // NoKontrak ?>
	<?php if ($t03_pinjaman->SortUrl($t03_pinjaman->NoKontrak) == "") { ?>
		<th data-name="NoKontrak" class="<?php echo $t03_pinjaman->NoKontrak->HeaderCellClass() ?>"><div id="elh_t03_pinjaman_NoKontrak" class="t03_pinjaman_NoKontrak"><div class="ewTableHeaderCaption"><?php echo $t03_pinjaman->NoKontrak->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NoKontrak" class="<?php echo $t03_pinjaman->NoKontrak->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t03_pinjaman->SortUrl($t03_pinjaman->NoKontrak) ?>',2);"><div id="elh_t03_pinjaman_NoKontrak" class="t03_pinjaman_NoKontrak">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t03_pinjaman->NoKontrak->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t03_pinjaman->NoKontrak->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t03_pinjaman->NoKontrak->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t03_pinjaman->TglKontrak->Visible) { // TglKontrak ?>
	<?php if ($t03_pinjaman->SortUrl($t03_pinjaman->TglKontrak) == "") { ?>
		<th data-name="TglKontrak" class="<?php echo $t03_pinjaman->TglKontrak->HeaderCellClass() ?>"><div id="elh_t03_pinjaman_TglKontrak" class="t03_pinjaman_TglKontrak"><div class="ewTableHeaderCaption"><?php echo $t03_pinjaman->TglKontrak->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="TglKontrak" class="<?php echo $t03_pinjaman->TglKontrak->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t03_pinjaman->SortUrl($t03_pinjaman->TglKontrak) ?>',2);"><div id="elh_t03_pinjaman_TglKontrak" class="t03_pinjaman_TglKontrak">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t03_pinjaman->TglKontrak->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t03_pinjaman->TglKontrak->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t03_pinjaman->TglKontrak->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t03_pinjaman->nasabah_id->Visible) { // nasabah_id ?>
	<?php if ($t03_pinjaman->SortUrl($t03_pinjaman->nasabah_id) == "") { ?>
		<th data-name="nasabah_id" class="<?php echo $t03_pinjaman->nasabah_id->HeaderCellClass() ?>"><div id="elh_t03_pinjaman_nasabah_id" class="t03_pinjaman_nasabah_id"><div class="ewTableHeaderCaption"><?php echo $t03_pinjaman->nasabah_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nasabah_id" class="<?php echo $t03_pinjaman->nasabah_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t03_pinjaman->SortUrl($t03_pinjaman->nasabah_id) ?>',2);"><div id="elh_t03_pinjaman_nasabah_id" class="t03_pinjaman_nasabah_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t03_pinjaman->nasabah_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t03_pinjaman->nasabah_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t03_pinjaman->nasabah_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t03_pinjaman->Pinjaman->Visible) { // Pinjaman ?>
	<?php if ($t03_pinjaman->SortUrl($t03_pinjaman->Pinjaman) == "") { ?>
		<th data-name="Pinjaman" class="<?php echo $t03_pinjaman->Pinjaman->HeaderCellClass() ?>"><div id="elh_t03_pinjaman_Pinjaman" class="t03_pinjaman_Pinjaman"><div class="ewTableHeaderCaption"><?php echo $t03_pinjaman->Pinjaman->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Pinjaman" class="<?php echo $t03_pinjaman->Pinjaman->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t03_pinjaman->SortUrl($t03_pinjaman->Pinjaman) ?>',2);"><div id="elh_t03_pinjaman_Pinjaman" class="t03_pinjaman_Pinjaman">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t03_pinjaman->Pinjaman->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t03_pinjaman->Pinjaman->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t03_pinjaman->Pinjaman->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t03_pinjaman->LamaAngsuran->Visible) { // LamaAngsuran ?>
	<?php if ($t03_pinjaman->SortUrl($t03_pinjaman->LamaAngsuran) == "") { ?>
		<th data-name="LamaAngsuran" class="<?php echo $t03_pinjaman->LamaAngsuran->HeaderCellClass() ?>"><div id="elh_t03_pinjaman_LamaAngsuran" class="t03_pinjaman_LamaAngsuran"><div class="ewTableHeaderCaption"><?php echo $t03_pinjaman->LamaAngsuran->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="LamaAngsuran" class="<?php echo $t03_pinjaman->LamaAngsuran->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t03_pinjaman->SortUrl($t03_pinjaman->LamaAngsuran) ?>',2);"><div id="elh_t03_pinjaman_LamaAngsuran" class="t03_pinjaman_LamaAngsuran">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t03_pinjaman->LamaAngsuran->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t03_pinjaman->LamaAngsuran->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t03_pinjaman->LamaAngsuran->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t03_pinjaman->Bunga->Visible) { // Bunga ?>
	<?php if ($t03_pinjaman->SortUrl($t03_pinjaman->Bunga) == "") { ?>
		<th data-name="Bunga" class="<?php echo $t03_pinjaman->Bunga->HeaderCellClass() ?>"><div id="elh_t03_pinjaman_Bunga" class="t03_pinjaman_Bunga"><div class="ewTableHeaderCaption"><?php echo $t03_pinjaman->Bunga->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Bunga" class="<?php echo $t03_pinjaman->Bunga->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t03_pinjaman->SortUrl($t03_pinjaman->Bunga) ?>',2);"><div id="elh_t03_pinjaman_Bunga" class="t03_pinjaman_Bunga">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t03_pinjaman->Bunga->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t03_pinjaman->Bunga->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t03_pinjaman->Bunga->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t03_pinjaman->Denda->Visible) { // Denda ?>
	<?php if ($t03_pinjaman->SortUrl($t03_pinjaman->Denda) == "") { ?>
		<th data-name="Denda" class="<?php echo $t03_pinjaman->Denda->HeaderCellClass() ?>"><div id="elh_t03_pinjaman_Denda" class="t03_pinjaman_Denda"><div class="ewTableHeaderCaption"><?php echo $t03_pinjaman->Denda->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Denda" class="<?php echo $t03_pinjaman->Denda->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t03_pinjaman->SortUrl($t03_pinjaman->Denda) ?>',2);"><div id="elh_t03_pinjaman_Denda" class="t03_pinjaman_Denda">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t03_pinjaman->Denda->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t03_pinjaman->Denda->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t03_pinjaman->Denda->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t03_pinjaman->DispensasiDenda->Visible) { // DispensasiDenda ?>
	<?php if ($t03_pinjaman->SortUrl($t03_pinjaman->DispensasiDenda) == "") { ?>
		<th data-name="DispensasiDenda" class="<?php echo $t03_pinjaman->DispensasiDenda->HeaderCellClass() ?>"><div id="elh_t03_pinjaman_DispensasiDenda" class="t03_pinjaman_DispensasiDenda"><div class="ewTableHeaderCaption"><?php echo $t03_pinjaman->DispensasiDenda->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="DispensasiDenda" class="<?php echo $t03_pinjaman->DispensasiDenda->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t03_pinjaman->SortUrl($t03_pinjaman->DispensasiDenda) ?>',2);"><div id="elh_t03_pinjaman_DispensasiDenda" class="t03_pinjaman_DispensasiDenda">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t03_pinjaman->DispensasiDenda->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t03_pinjaman->DispensasiDenda->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t03_pinjaman->DispensasiDenda->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t03_pinjaman->AngsuranTotal->Visible) { // AngsuranTotal ?>
	<?php if ($t03_pinjaman->SortUrl($t03_pinjaman->AngsuranTotal) == "") { ?>
		<th data-name="AngsuranTotal" class="<?php echo $t03_pinjaman->AngsuranTotal->HeaderCellClass() ?>"><div id="elh_t03_pinjaman_AngsuranTotal" class="t03_pinjaman_AngsuranTotal"><div class="ewTableHeaderCaption"><?php echo $t03_pinjaman->AngsuranTotal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="AngsuranTotal" class="<?php echo $t03_pinjaman->AngsuranTotal->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t03_pinjaman->SortUrl($t03_pinjaman->AngsuranTotal) ?>',2);"><div id="elh_t03_pinjaman_AngsuranTotal" class="t03_pinjaman_AngsuranTotal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t03_pinjaman->AngsuranTotal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t03_pinjaman->AngsuranTotal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t03_pinjaman->AngsuranTotal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t03_pinjaman->NoKontrakRefTo->Visible) { // NoKontrakRefTo ?>
	<?php if ($t03_pinjaman->SortUrl($t03_pinjaman->NoKontrakRefTo) == "") { ?>
		<th data-name="NoKontrakRefTo" class="<?php echo $t03_pinjaman->NoKontrakRefTo->HeaderCellClass() ?>"><div id="elh_t03_pinjaman_NoKontrakRefTo" class="t03_pinjaman_NoKontrakRefTo"><div class="ewTableHeaderCaption"><?php echo $t03_pinjaman->NoKontrakRefTo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NoKontrakRefTo" class="<?php echo $t03_pinjaman->NoKontrakRefTo->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t03_pinjaman->SortUrl($t03_pinjaman->NoKontrakRefTo) ?>',2);"><div id="elh_t03_pinjaman_NoKontrakRefTo" class="t03_pinjaman_NoKontrakRefTo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t03_pinjaman->NoKontrakRefTo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t03_pinjaman->NoKontrakRefTo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t03_pinjaman->NoKontrakRefTo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$t03_pinjaman_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($t03_pinjaman->ExportAll && $t03_pinjaman->Export <> "") {
	$t03_pinjaman_list->StopRec = $t03_pinjaman_list->TotalRecs;
} else {

	// Set the last record to display
	if ($t03_pinjaman_list->TotalRecs > $t03_pinjaman_list->StartRec + $t03_pinjaman_list->DisplayRecs - 1)
		$t03_pinjaman_list->StopRec = $t03_pinjaman_list->StartRec + $t03_pinjaman_list->DisplayRecs - 1;
	else
		$t03_pinjaman_list->StopRec = $t03_pinjaman_list->TotalRecs;
}
$t03_pinjaman_list->RecCnt = $t03_pinjaman_list->StartRec - 1;
if ($t03_pinjaman_list->Recordset && !$t03_pinjaman_list->Recordset->EOF) {
	$t03_pinjaman_list->Recordset->MoveFirst();
	$bSelectLimit = $t03_pinjaman_list->UseSelectLimit;
	if (!$bSelectLimit && $t03_pinjaman_list->StartRec > 1)
		$t03_pinjaman_list->Recordset->Move($t03_pinjaman_list->StartRec - 1);
} elseif (!$t03_pinjaman->AllowAddDeleteRow && $t03_pinjaman_list->StopRec == 0) {
	$t03_pinjaman_list->StopRec = $t03_pinjaman->GridAddRowCount;
}

// Initialize aggregate
$t03_pinjaman->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t03_pinjaman->ResetAttrs();
$t03_pinjaman_list->RenderRow();
while ($t03_pinjaman_list->RecCnt < $t03_pinjaman_list->StopRec) {
	$t03_pinjaman_list->RecCnt++;
	if (intval($t03_pinjaman_list->RecCnt) >= intval($t03_pinjaman_list->StartRec)) {
		$t03_pinjaman_list->RowCnt++;

		// Set up key count
		$t03_pinjaman_list->KeyCount = $t03_pinjaman_list->RowIndex;

		// Init row class and style
		$t03_pinjaman->ResetAttrs();
		$t03_pinjaman->CssClass = "";
		if ($t03_pinjaman->CurrentAction == "gridadd") {
		} else {
			$t03_pinjaman_list->LoadRowValues($t03_pinjaman_list->Recordset); // Load row values
		}
		$t03_pinjaman->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$t03_pinjaman->RowAttrs = array_merge($t03_pinjaman->RowAttrs, array('data-rowindex'=>$t03_pinjaman_list->RowCnt, 'id'=>'r' . $t03_pinjaman_list->RowCnt . '_t03_pinjaman', 'data-rowtype'=>$t03_pinjaman->RowType));

		// Render row
		$t03_pinjaman_list->RenderRow();

		// Render list options
		$t03_pinjaman_list->RenderListOptions();
?>
	<tr<?php echo $t03_pinjaman->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t03_pinjaman_list->ListOptions->Render("body", "left", $t03_pinjaman_list->RowCnt);
?>
	<?php if ($t03_pinjaman->NoKontrak->Visible) { // NoKontrak ?>
		<td data-name="NoKontrak"<?php echo $t03_pinjaman->NoKontrak->CellAttributes() ?>>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_NoKontrak" class="t03_pinjaman_NoKontrak">
<span<?php echo $t03_pinjaman->NoKontrak->ViewAttributes() ?>>
<?php echo $t03_pinjaman->NoKontrak->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t03_pinjaman->TglKontrak->Visible) { // TglKontrak ?>
		<td data-name="TglKontrak"<?php echo $t03_pinjaman->TglKontrak->CellAttributes() ?>>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_TglKontrak" class="t03_pinjaman_TglKontrak">
<span<?php echo $t03_pinjaman->TglKontrak->ViewAttributes() ?>>
<?php echo $t03_pinjaman->TglKontrak->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t03_pinjaman->nasabah_id->Visible) { // nasabah_id ?>
		<td data-name="nasabah_id"<?php echo $t03_pinjaman->nasabah_id->CellAttributes() ?>>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_nasabah_id" class="t03_pinjaman_nasabah_id">
<span<?php echo $t03_pinjaman->nasabah_id->ViewAttributes() ?>>
<?php echo $t03_pinjaman->nasabah_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t03_pinjaman->Pinjaman->Visible) { // Pinjaman ?>
		<td data-name="Pinjaman"<?php echo $t03_pinjaman->Pinjaman->CellAttributes() ?>>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_Pinjaman" class="t03_pinjaman_Pinjaman">
<span<?php echo $t03_pinjaman->Pinjaman->ViewAttributes() ?>>
<?php echo $t03_pinjaman->Pinjaman->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t03_pinjaman->LamaAngsuran->Visible) { // LamaAngsuran ?>
		<td data-name="LamaAngsuran"<?php echo $t03_pinjaman->LamaAngsuran->CellAttributes() ?>>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_LamaAngsuran" class="t03_pinjaman_LamaAngsuran">
<span<?php echo $t03_pinjaman->LamaAngsuran->ViewAttributes() ?>>
<?php echo $t03_pinjaman->LamaAngsuran->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t03_pinjaman->Bunga->Visible) { // Bunga ?>
		<td data-name="Bunga"<?php echo $t03_pinjaman->Bunga->CellAttributes() ?>>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_Bunga" class="t03_pinjaman_Bunga">
<span<?php echo $t03_pinjaman->Bunga->ViewAttributes() ?>>
<?php echo $t03_pinjaman->Bunga->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t03_pinjaman->Denda->Visible) { // Denda ?>
		<td data-name="Denda"<?php echo $t03_pinjaman->Denda->CellAttributes() ?>>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_Denda" class="t03_pinjaman_Denda">
<span<?php echo $t03_pinjaman->Denda->ViewAttributes() ?>>
<?php echo $t03_pinjaman->Denda->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t03_pinjaman->DispensasiDenda->Visible) { // DispensasiDenda ?>
		<td data-name="DispensasiDenda"<?php echo $t03_pinjaman->DispensasiDenda->CellAttributes() ?>>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_DispensasiDenda" class="t03_pinjaman_DispensasiDenda">
<span<?php echo $t03_pinjaman->DispensasiDenda->ViewAttributes() ?>>
<?php echo $t03_pinjaman->DispensasiDenda->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t03_pinjaman->AngsuranTotal->Visible) { // AngsuranTotal ?>
		<td data-name="AngsuranTotal"<?php echo $t03_pinjaman->AngsuranTotal->CellAttributes() ?>>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_AngsuranTotal" class="t03_pinjaman_AngsuranTotal">
<span<?php echo $t03_pinjaman->AngsuranTotal->ViewAttributes() ?>>
<?php echo $t03_pinjaman->AngsuranTotal->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t03_pinjaman->NoKontrakRefTo->Visible) { // NoKontrakRefTo ?>
		<td data-name="NoKontrakRefTo"<?php echo $t03_pinjaman->NoKontrakRefTo->CellAttributes() ?>>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_NoKontrakRefTo" class="t03_pinjaman_NoKontrakRefTo">
<span<?php echo $t03_pinjaman->NoKontrakRefTo->ViewAttributes() ?>>
<?php echo $t03_pinjaman->NoKontrakRefTo->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t03_pinjaman_list->ListOptions->Render("body", "right", $t03_pinjaman_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($t03_pinjaman->CurrentAction <> "gridadd")
		$t03_pinjaman_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($t03_pinjaman->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($t03_pinjaman_list->Recordset)
	$t03_pinjaman_list->Recordset->Close();
?>
<div class="box-footer ewGridLowerPanel">
<?php if ($t03_pinjaman->CurrentAction <> "gridadd" && $t03_pinjaman->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t03_pinjaman_list->Pager)) $t03_pinjaman_list->Pager = new cPrevNextPager($t03_pinjaman_list->StartRec, $t03_pinjaman_list->DisplayRecs, $t03_pinjaman_list->TotalRecs, $t03_pinjaman_list->AutoHidePager) ?>
<?php if ($t03_pinjaman_list->Pager->RecordCount > 0 && $t03_pinjaman_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t03_pinjaman_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t03_pinjaman_list->PageUrl() ?>start=<?php echo $t03_pinjaman_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t03_pinjaman_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t03_pinjaman_list->PageUrl() ?>start=<?php echo $t03_pinjaman_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t03_pinjaman_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t03_pinjaman_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t03_pinjaman_list->PageUrl() ?>start=<?php echo $t03_pinjaman_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t03_pinjaman_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t03_pinjaman_list->PageUrl() ?>start=<?php echo $t03_pinjaman_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t03_pinjaman_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($t03_pinjaman_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $t03_pinjaman_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $t03_pinjaman_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $t03_pinjaman_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($t03_pinjaman_list->TotalRecs > 0 && (!$t03_pinjaman_list->AutoHidePageSizeSelector || $t03_pinjaman_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="t03_pinjaman">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($t03_pinjaman_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($t03_pinjaman_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($t03_pinjaman_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($t03_pinjaman_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="200"<?php if ($t03_pinjaman_list->DisplayRecs == 200) { ?> selected<?php } ?>>200</option>
<option value="ALL"<?php if ($t03_pinjaman->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t03_pinjaman_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($t03_pinjaman_list->TotalRecs == 0 && $t03_pinjaman->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t03_pinjaman_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
ft03_pinjamanlistsrch.FilterList = <?php echo $t03_pinjaman_list->GetFilterList() ?>;
ft03_pinjamanlistsrch.Init();
ft03_pinjamanlist.Init();
</script>
<?php
$t03_pinjaman_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t03_pinjaman_list->Page_Terminate();
?>
