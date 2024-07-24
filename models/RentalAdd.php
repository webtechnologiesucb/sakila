<?php

namespace PHPMaker2024\Sakila;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use Slim\Routing\RouteCollectorProxy;
use Slim\App;
use Closure;

/**
 * Page class
 */
class RentalAdd extends Rental
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "RentalAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "rentaladd";

    // Audit Trail
    public $AuditTrailOnAdd = true;
    public $AuditTrailOnEdit = true;
    public $AuditTrailOnDelete = true;
    public $AuditTrailOnView = false;
    public $AuditTrailOnViewData = false;
    public $AuditTrailOnSearch = false;

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page layout
    public $UseLayout = true;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl($withArgs = true)
    {
        $route = GetRoute();
        $args = RemoveXss($route->getArguments());
        if (!$withArgs) {
            foreach ($args as $key => &$val) {
                $val = "";
            }
            unset($val);
        }
        return rtrim(UrlFor($route->getName(), $args), "/") . "?";
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<div id="ew-page-header">' . $header . '</div>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<div id="ew-page-footer">' . $footer . '</div>';
        }
    }

    // Set field visibility
    public function setVisibility()
    {
        $this->rental_id->Visible = false;
        $this->rental_date->setVisibility();
        $this->inventory_id->setVisibility();
        $this->customer_id->setVisibility();
        $this->return_date->setVisibility();
        $this->staff_id->setVisibility();
        $this->last_update->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'rental';
        $this->TableName = 'rental';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (rental)
        if (!isset($GLOBALS["rental"]) || $GLOBALS["rental"]::class == PROJECT_NAMESPACE . "rental") {
            $GLOBALS["rental"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'rental');
        }

        // Start timer
        $DebugTimer = Container("debug.timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] ??= $this->getConnection();

        // User table object
        $UserTable = Container("usertable");
    }

    // Get content from stream
    public function getContents(): string
    {
        global $Response;
        return $Response?->getBody() ?? ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;

        // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }
        DispatchEvent(new PageUnloadedEvent($this), PageUnloadedEvent::NAME);
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show response for API
                $ar = array_merge($this->getMessages(), $url ? ["url" => GetUrl($url)] : []);
                WriteJson($ar);
            }
            $this->clearMessages(); // Clear messages for API request
            return;
        } else { // Check if response is JSON
            if (WithJsonResponse()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $pageName = GetPageName($url);
                $result = ["url" => GetUrl($url), "modal" => "1"];  // Assume return to modal for simplicity
                if (
                    SameString($pageName, GetPageName($this->getListUrl())) ||
                    SameString($pageName, GetPageName($this->getViewUrl())) ||
                    SameString($pageName, GetPageName(CurrentMasterTable()?->getViewUrl() ?? ""))
                ) { // List / View / Master View page
                    if (!SameString($pageName, GetPageName($this->getListUrl()))) { // Not List page
                        $result["caption"] = $this->getModalCaption($pageName);
                        $result["view"] = SameString($pageName, "rentalview"); // If View page, no primary button
                    } else { // List page
                        $result["error"] = $this->getFailureMessage(); // List page should not be shown as modal => error
                        $this->clearFailureMessage();
                    }
                } else { // Other pages (add messages and then clear messages)
                    $result = array_merge($this->getMessages(), ["modal" => "1"]);
                    $this->clearMessages();
                }
                WriteJson($result);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
        }
        return; // Return to controller
    }

    // Get records from result set
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Result set
            while ($row = $rs->fetch()) {
                $this->loadRowValues($row); // Set up DbValue/CurrentValue
                $row = $this->getRecordFromArray($row);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DataType::BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['rental_id'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->rental_id->Visible = false;
        }
    }

    // Lookup data
    public function lookup(array $req = [], bool $response = true)
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = $req["field"] ?? null;
        if (!$fieldName) {
            return [];
        }
        $fld = $this->Fields[$fieldName];
        $lookup = $fld->Lookup;
        $name = $req["name"] ?? "";
        if (ContainsString($name, "query_builder_rule")) {
            $lookup->FilterFields = []; // Skip parent fields if any
        }

        // Get lookup parameters
        $lookupType = $req["ajax"] ?? "unknown";
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal") || SameText($lookupType, "filter")) {
            $searchValue = $req["q"] ?? $req["sv"] ?? "";
            $pageSize = $req["n"] ?? $req["recperpage"] ?? 10;
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = $req["q"] ?? "";
            $pageSize = $req["n"] ?? -1;
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
        }
        $start = $req["start"] ?? -1;
        $start = is_numeric($start) ? (int)$start : -1;
        $page = $req["page"] ?? -1;
        $page = is_numeric($page) ? (int)$page : -1;
        $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        $userSelect = Decrypt($req["s"] ?? "");
        $userFilter = Decrypt($req["f"] ?? "");
        $userOrderBy = Decrypt($req["o"] ?? "");
        $keys = $req["keys"] ?? null;
        $lookup->LookupType = $lookupType; // Lookup type
        $lookup->FilterValues = []; // Clear filter values first
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = $req["v0"] ?? $req["lookupValue"] ?? "";
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = $req["v" . $i] ?? "";
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        return $lookup->toJson($this, $response); // Use settings from current page
    }
    public $FormClassName = "ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $CopyRecord;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $Language, $Security, $CurrentForm, $SkipHeaderFooter;

        // Is modal
        $this->IsModal = ConvertToBool(Param("modal"));
        $this->UseLayout = $this->UseLayout && !$this->IsModal;

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param(Config("PAGE_LAYOUT"), true));

        // View
        $this->View = Get(Config("VIEW"));

        // Load user profile
        if (IsLoggedIn()) {
            Profile()->setUserName(CurrentUserName())->loadFromStorage();
        }

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
        $this->setVisibility();

        // Set lookup cache
        if (!in_array($this->PageID, Config("LOOKUP_CACHE_PAGE_IDS"))) {
            $this->setUseLookupCache(false);
        }

        // Global Page Loading event (in userfn*.php)
        DispatchEvent(new PageLoadingEvent($this), PageLoadingEvent::NAME);

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Hide fields for add/edit
        if (!$this->UseAjaxActions) {
            $this->hideFieldsForAddEdit();
        }
        // Use inline delete
        if ($this->UseAjaxActions) {
            $this->InlineDelete = true;
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->inventory_id);
        $this->setupLookupOptions($this->customer_id);
        $this->setupLookupOptions($this->staff_id);

        // Load default values for add
        $this->loadDefaultValues();

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $postBack = false;

        // Set up current action
        if (IsApi()) {
            $this->CurrentAction = "insert"; // Add record directly
            $postBack = true;
        } elseif (Post("action", "") !== "") {
            $this->CurrentAction = Post("action"); // Get form action
            $this->setKey(Post($this->OldKeyName));
            $postBack = true;
        } else {
            // Load key values from QueryString
            if (($keyValue = Get("rental_id") ?? Route("rental_id")) !== null) {
                $this->rental_id->setQueryStringValue($keyValue);
            }
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $this->CopyRecord = !EmptyValue($this->OldKey);
            if ($this->CopyRecord) {
                $this->CurrentAction = "copy"; // Copy record
                $this->setKey($this->OldKey); // Set up record key
            } else {
                $this->CurrentAction = "show"; // Display blank record
            }
        }

        // Load old record or default values
        $rsold = $this->loadOldRecord();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues(); // Restore form values
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "copy": // Copy an existing record
                if (!$rsold) { // Record not loaded
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("rentallist"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($rsold)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->getReturnUrl();
                    if (GetPageName($returnUrl) == "rentallist") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "rentalview") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "rentallist") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "rentallist"; // Return list page content
                        }
                    }
                    if (IsJsonResponse()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl);
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->IsModal && $this->UseAjaxActions) { // Return JSON error message
                    WriteJson(["success" => false, "validation" => $this->getValidationErrors(), "error" => $this->getFailureMessage()]);
                    $this->clearFailureMessage();
                    $this->terminate();
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Add failed, restore form values
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render row based on row type
        if ($this->isConfirm()) { // Confirm page
            $this->RowType = RowType::VIEW; // Render view type
        } else {
            $this->RowType = RowType::ADD; // Render add type
        }

        // Render row
        $this->resetAttributes();
        $this->renderRow();

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            DispatchEvent(new PageRenderingEvent($this), PageRenderingEvent::NAME);

            // Page Render event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }

            // Render search option
            if (method_exists($this, "renderSearchOptions")) {
                $this->renderSearchOptions();
            }
        }
    }

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load default values
    protected function loadDefaultValues()
    {
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'rental_date' first before field var 'x_rental_date'
        $val = $CurrentForm->hasValue("rental_date") ? $CurrentForm->getValue("rental_date") : $CurrentForm->getValue("x_rental_date");
        if (!$this->rental_date->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->rental_date->Visible = false; // Disable update for API request
            } else {
                $this->rental_date->setFormValue($val, true, $validate);
            }
            $this->rental_date->CurrentValue = UnFormatDateTime($this->rental_date->CurrentValue, $this->rental_date->formatPattern());
        }

        // Check field name 'inventory_id' first before field var 'x_inventory_id'
        $val = $CurrentForm->hasValue("inventory_id") ? $CurrentForm->getValue("inventory_id") : $CurrentForm->getValue("x_inventory_id");
        if (!$this->inventory_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->inventory_id->Visible = false; // Disable update for API request
            } else {
                $this->inventory_id->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'customer_id' first before field var 'x_customer_id'
        $val = $CurrentForm->hasValue("customer_id") ? $CurrentForm->getValue("customer_id") : $CurrentForm->getValue("x_customer_id");
        if (!$this->customer_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->customer_id->Visible = false; // Disable update for API request
            } else {
                $this->customer_id->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'return_date' first before field var 'x_return_date'
        $val = $CurrentForm->hasValue("return_date") ? $CurrentForm->getValue("return_date") : $CurrentForm->getValue("x_return_date");
        if (!$this->return_date->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->return_date->Visible = false; // Disable update for API request
            } else {
                $this->return_date->setFormValue($val, true, $validate);
            }
            $this->return_date->CurrentValue = UnFormatDateTime($this->return_date->CurrentValue, $this->return_date->formatPattern());
        }

        // Check field name 'staff_id' first before field var 'x_staff_id'
        $val = $CurrentForm->hasValue("staff_id") ? $CurrentForm->getValue("staff_id") : $CurrentForm->getValue("x_staff_id");
        if (!$this->staff_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->staff_id->Visible = false; // Disable update for API request
            } else {
                $this->staff_id->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'last_update' first before field var 'x_last_update'
        $val = $CurrentForm->hasValue("last_update") ? $CurrentForm->getValue("last_update") : $CurrentForm->getValue("x_last_update");
        if (!$this->last_update->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->last_update->Visible = false; // Disable update for API request
            } else {
                $this->last_update->setFormValue($val, true, $validate);
            }
            $this->last_update->CurrentValue = UnFormatDateTime($this->last_update->CurrentValue, $this->last_update->formatPattern());
        }

        // Check field name 'rental_id' first before field var 'x_rental_id'
        $val = $CurrentForm->hasValue("rental_id") ? $CurrentForm->getValue("rental_id") : $CurrentForm->getValue("x_rental_id");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->rental_date->CurrentValue = $this->rental_date->FormValue;
        $this->rental_date->CurrentValue = UnFormatDateTime($this->rental_date->CurrentValue, $this->rental_date->formatPattern());
        $this->inventory_id->CurrentValue = $this->inventory_id->FormValue;
        $this->customer_id->CurrentValue = $this->customer_id->FormValue;
        $this->return_date->CurrentValue = $this->return_date->FormValue;
        $this->return_date->CurrentValue = UnFormatDateTime($this->return_date->CurrentValue, $this->return_date->formatPattern());
        $this->staff_id->CurrentValue = $this->staff_id->FormValue;
        $this->last_update->CurrentValue = $this->last_update->FormValue;
        $this->last_update->CurrentValue = UnFormatDateTime($this->last_update->CurrentValue, $this->last_update->formatPattern());
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssociative($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }
        return $res;
    }

    /**
     * Load row values from result set or record
     *
     * @param array $row Record
     * @return void
     */
    public function loadRowValues($row = null)
    {
        $row = is_array($row) ? $row : $this->newRow();

        // Call Row Selected event
        $this->rowSelected($row);
        $this->rental_id->setDbValue($row['rental_id']);
        $this->rental_date->setDbValue($row['rental_date']);
        $this->inventory_id->setDbValue($row['inventory_id']);
        $this->customer_id->setDbValue($row['customer_id']);
        $this->return_date->setDbValue($row['return_date']);
        $this->staff_id->setDbValue($row['staff_id']);
        $this->last_update->setDbValue($row['last_update']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['rental_id'] = $this->rental_id->DefaultValue;
        $row['rental_date'] = $this->rental_date->DefaultValue;
        $row['inventory_id'] = $this->inventory_id->DefaultValue;
        $row['customer_id'] = $this->customer_id->DefaultValue;
        $row['return_date'] = $this->return_date->DefaultValue;
        $row['staff_id'] = $this->staff_id->DefaultValue;
        $row['last_update'] = $this->last_update->DefaultValue;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
        // Load old record
        if ($this->OldKey != "") {
            $this->setKey($this->OldKey);
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $rs = ExecuteQuery($sql, $conn);
            if ($row = $rs->fetch()) {
                $this->loadRowValues($row); // Load row values
                return $row;
            }
        }
        $this->loadRowValues(); // Load default row values
        return null;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // rental_id
        $this->rental_id->RowCssClass = "row";

        // rental_date
        $this->rental_date->RowCssClass = "row";

        // inventory_id
        $this->inventory_id->RowCssClass = "row";

        // customer_id
        $this->customer_id->RowCssClass = "row";

        // return_date
        $this->return_date->RowCssClass = "row";

        // staff_id
        $this->staff_id->RowCssClass = "row";

        // last_update
        $this->last_update->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // rental_id
            $this->rental_id->ViewValue = $this->rental_id->CurrentValue;

            // rental_date
            $this->rental_date->ViewValue = $this->rental_date->CurrentValue;
            $this->rental_date->ViewValue = FormatDateTime($this->rental_date->ViewValue, $this->rental_date->formatPattern());

            // inventory_id
            $this->inventory_id->ViewValue = $this->inventory_id->CurrentValue;
            $curVal = strval($this->inventory_id->CurrentValue);
            if ($curVal != "") {
                $this->inventory_id->ViewValue = $this->inventory_id->lookupCacheOption($curVal);
                if ($this->inventory_id->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->inventory_id->Lookup->getTable()->Fields["inventory_id"]->searchExpression(), "=", $curVal, $this->inventory_id->Lookup->getTable()->Fields["inventory_id"]->searchDataType(), "");
                    $sqlWrk = $this->inventory_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->inventory_id->Lookup->renderViewRow($rswrk[0]);
                        $this->inventory_id->ViewValue = $this->inventory_id->displayValue($arwrk);
                    } else {
                        $this->inventory_id->ViewValue = FormatNumber($this->inventory_id->CurrentValue, $this->inventory_id->formatPattern());
                    }
                }
            } else {
                $this->inventory_id->ViewValue = null;
            }

            // customer_id
            $this->customer_id->ViewValue = $this->customer_id->CurrentValue;
            $curVal = strval($this->customer_id->CurrentValue);
            if ($curVal != "") {
                $this->customer_id->ViewValue = $this->customer_id->lookupCacheOption($curVal);
                if ($this->customer_id->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->customer_id->Lookup->getTable()->Fields["customer_id"]->searchExpression(), "=", $curVal, $this->customer_id->Lookup->getTable()->Fields["customer_id"]->searchDataType(), "");
                    $sqlWrk = $this->customer_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->customer_id->Lookup->renderViewRow($rswrk[0]);
                        $this->customer_id->ViewValue = $this->customer_id->displayValue($arwrk);
                    } else {
                        $this->customer_id->ViewValue = FormatNumber($this->customer_id->CurrentValue, $this->customer_id->formatPattern());
                    }
                }
            } else {
                $this->customer_id->ViewValue = null;
            }

            // return_date
            $this->return_date->ViewValue = $this->return_date->CurrentValue;
            $this->return_date->ViewValue = FormatDateTime($this->return_date->ViewValue, $this->return_date->formatPattern());

            // staff_id
            $this->staff_id->ViewValue = $this->staff_id->CurrentValue;
            $curVal = strval($this->staff_id->CurrentValue);
            if ($curVal != "") {
                $this->staff_id->ViewValue = $this->staff_id->lookupCacheOption($curVal);
                if ($this->staff_id->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->staff_id->Lookup->getTable()->Fields["staff_id"]->searchExpression(), "=", $curVal, $this->staff_id->Lookup->getTable()->Fields["staff_id"]->searchDataType(), "");
                    $sqlWrk = $this->staff_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->staff_id->Lookup->renderViewRow($rswrk[0]);
                        $this->staff_id->ViewValue = $this->staff_id->displayValue($arwrk);
                    } else {
                        $this->staff_id->ViewValue = FormatNumber($this->staff_id->CurrentValue, $this->staff_id->formatPattern());
                    }
                }
            } else {
                $this->staff_id->ViewValue = null;
            }

            // last_update
            $this->last_update->ViewValue = $this->last_update->CurrentValue;
            $this->last_update->ViewValue = FormatDateTime($this->last_update->ViewValue, $this->last_update->formatPattern());

            // rental_date
            $this->rental_date->HrefValue = "";

            // inventory_id
            $this->inventory_id->HrefValue = "";

            // customer_id
            $this->customer_id->HrefValue = "";

            // return_date
            $this->return_date->HrefValue = "";

            // staff_id
            $this->staff_id->HrefValue = "";

            // last_update
            $this->last_update->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // rental_date
            $this->rental_date->setupEditAttributes();
            $this->rental_date->EditValue = HtmlEncode(FormatDateTime($this->rental_date->CurrentValue, $this->rental_date->formatPattern()));
            $this->rental_date->PlaceHolder = RemoveHtml($this->rental_date->caption());

            // inventory_id
            $this->inventory_id->setupEditAttributes();
            $this->inventory_id->EditValue = $this->inventory_id->CurrentValue;
            $curVal = strval($this->inventory_id->CurrentValue);
            if ($curVal != "") {
                $this->inventory_id->EditValue = $this->inventory_id->lookupCacheOption($curVal);
                if ($this->inventory_id->EditValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->inventory_id->Lookup->getTable()->Fields["inventory_id"]->searchExpression(), "=", $curVal, $this->inventory_id->Lookup->getTable()->Fields["inventory_id"]->searchDataType(), "");
                    $sqlWrk = $this->inventory_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->inventory_id->Lookup->renderViewRow($rswrk[0]);
                        $this->inventory_id->EditValue = $this->inventory_id->displayValue($arwrk);
                    } else {
                        $this->inventory_id->EditValue = HtmlEncode(FormatNumber($this->inventory_id->CurrentValue, $this->inventory_id->formatPattern()));
                    }
                }
            } else {
                $this->inventory_id->EditValue = null;
            }
            $this->inventory_id->PlaceHolder = RemoveHtml($this->inventory_id->caption());

            // customer_id
            $this->customer_id->setupEditAttributes();
            $this->customer_id->EditValue = $this->customer_id->CurrentValue;
            $curVal = strval($this->customer_id->CurrentValue);
            if ($curVal != "") {
                $this->customer_id->EditValue = $this->customer_id->lookupCacheOption($curVal);
                if ($this->customer_id->EditValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->customer_id->Lookup->getTable()->Fields["customer_id"]->searchExpression(), "=", $curVal, $this->customer_id->Lookup->getTable()->Fields["customer_id"]->searchDataType(), "");
                    $sqlWrk = $this->customer_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->customer_id->Lookup->renderViewRow($rswrk[0]);
                        $this->customer_id->EditValue = $this->customer_id->displayValue($arwrk);
                    } else {
                        $this->customer_id->EditValue = HtmlEncode(FormatNumber($this->customer_id->CurrentValue, $this->customer_id->formatPattern()));
                    }
                }
            } else {
                $this->customer_id->EditValue = null;
            }
            $this->customer_id->PlaceHolder = RemoveHtml($this->customer_id->caption());

            // return_date
            $this->return_date->setupEditAttributes();
            $this->return_date->EditValue = HtmlEncode(FormatDateTime($this->return_date->CurrentValue, $this->return_date->formatPattern()));
            $this->return_date->PlaceHolder = RemoveHtml($this->return_date->caption());

            // staff_id
            $this->staff_id->setupEditAttributes();
            $this->staff_id->EditValue = $this->staff_id->CurrentValue;
            $curVal = strval($this->staff_id->CurrentValue);
            if ($curVal != "") {
                $this->staff_id->EditValue = $this->staff_id->lookupCacheOption($curVal);
                if ($this->staff_id->EditValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->staff_id->Lookup->getTable()->Fields["staff_id"]->searchExpression(), "=", $curVal, $this->staff_id->Lookup->getTable()->Fields["staff_id"]->searchDataType(), "");
                    $sqlWrk = $this->staff_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->staff_id->Lookup->renderViewRow($rswrk[0]);
                        $this->staff_id->EditValue = $this->staff_id->displayValue($arwrk);
                    } else {
                        $this->staff_id->EditValue = HtmlEncode(FormatNumber($this->staff_id->CurrentValue, $this->staff_id->formatPattern()));
                    }
                }
            } else {
                $this->staff_id->EditValue = null;
            }
            $this->staff_id->PlaceHolder = RemoveHtml($this->staff_id->caption());

            // last_update
            $this->last_update->setupEditAttributes();
            $this->last_update->EditValue = HtmlEncode(FormatDateTime($this->last_update->CurrentValue, $this->last_update->formatPattern()));
            $this->last_update->PlaceHolder = RemoveHtml($this->last_update->caption());

            // Add refer script

            // rental_date
            $this->rental_date->HrefValue = "";

            // inventory_id
            $this->inventory_id->HrefValue = "";

            // customer_id
            $this->customer_id->HrefValue = "";

            // return_date
            $this->return_date->HrefValue = "";

            // staff_id
            $this->staff_id->HrefValue = "";

            // last_update
            $this->last_update->HrefValue = "";
        }
        if ($this->RowType == RowType::ADD || $this->RowType == RowType::EDIT || $this->RowType == RowType::SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != RowType::AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate form
    protected function validateForm()
    {
        global $Language, $Security;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        $validateForm = true;
            if ($this->rental_date->Visible && $this->rental_date->Required) {
                if (!$this->rental_date->IsDetailKey && EmptyValue($this->rental_date->FormValue)) {
                    $this->rental_date->addErrorMessage(str_replace("%s", $this->rental_date->caption(), $this->rental_date->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->rental_date->FormValue, $this->rental_date->formatPattern())) {
                $this->rental_date->addErrorMessage($this->rental_date->getErrorMessage(false));
            }
            if ($this->inventory_id->Visible && $this->inventory_id->Required) {
                if (!$this->inventory_id->IsDetailKey && EmptyValue($this->inventory_id->FormValue)) {
                    $this->inventory_id->addErrorMessage(str_replace("%s", $this->inventory_id->caption(), $this->inventory_id->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->inventory_id->FormValue)) {
                $this->inventory_id->addErrorMessage($this->inventory_id->getErrorMessage(false));
            }
            if ($this->customer_id->Visible && $this->customer_id->Required) {
                if (!$this->customer_id->IsDetailKey && EmptyValue($this->customer_id->FormValue)) {
                    $this->customer_id->addErrorMessage(str_replace("%s", $this->customer_id->caption(), $this->customer_id->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->customer_id->FormValue)) {
                $this->customer_id->addErrorMessage($this->customer_id->getErrorMessage(false));
            }
            if ($this->return_date->Visible && $this->return_date->Required) {
                if (!$this->return_date->IsDetailKey && EmptyValue($this->return_date->FormValue)) {
                    $this->return_date->addErrorMessage(str_replace("%s", $this->return_date->caption(), $this->return_date->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->return_date->FormValue, $this->return_date->formatPattern())) {
                $this->return_date->addErrorMessage($this->return_date->getErrorMessage(false));
            }
            if ($this->staff_id->Visible && $this->staff_id->Required) {
                if (!$this->staff_id->IsDetailKey && EmptyValue($this->staff_id->FormValue)) {
                    $this->staff_id->addErrorMessage(str_replace("%s", $this->staff_id->caption(), $this->staff_id->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->staff_id->FormValue)) {
                $this->staff_id->addErrorMessage($this->staff_id->getErrorMessage(false));
            }
            if ($this->last_update->Visible && $this->last_update->Required) {
                if (!$this->last_update->IsDetailKey && EmptyValue($this->last_update->FormValue)) {
                    $this->last_update->addErrorMessage(str_replace("%s", $this->last_update->caption(), $this->last_update->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->last_update->FormValue, $this->last_update->formatPattern())) {
                $this->last_update->addErrorMessage($this->last_update->getErrorMessage(false));
            }

        // Return validate result
        $validateForm = $validateForm && !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Get new row
        $rsnew = $this->getAddRow();

        // Update current values
        $this->setCurrentValues($rsnew);
        $conn = $this->getConnection();

        // Load db values from old row
        $this->loadDbValues($rsold);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        if ($insertRow) {
            $addRow = $this->insert($rsnew);
            if ($addRow) {
            } elseif (!EmptyValue($this->DbErrorMessage)) { // Show database error
                $this->setFailureMessage($this->DbErrorMessage);
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("InsertCancelled"));
            }
            $addRow = false;
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }

        // Write JSON response
        if (IsJsonResponse() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            $table = $this->TableVar;
            WriteJson(["success" => true, "action" => Config("API_ADD_ACTION"), $table => $row]);
        }
        return $addRow;
    }

    /**
     * Get add row
     *
     * @return array
     */
    protected function getAddRow()
    {
        global $Security;
        $rsnew = [];

        // rental_date
        $this->rental_date->setDbValueDef($rsnew, UnFormatDateTime($this->rental_date->CurrentValue, $this->rental_date->formatPattern()), false);

        // inventory_id
        $this->inventory_id->setDbValueDef($rsnew, $this->inventory_id->CurrentValue, false);

        // customer_id
        $this->customer_id->setDbValueDef($rsnew, $this->customer_id->CurrentValue, false);

        // return_date
        $this->return_date->setDbValueDef($rsnew, UnFormatDateTime($this->return_date->CurrentValue, $this->return_date->formatPattern()), false);

        // staff_id
        $this->staff_id->setDbValueDef($rsnew, $this->staff_id->CurrentValue, false);

        // last_update
        $this->last_update->setDbValueDef($rsnew, UnFormatDateTime($this->last_update->CurrentValue, $this->last_update->formatPattern()), false);
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['rental_date'])) { // rental_date
            $this->rental_date->setFormValue($row['rental_date']);
        }
        if (isset($row['inventory_id'])) { // inventory_id
            $this->inventory_id->setFormValue($row['inventory_id']);
        }
        if (isset($row['customer_id'])) { // customer_id
            $this->customer_id->setFormValue($row['customer_id']);
        }
        if (isset($row['return_date'])) { // return_date
            $this->return_date->setFormValue($row['return_date']);
        }
        if (isset($row['staff_id'])) { // staff_id
            $this->staff_id->setFormValue($row['staff_id']);
        }
        if (isset($row['last_update'])) { // last_update
            $this->last_update->setFormValue($row['last_update']);
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("rentallist"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                case "x_inventory_id":
                    break;
                case "x_customer_id":
                    break;
                case "x_staff_id":
                    break;
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if (!$fld->hasLookupOptions() && $fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0 && count($fld->Lookup->FilterFields) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll();
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row, Container($fld->Lookup->LinkTable));
                    $key = $row["lf"];
                    if (IsFloatType($fld->Type)) { // Handle float field
                        $key = (float)$key;
                    }
                    $ar[strval($key)] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
        if ($type == "success") {
            //$msg = "your success message";
        } elseif ($type == "failure") {
            //$msg = "your failure message";
        } elseif ($type == "warning") {
            //$msg = "your warning message";
        } else {
            //$msg = "your message";
        }
    }

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }

    // Page Breaking event
    public function pageBreaking(&$break, &$content)
    {
        // Example:
        //$break = false; // Skip page break, or
        //$content = "<div style=\"break-after:page;\"></div>"; // Modify page break content
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in $customError
        return true;
    }
}
