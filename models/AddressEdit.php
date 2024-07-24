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
class AddressEdit extends Address
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "AddressEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "addressedit";

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
        $this->address_id->setVisibility();
        $this->address->setVisibility();
        $this->address2->setVisibility();
        $this->district->setVisibility();
        $this->city_id->setVisibility();
        $this->postal_code->setVisibility();
        $this->phone->setVisibility();
        $this->location->setVisibility();
        $this->last_update->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'address';
        $this->TableName = 'address';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (address)
        if (!isset($GLOBALS["address"]) || $GLOBALS["address"]::class == PROJECT_NAMESPACE . "address") {
            $GLOBALS["address"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'address');
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
                        $result["view"] = SameString($pageName, "addressview"); // If View page, no primary button
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
            $key .= @$ar['address_id'];
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
            $this->address_id->Visible = false;
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

    // Properties
    public $FormClassName = "ew-form ew-edit-form overlay-wrapper";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $HashValue; // Hash Value
    public $DisplayRecords = 1;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecordCount;

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
        $this->setupLookupOptions($this->city_id);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("address_id") ?? Key(0) ?? Route(2)) !== null) {
                $this->address_id->setQueryStringValue($keyValue);
                $this->address_id->setOldValue($this->address_id->QueryStringValue);
            } elseif (Post("address_id") !== null) {
                $this->address_id->setFormValue(Post("address_id"));
                $this->address_id->setOldValue($this->address_id->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action", "") !== "") {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey(Post($this->OldKeyName), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("address_id") ?? Route("address_id")) !== null) {
                    $this->address_id->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->address_id->CurrentValue = null;
                }
            }

            // Load result set
            if ($this->isShow()) {
                    // Load current record
                    $loaded = $this->loadRow();
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values

            // Overwrite record, reload hash value
            if ($this->isOverwrite()) {
                $this->loadRowHash();
                $this->CurrentAction = "confirm";
            }
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("addresslist"); // No matching record, return to list
                        return;
                    }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "addresslist") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "addresslist") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "addresslist"; // Return list page content
                        }
                    }
                    if (IsJsonResponse()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
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
                } elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        if ($this->isConfirm()) { // Confirm page
            $this->RowType = RowType::VIEW; // Render as View
        } else {
            $this->RowType = RowType::EDIT; // Render as Edit
        }
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

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'address_id' first before field var 'x_address_id'
        $val = $CurrentForm->hasValue("address_id") ? $CurrentForm->getValue("address_id") : $CurrentForm->getValue("x_address_id");
        if (!$this->address_id->IsDetailKey) {
            $this->address_id->setFormValue($val);
        }

        // Check field name 'address' first before field var 'x_address'
        $val = $CurrentForm->hasValue("address") ? $CurrentForm->getValue("address") : $CurrentForm->getValue("x_address");
        if (!$this->address->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->address->Visible = false; // Disable update for API request
            } else {
                $this->address->setFormValue($val);
            }
        }

        // Check field name 'address2' first before field var 'x_address2'
        $val = $CurrentForm->hasValue("address2") ? $CurrentForm->getValue("address2") : $CurrentForm->getValue("x_address2");
        if (!$this->address2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->address2->Visible = false; // Disable update for API request
            } else {
                $this->address2->setFormValue($val);
            }
        }

        // Check field name 'district' first before field var 'x_district'
        $val = $CurrentForm->hasValue("district") ? $CurrentForm->getValue("district") : $CurrentForm->getValue("x_district");
        if (!$this->district->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->district->Visible = false; // Disable update for API request
            } else {
                $this->district->setFormValue($val);
            }
        }

        // Check field name 'city_id' first before field var 'x_city_id'
        $val = $CurrentForm->hasValue("city_id") ? $CurrentForm->getValue("city_id") : $CurrentForm->getValue("x_city_id");
        if (!$this->city_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->city_id->Visible = false; // Disable update for API request
            } else {
                $this->city_id->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'postal_code' first before field var 'x_postal_code'
        $val = $CurrentForm->hasValue("postal_code") ? $CurrentForm->getValue("postal_code") : $CurrentForm->getValue("x_postal_code");
        if (!$this->postal_code->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->postal_code->Visible = false; // Disable update for API request
            } else {
                $this->postal_code->setFormValue($val);
            }
        }

        // Check field name 'phone' first before field var 'x_phone'
        $val = $CurrentForm->hasValue("phone") ? $CurrentForm->getValue("phone") : $CurrentForm->getValue("x_phone");
        if (!$this->phone->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->phone->Visible = false; // Disable update for API request
            } else {
                $this->phone->setFormValue($val);
            }
        }

        // Check field name 'location' first before field var 'x_location'
        $val = $CurrentForm->hasValue("location") ? $CurrentForm->getValue("location") : $CurrentForm->getValue("x_location");
        if (!$this->location->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->location->Visible = false; // Disable update for API request
            } else {
                $this->location->setFormValue($val);
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
        if (!$this->isOverwrite()) {
            $this->HashValue = $CurrentForm->getValue("k_hash");
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->address_id->CurrentValue = $this->address_id->FormValue;
        $this->address->CurrentValue = $this->address->FormValue;
        $this->address2->CurrentValue = $this->address2->FormValue;
        $this->district->CurrentValue = $this->district->FormValue;
        $this->city_id->CurrentValue = $this->city_id->FormValue;
        $this->postal_code->CurrentValue = $this->postal_code->FormValue;
        $this->phone->CurrentValue = $this->phone->FormValue;
        $this->location->CurrentValue = $this->location->FormValue;
        $this->last_update->CurrentValue = $this->last_update->FormValue;
        $this->last_update->CurrentValue = UnFormatDateTime($this->last_update->CurrentValue, $this->last_update->formatPattern());
        if (!$this->isOverwrite()) {
            $this->HashValue = $CurrentForm->getValue("k_hash");
        }
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
            if (!$this->EventCancelled) {
                $this->HashValue = $this->getRowHash($row); // Get hash value for record
            }
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
        $this->address_id->setDbValue($row['address_id']);
        $this->address->setDbValue($row['address']);
        $this->address2->setDbValue($row['address2']);
        $this->district->setDbValue($row['district']);
        $this->city_id->setDbValue($row['city_id']);
        $this->postal_code->setDbValue($row['postal_code']);
        $this->phone->setDbValue($row['phone']);
        $this->location->setDbValue($row['location']);
        $this->last_update->setDbValue($row['last_update']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['address_id'] = $this->address_id->DefaultValue;
        $row['address'] = $this->address->DefaultValue;
        $row['address2'] = $this->address2->DefaultValue;
        $row['district'] = $this->district->DefaultValue;
        $row['city_id'] = $this->city_id->DefaultValue;
        $row['postal_code'] = $this->postal_code->DefaultValue;
        $row['phone'] = $this->phone->DefaultValue;
        $row['location'] = $this->location->DefaultValue;
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

        // address_id
        $this->address_id->RowCssClass = "row";

        // address
        $this->address->RowCssClass = "row";

        // address2
        $this->address2->RowCssClass = "row";

        // district
        $this->district->RowCssClass = "row";

        // city_id
        $this->city_id->RowCssClass = "row";

        // postal_code
        $this->postal_code->RowCssClass = "row";

        // phone
        $this->phone->RowCssClass = "row";

        // location
        $this->location->RowCssClass = "row";

        // last_update
        $this->last_update->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // address_id
            $this->address_id->ViewValue = $this->address_id->CurrentValue;

            // address
            $this->address->ViewValue = $this->address->CurrentValue;

            // address2
            $this->address2->ViewValue = $this->address2->CurrentValue;

            // district
            $this->district->ViewValue = $this->district->CurrentValue;

            // city_id
            $this->city_id->ViewValue = $this->city_id->CurrentValue;
            $curVal = strval($this->city_id->CurrentValue);
            if ($curVal != "") {
                $this->city_id->ViewValue = $this->city_id->lookupCacheOption($curVal);
                if ($this->city_id->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->city_id->Lookup->getTable()->Fields["city_id"]->searchExpression(), "=", $curVal, $this->city_id->Lookup->getTable()->Fields["city_id"]->searchDataType(), "");
                    $sqlWrk = $this->city_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->city_id->Lookup->renderViewRow($rswrk[0]);
                        $this->city_id->ViewValue = $this->city_id->displayValue($arwrk);
                    } else {
                        $this->city_id->ViewValue = FormatNumber($this->city_id->CurrentValue, $this->city_id->formatPattern());
                    }
                }
            } else {
                $this->city_id->ViewValue = null;
            }

            // postal_code
            $this->postal_code->ViewValue = $this->postal_code->CurrentValue;

            // phone
            $this->phone->ViewValue = $this->phone->CurrentValue;

            // location
            $this->location->ViewValue = $this->location->CurrentValue;

            // last_update
            $this->last_update->ViewValue = $this->last_update->CurrentValue;
            $this->last_update->ViewValue = FormatDateTime($this->last_update->ViewValue, $this->last_update->formatPattern());

            // address_id
            $this->address_id->HrefValue = "";

            // address
            $this->address->HrefValue = "";

            // address2
            $this->address2->HrefValue = "";

            // district
            $this->district->HrefValue = "";

            // city_id
            $this->city_id->HrefValue = "";

            // postal_code
            $this->postal_code->HrefValue = "";

            // phone
            $this->phone->HrefValue = "";

            // location
            $this->location->HrefValue = "";

            // last_update
            $this->last_update->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // address_id
            $this->address_id->setupEditAttributes();
            $this->address_id->EditValue = $this->address_id->CurrentValue;

            // address
            $this->address->setupEditAttributes();
            if (!$this->address->Raw) {
                $this->address->CurrentValue = HtmlDecode($this->address->CurrentValue);
            }
            $this->address->EditValue = HtmlEncode($this->address->CurrentValue);
            $this->address->PlaceHolder = RemoveHtml($this->address->caption());

            // address2
            $this->address2->setupEditAttributes();
            if (!$this->address2->Raw) {
                $this->address2->CurrentValue = HtmlDecode($this->address2->CurrentValue);
            }
            $this->address2->EditValue = HtmlEncode($this->address2->CurrentValue);
            $this->address2->PlaceHolder = RemoveHtml($this->address2->caption());

            // district
            $this->district->setupEditAttributes();
            if (!$this->district->Raw) {
                $this->district->CurrentValue = HtmlDecode($this->district->CurrentValue);
            }
            $this->district->EditValue = HtmlEncode($this->district->CurrentValue);
            $this->district->PlaceHolder = RemoveHtml($this->district->caption());

            // city_id
            $this->city_id->setupEditAttributes();
            $this->city_id->EditValue = $this->city_id->CurrentValue;
            $curVal = strval($this->city_id->CurrentValue);
            if ($curVal != "") {
                $this->city_id->EditValue = $this->city_id->lookupCacheOption($curVal);
                if ($this->city_id->EditValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->city_id->Lookup->getTable()->Fields["city_id"]->searchExpression(), "=", $curVal, $this->city_id->Lookup->getTable()->Fields["city_id"]->searchDataType(), "");
                    $sqlWrk = $this->city_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->city_id->Lookup->renderViewRow($rswrk[0]);
                        $this->city_id->EditValue = $this->city_id->displayValue($arwrk);
                    } else {
                        $this->city_id->EditValue = HtmlEncode(FormatNumber($this->city_id->CurrentValue, $this->city_id->formatPattern()));
                    }
                }
            } else {
                $this->city_id->EditValue = null;
            }
            $this->city_id->PlaceHolder = RemoveHtml($this->city_id->caption());

            // postal_code
            $this->postal_code->setupEditAttributes();
            if (!$this->postal_code->Raw) {
                $this->postal_code->CurrentValue = HtmlDecode($this->postal_code->CurrentValue);
            }
            $this->postal_code->EditValue = HtmlEncode($this->postal_code->CurrentValue);
            $this->postal_code->PlaceHolder = RemoveHtml($this->postal_code->caption());

            // phone
            $this->phone->setupEditAttributes();
            if (!$this->phone->Raw) {
                $this->phone->CurrentValue = HtmlDecode($this->phone->CurrentValue);
            }
            $this->phone->EditValue = HtmlEncode($this->phone->CurrentValue);
            $this->phone->PlaceHolder = RemoveHtml($this->phone->caption());

            // location
            $this->location->setupEditAttributes();
            if (!$this->location->Raw) {
                $this->location->CurrentValue = HtmlDecode($this->location->CurrentValue);
            }
            $this->location->EditValue = HtmlEncode($this->location->CurrentValue);
            $this->location->PlaceHolder = RemoveHtml($this->location->caption());

            // last_update
            $this->last_update->setupEditAttributes();
            $this->last_update->EditValue = HtmlEncode(FormatDateTime($this->last_update->CurrentValue, $this->last_update->formatPattern()));
            $this->last_update->PlaceHolder = RemoveHtml($this->last_update->caption());

            // Edit refer script

            // address_id
            $this->address_id->HrefValue = "";

            // address
            $this->address->HrefValue = "";

            // address2
            $this->address2->HrefValue = "";

            // district
            $this->district->HrefValue = "";

            // city_id
            $this->city_id->HrefValue = "";

            // postal_code
            $this->postal_code->HrefValue = "";

            // phone
            $this->phone->HrefValue = "";

            // location
            $this->location->HrefValue = "";

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
            if ($this->address_id->Visible && $this->address_id->Required) {
                if (!$this->address_id->IsDetailKey && EmptyValue($this->address_id->FormValue)) {
                    $this->address_id->addErrorMessage(str_replace("%s", $this->address_id->caption(), $this->address_id->RequiredErrorMessage));
                }
            }
            if ($this->address->Visible && $this->address->Required) {
                if (!$this->address->IsDetailKey && EmptyValue($this->address->FormValue)) {
                    $this->address->addErrorMessage(str_replace("%s", $this->address->caption(), $this->address->RequiredErrorMessage));
                }
            }
            if ($this->address2->Visible && $this->address2->Required) {
                if (!$this->address2->IsDetailKey && EmptyValue($this->address2->FormValue)) {
                    $this->address2->addErrorMessage(str_replace("%s", $this->address2->caption(), $this->address2->RequiredErrorMessage));
                }
            }
            if ($this->district->Visible && $this->district->Required) {
                if (!$this->district->IsDetailKey && EmptyValue($this->district->FormValue)) {
                    $this->district->addErrorMessage(str_replace("%s", $this->district->caption(), $this->district->RequiredErrorMessage));
                }
            }
            if ($this->city_id->Visible && $this->city_id->Required) {
                if (!$this->city_id->IsDetailKey && EmptyValue($this->city_id->FormValue)) {
                    $this->city_id->addErrorMessage(str_replace("%s", $this->city_id->caption(), $this->city_id->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->city_id->FormValue)) {
                $this->city_id->addErrorMessage($this->city_id->getErrorMessage(false));
            }
            if ($this->postal_code->Visible && $this->postal_code->Required) {
                if (!$this->postal_code->IsDetailKey && EmptyValue($this->postal_code->FormValue)) {
                    $this->postal_code->addErrorMessage(str_replace("%s", $this->postal_code->caption(), $this->postal_code->RequiredErrorMessage));
                }
            }
            if ($this->phone->Visible && $this->phone->Required) {
                if (!$this->phone->IsDetailKey && EmptyValue($this->phone->FormValue)) {
                    $this->phone->addErrorMessage(str_replace("%s", $this->phone->caption(), $this->phone->RequiredErrorMessage));
                }
            }
            if ($this->location->Visible && $this->location->Required) {
                if (!$this->location->IsDetailKey && EmptyValue($this->location->FormValue)) {
                    $this->location->addErrorMessage(str_replace("%s", $this->location->caption(), $this->location->RequiredErrorMessage));
                }
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

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();

        // Load old row
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssociative($sql);
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            return false; // Update Failed
        } else {
            // Load old values
            $this->loadDbValues($rsold);
        }

        // Get new row
        $rsnew = $this->getEditRow($rsold);

        // Update current values
        $this->setCurrentValues($rsnew);

        // Check hash value
        $rowHasConflict = (!IsApi() && $this->getRowHash($rsold) != $this->HashValue);

        // Call Row Update Conflict event
        if ($rowHasConflict) {
            $rowHasConflict = $this->rowUpdateConflict($rsold, $rsnew);
        }
        if ($rowHasConflict) {
            $this->setFailureMessage($Language->phrase("RecordChangedByOtherUser"));
            $this->UpdateConflict = "U";
            return false; // Update Failed
        }

        // Call Row Updating event
        $updateRow = $this->rowUpdating($rsold, $rsnew);
        if ($updateRow) {
            if (count($rsnew) > 0) {
                $this->CurrentFilter = $filter; // Set up current filter
                $editRow = $this->update($rsnew, "", $rsold);
                if (!$editRow && !EmptyValue($this->DbErrorMessage)) { // Show database error
                    $this->setFailureMessage($this->DbErrorMessage);
                }
            } else {
                $editRow = true; // No field to update
            }
            if ($editRow) {
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("UpdateCancelled"));
            }
            $editRow = false;
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($rsold, $rsnew);
        }

        // Write JSON response
        if (IsJsonResponse() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            $table = $this->TableVar;
            WriteJson(["success" => true, "action" => Config("API_EDIT_ACTION"), $table => $row]);
        }
        return $editRow;
    }

    /**
     * Get edit row
     *
     * @return array
     */
    protected function getEditRow($rsold)
    {
        global $Security;
        $rsnew = [];

        // address
        $this->address->setDbValueDef($rsnew, $this->address->CurrentValue, $this->address->ReadOnly);

        // address2
        $this->address2->setDbValueDef($rsnew, $this->address2->CurrentValue, $this->address2->ReadOnly);

        // district
        $this->district->setDbValueDef($rsnew, $this->district->CurrentValue, $this->district->ReadOnly);

        // city_id
        $this->city_id->setDbValueDef($rsnew, $this->city_id->CurrentValue, $this->city_id->ReadOnly);

        // postal_code
        $this->postal_code->setDbValueDef($rsnew, $this->postal_code->CurrentValue, $this->postal_code->ReadOnly);

        // phone
        $this->phone->setDbValueDef($rsnew, $this->phone->CurrentValue, $this->phone->ReadOnly);

        // location
        $this->location->setDbValueDef($rsnew, $this->location->CurrentValue, $this->location->ReadOnly);

        // last_update
        $this->last_update->setDbValueDef($rsnew, UnFormatDateTime($this->last_update->CurrentValue, $this->last_update->formatPattern()), $this->last_update->ReadOnly);
        return $rsnew;
    }

    /**
     * Restore edit form from row
     * @param array $row Row
     */
    protected function restoreEditFormFromRow($row)
    {
        if (isset($row['address'])) { // address
            $this->address->CurrentValue = $row['address'];
        }
        if (isset($row['address2'])) { // address2
            $this->address2->CurrentValue = $row['address2'];
        }
        if (isset($row['district'])) { // district
            $this->district->CurrentValue = $row['district'];
        }
        if (isset($row['city_id'])) { // city_id
            $this->city_id->CurrentValue = $row['city_id'];
        }
        if (isset($row['postal_code'])) { // postal_code
            $this->postal_code->CurrentValue = $row['postal_code'];
        }
        if (isset($row['phone'])) { // phone
            $this->phone->CurrentValue = $row['phone'];
        }
        if (isset($row['location'])) { // location
            $this->location->CurrentValue = $row['location'];
        }
        if (isset($row['last_update'])) { // last_update
            $this->last_update->CurrentValue = $row['last_update'];
        }
    }

    // Load row hash
    protected function loadRowHash()
    {
        $filter = $this->getRecordFilter();

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $row = $conn->fetchAssociative($sql);
        $this->HashValue = $row ? $this->getRowHash($row) : ""; // Get hash value for record
    }

    // Get Row Hash
    public function getRowHash($row)
    {
        if (!$row) {
            return "";
        }
        $hash = "";
        $hash .= GetFieldHash($row['address']); // address
        $hash .= GetFieldHash($row['address2']); // address2
        $hash .= GetFieldHash($row['district']); // district
        $hash .= GetFieldHash($row['city_id']); // city_id
        $hash .= GetFieldHash($row['postal_code']); // postal_code
        $hash .= GetFieldHash($row['phone']); // phone
        $hash .= GetFieldHash($row['location']); // location
        $hash .= GetFieldHash($row['last_update']); // last_update
        return md5($hash);
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("addresslist"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
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
                case "x_city_id":
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

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        $pageNo = Get(Config("TABLE_PAGE_NUMBER"));
        $startRec = Get(Config("TABLE_START_REC"));
        $infiniteScroll = false;
        $recordNo = $pageNo ?? $startRec; // Record number = page number or start record
        if ($recordNo !== null && is_numeric($recordNo)) {
            $this->StartRecord = $recordNo;
        } else {
            $this->StartRecord = $this->getStartRecordNumber();
        }

        // Check if correct start record counter
        if (!is_numeric($this->StartRecord) || intval($this->StartRecord) <= 0) { // Avoid invalid start record counter
            $this->StartRecord = 1; // Reset start record counter
        } elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
            $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
        } elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
            $this->StartRecord = (int)(($this->StartRecord - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
        }
        if (!$infiniteScroll) {
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Get page count
    public function pageCount() {
        return ceil($this->TotalRecords / $this->DisplayRecords);
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
