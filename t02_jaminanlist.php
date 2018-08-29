<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "t02_jaminaninfo.php" ?>
<?php include_once "t96_employeesinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$t02_jaminan_list = NULL; // Initialize page object first

class ct02_jaminan_list extends ct02_jaminan {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{B3698D9B-8D4B-412E-A2E5-AFAD2FEE5A23}';

	// Table name
	var $TableName = 't02_jaminan';

	// Page object name
	var $PageObjName = 't02_jaminan_list';

	// Grid form hidden field names
	var $FormName = 'ft02_jaminanlist';
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

		// Table object (t02_jaminan)
		if (!isset($GLOBALS["t02_jaminan"]) || get_class($GLOBALS["t02_jaminan"]) == "ct02_jaminan") {
			$GLOBALS["t02_jaminan"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t02_jaminan"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "t02_jaminanadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "t02_jaminandelete.php";
		$this->MultiUpdateUrl = "t02_jaminanupdate.php";

		// Table object (t96_employees)
		if (!isset($GLOBALS['t96_employees'])) $GLOBALS['t96_employees'] = new ct96_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't02_jaminan', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption ft02_jaminanlistsrch";

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
		// Create form object

		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();
		$this->MerkType->SetVisibility();
		$this->NoRangka->SetVisibility();
		$this->NoMesin->SetVisibility();
		$this->Warna->SetVisibility();
		$this->NoPol->SetVisibility();
		$this->Keterangan->SetVisibility();
		$this->AtasNama->SetVisibility();

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
		global $EW_EXPORT, $t02_jaminan;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t02_jaminan);
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

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$this->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($this->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to grid edit mode
				if ($this->CurrentAction == "gridedit")
					$this->GridEditMode();

				// Switch to inline edit mode
				if ($this->CurrentAction == "edit")
					$this->InlineEditMode();

				// Switch to inline add mode
				if ($this->CurrentAction == "add" || $this->CurrentAction == "copy")
					$this->InlineAddMode();

				// Switch to grid add mode
				if ($this->CurrentAction == "gridadd")
					$this->GridAddMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$this->CurrentAction = $_POST["a_list"]; // Get action

					// Grid Update
					if (($this->CurrentAction == "gridupdate" || $this->CurrentAction == "gridoverwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridedit") {
						if ($this->ValidateGridForm()) {
							$bGridUpdate = $this->GridUpdate();
						} else {
							$bGridUpdate = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridUpdate) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridedit"; // Stay in Grid Edit mode
						}
					}

					// Inline Update
					if (($this->CurrentAction == "update" || $this->CurrentAction == "overwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "edit")
						$this->InlineUpdate();

					// Insert Inline
					if ($this->CurrentAction == "insert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "add")
						$this->InlineInsert();

					// Grid Insert
					if ($this->CurrentAction == "gridinsert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridadd") {
						if ($this->ValidateGridForm()) {
							$bGridInsert = $this->GridInsert();
						} else {
							$bGridInsert = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridInsert) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridadd"; // Stay in Grid Add mode
						}
					}
				}
			}

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

			// Show grid delete link for grid add / grid edit
			if ($this->AllowAddDeleteRow) {
				if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
					$item = $this->ListOptions->GetItem("griddelete");
					if ($item) $item->Visible = TRUE;
				}
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

	// Exit inline mode
	function ClearInlineMode() {
		$this->setKey("id", ""); // Clear inline edit key
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Add mode
	function GridAddMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridadd"; // Enabled grid add
	}

	// Switch to Grid Edit mode
	function GridEditMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridedit"; // Enable grid edit
	}

	// Switch to Inline Edit mode
	function InlineEditMode() {
		global $Security, $Language;
		if (!$Security->CanEdit())
			$this->Page_Terminate("login.php"); // Go to login page
		$bInlineEdit = TRUE;
		if (isset($_GET["id"])) {
			$this->id->setQueryStringValue($_GET["id"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("id", $this->id->CurrentValue); // Set up inline edit key
				$_SESSION[EW_SESSION_INLINE_MODE] = "edit"; // Enable inline edit
			}
		}
	}

	// Perform update to Inline Edit record
	function InlineUpdate() {
		global $Language, $objForm, $gsFormError;
		$objForm->Index = 1;
		$this->LoadFormValues(); // Get form values

		// Validate form
		$bInlineUpdate = TRUE;
		if (!$this->ValidateForm()) {
			$bInlineUpdate = FALSE; // Form error, reset action
			$this->setFailureMessage($gsFormError);
		} else {
			$bInlineUpdate = FALSE;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			if ($this->SetupKeyValues($rowkey)) { // Set up key values
				if ($this->CheckInlineEditKey()) { // Check key
					$this->SendEmail = TRUE; // Send email on update success
					$bInlineUpdate = $this->EditRow(); // Update record
				} else {
					$bInlineUpdate = FALSE;
				}
			}
		}
		if ($bInlineUpdate) { // Update success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
			$this->EventCancelled = TRUE; // Cancel event
			$this->CurrentAction = "edit"; // Stay in edit mode
		}
	}

	// Check Inline Edit key
	function CheckInlineEditKey() {

		//CheckInlineEditKey = True
		if (strval($this->getKey("id")) <> strval($this->id->CurrentValue))
			return FALSE;
		return TRUE;
	}

	// Switch to Inline Add mode
	function InlineAddMode() {
		global $Security, $Language;
		if (!$Security->CanAdd())
			$this->Page_Terminate("login.php"); // Return to login page
		if ($this->CurrentAction == "copy") {
			if (@$_GET["id"] <> "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->setKey("id", $this->id->CurrentValue); // Set up key
			} else {
				$this->setKey("id", ""); // Clear key
				$this->CurrentAction = "add";
			}
		}
		$_SESSION[EW_SESSION_INLINE_MODE] = "add"; // Enable inline add
	}

	// Perform update to Inline Add/Copy record
	function InlineInsert() {
		global $Language, $objForm, $gsFormError;
		$this->LoadOldRecord(); // Load old record
		$objForm->Index = 0;
		$this->LoadFormValues(); // Get form values

		// Validate form
		if (!$this->ValidateForm()) {
			$this->setFailureMessage($gsFormError); // Set validation error message
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "add"; // Stay in add mode
			return;
		}
		$this->SendEmail = TRUE; // Send email on add success
		if ($this->AddRow($this->OldRecordset)) { // Add record
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up add success message
			$this->ClearInlineMode(); // Clear inline add mode
		} else { // Add failed
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "add"; // Stay in add mode
		}
	}

	// Perform update to grid
	function GridUpdate() {
		global $Language, $objForm, $gsFormError;
		$bGridUpdate = TRUE;

		// Get old recordset
		$this->CurrentFilter = $this->BuildKeyFilter();
		if ($this->CurrentFilter == "")
			$this->CurrentFilter = "0=1";
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			$rsold = $rs->GetRows();
			$rs->Close();
		}

		// Call Grid Updating event
		if (!$this->Grid_Updating($rsold)) {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("GridEditCancelled")); // Set grid edit cancelled message
			return FALSE;
		}

		// Begin transaction
		$conn->BeginTrans();
		if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateBegin")); // Batch update begin
		$sKey = "";

		// Update row index and get row key
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Update all rows based on key
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
			$objForm->Index = $rowindex;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			$rowaction = strval($objForm->GetValue($this->FormActionName));

			// Load all values and keys
			if ($rowaction <> "insertdelete") { // Skip insert then deleted rows
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
					$bGridUpdate = $this->SetupKeyValues($rowkey); // Set up key values
				} else {
					$bGridUpdate = TRUE;
				}

				// Skip empty row
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// No action required
				// Validate form and insert/update/delete record

				} elseif ($bGridUpdate) {
					if ($rowaction == "delete") {
						$this->CurrentFilter = $this->KeyFilter();
						$bGridUpdate = $this->DeleteRows(); // Delete this row
					} else if (!$this->ValidateForm()) {
						$bGridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($gsFormError);
					} else {
						if ($rowaction == "insert") {
							$bGridUpdate = $this->AddRow(); // Insert this row
						} else {
							if ($rowkey <> "") {
								$this->SendEmail = FALSE; // Do not send email on update success
								$bGridUpdate = $this->EditRow(); // Update this row
							}
						} // End update
					}
				}
				if ($bGridUpdate) {
					if ($sKey <> "") $sKey .= ", ";
					$sKey .= $rowkey;
				} else {
					break;
				}
			}
		}
		if ($bGridUpdate) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Updated event
			$this->Grid_Updated($rsold, $rsnew);
			if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateSuccess")); // Batch update success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateRollback")); // Batch update rollback
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
		}
		return $bGridUpdate;
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

	// Perform Grid Add
	function GridInsert() {
		global $Language, $objForm, $gsFormError;
		$rowindex = 1;
		$bGridInsert = FALSE;
		$conn = &$this->Connection();

		// Call Grid Inserting event
		if (!$this->Grid_Inserting()) {
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("GridAddCancelled")); // Set grid add cancelled message
			}
			return FALSE;
		}

		// Begin transaction
		$conn->BeginTrans();

		// Init key filter
		$sWrkFilter = "";
		$addcnt = 0;
		if ($this->AuditTrailOnAdd) $this->WriteAuditTrailDummy($Language->Phrase("BatchInsertBegin")); // Batch insert begin
		$sKey = "";

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Insert all rows
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "" && $rowaction <> "insert")
				continue; // Skip
			$this->LoadFormValues(); // Get form values
			if (!$this->EmptyRow()) {
				$addcnt++;
				$this->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->ValidateForm()) {
					$bGridInsert = FALSE; // Form error, reset action
					$this->setFailureMessage($gsFormError);
				} else {
					$bGridInsert = $this->AddRow($this->OldRecordset); // Insert this row
				}
				if ($bGridInsert) {
					if ($sKey <> "") $sKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
					$sKey .= $this->id->CurrentValue;

					// Add filter for this record
					$sFilter = $this->KeyFilter();
					if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
					$sWrkFilter .= $sFilter;
				} else {
					break;
				}
			}
		}
		if ($addcnt == 0) { // No record inserted
			$this->setFailureMessage($Language->Phrase("NoAddRecord"));
			$bGridInsert = FALSE;
		}
		if ($bGridInsert) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			$this->CurrentFilter = $sWrkFilter;
			$sSql = $this->SQL();
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Inserted event
			$this->Grid_Inserted($rsnew);
			if ($this->AuditTrailOnAdd) $this->WriteAuditTrailDummy($Language->Phrase("BatchInsertSuccess")); // Batch insert success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("InsertSuccess")); // Set up insert success message
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->AuditTrailOnAdd) $this->WriteAuditTrailDummy($Language->Phrase("BatchInsertRollback")); // Batch insert rollback
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("InsertFailed")); // Set insert failed message
			}
		}
		return $bGridInsert;
	}

	// Check if empty row
	function EmptyRow() {
		global $objForm;
		if ($objForm->HasValue("x_MerkType") && $objForm->HasValue("o_MerkType") && $this->MerkType->CurrentValue <> $this->MerkType->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_NoRangka") && $objForm->HasValue("o_NoRangka") && $this->NoRangka->CurrentValue <> $this->NoRangka->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_NoMesin") && $objForm->HasValue("o_NoMesin") && $this->NoMesin->CurrentValue <> $this->NoMesin->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Warna") && $objForm->HasValue("o_Warna") && $this->Warna->CurrentValue <> $this->Warna->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_NoPol") && $objForm->HasValue("o_NoPol") && $this->NoPol->CurrentValue <> $this->NoPol->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Keterangan") && $objForm->HasValue("o_Keterangan") && $this->Keterangan->CurrentValue <> $this->Keterangan->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_AtasNama") && $objForm->HasValue("o_AtasNama") && $this->AtasNama->CurrentValue <> $this->AtasNama->OldValue)
			return FALSE;
		return TRUE;
	}

	// Validate grid form
	function ValidateGridForm() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Validate all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else if (!$this->ValidateForm()) {
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	// Get all form values of the grid
	function GetGridFormValues() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;
		$rows = array();

		// Loop through all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else {
					$rows[] = $this->GetFieldValues("FormValue"); // Return row as array
				}
			}
		}
		return $rows; // Return as array of array
	}

	// Restore form values for current row
	function RestoreCurrentRowFormValues($idx) {
		global $objForm;

		// Get row based on current index
		$objForm->Index = $idx;
		$this->LoadFormValues(); // Load form values
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Initialize
		$sFilterList = "";
		$sSavedFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->id->AdvancedSearch->ToJson(), ","); // Field id
		$sFilterList = ew_Concat($sFilterList, $this->MerkType->AdvancedSearch->ToJson(), ","); // Field MerkType
		$sFilterList = ew_Concat($sFilterList, $this->NoRangka->AdvancedSearch->ToJson(), ","); // Field NoRangka
		$sFilterList = ew_Concat($sFilterList, $this->NoMesin->AdvancedSearch->ToJson(), ","); // Field NoMesin
		$sFilterList = ew_Concat($sFilterList, $this->Warna->AdvancedSearch->ToJson(), ","); // Field Warna
		$sFilterList = ew_Concat($sFilterList, $this->NoPol->AdvancedSearch->ToJson(), ","); // Field NoPol
		$sFilterList = ew_Concat($sFilterList, $this->Keterangan->AdvancedSearch->ToJson(), ","); // Field Keterangan
		$sFilterList = ew_Concat($sFilterList, $this->AtasNama->AdvancedSearch->ToJson(), ","); // Field AtasNama
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "ft02_jaminanlistsrch", $filters);

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
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
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
			$this->UpdateSort($this->MerkType, $bCtrl); // MerkType
			$this->UpdateSort($this->NoRangka, $bCtrl); // NoRangka
			$this->UpdateSort($this->NoMesin, $bCtrl); // NoMesin
			$this->UpdateSort($this->Warna, $bCtrl); // Warna
			$this->UpdateSort($this->NoPol, $bCtrl); // NoPol
			$this->UpdateSort($this->Keterangan, $bCtrl); // Keterangan
			$this->UpdateSort($this->AtasNama, $bCtrl); // AtasNama
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
				$this->MerkType->setSort("");
				$this->NoRangka->setSort("");
				$this->NoMesin->setSort("");
				$this->Warna->setSort("");
				$this->NoPol->setSort("");
				$this->Keterangan->setSort("");
				$this->AtasNama->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// "griddelete"
		if ($this->AllowAddDeleteRow) {
			$item = &$this->ListOptions->Add("griddelete");
			$item->CssClass = "text-nowrap";
			$item->OnLeft = TRUE;
			$item->Visible = FALSE; // Default hidden
		}

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

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode <> "view") {
			$objForm->Index = $this->RowIndex;
			$ActionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$OldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$KeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$BlankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $ActionName . "\" id=\"" . $ActionName . "\" value=\"" . $this->RowAction . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue($this->FormKeyName);
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $BlankRowName . "\" id=\"" . $BlankRowName . "\" value=\"1\">";
		}

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$option = &$this->ListOptions;
				$option->UseButtonGroup = TRUE; // Use button group for grid delete button
				$option->UseImageAndText = TRUE; // Use image and text for grid delete button
				$oListOpt = &$option->Items["griddelete"];
				if (!$Security->CanDelete() && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
					$oListOpt->Body = "&nbsp;";
				} else {
					$oListOpt->Body = "<a class=\"ewGridLink ewGridDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" onclick=\"return ew_DeleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->Phrase("DeleteLink") . "</a>";
				}
			}
		}

		// "sequence"
		$oListOpt = &$this->ListOptions->Items["sequence"];
		$oListOpt->Body = ew_FormatSeqNo($this->RecCnt);

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		if (($this->CurrentAction == "add" || $this->CurrentAction == "copy") && $this->RowType == EW_ROWTYPE_ADD) { // Inline Add/Copy
			$this->ListOptions->CustomItem = "copy"; // Show copy column only
			$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
			$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
				"<a class=\"ewGridLink ewInlineInsert\" title=\"" . ew_HtmlTitle($Language->Phrase("InsertLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InsertLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("InsertLink") . "</a>&nbsp;" .
				"<a class=\"ewGridLink ewInlineCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("CancelLink") . "</a>" .
				"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"insert\"></div>";
			return;
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($this->CurrentAction == "edit" && $this->RowType == EW_ROWTYPE_EDIT) { // Inline-Edit
			$this->ListOptions->CustomItem = "edit"; // Show edit column only
			$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
				$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
					"<a class=\"ewGridLink ewInlineUpdate\" title=\"" . ew_HtmlTitle($Language->Phrase("UpdateLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("UpdateLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . ew_UrlAddHash($this->PageName(), "r" . $this->RowCnt . "_" . $this->TableVar) . "');\">" . $Language->Phrase("UpdateLink") . "</a>&nbsp;" .
					"<a class=\"ewGridLink ewInlineCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("CancelLink") . "</a>" .
					"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"update\"></div>";
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->id->CurrentValue) . "\">";
			return;
		}

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
			$oListOpt->Body .= "<a class=\"ewRowLink ewInlineEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" href=\"" . ew_HtmlEncode(ew_UrlAddHash($this->InlineEditUrl, "r" . $this->RowCnt . "_" . $this->TableVar)) . "\">" . $Language->Phrase("InlineEditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		$copycaption = ew_HtmlTitle($Language->Phrase("CopyLink"));
		if ($Security->CanAdd()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") . "</a>";
			$oListOpt->Body .= "<a class=\"ewRowLink ewInlineCopy\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineCopyLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->InlineCopyUrl) . "\">" . $Language->Phrase("InlineCopyLink") . "</a>";
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
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->id->CurrentValue . "\">";
		}
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

		// Inline Add
		$item = &$option->Add("inlineadd");
		$item->Body = "<a class=\"ewAddEdit ewInlineAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineAddLink")) . "\" href=\"" . ew_HtmlEncode($this->InlineAddUrl) . "\">" .$Language->Phrase("InlineAddLink") . "</a>";
		$item->Visible = ($this->InlineAddUrl <> "" && $Security->CanAdd());
		$item = &$option->Add("gridadd");
		$item->Body = "<a class=\"ewAddEdit ewGridAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" href=\"" . ew_HtmlEncode($this->GridAddUrl) . "\">" . $Language->Phrase("GridAddLink") . "</a>";
		$item->Visible = ($this->GridAddUrl <> "" && $Security->CanAdd());

		// Add grid edit
		$option = $options["addedit"];
		$item = &$option->Add("gridedit");
		$item->Body = "<a class=\"ewAddEdit ewGridEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GridEditUrl) . "\">" . $Language->Phrase("GridEditLink") . "</a>";
		$item->Visible = ($this->GridEditUrl <> "" && $Security->CanEdit());
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"ft02_jaminanlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"ft02_jaminanlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "gridedit") { // Not grid add/edit mode
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.ft02_jaminanlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		} else { // Grid add/edit mode

			// Hide all options first
			foreach ($options as &$option)
				$option->HideAllOptions();
			if ($this->CurrentAction == "gridadd") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = $Security->CanAdd();
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;

				// Add grid insert
				$item = &$option->Add("gridinsert");
				$item->Body = "<a class=\"ewAction ewGridInsert\" title=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("GridInsertLink") . "</a>";

				// Add grid cancel
				$item = &$option->Add("gridcancel");
				$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
				$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
			if ($this->CurrentAction == "gridedit") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = $Security->CanAdd();
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;
					$item = &$option->Add("gridsave");
					$item->Body = "<a class=\"ewAction ewGridSave\" title=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("GridSaveLink") . "</a>";
					$item = &$option->Add("gridcancel");
					$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
					$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"ft02_jaminanlistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
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

	// Load default values
	function LoadDefaultValues() {
		$this->id->CurrentValue = NULL;
		$this->id->OldValue = $this->id->CurrentValue;
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
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "" && $this->Command == "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->MerkType->FldIsDetailKey) {
			$this->MerkType->setFormValue($objForm->GetValue("x_MerkType"));
		}
		$this->MerkType->setOldValue($objForm->GetValue("o_MerkType"));
		if (!$this->NoRangka->FldIsDetailKey) {
			$this->NoRangka->setFormValue($objForm->GetValue("x_NoRangka"));
		}
		$this->NoRangka->setOldValue($objForm->GetValue("o_NoRangka"));
		if (!$this->NoMesin->FldIsDetailKey) {
			$this->NoMesin->setFormValue($objForm->GetValue("x_NoMesin"));
		}
		$this->NoMesin->setOldValue($objForm->GetValue("o_NoMesin"));
		if (!$this->Warna->FldIsDetailKey) {
			$this->Warna->setFormValue($objForm->GetValue("x_Warna"));
		}
		$this->Warna->setOldValue($objForm->GetValue("o_Warna"));
		if (!$this->NoPol->FldIsDetailKey) {
			$this->NoPol->setFormValue($objForm->GetValue("x_NoPol"));
		}
		$this->NoPol->setOldValue($objForm->GetValue("o_NoPol"));
		if (!$this->Keterangan->FldIsDetailKey) {
			$this->Keterangan->setFormValue($objForm->GetValue("x_Keterangan"));
		}
		$this->Keterangan->setOldValue($objForm->GetValue("o_Keterangan"));
		if (!$this->AtasNama->FldIsDetailKey) {
			$this->AtasNama->setFormValue($objForm->GetValue("x_AtasNama"));
		}
		$this->AtasNama->setOldValue($objForm->GetValue("o_AtasNama"));
		if (!$this->id->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->CurrentValue = $this->id->FormValue;
		$this->MerkType->CurrentValue = $this->MerkType->FormValue;
		$this->NoRangka->CurrentValue = $this->NoRangka->FormValue;
		$this->NoMesin->CurrentValue = $this->NoMesin->FormValue;
		$this->Warna->CurrentValue = $this->Warna->FormValue;
		$this->NoPol->CurrentValue = $this->NoPol->FormValue;
		$this->Keterangan->CurrentValue = $this->Keterangan->FormValue;
		$this->AtasNama->CurrentValue = $this->AtasNama->FormValue;
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
		$this->MerkType->setDbValue($row['MerkType']);
		$this->NoRangka->setDbValue($row['NoRangka']);
		$this->NoMesin->setDbValue($row['NoMesin']);
		$this->Warna->setDbValue($row['Warna']);
		$this->NoPol->setDbValue($row['NoPol']);
		$this->Keterangan->setDbValue($row['Keterangan']);
		$this->AtasNama->setDbValue($row['AtasNama']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['id'] = $this->id->CurrentValue;
		$row['MerkType'] = $this->MerkType->CurrentValue;
		$row['NoRangka'] = $this->NoRangka->CurrentValue;
		$row['NoMesin'] = $this->NoMesin->CurrentValue;
		$row['Warna'] = $this->Warna->CurrentValue;
		$row['NoPol'] = $this->NoPol->CurrentValue;
		$row['Keterangan'] = $this->Keterangan->CurrentValue;
		$row['AtasNama'] = $this->AtasNama->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->MerkType->DbValue = $row['MerkType'];
		$this->NoRangka->DbValue = $row['NoRangka'];
		$this->NoMesin->DbValue = $row['NoMesin'];
		$this->Warna->DbValue = $row['Warna'];
		$this->NoPol->DbValue = $row['NoPol'];
		$this->Keterangan->DbValue = $row['Keterangan'];
		$this->AtasNama->DbValue = $row['AtasNama'];
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

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// MerkType
		// NoRangka
		// NoMesin
		// Warna
		// NoPol
		// Keterangan
		// AtasNama

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

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

			// Add refer script
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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

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

			// Edit refer script
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
		if (!$this->MerkType->FldIsDetailKey && !is_null($this->MerkType->FormValue) && $this->MerkType->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->MerkType->FldCaption(), $this->MerkType->ReqErrMsg));
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

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		}
		$rows = ($rs) ? $rs->GetRows() : array();
		if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteBegin")); // Batch delete begin

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['id'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		}
		if (!$DeleteRows) {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteSuccess")); // Batch delete success
		} else {
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

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
if (!isset($t02_jaminan_list)) $t02_jaminan_list = new ct02_jaminan_list();

// Page init
$t02_jaminan_list->Page_Init();

// Page main
$t02_jaminan_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t02_jaminan_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = ft02_jaminanlist = new ew_Form("ft02_jaminanlist", "list");
ft02_jaminanlist.FormKeyCountName = '<?php echo $t02_jaminan_list->FormKeyCountName ?>';

// Validate form
ft02_jaminanlist.Validate = function() {
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
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			elm = this.GetElements("x" + infix + "_MerkType");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t02_jaminan->MerkType->FldCaption(), $t02_jaminan->MerkType->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	if (gridinsert && addcnt == 0) { // No row added
		ew_Alert(ewLanguage.Phrase("NoAddRecord"));
		return false;
	}
	return true;
}

// Check empty row
ft02_jaminanlist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "MerkType", false)) return false;
	if (ew_ValueChanged(fobj, infix, "NoRangka", false)) return false;
	if (ew_ValueChanged(fobj, infix, "NoMesin", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Warna", false)) return false;
	if (ew_ValueChanged(fobj, infix, "NoPol", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Keterangan", false)) return false;
	if (ew_ValueChanged(fobj, infix, "AtasNama", false)) return false;
	return true;
}

// Form_CustomValidate event
ft02_jaminanlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft02_jaminanlist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = ft02_jaminanlistsrch = new ew_Form("ft02_jaminanlistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php if ($t02_jaminan_list->TotalRecs > 0 && $t02_jaminan_list->ExportOptions->Visible()) { ?>
<?php $t02_jaminan_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($t02_jaminan_list->SearchOptions->Visible()) { ?>
<?php $t02_jaminan_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($t02_jaminan_list->FilterOptions->Visible()) { ?>
<?php $t02_jaminan_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php
if ($t02_jaminan->CurrentAction == "gridadd") {
	$t02_jaminan->CurrentFilter = "0=1";
	$t02_jaminan_list->StartRec = 1;
	$t02_jaminan_list->DisplayRecs = $t02_jaminan->GridAddRowCount;
	$t02_jaminan_list->TotalRecs = $t02_jaminan_list->DisplayRecs;
	$t02_jaminan_list->StopRec = $t02_jaminan_list->DisplayRecs;
} else {
	$bSelectLimit = $t02_jaminan_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t02_jaminan_list->TotalRecs <= 0)
			$t02_jaminan_list->TotalRecs = $t02_jaminan->ListRecordCount();
	} else {
		if (!$t02_jaminan_list->Recordset && ($t02_jaminan_list->Recordset = $t02_jaminan_list->LoadRecordset()))
			$t02_jaminan_list->TotalRecs = $t02_jaminan_list->Recordset->RecordCount();
	}
	$t02_jaminan_list->StartRec = 1;
	if ($t02_jaminan_list->DisplayRecs <= 0 || ($t02_jaminan->Export <> "" && $t02_jaminan->ExportAll)) // Display all records
		$t02_jaminan_list->DisplayRecs = $t02_jaminan_list->TotalRecs;
	if (!($t02_jaminan->Export <> "" && $t02_jaminan->ExportAll))
		$t02_jaminan_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$t02_jaminan_list->Recordset = $t02_jaminan_list->LoadRecordset($t02_jaminan_list->StartRec-1, $t02_jaminan_list->DisplayRecs);

	// Set no record found message
	if ($t02_jaminan->CurrentAction == "" && $t02_jaminan_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$t02_jaminan_list->setWarningMessage(ew_DeniedMsg());
		if ($t02_jaminan_list->SearchWhere == "0=101")
			$t02_jaminan_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t02_jaminan_list->setWarningMessage($Language->Phrase("NoRecord"));
	}

	// Audit trail on search
	if ($t02_jaminan_list->AuditTrailOnSearch && $t02_jaminan_list->Command == "search" && !$t02_jaminan_list->RestoreSearch) {
		$searchparm = ew_ServerVar("QUERY_STRING");
		$searchsql = $t02_jaminan_list->getSessionWhere();
		$t02_jaminan_list->WriteAuditTrailOnSearch($searchparm, $searchsql);
	}
}
$t02_jaminan_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($t02_jaminan->Export == "" && $t02_jaminan->CurrentAction == "") { ?>
<form name="ft02_jaminanlistsrch" id="ft02_jaminanlistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($t02_jaminan_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="ft02_jaminanlistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="t02_jaminan">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($t02_jaminan_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($t02_jaminan_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $t02_jaminan_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($t02_jaminan_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($t02_jaminan_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($t02_jaminan_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($t02_jaminan_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $t02_jaminan_list->ShowPageHeader(); ?>
<?php
$t02_jaminan_list->ShowMessage();
?>
<?php if ($t02_jaminan_list->TotalRecs > 0 || $t02_jaminan->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($t02_jaminan_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> t02_jaminan">
<form name="ft02_jaminanlist" id="ft02_jaminanlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t02_jaminan_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t02_jaminan_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t02_jaminan">
<div id="gmp_t02_jaminan" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($t02_jaminan_list->TotalRecs > 0 || $t02_jaminan->CurrentAction == "add" || $t02_jaminan->CurrentAction == "copy" || $t02_jaminan->CurrentAction == "gridedit") { ?>
<table id="tbl_t02_jaminanlist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$t02_jaminan_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t02_jaminan_list->RenderListOptions();

// Render list options (header, left)
$t02_jaminan_list->ListOptions->Render("header", "left");
?>
<?php if ($t02_jaminan->MerkType->Visible) { // MerkType ?>
	<?php if ($t02_jaminan->SortUrl($t02_jaminan->MerkType) == "") { ?>
		<th data-name="MerkType" class="<?php echo $t02_jaminan->MerkType->HeaderCellClass() ?>"><div id="elh_t02_jaminan_MerkType" class="t02_jaminan_MerkType"><div class="ewTableHeaderCaption"><?php echo $t02_jaminan->MerkType->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="MerkType" class="<?php echo $t02_jaminan->MerkType->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t02_jaminan->SortUrl($t02_jaminan->MerkType) ?>',2);"><div id="elh_t02_jaminan_MerkType" class="t02_jaminan_MerkType">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_jaminan->MerkType->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t02_jaminan->MerkType->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_jaminan->MerkType->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_jaminan->NoRangka->Visible) { // NoRangka ?>
	<?php if ($t02_jaminan->SortUrl($t02_jaminan->NoRangka) == "") { ?>
		<th data-name="NoRangka" class="<?php echo $t02_jaminan->NoRangka->HeaderCellClass() ?>"><div id="elh_t02_jaminan_NoRangka" class="t02_jaminan_NoRangka"><div class="ewTableHeaderCaption"><?php echo $t02_jaminan->NoRangka->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NoRangka" class="<?php echo $t02_jaminan->NoRangka->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t02_jaminan->SortUrl($t02_jaminan->NoRangka) ?>',2);"><div id="elh_t02_jaminan_NoRangka" class="t02_jaminan_NoRangka">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_jaminan->NoRangka->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t02_jaminan->NoRangka->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_jaminan->NoRangka->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_jaminan->NoMesin->Visible) { // NoMesin ?>
	<?php if ($t02_jaminan->SortUrl($t02_jaminan->NoMesin) == "") { ?>
		<th data-name="NoMesin" class="<?php echo $t02_jaminan->NoMesin->HeaderCellClass() ?>"><div id="elh_t02_jaminan_NoMesin" class="t02_jaminan_NoMesin"><div class="ewTableHeaderCaption"><?php echo $t02_jaminan->NoMesin->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NoMesin" class="<?php echo $t02_jaminan->NoMesin->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t02_jaminan->SortUrl($t02_jaminan->NoMesin) ?>',2);"><div id="elh_t02_jaminan_NoMesin" class="t02_jaminan_NoMesin">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_jaminan->NoMesin->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t02_jaminan->NoMesin->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_jaminan->NoMesin->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_jaminan->Warna->Visible) { // Warna ?>
	<?php if ($t02_jaminan->SortUrl($t02_jaminan->Warna) == "") { ?>
		<th data-name="Warna" class="<?php echo $t02_jaminan->Warna->HeaderCellClass() ?>"><div id="elh_t02_jaminan_Warna" class="t02_jaminan_Warna"><div class="ewTableHeaderCaption"><?php echo $t02_jaminan->Warna->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Warna" class="<?php echo $t02_jaminan->Warna->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t02_jaminan->SortUrl($t02_jaminan->Warna) ?>',2);"><div id="elh_t02_jaminan_Warna" class="t02_jaminan_Warna">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_jaminan->Warna->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t02_jaminan->Warna->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_jaminan->Warna->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_jaminan->NoPol->Visible) { // NoPol ?>
	<?php if ($t02_jaminan->SortUrl($t02_jaminan->NoPol) == "") { ?>
		<th data-name="NoPol" class="<?php echo $t02_jaminan->NoPol->HeaderCellClass() ?>"><div id="elh_t02_jaminan_NoPol" class="t02_jaminan_NoPol"><div class="ewTableHeaderCaption"><?php echo $t02_jaminan->NoPol->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NoPol" class="<?php echo $t02_jaminan->NoPol->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t02_jaminan->SortUrl($t02_jaminan->NoPol) ?>',2);"><div id="elh_t02_jaminan_NoPol" class="t02_jaminan_NoPol">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_jaminan->NoPol->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t02_jaminan->NoPol->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_jaminan->NoPol->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_jaminan->Keterangan->Visible) { // Keterangan ?>
	<?php if ($t02_jaminan->SortUrl($t02_jaminan->Keterangan) == "") { ?>
		<th data-name="Keterangan" class="<?php echo $t02_jaminan->Keterangan->HeaderCellClass() ?>"><div id="elh_t02_jaminan_Keterangan" class="t02_jaminan_Keterangan"><div class="ewTableHeaderCaption"><?php echo $t02_jaminan->Keterangan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Keterangan" class="<?php echo $t02_jaminan->Keterangan->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t02_jaminan->SortUrl($t02_jaminan->Keterangan) ?>',2);"><div id="elh_t02_jaminan_Keterangan" class="t02_jaminan_Keterangan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_jaminan->Keterangan->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t02_jaminan->Keterangan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_jaminan->Keterangan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_jaminan->AtasNama->Visible) { // AtasNama ?>
	<?php if ($t02_jaminan->SortUrl($t02_jaminan->AtasNama) == "") { ?>
		<th data-name="AtasNama" class="<?php echo $t02_jaminan->AtasNama->HeaderCellClass() ?>"><div id="elh_t02_jaminan_AtasNama" class="t02_jaminan_AtasNama"><div class="ewTableHeaderCaption"><?php echo $t02_jaminan->AtasNama->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="AtasNama" class="<?php echo $t02_jaminan->AtasNama->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t02_jaminan->SortUrl($t02_jaminan->AtasNama) ?>',2);"><div id="elh_t02_jaminan_AtasNama" class="t02_jaminan_AtasNama">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_jaminan->AtasNama->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t02_jaminan->AtasNama->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_jaminan->AtasNama->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$t02_jaminan_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
	if ($t02_jaminan->CurrentAction == "add" || $t02_jaminan->CurrentAction == "copy") {
		$t02_jaminan_list->RowIndex = 0;
		$t02_jaminan_list->KeyCount = $t02_jaminan_list->RowIndex;
		if ($t02_jaminan->CurrentAction == "copy" && !$t02_jaminan_list->LoadRow())
			$t02_jaminan->CurrentAction = "add";
		if ($t02_jaminan->CurrentAction == "add")
			$t02_jaminan_list->LoadRowValues();
		if ($t02_jaminan->EventCancelled) // Insert failed
			$t02_jaminan_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$t02_jaminan->ResetAttrs();
		$t02_jaminan->RowAttrs = array_merge($t02_jaminan->RowAttrs, array('data-rowindex'=>0, 'id'=>'r0_t02_jaminan', 'data-rowtype'=>EW_ROWTYPE_ADD));
		$t02_jaminan->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t02_jaminan_list->RenderRow();

		// Render list options
		$t02_jaminan_list->RenderListOptions();
		$t02_jaminan_list->StartRowCnt = 0;
?>
	<tr<?php echo $t02_jaminan->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t02_jaminan_list->ListOptions->Render("body", "left", $t02_jaminan_list->RowCnt);
?>
	<?php if ($t02_jaminan->MerkType->Visible) { // MerkType ?>
		<td data-name="MerkType">
<span id="el<?php echo $t02_jaminan_list->RowCnt ?>_t02_jaminan_MerkType" class="form-group t02_jaminan_MerkType">
<input type="text" data-table="t02_jaminan" data-field="x_MerkType" name="x<?php echo $t02_jaminan_list->RowIndex ?>_MerkType" id="x<?php echo $t02_jaminan_list->RowIndex ?>_MerkType" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t02_jaminan->MerkType->getPlaceHolder()) ?>" value="<?php echo $t02_jaminan->MerkType->EditValue ?>"<?php echo $t02_jaminan->MerkType->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_jaminan" data-field="x_MerkType" name="o<?php echo $t02_jaminan_list->RowIndex ?>_MerkType" id="o<?php echo $t02_jaminan_list->RowIndex ?>_MerkType" value="<?php echo ew_HtmlEncode($t02_jaminan->MerkType->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_jaminan->NoRangka->Visible) { // NoRangka ?>
		<td data-name="NoRangka">
<span id="el<?php echo $t02_jaminan_list->RowCnt ?>_t02_jaminan_NoRangka" class="form-group t02_jaminan_NoRangka">
<input type="text" data-table="t02_jaminan" data-field="x_NoRangka" name="x<?php echo $t02_jaminan_list->RowIndex ?>_NoRangka" id="x<?php echo $t02_jaminan_list->RowIndex ?>_NoRangka" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t02_jaminan->NoRangka->getPlaceHolder()) ?>" value="<?php echo $t02_jaminan->NoRangka->EditValue ?>"<?php echo $t02_jaminan->NoRangka->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_jaminan" data-field="x_NoRangka" name="o<?php echo $t02_jaminan_list->RowIndex ?>_NoRangka" id="o<?php echo $t02_jaminan_list->RowIndex ?>_NoRangka" value="<?php echo ew_HtmlEncode($t02_jaminan->NoRangka->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_jaminan->NoMesin->Visible) { // NoMesin ?>
		<td data-name="NoMesin">
<span id="el<?php echo $t02_jaminan_list->RowCnt ?>_t02_jaminan_NoMesin" class="form-group t02_jaminan_NoMesin">
<input type="text" data-table="t02_jaminan" data-field="x_NoMesin" name="x<?php echo $t02_jaminan_list->RowIndex ?>_NoMesin" id="x<?php echo $t02_jaminan_list->RowIndex ?>_NoMesin" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t02_jaminan->NoMesin->getPlaceHolder()) ?>" value="<?php echo $t02_jaminan->NoMesin->EditValue ?>"<?php echo $t02_jaminan->NoMesin->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_jaminan" data-field="x_NoMesin" name="o<?php echo $t02_jaminan_list->RowIndex ?>_NoMesin" id="o<?php echo $t02_jaminan_list->RowIndex ?>_NoMesin" value="<?php echo ew_HtmlEncode($t02_jaminan->NoMesin->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_jaminan->Warna->Visible) { // Warna ?>
		<td data-name="Warna">
<span id="el<?php echo $t02_jaminan_list->RowCnt ?>_t02_jaminan_Warna" class="form-group t02_jaminan_Warna">
<input type="text" data-table="t02_jaminan" data-field="x_Warna" name="x<?php echo $t02_jaminan_list->RowIndex ?>_Warna" id="x<?php echo $t02_jaminan_list->RowIndex ?>_Warna" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($t02_jaminan->Warna->getPlaceHolder()) ?>" value="<?php echo $t02_jaminan->Warna->EditValue ?>"<?php echo $t02_jaminan->Warna->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_jaminan" data-field="x_Warna" name="o<?php echo $t02_jaminan_list->RowIndex ?>_Warna" id="o<?php echo $t02_jaminan_list->RowIndex ?>_Warna" value="<?php echo ew_HtmlEncode($t02_jaminan->Warna->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_jaminan->NoPol->Visible) { // NoPol ?>
		<td data-name="NoPol">
<span id="el<?php echo $t02_jaminan_list->RowCnt ?>_t02_jaminan_NoPol" class="form-group t02_jaminan_NoPol">
<input type="text" data-table="t02_jaminan" data-field="x_NoPol" name="x<?php echo $t02_jaminan_list->RowIndex ?>_NoPol" id="x<?php echo $t02_jaminan_list->RowIndex ?>_NoPol" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($t02_jaminan->NoPol->getPlaceHolder()) ?>" value="<?php echo $t02_jaminan->NoPol->EditValue ?>"<?php echo $t02_jaminan->NoPol->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_jaminan" data-field="x_NoPol" name="o<?php echo $t02_jaminan_list->RowIndex ?>_NoPol" id="o<?php echo $t02_jaminan_list->RowIndex ?>_NoPol" value="<?php echo ew_HtmlEncode($t02_jaminan->NoPol->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_jaminan->Keterangan->Visible) { // Keterangan ?>
		<td data-name="Keterangan">
<span id="el<?php echo $t02_jaminan_list->RowCnt ?>_t02_jaminan_Keterangan" class="form-group t02_jaminan_Keterangan">
<textarea data-table="t02_jaminan" data-field="x_Keterangan" name="x<?php echo $t02_jaminan_list->RowIndex ?>_Keterangan" id="x<?php echo $t02_jaminan_list->RowIndex ?>_Keterangan" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($t02_jaminan->Keterangan->getPlaceHolder()) ?>"<?php echo $t02_jaminan->Keterangan->EditAttributes() ?>><?php echo $t02_jaminan->Keterangan->EditValue ?></textarea>
</span>
<input type="hidden" data-table="t02_jaminan" data-field="x_Keterangan" name="o<?php echo $t02_jaminan_list->RowIndex ?>_Keterangan" id="o<?php echo $t02_jaminan_list->RowIndex ?>_Keterangan" value="<?php echo ew_HtmlEncode($t02_jaminan->Keterangan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_jaminan->AtasNama->Visible) { // AtasNama ?>
		<td data-name="AtasNama">
<span id="el<?php echo $t02_jaminan_list->RowCnt ?>_t02_jaminan_AtasNama" class="form-group t02_jaminan_AtasNama">
<input type="text" data-table="t02_jaminan" data-field="x_AtasNama" name="x<?php echo $t02_jaminan_list->RowIndex ?>_AtasNama" id="x<?php echo $t02_jaminan_list->RowIndex ?>_AtasNama" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t02_jaminan->AtasNama->getPlaceHolder()) ?>" value="<?php echo $t02_jaminan->AtasNama->EditValue ?>"<?php echo $t02_jaminan->AtasNama->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_jaminan" data-field="x_AtasNama" name="o<?php echo $t02_jaminan_list->RowIndex ?>_AtasNama" id="o<?php echo $t02_jaminan_list->RowIndex ?>_AtasNama" value="<?php echo ew_HtmlEncode($t02_jaminan->AtasNama->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t02_jaminan_list->ListOptions->Render("body", "right", $t02_jaminan_list->RowCnt);
?>
<script type="text/javascript">
ft02_jaminanlist.UpdateOpts(<?php echo $t02_jaminan_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
<?php
if ($t02_jaminan->ExportAll && $t02_jaminan->Export <> "") {
	$t02_jaminan_list->StopRec = $t02_jaminan_list->TotalRecs;
} else {

	// Set the last record to display
	if ($t02_jaminan_list->TotalRecs > $t02_jaminan_list->StartRec + $t02_jaminan_list->DisplayRecs - 1)
		$t02_jaminan_list->StopRec = $t02_jaminan_list->StartRec + $t02_jaminan_list->DisplayRecs - 1;
	else
		$t02_jaminan_list->StopRec = $t02_jaminan_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t02_jaminan_list->FormKeyCountName) && ($t02_jaminan->CurrentAction == "gridadd" || $t02_jaminan->CurrentAction == "gridedit" || $t02_jaminan->CurrentAction == "F")) {
		$t02_jaminan_list->KeyCount = $objForm->GetValue($t02_jaminan_list->FormKeyCountName);
		$t02_jaminan_list->StopRec = $t02_jaminan_list->StartRec + $t02_jaminan_list->KeyCount - 1;
	}
}
$t02_jaminan_list->RecCnt = $t02_jaminan_list->StartRec - 1;
if ($t02_jaminan_list->Recordset && !$t02_jaminan_list->Recordset->EOF) {
	$t02_jaminan_list->Recordset->MoveFirst();
	$bSelectLimit = $t02_jaminan_list->UseSelectLimit;
	if (!$bSelectLimit && $t02_jaminan_list->StartRec > 1)
		$t02_jaminan_list->Recordset->Move($t02_jaminan_list->StartRec - 1);
} elseif (!$t02_jaminan->AllowAddDeleteRow && $t02_jaminan_list->StopRec == 0) {
	$t02_jaminan_list->StopRec = $t02_jaminan->GridAddRowCount;
}

// Initialize aggregate
$t02_jaminan->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t02_jaminan->ResetAttrs();
$t02_jaminan_list->RenderRow();
$t02_jaminan_list->EditRowCnt = 0;
if ($t02_jaminan->CurrentAction == "edit")
	$t02_jaminan_list->RowIndex = 1;
if ($t02_jaminan->CurrentAction == "gridadd")
	$t02_jaminan_list->RowIndex = 0;
if ($t02_jaminan->CurrentAction == "gridedit")
	$t02_jaminan_list->RowIndex = 0;
while ($t02_jaminan_list->RecCnt < $t02_jaminan_list->StopRec) {
	$t02_jaminan_list->RecCnt++;
	if (intval($t02_jaminan_list->RecCnt) >= intval($t02_jaminan_list->StartRec)) {
		$t02_jaminan_list->RowCnt++;
		if ($t02_jaminan->CurrentAction == "gridadd" || $t02_jaminan->CurrentAction == "gridedit" || $t02_jaminan->CurrentAction == "F") {
			$t02_jaminan_list->RowIndex++;
			$objForm->Index = $t02_jaminan_list->RowIndex;
			if ($objForm->HasValue($t02_jaminan_list->FormActionName))
				$t02_jaminan_list->RowAction = strval($objForm->GetValue($t02_jaminan_list->FormActionName));
			elseif ($t02_jaminan->CurrentAction == "gridadd")
				$t02_jaminan_list->RowAction = "insert";
			else
				$t02_jaminan_list->RowAction = "";
		}

		// Set up key count
		$t02_jaminan_list->KeyCount = $t02_jaminan_list->RowIndex;

		// Init row class and style
		$t02_jaminan->ResetAttrs();
		$t02_jaminan->CssClass = "";
		if ($t02_jaminan->CurrentAction == "gridadd") {
			$t02_jaminan_list->LoadRowValues(); // Load default values
		} else {
			$t02_jaminan_list->LoadRowValues($t02_jaminan_list->Recordset); // Load row values
		}
		$t02_jaminan->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t02_jaminan->CurrentAction == "gridadd") // Grid add
			$t02_jaminan->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t02_jaminan->CurrentAction == "gridadd" && $t02_jaminan->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t02_jaminan_list->RestoreCurrentRowFormValues($t02_jaminan_list->RowIndex); // Restore form values
		if ($t02_jaminan->CurrentAction == "edit") {
			if ($t02_jaminan_list->CheckInlineEditKey() && $t02_jaminan_list->EditRowCnt == 0) { // Inline edit
				$t02_jaminan->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($t02_jaminan->CurrentAction == "gridedit") { // Grid edit
			if ($t02_jaminan->EventCancelled) {
				$t02_jaminan_list->RestoreCurrentRowFormValues($t02_jaminan_list->RowIndex); // Restore form values
			}
			if ($t02_jaminan_list->RowAction == "insert")
				$t02_jaminan->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t02_jaminan->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t02_jaminan->CurrentAction == "edit" && $t02_jaminan->RowType == EW_ROWTYPE_EDIT && $t02_jaminan->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$t02_jaminan_list->RestoreFormValues(); // Restore form values
		}
		if ($t02_jaminan->CurrentAction == "gridedit" && ($t02_jaminan->RowType == EW_ROWTYPE_EDIT || $t02_jaminan->RowType == EW_ROWTYPE_ADD) && $t02_jaminan->EventCancelled) // Update failed
			$t02_jaminan_list->RestoreCurrentRowFormValues($t02_jaminan_list->RowIndex); // Restore form values
		if ($t02_jaminan->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t02_jaminan_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$t02_jaminan->RowAttrs = array_merge($t02_jaminan->RowAttrs, array('data-rowindex'=>$t02_jaminan_list->RowCnt, 'id'=>'r' . $t02_jaminan_list->RowCnt . '_t02_jaminan', 'data-rowtype'=>$t02_jaminan->RowType));

		// Render row
		$t02_jaminan_list->RenderRow();

		// Render list options
		$t02_jaminan_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t02_jaminan_list->RowAction <> "delete" && $t02_jaminan_list->RowAction <> "insertdelete" && !($t02_jaminan_list->RowAction == "insert" && $t02_jaminan->CurrentAction == "F" && $t02_jaminan_list->EmptyRow())) {
?>
	<tr<?php echo $t02_jaminan->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t02_jaminan_list->ListOptions->Render("body", "left", $t02_jaminan_list->RowCnt);
?>
	<?php if ($t02_jaminan->MerkType->Visible) { // MerkType ?>
		<td data-name="MerkType"<?php echo $t02_jaminan->MerkType->CellAttributes() ?>>
<?php if ($t02_jaminan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_jaminan_list->RowCnt ?>_t02_jaminan_MerkType" class="form-group t02_jaminan_MerkType">
<input type="text" data-table="t02_jaminan" data-field="x_MerkType" name="x<?php echo $t02_jaminan_list->RowIndex ?>_MerkType" id="x<?php echo $t02_jaminan_list->RowIndex ?>_MerkType" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t02_jaminan->MerkType->getPlaceHolder()) ?>" value="<?php echo $t02_jaminan->MerkType->EditValue ?>"<?php echo $t02_jaminan->MerkType->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_jaminan" data-field="x_MerkType" name="o<?php echo $t02_jaminan_list->RowIndex ?>_MerkType" id="o<?php echo $t02_jaminan_list->RowIndex ?>_MerkType" value="<?php echo ew_HtmlEncode($t02_jaminan->MerkType->OldValue) ?>">
<?php } ?>
<?php if ($t02_jaminan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_jaminan_list->RowCnt ?>_t02_jaminan_MerkType" class="form-group t02_jaminan_MerkType">
<input type="text" data-table="t02_jaminan" data-field="x_MerkType" name="x<?php echo $t02_jaminan_list->RowIndex ?>_MerkType" id="x<?php echo $t02_jaminan_list->RowIndex ?>_MerkType" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t02_jaminan->MerkType->getPlaceHolder()) ?>" value="<?php echo $t02_jaminan->MerkType->EditValue ?>"<?php echo $t02_jaminan->MerkType->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_jaminan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_jaminan_list->RowCnt ?>_t02_jaminan_MerkType" class="t02_jaminan_MerkType">
<span<?php echo $t02_jaminan->MerkType->ViewAttributes() ?>>
<?php echo $t02_jaminan->MerkType->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php if ($t02_jaminan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t02_jaminan" data-field="x_id" name="x<?php echo $t02_jaminan_list->RowIndex ?>_id" id="x<?php echo $t02_jaminan_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t02_jaminan->id->CurrentValue) ?>">
<input type="hidden" data-table="t02_jaminan" data-field="x_id" name="o<?php echo $t02_jaminan_list->RowIndex ?>_id" id="o<?php echo $t02_jaminan_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t02_jaminan->id->OldValue) ?>">
<?php } ?>
<?php if ($t02_jaminan->RowType == EW_ROWTYPE_EDIT || $t02_jaminan->CurrentMode == "edit") { ?>
<input type="hidden" data-table="t02_jaminan" data-field="x_id" name="x<?php echo $t02_jaminan_list->RowIndex ?>_id" id="x<?php echo $t02_jaminan_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t02_jaminan->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($t02_jaminan->NoRangka->Visible) { // NoRangka ?>
		<td data-name="NoRangka"<?php echo $t02_jaminan->NoRangka->CellAttributes() ?>>
<?php if ($t02_jaminan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_jaminan_list->RowCnt ?>_t02_jaminan_NoRangka" class="form-group t02_jaminan_NoRangka">
<input type="text" data-table="t02_jaminan" data-field="x_NoRangka" name="x<?php echo $t02_jaminan_list->RowIndex ?>_NoRangka" id="x<?php echo $t02_jaminan_list->RowIndex ?>_NoRangka" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t02_jaminan->NoRangka->getPlaceHolder()) ?>" value="<?php echo $t02_jaminan->NoRangka->EditValue ?>"<?php echo $t02_jaminan->NoRangka->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_jaminan" data-field="x_NoRangka" name="o<?php echo $t02_jaminan_list->RowIndex ?>_NoRangka" id="o<?php echo $t02_jaminan_list->RowIndex ?>_NoRangka" value="<?php echo ew_HtmlEncode($t02_jaminan->NoRangka->OldValue) ?>">
<?php } ?>
<?php if ($t02_jaminan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_jaminan_list->RowCnt ?>_t02_jaminan_NoRangka" class="form-group t02_jaminan_NoRangka">
<input type="text" data-table="t02_jaminan" data-field="x_NoRangka" name="x<?php echo $t02_jaminan_list->RowIndex ?>_NoRangka" id="x<?php echo $t02_jaminan_list->RowIndex ?>_NoRangka" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t02_jaminan->NoRangka->getPlaceHolder()) ?>" value="<?php echo $t02_jaminan->NoRangka->EditValue ?>"<?php echo $t02_jaminan->NoRangka->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_jaminan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_jaminan_list->RowCnt ?>_t02_jaminan_NoRangka" class="t02_jaminan_NoRangka">
<span<?php echo $t02_jaminan->NoRangka->ViewAttributes() ?>>
<?php echo $t02_jaminan->NoRangka->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_jaminan->NoMesin->Visible) { // NoMesin ?>
		<td data-name="NoMesin"<?php echo $t02_jaminan->NoMesin->CellAttributes() ?>>
<?php if ($t02_jaminan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_jaminan_list->RowCnt ?>_t02_jaminan_NoMesin" class="form-group t02_jaminan_NoMesin">
<input type="text" data-table="t02_jaminan" data-field="x_NoMesin" name="x<?php echo $t02_jaminan_list->RowIndex ?>_NoMesin" id="x<?php echo $t02_jaminan_list->RowIndex ?>_NoMesin" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t02_jaminan->NoMesin->getPlaceHolder()) ?>" value="<?php echo $t02_jaminan->NoMesin->EditValue ?>"<?php echo $t02_jaminan->NoMesin->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_jaminan" data-field="x_NoMesin" name="o<?php echo $t02_jaminan_list->RowIndex ?>_NoMesin" id="o<?php echo $t02_jaminan_list->RowIndex ?>_NoMesin" value="<?php echo ew_HtmlEncode($t02_jaminan->NoMesin->OldValue) ?>">
<?php } ?>
<?php if ($t02_jaminan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_jaminan_list->RowCnt ?>_t02_jaminan_NoMesin" class="form-group t02_jaminan_NoMesin">
<input type="text" data-table="t02_jaminan" data-field="x_NoMesin" name="x<?php echo $t02_jaminan_list->RowIndex ?>_NoMesin" id="x<?php echo $t02_jaminan_list->RowIndex ?>_NoMesin" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t02_jaminan->NoMesin->getPlaceHolder()) ?>" value="<?php echo $t02_jaminan->NoMesin->EditValue ?>"<?php echo $t02_jaminan->NoMesin->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_jaminan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_jaminan_list->RowCnt ?>_t02_jaminan_NoMesin" class="t02_jaminan_NoMesin">
<span<?php echo $t02_jaminan->NoMesin->ViewAttributes() ?>>
<?php echo $t02_jaminan->NoMesin->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_jaminan->Warna->Visible) { // Warna ?>
		<td data-name="Warna"<?php echo $t02_jaminan->Warna->CellAttributes() ?>>
<?php if ($t02_jaminan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_jaminan_list->RowCnt ?>_t02_jaminan_Warna" class="form-group t02_jaminan_Warna">
<input type="text" data-table="t02_jaminan" data-field="x_Warna" name="x<?php echo $t02_jaminan_list->RowIndex ?>_Warna" id="x<?php echo $t02_jaminan_list->RowIndex ?>_Warna" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($t02_jaminan->Warna->getPlaceHolder()) ?>" value="<?php echo $t02_jaminan->Warna->EditValue ?>"<?php echo $t02_jaminan->Warna->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_jaminan" data-field="x_Warna" name="o<?php echo $t02_jaminan_list->RowIndex ?>_Warna" id="o<?php echo $t02_jaminan_list->RowIndex ?>_Warna" value="<?php echo ew_HtmlEncode($t02_jaminan->Warna->OldValue) ?>">
<?php } ?>
<?php if ($t02_jaminan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_jaminan_list->RowCnt ?>_t02_jaminan_Warna" class="form-group t02_jaminan_Warna">
<input type="text" data-table="t02_jaminan" data-field="x_Warna" name="x<?php echo $t02_jaminan_list->RowIndex ?>_Warna" id="x<?php echo $t02_jaminan_list->RowIndex ?>_Warna" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($t02_jaminan->Warna->getPlaceHolder()) ?>" value="<?php echo $t02_jaminan->Warna->EditValue ?>"<?php echo $t02_jaminan->Warna->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_jaminan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_jaminan_list->RowCnt ?>_t02_jaminan_Warna" class="t02_jaminan_Warna">
<span<?php echo $t02_jaminan->Warna->ViewAttributes() ?>>
<?php echo $t02_jaminan->Warna->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_jaminan->NoPol->Visible) { // NoPol ?>
		<td data-name="NoPol"<?php echo $t02_jaminan->NoPol->CellAttributes() ?>>
<?php if ($t02_jaminan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_jaminan_list->RowCnt ?>_t02_jaminan_NoPol" class="form-group t02_jaminan_NoPol">
<input type="text" data-table="t02_jaminan" data-field="x_NoPol" name="x<?php echo $t02_jaminan_list->RowIndex ?>_NoPol" id="x<?php echo $t02_jaminan_list->RowIndex ?>_NoPol" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($t02_jaminan->NoPol->getPlaceHolder()) ?>" value="<?php echo $t02_jaminan->NoPol->EditValue ?>"<?php echo $t02_jaminan->NoPol->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_jaminan" data-field="x_NoPol" name="o<?php echo $t02_jaminan_list->RowIndex ?>_NoPol" id="o<?php echo $t02_jaminan_list->RowIndex ?>_NoPol" value="<?php echo ew_HtmlEncode($t02_jaminan->NoPol->OldValue) ?>">
<?php } ?>
<?php if ($t02_jaminan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_jaminan_list->RowCnt ?>_t02_jaminan_NoPol" class="form-group t02_jaminan_NoPol">
<input type="text" data-table="t02_jaminan" data-field="x_NoPol" name="x<?php echo $t02_jaminan_list->RowIndex ?>_NoPol" id="x<?php echo $t02_jaminan_list->RowIndex ?>_NoPol" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($t02_jaminan->NoPol->getPlaceHolder()) ?>" value="<?php echo $t02_jaminan->NoPol->EditValue ?>"<?php echo $t02_jaminan->NoPol->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_jaminan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_jaminan_list->RowCnt ?>_t02_jaminan_NoPol" class="t02_jaminan_NoPol">
<span<?php echo $t02_jaminan->NoPol->ViewAttributes() ?>>
<?php echo $t02_jaminan->NoPol->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_jaminan->Keterangan->Visible) { // Keterangan ?>
		<td data-name="Keterangan"<?php echo $t02_jaminan->Keterangan->CellAttributes() ?>>
<?php if ($t02_jaminan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_jaminan_list->RowCnt ?>_t02_jaminan_Keterangan" class="form-group t02_jaminan_Keterangan">
<textarea data-table="t02_jaminan" data-field="x_Keterangan" name="x<?php echo $t02_jaminan_list->RowIndex ?>_Keterangan" id="x<?php echo $t02_jaminan_list->RowIndex ?>_Keterangan" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($t02_jaminan->Keterangan->getPlaceHolder()) ?>"<?php echo $t02_jaminan->Keterangan->EditAttributes() ?>><?php echo $t02_jaminan->Keterangan->EditValue ?></textarea>
</span>
<input type="hidden" data-table="t02_jaminan" data-field="x_Keterangan" name="o<?php echo $t02_jaminan_list->RowIndex ?>_Keterangan" id="o<?php echo $t02_jaminan_list->RowIndex ?>_Keterangan" value="<?php echo ew_HtmlEncode($t02_jaminan->Keterangan->OldValue) ?>">
<?php } ?>
<?php if ($t02_jaminan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_jaminan_list->RowCnt ?>_t02_jaminan_Keterangan" class="form-group t02_jaminan_Keterangan">
<textarea data-table="t02_jaminan" data-field="x_Keterangan" name="x<?php echo $t02_jaminan_list->RowIndex ?>_Keterangan" id="x<?php echo $t02_jaminan_list->RowIndex ?>_Keterangan" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($t02_jaminan->Keterangan->getPlaceHolder()) ?>"<?php echo $t02_jaminan->Keterangan->EditAttributes() ?>><?php echo $t02_jaminan->Keterangan->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($t02_jaminan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_jaminan_list->RowCnt ?>_t02_jaminan_Keterangan" class="t02_jaminan_Keterangan">
<span<?php echo $t02_jaminan->Keterangan->ViewAttributes() ?>>
<?php echo $t02_jaminan->Keterangan->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_jaminan->AtasNama->Visible) { // AtasNama ?>
		<td data-name="AtasNama"<?php echo $t02_jaminan->AtasNama->CellAttributes() ?>>
<?php if ($t02_jaminan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_jaminan_list->RowCnt ?>_t02_jaminan_AtasNama" class="form-group t02_jaminan_AtasNama">
<input type="text" data-table="t02_jaminan" data-field="x_AtasNama" name="x<?php echo $t02_jaminan_list->RowIndex ?>_AtasNama" id="x<?php echo $t02_jaminan_list->RowIndex ?>_AtasNama" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t02_jaminan->AtasNama->getPlaceHolder()) ?>" value="<?php echo $t02_jaminan->AtasNama->EditValue ?>"<?php echo $t02_jaminan->AtasNama->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_jaminan" data-field="x_AtasNama" name="o<?php echo $t02_jaminan_list->RowIndex ?>_AtasNama" id="o<?php echo $t02_jaminan_list->RowIndex ?>_AtasNama" value="<?php echo ew_HtmlEncode($t02_jaminan->AtasNama->OldValue) ?>">
<?php } ?>
<?php if ($t02_jaminan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_jaminan_list->RowCnt ?>_t02_jaminan_AtasNama" class="form-group t02_jaminan_AtasNama">
<input type="text" data-table="t02_jaminan" data-field="x_AtasNama" name="x<?php echo $t02_jaminan_list->RowIndex ?>_AtasNama" id="x<?php echo $t02_jaminan_list->RowIndex ?>_AtasNama" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t02_jaminan->AtasNama->getPlaceHolder()) ?>" value="<?php echo $t02_jaminan->AtasNama->EditValue ?>"<?php echo $t02_jaminan->AtasNama->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_jaminan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_jaminan_list->RowCnt ?>_t02_jaminan_AtasNama" class="t02_jaminan_AtasNama">
<span<?php echo $t02_jaminan->AtasNama->ViewAttributes() ?>>
<?php echo $t02_jaminan->AtasNama->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t02_jaminan_list->ListOptions->Render("body", "right", $t02_jaminan_list->RowCnt);
?>
	</tr>
<?php if ($t02_jaminan->RowType == EW_ROWTYPE_ADD || $t02_jaminan->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft02_jaminanlist.UpdateOpts(<?php echo $t02_jaminan_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t02_jaminan->CurrentAction <> "gridadd")
		if (!$t02_jaminan_list->Recordset->EOF) $t02_jaminan_list->Recordset->MoveNext();
}
?>
<?php
	if ($t02_jaminan->CurrentAction == "gridadd" || $t02_jaminan->CurrentAction == "gridedit") {
		$t02_jaminan_list->RowIndex = '$rowindex$';
		$t02_jaminan_list->LoadRowValues();

		// Set row properties
		$t02_jaminan->ResetAttrs();
		$t02_jaminan->RowAttrs = array_merge($t02_jaminan->RowAttrs, array('data-rowindex'=>$t02_jaminan_list->RowIndex, 'id'=>'r0_t02_jaminan', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t02_jaminan->RowAttrs["class"], "ewTemplate");
		$t02_jaminan->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t02_jaminan_list->RenderRow();

		// Render list options
		$t02_jaminan_list->RenderListOptions();
		$t02_jaminan_list->StartRowCnt = 0;
?>
	<tr<?php echo $t02_jaminan->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t02_jaminan_list->ListOptions->Render("body", "left", $t02_jaminan_list->RowIndex);
?>
	<?php if ($t02_jaminan->MerkType->Visible) { // MerkType ?>
		<td data-name="MerkType">
<span id="el$rowindex$_t02_jaminan_MerkType" class="form-group t02_jaminan_MerkType">
<input type="text" data-table="t02_jaminan" data-field="x_MerkType" name="x<?php echo $t02_jaminan_list->RowIndex ?>_MerkType" id="x<?php echo $t02_jaminan_list->RowIndex ?>_MerkType" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t02_jaminan->MerkType->getPlaceHolder()) ?>" value="<?php echo $t02_jaminan->MerkType->EditValue ?>"<?php echo $t02_jaminan->MerkType->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_jaminan" data-field="x_MerkType" name="o<?php echo $t02_jaminan_list->RowIndex ?>_MerkType" id="o<?php echo $t02_jaminan_list->RowIndex ?>_MerkType" value="<?php echo ew_HtmlEncode($t02_jaminan->MerkType->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_jaminan->NoRangka->Visible) { // NoRangka ?>
		<td data-name="NoRangka">
<span id="el$rowindex$_t02_jaminan_NoRangka" class="form-group t02_jaminan_NoRangka">
<input type="text" data-table="t02_jaminan" data-field="x_NoRangka" name="x<?php echo $t02_jaminan_list->RowIndex ?>_NoRangka" id="x<?php echo $t02_jaminan_list->RowIndex ?>_NoRangka" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t02_jaminan->NoRangka->getPlaceHolder()) ?>" value="<?php echo $t02_jaminan->NoRangka->EditValue ?>"<?php echo $t02_jaminan->NoRangka->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_jaminan" data-field="x_NoRangka" name="o<?php echo $t02_jaminan_list->RowIndex ?>_NoRangka" id="o<?php echo $t02_jaminan_list->RowIndex ?>_NoRangka" value="<?php echo ew_HtmlEncode($t02_jaminan->NoRangka->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_jaminan->NoMesin->Visible) { // NoMesin ?>
		<td data-name="NoMesin">
<span id="el$rowindex$_t02_jaminan_NoMesin" class="form-group t02_jaminan_NoMesin">
<input type="text" data-table="t02_jaminan" data-field="x_NoMesin" name="x<?php echo $t02_jaminan_list->RowIndex ?>_NoMesin" id="x<?php echo $t02_jaminan_list->RowIndex ?>_NoMesin" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t02_jaminan->NoMesin->getPlaceHolder()) ?>" value="<?php echo $t02_jaminan->NoMesin->EditValue ?>"<?php echo $t02_jaminan->NoMesin->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_jaminan" data-field="x_NoMesin" name="o<?php echo $t02_jaminan_list->RowIndex ?>_NoMesin" id="o<?php echo $t02_jaminan_list->RowIndex ?>_NoMesin" value="<?php echo ew_HtmlEncode($t02_jaminan->NoMesin->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_jaminan->Warna->Visible) { // Warna ?>
		<td data-name="Warna">
<span id="el$rowindex$_t02_jaminan_Warna" class="form-group t02_jaminan_Warna">
<input type="text" data-table="t02_jaminan" data-field="x_Warna" name="x<?php echo $t02_jaminan_list->RowIndex ?>_Warna" id="x<?php echo $t02_jaminan_list->RowIndex ?>_Warna" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($t02_jaminan->Warna->getPlaceHolder()) ?>" value="<?php echo $t02_jaminan->Warna->EditValue ?>"<?php echo $t02_jaminan->Warna->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_jaminan" data-field="x_Warna" name="o<?php echo $t02_jaminan_list->RowIndex ?>_Warna" id="o<?php echo $t02_jaminan_list->RowIndex ?>_Warna" value="<?php echo ew_HtmlEncode($t02_jaminan->Warna->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_jaminan->NoPol->Visible) { // NoPol ?>
		<td data-name="NoPol">
<span id="el$rowindex$_t02_jaminan_NoPol" class="form-group t02_jaminan_NoPol">
<input type="text" data-table="t02_jaminan" data-field="x_NoPol" name="x<?php echo $t02_jaminan_list->RowIndex ?>_NoPol" id="x<?php echo $t02_jaminan_list->RowIndex ?>_NoPol" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($t02_jaminan->NoPol->getPlaceHolder()) ?>" value="<?php echo $t02_jaminan->NoPol->EditValue ?>"<?php echo $t02_jaminan->NoPol->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_jaminan" data-field="x_NoPol" name="o<?php echo $t02_jaminan_list->RowIndex ?>_NoPol" id="o<?php echo $t02_jaminan_list->RowIndex ?>_NoPol" value="<?php echo ew_HtmlEncode($t02_jaminan->NoPol->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_jaminan->Keterangan->Visible) { // Keterangan ?>
		<td data-name="Keterangan">
<span id="el$rowindex$_t02_jaminan_Keterangan" class="form-group t02_jaminan_Keterangan">
<textarea data-table="t02_jaminan" data-field="x_Keterangan" name="x<?php echo $t02_jaminan_list->RowIndex ?>_Keterangan" id="x<?php echo $t02_jaminan_list->RowIndex ?>_Keterangan" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($t02_jaminan->Keterangan->getPlaceHolder()) ?>"<?php echo $t02_jaminan->Keterangan->EditAttributes() ?>><?php echo $t02_jaminan->Keterangan->EditValue ?></textarea>
</span>
<input type="hidden" data-table="t02_jaminan" data-field="x_Keterangan" name="o<?php echo $t02_jaminan_list->RowIndex ?>_Keterangan" id="o<?php echo $t02_jaminan_list->RowIndex ?>_Keterangan" value="<?php echo ew_HtmlEncode($t02_jaminan->Keterangan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_jaminan->AtasNama->Visible) { // AtasNama ?>
		<td data-name="AtasNama">
<span id="el$rowindex$_t02_jaminan_AtasNama" class="form-group t02_jaminan_AtasNama">
<input type="text" data-table="t02_jaminan" data-field="x_AtasNama" name="x<?php echo $t02_jaminan_list->RowIndex ?>_AtasNama" id="x<?php echo $t02_jaminan_list->RowIndex ?>_AtasNama" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t02_jaminan->AtasNama->getPlaceHolder()) ?>" value="<?php echo $t02_jaminan->AtasNama->EditValue ?>"<?php echo $t02_jaminan->AtasNama->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_jaminan" data-field="x_AtasNama" name="o<?php echo $t02_jaminan_list->RowIndex ?>_AtasNama" id="o<?php echo $t02_jaminan_list->RowIndex ?>_AtasNama" value="<?php echo ew_HtmlEncode($t02_jaminan->AtasNama->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t02_jaminan_list->ListOptions->Render("body", "right", $t02_jaminan_list->RowIndex);
?>
<script type="text/javascript">
ft02_jaminanlist.UpdateOpts(<?php echo $t02_jaminan_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($t02_jaminan->CurrentAction == "add" || $t02_jaminan->CurrentAction == "copy") { ?>
<input type="hidden" name="<?php echo $t02_jaminan_list->FormKeyCountName ?>" id="<?php echo $t02_jaminan_list->FormKeyCountName ?>" value="<?php echo $t02_jaminan_list->KeyCount ?>">
<?php } ?>
<?php if ($t02_jaminan->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t02_jaminan_list->FormKeyCountName ?>" id="<?php echo $t02_jaminan_list->FormKeyCountName ?>" value="<?php echo $t02_jaminan_list->KeyCount ?>">
<?php echo $t02_jaminan_list->MultiSelectKey ?>
<?php } ?>
<?php if ($t02_jaminan->CurrentAction == "edit") { ?>
<input type="hidden" name="<?php echo $t02_jaminan_list->FormKeyCountName ?>" id="<?php echo $t02_jaminan_list->FormKeyCountName ?>" value="<?php echo $t02_jaminan_list->KeyCount ?>">
<?php } ?>
<?php if ($t02_jaminan->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t02_jaminan_list->FormKeyCountName ?>" id="<?php echo $t02_jaminan_list->FormKeyCountName ?>" value="<?php echo $t02_jaminan_list->KeyCount ?>">
<?php echo $t02_jaminan_list->MultiSelectKey ?>
<?php } ?>
<?php if ($t02_jaminan->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($t02_jaminan_list->Recordset)
	$t02_jaminan_list->Recordset->Close();
?>
<div class="box-footer ewGridLowerPanel">
<?php if ($t02_jaminan->CurrentAction <> "gridadd" && $t02_jaminan->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t02_jaminan_list->Pager)) $t02_jaminan_list->Pager = new cPrevNextPager($t02_jaminan_list->StartRec, $t02_jaminan_list->DisplayRecs, $t02_jaminan_list->TotalRecs, $t02_jaminan_list->AutoHidePager) ?>
<?php if ($t02_jaminan_list->Pager->RecordCount > 0 && $t02_jaminan_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t02_jaminan_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t02_jaminan_list->PageUrl() ?>start=<?php echo $t02_jaminan_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t02_jaminan_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t02_jaminan_list->PageUrl() ?>start=<?php echo $t02_jaminan_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t02_jaminan_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t02_jaminan_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t02_jaminan_list->PageUrl() ?>start=<?php echo $t02_jaminan_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t02_jaminan_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t02_jaminan_list->PageUrl() ?>start=<?php echo $t02_jaminan_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t02_jaminan_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($t02_jaminan_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $t02_jaminan_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $t02_jaminan_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $t02_jaminan_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($t02_jaminan_list->TotalRecs > 0 && (!$t02_jaminan_list->AutoHidePageSizeSelector || $t02_jaminan_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="t02_jaminan">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($t02_jaminan_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($t02_jaminan_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($t02_jaminan_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($t02_jaminan_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="200"<?php if ($t02_jaminan_list->DisplayRecs == 200) { ?> selected<?php } ?>>200</option>
<option value="ALL"<?php if ($t02_jaminan->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t02_jaminan_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($t02_jaminan_list->TotalRecs == 0 && $t02_jaminan->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t02_jaminan_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
ft02_jaminanlistsrch.FilterList = <?php echo $t02_jaminan_list->GetFilterList() ?>;
ft02_jaminanlistsrch.Init();
ft02_jaminanlist.Init();
</script>
<?php
$t02_jaminan_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t02_jaminan_list->Page_Terminate();
?>
