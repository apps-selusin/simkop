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
<?php include_once "t06_pinjamantitipangridcls.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$t03_pinjaman_view = NULL; // Initialize page object first

class ct03_pinjaman_view extends ct03_pinjaman {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = '{B3698D9B-8D4B-412E-A2E5-AFAD2FEE5A23}';

	// Table name
	var $TableName = 't03_pinjaman';

	// Page object name
	var $PageObjName = 't03_pinjaman_view';

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

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->NoKontrak->SetVisibility();
		$this->TglKontrak->SetVisibility();
		$this->nasabah_id->SetVisibility();
		$this->Pinjaman->SetVisibility();
		$this->LamaAngsuran->SetVisibility();
		$this->Bunga->SetVisibility();
		$this->Denda->SetVisibility();
		$this->DispensasiDenda->SetVisibility();
		$this->AngsuranPokok->SetVisibility();
		$this->AngsuranBunga->SetVisibility();
		$this->AngsuranTotal->SetVisibility();
		$this->NoKontrakRefTo->SetVisibility();

		// Set up detail page object
		$this->SetupDetailPages();

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
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $AutoHidePager = EW_AUTO_HIDE_PAGER;
	var $RecCnt;
	var $RecKey = array();
	var $IsModal = FALSE;
	var $Recordset;
	var $DetailPages; // Detail pages object

	//
	// Page main
	//
	function Page_Main() {
		global $Language, $gbSkipHeaderFooter, $EW_EXPORT;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Load current record
		$bLoadCurrentRecord = FALSE;
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
				$bLoadCurrentRecord = TRUE;
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					$this->StartRec = 1; // Initialize start position
					if ($this->Recordset = $this->LoadRecordset()) // Load records
						$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
					if ($this->TotalRecs <= 0) { // No record found
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$this->Page_Terminate("t03_pinjamanlist.php"); // Return to list page
					} elseif ($bLoadCurrentRecord) { // Load current record position
						$this->SetupStartRec(); // Set up start record position

						// Point to current record
						if (intval($this->StartRec) <= intval($this->TotalRecs)) {
							$bMatchRecord = TRUE;
							$this->Recordset->Move($this->StartRec-1);
						}
					} else { // Match key values
						while (!$this->Recordset->EOF) {
							if (strval($this->id->CurrentValue) == strval($this->Recordset->fields('id'))) {
								$this->setStartRecordNumber($this->StartRec); // Save record position
								$bMatchRecord = TRUE;
								break;
							} else {
								$this->StartRec++;
								$this->Recordset->MoveNext();
							}
						}
					}
					if (!$bMatchRecord) {
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "t03_pinjamanlist.php"; // No matching record, return to list
					} else {
						$this->LoadRowValues($this->Recordset); // Load row values
					}
			}
		} else {
			$sReturnUrl = "t03_pinjamanlist.php"; // Not page request, return to list
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

		// Set up detail parameters
		$this->SetupDetailParms();
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
		$option = &$options["detail"];
		$DetailTableLink = "";
		$DetailViewTblVar = "";
		$DetailCopyTblVar = "";
		$DetailEditTblVar = "";

		// "detail_t04_angsuran"
		$item = &$option->Add("detail_t04_angsuran");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("t04_angsuran", "TblCaption");
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("t04_angsuranlist.php?" . EW_TABLE_SHOW_MASTER . "=t03_pinjaman&fk_id=" . urlencode(strval($this->id->CurrentValue)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["t04_angsuran_grid"] && $GLOBALS["t04_angsuran_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 't04_angsuran')) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=t04_angsuran")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "t04_angsuran";
		}
		if ($GLOBALS["t04_angsuran_grid"] && $GLOBALS["t04_angsuran_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 't04_angsuran')) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=t04_angsuran")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "t04_angsuran";
		}
		if ($GLOBALS["t04_angsuran_grid"] && $GLOBALS["t04_angsuran_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 't04_angsuran')) {
			$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=t04_angsuran")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
			$DetailCopyTblVar .= "t04_angsuran";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = $Security->AllowList(CurrentProjectID() . 't04_angsuran');
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "t04_angsuran";
		}
		if ($this->ShowMultipleDetails) $item->Visible = FALSE;

		// "detail_t05_pinjamanjaminan"
		$item = &$option->Add("detail_t05_pinjamanjaminan");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("t05_pinjamanjaminan", "TblCaption");
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("t05_pinjamanjaminanlist.php?" . EW_TABLE_SHOW_MASTER . "=t03_pinjaman&fk_id=" . urlencode(strval($this->id->CurrentValue)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["t05_pinjamanjaminan_grid"] && $GLOBALS["t05_pinjamanjaminan_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 't05_pinjamanjaminan')) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=t05_pinjamanjaminan")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "t05_pinjamanjaminan";
		}
		if ($GLOBALS["t05_pinjamanjaminan_grid"] && $GLOBALS["t05_pinjamanjaminan_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 't05_pinjamanjaminan')) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=t05_pinjamanjaminan")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "t05_pinjamanjaminan";
		}
		if ($GLOBALS["t05_pinjamanjaminan_grid"] && $GLOBALS["t05_pinjamanjaminan_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 't05_pinjamanjaminan')) {
			$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=t05_pinjamanjaminan")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
			$DetailCopyTblVar .= "t05_pinjamanjaminan";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = $Security->AllowList(CurrentProjectID() . 't05_pinjamanjaminan');
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "t05_pinjamanjaminan";
		}
		if ($this->ShowMultipleDetails) $item->Visible = FALSE;

		// "detail_t06_pinjamantitipan"
		$item = &$option->Add("detail_t06_pinjamantitipan");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("t06_pinjamantitipan", "TblCaption");
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("t06_pinjamantitipanlist.php?" . EW_TABLE_SHOW_MASTER . "=t03_pinjaman&fk_id=" . urlencode(strval($this->id->CurrentValue)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["t06_pinjamantitipan_grid"] && $GLOBALS["t06_pinjamantitipan_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 't06_pinjamantitipan')) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=t06_pinjamantitipan")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "t06_pinjamantitipan";
		}
		if ($GLOBALS["t06_pinjamantitipan_grid"] && $GLOBALS["t06_pinjamantitipan_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 't06_pinjamantitipan')) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=t06_pinjamantitipan")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "t06_pinjamantitipan";
		}
		if ($GLOBALS["t06_pinjamantitipan_grid"] && $GLOBALS["t06_pinjamantitipan_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 't06_pinjamantitipan')) {
			$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=t06_pinjamantitipan")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
			$DetailCopyTblVar .= "t06_pinjamantitipan";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = $Security->AllowList(CurrentProjectID() . 't06_pinjamantitipan');
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "t06_pinjamantitipan";
		}
		if ($this->ShowMultipleDetails) $item->Visible = FALSE;

		// Multiple details
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
			$oListOpt = &$option->Add("details");
			$oListOpt->Body = $body;
		}

		// Set up detail default
		$option = &$options["detail"];
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$option->UseImageAndText = TRUE;
		$ar = explode(",", $DetailTableLink);
		$cnt = count($ar);
		$option->UseDropDownButton = ($cnt > 1);
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

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
		if ($this->AuditTrailOnView) $this->WriteAuditTrailOnView($row);
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
		if ($this->Bunga->FormValue == $this->Bunga->CurrentValue && is_numeric(ew_StrToFloat($this->Bunga->CurrentValue)))
			$this->Bunga->CurrentValue = ew_StrToFloat($this->Bunga->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Denda->FormValue == $this->Denda->CurrentValue && is_numeric(ew_StrToFloat($this->Denda->CurrentValue)))
			$this->Denda->CurrentValue = ew_StrToFloat($this->Denda->CurrentValue);

		// Convert decimal values if posted back
		if ($this->AngsuranPokok->FormValue == $this->AngsuranPokok->CurrentValue && is_numeric(ew_StrToFloat($this->AngsuranPokok->CurrentValue)))
			$this->AngsuranPokok->CurrentValue = ew_StrToFloat($this->AngsuranPokok->CurrentValue);

		// Convert decimal values if posted back
		if ($this->AngsuranBunga->FormValue == $this->AngsuranBunga->CurrentValue && is_numeric(ew_StrToFloat($this->AngsuranBunga->CurrentValue)))
			$this->AngsuranBunga->CurrentValue = ew_StrToFloat($this->AngsuranBunga->CurrentValue);

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

			// NoKontrakRefTo
			$this->NoKontrakRefTo->LinkCustomAttributes = "";
			$this->NoKontrakRefTo->HrefValue = "";
			$this->NoKontrakRefTo->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
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
				if ($GLOBALS["t04_angsuran_grid"]->DetailView) {
					$GLOBALS["t04_angsuran_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["t04_angsuran_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["t04_angsuran_grid"]->setStartRecordNumber(1);
					$GLOBALS["t04_angsuran_grid"]->pinjaman_id->FldIsDetailKey = TRUE;
					$GLOBALS["t04_angsuran_grid"]->pinjaman_id->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["t04_angsuran_grid"]->pinjaman_id->setSessionValue($GLOBALS["t04_angsuran_grid"]->pinjaman_id->CurrentValue);
				}
			}
			if (in_array("t05_pinjamanjaminan", $DetailTblVar)) {
				if (!isset($GLOBALS["t05_pinjamanjaminan_grid"]))
					$GLOBALS["t05_pinjamanjaminan_grid"] = new ct05_pinjamanjaminan_grid;
				if ($GLOBALS["t05_pinjamanjaminan_grid"]->DetailView) {
					$GLOBALS["t05_pinjamanjaminan_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["t05_pinjamanjaminan_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["t05_pinjamanjaminan_grid"]->setStartRecordNumber(1);
					$GLOBALS["t05_pinjamanjaminan_grid"]->pinjaman_id->FldIsDetailKey = TRUE;
					$GLOBALS["t05_pinjamanjaminan_grid"]->pinjaman_id->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["t05_pinjamanjaminan_grid"]->pinjaman_id->setSessionValue($GLOBALS["t05_pinjamanjaminan_grid"]->pinjaman_id->CurrentValue);
				}
			}
			if (in_array("t06_pinjamantitipan", $DetailTblVar)) {
				if (!isset($GLOBALS["t06_pinjamantitipan_grid"]))
					$GLOBALS["t06_pinjamantitipan_grid"] = new ct06_pinjamantitipan_grid;
				if ($GLOBALS["t06_pinjamantitipan_grid"]->DetailView) {
					$GLOBALS["t06_pinjamantitipan_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["t06_pinjamantitipan_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["t06_pinjamantitipan_grid"]->setStartRecordNumber(1);
					$GLOBALS["t06_pinjamantitipan_grid"]->pinjaman_id->FldIsDetailKey = TRUE;
					$GLOBALS["t06_pinjamantitipan_grid"]->pinjaman_id->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["t06_pinjamantitipan_grid"]->pinjaman_id->setSessionValue($GLOBALS["t06_pinjamantitipan_grid"]->pinjaman_id->CurrentValue);
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
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url);
	}

	// Set up detail pages
	function SetupDetailPages() {
		$pages = new cSubPages();
		$pages->Style = "pills";
		$pages->Add('t04_angsuran');
		$pages->Add('t05_pinjamanjaminan');
		$pages->Add('t06_pinjamantitipan');
		$this->DetailPages = $pages;
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
if (!isset($t03_pinjaman_view)) $t03_pinjaman_view = new ct03_pinjaman_view();

// Page init
$t03_pinjaman_view->Page_Init();

// Page main
$t03_pinjaman_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t03_pinjaman_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = ft03_pinjamanview = new ew_Form("ft03_pinjamanview", "view");

// Form_CustomValidate event
ft03_pinjamanview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft03_pinjamanview.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ft03_pinjamanview.Lists["x_nasabah_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_Customer","x_NoTelpHp","",""],"ParentFields":[],"ChildFields":["t05_pinjamanjaminan x_jaminan_id"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t01_nasabah"};
ft03_pinjamanview.Lists["x_nasabah_id"].Data = "<?php echo $t03_pinjaman_view->nasabah_id->LookupFilterQuery(FALSE, "view") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $t03_pinjaman_view->ExportOptions->Render("body") ?>
<?php
	foreach ($t03_pinjaman_view->OtherOptions as &$option)
		$option->Render("body");
?>
<div class="clearfix"></div>
</div>
<?php $t03_pinjaman_view->ShowPageHeader(); ?>
<?php
$t03_pinjaman_view->ShowMessage();
?>
<?php if (!$t03_pinjaman_view->IsModal) { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t03_pinjaman_view->Pager)) $t03_pinjaman_view->Pager = new cPrevNextPager($t03_pinjaman_view->StartRec, $t03_pinjaman_view->DisplayRecs, $t03_pinjaman_view->TotalRecs, $t03_pinjaman_view->AutoHidePager) ?>
<?php if ($t03_pinjaman_view->Pager->RecordCount > 0 && $t03_pinjaman_view->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t03_pinjaman_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t03_pinjaman_view->PageUrl() ?>start=<?php echo $t03_pinjaman_view->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t03_pinjaman_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t03_pinjaman_view->PageUrl() ?>start=<?php echo $t03_pinjaman_view->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t03_pinjaman_view->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t03_pinjaman_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t03_pinjaman_view->PageUrl() ?>start=<?php echo $t03_pinjaman_view->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t03_pinjaman_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t03_pinjaman_view->PageUrl() ?>start=<?php echo $t03_pinjaman_view->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t03_pinjaman_view->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="ft03_pinjamanview" id="ft03_pinjamanview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t03_pinjaman_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t03_pinjaman_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t03_pinjaman">
<input type="hidden" name="modal" value="<?php echo intval($t03_pinjaman_view->IsModal) ?>">
<table class="table table-striped table-bordered table-hover table-condensed ewViewTable">
<?php if ($t03_pinjaman->NoKontrak->Visible) { // NoKontrak ?>
	<tr id="r_NoKontrak">
		<td class="col-sm-2"><span id="elh_t03_pinjaman_NoKontrak"><?php echo $t03_pinjaman->NoKontrak->FldCaption() ?></span></td>
		<td data-name="NoKontrak"<?php echo $t03_pinjaman->NoKontrak->CellAttributes() ?>>
<span id="el_t03_pinjaman_NoKontrak">
<span<?php echo $t03_pinjaman->NoKontrak->ViewAttributes() ?>>
<?php echo $t03_pinjaman->NoKontrak->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t03_pinjaman->TglKontrak->Visible) { // TglKontrak ?>
	<tr id="r_TglKontrak">
		<td class="col-sm-2"><span id="elh_t03_pinjaman_TglKontrak"><?php echo $t03_pinjaman->TglKontrak->FldCaption() ?></span></td>
		<td data-name="TglKontrak"<?php echo $t03_pinjaman->TglKontrak->CellAttributes() ?>>
<span id="el_t03_pinjaman_TglKontrak">
<span<?php echo $t03_pinjaman->TglKontrak->ViewAttributes() ?>>
<?php echo $t03_pinjaman->TglKontrak->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t03_pinjaman->nasabah_id->Visible) { // nasabah_id ?>
	<tr id="r_nasabah_id">
		<td class="col-sm-2"><span id="elh_t03_pinjaman_nasabah_id"><?php echo $t03_pinjaman->nasabah_id->FldCaption() ?></span></td>
		<td data-name="nasabah_id"<?php echo $t03_pinjaman->nasabah_id->CellAttributes() ?>>
<span id="el_t03_pinjaman_nasabah_id">
<span<?php echo $t03_pinjaman->nasabah_id->ViewAttributes() ?>>
<?php echo $t03_pinjaman->nasabah_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t03_pinjaman->Pinjaman->Visible) { // Pinjaman ?>
	<tr id="r_Pinjaman">
		<td class="col-sm-2"><span id="elh_t03_pinjaman_Pinjaman"><?php echo $t03_pinjaman->Pinjaman->FldCaption() ?></span></td>
		<td data-name="Pinjaman"<?php echo $t03_pinjaman->Pinjaman->CellAttributes() ?>>
<span id="el_t03_pinjaman_Pinjaman">
<span<?php echo $t03_pinjaman->Pinjaman->ViewAttributes() ?>>
<?php echo $t03_pinjaman->Pinjaman->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t03_pinjaman->LamaAngsuran->Visible) { // LamaAngsuran ?>
	<tr id="r_LamaAngsuran">
		<td class="col-sm-2"><span id="elh_t03_pinjaman_LamaAngsuran"><?php echo $t03_pinjaman->LamaAngsuran->FldCaption() ?></span></td>
		<td data-name="LamaAngsuran"<?php echo $t03_pinjaman->LamaAngsuran->CellAttributes() ?>>
<span id="el_t03_pinjaman_LamaAngsuran">
<span<?php echo $t03_pinjaman->LamaAngsuran->ViewAttributes() ?>>
<?php echo $t03_pinjaman->LamaAngsuran->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t03_pinjaman->Bunga->Visible) { // Bunga ?>
	<tr id="r_Bunga">
		<td class="col-sm-2"><span id="elh_t03_pinjaman_Bunga"><?php echo $t03_pinjaman->Bunga->FldCaption() ?></span></td>
		<td data-name="Bunga"<?php echo $t03_pinjaman->Bunga->CellAttributes() ?>>
<span id="el_t03_pinjaman_Bunga">
<span<?php echo $t03_pinjaman->Bunga->ViewAttributes() ?>>
<?php echo $t03_pinjaman->Bunga->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t03_pinjaman->Denda->Visible) { // Denda ?>
	<tr id="r_Denda">
		<td class="col-sm-2"><span id="elh_t03_pinjaman_Denda"><?php echo $t03_pinjaman->Denda->FldCaption() ?></span></td>
		<td data-name="Denda"<?php echo $t03_pinjaman->Denda->CellAttributes() ?>>
<span id="el_t03_pinjaman_Denda">
<span<?php echo $t03_pinjaman->Denda->ViewAttributes() ?>>
<?php echo $t03_pinjaman->Denda->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t03_pinjaman->DispensasiDenda->Visible) { // DispensasiDenda ?>
	<tr id="r_DispensasiDenda">
		<td class="col-sm-2"><span id="elh_t03_pinjaman_DispensasiDenda"><?php echo $t03_pinjaman->DispensasiDenda->FldCaption() ?></span></td>
		<td data-name="DispensasiDenda"<?php echo $t03_pinjaman->DispensasiDenda->CellAttributes() ?>>
<span id="el_t03_pinjaman_DispensasiDenda">
<span<?php echo $t03_pinjaman->DispensasiDenda->ViewAttributes() ?>>
<?php echo $t03_pinjaman->DispensasiDenda->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t03_pinjaman->AngsuranPokok->Visible) { // AngsuranPokok ?>
	<tr id="r_AngsuranPokok">
		<td class="col-sm-2"><span id="elh_t03_pinjaman_AngsuranPokok"><?php echo $t03_pinjaman->AngsuranPokok->FldCaption() ?></span></td>
		<td data-name="AngsuranPokok"<?php echo $t03_pinjaman->AngsuranPokok->CellAttributes() ?>>
<span id="el_t03_pinjaman_AngsuranPokok">
<span<?php echo $t03_pinjaman->AngsuranPokok->ViewAttributes() ?>>
<?php echo $t03_pinjaman->AngsuranPokok->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t03_pinjaman->AngsuranBunga->Visible) { // AngsuranBunga ?>
	<tr id="r_AngsuranBunga">
		<td class="col-sm-2"><span id="elh_t03_pinjaman_AngsuranBunga"><?php echo $t03_pinjaman->AngsuranBunga->FldCaption() ?></span></td>
		<td data-name="AngsuranBunga"<?php echo $t03_pinjaman->AngsuranBunga->CellAttributes() ?>>
<span id="el_t03_pinjaman_AngsuranBunga">
<span<?php echo $t03_pinjaman->AngsuranBunga->ViewAttributes() ?>>
<?php echo $t03_pinjaman->AngsuranBunga->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t03_pinjaman->AngsuranTotal->Visible) { // AngsuranTotal ?>
	<tr id="r_AngsuranTotal">
		<td class="col-sm-2"><span id="elh_t03_pinjaman_AngsuranTotal"><?php echo $t03_pinjaman->AngsuranTotal->FldCaption() ?></span></td>
		<td data-name="AngsuranTotal"<?php echo $t03_pinjaman->AngsuranTotal->CellAttributes() ?>>
<span id="el_t03_pinjaman_AngsuranTotal">
<span<?php echo $t03_pinjaman->AngsuranTotal->ViewAttributes() ?>>
<?php echo $t03_pinjaman->AngsuranTotal->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t03_pinjaman->NoKontrakRefTo->Visible) { // NoKontrakRefTo ?>
	<tr id="r_NoKontrakRefTo">
		<td class="col-sm-2"><span id="elh_t03_pinjaman_NoKontrakRefTo"><?php echo $t03_pinjaman->NoKontrakRefTo->FldCaption() ?></span></td>
		<td data-name="NoKontrakRefTo"<?php echo $t03_pinjaman->NoKontrakRefTo->CellAttributes() ?>>
<span id="el_t03_pinjaman_NoKontrakRefTo">
<span<?php echo $t03_pinjaman->NoKontrakRefTo->ViewAttributes() ?>>
<?php echo $t03_pinjaman->NoKontrakRefTo->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if (!$t03_pinjaman_view->IsModal) { ?>
<?php if (!isset($t03_pinjaman_view->Pager)) $t03_pinjaman_view->Pager = new cPrevNextPager($t03_pinjaman_view->StartRec, $t03_pinjaman_view->DisplayRecs, $t03_pinjaman_view->TotalRecs, $t03_pinjaman_view->AutoHidePager) ?>
<?php if ($t03_pinjaman_view->Pager->RecordCount > 0 && $t03_pinjaman_view->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t03_pinjaman_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t03_pinjaman_view->PageUrl() ?>start=<?php echo $t03_pinjaman_view->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t03_pinjaman_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t03_pinjaman_view->PageUrl() ?>start=<?php echo $t03_pinjaman_view->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t03_pinjaman_view->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t03_pinjaman_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t03_pinjaman_view->PageUrl() ?>start=<?php echo $t03_pinjaman_view->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t03_pinjaman_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t03_pinjaman_view->PageUrl() ?>start=<?php echo $t03_pinjaman_view->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t03_pinjaman_view->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t03_pinjaman->getCurrentDetailTable() <> "") { ?>
<?php
	$t03_pinjaman_view->DetailPages->ValidKeys = explode(",", $t03_pinjaman->getCurrentDetailTable());
	$FirstActiveDetailTable = $t03_pinjaman_view->DetailPages->ActivePageIndex();
?>
<div class="ewDetailPages"><!-- detail-pages -->
<div class="nav-tabs-custom" id="t03_pinjaman_view_details"><!-- .nav-tabs-custom -->
	<ul class="nav<?php echo $t03_pinjaman_view->DetailPages->NavStyle() ?>"><!-- .nav -->
<?php
	if (in_array("t04_angsuran", explode(",", $t03_pinjaman->getCurrentDetailTable())) && $t04_angsuran->DetailView) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "t04_angsuran") {
			$FirstActiveDetailTable = "t04_angsuran";
		}
?>
		<li<?php echo $t03_pinjaman_view->DetailPages->TabStyle("t04_angsuran") ?>><a href="#tab_t04_angsuran" data-toggle="tab"><?php echo $Language->TablePhrase("t04_angsuran", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("t05_pinjamanjaminan", explode(",", $t03_pinjaman->getCurrentDetailTable())) && $t05_pinjamanjaminan->DetailView) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "t05_pinjamanjaminan") {
			$FirstActiveDetailTable = "t05_pinjamanjaminan";
		}
?>
		<li<?php echo $t03_pinjaman_view->DetailPages->TabStyle("t05_pinjamanjaminan") ?>><a href="#tab_t05_pinjamanjaminan" data-toggle="tab"><?php echo $Language->TablePhrase("t05_pinjamanjaminan", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("t06_pinjamantitipan", explode(",", $t03_pinjaman->getCurrentDetailTable())) && $t06_pinjamantitipan->DetailView) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "t06_pinjamantitipan") {
			$FirstActiveDetailTable = "t06_pinjamantitipan";
		}
?>
		<li<?php echo $t03_pinjaman_view->DetailPages->TabStyle("t06_pinjamantitipan") ?>><a href="#tab_t06_pinjamantitipan" data-toggle="tab"><?php echo $Language->TablePhrase("t06_pinjamantitipan", "TblCaption") ?></a></li>
<?php
	}
?>
	</ul><!-- /.nav -->
	<div class="tab-content"><!-- .tab-content -->
<?php
	if (in_array("t04_angsuran", explode(",", $t03_pinjaman->getCurrentDetailTable())) && $t04_angsuran->DetailView) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "t04_angsuran") {
			$FirstActiveDetailTable = "t04_angsuran";
		}
?>
		<div class="tab-pane<?php echo $t03_pinjaman_view->DetailPages->PageStyle("t04_angsuran") ?>" id="tab_t04_angsuran"><!-- page* -->
<?php include_once "t04_angsurangrid.php" ?>
		</div><!-- /page* -->
<?php } ?>
<?php
	if (in_array("t05_pinjamanjaminan", explode(",", $t03_pinjaman->getCurrentDetailTable())) && $t05_pinjamanjaminan->DetailView) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "t05_pinjamanjaminan") {
			$FirstActiveDetailTable = "t05_pinjamanjaminan";
		}
?>
		<div class="tab-pane<?php echo $t03_pinjaman_view->DetailPages->PageStyle("t05_pinjamanjaminan") ?>" id="tab_t05_pinjamanjaminan"><!-- page* -->
<?php include_once "t05_pinjamanjaminangrid.php" ?>
		</div><!-- /page* -->
<?php } ?>
<?php
	if (in_array("t06_pinjamantitipan", explode(",", $t03_pinjaman->getCurrentDetailTable())) && $t06_pinjamantitipan->DetailView) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "t06_pinjamantitipan") {
			$FirstActiveDetailTable = "t06_pinjamantitipan";
		}
?>
		<div class="tab-pane<?php echo $t03_pinjaman_view->DetailPages->PageStyle("t06_pinjamantitipan") ?>" id="tab_t06_pinjamantitipan"><!-- page* -->
<?php include_once "t06_pinjamantitipangrid.php" ?>
		</div><!-- /page* -->
<?php } ?>
	</div><!-- /.tab-content -->
</div><!-- /.nav-tabs-custom -->
</div><!-- /detail-pages -->
<?php } ?>
</form>
<script type="text/javascript">
ft03_pinjamanview.Init();
</script>
<?php
$t03_pinjaman_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t03_pinjaman_view->Page_Terminate();
?>
