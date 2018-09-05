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
<?php include_once "t02_jaminangridcls.php" ?>
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
		// Create form object

		$objForm = new cFormObj();
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
				if (in_array("t02_jaminan", $DetailTblVar)) {

					// Process auto fill for detail table 't02_jaminan'
					if (preg_match('/^ft02_jaminan(grid|add|addopt|edit|update|search)$/', @$_POST["form"])) {
						if (!isset($GLOBALS["t02_jaminan_grid"])) $GLOBALS["t02_jaminan_grid"] = new ct02_jaminan_grid;
						$GLOBALS["t02_jaminan_grid"]->Page_Init();
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
		$this->Pinjaman->FormValue = ""; // Clear form value
		$this->Denda->FormValue = ""; // Clear form value
		$this->JumlahAngsuran->FormValue = ""; // Clear form value
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
		if ($objForm->HasValue("x_NoKontrak") && $objForm->HasValue("o_NoKontrak") && $this->NoKontrak->CurrentValue <> $this->NoKontrak->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_TglKontrak") && $objForm->HasValue("o_TglKontrak") && $this->TglKontrak->CurrentValue <> $this->TglKontrak->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_nasabah_id") && $objForm->HasValue("o_nasabah_id") && $this->nasabah_id->CurrentValue <> $this->nasabah_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Pinjaman") && $objForm->HasValue("o_Pinjaman") && $this->Pinjaman->CurrentValue <> $this->Pinjaman->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Denda") && $objForm->HasValue("o_Denda") && $this->Denda->CurrentValue <> $this->Denda->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_DispensasiDenda") && $objForm->HasValue("o_DispensasiDenda") && $this->DispensasiDenda->CurrentValue <> $this->DispensasiDenda->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_LamaAngsuran") && $objForm->HasValue("o_LamaAngsuran") && $this->LamaAngsuran->CurrentValue <> $this->LamaAngsuran->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_JumlahAngsuran") && $objForm->HasValue("o_JumlahAngsuran") && $this->JumlahAngsuran->CurrentValue <> $this->JumlahAngsuran->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_NoKontrakRefTo") && $objForm->HasValue("o_NoKontrakRefTo") && $this->NoKontrakRefTo->CurrentValue <> $this->NoKontrakRefTo->OldValue)
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
		$sFilterList = ew_Concat($sFilterList, $this->NoKontrak->AdvancedSearch->ToJson(), ","); // Field NoKontrak
		$sFilterList = ew_Concat($sFilterList, $this->TglKontrak->AdvancedSearch->ToJson(), ","); // Field TglKontrak
		$sFilterList = ew_Concat($sFilterList, $this->nasabah_id->AdvancedSearch->ToJson(), ","); // Field nasabah_id
		$sFilterList = ew_Concat($sFilterList, $this->Pinjaman->AdvancedSearch->ToJson(), ","); // Field Pinjaman
		$sFilterList = ew_Concat($sFilterList, $this->Denda->AdvancedSearch->ToJson(), ","); // Field Denda
		$sFilterList = ew_Concat($sFilterList, $this->DispensasiDenda->AdvancedSearch->ToJson(), ","); // Field DispensasiDenda
		$sFilterList = ew_Concat($sFilterList, $this->LamaAngsuran->AdvancedSearch->ToJson(), ","); // Field LamaAngsuran
		$sFilterList = ew_Concat($sFilterList, $this->JumlahAngsuran->AdvancedSearch->ToJson(), ","); // Field JumlahAngsuran
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
			$this->UpdateSort($this->Denda, $bCtrl); // Denda
			$this->UpdateSort($this->DispensasiDenda, $bCtrl); // DispensasiDenda
			$this->UpdateSort($this->LamaAngsuran, $bCtrl); // LamaAngsuran
			$this->UpdateSort($this->JumlahAngsuran, $bCtrl); // JumlahAngsuran
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
				$this->Denda->setSort("");
				$this->DispensasiDenda->setSort("");
				$this->LamaAngsuran->setSort("");
				$this->JumlahAngsuran->setSort("");
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

		// "detail_t02_jaminan"
		$item = &$this->ListOptions->Add("detail_t02_jaminan");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 't02_jaminan') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["t02_jaminan_grid"])) $GLOBALS["t02_jaminan_grid"] = new ct02_jaminan_grid;

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
		$pages->Add("t02_jaminan");
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

		// "detail_t02_jaminan"
		$oListOpt = &$this->ListOptions->Items["detail_t02_jaminan"];
		if ($Security->AllowList(CurrentProjectID() . 't02_jaminan')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("t02_jaminan", "TblCaption");
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("t02_jaminanlist.php?" . EW_TABLE_SHOW_MASTER . "=t03_pinjaman&fk_nasabah_id=" . urlencode(strval($this->nasabah_id->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["t02_jaminan_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 't02_jaminan')) {
				$caption = $Language->Phrase("MasterDetailEditLink");
				$url = $this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=t02_jaminan");
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . ew_HtmlImageAndText($caption) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "t02_jaminan";
			}
			if ($GLOBALS["t02_jaminan_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 't02_jaminan')) {
				$caption = $Language->Phrase("MasterDetailCopyLink");
				$url = $this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=t02_jaminan");
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . ew_HtmlImageAndText($caption) . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "t02_jaminan";
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
		$item = &$option->Add("detailadd_t02_jaminan");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=t02_jaminan");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["t02_jaminan"]->TableCaption();
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["t02_jaminan"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 't02_jaminan') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "t02_jaminan";
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
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "gridedit") { // Not grid add/edit mode
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
		if (!$this->NoKontrak->FldIsDetailKey) {
			$this->NoKontrak->setFormValue($objForm->GetValue("x_NoKontrak"));
		}
		$this->NoKontrak->setOldValue($objForm->GetValue("o_NoKontrak"));
		if (!$this->TglKontrak->FldIsDetailKey) {
			$this->TglKontrak->setFormValue($objForm->GetValue("x_TglKontrak"));
			$this->TglKontrak->CurrentValue = ew_UnFormatDateTime($this->TglKontrak->CurrentValue, 7);
		}
		$this->TglKontrak->setOldValue($objForm->GetValue("o_TglKontrak"));
		if (!$this->nasabah_id->FldIsDetailKey) {
			$this->nasabah_id->setFormValue($objForm->GetValue("x_nasabah_id"));
		}
		$this->nasabah_id->setOldValue($objForm->GetValue("o_nasabah_id"));
		if (!$this->Pinjaman->FldIsDetailKey) {
			$this->Pinjaman->setFormValue($objForm->GetValue("x_Pinjaman"));
		}
		$this->Pinjaman->setOldValue($objForm->GetValue("o_Pinjaman"));
		if (!$this->Denda->FldIsDetailKey) {
			$this->Denda->setFormValue($objForm->GetValue("x_Denda"));
		}
		$this->Denda->setOldValue($objForm->GetValue("o_Denda"));
		if (!$this->DispensasiDenda->FldIsDetailKey) {
			$this->DispensasiDenda->setFormValue($objForm->GetValue("x_DispensasiDenda"));
		}
		$this->DispensasiDenda->setOldValue($objForm->GetValue("o_DispensasiDenda"));
		if (!$this->LamaAngsuran->FldIsDetailKey) {
			$this->LamaAngsuran->setFormValue($objForm->GetValue("x_LamaAngsuran"));
		}
		$this->LamaAngsuran->setOldValue($objForm->GetValue("o_LamaAngsuran"));
		if (!$this->JumlahAngsuran->FldIsDetailKey) {
			$this->JumlahAngsuran->setFormValue($objForm->GetValue("x_JumlahAngsuran"));
		}
		$this->JumlahAngsuran->setOldValue($objForm->GetValue("o_JumlahAngsuran"));
		if (!$this->NoKontrakRefTo->FldIsDetailKey) {
			$this->NoKontrakRefTo->setFormValue($objForm->GetValue("x_NoKontrakRefTo"));
		}
		$this->NoKontrakRefTo->setOldValue($objForm->GetValue("o_NoKontrakRefTo"));
		if (!$this->id->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->CurrentValue = $this->id->FormValue;
		$this->NoKontrak->CurrentValue = $this->NoKontrak->FormValue;
		$this->TglKontrak->CurrentValue = $this->TglKontrak->FormValue;
		$this->TglKontrak->CurrentValue = ew_UnFormatDateTime($this->TglKontrak->CurrentValue, 7);
		$this->nasabah_id->CurrentValue = $this->nasabah_id->FormValue;
		$this->Pinjaman->CurrentValue = $this->Pinjaman->FormValue;
		$this->Denda->CurrentValue = $this->Denda->FormValue;
		$this->DispensasiDenda->CurrentValue = $this->DispensasiDenda->FormValue;
		$this->LamaAngsuran->CurrentValue = $this->LamaAngsuran->FormValue;
		$this->JumlahAngsuran->CurrentValue = $this->JumlahAngsuran->FormValue;
		$this->NoKontrakRefTo->CurrentValue = $this->NoKontrakRefTo->FormValue;
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
		// TglKontrak
		// nasabah_id
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

			// Pinjaman
			$this->Pinjaman->EditAttrs["class"] = "form-control";
			$this->Pinjaman->EditCustomAttributes = "";
			$this->Pinjaman->EditValue = ew_HtmlEncode($this->Pinjaman->CurrentValue);
			$this->Pinjaman->PlaceHolder = ew_RemoveHtml($this->Pinjaman->FldCaption());
			if (strval($this->Pinjaman->EditValue) <> "" && is_numeric($this->Pinjaman->EditValue)) {
			$this->Pinjaman->EditValue = ew_FormatNumber($this->Pinjaman->EditValue, -2, -2, -2, -2);
			$this->Pinjaman->OldValue = $this->Pinjaman->EditValue;
			}

			// Denda
			$this->Denda->EditAttrs["class"] = "form-control";
			$this->Denda->EditCustomAttributes = "";
			$this->Denda->EditValue = ew_HtmlEncode($this->Denda->CurrentValue);
			$this->Denda->PlaceHolder = ew_RemoveHtml($this->Denda->FldCaption());
			if (strval($this->Denda->EditValue) <> "" && is_numeric($this->Denda->EditValue)) {
			$this->Denda->EditValue = ew_FormatNumber($this->Denda->EditValue, -2, -2, -2, -2);
			$this->Denda->OldValue = $this->Denda->EditValue;
			}

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
			if (strval($this->JumlahAngsuran->EditValue) <> "" && is_numeric($this->JumlahAngsuran->EditValue)) {
			$this->JumlahAngsuran->EditValue = ew_FormatNumber($this->JumlahAngsuran->EditValue, -2, -2, -2, -2);
			$this->JumlahAngsuran->OldValue = $this->JumlahAngsuran->EditValue;
			}

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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

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

			// Pinjaman
			$this->Pinjaman->EditAttrs["class"] = "form-control";
			$this->Pinjaman->EditCustomAttributes = "";
			$this->Pinjaman->EditValue = ew_HtmlEncode($this->Pinjaman->CurrentValue);
			$this->Pinjaman->PlaceHolder = ew_RemoveHtml($this->Pinjaman->FldCaption());
			if (strval($this->Pinjaman->EditValue) <> "" && is_numeric($this->Pinjaman->EditValue)) {
			$this->Pinjaman->EditValue = ew_FormatNumber($this->Pinjaman->EditValue, -2, -2, -2, -2);
			$this->Pinjaman->OldValue = $this->Pinjaman->EditValue;
			}

			// Denda
			$this->Denda->EditAttrs["class"] = "form-control";
			$this->Denda->EditCustomAttributes = "";
			$this->Denda->EditValue = ew_HtmlEncode($this->Denda->CurrentValue);
			$this->Denda->PlaceHolder = ew_RemoveHtml($this->Denda->FldCaption());
			if (strval($this->Denda->EditValue) <> "" && is_numeric($this->Denda->EditValue)) {
			$this->Denda->EditValue = ew_FormatNumber($this->Denda->EditValue, -2, -2, -2, -2);
			$this->Denda->OldValue = $this->Denda->EditValue;
			}

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
			if (strval($this->JumlahAngsuran->EditValue) <> "" && is_numeric($this->JumlahAngsuran->EditValue)) {
			$this->JumlahAngsuran->EditValue = ew_FormatNumber($this->JumlahAngsuran->EditValue, -2, -2, -2, -2);
			$this->JumlahAngsuran->OldValue = $this->JumlahAngsuran->EditValue;
			}

			// NoKontrakRefTo
			$this->NoKontrakRefTo->EditAttrs["class"] = "form-control";
			$this->NoKontrakRefTo->EditCustomAttributes = "";
			$this->NoKontrakRefTo->EditValue = ew_HtmlEncode($this->NoKontrakRefTo->CurrentValue);
			$this->NoKontrakRefTo->PlaceHolder = ew_RemoveHtml($this->NoKontrakRefTo->FldCaption());

			// Edit refer script
			// NoKontrak

			$this->NoKontrak->LinkCustomAttributes = "";
			$this->NoKontrak->HrefValue = "";

			// TglKontrak
			$this->TglKontrak->LinkCustomAttributes = "";
			$this->TglKontrak->HrefValue = "";

			// nasabah_id
			$this->nasabah_id->LinkCustomAttributes = "";
			$this->nasabah_id->HrefValue = "";

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

			// NoKontrak
			$this->NoKontrak->SetDbValueDef($rsnew, $this->NoKontrak->CurrentValue, "", $this->NoKontrak->ReadOnly);

			// TglKontrak
			$this->TglKontrak->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->TglKontrak->CurrentValue, 7), ew_CurrentDate(), $this->TglKontrak->ReadOnly);

			// nasabah_id
			$this->nasabah_id->SetDbValueDef($rsnew, $this->nasabah_id->CurrentValue, 0, $this->nasabah_id->ReadOnly);

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

			// NoKontrakRefTo
			$this->NoKontrakRefTo->SetDbValueDef($rsnew, $this->NoKontrakRefTo->CurrentValue, NULL, $this->NoKontrakRefTo->ReadOnly);

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

		// NoKontrak
		$this->NoKontrak->SetDbValueDef($rsnew, $this->NoKontrak->CurrentValue, "", FALSE);

		// TglKontrak
		$this->TglKontrak->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->TglKontrak->CurrentValue, 7), ew_CurrentDate(), FALSE);

		// nasabah_id
		$this->nasabah_id->SetDbValueDef($rsnew, $this->nasabah_id->CurrentValue, 0, FALSE);

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
		$this->OtherOptions["addedit"]->UseDropDownButton = FALSE; // jangan gunakan style DropDownButton
		$my_options = &$this->OtherOptions; // pastikan menggunakan area OtherOptions
		$my_option = $my_options["addedit"]; // dekat tombol addedit
		$my_item = &$my_option->Add("mynewbutton"); // tambahkan tombol baru
		$my_item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"Your Title\" data-caption=\"Your Caption\" href=\"yourpage.php\">My New Button @ list</a>"; // definisikan link, style, dan caption tombol
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

// Validate form
ft03_pinjamanlist.Validate = function() {
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
		} // End Grid Add checking
	}
	if (gridinsert && addcnt == 0) { // No row added
		ew_Alert(ewLanguage.Phrase("NoAddRecord"));
		return false;
	}
	return true;
}

// Check empty row
ft03_pinjamanlist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "NoKontrak", false)) return false;
	if (ew_ValueChanged(fobj, infix, "TglKontrak", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nasabah_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Pinjaman", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Denda", false)) return false;
	if (ew_ValueChanged(fobj, infix, "DispensasiDenda", false)) return false;
	if (ew_ValueChanged(fobj, infix, "LamaAngsuran", false)) return false;
	if (ew_ValueChanged(fobj, infix, "JumlahAngsuran", false)) return false;
	if (ew_ValueChanged(fobj, infix, "NoKontrakRefTo", false)) return false;
	return true;
}

// Form_CustomValidate event
ft03_pinjamanlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft03_pinjamanlist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ft03_pinjamanlist.Lists["x_nasabah_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_Customer","x_NoTelpHp","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t01_nasabah"};
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
if ($t03_pinjaman->CurrentAction == "gridadd") {
	$t03_pinjaman->CurrentFilter = "0=1";
	$t03_pinjaman_list->StartRec = 1;
	$t03_pinjaman_list->DisplayRecs = $t03_pinjaman->GridAddRowCount;
	$t03_pinjaman_list->TotalRecs = $t03_pinjaman_list->DisplayRecs;
	$t03_pinjaman_list->StopRec = $t03_pinjaman_list->DisplayRecs;
} else {
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
<form name="ft03_pinjamanlist" id="ft03_pinjamanlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t03_pinjaman_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t03_pinjaman_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t03_pinjaman">
<div id="gmp_t03_pinjaman" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($t03_pinjaman_list->TotalRecs > 0 || $t03_pinjaman->CurrentAction == "add" || $t03_pinjaman->CurrentAction == "copy" || $t03_pinjaman->CurrentAction == "gridedit") { ?>
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
<?php if ($t03_pinjaman->LamaAngsuran->Visible) { // LamaAngsuran ?>
	<?php if ($t03_pinjaman->SortUrl($t03_pinjaman->LamaAngsuran) == "") { ?>
		<th data-name="LamaAngsuran" class="<?php echo $t03_pinjaman->LamaAngsuran->HeaderCellClass() ?>"><div id="elh_t03_pinjaman_LamaAngsuran" class="t03_pinjaman_LamaAngsuran"><div class="ewTableHeaderCaption"><?php echo $t03_pinjaman->LamaAngsuran->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="LamaAngsuran" class="<?php echo $t03_pinjaman->LamaAngsuran->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t03_pinjaman->SortUrl($t03_pinjaman->LamaAngsuran) ?>',2);"><div id="elh_t03_pinjaman_LamaAngsuran" class="t03_pinjaman_LamaAngsuran">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t03_pinjaman->LamaAngsuran->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t03_pinjaman->LamaAngsuran->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t03_pinjaman->LamaAngsuran->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t03_pinjaman->JumlahAngsuran->Visible) { // JumlahAngsuran ?>
	<?php if ($t03_pinjaman->SortUrl($t03_pinjaman->JumlahAngsuran) == "") { ?>
		<th data-name="JumlahAngsuran" class="<?php echo $t03_pinjaman->JumlahAngsuran->HeaderCellClass() ?>"><div id="elh_t03_pinjaman_JumlahAngsuran" class="t03_pinjaman_JumlahAngsuran"><div class="ewTableHeaderCaption"><?php echo $t03_pinjaman->JumlahAngsuran->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="JumlahAngsuran" class="<?php echo $t03_pinjaman->JumlahAngsuran->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t03_pinjaman->SortUrl($t03_pinjaman->JumlahAngsuran) ?>',2);"><div id="elh_t03_pinjaman_JumlahAngsuran" class="t03_pinjaman_JumlahAngsuran">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t03_pinjaman->JumlahAngsuran->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t03_pinjaman->JumlahAngsuran->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t03_pinjaman->JumlahAngsuran->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
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
	if ($t03_pinjaman->CurrentAction == "add" || $t03_pinjaman->CurrentAction == "copy") {
		$t03_pinjaman_list->RowIndex = 0;
		$t03_pinjaman_list->KeyCount = $t03_pinjaman_list->RowIndex;
		if ($t03_pinjaman->CurrentAction == "copy" && !$t03_pinjaman_list->LoadRow())
			$t03_pinjaman->CurrentAction = "add";
		if ($t03_pinjaman->CurrentAction == "add")
			$t03_pinjaman_list->LoadRowValues();
		if ($t03_pinjaman->EventCancelled) // Insert failed
			$t03_pinjaman_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$t03_pinjaman->ResetAttrs();
		$t03_pinjaman->RowAttrs = array_merge($t03_pinjaman->RowAttrs, array('data-rowindex'=>0, 'id'=>'r0_t03_pinjaman', 'data-rowtype'=>EW_ROWTYPE_ADD));
		$t03_pinjaman->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t03_pinjaman_list->RenderRow();

		// Render list options
		$t03_pinjaman_list->RenderListOptions();
		$t03_pinjaman_list->StartRowCnt = 0;
?>
	<tr<?php echo $t03_pinjaman->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t03_pinjaman_list->ListOptions->Render("body", "left", $t03_pinjaman_list->RowCnt);
?>
	<?php if ($t03_pinjaman->NoKontrak->Visible) { // NoKontrak ?>
		<td data-name="NoKontrak">
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_NoKontrak" class="form-group t03_pinjaman_NoKontrak">
<input type="text" data-table="t03_pinjaman" data-field="x_NoKontrak" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_NoKontrak" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_NoKontrak" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->NoKontrak->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->NoKontrak->EditValue ?>"<?php echo $t03_pinjaman->NoKontrak->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_pinjaman" data-field="x_NoKontrak" name="o<?php echo $t03_pinjaman_list->RowIndex ?>_NoKontrak" id="o<?php echo $t03_pinjaman_list->RowIndex ?>_NoKontrak" value="<?php echo ew_HtmlEncode($t03_pinjaman->NoKontrak->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_pinjaman->TglKontrak->Visible) { // TglKontrak ?>
		<td data-name="TglKontrak">
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_TglKontrak" class="form-group t03_pinjaman_TglKontrak">
<input type="text" data-table="t03_pinjaman" data-field="x_TglKontrak" data-format="7" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_TglKontrak" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_TglKontrak" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->TglKontrak->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->TglKontrak->EditValue ?>"<?php echo $t03_pinjaman->TglKontrak->EditAttributes() ?>>
<?php if (!$t03_pinjaman->TglKontrak->ReadOnly && !$t03_pinjaman->TglKontrak->Disabled && !isset($t03_pinjaman->TglKontrak->EditAttrs["readonly"]) && !isset($t03_pinjaman->TglKontrak->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateDateTimePicker("ft03_pinjamanlist", "x<?php echo $t03_pinjaman_list->RowIndex ?>_TglKontrak", {"ignoreReadonly":true,"useCurrent":false,"format":7});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="t03_pinjaman" data-field="x_TglKontrak" name="o<?php echo $t03_pinjaman_list->RowIndex ?>_TglKontrak" id="o<?php echo $t03_pinjaman_list->RowIndex ?>_TglKontrak" value="<?php echo ew_HtmlEncode($t03_pinjaman->TglKontrak->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_pinjaman->nasabah_id->Visible) { // nasabah_id ?>
		<td data-name="nasabah_id">
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_nasabah_id" class="form-group t03_pinjaman_nasabah_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next(":not([disabled])").click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $t03_pinjaman_list->RowIndex ?>_nasabah_id"><?php echo (strval($t03_pinjaman->nasabah_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t03_pinjaman->nasabah_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t03_pinjaman->nasabah_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t03_pinjaman_list->RowIndex ?>_nasabah_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t03_pinjaman->nasabah_id->ReadOnly || $t03_pinjaman->nasabah_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t03_pinjaman" data-field="x_nasabah_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t03_pinjaman->nasabah_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_nasabah_id" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_nasabah_id" value="<?php echo $t03_pinjaman->nasabah_id->CurrentValue ?>"<?php echo $t03_pinjaman->nasabah_id->EditAttributes() ?>>
<?php if (AllowAdd(CurrentProjectID() . "t01_nasabah") && !$t03_pinjaman->nasabah_id->ReadOnly) { ?>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $t03_pinjaman->nasabah_id->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $t03_pinjaman_list->RowIndex ?>_nasabah_id',url:'t01_nasabahaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $t03_pinjaman_list->RowIndex ?>_nasabah_id"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $t03_pinjaman->nasabah_id->FldCaption() ?></span></button>
<?php } ?>
</span>
<input type="hidden" data-table="t03_pinjaman" data-field="x_nasabah_id" name="o<?php echo $t03_pinjaman_list->RowIndex ?>_nasabah_id" id="o<?php echo $t03_pinjaman_list->RowIndex ?>_nasabah_id" value="<?php echo ew_HtmlEncode($t03_pinjaman->nasabah_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_pinjaman->Pinjaman->Visible) { // Pinjaman ?>
		<td data-name="Pinjaman">
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_Pinjaman" class="form-group t03_pinjaman_Pinjaman">
<input type="text" data-table="t03_pinjaman" data-field="x_Pinjaman" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_Pinjaman" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_Pinjaman" size="30" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->Pinjaman->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->Pinjaman->EditValue ?>"<?php echo $t03_pinjaman->Pinjaman->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_pinjaman" data-field="x_Pinjaman" name="o<?php echo $t03_pinjaman_list->RowIndex ?>_Pinjaman" id="o<?php echo $t03_pinjaman_list->RowIndex ?>_Pinjaman" value="<?php echo ew_HtmlEncode($t03_pinjaman->Pinjaman->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_pinjaman->Denda->Visible) { // Denda ?>
		<td data-name="Denda">
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_Denda" class="form-group t03_pinjaman_Denda">
<input type="text" data-table="t03_pinjaman" data-field="x_Denda" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_Denda" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_Denda" size="30" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->Denda->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->Denda->EditValue ?>"<?php echo $t03_pinjaman->Denda->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_pinjaman" data-field="x_Denda" name="o<?php echo $t03_pinjaman_list->RowIndex ?>_Denda" id="o<?php echo $t03_pinjaman_list->RowIndex ?>_Denda" value="<?php echo ew_HtmlEncode($t03_pinjaman->Denda->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_pinjaman->DispensasiDenda->Visible) { // DispensasiDenda ?>
		<td data-name="DispensasiDenda">
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_DispensasiDenda" class="form-group t03_pinjaman_DispensasiDenda">
<input type="text" data-table="t03_pinjaman" data-field="x_DispensasiDenda" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_DispensasiDenda" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_DispensasiDenda" size="30" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->DispensasiDenda->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->DispensasiDenda->EditValue ?>"<?php echo $t03_pinjaman->DispensasiDenda->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_pinjaman" data-field="x_DispensasiDenda" name="o<?php echo $t03_pinjaman_list->RowIndex ?>_DispensasiDenda" id="o<?php echo $t03_pinjaman_list->RowIndex ?>_DispensasiDenda" value="<?php echo ew_HtmlEncode($t03_pinjaman->DispensasiDenda->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_pinjaman->LamaAngsuran->Visible) { // LamaAngsuran ?>
		<td data-name="LamaAngsuran">
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_LamaAngsuran" class="form-group t03_pinjaman_LamaAngsuran">
<input type="text" data-table="t03_pinjaman" data-field="x_LamaAngsuran" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_LamaAngsuran" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_LamaAngsuran" size="30" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->LamaAngsuran->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->LamaAngsuran->EditValue ?>"<?php echo $t03_pinjaman->LamaAngsuran->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_pinjaman" data-field="x_LamaAngsuran" name="o<?php echo $t03_pinjaman_list->RowIndex ?>_LamaAngsuran" id="o<?php echo $t03_pinjaman_list->RowIndex ?>_LamaAngsuran" value="<?php echo ew_HtmlEncode($t03_pinjaman->LamaAngsuran->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_pinjaman->JumlahAngsuran->Visible) { // JumlahAngsuran ?>
		<td data-name="JumlahAngsuran">
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_JumlahAngsuran" class="form-group t03_pinjaman_JumlahAngsuran">
<input type="text" data-table="t03_pinjaman" data-field="x_JumlahAngsuran" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_JumlahAngsuran" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_JumlahAngsuran" size="30" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->JumlahAngsuran->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->JumlahAngsuran->EditValue ?>"<?php echo $t03_pinjaman->JumlahAngsuran->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_pinjaman" data-field="x_JumlahAngsuran" name="o<?php echo $t03_pinjaman_list->RowIndex ?>_JumlahAngsuran" id="o<?php echo $t03_pinjaman_list->RowIndex ?>_JumlahAngsuran" value="<?php echo ew_HtmlEncode($t03_pinjaman->JumlahAngsuran->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_pinjaman->NoKontrakRefTo->Visible) { // NoKontrakRefTo ?>
		<td data-name="NoKontrakRefTo">
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_NoKontrakRefTo" class="form-group t03_pinjaman_NoKontrakRefTo">
<input type="text" data-table="t03_pinjaman" data-field="x_NoKontrakRefTo" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_NoKontrakRefTo" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_NoKontrakRefTo" size="30" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->NoKontrakRefTo->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->NoKontrakRefTo->EditValue ?>"<?php echo $t03_pinjaman->NoKontrakRefTo->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_pinjaman" data-field="x_NoKontrakRefTo" name="o<?php echo $t03_pinjaman_list->RowIndex ?>_NoKontrakRefTo" id="o<?php echo $t03_pinjaman_list->RowIndex ?>_NoKontrakRefTo" value="<?php echo ew_HtmlEncode($t03_pinjaman->NoKontrakRefTo->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t03_pinjaman_list->ListOptions->Render("body", "right", $t03_pinjaman_list->RowCnt);
?>
<script type="text/javascript">
ft03_pinjamanlist.UpdateOpts(<?php echo $t03_pinjaman_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
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

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t03_pinjaman_list->FormKeyCountName) && ($t03_pinjaman->CurrentAction == "gridadd" || $t03_pinjaman->CurrentAction == "gridedit" || $t03_pinjaman->CurrentAction == "F")) {
		$t03_pinjaman_list->KeyCount = $objForm->GetValue($t03_pinjaman_list->FormKeyCountName);
		$t03_pinjaman_list->StopRec = $t03_pinjaman_list->StartRec + $t03_pinjaman_list->KeyCount - 1;
	}
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
$t03_pinjaman_list->EditRowCnt = 0;
if ($t03_pinjaman->CurrentAction == "edit")
	$t03_pinjaman_list->RowIndex = 1;
if ($t03_pinjaman->CurrentAction == "gridadd")
	$t03_pinjaman_list->RowIndex = 0;
if ($t03_pinjaman->CurrentAction == "gridedit")
	$t03_pinjaman_list->RowIndex = 0;
while ($t03_pinjaman_list->RecCnt < $t03_pinjaman_list->StopRec) {
	$t03_pinjaman_list->RecCnt++;
	if (intval($t03_pinjaman_list->RecCnt) >= intval($t03_pinjaman_list->StartRec)) {
		$t03_pinjaman_list->RowCnt++;
		if ($t03_pinjaman->CurrentAction == "gridadd" || $t03_pinjaman->CurrentAction == "gridedit" || $t03_pinjaman->CurrentAction == "F") {
			$t03_pinjaman_list->RowIndex++;
			$objForm->Index = $t03_pinjaman_list->RowIndex;
			if ($objForm->HasValue($t03_pinjaman_list->FormActionName))
				$t03_pinjaman_list->RowAction = strval($objForm->GetValue($t03_pinjaman_list->FormActionName));
			elseif ($t03_pinjaman->CurrentAction == "gridadd")
				$t03_pinjaman_list->RowAction = "insert";
			else
				$t03_pinjaman_list->RowAction = "";
		}

		// Set up key count
		$t03_pinjaman_list->KeyCount = $t03_pinjaman_list->RowIndex;

		// Init row class and style
		$t03_pinjaman->ResetAttrs();
		$t03_pinjaman->CssClass = "";
		if ($t03_pinjaman->CurrentAction == "gridadd") {
			$t03_pinjaman_list->LoadRowValues(); // Load default values
		} else {
			$t03_pinjaman_list->LoadRowValues($t03_pinjaman_list->Recordset); // Load row values
		}
		$t03_pinjaman->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t03_pinjaman->CurrentAction == "gridadd") // Grid add
			$t03_pinjaman->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t03_pinjaman->CurrentAction == "gridadd" && $t03_pinjaman->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t03_pinjaman_list->RestoreCurrentRowFormValues($t03_pinjaman_list->RowIndex); // Restore form values
		if ($t03_pinjaman->CurrentAction == "edit") {
			if ($t03_pinjaman_list->CheckInlineEditKey() && $t03_pinjaman_list->EditRowCnt == 0) { // Inline edit
				$t03_pinjaman->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($t03_pinjaman->CurrentAction == "gridedit") { // Grid edit
			if ($t03_pinjaman->EventCancelled) {
				$t03_pinjaman_list->RestoreCurrentRowFormValues($t03_pinjaman_list->RowIndex); // Restore form values
			}
			if ($t03_pinjaman_list->RowAction == "insert")
				$t03_pinjaman->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t03_pinjaman->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t03_pinjaman->CurrentAction == "edit" && $t03_pinjaman->RowType == EW_ROWTYPE_EDIT && $t03_pinjaman->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$t03_pinjaman_list->RestoreFormValues(); // Restore form values
		}
		if ($t03_pinjaman->CurrentAction == "gridedit" && ($t03_pinjaman->RowType == EW_ROWTYPE_EDIT || $t03_pinjaman->RowType == EW_ROWTYPE_ADD) && $t03_pinjaman->EventCancelled) // Update failed
			$t03_pinjaman_list->RestoreCurrentRowFormValues($t03_pinjaman_list->RowIndex); // Restore form values
		if ($t03_pinjaman->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t03_pinjaman_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$t03_pinjaman->RowAttrs = array_merge($t03_pinjaman->RowAttrs, array('data-rowindex'=>$t03_pinjaman_list->RowCnt, 'id'=>'r' . $t03_pinjaman_list->RowCnt . '_t03_pinjaman', 'data-rowtype'=>$t03_pinjaman->RowType));

		// Render row
		$t03_pinjaman_list->RenderRow();

		// Render list options
		$t03_pinjaman_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t03_pinjaman_list->RowAction <> "delete" && $t03_pinjaman_list->RowAction <> "insertdelete" && !($t03_pinjaman_list->RowAction == "insert" && $t03_pinjaman->CurrentAction == "F" && $t03_pinjaman_list->EmptyRow())) {
?>
	<tr<?php echo $t03_pinjaman->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t03_pinjaman_list->ListOptions->Render("body", "left", $t03_pinjaman_list->RowCnt);
?>
	<?php if ($t03_pinjaman->NoKontrak->Visible) { // NoKontrak ?>
		<td data-name="NoKontrak"<?php echo $t03_pinjaman->NoKontrak->CellAttributes() ?>>
<?php if ($t03_pinjaman->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_NoKontrak" class="form-group t03_pinjaman_NoKontrak">
<input type="text" data-table="t03_pinjaman" data-field="x_NoKontrak" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_NoKontrak" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_NoKontrak" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->NoKontrak->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->NoKontrak->EditValue ?>"<?php echo $t03_pinjaman->NoKontrak->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_pinjaman" data-field="x_NoKontrak" name="o<?php echo $t03_pinjaman_list->RowIndex ?>_NoKontrak" id="o<?php echo $t03_pinjaman_list->RowIndex ?>_NoKontrak" value="<?php echo ew_HtmlEncode($t03_pinjaman->NoKontrak->OldValue) ?>">
<?php } ?>
<?php if ($t03_pinjaman->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_NoKontrak" class="form-group t03_pinjaman_NoKontrak">
<input type="text" data-table="t03_pinjaman" data-field="x_NoKontrak" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_NoKontrak" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_NoKontrak" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->NoKontrak->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->NoKontrak->EditValue ?>"<?php echo $t03_pinjaman->NoKontrak->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t03_pinjaman->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_NoKontrak" class="t03_pinjaman_NoKontrak">
<span<?php echo $t03_pinjaman->NoKontrak->ViewAttributes() ?>>
<?php echo $t03_pinjaman->NoKontrak->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php if ($t03_pinjaman->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t03_pinjaman" data-field="x_id" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_id" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t03_pinjaman->id->CurrentValue) ?>">
<input type="hidden" data-table="t03_pinjaman" data-field="x_id" name="o<?php echo $t03_pinjaman_list->RowIndex ?>_id" id="o<?php echo $t03_pinjaman_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t03_pinjaman->id->OldValue) ?>">
<?php } ?>
<?php if ($t03_pinjaman->RowType == EW_ROWTYPE_EDIT || $t03_pinjaman->CurrentMode == "edit") { ?>
<input type="hidden" data-table="t03_pinjaman" data-field="x_id" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_id" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t03_pinjaman->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($t03_pinjaman->TglKontrak->Visible) { // TglKontrak ?>
		<td data-name="TglKontrak"<?php echo $t03_pinjaman->TglKontrak->CellAttributes() ?>>
<?php if ($t03_pinjaman->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_TglKontrak" class="form-group t03_pinjaman_TglKontrak">
<input type="text" data-table="t03_pinjaman" data-field="x_TglKontrak" data-format="7" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_TglKontrak" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_TglKontrak" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->TglKontrak->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->TglKontrak->EditValue ?>"<?php echo $t03_pinjaman->TglKontrak->EditAttributes() ?>>
<?php if (!$t03_pinjaman->TglKontrak->ReadOnly && !$t03_pinjaman->TglKontrak->Disabled && !isset($t03_pinjaman->TglKontrak->EditAttrs["readonly"]) && !isset($t03_pinjaman->TglKontrak->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateDateTimePicker("ft03_pinjamanlist", "x<?php echo $t03_pinjaman_list->RowIndex ?>_TglKontrak", {"ignoreReadonly":true,"useCurrent":false,"format":7});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="t03_pinjaman" data-field="x_TglKontrak" name="o<?php echo $t03_pinjaman_list->RowIndex ?>_TglKontrak" id="o<?php echo $t03_pinjaman_list->RowIndex ?>_TglKontrak" value="<?php echo ew_HtmlEncode($t03_pinjaman->TglKontrak->OldValue) ?>">
<?php } ?>
<?php if ($t03_pinjaman->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_TglKontrak" class="form-group t03_pinjaman_TglKontrak">
<input type="text" data-table="t03_pinjaman" data-field="x_TglKontrak" data-format="7" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_TglKontrak" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_TglKontrak" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->TglKontrak->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->TglKontrak->EditValue ?>"<?php echo $t03_pinjaman->TglKontrak->EditAttributes() ?>>
<?php if (!$t03_pinjaman->TglKontrak->ReadOnly && !$t03_pinjaman->TglKontrak->Disabled && !isset($t03_pinjaman->TglKontrak->EditAttrs["readonly"]) && !isset($t03_pinjaman->TglKontrak->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateDateTimePicker("ft03_pinjamanlist", "x<?php echo $t03_pinjaman_list->RowIndex ?>_TglKontrak", {"ignoreReadonly":true,"useCurrent":false,"format":7});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($t03_pinjaman->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_TglKontrak" class="t03_pinjaman_TglKontrak">
<span<?php echo $t03_pinjaman->TglKontrak->ViewAttributes() ?>>
<?php echo $t03_pinjaman->TglKontrak->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t03_pinjaman->nasabah_id->Visible) { // nasabah_id ?>
		<td data-name="nasabah_id"<?php echo $t03_pinjaman->nasabah_id->CellAttributes() ?>>
<?php if ($t03_pinjaman->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_nasabah_id" class="form-group t03_pinjaman_nasabah_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next(":not([disabled])").click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $t03_pinjaman_list->RowIndex ?>_nasabah_id"><?php echo (strval($t03_pinjaman->nasabah_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t03_pinjaman->nasabah_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t03_pinjaman->nasabah_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t03_pinjaman_list->RowIndex ?>_nasabah_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t03_pinjaman->nasabah_id->ReadOnly || $t03_pinjaman->nasabah_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t03_pinjaman" data-field="x_nasabah_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t03_pinjaman->nasabah_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_nasabah_id" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_nasabah_id" value="<?php echo $t03_pinjaman->nasabah_id->CurrentValue ?>"<?php echo $t03_pinjaman->nasabah_id->EditAttributes() ?>>
<?php if (AllowAdd(CurrentProjectID() . "t01_nasabah") && !$t03_pinjaman->nasabah_id->ReadOnly) { ?>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $t03_pinjaman->nasabah_id->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $t03_pinjaman_list->RowIndex ?>_nasabah_id',url:'t01_nasabahaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $t03_pinjaman_list->RowIndex ?>_nasabah_id"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $t03_pinjaman->nasabah_id->FldCaption() ?></span></button>
<?php } ?>
</span>
<input type="hidden" data-table="t03_pinjaman" data-field="x_nasabah_id" name="o<?php echo $t03_pinjaman_list->RowIndex ?>_nasabah_id" id="o<?php echo $t03_pinjaman_list->RowIndex ?>_nasabah_id" value="<?php echo ew_HtmlEncode($t03_pinjaman->nasabah_id->OldValue) ?>">
<?php } ?>
<?php if ($t03_pinjaman->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_nasabah_id" class="form-group t03_pinjaman_nasabah_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next(":not([disabled])").click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $t03_pinjaman_list->RowIndex ?>_nasabah_id"><?php echo (strval($t03_pinjaman->nasabah_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t03_pinjaman->nasabah_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t03_pinjaman->nasabah_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t03_pinjaman_list->RowIndex ?>_nasabah_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t03_pinjaman->nasabah_id->ReadOnly || $t03_pinjaman->nasabah_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t03_pinjaman" data-field="x_nasabah_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t03_pinjaman->nasabah_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_nasabah_id" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_nasabah_id" value="<?php echo $t03_pinjaman->nasabah_id->CurrentValue ?>"<?php echo $t03_pinjaman->nasabah_id->EditAttributes() ?>>
<?php if (AllowAdd(CurrentProjectID() . "t01_nasabah") && !$t03_pinjaman->nasabah_id->ReadOnly) { ?>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $t03_pinjaman->nasabah_id->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $t03_pinjaman_list->RowIndex ?>_nasabah_id',url:'t01_nasabahaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $t03_pinjaman_list->RowIndex ?>_nasabah_id"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $t03_pinjaman->nasabah_id->FldCaption() ?></span></button>
<?php } ?>
</span>
<?php } ?>
<?php if ($t03_pinjaman->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_nasabah_id" class="t03_pinjaman_nasabah_id">
<span<?php echo $t03_pinjaman->nasabah_id->ViewAttributes() ?>>
<?php echo $t03_pinjaman->nasabah_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t03_pinjaman->Pinjaman->Visible) { // Pinjaman ?>
		<td data-name="Pinjaman"<?php echo $t03_pinjaman->Pinjaman->CellAttributes() ?>>
<?php if ($t03_pinjaman->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_Pinjaman" class="form-group t03_pinjaman_Pinjaman">
<input type="text" data-table="t03_pinjaman" data-field="x_Pinjaman" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_Pinjaman" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_Pinjaman" size="30" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->Pinjaman->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->Pinjaman->EditValue ?>"<?php echo $t03_pinjaman->Pinjaman->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_pinjaman" data-field="x_Pinjaman" name="o<?php echo $t03_pinjaman_list->RowIndex ?>_Pinjaman" id="o<?php echo $t03_pinjaman_list->RowIndex ?>_Pinjaman" value="<?php echo ew_HtmlEncode($t03_pinjaman->Pinjaman->OldValue) ?>">
<?php } ?>
<?php if ($t03_pinjaman->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_Pinjaman" class="form-group t03_pinjaman_Pinjaman">
<input type="text" data-table="t03_pinjaman" data-field="x_Pinjaman" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_Pinjaman" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_Pinjaman" size="30" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->Pinjaman->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->Pinjaman->EditValue ?>"<?php echo $t03_pinjaman->Pinjaman->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t03_pinjaman->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_Pinjaman" class="t03_pinjaman_Pinjaman">
<span<?php echo $t03_pinjaman->Pinjaman->ViewAttributes() ?>>
<?php echo $t03_pinjaman->Pinjaman->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t03_pinjaman->Denda->Visible) { // Denda ?>
		<td data-name="Denda"<?php echo $t03_pinjaman->Denda->CellAttributes() ?>>
<?php if ($t03_pinjaman->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_Denda" class="form-group t03_pinjaman_Denda">
<input type="text" data-table="t03_pinjaman" data-field="x_Denda" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_Denda" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_Denda" size="30" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->Denda->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->Denda->EditValue ?>"<?php echo $t03_pinjaman->Denda->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_pinjaman" data-field="x_Denda" name="o<?php echo $t03_pinjaman_list->RowIndex ?>_Denda" id="o<?php echo $t03_pinjaman_list->RowIndex ?>_Denda" value="<?php echo ew_HtmlEncode($t03_pinjaman->Denda->OldValue) ?>">
<?php } ?>
<?php if ($t03_pinjaman->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_Denda" class="form-group t03_pinjaman_Denda">
<input type="text" data-table="t03_pinjaman" data-field="x_Denda" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_Denda" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_Denda" size="30" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->Denda->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->Denda->EditValue ?>"<?php echo $t03_pinjaman->Denda->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t03_pinjaman->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_Denda" class="t03_pinjaman_Denda">
<span<?php echo $t03_pinjaman->Denda->ViewAttributes() ?>>
<?php echo $t03_pinjaman->Denda->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t03_pinjaman->DispensasiDenda->Visible) { // DispensasiDenda ?>
		<td data-name="DispensasiDenda"<?php echo $t03_pinjaman->DispensasiDenda->CellAttributes() ?>>
<?php if ($t03_pinjaman->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_DispensasiDenda" class="form-group t03_pinjaman_DispensasiDenda">
<input type="text" data-table="t03_pinjaman" data-field="x_DispensasiDenda" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_DispensasiDenda" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_DispensasiDenda" size="30" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->DispensasiDenda->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->DispensasiDenda->EditValue ?>"<?php echo $t03_pinjaman->DispensasiDenda->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_pinjaman" data-field="x_DispensasiDenda" name="o<?php echo $t03_pinjaman_list->RowIndex ?>_DispensasiDenda" id="o<?php echo $t03_pinjaman_list->RowIndex ?>_DispensasiDenda" value="<?php echo ew_HtmlEncode($t03_pinjaman->DispensasiDenda->OldValue) ?>">
<?php } ?>
<?php if ($t03_pinjaman->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_DispensasiDenda" class="form-group t03_pinjaman_DispensasiDenda">
<input type="text" data-table="t03_pinjaman" data-field="x_DispensasiDenda" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_DispensasiDenda" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_DispensasiDenda" size="30" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->DispensasiDenda->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->DispensasiDenda->EditValue ?>"<?php echo $t03_pinjaman->DispensasiDenda->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t03_pinjaman->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_DispensasiDenda" class="t03_pinjaman_DispensasiDenda">
<span<?php echo $t03_pinjaman->DispensasiDenda->ViewAttributes() ?>>
<?php echo $t03_pinjaman->DispensasiDenda->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t03_pinjaman->LamaAngsuran->Visible) { // LamaAngsuran ?>
		<td data-name="LamaAngsuran"<?php echo $t03_pinjaman->LamaAngsuran->CellAttributes() ?>>
<?php if ($t03_pinjaman->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_LamaAngsuran" class="form-group t03_pinjaman_LamaAngsuran">
<input type="text" data-table="t03_pinjaman" data-field="x_LamaAngsuran" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_LamaAngsuran" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_LamaAngsuran" size="30" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->LamaAngsuran->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->LamaAngsuran->EditValue ?>"<?php echo $t03_pinjaman->LamaAngsuran->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_pinjaman" data-field="x_LamaAngsuran" name="o<?php echo $t03_pinjaman_list->RowIndex ?>_LamaAngsuran" id="o<?php echo $t03_pinjaman_list->RowIndex ?>_LamaAngsuran" value="<?php echo ew_HtmlEncode($t03_pinjaman->LamaAngsuran->OldValue) ?>">
<?php } ?>
<?php if ($t03_pinjaman->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_LamaAngsuran" class="form-group t03_pinjaman_LamaAngsuran">
<input type="text" data-table="t03_pinjaman" data-field="x_LamaAngsuran" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_LamaAngsuran" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_LamaAngsuran" size="30" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->LamaAngsuran->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->LamaAngsuran->EditValue ?>"<?php echo $t03_pinjaman->LamaAngsuran->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t03_pinjaman->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_LamaAngsuran" class="t03_pinjaman_LamaAngsuran">
<span<?php echo $t03_pinjaman->LamaAngsuran->ViewAttributes() ?>>
<?php echo $t03_pinjaman->LamaAngsuran->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t03_pinjaman->JumlahAngsuran->Visible) { // JumlahAngsuran ?>
		<td data-name="JumlahAngsuran"<?php echo $t03_pinjaman->JumlahAngsuran->CellAttributes() ?>>
<?php if ($t03_pinjaman->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_JumlahAngsuran" class="form-group t03_pinjaman_JumlahAngsuran">
<input type="text" data-table="t03_pinjaman" data-field="x_JumlahAngsuran" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_JumlahAngsuran" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_JumlahAngsuran" size="30" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->JumlahAngsuran->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->JumlahAngsuran->EditValue ?>"<?php echo $t03_pinjaman->JumlahAngsuran->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_pinjaman" data-field="x_JumlahAngsuran" name="o<?php echo $t03_pinjaman_list->RowIndex ?>_JumlahAngsuran" id="o<?php echo $t03_pinjaman_list->RowIndex ?>_JumlahAngsuran" value="<?php echo ew_HtmlEncode($t03_pinjaman->JumlahAngsuran->OldValue) ?>">
<?php } ?>
<?php if ($t03_pinjaman->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_JumlahAngsuran" class="form-group t03_pinjaman_JumlahAngsuran">
<input type="text" data-table="t03_pinjaman" data-field="x_JumlahAngsuran" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_JumlahAngsuran" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_JumlahAngsuran" size="30" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->JumlahAngsuran->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->JumlahAngsuran->EditValue ?>"<?php echo $t03_pinjaman->JumlahAngsuran->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t03_pinjaman->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_JumlahAngsuran" class="t03_pinjaman_JumlahAngsuran">
<span<?php echo $t03_pinjaman->JumlahAngsuran->ViewAttributes() ?>>
<?php echo $t03_pinjaman->JumlahAngsuran->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t03_pinjaman->NoKontrakRefTo->Visible) { // NoKontrakRefTo ?>
		<td data-name="NoKontrakRefTo"<?php echo $t03_pinjaman->NoKontrakRefTo->CellAttributes() ?>>
<?php if ($t03_pinjaman->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_NoKontrakRefTo" class="form-group t03_pinjaman_NoKontrakRefTo">
<input type="text" data-table="t03_pinjaman" data-field="x_NoKontrakRefTo" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_NoKontrakRefTo" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_NoKontrakRefTo" size="30" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->NoKontrakRefTo->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->NoKontrakRefTo->EditValue ?>"<?php echo $t03_pinjaman->NoKontrakRefTo->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_pinjaman" data-field="x_NoKontrakRefTo" name="o<?php echo $t03_pinjaman_list->RowIndex ?>_NoKontrakRefTo" id="o<?php echo $t03_pinjaman_list->RowIndex ?>_NoKontrakRefTo" value="<?php echo ew_HtmlEncode($t03_pinjaman->NoKontrakRefTo->OldValue) ?>">
<?php } ?>
<?php if ($t03_pinjaman->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_NoKontrakRefTo" class="form-group t03_pinjaman_NoKontrakRefTo">
<input type="text" data-table="t03_pinjaman" data-field="x_NoKontrakRefTo" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_NoKontrakRefTo" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_NoKontrakRefTo" size="30" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->NoKontrakRefTo->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->NoKontrakRefTo->EditValue ?>"<?php echo $t03_pinjaman->NoKontrakRefTo->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t03_pinjaman->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t03_pinjaman_list->RowCnt ?>_t03_pinjaman_NoKontrakRefTo" class="t03_pinjaman_NoKontrakRefTo">
<span<?php echo $t03_pinjaman->NoKontrakRefTo->ViewAttributes() ?>>
<?php echo $t03_pinjaman->NoKontrakRefTo->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t03_pinjaman_list->ListOptions->Render("body", "right", $t03_pinjaman_list->RowCnt);
?>
	</tr>
<?php if ($t03_pinjaman->RowType == EW_ROWTYPE_ADD || $t03_pinjaman->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft03_pinjamanlist.UpdateOpts(<?php echo $t03_pinjaman_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t03_pinjaman->CurrentAction <> "gridadd")
		if (!$t03_pinjaman_list->Recordset->EOF) $t03_pinjaman_list->Recordset->MoveNext();
}
?>
<?php
	if ($t03_pinjaman->CurrentAction == "gridadd" || $t03_pinjaman->CurrentAction == "gridedit") {
		$t03_pinjaman_list->RowIndex = '$rowindex$';
		$t03_pinjaman_list->LoadRowValues();

		// Set row properties
		$t03_pinjaman->ResetAttrs();
		$t03_pinjaman->RowAttrs = array_merge($t03_pinjaman->RowAttrs, array('data-rowindex'=>$t03_pinjaman_list->RowIndex, 'id'=>'r0_t03_pinjaman', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t03_pinjaman->RowAttrs["class"], "ewTemplate");
		$t03_pinjaman->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t03_pinjaman_list->RenderRow();

		// Render list options
		$t03_pinjaman_list->RenderListOptions();
		$t03_pinjaman_list->StartRowCnt = 0;
?>
	<tr<?php echo $t03_pinjaman->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t03_pinjaman_list->ListOptions->Render("body", "left", $t03_pinjaman_list->RowIndex);
?>
	<?php if ($t03_pinjaman->NoKontrak->Visible) { // NoKontrak ?>
		<td data-name="NoKontrak">
<span id="el$rowindex$_t03_pinjaman_NoKontrak" class="form-group t03_pinjaman_NoKontrak">
<input type="text" data-table="t03_pinjaman" data-field="x_NoKontrak" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_NoKontrak" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_NoKontrak" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->NoKontrak->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->NoKontrak->EditValue ?>"<?php echo $t03_pinjaman->NoKontrak->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_pinjaman" data-field="x_NoKontrak" name="o<?php echo $t03_pinjaman_list->RowIndex ?>_NoKontrak" id="o<?php echo $t03_pinjaman_list->RowIndex ?>_NoKontrak" value="<?php echo ew_HtmlEncode($t03_pinjaman->NoKontrak->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_pinjaman->TglKontrak->Visible) { // TglKontrak ?>
		<td data-name="TglKontrak">
<span id="el$rowindex$_t03_pinjaman_TglKontrak" class="form-group t03_pinjaman_TglKontrak">
<input type="text" data-table="t03_pinjaman" data-field="x_TglKontrak" data-format="7" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_TglKontrak" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_TglKontrak" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->TglKontrak->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->TglKontrak->EditValue ?>"<?php echo $t03_pinjaman->TglKontrak->EditAttributes() ?>>
<?php if (!$t03_pinjaman->TglKontrak->ReadOnly && !$t03_pinjaman->TglKontrak->Disabled && !isset($t03_pinjaman->TglKontrak->EditAttrs["readonly"]) && !isset($t03_pinjaman->TglKontrak->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateDateTimePicker("ft03_pinjamanlist", "x<?php echo $t03_pinjaman_list->RowIndex ?>_TglKontrak", {"ignoreReadonly":true,"useCurrent":false,"format":7});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="t03_pinjaman" data-field="x_TglKontrak" name="o<?php echo $t03_pinjaman_list->RowIndex ?>_TglKontrak" id="o<?php echo $t03_pinjaman_list->RowIndex ?>_TglKontrak" value="<?php echo ew_HtmlEncode($t03_pinjaman->TglKontrak->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_pinjaman->nasabah_id->Visible) { // nasabah_id ?>
		<td data-name="nasabah_id">
<span id="el$rowindex$_t03_pinjaman_nasabah_id" class="form-group t03_pinjaman_nasabah_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next(":not([disabled])").click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $t03_pinjaman_list->RowIndex ?>_nasabah_id"><?php echo (strval($t03_pinjaman->nasabah_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t03_pinjaman->nasabah_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t03_pinjaman->nasabah_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t03_pinjaman_list->RowIndex ?>_nasabah_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t03_pinjaman->nasabah_id->ReadOnly || $t03_pinjaman->nasabah_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t03_pinjaman" data-field="x_nasabah_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t03_pinjaman->nasabah_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_nasabah_id" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_nasabah_id" value="<?php echo $t03_pinjaman->nasabah_id->CurrentValue ?>"<?php echo $t03_pinjaman->nasabah_id->EditAttributes() ?>>
<?php if (AllowAdd(CurrentProjectID() . "t01_nasabah") && !$t03_pinjaman->nasabah_id->ReadOnly) { ?>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $t03_pinjaman->nasabah_id->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $t03_pinjaman_list->RowIndex ?>_nasabah_id',url:'t01_nasabahaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $t03_pinjaman_list->RowIndex ?>_nasabah_id"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $t03_pinjaman->nasabah_id->FldCaption() ?></span></button>
<?php } ?>
</span>
<input type="hidden" data-table="t03_pinjaman" data-field="x_nasabah_id" name="o<?php echo $t03_pinjaman_list->RowIndex ?>_nasabah_id" id="o<?php echo $t03_pinjaman_list->RowIndex ?>_nasabah_id" value="<?php echo ew_HtmlEncode($t03_pinjaman->nasabah_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_pinjaman->Pinjaman->Visible) { // Pinjaman ?>
		<td data-name="Pinjaman">
<span id="el$rowindex$_t03_pinjaman_Pinjaman" class="form-group t03_pinjaman_Pinjaman">
<input type="text" data-table="t03_pinjaman" data-field="x_Pinjaman" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_Pinjaman" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_Pinjaman" size="30" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->Pinjaman->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->Pinjaman->EditValue ?>"<?php echo $t03_pinjaman->Pinjaman->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_pinjaman" data-field="x_Pinjaman" name="o<?php echo $t03_pinjaman_list->RowIndex ?>_Pinjaman" id="o<?php echo $t03_pinjaman_list->RowIndex ?>_Pinjaman" value="<?php echo ew_HtmlEncode($t03_pinjaman->Pinjaman->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_pinjaman->Denda->Visible) { // Denda ?>
		<td data-name="Denda">
<span id="el$rowindex$_t03_pinjaman_Denda" class="form-group t03_pinjaman_Denda">
<input type="text" data-table="t03_pinjaman" data-field="x_Denda" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_Denda" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_Denda" size="30" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->Denda->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->Denda->EditValue ?>"<?php echo $t03_pinjaman->Denda->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_pinjaman" data-field="x_Denda" name="o<?php echo $t03_pinjaman_list->RowIndex ?>_Denda" id="o<?php echo $t03_pinjaman_list->RowIndex ?>_Denda" value="<?php echo ew_HtmlEncode($t03_pinjaman->Denda->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_pinjaman->DispensasiDenda->Visible) { // DispensasiDenda ?>
		<td data-name="DispensasiDenda">
<span id="el$rowindex$_t03_pinjaman_DispensasiDenda" class="form-group t03_pinjaman_DispensasiDenda">
<input type="text" data-table="t03_pinjaman" data-field="x_DispensasiDenda" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_DispensasiDenda" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_DispensasiDenda" size="30" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->DispensasiDenda->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->DispensasiDenda->EditValue ?>"<?php echo $t03_pinjaman->DispensasiDenda->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_pinjaman" data-field="x_DispensasiDenda" name="o<?php echo $t03_pinjaman_list->RowIndex ?>_DispensasiDenda" id="o<?php echo $t03_pinjaman_list->RowIndex ?>_DispensasiDenda" value="<?php echo ew_HtmlEncode($t03_pinjaman->DispensasiDenda->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_pinjaman->LamaAngsuran->Visible) { // LamaAngsuran ?>
		<td data-name="LamaAngsuran">
<span id="el$rowindex$_t03_pinjaman_LamaAngsuran" class="form-group t03_pinjaman_LamaAngsuran">
<input type="text" data-table="t03_pinjaman" data-field="x_LamaAngsuran" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_LamaAngsuran" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_LamaAngsuran" size="30" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->LamaAngsuran->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->LamaAngsuran->EditValue ?>"<?php echo $t03_pinjaman->LamaAngsuran->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_pinjaman" data-field="x_LamaAngsuran" name="o<?php echo $t03_pinjaman_list->RowIndex ?>_LamaAngsuran" id="o<?php echo $t03_pinjaman_list->RowIndex ?>_LamaAngsuran" value="<?php echo ew_HtmlEncode($t03_pinjaman->LamaAngsuran->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_pinjaman->JumlahAngsuran->Visible) { // JumlahAngsuran ?>
		<td data-name="JumlahAngsuran">
<span id="el$rowindex$_t03_pinjaman_JumlahAngsuran" class="form-group t03_pinjaman_JumlahAngsuran">
<input type="text" data-table="t03_pinjaman" data-field="x_JumlahAngsuran" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_JumlahAngsuran" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_JumlahAngsuran" size="30" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->JumlahAngsuran->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->JumlahAngsuran->EditValue ?>"<?php echo $t03_pinjaman->JumlahAngsuran->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_pinjaman" data-field="x_JumlahAngsuran" name="o<?php echo $t03_pinjaman_list->RowIndex ?>_JumlahAngsuran" id="o<?php echo $t03_pinjaman_list->RowIndex ?>_JumlahAngsuran" value="<?php echo ew_HtmlEncode($t03_pinjaman->JumlahAngsuran->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_pinjaman->NoKontrakRefTo->Visible) { // NoKontrakRefTo ?>
		<td data-name="NoKontrakRefTo">
<span id="el$rowindex$_t03_pinjaman_NoKontrakRefTo" class="form-group t03_pinjaman_NoKontrakRefTo">
<input type="text" data-table="t03_pinjaman" data-field="x_NoKontrakRefTo" name="x<?php echo $t03_pinjaman_list->RowIndex ?>_NoKontrakRefTo" id="x<?php echo $t03_pinjaman_list->RowIndex ?>_NoKontrakRefTo" size="30" placeholder="<?php echo ew_HtmlEncode($t03_pinjaman->NoKontrakRefTo->getPlaceHolder()) ?>" value="<?php echo $t03_pinjaman->NoKontrakRefTo->EditValue ?>"<?php echo $t03_pinjaman->NoKontrakRefTo->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_pinjaman" data-field="x_NoKontrakRefTo" name="o<?php echo $t03_pinjaman_list->RowIndex ?>_NoKontrakRefTo" id="o<?php echo $t03_pinjaman_list->RowIndex ?>_NoKontrakRefTo" value="<?php echo ew_HtmlEncode($t03_pinjaman->NoKontrakRefTo->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t03_pinjaman_list->ListOptions->Render("body", "right", $t03_pinjaman_list->RowIndex);
?>
<script type="text/javascript">
ft03_pinjamanlist.UpdateOpts(<?php echo $t03_pinjaman_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($t03_pinjaman->CurrentAction == "add" || $t03_pinjaman->CurrentAction == "copy") { ?>
<input type="hidden" name="<?php echo $t03_pinjaman_list->FormKeyCountName ?>" id="<?php echo $t03_pinjaman_list->FormKeyCountName ?>" value="<?php echo $t03_pinjaman_list->KeyCount ?>">
<?php } ?>
<?php if ($t03_pinjaman->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t03_pinjaman_list->FormKeyCountName ?>" id="<?php echo $t03_pinjaman_list->FormKeyCountName ?>" value="<?php echo $t03_pinjaman_list->KeyCount ?>">
<?php echo $t03_pinjaman_list->MultiSelectKey ?>
<?php } ?>
<?php if ($t03_pinjaman->CurrentAction == "edit") { ?>
<input type="hidden" name="<?php echo $t03_pinjaman_list->FormKeyCountName ?>" id="<?php echo $t03_pinjaman_list->FormKeyCountName ?>" value="<?php echo $t03_pinjaman_list->KeyCount ?>">
<?php } ?>
<?php if ($t03_pinjaman->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t03_pinjaman_list->FormKeyCountName ?>" id="<?php echo $t03_pinjaman_list->FormKeyCountName ?>" value="<?php echo $t03_pinjaman_list->KeyCount ?>">
<?php echo $t03_pinjaman_list->MultiSelectKey ?>
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
