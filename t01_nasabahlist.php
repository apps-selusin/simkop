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

$t01_nasabah_list = NULL; // Initialize page object first

class ct01_nasabah_list extends ct01_nasabah {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{B3698D9B-8D4B-412E-A2E5-AFAD2FEE5A23}';

	// Table name
	var $TableName = 't01_nasabah';

	// Page object name
	var $PageObjName = 't01_nasabah_list';

	// Grid form hidden field names
	var $FormName = 'ft01_nasabahlist';
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

		// Table object (t01_nasabah)
		if (!isset($GLOBALS["t01_nasabah"]) || get_class($GLOBALS["t01_nasabah"]) == "ct01_nasabah") {
			$GLOBALS["t01_nasabah"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t01_nasabah"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "t01_nasabahadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "t01_nasabahdelete.php";
		$this->MultiUpdateUrl = "t01_nasabahupdate.php";

		// Table object (t96_employees)
		if (!isset($GLOBALS['t96_employees'])) $GLOBALS['t96_employees'] = new ct96_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption ft01_nasabahlistsrch";

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
		$sFilterList = ew_Concat($sFilterList, $this->Customer->AdvancedSearch->ToJson(), ","); // Field Customer
		$sFilterList = ew_Concat($sFilterList, $this->Pekerjaan->AdvancedSearch->ToJson(), ","); // Field Pekerjaan
		$sFilterList = ew_Concat($sFilterList, $this->Alamat->AdvancedSearch->ToJson(), ","); // Field Alamat
		$sFilterList = ew_Concat($sFilterList, $this->NoTelpHp->AdvancedSearch->ToJson(), ","); // Field NoTelpHp
		$sFilterList = ew_Concat($sFilterList, $this->TglKontrak->AdvancedSearch->ToJson(), ","); // Field TglKontrak
		$sFilterList = ew_Concat($sFilterList, $this->MerkType->AdvancedSearch->ToJson(), ","); // Field MerkType
		$sFilterList = ew_Concat($sFilterList, $this->NoRangka->AdvancedSearch->ToJson(), ","); // Field NoRangka
		$sFilterList = ew_Concat($sFilterList, $this->NoMesin->AdvancedSearch->ToJson(), ","); // Field NoMesin
		$sFilterList = ew_Concat($sFilterList, $this->Warna->AdvancedSearch->ToJson(), ","); // Field Warna
		$sFilterList = ew_Concat($sFilterList, $this->NoPol->AdvancedSearch->ToJson(), ","); // Field NoPol
		$sFilterList = ew_Concat($sFilterList, $this->Keterangan->AdvancedSearch->ToJson(), ","); // Field Keterangan
		$sFilterList = ew_Concat($sFilterList, $this->AtasNama->AdvancedSearch->ToJson(), ","); // Field AtasNama
		$sFilterList = ew_Concat($sFilterList, $this->Pinjaman->AdvancedSearch->ToJson(), ","); // Field Pinjaman
		$sFilterList = ew_Concat($sFilterList, $this->Denda->AdvancedSearch->ToJson(), ","); // Field Denda
		$sFilterList = ew_Concat($sFilterList, $this->DispensasiDenda->AdvancedSearch->ToJson(), ","); // Field DispensasiDenda
		$sFilterList = ew_Concat($sFilterList, $this->LamaAngsuran->AdvancedSearch->ToJson(), ","); // Field LamaAngsuran
		$sFilterList = ew_Concat($sFilterList, $this->JumlahAngsuran->AdvancedSearch->ToJson(), ","); // Field JumlahAngsuran
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "ft01_nasabahlistsrch", $filters);

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

		// Field Customer
		$this->Customer->AdvancedSearch->SearchValue = @$filter["x_Customer"];
		$this->Customer->AdvancedSearch->SearchOperator = @$filter["z_Customer"];
		$this->Customer->AdvancedSearch->SearchCondition = @$filter["v_Customer"];
		$this->Customer->AdvancedSearch->SearchValue2 = @$filter["y_Customer"];
		$this->Customer->AdvancedSearch->SearchOperator2 = @$filter["w_Customer"];
		$this->Customer->AdvancedSearch->Save();

		// Field Pekerjaan
		$this->Pekerjaan->AdvancedSearch->SearchValue = @$filter["x_Pekerjaan"];
		$this->Pekerjaan->AdvancedSearch->SearchOperator = @$filter["z_Pekerjaan"];
		$this->Pekerjaan->AdvancedSearch->SearchCondition = @$filter["v_Pekerjaan"];
		$this->Pekerjaan->AdvancedSearch->SearchValue2 = @$filter["y_Pekerjaan"];
		$this->Pekerjaan->AdvancedSearch->SearchOperator2 = @$filter["w_Pekerjaan"];
		$this->Pekerjaan->AdvancedSearch->Save();

		// Field Alamat
		$this->Alamat->AdvancedSearch->SearchValue = @$filter["x_Alamat"];
		$this->Alamat->AdvancedSearch->SearchOperator = @$filter["z_Alamat"];
		$this->Alamat->AdvancedSearch->SearchCondition = @$filter["v_Alamat"];
		$this->Alamat->AdvancedSearch->SearchValue2 = @$filter["y_Alamat"];
		$this->Alamat->AdvancedSearch->SearchOperator2 = @$filter["w_Alamat"];
		$this->Alamat->AdvancedSearch->Save();

		// Field NoTelpHp
		$this->NoTelpHp->AdvancedSearch->SearchValue = @$filter["x_NoTelpHp"];
		$this->NoTelpHp->AdvancedSearch->SearchOperator = @$filter["z_NoTelpHp"];
		$this->NoTelpHp->AdvancedSearch->SearchCondition = @$filter["v_NoTelpHp"];
		$this->NoTelpHp->AdvancedSearch->SearchValue2 = @$filter["y_NoTelpHp"];
		$this->NoTelpHp->AdvancedSearch->SearchOperator2 = @$filter["w_NoTelpHp"];
		$this->NoTelpHp->AdvancedSearch->Save();

		// Field TglKontrak
		$this->TglKontrak->AdvancedSearch->SearchValue = @$filter["x_TglKontrak"];
		$this->TglKontrak->AdvancedSearch->SearchOperator = @$filter["z_TglKontrak"];
		$this->TglKontrak->AdvancedSearch->SearchCondition = @$filter["v_TglKontrak"];
		$this->TglKontrak->AdvancedSearch->SearchValue2 = @$filter["y_TglKontrak"];
		$this->TglKontrak->AdvancedSearch->SearchOperator2 = @$filter["w_TglKontrak"];
		$this->TglKontrak->AdvancedSearch->Save();

		// Field MerkType
		$this->MerkType->AdvancedSearch->SearchValue = @$filter["x_MerkType"];
		$this->MerkType->AdvancedSearch->SearchOperator = @$filter["z_MerkType"];
		$this->MerkType->AdvancedSearch->SearchCondition = @$filter["v_MerkType"];
		$this->MerkType->AdvancedSearch->SearchValue2 = @$filter["y_MerkType"];
		$this->MerkType->AdvancedSearch->SearchOperator2 = @$filter["w_MerkType"];
		$this->MerkType->AdvancedSearch->Save();

		// Field NoRangka
		$this->NoRangka->AdvancedSearch->SearchValue = @$filter["x_NoRangka"];
		$this->NoRangka->AdvancedSearch->SearchOperator = @$filter["z_NoRangka"];
		$this->NoRangka->AdvancedSearch->SearchCondition = @$filter["v_NoRangka"];
		$this->NoRangka->AdvancedSearch->SearchValue2 = @$filter["y_NoRangka"];
		$this->NoRangka->AdvancedSearch->SearchOperator2 = @$filter["w_NoRangka"];
		$this->NoRangka->AdvancedSearch->Save();

		// Field NoMesin
		$this->NoMesin->AdvancedSearch->SearchValue = @$filter["x_NoMesin"];
		$this->NoMesin->AdvancedSearch->SearchOperator = @$filter["z_NoMesin"];
		$this->NoMesin->AdvancedSearch->SearchCondition = @$filter["v_NoMesin"];
		$this->NoMesin->AdvancedSearch->SearchValue2 = @$filter["y_NoMesin"];
		$this->NoMesin->AdvancedSearch->SearchOperator2 = @$filter["w_NoMesin"];
		$this->NoMesin->AdvancedSearch->Save();

		// Field Warna
		$this->Warna->AdvancedSearch->SearchValue = @$filter["x_Warna"];
		$this->Warna->AdvancedSearch->SearchOperator = @$filter["z_Warna"];
		$this->Warna->AdvancedSearch->SearchCondition = @$filter["v_Warna"];
		$this->Warna->AdvancedSearch->SearchValue2 = @$filter["y_Warna"];
		$this->Warna->AdvancedSearch->SearchOperator2 = @$filter["w_Warna"];
		$this->Warna->AdvancedSearch->Save();

		// Field NoPol
		$this->NoPol->AdvancedSearch->SearchValue = @$filter["x_NoPol"];
		$this->NoPol->AdvancedSearch->SearchOperator = @$filter["z_NoPol"];
		$this->NoPol->AdvancedSearch->SearchCondition = @$filter["v_NoPol"];
		$this->NoPol->AdvancedSearch->SearchValue2 = @$filter["y_NoPol"];
		$this->NoPol->AdvancedSearch->SearchOperator2 = @$filter["w_NoPol"];
		$this->NoPol->AdvancedSearch->Save();

		// Field Keterangan
		$this->Keterangan->AdvancedSearch->SearchValue = @$filter["x_Keterangan"];
		$this->Keterangan->AdvancedSearch->SearchOperator = @$filter["z_Keterangan"];
		$this->Keterangan->AdvancedSearch->SearchCondition = @$filter["v_Keterangan"];
		$this->Keterangan->AdvancedSearch->SearchValue2 = @$filter["y_Keterangan"];
		$this->Keterangan->AdvancedSearch->SearchOperator2 = @$filter["w_Keterangan"];
		$this->Keterangan->AdvancedSearch->Save();

		// Field AtasNama
		$this->AtasNama->AdvancedSearch->SearchValue = @$filter["x_AtasNama"];
		$this->AtasNama->AdvancedSearch->SearchOperator = @$filter["z_AtasNama"];
		$this->AtasNama->AdvancedSearch->SearchCondition = @$filter["v_AtasNama"];
		$this->AtasNama->AdvancedSearch->SearchValue2 = @$filter["y_AtasNama"];
		$this->AtasNama->AdvancedSearch->SearchOperator2 = @$filter["w_AtasNama"];
		$this->AtasNama->AdvancedSearch->Save();

		// Field Pinjaman
		$this->Pinjaman->AdvancedSearch->SearchValue = @$filter["x_Pinjaman"];
		$this->Pinjaman->AdvancedSearch->SearchOperator = @$filter["z_Pinjaman"];
		$this->Pinjaman->AdvancedSearch->SearchCondition = @$filter["v_Pinjaman"];
		$this->Pinjaman->AdvancedSearch->SearchValue2 = @$filter["y_Pinjaman"];
		$this->Pinjaman->AdvancedSearch->SearchOperator2 = @$filter["w_Pinjaman"];
		$this->Pinjaman->AdvancedSearch->Save();

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

		// Field LamaAngsuran
		$this->LamaAngsuran->AdvancedSearch->SearchValue = @$filter["x_LamaAngsuran"];
		$this->LamaAngsuran->AdvancedSearch->SearchOperator = @$filter["z_LamaAngsuran"];
		$this->LamaAngsuran->AdvancedSearch->SearchCondition = @$filter["v_LamaAngsuran"];
		$this->LamaAngsuran->AdvancedSearch->SearchValue2 = @$filter["y_LamaAngsuran"];
		$this->LamaAngsuran->AdvancedSearch->SearchOperator2 = @$filter["w_LamaAngsuran"];
		$this->LamaAngsuran->AdvancedSearch->Save();

		// Field JumlahAngsuran
		$this->JumlahAngsuran->AdvancedSearch->SearchValue = @$filter["x_JumlahAngsuran"];
		$this->JumlahAngsuran->AdvancedSearch->SearchOperator = @$filter["z_JumlahAngsuran"];
		$this->JumlahAngsuran->AdvancedSearch->SearchCondition = @$filter["v_JumlahAngsuran"];
		$this->JumlahAngsuran->AdvancedSearch->SearchValue2 = @$filter["y_JumlahAngsuran"];
		$this->JumlahAngsuran->AdvancedSearch->SearchOperator2 = @$filter["w_JumlahAngsuran"];
		$this->JumlahAngsuran->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->NoKontrak, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Customer, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Pekerjaan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Alamat, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->NoTelpHp, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->MerkType, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->NoRangka, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->NoMesin, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Warna, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->NoPol, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Keterangan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->AtasNama, $arKeywords, $type);
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
			$this->UpdateSort($this->NoKontrak, $bCtrl); // NoKontrak
			$this->UpdateSort($this->Customer, $bCtrl); // Customer
			$this->UpdateSort($this->Pekerjaan, $bCtrl); // Pekerjaan
			$this->UpdateSort($this->NoTelpHp, $bCtrl); // NoTelpHp
			$this->UpdateSort($this->TglKontrak, $bCtrl); // TglKontrak
			$this->UpdateSort($this->MerkType, $bCtrl); // MerkType
			$this->UpdateSort($this->NoRangka, $bCtrl); // NoRangka
			$this->UpdateSort($this->NoMesin, $bCtrl); // NoMesin
			$this->UpdateSort($this->Warna, $bCtrl); // Warna
			$this->UpdateSort($this->NoPol, $bCtrl); // NoPol
			$this->UpdateSort($this->AtasNama, $bCtrl); // AtasNama
			$this->UpdateSort($this->Pinjaman, $bCtrl); // Pinjaman
			$this->UpdateSort($this->Denda, $bCtrl); // Denda
			$this->UpdateSort($this->DispensasiDenda, $bCtrl); // DispensasiDenda
			$this->UpdateSort($this->LamaAngsuran, $bCtrl); // LamaAngsuran
			$this->UpdateSort($this->JumlahAngsuran, $bCtrl); // JumlahAngsuran
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
				$this->id->setSort("");
				$this->NoKontrak->setSort("");
				$this->Customer->setSort("");
				$this->Pekerjaan->setSort("");
				$this->NoTelpHp->setSort("");
				$this->TglKontrak->setSort("");
				$this->MerkType->setSort("");
				$this->NoRangka->setSort("");
				$this->NoMesin->setSort("");
				$this->Warna->setSort("");
				$this->NoPol->setSort("");
				$this->AtasNama->setSort("");
				$this->Pinjaman->setSort("");
				$this->Denda->setSort("");
				$this->DispensasiDenda->setSort("");
				$this->LamaAngsuran->setSort("");
				$this->JumlahAngsuran->setSort("");
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
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanView();
		$item->OnLeft = FALSE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = FALSE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanAdd();
		$item->OnLeft = FALSE;

		// "delete"
		$item = &$this->ListOptions->Add("delete");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanDelete();
		$item->OnLeft = FALSE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssClass = "text-nowrap";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = FALSE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"ft01_nasabahlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"ft01_nasabahlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.ft01_nasabahlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"ft01_nasabahlistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
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
if (!isset($t01_nasabah_list)) $t01_nasabah_list = new ct01_nasabah_list();

// Page init
$t01_nasabah_list->Page_Init();

// Page main
$t01_nasabah_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t01_nasabah_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = ft01_nasabahlist = new ew_Form("ft01_nasabahlist", "list");
ft01_nasabahlist.FormKeyCountName = '<?php echo $t01_nasabah_list->FormKeyCountName ?>';

// Form_CustomValidate event
ft01_nasabahlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft01_nasabahlist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = ft01_nasabahlistsrch = new ew_Form("ft01_nasabahlistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php if ($t01_nasabah_list->TotalRecs > 0 && $t01_nasabah_list->ExportOptions->Visible()) { ?>
<?php $t01_nasabah_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($t01_nasabah_list->SearchOptions->Visible()) { ?>
<?php $t01_nasabah_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($t01_nasabah_list->FilterOptions->Visible()) { ?>
<?php $t01_nasabah_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $t01_nasabah_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t01_nasabah_list->TotalRecs <= 0)
			$t01_nasabah_list->TotalRecs = $t01_nasabah->ListRecordCount();
	} else {
		if (!$t01_nasabah_list->Recordset && ($t01_nasabah_list->Recordset = $t01_nasabah_list->LoadRecordset()))
			$t01_nasabah_list->TotalRecs = $t01_nasabah_list->Recordset->RecordCount();
	}
	$t01_nasabah_list->StartRec = 1;
	if ($t01_nasabah_list->DisplayRecs <= 0 || ($t01_nasabah->Export <> "" && $t01_nasabah->ExportAll)) // Display all records
		$t01_nasabah_list->DisplayRecs = $t01_nasabah_list->TotalRecs;
	if (!($t01_nasabah->Export <> "" && $t01_nasabah->ExportAll))
		$t01_nasabah_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$t01_nasabah_list->Recordset = $t01_nasabah_list->LoadRecordset($t01_nasabah_list->StartRec-1, $t01_nasabah_list->DisplayRecs);

	// Set no record found message
	if ($t01_nasabah->CurrentAction == "" && $t01_nasabah_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$t01_nasabah_list->setWarningMessage(ew_DeniedMsg());
		if ($t01_nasabah_list->SearchWhere == "0=101")
			$t01_nasabah_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t01_nasabah_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$t01_nasabah_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($t01_nasabah->Export == "" && $t01_nasabah->CurrentAction == "") { ?>
<form name="ft01_nasabahlistsrch" id="ft01_nasabahlistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($t01_nasabah_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="ft01_nasabahlistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="t01_nasabah">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($t01_nasabah_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($t01_nasabah_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $t01_nasabah_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($t01_nasabah_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($t01_nasabah_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($t01_nasabah_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($t01_nasabah_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $t01_nasabah_list->ShowPageHeader(); ?>
<?php
$t01_nasabah_list->ShowMessage();
?>
<?php if ($t01_nasabah_list->TotalRecs > 0 || $t01_nasabah->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($t01_nasabah_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> t01_nasabah">
<form name="ft01_nasabahlist" id="ft01_nasabahlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t01_nasabah_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t01_nasabah_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t01_nasabah">
<div id="gmp_t01_nasabah" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($t01_nasabah_list->TotalRecs > 0 || $t01_nasabah->CurrentAction == "gridedit") { ?>
<table id="tbl_t01_nasabahlist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$t01_nasabah_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t01_nasabah_list->RenderListOptions();

// Render list options (header, left)
$t01_nasabah_list->ListOptions->Render("header", "left");
?>
<?php if ($t01_nasabah->id->Visible) { // id ?>
	<?php if ($t01_nasabah->SortUrl($t01_nasabah->id) == "") { ?>
		<th data-name="id" class="<?php echo $t01_nasabah->id->HeaderCellClass() ?>"><div id="elh_t01_nasabah_id" class="t01_nasabah_id"><div class="ewTableHeaderCaption"><?php echo $t01_nasabah->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id" class="<?php echo $t01_nasabah->id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t01_nasabah->SortUrl($t01_nasabah->id) ?>',2);"><div id="elh_t01_nasabah_id" class="t01_nasabah_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t01_nasabah->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t01_nasabah->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t01_nasabah->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t01_nasabah->NoKontrak->Visible) { // NoKontrak ?>
	<?php if ($t01_nasabah->SortUrl($t01_nasabah->NoKontrak) == "") { ?>
		<th data-name="NoKontrak" class="<?php echo $t01_nasabah->NoKontrak->HeaderCellClass() ?>"><div id="elh_t01_nasabah_NoKontrak" class="t01_nasabah_NoKontrak"><div class="ewTableHeaderCaption"><?php echo $t01_nasabah->NoKontrak->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NoKontrak" class="<?php echo $t01_nasabah->NoKontrak->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t01_nasabah->SortUrl($t01_nasabah->NoKontrak) ?>',2);"><div id="elh_t01_nasabah_NoKontrak" class="t01_nasabah_NoKontrak">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t01_nasabah->NoKontrak->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t01_nasabah->NoKontrak->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t01_nasabah->NoKontrak->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t01_nasabah->Customer->Visible) { // Customer ?>
	<?php if ($t01_nasabah->SortUrl($t01_nasabah->Customer) == "") { ?>
		<th data-name="Customer" class="<?php echo $t01_nasabah->Customer->HeaderCellClass() ?>"><div id="elh_t01_nasabah_Customer" class="t01_nasabah_Customer"><div class="ewTableHeaderCaption"><?php echo $t01_nasabah->Customer->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Customer" class="<?php echo $t01_nasabah->Customer->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t01_nasabah->SortUrl($t01_nasabah->Customer) ?>',2);"><div id="elh_t01_nasabah_Customer" class="t01_nasabah_Customer">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t01_nasabah->Customer->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t01_nasabah->Customer->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t01_nasabah->Customer->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t01_nasabah->Pekerjaan->Visible) { // Pekerjaan ?>
	<?php if ($t01_nasabah->SortUrl($t01_nasabah->Pekerjaan) == "") { ?>
		<th data-name="Pekerjaan" class="<?php echo $t01_nasabah->Pekerjaan->HeaderCellClass() ?>"><div id="elh_t01_nasabah_Pekerjaan" class="t01_nasabah_Pekerjaan"><div class="ewTableHeaderCaption"><?php echo $t01_nasabah->Pekerjaan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Pekerjaan" class="<?php echo $t01_nasabah->Pekerjaan->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t01_nasabah->SortUrl($t01_nasabah->Pekerjaan) ?>',2);"><div id="elh_t01_nasabah_Pekerjaan" class="t01_nasabah_Pekerjaan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t01_nasabah->Pekerjaan->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t01_nasabah->Pekerjaan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t01_nasabah->Pekerjaan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t01_nasabah->NoTelpHp->Visible) { // NoTelpHp ?>
	<?php if ($t01_nasabah->SortUrl($t01_nasabah->NoTelpHp) == "") { ?>
		<th data-name="NoTelpHp" class="<?php echo $t01_nasabah->NoTelpHp->HeaderCellClass() ?>"><div id="elh_t01_nasabah_NoTelpHp" class="t01_nasabah_NoTelpHp"><div class="ewTableHeaderCaption"><?php echo $t01_nasabah->NoTelpHp->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NoTelpHp" class="<?php echo $t01_nasabah->NoTelpHp->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t01_nasabah->SortUrl($t01_nasabah->NoTelpHp) ?>',2);"><div id="elh_t01_nasabah_NoTelpHp" class="t01_nasabah_NoTelpHp">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t01_nasabah->NoTelpHp->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t01_nasabah->NoTelpHp->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t01_nasabah->NoTelpHp->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t01_nasabah->TglKontrak->Visible) { // TglKontrak ?>
	<?php if ($t01_nasabah->SortUrl($t01_nasabah->TglKontrak) == "") { ?>
		<th data-name="TglKontrak" class="<?php echo $t01_nasabah->TglKontrak->HeaderCellClass() ?>"><div id="elh_t01_nasabah_TglKontrak" class="t01_nasabah_TglKontrak"><div class="ewTableHeaderCaption"><?php echo $t01_nasabah->TglKontrak->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="TglKontrak" class="<?php echo $t01_nasabah->TglKontrak->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t01_nasabah->SortUrl($t01_nasabah->TglKontrak) ?>',2);"><div id="elh_t01_nasabah_TglKontrak" class="t01_nasabah_TglKontrak">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t01_nasabah->TglKontrak->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t01_nasabah->TglKontrak->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t01_nasabah->TglKontrak->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t01_nasabah->MerkType->Visible) { // MerkType ?>
	<?php if ($t01_nasabah->SortUrl($t01_nasabah->MerkType) == "") { ?>
		<th data-name="MerkType" class="<?php echo $t01_nasabah->MerkType->HeaderCellClass() ?>"><div id="elh_t01_nasabah_MerkType" class="t01_nasabah_MerkType"><div class="ewTableHeaderCaption"><?php echo $t01_nasabah->MerkType->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="MerkType" class="<?php echo $t01_nasabah->MerkType->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t01_nasabah->SortUrl($t01_nasabah->MerkType) ?>',2);"><div id="elh_t01_nasabah_MerkType" class="t01_nasabah_MerkType">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t01_nasabah->MerkType->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t01_nasabah->MerkType->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t01_nasabah->MerkType->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t01_nasabah->NoRangka->Visible) { // NoRangka ?>
	<?php if ($t01_nasabah->SortUrl($t01_nasabah->NoRangka) == "") { ?>
		<th data-name="NoRangka" class="<?php echo $t01_nasabah->NoRangka->HeaderCellClass() ?>"><div id="elh_t01_nasabah_NoRangka" class="t01_nasabah_NoRangka"><div class="ewTableHeaderCaption"><?php echo $t01_nasabah->NoRangka->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NoRangka" class="<?php echo $t01_nasabah->NoRangka->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t01_nasabah->SortUrl($t01_nasabah->NoRangka) ?>',2);"><div id="elh_t01_nasabah_NoRangka" class="t01_nasabah_NoRangka">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t01_nasabah->NoRangka->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t01_nasabah->NoRangka->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t01_nasabah->NoRangka->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t01_nasabah->NoMesin->Visible) { // NoMesin ?>
	<?php if ($t01_nasabah->SortUrl($t01_nasabah->NoMesin) == "") { ?>
		<th data-name="NoMesin" class="<?php echo $t01_nasabah->NoMesin->HeaderCellClass() ?>"><div id="elh_t01_nasabah_NoMesin" class="t01_nasabah_NoMesin"><div class="ewTableHeaderCaption"><?php echo $t01_nasabah->NoMesin->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NoMesin" class="<?php echo $t01_nasabah->NoMesin->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t01_nasabah->SortUrl($t01_nasabah->NoMesin) ?>',2);"><div id="elh_t01_nasabah_NoMesin" class="t01_nasabah_NoMesin">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t01_nasabah->NoMesin->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t01_nasabah->NoMesin->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t01_nasabah->NoMesin->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t01_nasabah->Warna->Visible) { // Warna ?>
	<?php if ($t01_nasabah->SortUrl($t01_nasabah->Warna) == "") { ?>
		<th data-name="Warna" class="<?php echo $t01_nasabah->Warna->HeaderCellClass() ?>"><div id="elh_t01_nasabah_Warna" class="t01_nasabah_Warna"><div class="ewTableHeaderCaption"><?php echo $t01_nasabah->Warna->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Warna" class="<?php echo $t01_nasabah->Warna->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t01_nasabah->SortUrl($t01_nasabah->Warna) ?>',2);"><div id="elh_t01_nasabah_Warna" class="t01_nasabah_Warna">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t01_nasabah->Warna->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t01_nasabah->Warna->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t01_nasabah->Warna->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t01_nasabah->NoPol->Visible) { // NoPol ?>
	<?php if ($t01_nasabah->SortUrl($t01_nasabah->NoPol) == "") { ?>
		<th data-name="NoPol" class="<?php echo $t01_nasabah->NoPol->HeaderCellClass() ?>"><div id="elh_t01_nasabah_NoPol" class="t01_nasabah_NoPol"><div class="ewTableHeaderCaption"><?php echo $t01_nasabah->NoPol->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NoPol" class="<?php echo $t01_nasabah->NoPol->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t01_nasabah->SortUrl($t01_nasabah->NoPol) ?>',2);"><div id="elh_t01_nasabah_NoPol" class="t01_nasabah_NoPol">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t01_nasabah->NoPol->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t01_nasabah->NoPol->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t01_nasabah->NoPol->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t01_nasabah->AtasNama->Visible) { // AtasNama ?>
	<?php if ($t01_nasabah->SortUrl($t01_nasabah->AtasNama) == "") { ?>
		<th data-name="AtasNama" class="<?php echo $t01_nasabah->AtasNama->HeaderCellClass() ?>"><div id="elh_t01_nasabah_AtasNama" class="t01_nasabah_AtasNama"><div class="ewTableHeaderCaption"><?php echo $t01_nasabah->AtasNama->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="AtasNama" class="<?php echo $t01_nasabah->AtasNama->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t01_nasabah->SortUrl($t01_nasabah->AtasNama) ?>',2);"><div id="elh_t01_nasabah_AtasNama" class="t01_nasabah_AtasNama">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t01_nasabah->AtasNama->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t01_nasabah->AtasNama->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t01_nasabah->AtasNama->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t01_nasabah->Pinjaman->Visible) { // Pinjaman ?>
	<?php if ($t01_nasabah->SortUrl($t01_nasabah->Pinjaman) == "") { ?>
		<th data-name="Pinjaman" class="<?php echo $t01_nasabah->Pinjaman->HeaderCellClass() ?>"><div id="elh_t01_nasabah_Pinjaman" class="t01_nasabah_Pinjaman"><div class="ewTableHeaderCaption"><?php echo $t01_nasabah->Pinjaman->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Pinjaman" class="<?php echo $t01_nasabah->Pinjaman->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t01_nasabah->SortUrl($t01_nasabah->Pinjaman) ?>',2);"><div id="elh_t01_nasabah_Pinjaman" class="t01_nasabah_Pinjaman">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t01_nasabah->Pinjaman->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t01_nasabah->Pinjaman->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t01_nasabah->Pinjaman->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t01_nasabah->Denda->Visible) { // Denda ?>
	<?php if ($t01_nasabah->SortUrl($t01_nasabah->Denda) == "") { ?>
		<th data-name="Denda" class="<?php echo $t01_nasabah->Denda->HeaderCellClass() ?>"><div id="elh_t01_nasabah_Denda" class="t01_nasabah_Denda"><div class="ewTableHeaderCaption"><?php echo $t01_nasabah->Denda->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Denda" class="<?php echo $t01_nasabah->Denda->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t01_nasabah->SortUrl($t01_nasabah->Denda) ?>',2);"><div id="elh_t01_nasabah_Denda" class="t01_nasabah_Denda">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t01_nasabah->Denda->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t01_nasabah->Denda->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t01_nasabah->Denda->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t01_nasabah->DispensasiDenda->Visible) { // DispensasiDenda ?>
	<?php if ($t01_nasabah->SortUrl($t01_nasabah->DispensasiDenda) == "") { ?>
		<th data-name="DispensasiDenda" class="<?php echo $t01_nasabah->DispensasiDenda->HeaderCellClass() ?>"><div id="elh_t01_nasabah_DispensasiDenda" class="t01_nasabah_DispensasiDenda"><div class="ewTableHeaderCaption"><?php echo $t01_nasabah->DispensasiDenda->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="DispensasiDenda" class="<?php echo $t01_nasabah->DispensasiDenda->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t01_nasabah->SortUrl($t01_nasabah->DispensasiDenda) ?>',2);"><div id="elh_t01_nasabah_DispensasiDenda" class="t01_nasabah_DispensasiDenda">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t01_nasabah->DispensasiDenda->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t01_nasabah->DispensasiDenda->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t01_nasabah->DispensasiDenda->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t01_nasabah->LamaAngsuran->Visible) { // LamaAngsuran ?>
	<?php if ($t01_nasabah->SortUrl($t01_nasabah->LamaAngsuran) == "") { ?>
		<th data-name="LamaAngsuran" class="<?php echo $t01_nasabah->LamaAngsuran->HeaderCellClass() ?>"><div id="elh_t01_nasabah_LamaAngsuran" class="t01_nasabah_LamaAngsuran"><div class="ewTableHeaderCaption"><?php echo $t01_nasabah->LamaAngsuran->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="LamaAngsuran" class="<?php echo $t01_nasabah->LamaAngsuran->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t01_nasabah->SortUrl($t01_nasabah->LamaAngsuran) ?>',2);"><div id="elh_t01_nasabah_LamaAngsuran" class="t01_nasabah_LamaAngsuran">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t01_nasabah->LamaAngsuran->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t01_nasabah->LamaAngsuran->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t01_nasabah->LamaAngsuran->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t01_nasabah->JumlahAngsuran->Visible) { // JumlahAngsuran ?>
	<?php if ($t01_nasabah->SortUrl($t01_nasabah->JumlahAngsuran) == "") { ?>
		<th data-name="JumlahAngsuran" class="<?php echo $t01_nasabah->JumlahAngsuran->HeaderCellClass() ?>"><div id="elh_t01_nasabah_JumlahAngsuran" class="t01_nasabah_JumlahAngsuran"><div class="ewTableHeaderCaption"><?php echo $t01_nasabah->JumlahAngsuran->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="JumlahAngsuran" class="<?php echo $t01_nasabah->JumlahAngsuran->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t01_nasabah->SortUrl($t01_nasabah->JumlahAngsuran) ?>',2);"><div id="elh_t01_nasabah_JumlahAngsuran" class="t01_nasabah_JumlahAngsuran">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t01_nasabah->JumlahAngsuran->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t01_nasabah->JumlahAngsuran->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t01_nasabah->JumlahAngsuran->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$t01_nasabah_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($t01_nasabah->ExportAll && $t01_nasabah->Export <> "") {
	$t01_nasabah_list->StopRec = $t01_nasabah_list->TotalRecs;
} else {

	// Set the last record to display
	if ($t01_nasabah_list->TotalRecs > $t01_nasabah_list->StartRec + $t01_nasabah_list->DisplayRecs - 1)
		$t01_nasabah_list->StopRec = $t01_nasabah_list->StartRec + $t01_nasabah_list->DisplayRecs - 1;
	else
		$t01_nasabah_list->StopRec = $t01_nasabah_list->TotalRecs;
}
$t01_nasabah_list->RecCnt = $t01_nasabah_list->StartRec - 1;
if ($t01_nasabah_list->Recordset && !$t01_nasabah_list->Recordset->EOF) {
	$t01_nasabah_list->Recordset->MoveFirst();
	$bSelectLimit = $t01_nasabah_list->UseSelectLimit;
	if (!$bSelectLimit && $t01_nasabah_list->StartRec > 1)
		$t01_nasabah_list->Recordset->Move($t01_nasabah_list->StartRec - 1);
} elseif (!$t01_nasabah->AllowAddDeleteRow && $t01_nasabah_list->StopRec == 0) {
	$t01_nasabah_list->StopRec = $t01_nasabah->GridAddRowCount;
}

// Initialize aggregate
$t01_nasabah->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t01_nasabah->ResetAttrs();
$t01_nasabah_list->RenderRow();
while ($t01_nasabah_list->RecCnt < $t01_nasabah_list->StopRec) {
	$t01_nasabah_list->RecCnt++;
	if (intval($t01_nasabah_list->RecCnt) >= intval($t01_nasabah_list->StartRec)) {
		$t01_nasabah_list->RowCnt++;

		// Set up key count
		$t01_nasabah_list->KeyCount = $t01_nasabah_list->RowIndex;

		// Init row class and style
		$t01_nasabah->ResetAttrs();
		$t01_nasabah->CssClass = "";
		if ($t01_nasabah->CurrentAction == "gridadd") {
		} else {
			$t01_nasabah_list->LoadRowValues($t01_nasabah_list->Recordset); // Load row values
		}
		$t01_nasabah->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$t01_nasabah->RowAttrs = array_merge($t01_nasabah->RowAttrs, array('data-rowindex'=>$t01_nasabah_list->RowCnt, 'id'=>'r' . $t01_nasabah_list->RowCnt . '_t01_nasabah', 'data-rowtype'=>$t01_nasabah->RowType));

		// Render row
		$t01_nasabah_list->RenderRow();

		// Render list options
		$t01_nasabah_list->RenderListOptions();
?>
	<tr<?php echo $t01_nasabah->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t01_nasabah_list->ListOptions->Render("body", "left", $t01_nasabah_list->RowCnt);
?>
	<?php if ($t01_nasabah->id->Visible) { // id ?>
		<td data-name="id"<?php echo $t01_nasabah->id->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_list->RowCnt ?>_t01_nasabah_id" class="t01_nasabah_id">
<span<?php echo $t01_nasabah->id->ViewAttributes() ?>>
<?php echo $t01_nasabah->id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t01_nasabah->NoKontrak->Visible) { // NoKontrak ?>
		<td data-name="NoKontrak"<?php echo $t01_nasabah->NoKontrak->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_list->RowCnt ?>_t01_nasabah_NoKontrak" class="t01_nasabah_NoKontrak">
<span<?php echo $t01_nasabah->NoKontrak->ViewAttributes() ?>>
<?php echo $t01_nasabah->NoKontrak->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t01_nasabah->Customer->Visible) { // Customer ?>
		<td data-name="Customer"<?php echo $t01_nasabah->Customer->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_list->RowCnt ?>_t01_nasabah_Customer" class="t01_nasabah_Customer">
<span<?php echo $t01_nasabah->Customer->ViewAttributes() ?>>
<?php echo $t01_nasabah->Customer->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t01_nasabah->Pekerjaan->Visible) { // Pekerjaan ?>
		<td data-name="Pekerjaan"<?php echo $t01_nasabah->Pekerjaan->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_list->RowCnt ?>_t01_nasabah_Pekerjaan" class="t01_nasabah_Pekerjaan">
<span<?php echo $t01_nasabah->Pekerjaan->ViewAttributes() ?>>
<?php echo $t01_nasabah->Pekerjaan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t01_nasabah->NoTelpHp->Visible) { // NoTelpHp ?>
		<td data-name="NoTelpHp"<?php echo $t01_nasabah->NoTelpHp->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_list->RowCnt ?>_t01_nasabah_NoTelpHp" class="t01_nasabah_NoTelpHp">
<span<?php echo $t01_nasabah->NoTelpHp->ViewAttributes() ?>>
<?php echo $t01_nasabah->NoTelpHp->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t01_nasabah->TglKontrak->Visible) { // TglKontrak ?>
		<td data-name="TglKontrak"<?php echo $t01_nasabah->TglKontrak->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_list->RowCnt ?>_t01_nasabah_TglKontrak" class="t01_nasabah_TglKontrak">
<span<?php echo $t01_nasabah->TglKontrak->ViewAttributes() ?>>
<?php echo $t01_nasabah->TglKontrak->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t01_nasabah->MerkType->Visible) { // MerkType ?>
		<td data-name="MerkType"<?php echo $t01_nasabah->MerkType->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_list->RowCnt ?>_t01_nasabah_MerkType" class="t01_nasabah_MerkType">
<span<?php echo $t01_nasabah->MerkType->ViewAttributes() ?>>
<?php echo $t01_nasabah->MerkType->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t01_nasabah->NoRangka->Visible) { // NoRangka ?>
		<td data-name="NoRangka"<?php echo $t01_nasabah->NoRangka->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_list->RowCnt ?>_t01_nasabah_NoRangka" class="t01_nasabah_NoRangka">
<span<?php echo $t01_nasabah->NoRangka->ViewAttributes() ?>>
<?php echo $t01_nasabah->NoRangka->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t01_nasabah->NoMesin->Visible) { // NoMesin ?>
		<td data-name="NoMesin"<?php echo $t01_nasabah->NoMesin->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_list->RowCnt ?>_t01_nasabah_NoMesin" class="t01_nasabah_NoMesin">
<span<?php echo $t01_nasabah->NoMesin->ViewAttributes() ?>>
<?php echo $t01_nasabah->NoMesin->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t01_nasabah->Warna->Visible) { // Warna ?>
		<td data-name="Warna"<?php echo $t01_nasabah->Warna->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_list->RowCnt ?>_t01_nasabah_Warna" class="t01_nasabah_Warna">
<span<?php echo $t01_nasabah->Warna->ViewAttributes() ?>>
<?php echo $t01_nasabah->Warna->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t01_nasabah->NoPol->Visible) { // NoPol ?>
		<td data-name="NoPol"<?php echo $t01_nasabah->NoPol->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_list->RowCnt ?>_t01_nasabah_NoPol" class="t01_nasabah_NoPol">
<span<?php echo $t01_nasabah->NoPol->ViewAttributes() ?>>
<?php echo $t01_nasabah->NoPol->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t01_nasabah->AtasNama->Visible) { // AtasNama ?>
		<td data-name="AtasNama"<?php echo $t01_nasabah->AtasNama->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_list->RowCnt ?>_t01_nasabah_AtasNama" class="t01_nasabah_AtasNama">
<span<?php echo $t01_nasabah->AtasNama->ViewAttributes() ?>>
<?php echo $t01_nasabah->AtasNama->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t01_nasabah->Pinjaman->Visible) { // Pinjaman ?>
		<td data-name="Pinjaman"<?php echo $t01_nasabah->Pinjaman->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_list->RowCnt ?>_t01_nasabah_Pinjaman" class="t01_nasabah_Pinjaman">
<span<?php echo $t01_nasabah->Pinjaman->ViewAttributes() ?>>
<?php echo $t01_nasabah->Pinjaman->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t01_nasabah->Denda->Visible) { // Denda ?>
		<td data-name="Denda"<?php echo $t01_nasabah->Denda->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_list->RowCnt ?>_t01_nasabah_Denda" class="t01_nasabah_Denda">
<span<?php echo $t01_nasabah->Denda->ViewAttributes() ?>>
<?php echo $t01_nasabah->Denda->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t01_nasabah->DispensasiDenda->Visible) { // DispensasiDenda ?>
		<td data-name="DispensasiDenda"<?php echo $t01_nasabah->DispensasiDenda->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_list->RowCnt ?>_t01_nasabah_DispensasiDenda" class="t01_nasabah_DispensasiDenda">
<span<?php echo $t01_nasabah->DispensasiDenda->ViewAttributes() ?>>
<?php echo $t01_nasabah->DispensasiDenda->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t01_nasabah->LamaAngsuran->Visible) { // LamaAngsuran ?>
		<td data-name="LamaAngsuran"<?php echo $t01_nasabah->LamaAngsuran->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_list->RowCnt ?>_t01_nasabah_LamaAngsuran" class="t01_nasabah_LamaAngsuran">
<span<?php echo $t01_nasabah->LamaAngsuran->ViewAttributes() ?>>
<?php echo $t01_nasabah->LamaAngsuran->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t01_nasabah->JumlahAngsuran->Visible) { // JumlahAngsuran ?>
		<td data-name="JumlahAngsuran"<?php echo $t01_nasabah->JumlahAngsuran->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_list->RowCnt ?>_t01_nasabah_JumlahAngsuran" class="t01_nasabah_JumlahAngsuran">
<span<?php echo $t01_nasabah->JumlahAngsuran->ViewAttributes() ?>>
<?php echo $t01_nasabah->JumlahAngsuran->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t01_nasabah_list->ListOptions->Render("body", "right", $t01_nasabah_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($t01_nasabah->CurrentAction <> "gridadd")
		$t01_nasabah_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($t01_nasabah->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($t01_nasabah_list->Recordset)
	$t01_nasabah_list->Recordset->Close();
?>
<div class="box-footer ewGridLowerPanel">
<?php if ($t01_nasabah->CurrentAction <> "gridadd" && $t01_nasabah->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t01_nasabah_list->Pager)) $t01_nasabah_list->Pager = new cPrevNextPager($t01_nasabah_list->StartRec, $t01_nasabah_list->DisplayRecs, $t01_nasabah_list->TotalRecs, $t01_nasabah_list->AutoHidePager) ?>
<?php if ($t01_nasabah_list->Pager->RecordCount > 0 && $t01_nasabah_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t01_nasabah_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t01_nasabah_list->PageUrl() ?>start=<?php echo $t01_nasabah_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t01_nasabah_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t01_nasabah_list->PageUrl() ?>start=<?php echo $t01_nasabah_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t01_nasabah_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t01_nasabah_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t01_nasabah_list->PageUrl() ?>start=<?php echo $t01_nasabah_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t01_nasabah_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t01_nasabah_list->PageUrl() ?>start=<?php echo $t01_nasabah_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t01_nasabah_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($t01_nasabah_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $t01_nasabah_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $t01_nasabah_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $t01_nasabah_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($t01_nasabah_list->TotalRecs > 0 && (!$t01_nasabah_list->AutoHidePageSizeSelector || $t01_nasabah_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="t01_nasabah">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($t01_nasabah_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($t01_nasabah_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($t01_nasabah_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($t01_nasabah_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="200"<?php if ($t01_nasabah_list->DisplayRecs == 200) { ?> selected<?php } ?>>200</option>
<option value="ALL"<?php if ($t01_nasabah->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t01_nasabah_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($t01_nasabah_list->TotalRecs == 0 && $t01_nasabah->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t01_nasabah_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
ft01_nasabahlistsrch.FilterList = <?php echo $t01_nasabah_list->GetFilterList() ?>;
ft01_nasabahlistsrch.Init();
ft01_nasabahlist.Init();
</script>
<?php
$t01_nasabah_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t01_nasabah_list->Page_Terminate();
?>
