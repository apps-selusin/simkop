<?php include_once "t04_angsuraninfo.php" ?>
<?php include_once "t96_employeesinfo.php" ?>
<?php

//
// Page class
//

$t04_angsuran_grid = NULL; // Initialize page object first

class ct04_angsuran_grid extends ct04_angsuran {

	// Page ID
	var $PageID = 'gridcls';

	// Project ID
	var $ProjectID = '{B3698D9B-8D4B-412E-A2E5-AFAD2FEE5A23}';

	// Table name
	var $TableName = 't04_angsuran';

	// Page object name
	var $PageObjName = 't04_angsuran_grid';

	// Grid form hidden field names
	var $FormName = 'ft04_angsurangrid';
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
		$this->FormActionName .= '_' . $this->FormName;
		$this->FormKeyName .= '_' . $this->FormName;
		$this->FormOldKeyName .= '_' . $this->FormName;
		$this->FormBlankRowName .= '_' . $this->FormName;
		$this->FormKeyCountName .= '_' . $this->FormName;
		$GLOBALS["Grid"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (t04_angsuran)
		if (!isset($GLOBALS["t04_angsuran"]) || get_class($GLOBALS["t04_angsuran"]) == "ct04_angsuran") {
			$GLOBALS["t04_angsuran"] = &$this;

//			$GLOBALS["MasterTable"] = &$GLOBALS["Table"];
//			if (!isset($GLOBALS["Table"])) $GLOBALS["Table"] = &$GLOBALS["t04_angsuran"];

		}
		$this->AddUrl = "t04_angsuranadd.php";

		// Table object (t96_employees)
		if (!isset($GLOBALS['t96_employees'])) $GLOBALS['t96_employees'] = new ct96_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'gridcls', TRUE);

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

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
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
		// Get grid add count

		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();
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
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

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

//		$GLOBALS["Table"] = &$GLOBALS["MasterTable"];
		unset($GLOBALS["Grid"]);
		if ($url == "")
			return;
		$this->Page_Redirecting($url);

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
	var $ShowOtherOptions = FALSE;
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

			// Set up records per page
			$this->SetupDisplayRecs();

			// Handle reset command
			$this->ResetCmd();

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

			// Show grid delete link for grid add / grid edit
			if ($this->AllowAddDeleteRow) {
				if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
					$item = $this->ListOptions->GetItem("griddelete");
					if ($item) $item->Visible = TRUE;
				}
			}

			// Set up sorting order
			$this->SetupSortOrder();
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
		$this->AngsuranPokok->FormValue = ""; // Clear form value
		$this->AngsuranBunga->FormValue = ""; // Clear form value
		$this->AngsuranTotal->FormValue = ""; // Clear form value
		$this->SisaHutang->FormValue = ""; // Clear form value
		$this->TotalDenda->FormValue = ""; // Clear form value
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

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Updated event
			$this->Grid_Updated($rsold, $rsnew);
			if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateSuccess")); // Batch update success
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
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
			if ($rowaction == "insert") {
				$this->RowOldKey = strval($objForm->GetValue($this->FormOldKeyName));
				$this->LoadOldRecord(); // Load old record
			}
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
			$this->ClearInlineMode(); // Clear grid add mode and return
			return TRUE;
		}
		if ($bGridInsert) {

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
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
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
		if ($objForm->HasValue("x_AngsuranKe") && $objForm->HasValue("o_AngsuranKe") && $this->AngsuranKe->CurrentValue <> $this->AngsuranKe->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_AngsuranTanggal") && $objForm->HasValue("o_AngsuranTanggal") && $this->AngsuranTanggal->CurrentValue <> $this->AngsuranTanggal->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_AngsuranPokok") && $objForm->HasValue("o_AngsuranPokok") && $this->AngsuranPokok->CurrentValue <> $this->AngsuranPokok->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_AngsuranBunga") && $objForm->HasValue("o_AngsuranBunga") && $this->AngsuranBunga->CurrentValue <> $this->AngsuranBunga->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_AngsuranTotal") && $objForm->HasValue("o_AngsuranTotal") && $this->AngsuranTotal->CurrentValue <> $this->AngsuranTotal->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_SisaHutang") && $objForm->HasValue("o_SisaHutang") && $this->SisaHutang->CurrentValue <> $this->SisaHutang->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_TanggalBayar") && $objForm->HasValue("o_TanggalBayar") && $this->TanggalBayar->CurrentValue <> $this->TanggalBayar->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_TotalDenda") && $objForm->HasValue("o_TotalDenda") && $this->TotalDenda->CurrentValue <> $this->TotalDenda->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Terlambat") && $objForm->HasValue("o_Terlambat") && $this->Terlambat->CurrentValue <> $this->Terlambat->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Keterangan") && $objForm->HasValue("o_Keterangan") && $this->Keterangan->CurrentValue <> $this->Keterangan->OldValue)
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

	// Set up sort parameters
	function SetupSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = @$_GET["order"];
			$this->CurrentOrderType = @$_GET["ordertype"];
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
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode <> "view") {
			$objForm->Index = $this->RowIndex;
			$ActionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$OldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$KeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$BlankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $ActionName . "\" id=\"" . $ActionName . "\" value=\"" . $this->RowAction . "\">";
			if ($objForm->HasValue($this->FormOldKeyName))
				$this->RowOldKey = strval($objForm->GetValue($this->FormOldKeyName));
			if ($this->RowOldKey <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $OldKeyName . "\" id=\"" . $OldKeyName . "\" value=\"" . ew_HtmlEncode($this->RowOldKey) . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue($this->FormKeyName);
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $BlankRowName . "\" id=\"" . $BlankRowName . "\" value=\"1\">";
		}

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") {
				$option = &$this->ListOptions;
				$option->UseButtonGroup = TRUE; // Use button group for grid delete button
				$option->UseImageAndText = TRUE; // Use image and text for grid delete button
				$oListOpt = &$option->Items["griddelete"];
				if (is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
					$oListOpt->Body = "&nbsp;";
				} else {
					$oListOpt->Body = "<a class=\"ewGridLink ewGridDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" onclick=\"return ew_DeleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->Phrase("DeleteLink") . "</a>";
				}
			}
		}

		// "sequence"
		$oListOpt = &$this->ListOptions->Items["sequence"];
		$oListOpt->Body = ew_FormatSeqNo($this->RecCnt);
		if ($this->CurrentMode == "view") { // View mode
		} // End View mode
		if ($this->CurrentMode == "edit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->id->CurrentValue . "\">";
		}
		$this->RenderListOptionsExt();
	}

	// Set record key
	function SetRecordKey(&$key, $rs) {
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs->fields('id');
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$option = &$this->OtherOptions["addedit"];
		$option->UseDropDownButton = FALSE;
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$option->UseButtonGroup = TRUE;
		$option->ButtonClass = "btn-sm"; // Class for button group
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		if (($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") && $this->CurrentAction != "F") { // Check add/copy/edit mode
			if ($this->AllowAddDeleteRow) {
				$option = &$options["addedit"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;
				$item = &$option->Add("addblankrow");
				$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
				$item->Visible = FALSE;
				$this->ShowOtherOptions = $item->Visible;
			}
		}
		if ($this->CurrentMode == "view") { // Check view mode
			$option = &$options["addedit"];
			$item = &$option->GetItem("add");
			$this->ShowOtherOptions = $item && $item->Visible;
		}
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
		$this->AngsuranKe->CurrentValue = NULL;
		$this->AngsuranKe->OldValue = $this->AngsuranKe->CurrentValue;
		$this->AngsuranTanggal->CurrentValue = NULL;
		$this->AngsuranTanggal->OldValue = $this->AngsuranTanggal->CurrentValue;
		$this->AngsuranPokok->CurrentValue = NULL;
		$this->AngsuranPokok->OldValue = $this->AngsuranPokok->CurrentValue;
		$this->AngsuranBunga->CurrentValue = NULL;
		$this->AngsuranBunga->OldValue = $this->AngsuranBunga->CurrentValue;
		$this->AngsuranTotal->CurrentValue = NULL;
		$this->AngsuranTotal->OldValue = $this->AngsuranTotal->CurrentValue;
		$this->SisaHutang->CurrentValue = NULL;
		$this->SisaHutang->OldValue = $this->SisaHutang->CurrentValue;
		$this->TanggalBayar->CurrentValue = NULL;
		$this->TanggalBayar->OldValue = $this->TanggalBayar->CurrentValue;
		$this->TotalDenda->CurrentValue = NULL;
		$this->TotalDenda->OldValue = $this->TotalDenda->CurrentValue;
		$this->Terlambat->CurrentValue = NULL;
		$this->Terlambat->OldValue = $this->Terlambat->CurrentValue;
		$this->Keterangan->CurrentValue = NULL;
		$this->Keterangan->OldValue = $this->Keterangan->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$objForm->FormName = $this->FormName;
		if (!$this->AngsuranKe->FldIsDetailKey) {
			$this->AngsuranKe->setFormValue($objForm->GetValue("x_AngsuranKe"));
		}
		$this->AngsuranKe->setOldValue($objForm->GetValue("o_AngsuranKe"));
		if (!$this->AngsuranTanggal->FldIsDetailKey) {
			$this->AngsuranTanggal->setFormValue($objForm->GetValue("x_AngsuranTanggal"));
			$this->AngsuranTanggal->CurrentValue = ew_UnFormatDateTime($this->AngsuranTanggal->CurrentValue, 7);
		}
		$this->AngsuranTanggal->setOldValue($objForm->GetValue("o_AngsuranTanggal"));
		if (!$this->AngsuranPokok->FldIsDetailKey) {
			$this->AngsuranPokok->setFormValue($objForm->GetValue("x_AngsuranPokok"));
		}
		$this->AngsuranPokok->setOldValue($objForm->GetValue("o_AngsuranPokok"));
		if (!$this->AngsuranBunga->FldIsDetailKey) {
			$this->AngsuranBunga->setFormValue($objForm->GetValue("x_AngsuranBunga"));
		}
		$this->AngsuranBunga->setOldValue($objForm->GetValue("o_AngsuranBunga"));
		if (!$this->AngsuranTotal->FldIsDetailKey) {
			$this->AngsuranTotal->setFormValue($objForm->GetValue("x_AngsuranTotal"));
		}
		$this->AngsuranTotal->setOldValue($objForm->GetValue("o_AngsuranTotal"));
		if (!$this->SisaHutang->FldIsDetailKey) {
			$this->SisaHutang->setFormValue($objForm->GetValue("x_SisaHutang"));
		}
		$this->SisaHutang->setOldValue($objForm->GetValue("o_SisaHutang"));
		if (!$this->TanggalBayar->FldIsDetailKey) {
			$this->TanggalBayar->setFormValue($objForm->GetValue("x_TanggalBayar"));
			$this->TanggalBayar->CurrentValue = ew_UnFormatDateTime($this->TanggalBayar->CurrentValue, 7);
		}
		$this->TanggalBayar->setOldValue($objForm->GetValue("o_TanggalBayar"));
		if (!$this->TotalDenda->FldIsDetailKey) {
			$this->TotalDenda->setFormValue($objForm->GetValue("x_TotalDenda"));
		}
		$this->TotalDenda->setOldValue($objForm->GetValue("o_TotalDenda"));
		if (!$this->Terlambat->FldIsDetailKey) {
			$this->Terlambat->setFormValue($objForm->GetValue("x_Terlambat"));
		}
		$this->Terlambat->setOldValue($objForm->GetValue("o_Terlambat"));
		if (!$this->Keterangan->FldIsDetailKey) {
			$this->Keterangan->setFormValue($objForm->GetValue("x_Keterangan"));
		}
		$this->Keterangan->setOldValue($objForm->GetValue("o_Keterangan"));
		if (!$this->id->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->CurrentValue = $this->id->FormValue;
		$this->AngsuranKe->CurrentValue = $this->AngsuranKe->FormValue;
		$this->AngsuranTanggal->CurrentValue = $this->AngsuranTanggal->FormValue;
		$this->AngsuranTanggal->CurrentValue = ew_UnFormatDateTime($this->AngsuranTanggal->CurrentValue, 7);
		$this->AngsuranPokok->CurrentValue = $this->AngsuranPokok->FormValue;
		$this->AngsuranBunga->CurrentValue = $this->AngsuranBunga->FormValue;
		$this->AngsuranTotal->CurrentValue = $this->AngsuranTotal->FormValue;
		$this->SisaHutang->CurrentValue = $this->SisaHutang->FormValue;
		$this->TanggalBayar->CurrentValue = $this->TanggalBayar->FormValue;
		$this->TanggalBayar->CurrentValue = ew_UnFormatDateTime($this->TanggalBayar->CurrentValue, 7);
		$this->TotalDenda->CurrentValue = $this->TotalDenda->FormValue;
		$this->Terlambat->CurrentValue = $this->Terlambat->FormValue;
		$this->Keterangan->CurrentValue = $this->Keterangan->FormValue;
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
		$this->LoadDefaultValues();
		$row = array();
		$row['id'] = $this->id->CurrentValue;
		$row['pinjaman_id'] = $this->pinjaman_id->CurrentValue;
		$row['AngsuranKe'] = $this->AngsuranKe->CurrentValue;
		$row['AngsuranTanggal'] = $this->AngsuranTanggal->CurrentValue;
		$row['AngsuranPokok'] = $this->AngsuranPokok->CurrentValue;
		$row['AngsuranBunga'] = $this->AngsuranBunga->CurrentValue;
		$row['AngsuranTotal'] = $this->AngsuranTotal->CurrentValue;
		$row['SisaHutang'] = $this->SisaHutang->CurrentValue;
		$row['TanggalBayar'] = $this->TanggalBayar->CurrentValue;
		$row['TotalDenda'] = $this->TotalDenda->CurrentValue;
		$row['Terlambat'] = $this->Terlambat->CurrentValue;
		$row['Keterangan'] = $this->Keterangan->CurrentValue;
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
		$arKeys[] = $this->RowOldKey;
		$cnt = count($arKeys);
		if ($cnt >= 1) {
			if (strval($arKeys[0]) <> "")
				$this->id->CurrentValue = strval($arKeys[0]); // id
			else
				$bValidKey = FALSE;
		} else {
			$bValidKey = FALSE;
		}

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
		$this->CopyUrl = $this->GetCopyUrl();
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

		$this->AngsuranTanggal->CellCssStyle = "white-space: nowrap;";

		// AngsuranPokok
		// AngsuranBunga
		// AngsuranTotal
		// SisaHutang
		// TanggalBayar

		$this->TanggalBayar->CellCssStyle = "white-space: nowrap;";

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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// AngsuranKe
			$this->AngsuranKe->EditAttrs["class"] = "form-control";
			$this->AngsuranKe->EditCustomAttributes = "";
			$this->AngsuranKe->EditValue = ew_HtmlEncode($this->AngsuranKe->CurrentValue);
			$this->AngsuranKe->PlaceHolder = ew_RemoveHtml($this->AngsuranKe->FldCaption());

			// AngsuranTanggal
			$this->AngsuranTanggal->EditAttrs["class"] = "form-control";
			$this->AngsuranTanggal->EditCustomAttributes = "";
			$this->AngsuranTanggal->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->AngsuranTanggal->CurrentValue, 7));
			$this->AngsuranTanggal->PlaceHolder = ew_RemoveHtml($this->AngsuranTanggal->FldCaption());

			// AngsuranPokok
			$this->AngsuranPokok->EditAttrs["class"] = "form-control";
			$this->AngsuranPokok->EditCustomAttributes = "";
			$this->AngsuranPokok->EditValue = ew_HtmlEncode($this->AngsuranPokok->CurrentValue);
			$this->AngsuranPokok->PlaceHolder = ew_RemoveHtml($this->AngsuranPokok->FldCaption());
			if (strval($this->AngsuranPokok->EditValue) <> "" && is_numeric($this->AngsuranPokok->EditValue)) {
			$this->AngsuranPokok->EditValue = ew_FormatNumber($this->AngsuranPokok->EditValue, -2, -2, -2, -2);
			$this->AngsuranPokok->OldValue = $this->AngsuranPokok->EditValue;
			}

			// AngsuranBunga
			$this->AngsuranBunga->EditAttrs["class"] = "form-control";
			$this->AngsuranBunga->EditCustomAttributes = "";
			$this->AngsuranBunga->EditValue = ew_HtmlEncode($this->AngsuranBunga->CurrentValue);
			$this->AngsuranBunga->PlaceHolder = ew_RemoveHtml($this->AngsuranBunga->FldCaption());
			if (strval($this->AngsuranBunga->EditValue) <> "" && is_numeric($this->AngsuranBunga->EditValue)) {
			$this->AngsuranBunga->EditValue = ew_FormatNumber($this->AngsuranBunga->EditValue, -2, -2, -2, -2);
			$this->AngsuranBunga->OldValue = $this->AngsuranBunga->EditValue;
			}

			// AngsuranTotal
			$this->AngsuranTotal->EditAttrs["class"] = "form-control";
			$this->AngsuranTotal->EditCustomAttributes = "";
			$this->AngsuranTotal->EditValue = ew_HtmlEncode($this->AngsuranTotal->CurrentValue);
			$this->AngsuranTotal->PlaceHolder = ew_RemoveHtml($this->AngsuranTotal->FldCaption());
			if (strval($this->AngsuranTotal->EditValue) <> "" && is_numeric($this->AngsuranTotal->EditValue)) {
			$this->AngsuranTotal->EditValue = ew_FormatNumber($this->AngsuranTotal->EditValue, -2, -2, -2, -2);
			$this->AngsuranTotal->OldValue = $this->AngsuranTotal->EditValue;
			}

			// SisaHutang
			$this->SisaHutang->EditAttrs["class"] = "form-control";
			$this->SisaHutang->EditCustomAttributes = "";
			$this->SisaHutang->EditValue = ew_HtmlEncode($this->SisaHutang->CurrentValue);
			$this->SisaHutang->PlaceHolder = ew_RemoveHtml($this->SisaHutang->FldCaption());
			if (strval($this->SisaHutang->EditValue) <> "" && is_numeric($this->SisaHutang->EditValue)) {
			$this->SisaHutang->EditValue = ew_FormatNumber($this->SisaHutang->EditValue, -2, -2, -2, -2);
			$this->SisaHutang->OldValue = $this->SisaHutang->EditValue;
			}

			// TanggalBayar
			$this->TanggalBayar->EditAttrs["class"] = "form-control";
			$this->TanggalBayar->EditCustomAttributes = "style='width: 100px;'";
			$this->TanggalBayar->EditValue = ew_HtmlEncode($this->TanggalBayar->CurrentValue);
			$this->TanggalBayar->PlaceHolder = ew_RemoveHtml($this->TanggalBayar->FldCaption());

			// TotalDenda
			$this->TotalDenda->EditAttrs["class"] = "form-control";
			$this->TotalDenda->EditCustomAttributes = "";
			$this->TotalDenda->EditValue = ew_HtmlEncode($this->TotalDenda->CurrentValue);
			$this->TotalDenda->PlaceHolder = ew_RemoveHtml($this->TotalDenda->FldCaption());
			if (strval($this->TotalDenda->EditValue) <> "" && is_numeric($this->TotalDenda->EditValue)) {
			$this->TotalDenda->EditValue = ew_FormatNumber($this->TotalDenda->EditValue, -2, -2, -2, -2);
			$this->TotalDenda->OldValue = $this->TotalDenda->EditValue;
			}

			// Terlambat
			$this->Terlambat->EditAttrs["class"] = "form-control";
			$this->Terlambat->EditCustomAttributes = "";
			$this->Terlambat->EditValue = ew_HtmlEncode($this->Terlambat->CurrentValue);
			$this->Terlambat->PlaceHolder = ew_RemoveHtml($this->Terlambat->FldCaption());

			// Keterangan
			$this->Keterangan->EditAttrs["class"] = "form-control";
			$this->Keterangan->EditCustomAttributes = "";
			$this->Keterangan->EditValue = ew_HtmlEncode($this->Keterangan->CurrentValue);
			$this->Keterangan->PlaceHolder = ew_RemoveHtml($this->Keterangan->FldCaption());

			// Add refer script
			// AngsuranKe

			$this->AngsuranKe->LinkCustomAttributes = "";
			$this->AngsuranKe->HrefValue = "";

			// AngsuranTanggal
			$this->AngsuranTanggal->LinkCustomAttributes = "";
			$this->AngsuranTanggal->HrefValue = "";

			// AngsuranPokok
			$this->AngsuranPokok->LinkCustomAttributes = "";
			$this->AngsuranPokok->HrefValue = "";

			// AngsuranBunga
			$this->AngsuranBunga->LinkCustomAttributes = "";
			$this->AngsuranBunga->HrefValue = "";

			// AngsuranTotal
			$this->AngsuranTotal->LinkCustomAttributes = "";
			$this->AngsuranTotal->HrefValue = "";

			// SisaHutang
			$this->SisaHutang->LinkCustomAttributes = "";
			$this->SisaHutang->HrefValue = "";

			// TanggalBayar
			$this->TanggalBayar->LinkCustomAttributes = "";
			$this->TanggalBayar->HrefValue = "";

			// TotalDenda
			$this->TotalDenda->LinkCustomAttributes = "";
			$this->TotalDenda->HrefValue = "";

			// Terlambat
			$this->Terlambat->LinkCustomAttributes = "";
			$this->Terlambat->HrefValue = "";

			// Keterangan
			$this->Keterangan->LinkCustomAttributes = "";
			$this->Keterangan->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// AngsuranKe
			$this->AngsuranKe->EditAttrs["class"] = "form-control";
			$this->AngsuranKe->EditCustomAttributes = "";
			$this->AngsuranKe->EditValue = $this->AngsuranKe->CurrentValue;
			$this->AngsuranKe->ViewCustomAttributes = "";

			// AngsuranTanggal
			$this->AngsuranTanggal->EditAttrs["class"] = "form-control";
			$this->AngsuranTanggal->EditCustomAttributes = "";
			$this->AngsuranTanggal->EditValue = $this->AngsuranTanggal->CurrentValue;
			$this->AngsuranTanggal->EditValue = ew_FormatDateTime($this->AngsuranTanggal->EditValue, 7);
			$this->AngsuranTanggal->ViewCustomAttributes = "";

			// AngsuranPokok
			$this->AngsuranPokok->EditAttrs["class"] = "form-control";
			$this->AngsuranPokok->EditCustomAttributes = "";
			$this->AngsuranPokok->EditValue = $this->AngsuranPokok->CurrentValue;
			$this->AngsuranPokok->EditValue = ew_FormatNumber($this->AngsuranPokok->EditValue, 2, -2, -2, -2);
			$this->AngsuranPokok->CellCssStyle .= "text-align: right;";
			$this->AngsuranPokok->ViewCustomAttributes = "";

			// AngsuranBunga
			$this->AngsuranBunga->EditAttrs["class"] = "form-control";
			$this->AngsuranBunga->EditCustomAttributes = "";
			$this->AngsuranBunga->EditValue = $this->AngsuranBunga->CurrentValue;
			$this->AngsuranBunga->EditValue = ew_FormatNumber($this->AngsuranBunga->EditValue, 2, -2, -2, -2);
			$this->AngsuranBunga->CellCssStyle .= "text-align: right;";
			$this->AngsuranBunga->ViewCustomAttributes = "";

			// AngsuranTotal
			$this->AngsuranTotal->EditAttrs["class"] = "form-control";
			$this->AngsuranTotal->EditCustomAttributes = "";
			$this->AngsuranTotal->EditValue = $this->AngsuranTotal->CurrentValue;
			$this->AngsuranTotal->EditValue = ew_FormatNumber($this->AngsuranTotal->EditValue, 2, -2, -2, -2);
			$this->AngsuranTotal->CellCssStyle .= "text-align: right;";
			$this->AngsuranTotal->ViewCustomAttributes = "";

			// SisaHutang
			$this->SisaHutang->EditAttrs["class"] = "form-control";
			$this->SisaHutang->EditCustomAttributes = "";
			$this->SisaHutang->EditValue = $this->SisaHutang->CurrentValue;
			$this->SisaHutang->EditValue = ew_FormatNumber($this->SisaHutang->EditValue, 2, -2, -2, -2);
			$this->SisaHutang->CellCssStyle .= "text-align: right;";
			$this->SisaHutang->ViewCustomAttributes = "";

			// TanggalBayar
			$this->TanggalBayar->EditAttrs["class"] = "form-control";
			$this->TanggalBayar->EditCustomAttributes = "style='width: 100px;'";
			$this->TanggalBayar->EditValue = ew_HtmlEncode($this->TanggalBayar->CurrentValue);
			$this->TanggalBayar->PlaceHolder = ew_RemoveHtml($this->TanggalBayar->FldCaption());

			// TotalDenda
			$this->TotalDenda->EditAttrs["class"] = "form-control";
			$this->TotalDenda->EditCustomAttributes = "";
			$this->TotalDenda->EditValue = ew_HtmlEncode($this->TotalDenda->CurrentValue);
			$this->TotalDenda->PlaceHolder = ew_RemoveHtml($this->TotalDenda->FldCaption());
			if (strval($this->TotalDenda->EditValue) <> "" && is_numeric($this->TotalDenda->EditValue)) {
			$this->TotalDenda->EditValue = ew_FormatNumber($this->TotalDenda->EditValue, -2, -2, -2, -2);
			$this->TotalDenda->OldValue = $this->TotalDenda->EditValue;
			}

			// Terlambat
			$this->Terlambat->EditAttrs["class"] = "form-control";
			$this->Terlambat->EditCustomAttributes = "";
			$this->Terlambat->EditValue = ew_HtmlEncode($this->Terlambat->CurrentValue);
			$this->Terlambat->PlaceHolder = ew_RemoveHtml($this->Terlambat->FldCaption());

			// Keterangan
			$this->Keterangan->EditAttrs["class"] = "form-control";
			$this->Keterangan->EditCustomAttributes = "";
			$this->Keterangan->EditValue = ew_HtmlEncode($this->Keterangan->CurrentValue);
			$this->Keterangan->PlaceHolder = ew_RemoveHtml($this->Keterangan->FldCaption());

			// Edit refer script
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

			// TotalDenda
			$this->TotalDenda->LinkCustomAttributes = "";
			$this->TotalDenda->HrefValue = "";

			// Terlambat
			$this->Terlambat->LinkCustomAttributes = "";
			$this->Terlambat->HrefValue = "";

			// Keterangan
			$this->Keterangan->LinkCustomAttributes = "";
			$this->Keterangan->HrefValue = "";
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

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->AngsuranKe->FldIsDetailKey && !is_null($this->AngsuranKe->FormValue) && $this->AngsuranKe->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->AngsuranKe->FldCaption(), $this->AngsuranKe->ReqErrMsg));
		}
		if (!$this->AngsuranTanggal->FldIsDetailKey && !is_null($this->AngsuranTanggal->FormValue) && $this->AngsuranTanggal->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->AngsuranTanggal->FldCaption(), $this->AngsuranTanggal->ReqErrMsg));
		}
		if (!$this->AngsuranPokok->FldIsDetailKey && !is_null($this->AngsuranPokok->FormValue) && $this->AngsuranPokok->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->AngsuranPokok->FldCaption(), $this->AngsuranPokok->ReqErrMsg));
		}
		if (!$this->AngsuranBunga->FldIsDetailKey && !is_null($this->AngsuranBunga->FormValue) && $this->AngsuranBunga->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->AngsuranBunga->FldCaption(), $this->AngsuranBunga->ReqErrMsg));
		}
		if (!$this->AngsuranTotal->FldIsDetailKey && !is_null($this->AngsuranTotal->FormValue) && $this->AngsuranTotal->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->AngsuranTotal->FldCaption(), $this->AngsuranTotal->ReqErrMsg));
		}
		if (!$this->SisaHutang->FldIsDetailKey && !is_null($this->SisaHutang->FormValue) && $this->SisaHutang->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->SisaHutang->FldCaption(), $this->SisaHutang->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->TanggalBayar->FormValue)) {
			ew_AddMessage($gsFormError, $this->TanggalBayar->FldErrMsg());
		}
		if (!ew_CheckNumber($this->TotalDenda->FormValue)) {
			ew_AddMessage($gsFormError, $this->TotalDenda->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Terlambat->FormValue)) {
			ew_AddMessage($gsFormError, $this->Terlambat->FldErrMsg());
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

			// TanggalBayar
			$this->TanggalBayar->SetDbValueDef($rsnew, $this->TanggalBayar->CurrentValue, NULL, $this->TanggalBayar->ReadOnly);

			// TotalDenda
			$this->TotalDenda->SetDbValueDef($rsnew, $this->TotalDenda->CurrentValue, NULL, $this->TotalDenda->ReadOnly);

			// Terlambat
			$this->Terlambat->SetDbValueDef($rsnew, $this->Terlambat->CurrentValue, NULL, $this->Terlambat->ReadOnly);

			// Keterangan
			$this->Keterangan->SetDbValueDef($rsnew, $this->Keterangan->CurrentValue, NULL, $this->Keterangan->ReadOnly);

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

		// Set up foreign key field value from Session
			if ($this->getCurrentMasterTable() == "t03_pinjaman") {
				$this->pinjaman_id->CurrentValue = $this->pinjaman_id->getSessionValue();
			}
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// AngsuranKe
		$this->AngsuranKe->SetDbValueDef($rsnew, $this->AngsuranKe->CurrentValue, 0, FALSE);

		// AngsuranTanggal
		$this->AngsuranTanggal->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->AngsuranTanggal->CurrentValue, 7), ew_CurrentDate(), FALSE);

		// AngsuranPokok
		$this->AngsuranPokok->SetDbValueDef($rsnew, $this->AngsuranPokok->CurrentValue, 0, FALSE);

		// AngsuranBunga
		$this->AngsuranBunga->SetDbValueDef($rsnew, $this->AngsuranBunga->CurrentValue, 0, FALSE);

		// AngsuranTotal
		$this->AngsuranTotal->SetDbValueDef($rsnew, $this->AngsuranTotal->CurrentValue, 0, FALSE);

		// SisaHutang
		$this->SisaHutang->SetDbValueDef($rsnew, $this->SisaHutang->CurrentValue, 0, FALSE);

		// TanggalBayar
		$this->TanggalBayar->SetDbValueDef($rsnew, $this->TanggalBayar->CurrentValue, NULL, FALSE);

		// TotalDenda
		$this->TotalDenda->SetDbValueDef($rsnew, $this->TotalDenda->CurrentValue, NULL, FALSE);

		// Terlambat
		$this->Terlambat->SetDbValueDef($rsnew, $this->Terlambat->CurrentValue, NULL, FALSE);

		// Keterangan
		$this->Keterangan->SetDbValueDef($rsnew, $this->Keterangan->CurrentValue, NULL, FALSE);

		// pinjaman_id
		if ($this->pinjaman_id->getSessionValue() <> "") {
			$rsnew['pinjaman_id'] = $this->pinjaman_id->getSessionValue();
		}

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

		// Hide foreign keys
		$sMasterTblVar = $this->getCurrentMasterTable();
		if ($sMasterTblVar == "t03_pinjaman") {
			$this->pinjaman_id->Visible = FALSE;
			if ($GLOBALS["t03_pinjaman"]->EventCancelled) $this->EventCancelled = TRUE;
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
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
