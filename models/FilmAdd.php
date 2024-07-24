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
class FilmAdd extends Film
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "FilmAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "filmadd";

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
        $this->film_id->Visible = false;
        $this->_title->setVisibility();
        $this->description->setVisibility();
        $this->release_year->setVisibility();
        $this->language_id->setVisibility();
        $this->original_language_id->setVisibility();
        $this->rental_duration->setVisibility();
        $this->rental_rate->setVisibility();
        $this->length->setVisibility();
        $this->replacement_cost->setVisibility();
        $this->rating->setVisibility();
        $this->special_features->setVisibility();
        $this->last_update->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'film';
        $this->TableName = 'film';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (film)
        if (!isset($GLOBALS["film"]) || $GLOBALS["film"]::class == PROJECT_NAMESPACE . "film") {
            $GLOBALS["film"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'film');
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
                        $result["view"] = SameString($pageName, "filmview"); // If View page, no primary button
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
            $key .= @$ar['film_id'];
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
            $this->film_id->Visible = false;
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
        $this->setupLookupOptions($this->language_id);
        $this->setupLookupOptions($this->original_language_id);
        $this->setupLookupOptions($this->rating);
        $this->setupLookupOptions($this->special_features);

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
            if (($keyValue = Get("film_id") ?? Route("film_id")) !== null) {
                $this->film_id->setQueryStringValue($keyValue);
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
                    $this->terminate("filmlist"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "filmlist") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "filmview") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "filmlist") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "filmlist"; // Return list page content
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
        $this->rental_duration->DefaultValue = $this->rental_duration->getDefault(); // PHP
        $this->rental_duration->OldValue = $this->rental_duration->DefaultValue;
        $this->rental_rate->DefaultValue = $this->rental_rate->getDefault(); // PHP
        $this->rental_rate->OldValue = $this->rental_rate->DefaultValue;
        $this->replacement_cost->DefaultValue = $this->replacement_cost->getDefault(); // PHP
        $this->replacement_cost->OldValue = $this->replacement_cost->DefaultValue;
        $this->rating->DefaultValue = $this->rating->getDefault(); // PHP
        $this->rating->OldValue = $this->rating->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'title' first before field var 'x__title'
        $val = $CurrentForm->hasValue("title") ? $CurrentForm->getValue("title") : $CurrentForm->getValue("x__title");
        if (!$this->_title->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_title->Visible = false; // Disable update for API request
            } else {
                $this->_title->setFormValue($val);
            }
        }

        // Check field name 'description' first before field var 'x_description'
        $val = $CurrentForm->hasValue("description") ? $CurrentForm->getValue("description") : $CurrentForm->getValue("x_description");
        if (!$this->description->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->description->Visible = false; // Disable update for API request
            } else {
                $this->description->setFormValue($val);
            }
        }

        // Check field name 'release_year' first before field var 'x_release_year'
        $val = $CurrentForm->hasValue("release_year") ? $CurrentForm->getValue("release_year") : $CurrentForm->getValue("x_release_year");
        if (!$this->release_year->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->release_year->Visible = false; // Disable update for API request
            } else {
                $this->release_year->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'language_id' first before field var 'x_language_id'
        $val = $CurrentForm->hasValue("language_id") ? $CurrentForm->getValue("language_id") : $CurrentForm->getValue("x_language_id");
        if (!$this->language_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->language_id->Visible = false; // Disable update for API request
            } else {
                $this->language_id->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'original_language_id' first before field var 'x_original_language_id'
        $val = $CurrentForm->hasValue("original_language_id") ? $CurrentForm->getValue("original_language_id") : $CurrentForm->getValue("x_original_language_id");
        if (!$this->original_language_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->original_language_id->Visible = false; // Disable update for API request
            } else {
                $this->original_language_id->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'rental_duration' first before field var 'x_rental_duration'
        $val = $CurrentForm->hasValue("rental_duration") ? $CurrentForm->getValue("rental_duration") : $CurrentForm->getValue("x_rental_duration");
        if (!$this->rental_duration->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->rental_duration->Visible = false; // Disable update for API request
            } else {
                $this->rental_duration->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'rental_rate' first before field var 'x_rental_rate'
        $val = $CurrentForm->hasValue("rental_rate") ? $CurrentForm->getValue("rental_rate") : $CurrentForm->getValue("x_rental_rate");
        if (!$this->rental_rate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->rental_rate->Visible = false; // Disable update for API request
            } else {
                $this->rental_rate->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'length' first before field var 'x_length'
        $val = $CurrentForm->hasValue("length") ? $CurrentForm->getValue("length") : $CurrentForm->getValue("x_length");
        if (!$this->length->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->length->Visible = false; // Disable update for API request
            } else {
                $this->length->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'replacement_cost' first before field var 'x_replacement_cost'
        $val = $CurrentForm->hasValue("replacement_cost") ? $CurrentForm->getValue("replacement_cost") : $CurrentForm->getValue("x_replacement_cost");
        if (!$this->replacement_cost->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->replacement_cost->Visible = false; // Disable update for API request
            } else {
                $this->replacement_cost->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'rating' first before field var 'x_rating'
        $val = $CurrentForm->hasValue("rating") ? $CurrentForm->getValue("rating") : $CurrentForm->getValue("x_rating");
        if (!$this->rating->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->rating->Visible = false; // Disable update for API request
            } else {
                $this->rating->setFormValue($val);
            }
        }

        // Check field name 'special_features' first before field var 'x_special_features'
        $val = $CurrentForm->hasValue("special_features") ? $CurrentForm->getValue("special_features") : $CurrentForm->getValue("x_special_features");
        if (!$this->special_features->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->special_features->Visible = false; // Disable update for API request
            } else {
                $this->special_features->setFormValue($val);
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

        // Check field name 'film_id' first before field var 'x_film_id'
        $val = $CurrentForm->hasValue("film_id") ? $CurrentForm->getValue("film_id") : $CurrentForm->getValue("x_film_id");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->_title->CurrentValue = $this->_title->FormValue;
        $this->description->CurrentValue = $this->description->FormValue;
        $this->release_year->CurrentValue = $this->release_year->FormValue;
        $this->language_id->CurrentValue = $this->language_id->FormValue;
        $this->original_language_id->CurrentValue = $this->original_language_id->FormValue;
        $this->rental_duration->CurrentValue = $this->rental_duration->FormValue;
        $this->rental_rate->CurrentValue = $this->rental_rate->FormValue;
        $this->length->CurrentValue = $this->length->FormValue;
        $this->replacement_cost->CurrentValue = $this->replacement_cost->FormValue;
        $this->rating->CurrentValue = $this->rating->FormValue;
        $this->special_features->CurrentValue = $this->special_features->FormValue;
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
        $this->film_id->setDbValue($row['film_id']);
        $this->_title->setDbValue($row['title']);
        $this->description->setDbValue($row['description']);
        $this->release_year->setDbValue($row['release_year']);
        $this->language_id->setDbValue($row['language_id']);
        $this->original_language_id->setDbValue($row['original_language_id']);
        $this->rental_duration->setDbValue($row['rental_duration']);
        $this->rental_rate->setDbValue($row['rental_rate']);
        $this->length->setDbValue($row['length']);
        $this->replacement_cost->setDbValue($row['replacement_cost']);
        $this->rating->setDbValue($row['rating']);
        $this->special_features->setDbValue($row['special_features']);
        $this->last_update->setDbValue($row['last_update']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['film_id'] = $this->film_id->DefaultValue;
        $row['title'] = $this->_title->DefaultValue;
        $row['description'] = $this->description->DefaultValue;
        $row['release_year'] = $this->release_year->DefaultValue;
        $row['language_id'] = $this->language_id->DefaultValue;
        $row['original_language_id'] = $this->original_language_id->DefaultValue;
        $row['rental_duration'] = $this->rental_duration->DefaultValue;
        $row['rental_rate'] = $this->rental_rate->DefaultValue;
        $row['length'] = $this->length->DefaultValue;
        $row['replacement_cost'] = $this->replacement_cost->DefaultValue;
        $row['rating'] = $this->rating->DefaultValue;
        $row['special_features'] = $this->special_features->DefaultValue;
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

        // film_id
        $this->film_id->RowCssClass = "row";

        // title
        $this->_title->RowCssClass = "row";

        // description
        $this->description->RowCssClass = "row";

        // release_year
        $this->release_year->RowCssClass = "row";

        // language_id
        $this->language_id->RowCssClass = "row";

        // original_language_id
        $this->original_language_id->RowCssClass = "row";

        // rental_duration
        $this->rental_duration->RowCssClass = "row";

        // rental_rate
        $this->rental_rate->RowCssClass = "row";

        // length
        $this->length->RowCssClass = "row";

        // replacement_cost
        $this->replacement_cost->RowCssClass = "row";

        // rating
        $this->rating->RowCssClass = "row";

        // special_features
        $this->special_features->RowCssClass = "row";

        // last_update
        $this->last_update->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // film_id
            $this->film_id->ViewValue = $this->film_id->CurrentValue;

            // title
            $this->_title->ViewValue = $this->_title->CurrentValue;

            // description
            $this->description->ViewValue = $this->description->CurrentValue;

            // release_year
            $this->release_year->ViewValue = $this->release_year->CurrentValue;

            // language_id
            $this->language_id->ViewValue = $this->language_id->CurrentValue;
            $curVal = strval($this->language_id->CurrentValue);
            if ($curVal != "") {
                $this->language_id->ViewValue = $this->language_id->lookupCacheOption($curVal);
                if ($this->language_id->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->language_id->Lookup->getTable()->Fields["language_id"]->searchExpression(), "=", $curVal, $this->language_id->Lookup->getTable()->Fields["language_id"]->searchDataType(), "");
                    $sqlWrk = $this->language_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->language_id->Lookup->renderViewRow($rswrk[0]);
                        $this->language_id->ViewValue = $this->language_id->displayValue($arwrk);
                    } else {
                        $this->language_id->ViewValue = FormatNumber($this->language_id->CurrentValue, $this->language_id->formatPattern());
                    }
                }
            } else {
                $this->language_id->ViewValue = null;
            }

            // original_language_id
            $this->original_language_id->ViewValue = $this->original_language_id->CurrentValue;
            $curVal = strval($this->original_language_id->CurrentValue);
            if ($curVal != "") {
                $this->original_language_id->ViewValue = $this->original_language_id->lookupCacheOption($curVal);
                if ($this->original_language_id->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->original_language_id->Lookup->getTable()->Fields["language_id"]->searchExpression(), "=", $curVal, $this->original_language_id->Lookup->getTable()->Fields["language_id"]->searchDataType(), "");
                    $sqlWrk = $this->original_language_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->original_language_id->Lookup->renderViewRow($rswrk[0]);
                        $this->original_language_id->ViewValue = $this->original_language_id->displayValue($arwrk);
                    } else {
                        $this->original_language_id->ViewValue = FormatNumber($this->original_language_id->CurrentValue, $this->original_language_id->formatPattern());
                    }
                }
            } else {
                $this->original_language_id->ViewValue = null;
            }

            // rental_duration
            $this->rental_duration->ViewValue = $this->rental_duration->CurrentValue;
            $this->rental_duration->ViewValue = FormatNumber($this->rental_duration->ViewValue, $this->rental_duration->formatPattern());

            // rental_rate
            $this->rental_rate->ViewValue = $this->rental_rate->CurrentValue;
            $this->rental_rate->ViewValue = FormatNumber($this->rental_rate->ViewValue, $this->rental_rate->formatPattern());

            // length
            $this->length->ViewValue = $this->length->CurrentValue;
            $this->length->ViewValue = FormatNumber($this->length->ViewValue, $this->length->formatPattern());

            // replacement_cost
            $this->replacement_cost->ViewValue = $this->replacement_cost->CurrentValue;
            $this->replacement_cost->ViewValue = FormatNumber($this->replacement_cost->ViewValue, $this->replacement_cost->formatPattern());

            // rating
            if (strval($this->rating->CurrentValue) != "") {
                $this->rating->ViewValue = $this->rating->optionCaption($this->rating->CurrentValue);
            } else {
                $this->rating->ViewValue = null;
            }

            // special_features
            if (strval($this->special_features->CurrentValue) != "") {
                $this->special_features->ViewValue = new OptionValues();
                $arwrk = explode(Config("MULTIPLE_OPTION_SEPARATOR"), strval($this->special_features->CurrentValue));
                $cnt = count($arwrk);
                for ($ari = 0; $ari < $cnt; $ari++)
                    $this->special_features->ViewValue->add($this->special_features->optionCaption(trim($arwrk[$ari])));
            } else {
                $this->special_features->ViewValue = null;
            }

            // last_update
            $this->last_update->ViewValue = $this->last_update->CurrentValue;
            $this->last_update->ViewValue = FormatDateTime($this->last_update->ViewValue, $this->last_update->formatPattern());

            // title
            $this->_title->HrefValue = "";

            // description
            $this->description->HrefValue = "";

            // release_year
            $this->release_year->HrefValue = "";

            // language_id
            $this->language_id->HrefValue = "";

            // original_language_id
            $this->original_language_id->HrefValue = "";

            // rental_duration
            $this->rental_duration->HrefValue = "";

            // rental_rate
            $this->rental_rate->HrefValue = "";

            // length
            $this->length->HrefValue = "";

            // replacement_cost
            $this->replacement_cost->HrefValue = "";

            // rating
            $this->rating->HrefValue = "";

            // special_features
            $this->special_features->HrefValue = "";

            // last_update
            $this->last_update->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // title
            $this->_title->setupEditAttributes();
            if (!$this->_title->Raw) {
                $this->_title->CurrentValue = HtmlDecode($this->_title->CurrentValue);
            }
            $this->_title->EditValue = HtmlEncode($this->_title->CurrentValue);
            $this->_title->PlaceHolder = RemoveHtml($this->_title->caption());

            // description
            $this->description->setupEditAttributes();
            if (!$this->description->Raw) {
                $this->description->CurrentValue = HtmlDecode($this->description->CurrentValue);
            }
            $this->description->EditValue = HtmlEncode($this->description->CurrentValue);
            $this->description->PlaceHolder = RemoveHtml($this->description->caption());

            // release_year
            $this->release_year->setupEditAttributes();
            $this->release_year->EditValue = $this->release_year->CurrentValue;
            $this->release_year->PlaceHolder = RemoveHtml($this->release_year->caption());
            if (strval($this->release_year->EditValue) != "" && is_numeric($this->release_year->EditValue)) {
                $this->release_year->EditValue = $this->release_year->EditValue;
            }

            // language_id
            $this->language_id->setupEditAttributes();
            $this->language_id->EditValue = $this->language_id->CurrentValue;
            $curVal = strval($this->language_id->CurrentValue);
            if ($curVal != "") {
                $this->language_id->EditValue = $this->language_id->lookupCacheOption($curVal);
                if ($this->language_id->EditValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->language_id->Lookup->getTable()->Fields["language_id"]->searchExpression(), "=", $curVal, $this->language_id->Lookup->getTable()->Fields["language_id"]->searchDataType(), "");
                    $sqlWrk = $this->language_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->language_id->Lookup->renderViewRow($rswrk[0]);
                        $this->language_id->EditValue = $this->language_id->displayValue($arwrk);
                    } else {
                        $this->language_id->EditValue = HtmlEncode(FormatNumber($this->language_id->CurrentValue, $this->language_id->formatPattern()));
                    }
                }
            } else {
                $this->language_id->EditValue = null;
            }
            $this->language_id->PlaceHolder = RemoveHtml($this->language_id->caption());

            // original_language_id
            $this->original_language_id->setupEditAttributes();
            $this->original_language_id->EditValue = $this->original_language_id->CurrentValue;
            $curVal = strval($this->original_language_id->CurrentValue);
            if ($curVal != "") {
                $this->original_language_id->EditValue = $this->original_language_id->lookupCacheOption($curVal);
                if ($this->original_language_id->EditValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->original_language_id->Lookup->getTable()->Fields["language_id"]->searchExpression(), "=", $curVal, $this->original_language_id->Lookup->getTable()->Fields["language_id"]->searchDataType(), "");
                    $sqlWrk = $this->original_language_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->original_language_id->Lookup->renderViewRow($rswrk[0]);
                        $this->original_language_id->EditValue = $this->original_language_id->displayValue($arwrk);
                    } else {
                        $this->original_language_id->EditValue = HtmlEncode(FormatNumber($this->original_language_id->CurrentValue, $this->original_language_id->formatPattern()));
                    }
                }
            } else {
                $this->original_language_id->EditValue = null;
            }
            $this->original_language_id->PlaceHolder = RemoveHtml($this->original_language_id->caption());

            // rental_duration
            $this->rental_duration->setupEditAttributes();
            $this->rental_duration->EditValue = $this->rental_duration->CurrentValue;
            $this->rental_duration->PlaceHolder = RemoveHtml($this->rental_duration->caption());
            if (strval($this->rental_duration->EditValue) != "" && is_numeric($this->rental_duration->EditValue)) {
                $this->rental_duration->EditValue = FormatNumber($this->rental_duration->EditValue, null);
            }

            // rental_rate
            $this->rental_rate->setupEditAttributes();
            $this->rental_rate->EditValue = $this->rental_rate->CurrentValue;
            $this->rental_rate->PlaceHolder = RemoveHtml($this->rental_rate->caption());
            if (strval($this->rental_rate->EditValue) != "" && is_numeric($this->rental_rate->EditValue)) {
                $this->rental_rate->EditValue = FormatNumber($this->rental_rate->EditValue, null);
            }

            // length
            $this->length->setupEditAttributes();
            $this->length->EditValue = $this->length->CurrentValue;
            $this->length->PlaceHolder = RemoveHtml($this->length->caption());
            if (strval($this->length->EditValue) != "" && is_numeric($this->length->EditValue)) {
                $this->length->EditValue = FormatNumber($this->length->EditValue, null);
            }

            // replacement_cost
            $this->replacement_cost->setupEditAttributes();
            $this->replacement_cost->EditValue = $this->replacement_cost->CurrentValue;
            $this->replacement_cost->PlaceHolder = RemoveHtml($this->replacement_cost->caption());
            if (strval($this->replacement_cost->EditValue) != "" && is_numeric($this->replacement_cost->EditValue)) {
                $this->replacement_cost->EditValue = FormatNumber($this->replacement_cost->EditValue, null);
            }

            // rating
            $this->rating->EditValue = $this->rating->options(false);
            $this->rating->PlaceHolder = RemoveHtml($this->rating->caption());

            // special_features
            $this->special_features->EditValue = $this->special_features->options(false);
            $this->special_features->PlaceHolder = RemoveHtml($this->special_features->caption());

            // last_update
            $this->last_update->setupEditAttributes();
            $this->last_update->EditValue = HtmlEncode(FormatDateTime($this->last_update->CurrentValue, $this->last_update->formatPattern()));
            $this->last_update->PlaceHolder = RemoveHtml($this->last_update->caption());

            // Add refer script

            // title
            $this->_title->HrefValue = "";

            // description
            $this->description->HrefValue = "";

            // release_year
            $this->release_year->HrefValue = "";

            // language_id
            $this->language_id->HrefValue = "";

            // original_language_id
            $this->original_language_id->HrefValue = "";

            // rental_duration
            $this->rental_duration->HrefValue = "";

            // rental_rate
            $this->rental_rate->HrefValue = "";

            // length
            $this->length->HrefValue = "";

            // replacement_cost
            $this->replacement_cost->HrefValue = "";

            // rating
            $this->rating->HrefValue = "";

            // special_features
            $this->special_features->HrefValue = "";

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
            if ($this->_title->Visible && $this->_title->Required) {
                if (!$this->_title->IsDetailKey && EmptyValue($this->_title->FormValue)) {
                    $this->_title->addErrorMessage(str_replace("%s", $this->_title->caption(), $this->_title->RequiredErrorMessage));
                }
            }
            if ($this->description->Visible && $this->description->Required) {
                if (!$this->description->IsDetailKey && EmptyValue($this->description->FormValue)) {
                    $this->description->addErrorMessage(str_replace("%s", $this->description->caption(), $this->description->RequiredErrorMessage));
                }
            }
            if ($this->release_year->Visible && $this->release_year->Required) {
                if (!$this->release_year->IsDetailKey && EmptyValue($this->release_year->FormValue)) {
                    $this->release_year->addErrorMessage(str_replace("%s", $this->release_year->caption(), $this->release_year->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->release_year->FormValue)) {
                $this->release_year->addErrorMessage($this->release_year->getErrorMessage(false));
            }
            if ($this->language_id->Visible && $this->language_id->Required) {
                if (!$this->language_id->IsDetailKey && EmptyValue($this->language_id->FormValue)) {
                    $this->language_id->addErrorMessage(str_replace("%s", $this->language_id->caption(), $this->language_id->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->language_id->FormValue)) {
                $this->language_id->addErrorMessage($this->language_id->getErrorMessage(false));
            }
            if ($this->original_language_id->Visible && $this->original_language_id->Required) {
                if (!$this->original_language_id->IsDetailKey && EmptyValue($this->original_language_id->FormValue)) {
                    $this->original_language_id->addErrorMessage(str_replace("%s", $this->original_language_id->caption(), $this->original_language_id->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->original_language_id->FormValue)) {
                $this->original_language_id->addErrorMessage($this->original_language_id->getErrorMessage(false));
            }
            if ($this->rental_duration->Visible && $this->rental_duration->Required) {
                if (!$this->rental_duration->IsDetailKey && EmptyValue($this->rental_duration->FormValue)) {
                    $this->rental_duration->addErrorMessage(str_replace("%s", $this->rental_duration->caption(), $this->rental_duration->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->rental_duration->FormValue)) {
                $this->rental_duration->addErrorMessage($this->rental_duration->getErrorMessage(false));
            }
            if ($this->rental_rate->Visible && $this->rental_rate->Required) {
                if (!$this->rental_rate->IsDetailKey && EmptyValue($this->rental_rate->FormValue)) {
                    $this->rental_rate->addErrorMessage(str_replace("%s", $this->rental_rate->caption(), $this->rental_rate->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->rental_rate->FormValue)) {
                $this->rental_rate->addErrorMessage($this->rental_rate->getErrorMessage(false));
            }
            if ($this->length->Visible && $this->length->Required) {
                if (!$this->length->IsDetailKey && EmptyValue($this->length->FormValue)) {
                    $this->length->addErrorMessage(str_replace("%s", $this->length->caption(), $this->length->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->length->FormValue)) {
                $this->length->addErrorMessage($this->length->getErrorMessage(false));
            }
            if ($this->replacement_cost->Visible && $this->replacement_cost->Required) {
                if (!$this->replacement_cost->IsDetailKey && EmptyValue($this->replacement_cost->FormValue)) {
                    $this->replacement_cost->addErrorMessage(str_replace("%s", $this->replacement_cost->caption(), $this->replacement_cost->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->replacement_cost->FormValue)) {
                $this->replacement_cost->addErrorMessage($this->replacement_cost->getErrorMessage(false));
            }
            if ($this->rating->Visible && $this->rating->Required) {
                if ($this->rating->FormValue == "") {
                    $this->rating->addErrorMessage(str_replace("%s", $this->rating->caption(), $this->rating->RequiredErrorMessage));
                }
            }
            if ($this->special_features->Visible && $this->special_features->Required) {
                if ($this->special_features->FormValue == "") {
                    $this->special_features->addErrorMessage(str_replace("%s", $this->special_features->caption(), $this->special_features->RequiredErrorMessage));
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

        // title
        $this->_title->setDbValueDef($rsnew, $this->_title->CurrentValue, false);

        // description
        $this->description->setDbValueDef($rsnew, $this->description->CurrentValue, false);

        // release_year
        $this->release_year->setDbValueDef($rsnew, $this->release_year->CurrentValue, false);

        // language_id
        $this->language_id->setDbValueDef($rsnew, $this->language_id->CurrentValue, false);

        // original_language_id
        $this->original_language_id->setDbValueDef($rsnew, $this->original_language_id->CurrentValue, false);

        // rental_duration
        $this->rental_duration->setDbValueDef($rsnew, $this->rental_duration->CurrentValue, strval($this->rental_duration->CurrentValue) == "");

        // rental_rate
        $this->rental_rate->setDbValueDef($rsnew, $this->rental_rate->CurrentValue, strval($this->rental_rate->CurrentValue) == "");

        // length
        $this->length->setDbValueDef($rsnew, $this->length->CurrentValue, false);

        // replacement_cost
        $this->replacement_cost->setDbValueDef($rsnew, $this->replacement_cost->CurrentValue, strval($this->replacement_cost->CurrentValue) == "");

        // rating
        $this->rating->setDbValueDef($rsnew, $this->rating->CurrentValue, strval($this->rating->CurrentValue) == "");

        // special_features
        $this->special_features->setDbValueDef($rsnew, $this->special_features->CurrentValue, false);

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
        if (isset($row['title'])) { // title
            $this->_title->setFormValue($row['title']);
        }
        if (isset($row['description'])) { // description
            $this->description->setFormValue($row['description']);
        }
        if (isset($row['release_year'])) { // release_year
            $this->release_year->setFormValue($row['release_year']);
        }
        if (isset($row['language_id'])) { // language_id
            $this->language_id->setFormValue($row['language_id']);
        }
        if (isset($row['original_language_id'])) { // original_language_id
            $this->original_language_id->setFormValue($row['original_language_id']);
        }
        if (isset($row['rental_duration'])) { // rental_duration
            $this->rental_duration->setFormValue($row['rental_duration']);
        }
        if (isset($row['rental_rate'])) { // rental_rate
            $this->rental_rate->setFormValue($row['rental_rate']);
        }
        if (isset($row['length'])) { // length
            $this->length->setFormValue($row['length']);
        }
        if (isset($row['replacement_cost'])) { // replacement_cost
            $this->replacement_cost->setFormValue($row['replacement_cost']);
        }
        if (isset($row['rating'])) { // rating
            $this->rating->setFormValue($row['rating']);
        }
        if (isset($row['special_features'])) { // special_features
            $this->special_features->setFormValue($row['special_features']);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("filmlist"), "", $this->TableVar, true);
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
                case "x_language_id":
                    break;
                case "x_original_language_id":
                    break;
                case "x_rating":
                    break;
                case "x_special_features":
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
