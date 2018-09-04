<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "t04_angsuraninfo.php" ?>
<?php include_once "t03_pinjamaninfo.php" ?>
<?php include_once "t96_employeesinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$t04_angsuran_list = NULL; // Initialize page object first

class ct04_angsuran_list extends ct04_angsuran {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{B3698D9B-8D4B-412E-A2E5-AFAD2FEE5A23}';

	// Table name
	var $TableName = 't04_angsuran';

	// Page object name
	var $PageObjName = 't04_angsuran_list';

	// Grid form hidden field names
	var $FormName = 'ft04_angsuranlist';
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

		// Table object (t04_angsuran)
		if (!isset($GLOBALS["t04_angsuran"]) || get_class($GLOBALS["t04_angsuran"]) == "ct04_angsuran") {
			$GLOBALS["t04_angsuran"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t04_angsuran"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "t04_angsuranadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "t04_angsurandelete.php";
		$this->MultiUpdateUrl = "t04_angsuranupdate.php";

		// Table object (t03_pinjaman)
		if (!isset($GLOBALS['t03_pinjaman'])) $GLOBALS['t03_pinjaman'] = new ct03_pinjaman();

		// Table object (t96_employees)
		if (!isset($GLOBALS['t96_employees'])) $GLOBALS['t96_employees'] = new ct96_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't04_angsuran', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption ft04_angsuranlistsrch";

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
		$this->id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->id->Visible = FALSE;
		$this->pinjaman_id->SetVisibility();
		$this->AngsuranKe->SetVisibility();
		$this->AngsuranTanggal->SetVisibility();
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

		// Set up master detail parameters
		$this->SetupMasterParms();

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
		global $EW_EXPORT, $t04_angsuran;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t04_angsuran);
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

		// Restore master/detail filter
		$this->DbMasterFilter = $this->GetMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "t03_pinjaman") {
			global $t03_pinjaman;
			$rsmaster = $t03_pinjaman->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("t03_pinjamanlist.php"); // Return to master page
			} else {
				$t03_pinjaman->LoadListRowValues($rsmaster);
				$t03_pinjaman->RowType = EW_ROWTYPE_MASTER; // Master row
				$t03_pinjaman->RenderListRow();
				$rsmaster->Close();
			}
		}

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
		$sFilterList = ew_Concat($sFilterList, $this->pinjaman_id->AdvancedSearch->ToJson(), ","); // Field pinjaman_id
		$sFilterList = ew_Concat($sFilterList, $this->AngsuranKe->AdvancedSearch->ToJson(), ","); // Field AngsuranKe
		$sFilterList = ew_Concat($sFilterList, $this->AngsuranTanggal->AdvancedSearch->ToJson(), ","); // Field AngsuranTanggal
		$sFilterList = ew_Concat($sFilterList, $this->AngsuranPokok->AdvancedSearch->ToJson(), ","); // Field AngsuranPokok
		$sFilterList = ew_Concat($sFilterList, $this->AngsuranBunga->AdvancedSearch->ToJson(), ","); // Field AngsuranBunga
		$sFilterList = ew_Concat($sFilterList, $this->AngsuranTotal->AdvancedSearch->ToJson(), ","); // Field AngsuranTotal
		$sFilterList = ew_Concat($sFilterList, $this->SisaHutang->AdvancedSearch->ToJson(), ","); // Field SisaHutang
		$sFilterList = ew_Concat($sFilterList, $this->TanggalBayar->AdvancedSearch->ToJson(), ","); // Field TanggalBayar
		$sFilterList = ew_Concat($sFilterList, $this->TotalDenda->AdvancedSearch->ToJson(), ","); // Field TotalDenda
		$sFilterList = ew_Concat($sFilterList, $this->Terlambat->AdvancedSearch->ToJson(), ","); // Field Terlambat
		$sFilterList = ew_Concat($sFilterList, $this->Keterangan->AdvancedSearch->ToJson(), ","); // Field Keterangan
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "ft04_angsuranlistsrch", $filters);

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

		// Field pinjaman_id
		$this->pinjaman_id->AdvancedSearch->SearchValue = @$filter["x_pinjaman_id"];
		$this->pinjaman_id->AdvancedSearch->SearchOperator = @$filter["z_pinjaman_id"];
		$this->pinjaman_id->AdvancedSearch->SearchCondition = @$filter["v_pinjaman_id"];
		$this->pinjaman_id->AdvancedSearch->SearchValue2 = @$filter["y_pinjaman_id"];
		$this->pinjaman_id->AdvancedSearch->SearchOperator2 = @$filter["w_pinjaman_id"];
		$this->pinjaman_id->AdvancedSearch->Save();

		// Field AngsuranKe
		$this->AngsuranKe->AdvancedSearch->SearchValue = @$filter["x_AngsuranKe"];
		$this->AngsuranKe->AdvancedSearch->SearchOperator = @$filter["z_AngsuranKe"];
		$this->AngsuranKe->AdvancedSearch->SearchCondition = @$filter["v_AngsuranKe"];
		$this->AngsuranKe->AdvancedSearch->SearchValue2 = @$filter["y_AngsuranKe"];
		$this->AngsuranKe->AdvancedSearch->SearchOperator2 = @$filter["w_AngsuranKe"];
		$this->AngsuranKe->AdvancedSearch->Save();

		// Field AngsuranTanggal
		$this->AngsuranTanggal->AdvancedSearch->SearchValue = @$filter["x_AngsuranTanggal"];
		$this->AngsuranTanggal->AdvancedSearch->SearchOperator = @$filter["z_AngsuranTanggal"];
		$this->AngsuranTanggal->AdvancedSearch->SearchCondition = @$filter["v_AngsuranTanggal"];
		$this->AngsuranTanggal->AdvancedSearch->SearchValue2 = @$filter["y_AngsuranTanggal"];
		$this->AngsuranTanggal->AdvancedSearch->SearchOperator2 = @$filter["w_AngsuranTanggal"];
		$this->AngsuranTanggal->AdvancedSearch->Save();

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

		// Field SisaHutang
		$this->SisaHutang->AdvancedSearch->SearchValue = @$filter["x_SisaHutang"];
		$this->SisaHutang->AdvancedSearch->SearchOperator = @$filter["z_SisaHutang"];
		$this->SisaHutang->AdvancedSearch->SearchCondition = @$filter["v_SisaHutang"];
		$this->SisaHutang->AdvancedSearch->SearchValue2 = @$filter["y_SisaHutang"];
		$this->SisaHutang->AdvancedSearch->SearchOperator2 = @$filter["w_SisaHutang"];
		$this->SisaHutang->AdvancedSearch->Save();

		// Field TanggalBayar
		$this->TanggalBayar->AdvancedSearch->SearchValue = @$filter["x_TanggalBayar"];
		$this->TanggalBayar->AdvancedSearch->SearchOperator = @$filter["z_TanggalBayar"];
		$this->TanggalBayar->AdvancedSearch->SearchCondition = @$filter["v_TanggalBayar"];
		$this->TanggalBayar->AdvancedSearch->SearchValue2 = @$filter["y_TanggalBayar"];
		$this->TanggalBayar->AdvancedSearch->SearchOperator2 = @$filter["w_TanggalBayar"];
		$this->TanggalBayar->AdvancedSearch->Save();

		// Field TotalDenda
		$this->TotalDenda->AdvancedSearch->SearchValue = @$filter["x_TotalDenda"];
		$this->TotalDenda->AdvancedSearch->SearchOperator = @$filter["z_TotalDenda"];
		$this->TotalDenda->AdvancedSearch->SearchCondition = @$filter["v_TotalDenda"];
		$this->TotalDenda->AdvancedSearch->SearchValue2 = @$filter["y_TotalDenda"];
		$this->TotalDenda->AdvancedSearch->SearchOperator2 = @$filter["w_TotalDenda"];
		$this->TotalDenda->AdvancedSearch->Save();

		// Field Terlambat
		$this->Terlambat->AdvancedSearch->SearchValue = @$filter["x_Terlambat"];
		$this->Terlambat->AdvancedSearch->SearchOperator = @$filter["z_Terlambat"];
		$this->Terlambat->AdvancedSearch->SearchCondition = @$filter["v_Terlambat"];
		$this->Terlambat->AdvancedSearch->SearchValue2 = @$filter["y_Terlambat"];
		$this->Terlambat->AdvancedSearch->SearchOperator2 = @$filter["w_Terlambat"];
		$this->Terlambat->AdvancedSearch->Save();

		// Field Keterangan
		$this->Keterangan->AdvancedSearch->SearchValue = @$filter["x_Keterangan"];
		$this->Keterangan->AdvancedSearch->SearchOperator = @$filter["z_Keterangan"];
		$this->Keterangan->AdvancedSearch->SearchCondition = @$filter["v_Keterangan"];
		$this->Keterangan->AdvancedSearch->SearchValue2 = @$filter["y_Keterangan"];
		$this->Keterangan->AdvancedSearch->SearchOperator2 = @$filter["w_Keterangan"];
		$this->Keterangan->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->Keterangan, $arKeywords, $type);
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
			$this->UpdateSort($this->id, $bCtrl); // id
			$this->UpdateSort($this->pinjaman_id, $bCtrl); // pinjaman_id
			$this->UpdateSort($this->AngsuranKe, $bCtrl); // AngsuranKe
			$this->UpdateSort($this->AngsuranTanggal, $bCtrl); // AngsuranTanggal
			$this->UpdateSort($this->AngsuranPokok, $bCtrl); // AngsuranPokok
			$this->UpdateSort($this->AngsuranBunga, $bCtrl); // AngsuranBunga
			$this->UpdateSort($this->AngsuranTotal, $bCtrl); // AngsuranTotal
			$this->UpdateSort($this->SisaHutang, $bCtrl); // SisaHutang
			$this->UpdateSort($this->TanggalBayar, $bCtrl); // TanggalBayar
			$this->UpdateSort($this->TotalDenda, $bCtrl); // TotalDenda
			$this->UpdateSort($this->Terlambat, $bCtrl); // Terlambat
			$this->UpdateSort($this->Keterangan, $bCtrl); // Keterangan
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

			// Reset master/detail keys
			if ($this->Command == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->pinjaman_id->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->id->setSort("");
				$this->pinjaman_id->setSort("");
				$this->AngsuranKe->setSort("");
				$this->AngsuranTanggal->setSort("");
				$this->AngsuranPokok->setSort("");
				$this->AngsuranBunga->setSort("");
				$this->AngsuranTotal->setSort("");
				$this->SisaHutang->setSort("");
				$this->TanggalBayar->setSort("");
				$this->TotalDenda->setSort("");
				$this->Terlambat->setSort("");
				$this->Keterangan->setSort("");
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

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanView();
		$item->OnLeft = TRUE;

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

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"ft04_angsuranlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"ft04_angsuranlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.ft04_angsuranlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"ft04_angsuranlistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
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
		$this->pinjaman_id->setDbValue($row['pinjaman_id']);
		$this->AngsuranKe->setDbValue($row['AngsuranKe']);
		$this->AngsuranTanggal->setDbValue($row['AngsuranTanggal']);
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
		$row['pinjaman_id'] = NULL;
		$row['AngsuranKe'] = NULL;
		$row['AngsuranTanggal'] = NULL;
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
		$this->pinjaman_id->DbValue = $row['pinjaman_id'];
		$this->AngsuranKe->DbValue = $row['AngsuranKe'];
		$this->AngsuranTanggal->DbValue = $row['AngsuranTanggal'];
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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
		// pinjaman_id
		// AngsuranKe
		// AngsuranTanggal
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

		// pinjaman_id
		$this->pinjaman_id->ViewValue = $this->pinjaman_id->CurrentValue;
		$this->pinjaman_id->ViewCustomAttributes = "";

		// AngsuranKe
		$this->AngsuranKe->ViewValue = $this->AngsuranKe->CurrentValue;
		$this->AngsuranKe->ViewCustomAttributes = "";

		// AngsuranTanggal
		$this->AngsuranTanggal->ViewValue = $this->AngsuranTanggal->CurrentValue;
		$this->AngsuranTanggal->ViewValue = ew_FormatDateTime($this->AngsuranTanggal->ViewValue, 7);
		$this->AngsuranTanggal->ViewCustomAttributes = "";

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

		// SisaHutang
		$this->SisaHutang->ViewValue = $this->SisaHutang->CurrentValue;
		$this->SisaHutang->ViewValue = ew_FormatNumber($this->SisaHutang->ViewValue, 2, -2, -2, -2);
		$this->SisaHutang->CellCssStyle .= "text-align: right;";
		$this->SisaHutang->ViewCustomAttributes = "";

		// TanggalBayar
		$this->TanggalBayar->ViewValue = $this->TanggalBayar->CurrentValue;
		$this->TanggalBayar->ViewValue = ew_FormatDateTime($this->TanggalBayar->ViewValue, 7);
		$this->TanggalBayar->ViewCustomAttributes = "";

		// TotalDenda
		$this->TotalDenda->ViewValue = $this->TotalDenda->CurrentValue;
		$this->TotalDenda->ViewValue = ew_FormatNumber($this->TotalDenda->ViewValue, 2, -2, -2, -2);
		$this->TotalDenda->CellCssStyle .= "text-align: right;";
		$this->TotalDenda->ViewCustomAttributes = "";

		// Terlambat
		$this->Terlambat->ViewValue = $this->Terlambat->CurrentValue;
		$this->Terlambat->ViewValue = ew_FormatNumber($this->Terlambat->ViewValue, 0, -2, -2, -2);
		$this->Terlambat->CellCssStyle .= "text-align: right;";
		$this->Terlambat->ViewCustomAttributes = "";

		// Keterangan
		$this->Keterangan->ViewValue = $this->Keterangan->CurrentValue;
		$this->Keterangan->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// pinjaman_id
			$this->pinjaman_id->LinkCustomAttributes = "";
			$this->pinjaman_id->HrefValue = "";
			$this->pinjaman_id->TooltipValue = "";

			// AngsuranKe
			$this->AngsuranKe->LinkCustomAttributes = "";
			$this->AngsuranKe->HrefValue = "";
			$this->AngsuranKe->TooltipValue = "";

			// AngsuranTanggal
			$this->AngsuranTanggal->LinkCustomAttributes = "";
			$this->AngsuranTanggal->HrefValue = "";
			$this->AngsuranTanggal->TooltipValue = "";

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
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

			// Update URL
			$this->AddUrl = $this->AddMasterUrl($this->AddUrl);
			$this->InlineAddUrl = $this->AddMasterUrl($this->InlineAddUrl);
			$this->GridAddUrl = $this->AddMasterUrl($this->GridAddUrl);
			$this->GridEditUrl = $this->AddMasterUrl($this->GridEditUrl);

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
if (!isset($t04_angsuran_list)) $t04_angsuran_list = new ct04_angsuran_list();

// Page init
$t04_angsuran_list->Page_Init();

// Page main
$t04_angsuran_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t04_angsuran_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = ft04_angsuranlist = new ew_Form("ft04_angsuranlist", "list");
ft04_angsuranlist.FormKeyCountName = '<?php echo $t04_angsuran_list->FormKeyCountName ?>';

// Form_CustomValidate event
ft04_angsuranlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft04_angsuranlist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = ft04_angsuranlistsrch = new ew_Form("ft04_angsuranlistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php if ($t04_angsuran_list->TotalRecs > 0 && $t04_angsuran_list->ExportOptions->Visible()) { ?>
<?php $t04_angsuran_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($t04_angsuran_list->SearchOptions->Visible()) { ?>
<?php $t04_angsuran_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($t04_angsuran_list->FilterOptions->Visible()) { ?>
<?php $t04_angsuran_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php if (($t04_angsuran->Export == "") || (EW_EXPORT_MASTER_RECORD && $t04_angsuran->Export == "print")) { ?>
<?php
if ($t04_angsuran_list->DbMasterFilter <> "" && $t04_angsuran->getCurrentMasterTable() == "t03_pinjaman") {
	if ($t04_angsuran_list->MasterRecordExists) {
?>
<?php include_once "t03_pinjamanmaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
	$bSelectLimit = $t04_angsuran_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t04_angsuran_list->TotalRecs <= 0)
			$t04_angsuran_list->TotalRecs = $t04_angsuran->ListRecordCount();
	} else {
		if (!$t04_angsuran_list->Recordset && ($t04_angsuran_list->Recordset = $t04_angsuran_list->LoadRecordset()))
			$t04_angsuran_list->TotalRecs = $t04_angsuran_list->Recordset->RecordCount();
	}
	$t04_angsuran_list->StartRec = 1;
	if ($t04_angsuran_list->DisplayRecs <= 0 || ($t04_angsuran->Export <> "" && $t04_angsuran->ExportAll)) // Display all records
		$t04_angsuran_list->DisplayRecs = $t04_angsuran_list->TotalRecs;
	if (!($t04_angsuran->Export <> "" && $t04_angsuran->ExportAll))
		$t04_angsuran_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$t04_angsuran_list->Recordset = $t04_angsuran_list->LoadRecordset($t04_angsuran_list->StartRec-1, $t04_angsuran_list->DisplayRecs);

	// Set no record found message
	if ($t04_angsuran->CurrentAction == "" && $t04_angsuran_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$t04_angsuran_list->setWarningMessage(ew_DeniedMsg());
		if ($t04_angsuran_list->SearchWhere == "0=101")
			$t04_angsuran_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t04_angsuran_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$t04_angsuran_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($t04_angsuran->Export == "" && $t04_angsuran->CurrentAction == "") { ?>
<form name="ft04_angsuranlistsrch" id="ft04_angsuranlistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($t04_angsuran_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="ft04_angsuranlistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="t04_angsuran">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($t04_angsuran_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($t04_angsuran_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $t04_angsuran_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($t04_angsuran_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($t04_angsuran_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($t04_angsuran_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($t04_angsuran_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $t04_angsuran_list->ShowPageHeader(); ?>
<?php
$t04_angsuran_list->ShowMessage();
?>
<?php if ($t04_angsuran_list->TotalRecs > 0 || $t04_angsuran->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($t04_angsuran_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> t04_angsuran">
<form name="ft04_angsuranlist" id="ft04_angsuranlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t04_angsuran_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t04_angsuran_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t04_angsuran">
<?php if ($t04_angsuran->getCurrentMasterTable() == "t03_pinjaman" && $t04_angsuran->CurrentAction <> "") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="t03_pinjaman">
<input type="hidden" name="fk_id" value="<?php echo $t04_angsuran->pinjaman_id->getSessionValue() ?>">
<?php } ?>
<div id="gmp_t04_angsuran" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($t04_angsuran_list->TotalRecs > 0 || $t04_angsuran->CurrentAction == "gridedit") { ?>
<table id="tbl_t04_angsuranlist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$t04_angsuran_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t04_angsuran_list->RenderListOptions();

// Render list options (header, left)
$t04_angsuran_list->ListOptions->Render("header", "left");
?>
<?php if ($t04_angsuran->id->Visible) { // id ?>
	<?php if ($t04_angsuran->SortUrl($t04_angsuran->id) == "") { ?>
		<th data-name="id" class="<?php echo $t04_angsuran->id->HeaderCellClass() ?>"><div id="elh_t04_angsuran_id" class="t04_angsuran_id"><div class="ewTableHeaderCaption"><?php echo $t04_angsuran->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id" class="<?php echo $t04_angsuran->id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t04_angsuran->SortUrl($t04_angsuran->id) ?>',2);"><div id="elh_t04_angsuran_id" class="t04_angsuran_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t04_angsuran->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t04_angsuran->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t04_angsuran->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t04_angsuran->pinjaman_id->Visible) { // pinjaman_id ?>
	<?php if ($t04_angsuran->SortUrl($t04_angsuran->pinjaman_id) == "") { ?>
		<th data-name="pinjaman_id" class="<?php echo $t04_angsuran->pinjaman_id->HeaderCellClass() ?>"><div id="elh_t04_angsuran_pinjaman_id" class="t04_angsuran_pinjaman_id"><div class="ewTableHeaderCaption"><?php echo $t04_angsuran->pinjaman_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pinjaman_id" class="<?php echo $t04_angsuran->pinjaman_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t04_angsuran->SortUrl($t04_angsuran->pinjaman_id) ?>',2);"><div id="elh_t04_angsuran_pinjaman_id" class="t04_angsuran_pinjaman_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t04_angsuran->pinjaman_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t04_angsuran->pinjaman_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t04_angsuran->pinjaman_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t04_angsuran->AngsuranKe->Visible) { // AngsuranKe ?>
	<?php if ($t04_angsuran->SortUrl($t04_angsuran->AngsuranKe) == "") { ?>
		<th data-name="AngsuranKe" class="<?php echo $t04_angsuran->AngsuranKe->HeaderCellClass() ?>"><div id="elh_t04_angsuran_AngsuranKe" class="t04_angsuran_AngsuranKe"><div class="ewTableHeaderCaption"><?php echo $t04_angsuran->AngsuranKe->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="AngsuranKe" class="<?php echo $t04_angsuran->AngsuranKe->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t04_angsuran->SortUrl($t04_angsuran->AngsuranKe) ?>',2);"><div id="elh_t04_angsuran_AngsuranKe" class="t04_angsuran_AngsuranKe">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t04_angsuran->AngsuranKe->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t04_angsuran->AngsuranKe->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t04_angsuran->AngsuranKe->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t04_angsuran->AngsuranTanggal->Visible) { // AngsuranTanggal ?>
	<?php if ($t04_angsuran->SortUrl($t04_angsuran->AngsuranTanggal) == "") { ?>
		<th data-name="AngsuranTanggal" class="<?php echo $t04_angsuran->AngsuranTanggal->HeaderCellClass() ?>"><div id="elh_t04_angsuran_AngsuranTanggal" class="t04_angsuran_AngsuranTanggal"><div class="ewTableHeaderCaption"><?php echo $t04_angsuran->AngsuranTanggal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="AngsuranTanggal" class="<?php echo $t04_angsuran->AngsuranTanggal->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t04_angsuran->SortUrl($t04_angsuran->AngsuranTanggal) ?>',2);"><div id="elh_t04_angsuran_AngsuranTanggal" class="t04_angsuran_AngsuranTanggal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t04_angsuran->AngsuranTanggal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t04_angsuran->AngsuranTanggal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t04_angsuran->AngsuranTanggal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t04_angsuran->AngsuranPokok->Visible) { // AngsuranPokok ?>
	<?php if ($t04_angsuran->SortUrl($t04_angsuran->AngsuranPokok) == "") { ?>
		<th data-name="AngsuranPokok" class="<?php echo $t04_angsuran->AngsuranPokok->HeaderCellClass() ?>"><div id="elh_t04_angsuran_AngsuranPokok" class="t04_angsuran_AngsuranPokok"><div class="ewTableHeaderCaption"><?php echo $t04_angsuran->AngsuranPokok->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="AngsuranPokok" class="<?php echo $t04_angsuran->AngsuranPokok->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t04_angsuran->SortUrl($t04_angsuran->AngsuranPokok) ?>',2);"><div id="elh_t04_angsuran_AngsuranPokok" class="t04_angsuran_AngsuranPokok">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t04_angsuran->AngsuranPokok->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t04_angsuran->AngsuranPokok->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t04_angsuran->AngsuranPokok->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t04_angsuran->AngsuranBunga->Visible) { // AngsuranBunga ?>
	<?php if ($t04_angsuran->SortUrl($t04_angsuran->AngsuranBunga) == "") { ?>
		<th data-name="AngsuranBunga" class="<?php echo $t04_angsuran->AngsuranBunga->HeaderCellClass() ?>"><div id="elh_t04_angsuran_AngsuranBunga" class="t04_angsuran_AngsuranBunga"><div class="ewTableHeaderCaption"><?php echo $t04_angsuran->AngsuranBunga->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="AngsuranBunga" class="<?php echo $t04_angsuran->AngsuranBunga->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t04_angsuran->SortUrl($t04_angsuran->AngsuranBunga) ?>',2);"><div id="elh_t04_angsuran_AngsuranBunga" class="t04_angsuran_AngsuranBunga">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t04_angsuran->AngsuranBunga->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t04_angsuran->AngsuranBunga->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t04_angsuran->AngsuranBunga->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t04_angsuran->AngsuranTotal->Visible) { // AngsuranTotal ?>
	<?php if ($t04_angsuran->SortUrl($t04_angsuran->AngsuranTotal) == "") { ?>
		<th data-name="AngsuranTotal" class="<?php echo $t04_angsuran->AngsuranTotal->HeaderCellClass() ?>"><div id="elh_t04_angsuran_AngsuranTotal" class="t04_angsuran_AngsuranTotal"><div class="ewTableHeaderCaption"><?php echo $t04_angsuran->AngsuranTotal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="AngsuranTotal" class="<?php echo $t04_angsuran->AngsuranTotal->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t04_angsuran->SortUrl($t04_angsuran->AngsuranTotal) ?>',2);"><div id="elh_t04_angsuran_AngsuranTotal" class="t04_angsuran_AngsuranTotal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t04_angsuran->AngsuranTotal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t04_angsuran->AngsuranTotal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t04_angsuran->AngsuranTotal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t04_angsuran->SisaHutang->Visible) { // SisaHutang ?>
	<?php if ($t04_angsuran->SortUrl($t04_angsuran->SisaHutang) == "") { ?>
		<th data-name="SisaHutang" class="<?php echo $t04_angsuran->SisaHutang->HeaderCellClass() ?>"><div id="elh_t04_angsuran_SisaHutang" class="t04_angsuran_SisaHutang"><div class="ewTableHeaderCaption"><?php echo $t04_angsuran->SisaHutang->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="SisaHutang" class="<?php echo $t04_angsuran->SisaHutang->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t04_angsuran->SortUrl($t04_angsuran->SisaHutang) ?>',2);"><div id="elh_t04_angsuran_SisaHutang" class="t04_angsuran_SisaHutang">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t04_angsuran->SisaHutang->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t04_angsuran->SisaHutang->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t04_angsuran->SisaHutang->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t04_angsuran->TanggalBayar->Visible) { // TanggalBayar ?>
	<?php if ($t04_angsuran->SortUrl($t04_angsuran->TanggalBayar) == "") { ?>
		<th data-name="TanggalBayar" class="<?php echo $t04_angsuran->TanggalBayar->HeaderCellClass() ?>"><div id="elh_t04_angsuran_TanggalBayar" class="t04_angsuran_TanggalBayar"><div class="ewTableHeaderCaption"><?php echo $t04_angsuran->TanggalBayar->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="TanggalBayar" class="<?php echo $t04_angsuran->TanggalBayar->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t04_angsuran->SortUrl($t04_angsuran->TanggalBayar) ?>',2);"><div id="elh_t04_angsuran_TanggalBayar" class="t04_angsuran_TanggalBayar">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t04_angsuran->TanggalBayar->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t04_angsuran->TanggalBayar->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t04_angsuran->TanggalBayar->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t04_angsuran->TotalDenda->Visible) { // TotalDenda ?>
	<?php if ($t04_angsuran->SortUrl($t04_angsuran->TotalDenda) == "") { ?>
		<th data-name="TotalDenda" class="<?php echo $t04_angsuran->TotalDenda->HeaderCellClass() ?>"><div id="elh_t04_angsuran_TotalDenda" class="t04_angsuran_TotalDenda"><div class="ewTableHeaderCaption"><?php echo $t04_angsuran->TotalDenda->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="TotalDenda" class="<?php echo $t04_angsuran->TotalDenda->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t04_angsuran->SortUrl($t04_angsuran->TotalDenda) ?>',2);"><div id="elh_t04_angsuran_TotalDenda" class="t04_angsuran_TotalDenda">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t04_angsuran->TotalDenda->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t04_angsuran->TotalDenda->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t04_angsuran->TotalDenda->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t04_angsuran->Terlambat->Visible) { // Terlambat ?>
	<?php if ($t04_angsuran->SortUrl($t04_angsuran->Terlambat) == "") { ?>
		<th data-name="Terlambat" class="<?php echo $t04_angsuran->Terlambat->HeaderCellClass() ?>"><div id="elh_t04_angsuran_Terlambat" class="t04_angsuran_Terlambat"><div class="ewTableHeaderCaption"><?php echo $t04_angsuran->Terlambat->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Terlambat" class="<?php echo $t04_angsuran->Terlambat->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t04_angsuran->SortUrl($t04_angsuran->Terlambat) ?>',2);"><div id="elh_t04_angsuran_Terlambat" class="t04_angsuran_Terlambat">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t04_angsuran->Terlambat->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t04_angsuran->Terlambat->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t04_angsuran->Terlambat->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t04_angsuran->Keterangan->Visible) { // Keterangan ?>
	<?php if ($t04_angsuran->SortUrl($t04_angsuran->Keterangan) == "") { ?>
		<th data-name="Keterangan" class="<?php echo $t04_angsuran->Keterangan->HeaderCellClass() ?>"><div id="elh_t04_angsuran_Keterangan" class="t04_angsuran_Keterangan"><div class="ewTableHeaderCaption"><?php echo $t04_angsuran->Keterangan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Keterangan" class="<?php echo $t04_angsuran->Keterangan->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t04_angsuran->SortUrl($t04_angsuran->Keterangan) ?>',2);"><div id="elh_t04_angsuran_Keterangan" class="t04_angsuran_Keterangan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t04_angsuran->Keterangan->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t04_angsuran->Keterangan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t04_angsuran->Keterangan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$t04_angsuran_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($t04_angsuran->ExportAll && $t04_angsuran->Export <> "") {
	$t04_angsuran_list->StopRec = $t04_angsuran_list->TotalRecs;
} else {

	// Set the last record to display
	if ($t04_angsuran_list->TotalRecs > $t04_angsuran_list->StartRec + $t04_angsuran_list->DisplayRecs - 1)
		$t04_angsuran_list->StopRec = $t04_angsuran_list->StartRec + $t04_angsuran_list->DisplayRecs - 1;
	else
		$t04_angsuran_list->StopRec = $t04_angsuran_list->TotalRecs;
}
$t04_angsuran_list->RecCnt = $t04_angsuran_list->StartRec - 1;
if ($t04_angsuran_list->Recordset && !$t04_angsuran_list->Recordset->EOF) {
	$t04_angsuran_list->Recordset->MoveFirst();
	$bSelectLimit = $t04_angsuran_list->UseSelectLimit;
	if (!$bSelectLimit && $t04_angsuran_list->StartRec > 1)
		$t04_angsuran_list->Recordset->Move($t04_angsuran_list->StartRec - 1);
} elseif (!$t04_angsuran->AllowAddDeleteRow && $t04_angsuran_list->StopRec == 0) {
	$t04_angsuran_list->StopRec = $t04_angsuran->GridAddRowCount;
}

// Initialize aggregate
$t04_angsuran->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t04_angsuran->ResetAttrs();
$t04_angsuran_list->RenderRow();
while ($t04_angsuran_list->RecCnt < $t04_angsuran_list->StopRec) {
	$t04_angsuran_list->RecCnt++;
	if (intval($t04_angsuran_list->RecCnt) >= intval($t04_angsuran_list->StartRec)) {
		$t04_angsuran_list->RowCnt++;

		// Set up key count
		$t04_angsuran_list->KeyCount = $t04_angsuran_list->RowIndex;

		// Init row class and style
		$t04_angsuran->ResetAttrs();
		$t04_angsuran->CssClass = "";
		if ($t04_angsuran->CurrentAction == "gridadd") {
		} else {
			$t04_angsuran_list->LoadRowValues($t04_angsuran_list->Recordset); // Load row values
		}
		$t04_angsuran->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$t04_angsuran->RowAttrs = array_merge($t04_angsuran->RowAttrs, array('data-rowindex'=>$t04_angsuran_list->RowCnt, 'id'=>'r' . $t04_angsuran_list->RowCnt . '_t04_angsuran', 'data-rowtype'=>$t04_angsuran->RowType));

		// Render row
		$t04_angsuran_list->RenderRow();

		// Render list options
		$t04_angsuran_list->RenderListOptions();
?>
	<tr<?php echo $t04_angsuran->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t04_angsuran_list->ListOptions->Render("body", "left", $t04_angsuran_list->RowCnt);
?>
	<?php if ($t04_angsuran->id->Visible) { // id ?>
		<td data-name="id"<?php echo $t04_angsuran->id->CellAttributes() ?>>
<span id="el<?php echo $t04_angsuran_list->RowCnt ?>_t04_angsuran_id" class="t04_angsuran_id">
<span<?php echo $t04_angsuran->id->ViewAttributes() ?>>
<?php echo $t04_angsuran->id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t04_angsuran->pinjaman_id->Visible) { // pinjaman_id ?>
		<td data-name="pinjaman_id"<?php echo $t04_angsuran->pinjaman_id->CellAttributes() ?>>
<span id="el<?php echo $t04_angsuran_list->RowCnt ?>_t04_angsuran_pinjaman_id" class="t04_angsuran_pinjaman_id">
<span<?php echo $t04_angsuran->pinjaman_id->ViewAttributes() ?>>
<?php echo $t04_angsuran->pinjaman_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t04_angsuran->AngsuranKe->Visible) { // AngsuranKe ?>
		<td data-name="AngsuranKe"<?php echo $t04_angsuran->AngsuranKe->CellAttributes() ?>>
<span id="el<?php echo $t04_angsuran_list->RowCnt ?>_t04_angsuran_AngsuranKe" class="t04_angsuran_AngsuranKe">
<span<?php echo $t04_angsuran->AngsuranKe->ViewAttributes() ?>>
<?php echo $t04_angsuran->AngsuranKe->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t04_angsuran->AngsuranTanggal->Visible) { // AngsuranTanggal ?>
		<td data-name="AngsuranTanggal"<?php echo $t04_angsuran->AngsuranTanggal->CellAttributes() ?>>
<span id="el<?php echo $t04_angsuran_list->RowCnt ?>_t04_angsuran_AngsuranTanggal" class="t04_angsuran_AngsuranTanggal">
<span<?php echo $t04_angsuran->AngsuranTanggal->ViewAttributes() ?>>
<?php echo $t04_angsuran->AngsuranTanggal->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t04_angsuran->AngsuranPokok->Visible) { // AngsuranPokok ?>
		<td data-name="AngsuranPokok"<?php echo $t04_angsuran->AngsuranPokok->CellAttributes() ?>>
<span id="el<?php echo $t04_angsuran_list->RowCnt ?>_t04_angsuran_AngsuranPokok" class="t04_angsuran_AngsuranPokok">
<span<?php echo $t04_angsuran->AngsuranPokok->ViewAttributes() ?>>
<?php echo $t04_angsuran->AngsuranPokok->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t04_angsuran->AngsuranBunga->Visible) { // AngsuranBunga ?>
		<td data-name="AngsuranBunga"<?php echo $t04_angsuran->AngsuranBunga->CellAttributes() ?>>
<span id="el<?php echo $t04_angsuran_list->RowCnt ?>_t04_angsuran_AngsuranBunga" class="t04_angsuran_AngsuranBunga">
<span<?php echo $t04_angsuran->AngsuranBunga->ViewAttributes() ?>>
<?php echo $t04_angsuran->AngsuranBunga->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t04_angsuran->AngsuranTotal->Visible) { // AngsuranTotal ?>
		<td data-name="AngsuranTotal"<?php echo $t04_angsuran->AngsuranTotal->CellAttributes() ?>>
<span id="el<?php echo $t04_angsuran_list->RowCnt ?>_t04_angsuran_AngsuranTotal" class="t04_angsuran_AngsuranTotal">
<span<?php echo $t04_angsuran->AngsuranTotal->ViewAttributes() ?>>
<?php echo $t04_angsuran->AngsuranTotal->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t04_angsuran->SisaHutang->Visible) { // SisaHutang ?>
		<td data-name="SisaHutang"<?php echo $t04_angsuran->SisaHutang->CellAttributes() ?>>
<span id="el<?php echo $t04_angsuran_list->RowCnt ?>_t04_angsuran_SisaHutang" class="t04_angsuran_SisaHutang">
<span<?php echo $t04_angsuran->SisaHutang->ViewAttributes() ?>>
<?php echo $t04_angsuran->SisaHutang->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t04_angsuran->TanggalBayar->Visible) { // TanggalBayar ?>
		<td data-name="TanggalBayar"<?php echo $t04_angsuran->TanggalBayar->CellAttributes() ?>>
<span id="el<?php echo $t04_angsuran_list->RowCnt ?>_t04_angsuran_TanggalBayar" class="t04_angsuran_TanggalBayar">
<span<?php echo $t04_angsuran->TanggalBayar->ViewAttributes() ?>>
<?php echo $t04_angsuran->TanggalBayar->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t04_angsuran->TotalDenda->Visible) { // TotalDenda ?>
		<td data-name="TotalDenda"<?php echo $t04_angsuran->TotalDenda->CellAttributes() ?>>
<span id="el<?php echo $t04_angsuran_list->RowCnt ?>_t04_angsuran_TotalDenda" class="t04_angsuran_TotalDenda">
<span<?php echo $t04_angsuran->TotalDenda->ViewAttributes() ?>>
<?php echo $t04_angsuran->TotalDenda->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t04_angsuran->Terlambat->Visible) { // Terlambat ?>
		<td data-name="Terlambat"<?php echo $t04_angsuran->Terlambat->CellAttributes() ?>>
<span id="el<?php echo $t04_angsuran_list->RowCnt ?>_t04_angsuran_Terlambat" class="t04_angsuran_Terlambat">
<span<?php echo $t04_angsuran->Terlambat->ViewAttributes() ?>>
<?php echo $t04_angsuran->Terlambat->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t04_angsuran->Keterangan->Visible) { // Keterangan ?>
		<td data-name="Keterangan"<?php echo $t04_angsuran->Keterangan->CellAttributes() ?>>
<span id="el<?php echo $t04_angsuran_list->RowCnt ?>_t04_angsuran_Keterangan" class="t04_angsuran_Keterangan">
<span<?php echo $t04_angsuran->Keterangan->ViewAttributes() ?>>
<?php echo $t04_angsuran->Keterangan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t04_angsuran_list->ListOptions->Render("body", "right", $t04_angsuran_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($t04_angsuran->CurrentAction <> "gridadd")
		$t04_angsuran_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($t04_angsuran->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($t04_angsuran_list->Recordset)
	$t04_angsuran_list->Recordset->Close();
?>
<div class="box-footer ewGridLowerPanel">
<?php if ($t04_angsuran->CurrentAction <> "gridadd" && $t04_angsuran->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t04_angsuran_list->Pager)) $t04_angsuran_list->Pager = new cPrevNextPager($t04_angsuran_list->StartRec, $t04_angsuran_list->DisplayRecs, $t04_angsuran_list->TotalRecs, $t04_angsuran_list->AutoHidePager) ?>
<?php if ($t04_angsuran_list->Pager->RecordCount > 0 && $t04_angsuran_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t04_angsuran_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t04_angsuran_list->PageUrl() ?>start=<?php echo $t04_angsuran_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t04_angsuran_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t04_angsuran_list->PageUrl() ?>start=<?php echo $t04_angsuran_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t04_angsuran_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t04_angsuran_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t04_angsuran_list->PageUrl() ?>start=<?php echo $t04_angsuran_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t04_angsuran_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t04_angsuran_list->PageUrl() ?>start=<?php echo $t04_angsuran_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t04_angsuran_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($t04_angsuran_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $t04_angsuran_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $t04_angsuran_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $t04_angsuran_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($t04_angsuran_list->TotalRecs > 0 && (!$t04_angsuran_list->AutoHidePageSizeSelector || $t04_angsuran_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="t04_angsuran">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($t04_angsuran_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($t04_angsuran_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($t04_angsuran_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($t04_angsuran_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="200"<?php if ($t04_angsuran_list->DisplayRecs == 200) { ?> selected<?php } ?>>200</option>
<option value="ALL"<?php if ($t04_angsuran->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t04_angsuran_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($t04_angsuran_list->TotalRecs == 0 && $t04_angsuran->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t04_angsuran_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
ft04_angsuranlistsrch.FilterList = <?php echo $t04_angsuran_list->GetFilterList() ?>;
ft04_angsuranlistsrch.Init();
ft04_angsuranlist.Init();
</script>
<?php
$t04_angsuran_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t04_angsuran_list->Page_Terminate();
?>
