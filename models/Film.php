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
 * Table class for film
 */
class Film extends DbTable
{
    protected $SqlFrom = "";
    protected $SqlSelect = null;
    protected $SqlSelectList = null;
    protected $SqlWhere = "";
    protected $SqlGroupBy = "";
    protected $SqlHaving = "";
    protected $SqlOrderBy = "";
    public $DbErrorMessage = "";
    public $UseSessionForListSql = true;

    // Column CSS classes
    public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
    public $RightColumnClass = "col-sm-10";
    public $OffsetColumnClass = "col-sm-10 offset-sm-2";
    public $TableLeftColumnClass = "w-col-2";

    // Audit trail
    public $AuditTrailOnAdd = true;
    public $AuditTrailOnEdit = true;
    public $AuditTrailOnDelete = true;
    public $AuditTrailOnView = false;
    public $AuditTrailOnViewData = false;
    public $AuditTrailOnSearch = false;

    // Ajax / Modal
    public $UseAjaxActions = false;
    public $ModalSearch = false;
    public $ModalView = true;
    public $ModalAdd = true;
    public $ModalEdit = true;
    public $ModalUpdate = false;
    public $InlineDelete = true;
    public $ModalGridAdd = false;
    public $ModalGridEdit = false;
    public $ModalMultiEdit = false;

    // Fields
    public $film_id;
    public $_title;
    public $description;
    public $release_year;
    public $language_id;
    public $original_language_id;
    public $rental_duration;
    public $rental_rate;
    public $length;
    public $replacement_cost;
    public $rating;
    public $special_features;
    public $last_update;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "film";
        $this->TableName = 'film';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "film";
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)

        // PDF
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)

        // PhpSpreadsheet
        $this->ExportExcelPageOrientation = null; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = null; // Page size (PhpSpreadsheet only)

        // PHPWord
        $this->ExportWordPageOrientation = ""; // Page orientation (PHPWord only)
        $this->ExportWordPageSize = ""; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = false; // Allow detail add
        $this->DetailEdit = false; // Allow detail edit
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UseAjaxActions = $this->UseAjaxActions || Config("USE_AJAX_ACTIONS");
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this);

        // film_id
        $this->film_id = new DbField(
            $this, // Table
            'x_film_id', // Variable name
            'film_id', // Name
            '`film_id`', // Expression
            '`film_id`', // Basic search expression
            18, // Type
            5, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`film_id`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->film_id->InputTextType = "text";
        $this->film_id->Raw = true;
        $this->film_id->IsAutoIncrement = true; // Autoincrement field
        $this->film_id->IsPrimaryKey = true; // Primary key field
        $this->film_id->Nullable = false; // NOT NULL field
        $this->film_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->film_id->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['film_id'] = &$this->film_id;

        // title
        $this->_title = new DbField(
            $this, // Table
            'x__title', // Variable name
            'title', // Name
            '`title`', // Expression
            '`title`', // Basic search expression
            200, // Type
            128, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`title`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->_title->InputTextType = "text";
        $this->_title->Nullable = false; // NOT NULL field
        $this->_title->Required = true; // Required field
        $this->_title->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['title'] = &$this->_title;

        // description
        $this->description = new DbField(
            $this, // Table
            'x_description', // Variable name
            'description', // Name
            '`description`', // Expression
            '`description`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`description`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->description->InputTextType = "text";
        $this->description->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['description'] = &$this->description;

        // release_year
        $this->release_year = new DbField(
            $this, // Table
            'x_release_year', // Variable name
            'release_year', // Name
            '`release_year`', // Expression
            '`release_year`', // Basic search expression
            18, // Type
            4, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`release_year`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->release_year->InputTextType = "text";
        $this->release_year->Raw = true;
        $this->release_year->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->release_year->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['release_year'] = &$this->release_year;

        // language_id
        $this->language_id = new DbField(
            $this, // Table
            'x_language_id', // Variable name
            'language_id', // Name
            '`language_id`', // Expression
            '`language_id`', // Basic search expression
            17, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`language_id`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->language_id->InputTextType = "text";
        $this->language_id->Raw = true;
        $this->language_id->Nullable = false; // NOT NULL field
        $this->language_id->Required = true; // Required field
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->language_id->Lookup = new Lookup($this->language_id, 'language2', false, 'language_id', ["name","","",""], '', '', [], [], [], [], [], [], false, '`name` ASC', '', "`name`");
                break;
            default:
                $this->language_id->Lookup = new Lookup($this->language_id, 'language2', false, 'language_id', ["name","","",""], '', '', [], [], [], [], [], [], false, '`name` ASC', '', "`name`");
                break;
        }
        $this->language_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->language_id->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['language_id'] = &$this->language_id;

        // original_language_id
        $this->original_language_id = new DbField(
            $this, // Table
            'x_original_language_id', // Variable name
            'original_language_id', // Name
            '`original_language_id`', // Expression
            '`original_language_id`', // Basic search expression
            17, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`original_language_id`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->original_language_id->InputTextType = "text";
        $this->original_language_id->Raw = true;
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->original_language_id->Lookup = new Lookup($this->original_language_id, 'language2', false, 'language_id', ["name","","",""], '', '', [], [], [], [], [], [], false, '`name` ASC', '', "`name`");
                break;
            default:
                $this->original_language_id->Lookup = new Lookup($this->original_language_id, 'language2', false, 'language_id', ["name","","",""], '', '', [], [], [], [], [], [], false, '`name` ASC', '', "`name`");
                break;
        }
        $this->original_language_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->original_language_id->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['original_language_id'] = &$this->original_language_id;

        // rental_duration
        $this->rental_duration = new DbField(
            $this, // Table
            'x_rental_duration', // Variable name
            'rental_duration', // Name
            '`rental_duration`', // Expression
            '`rental_duration`', // Basic search expression
            17, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`rental_duration`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->rental_duration->addMethod("getDefault", fn() => 3);
        $this->rental_duration->InputTextType = "text";
        $this->rental_duration->Raw = true;
        $this->rental_duration->Nullable = false; // NOT NULL field
        $this->rental_duration->Required = true; // Required field
        $this->rental_duration->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->rental_duration->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['rental_duration'] = &$this->rental_duration;

        // rental_rate
        $this->rental_rate = new DbField(
            $this, // Table
            'x_rental_rate', // Variable name
            'rental_rate', // Name
            '`rental_rate`', // Expression
            '`rental_rate`', // Basic search expression
            131, // Type
            6, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`rental_rate`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->rental_rate->addMethod("getDefault", fn() => 4.99);
        $this->rental_rate->InputTextType = "text";
        $this->rental_rate->Raw = true;
        $this->rental_rate->Nullable = false; // NOT NULL field
        $this->rental_rate->Required = true; // Required field
        $this->rental_rate->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->rental_rate->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['rental_rate'] = &$this->rental_rate;

        // length
        $this->length = new DbField(
            $this, // Table
            'x_length', // Variable name
            'length', // Name
            '`length`', // Expression
            '`length`', // Basic search expression
            18, // Type
            5, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`length`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->length->InputTextType = "text";
        $this->length->Raw = true;
        $this->length->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->length->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['length'] = &$this->length;

        // replacement_cost
        $this->replacement_cost = new DbField(
            $this, // Table
            'x_replacement_cost', // Variable name
            'replacement_cost', // Name
            '`replacement_cost`', // Expression
            '`replacement_cost`', // Basic search expression
            131, // Type
            7, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`replacement_cost`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->replacement_cost->addMethod("getDefault", fn() => 19.99);
        $this->replacement_cost->InputTextType = "text";
        $this->replacement_cost->Raw = true;
        $this->replacement_cost->Nullable = false; // NOT NULL field
        $this->replacement_cost->Required = true; // Required field
        $this->replacement_cost->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->replacement_cost->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['replacement_cost'] = &$this->replacement_cost;

        // rating
        $this->rating = new DbField(
            $this, // Table
            'x_rating', // Variable name
            'rating', // Name
            '`rating`', // Expression
            '`rating`', // Basic search expression
            200, // Type
            5, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`rating`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->rating->addMethod("getDefault", fn() => "G");
        $this->rating->InputTextType = "text";
        $this->rating->Raw = true;
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->rating->Lookup = new Lookup($this->rating, 'film', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
                break;
            default:
                $this->rating->Lookup = new Lookup($this->rating, 'film', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
                break;
        }
        $this->rating->OptionCount = 5;
        $this->rating->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['rating'] = &$this->rating;

        // special_features
        $this->special_features = new DbField(
            $this, // Table
            'x_special_features', // Variable name
            'special_features', // Name
            '`special_features`', // Expression
            '`special_features`', // Basic search expression
            200, // Type
            54, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`special_features`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'CHECKBOX' // Edit Tag
        );
        $this->special_features->InputTextType = "text";
        $this->special_features->Raw = true;
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->special_features->Lookup = new Lookup($this->special_features, 'film', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
                break;
            default:
                $this->special_features->Lookup = new Lookup($this->special_features, 'film', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
                break;
        }
        $this->special_features->OptionCount = 4;
        $this->special_features->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['special_features'] = &$this->special_features;

        // last_update
        $this->last_update = new DbField(
            $this, // Table
            'x_last_update', // Variable name
            'last_update', // Name
            '`last_update`', // Expression
            CastDateFieldForLike("`last_update`", 0, "DB"), // Basic search expression
            135, // Type
            19, // Size
            0, // Date/Time format
            false, // Is upload field
            '`last_update`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->last_update->InputTextType = "text";
        $this->last_update->Raw = true;
        $this->last_update->Nullable = false; // NOT NULL field
        $this->last_update->Required = true; // Required field
        $this->last_update->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->last_update->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['last_update'] = &$this->last_update;

        // Add Doctrine Cache
        $this->Cache = new \Symfony\Component\Cache\Adapter\ArrayAdapter();
        $this->CacheProfile = new \Doctrine\DBAL\Cache\QueryCacheProfile(0, $this->TableVar);

        // Call Table Load event
        $this->tableLoad();
    }

    // Field Visibility
    public function getFieldVisibility($fldParm)
    {
        global $Security;
        return $this->$fldParm->Visible; // Returns original value
    }

    // Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
    public function setLeftColumnClass($class)
    {
        if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
            $this->LeftColumnClass = $class . " col-form-label ew-label";
            $this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
            $this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
            $this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
        }
    }

    // Single column sort
    public function updateSort(&$fld)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $orderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            $this->setSessionOrderBy($orderBy); // Save to Session
        }
    }

    // Update field sort
    public function updateFieldSort()
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
        $flds = GetSortFields($orderBy);
        foreach ($this->Fields as $field) {
            $fldSort = "";
            foreach ($flds as $fld) {
                if ($fld[0] == $field->Expression || $fld[0] == $field->VirtualExpression) {
                    $fldSort = $fld[1];
                }
            }
            $field->setSort($fldSort);
        }
    }

    // Render X Axis for chart
    public function renderChartXAxis($chartVar, $chartRow)
    {
        return $chartRow;
    }

    // Get FROM clause
    public function getSqlFrom()
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "film";
    }

    // Get FROM clause (for backward compatibility)
    public function sqlFrom()
    {
        return $this->getSqlFrom();
    }

    // Set FROM clause
    public function setSqlFrom($v)
    {
        $this->SqlFrom = $v;
    }

    // Get SELECT clause
    public function getSqlSelect() // Select
    {
        return $this->SqlSelect ?? $this->getQueryBuilder()->select($this->sqlSelectFields());
    }

    // Get list of fields
    private function sqlSelectFields()
    {
        $useFieldNames = false;
        $fieldNames = [];
        $platform = $this->getConnection()->getDatabasePlatform();
        foreach ($this->Fields as $field) {
            $expr = $field->Expression;
            $customExpr = $field->CustomDataType?->convertToPHPValueSQL($expr, $platform) ?? $expr;
            if ($customExpr != $expr) {
                $fieldNames[] = $customExpr . " AS " . QuotedName($field->Name, $this->Dbid);
                $useFieldNames = true;
            } else {
                $fieldNames[] = $expr;
            }
        }
        return $useFieldNames ? implode(", ", $fieldNames) : "*";
    }

    // Get SELECT clause (for backward compatibility)
    public function sqlSelect()
    {
        return $this->getSqlSelect();
    }

    // Set SELECT clause
    public function setSqlSelect($v)
    {
        $this->SqlSelect = $v;
    }

    // Get WHERE clause
    public function getSqlWhere()
    {
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
        $this->DefaultFilter = "";
        AddFilter($where, $this->DefaultFilter);
        return $where;
    }

    // Get WHERE clause (for backward compatibility)
    public function sqlWhere()
    {
        return $this->getSqlWhere();
    }

    // Set WHERE clause
    public function setSqlWhere($v)
    {
        $this->SqlWhere = $v;
    }

    // Get GROUP BY clause
    public function getSqlGroupBy()
    {
        return $this->SqlGroupBy != "" ? $this->SqlGroupBy : "";
    }

    // Get GROUP BY clause (for backward compatibility)
    public function sqlGroupBy()
    {
        return $this->getSqlGroupBy();
    }

    // set GROUP BY clause
    public function setSqlGroupBy($v)
    {
        $this->SqlGroupBy = $v;
    }

    // Get HAVING clause
    public function getSqlHaving() // Having
    {
        return ($this->SqlHaving != "") ? $this->SqlHaving : "";
    }

    // Get HAVING clause (for backward compatibility)
    public function sqlHaving()
    {
        return $this->getSqlHaving();
    }

    // Set HAVING clause
    public function setSqlHaving($v)
    {
        $this->SqlHaving = $v;
    }

    // Get ORDER BY clause
    public function getSqlOrderBy()
    {
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : "";
    }

    // Get ORDER BY clause (for backward compatibility)
    public function sqlOrderBy()
    {
        return $this->getSqlOrderBy();
    }

    // set ORDER BY clause
    public function setSqlOrderBy($v)
    {
        $this->SqlOrderBy = $v;
    }

    // Apply User ID filters
    public function applyUserIDFilters($filter, $id = "")
    {
        return $filter;
    }

    // Check if User ID security allows view all
    public function userIDAllow($id = "")
    {
        $allow = $this->UserIDAllowSecurity;
        switch ($id) {
            case "add":
            case "copy":
            case "gridadd":
            case "register":
            case "addopt":
                return ($allow & Allow::ADD->value) == Allow::ADD->value;
            case "edit":
            case "gridedit":
            case "update":
            case "changepassword":
            case "resetpassword":
                return ($allow & Allow::EDIT->value) == Allow::EDIT->value;
            case "delete":
                return ($allow & Allow::DELETE->value) == Allow::DELETE->value;
            case "view":
                return ($allow & Allow::VIEW->value) == Allow::VIEW->value;
            case "search":
                return ($allow & Allow::SEARCH->value) == Allow::SEARCH->value;
            case "lookup":
                return ($allow & Allow::LOOKUP->value) == Allow::LOOKUP->value;
            default:
                return ($allow & Allow::LIST->value) == Allow::LIST->value;
        }
    }

    /**
     * Get record count
     *
     * @param string|QueryBuilder $sql SQL or QueryBuilder
     * @param mixed $c Connection
     * @return int
     */
    public function getRecordCount($sql, $c = null)
    {
        $cnt = -1;
        $sqlwrk = $sql instanceof QueryBuilder // Query builder
            ? (clone $sql)->resetQueryPart("orderBy")->getSQL()
            : $sql;
        $pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            in_array($this->TableType, ["TABLE", "VIEW", "LINKTABLE"]) &&
            preg_match($pattern, $sqlwrk) &&
            !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sqlwrk) &&
            !preg_match('/^\s*SELECT\s+DISTINCT\s+/i', $sqlwrk) &&
            !preg_match('/\s+ORDER\s+BY\s+/i', $sqlwrk)
        ) {
            $sqlcnt = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sqlwrk);
        } else {
            $sqlcnt = "SELECT COUNT(*) FROM (" . $sqlwrk . ") COUNT_TABLE";
        }
        $conn = $c ?? $this->getConnection();
        $cnt = $conn->fetchOne($sqlcnt);
        if ($cnt !== false) {
            return (int)$cnt;
        }
        // Unable to get count by SELECT COUNT(*), execute the SQL to get record count directly
        $result = $conn->executeQuery($sqlwrk);
        $cnt = $result->rowCount();
        if ($cnt == 0) { // Unable to get record count, count directly
            while ($result->fetch()) {
                $cnt++;
            }
        }
        return $cnt;
    }

    // Get SQL
    public function getSql($where, $orderBy = "")
    {
        return $this->getSqlAsQueryBuilder($where, $orderBy)->getSQL();
    }

    // Get QueryBuilder
    public function getSqlAsQueryBuilder($where, $orderBy = "")
    {
        return $this->buildSelectSql(
            $this->getSqlSelect(),
            $this->getSqlFrom(),
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $where,
            $orderBy
        );
    }

    // Table SQL
    public function getCurrentSql()
    {
        $filter = $this->CurrentFilter;
        $filter = $this->applyUserIDFilters($filter);
        $sort = $this->getSessionOrderBy();
        return $this->getSql($filter, $sort);
    }

    /**
     * Table SQL with List page filter
     *
     * @return QueryBuilder
     */
    public function getListSql()
    {
        $filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->getSqlSelect();
        $from = $this->getSqlFrom();
        $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
        $this->Sort = $sort;
        return $this->buildSelectSql(
            $select,
            $from,
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $filter,
            $sort
        );
    }

    // Get ORDER BY clause
    public function getOrderBy()
    {
        $orderBy = $this->getSqlOrderBy();
        $sort = $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
    }

    // Get record count based on filter (for detail record count in master table pages)
    public function loadRecordCount($filter)
    {
        $origFilter = $this->CurrentFilter;
        $this->CurrentFilter = $filter;
        $this->recordsetSelecting($this->CurrentFilter);
        $isCustomView = $this->TableType == "CUSTOMVIEW";
        $select = $isCustomView ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $isCustomView ? $this->getSqlGroupBy() : "";
        $having = $isCustomView ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
        $cnt = $this->getRecordCount($sql);
        $this->CurrentFilter = $origFilter;
        return $cnt;
    }

    // Get record count (for current List page)
    public function listRecordCount()
    {
        $filter = $this->getSessionWhere();
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $isCustomView = $this->TableType == "CUSTOMVIEW";
        $select = $isCustomView ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $isCustomView ? $this->getSqlGroupBy() : "";
        $having = $isCustomView ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        $cnt = $this->getRecordCount($sql);
        return $cnt;
    }

    /**
     * INSERT statement
     *
     * @param mixed $rs
     * @return QueryBuilder
     */
    public function insertSql(&$rs)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->insert($this->UpdateTable);
        $platform = $this->getConnection()->getDatabasePlatform();
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom) {
                continue;
            }
            $field = $this->Fields[$name];
            $parm = $queryBuilder->createPositionalParameter($value, $field->getParameterType());
            $parm = $field->CustomDataType?->convertToDatabaseValueSQL($parm, $platform) ?? $parm; // Convert database SQL
            $queryBuilder->setValue($field->Expression, $parm);
        }
        return $queryBuilder;
    }

    // Insert
    public function insert(&$rs)
    {
        $conn = $this->getConnection();
        try {
            $queryBuilder = $this->insertSql($rs);
            $result = $queryBuilder->executeStatement();
            $this->DbErrorMessage = "";
        } catch (\Exception $e) {
            $result = false;
            $this->DbErrorMessage = $e->getMessage();
        }
        if ($result) {
            $this->film_id->setDbValue($conn->lastInsertId());
            $rs['film_id'] = $this->film_id->DbValue;
            if ($this->AuditTrailOnAdd) {
                $this->writeAuditTrailOnAdd($rs);
            }
        }
        return $result;
    }

    /**
     * UPDATE statement
     *
     * @param array $rs Data to be updated
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    public function updateSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->update($this->UpdateTable);
        $platform = $this->getConnection()->getDatabasePlatform();
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom || $this->Fields[$name]->IsAutoIncrement) {
                continue;
            }
            $field = $this->Fields[$name];
            $parm = $queryBuilder->createPositionalParameter($value, $field->getParameterType());
            $parm = $field->CustomDataType?->convertToDatabaseValueSQL($parm, $platform) ?? $parm; // Convert database SQL
            $queryBuilder->set($field->Expression, $parm);
        }
        $filter = $curfilter ? $this->CurrentFilter : "";
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        AddFilter($filter, $where);
        if ($filter != "") {
            $queryBuilder->where($filter);
        }
        return $queryBuilder;
    }

    // Update
    public function update(&$rs, $where = "", $rsold = null, $curfilter = true)
    {
        // If no field is updated, execute may return 0. Treat as success
        try {
            $success = $this->updateSql($rs, $where, $curfilter)->executeStatement();
            $success = $success > 0 ? $success : true;
            $this->DbErrorMessage = "";
        } catch (\Exception $e) {
            $success = false;
            $this->DbErrorMessage = $e->getMessage();
        }

        // Return auto increment field
        if ($success) {
            if (!isset($rs['film_id']) && !EmptyValue($this->film_id->CurrentValue)) {
                $rs['film_id'] = $this->film_id->CurrentValue;
            }
        }
        if ($success && $this->AuditTrailOnEdit && $rsold) {
            $rsaudit = $rs;
            $fldname = 'film_id';
            if (!array_key_exists($fldname, $rsaudit)) {
                $rsaudit[$fldname] = $rsold[$fldname];
            }
            $this->writeAuditTrailOnEdit($rsold, $rsaudit);
        }
        return $success;
    }

    /**
     * DELETE statement
     *
     * @param array $rs Key values
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    public function deleteSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->delete($this->UpdateTable);
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        if ($rs) {
            if (array_key_exists('film_id', $rs)) {
                AddFilter($where, QuotedName('film_id', $this->Dbid) . '=' . QuotedValue($rs['film_id'], $this->film_id->DataType, $this->Dbid));
            }
        }
        $filter = $curfilter ? $this->CurrentFilter : "";
        AddFilter($filter, $where);
        return $queryBuilder->where($filter != "" ? $filter : "0=1");
    }

    // Delete
    public function delete(&$rs, $where = "", $curfilter = false)
    {
        $success = true;
        if ($success) {
            try {
                $success = $this->deleteSql($rs, $where, $curfilter)->executeStatement();
                $this->DbErrorMessage = "";
            } catch (\Exception $e) {
                $success = false;
                $this->DbErrorMessage = $e->getMessage();
            }
        }
        if ($success && $this->AuditTrailOnDelete) {
            $this->writeAuditTrailOnDelete($rs);
        }
        return $success;
    }

    // Load DbValue from result set or array
    protected function loadDbValues($row)
    {
        if (!is_array($row)) {
            return;
        }
        $this->film_id->DbValue = $row['film_id'];
        $this->_title->DbValue = $row['title'];
        $this->description->DbValue = $row['description'];
        $this->release_year->DbValue = $row['release_year'];
        $this->language_id->DbValue = $row['language_id'];
        $this->original_language_id->DbValue = $row['original_language_id'];
        $this->rental_duration->DbValue = $row['rental_duration'];
        $this->rental_rate->DbValue = $row['rental_rate'];
        $this->length->DbValue = $row['length'];
        $this->replacement_cost->DbValue = $row['replacement_cost'];
        $this->rating->DbValue = $row['rating'];
        $this->special_features->DbValue = $row['special_features'];
        $this->last_update->DbValue = $row['last_update'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`film_id` = @film_id@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->film_id->CurrentValue : $this->film_id->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        $keySeparator ??= Config("COMPOSITE_KEY_SEPARATOR");
        return implode($keySeparator, $keys);
    }

    // Set Key
    public function setKey($key, $current = false, $keySeparator = null)
    {
        $keySeparator ??= Config("COMPOSITE_KEY_SEPARATOR");
        $this->OldKey = strval($key);
        $keys = explode($keySeparator, $this->OldKey);
        if (count($keys) == 1) {
            if ($current) {
                $this->film_id->CurrentValue = $keys[0];
            } else {
                $this->film_id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('film_id', $row) ? $row['film_id'] : null;
        } else {
            $val = !EmptyValue($this->film_id->OldValue) && !$current ? $this->film_id->OldValue : $this->film_id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@film_id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        return $keyFilter;
    }

    // Return page URL
    public function getReturnUrl()
    {
        $referUrl = ReferUrl();
        $referPageName = ReferPageName();
        $name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");
        // Get referer URL automatically
        if ($referUrl != "" && $referPageName != CurrentPageName() && $referPageName != "login") { // Referer not same page or login page
            $_SESSION[$name] = $referUrl; // Save to Session
        }
        return $_SESSION[$name] ?? GetUrl("filmlist");
    }

    // Set return page URL
    public function setReturnUrl($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
    }

    // Get modal caption
    public function getModalCaption($pageName)
    {
        global $Language;
        return match ($pageName) {
            "filmview" => $Language->phrase("View"),
            "filmedit" => $Language->phrase("Edit"),
            "filmadd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "filmlist";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "FilmView",
            Config("API_ADD_ACTION") => "FilmAdd",
            Config("API_EDIT_ACTION") => "FilmEdit",
            Config("API_DELETE_ACTION") => "FilmDelete",
            Config("API_LIST_ACTION") => "FilmList",
            default => ""
        };
    }

    // Current URL
    public function getCurrentUrl($parm = "")
    {
        $url = CurrentPageUrl(false);
        if ($parm != "") {
            $url = $this->keyUrl($url, $parm);
        } else {
            $url = $this->keyUrl($url, Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // List URL
    public function getListUrl()
    {
        return "filmlist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("filmview", $parm);
        } else {
            $url = $this->keyUrl("filmview", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "filmadd?" . $parm;
        } else {
            $url = "filmadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("filmedit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("filmlist", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("filmadd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("filmlist", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("filmdelete", $parm);
        }
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"film_id\":" . VarToJson($this->film_id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->film_id->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->film_id->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($parm != "") {
            $url .= "?" . $parm;
        }
        return $url;
    }

    // Render sort
    public function renderFieldHeader($fld)
    {
        global $Security, $Language;
        $sortUrl = "";
        $attrs = "";
        if ($this->PageID != "grid" && $fld->Sortable) {
            $sortUrl = $this->sortUrl($fld);
            $attrs = ' role="button" data-ew-action="sort" data-ajax="' . ($this->UseAjaxActions ? "true" : "false") . '" data-sort-url="' . $sortUrl . '" data-sort-type="1"';
            if ($this->ContextClass) { // Add context
                $attrs .= ' data-context="' . HtmlEncode($this->ContextClass) . '"';
            }
        }
        $html = '<div class="ew-table-header-caption"' . $attrs . '>' . $fld->caption() . '</div>';
        if ($sortUrl) {
            $html .= '<div class="ew-table-header-sort">' . $fld->getSortIcon() . '</div>';
        }
        if ($this->PageID != "grid" && !$this->isExport() && $fld->UseFilter && $Security->canSearch()) {
            $html .= '<div class="ew-filter-dropdown-btn" data-ew-action="filter" data-table="' . $fld->TableVar . '" data-field="' . $fld->FieldVar .
                '"><div class="ew-table-header-filter" role="button" aria-haspopup="true">' . $Language->phrase("Filter") .
                (is_array($fld->EditValue) ? str_replace("%c", count($fld->EditValue), $Language->phrase("FilterCount")) : '') .
                '</div></div>';
        }
        $html = '<div class="ew-table-header-btn">' . $html . '</div>';
        if ($this->UseCustomTemplate) {
            $scriptId = str_replace("{id}", $fld->TableVar . "_" . $fld->Param, "tpc_{id}");
            $html = '<template id="' . $scriptId . '">' . $html . '</template>';
        }
        return $html;
    }

    // Sort URL
    public function sortUrl($fld)
    {
        global $DashboardReport;
        if (
            $this->CurrentAction || $this->isExport() ||
            in_array($fld->Type, [128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = "order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort();
            if ($DashboardReport) {
                $urlParm .= "&amp;" . Config("PAGE_DASHBOARD") . "=" . $DashboardReport;
            }
            return $this->addMasterUrl($this->CurrentPageName . "?" . $urlParm);
        } else {
            return "";
        }
    }

    // Get record keys from Post/Get/Session
    public function getRecordKeys()
    {
        $arKeys = [];
        $arKey = [];
        if (Param("key_m") !== null) {
            $arKeys = Param("key_m");
            $cnt = count($arKeys);
        } else {
            $isApi = IsApi();
            $keyValues = $isApi
                ? (Route(0) == "export"
                    ? array_map(fn ($i) => Route($i + 3), range(0, 0))  // Export API
                    : array_map(fn ($i) => Route($i + 2), range(0, 0))) // Other API
                : []; // Non-API
            if (($keyValue = Param("film_id") ?? Route("film_id")) !== null) {
                $arKeys[] = $keyValue;
            } elseif ($isApi && (($keyValue = Key(0) ?? $keyValues[0] ?? null) !== null)) {
                $arKeys[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_numeric($key)) {
                    continue;
                }
                $ar[] = $key;
            }
        }
        return $ar;
    }

    // Get filter from records
    public function getFilterFromRecords($rows)
    {
        return implode(" OR ", array_map(fn($row) => "(" . $this->getRecordFilter($row) . ")", $rows));
    }

    // Get filter from record keys
    public function getFilterFromRecordKeys($setCurrent = true)
    {
        $arKeys = $this->getRecordKeys();
        $keyFilter = "";
        foreach ($arKeys as $key) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            if ($setCurrent) {
                $this->film_id->CurrentValue = $key;
            } else {
                $this->film_id->OldValue = $key;
            }
            $keyFilter .= "(" . $this->getRecordFilter() . ")";
        }
        return $keyFilter;
    }

    // Load result set based on filter/sort
    public function loadRs($filter, $sort = "")
    {
        $sql = $this->getSql($filter, $sort); // Set up filter (WHERE Clause) / sort (ORDER BY Clause)
        $conn = $this->getConnection();
        return $conn->executeQuery($sql);
    }

    // Load row values from record
    public function loadListRowValues(&$rs)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            return;
        }
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

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "FilmList";
        $listClass = PROJECT_NAMESPACE . $listPage;
        $page = new $listClass();
        $page->loadRecordsetFromFilter($filter);
        $view = Container("app.view");
        $template = $listPage . ".php"; // View
        $GLOBALS["Title"] ??= $page->Title; // Title
        try {
            $Response = $view->render($Response, $template, $GLOBALS);
        } finally {
            $page->terminate(); // Terminate page and clean up
        }
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // film_id

        // title

        // description

        // release_year

        // language_id

        // original_language_id

        // rental_duration

        // rental_rate

        // length

        // replacement_cost

        // rating

        // special_features

        // last_update

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

        // film_id
        $this->film_id->HrefValue = "";
        $this->film_id->TooltipValue = "";

        // title
        $this->_title->HrefValue = "";
        $this->_title->TooltipValue = "";

        // description
        $this->description->HrefValue = "";
        $this->description->TooltipValue = "";

        // release_year
        $this->release_year->HrefValue = "";
        $this->release_year->TooltipValue = "";

        // language_id
        $this->language_id->HrefValue = "";
        $this->language_id->TooltipValue = "";

        // original_language_id
        $this->original_language_id->HrefValue = "";
        $this->original_language_id->TooltipValue = "";

        // rental_duration
        $this->rental_duration->HrefValue = "";
        $this->rental_duration->TooltipValue = "";

        // rental_rate
        $this->rental_rate->HrefValue = "";
        $this->rental_rate->TooltipValue = "";

        // length
        $this->length->HrefValue = "";
        $this->length->TooltipValue = "";

        // replacement_cost
        $this->replacement_cost->HrefValue = "";
        $this->replacement_cost->TooltipValue = "";

        // rating
        $this->rating->HrefValue = "";
        $this->rating->TooltipValue = "";

        // special_features
        $this->special_features->HrefValue = "";
        $this->special_features->TooltipValue = "";

        // last_update
        $this->last_update->HrefValue = "";
        $this->last_update->TooltipValue = "";

        // Call Row Rendered event
        $this->rowRendered();

        // Save data for Custom Template
        $this->Rows[] = $this->customTemplateFieldValues();
    }

    // Render edit row values
    public function renderEditRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // film_id
        $this->film_id->setupEditAttributes();
        $this->film_id->EditValue = $this->film_id->CurrentValue;

        // title
        $this->_title->setupEditAttributes();
        if (!$this->_title->Raw) {
            $this->_title->CurrentValue = HtmlDecode($this->_title->CurrentValue);
        }
        $this->_title->EditValue = $this->_title->CurrentValue;
        $this->_title->PlaceHolder = RemoveHtml($this->_title->caption());

        // description
        $this->description->setupEditAttributes();
        if (!$this->description->Raw) {
            $this->description->CurrentValue = HtmlDecode($this->description->CurrentValue);
        }
        $this->description->EditValue = $this->description->CurrentValue;
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
        $this->language_id->PlaceHolder = RemoveHtml($this->language_id->caption());

        // original_language_id
        $this->original_language_id->setupEditAttributes();
        $this->original_language_id->EditValue = $this->original_language_id->CurrentValue;
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
        $this->last_update->EditValue = FormatDateTime($this->last_update->CurrentValue, $this->last_update->formatPattern());
        $this->last_update->PlaceHolder = RemoveHtml($this->last_update->caption());

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
        // Call Row Rendered event
        $this->rowRendered();
    }

    // Export data in HTML/CSV/Word/Excel/Email/PDF format
    public function exportDocument($doc, $result, $startRec = 1, $stopRec = 1, $exportPageType = "")
    {
        if (!$result || !$doc) {
            return;
        }
        if (!$doc->ExportCustom) {
            // Write header
            $doc->exportTableHeader();
            if ($doc->Horizontal) { // Horizontal format, write header
                $doc->beginExportRow();
                if ($exportPageType == "view") {
                    $doc->exportCaption($this->film_id);
                    $doc->exportCaption($this->_title);
                    $doc->exportCaption($this->description);
                    $doc->exportCaption($this->release_year);
                    $doc->exportCaption($this->language_id);
                    $doc->exportCaption($this->original_language_id);
                    $doc->exportCaption($this->rental_duration);
                    $doc->exportCaption($this->rental_rate);
                    $doc->exportCaption($this->length);
                    $doc->exportCaption($this->replacement_cost);
                    $doc->exportCaption($this->rating);
                    $doc->exportCaption($this->special_features);
                    $doc->exportCaption($this->last_update);
                } else {
                    $doc->exportCaption($this->film_id);
                    $doc->exportCaption($this->_title);
                    $doc->exportCaption($this->description);
                    $doc->exportCaption($this->release_year);
                    $doc->exportCaption($this->language_id);
                    $doc->exportCaption($this->original_language_id);
                    $doc->exportCaption($this->rental_duration);
                    $doc->exportCaption($this->rental_rate);
                    $doc->exportCaption($this->length);
                    $doc->exportCaption($this->replacement_cost);
                    $doc->exportCaption($this->rating);
                    $doc->exportCaption($this->special_features);
                    $doc->exportCaption($this->last_update);
                }
                $doc->endExportRow();
            }
        }
        $recCnt = $startRec - 1;
        $stopRec = $stopRec > 0 ? $stopRec : PHP_INT_MAX;
        while (($row = $result->fetch()) && $recCnt < $stopRec) {
            $recCnt++;
            if ($recCnt >= $startRec) {
                $rowCnt = $recCnt - $startRec + 1;

                // Page break
                if ($this->ExportPageBreakCount > 0) {
                    if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0) {
                        $doc->exportPageBreak();
                    }
                }
                $this->loadListRowValues($row);

                // Render row
                $this->RowType = RowType::VIEW; // Render view
                $this->resetAttributes();
                $this->renderListRow();
                if (!$doc->ExportCustom) {
                    $doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
                    if ($exportPageType == "view") {
                        $doc->exportField($this->film_id);
                        $doc->exportField($this->_title);
                        $doc->exportField($this->description);
                        $doc->exportField($this->release_year);
                        $doc->exportField($this->language_id);
                        $doc->exportField($this->original_language_id);
                        $doc->exportField($this->rental_duration);
                        $doc->exportField($this->rental_rate);
                        $doc->exportField($this->length);
                        $doc->exportField($this->replacement_cost);
                        $doc->exportField($this->rating);
                        $doc->exportField($this->special_features);
                        $doc->exportField($this->last_update);
                    } else {
                        $doc->exportField($this->film_id);
                        $doc->exportField($this->_title);
                        $doc->exportField($this->description);
                        $doc->exportField($this->release_year);
                        $doc->exportField($this->language_id);
                        $doc->exportField($this->original_language_id);
                        $doc->exportField($this->rental_duration);
                        $doc->exportField($this->rental_rate);
                        $doc->exportField($this->length);
                        $doc->exportField($this->replacement_cost);
                        $doc->exportField($this->rating);
                        $doc->exportField($this->special_features);
                        $doc->exportField($this->last_update);
                    }
                    $doc->endExportRow($rowCnt);
                }
            }

            // Call Row Export server event
            if ($doc->ExportCustom) {
                $this->rowExport($doc, $row);
            }
        }
        if (!$doc->ExportCustom) {
            $doc->exportTableFooter();
        }
    }

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        global $DownloadFileName;

        // No binary fields
        return false;
    }

    // Write audit trail start/end for grid update
    public function writeAuditTrailDummy($typ)
    {
        WriteAuditLog(CurrentUserIdentifier(), $typ, 'film');
    }

    // Write audit trail (add page)
    public function writeAuditTrailOnAdd(&$rs)
    {
        global $Language;
        if (!$this->AuditTrailOnAdd) {
            return;
        }

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rs['film_id'];

        // Write audit trail
        $usr = CurrentUserIdentifier();
        foreach (array_keys($rs) as $fldname) {
            if (array_key_exists($fldname, $this->Fields) && $this->Fields[$fldname]->DataType != DataType::BLOB) { // Ignore BLOB fields
                if ($this->Fields[$fldname]->HtmlTag == "PASSWORD") { // Password Field
                    $newvalue = $Language->phrase("PasswordMask");
                } elseif ($this->Fields[$fldname]->DataType == DataType::MEMO) { // Memo Field
                    $newvalue = Config("AUDIT_TRAIL_TO_DATABASE") ? $rs[$fldname] : "[MEMO]";
                } elseif ($this->Fields[$fldname]->DataType == DataType::XML) { // XML Field
                    $newvalue = "[XML]";
                } else {
                    $newvalue = $rs[$fldname];
                }
                WriteAuditLog($usr, "A", 'film', $fldname, $key, "", $newvalue);
            }
        }
    }

    // Write audit trail (edit page)
    public function writeAuditTrailOnEdit(&$rsold, &$rsnew)
    {
        global $Language;
        if (!$this->AuditTrailOnEdit) {
            return;
        }

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rsold['film_id'];

        // Write audit trail
        $usr = CurrentUserIdentifier();
        foreach (array_keys($rsnew) as $fldname) {
            if (array_key_exists($fldname, $this->Fields) && array_key_exists($fldname, $rsold) && $this->Fields[$fldname]->DataType != DataType::BLOB) { // Ignore BLOB fields
                if ($this->Fields[$fldname]->DataType == DataType::DATE) { // DateTime field
                    $modified = (FormatDateTime($rsold[$fldname], 0) != FormatDateTime($rsnew[$fldname], 0));
                } else {
                    $modified = !CompareValue($rsold[$fldname], $rsnew[$fldname]);
                }
                if ($modified) {
                    if ($this->Fields[$fldname]->HtmlTag == "PASSWORD") { // Password Field
                        $oldvalue = $Language->phrase("PasswordMask");
                        $newvalue = $Language->phrase("PasswordMask");
                    } elseif ($this->Fields[$fldname]->DataType == DataType::MEMO) { // Memo field
                        $oldvalue = Config("AUDIT_TRAIL_TO_DATABASE") ? $rsold[$fldname] : "[MEMO]";
                        $newvalue = Config("AUDIT_TRAIL_TO_DATABASE") ? $rsnew[$fldname] : "[MEMO]";
                    } elseif ($this->Fields[$fldname]->DataType == DataType::XML) { // XML field
                        $oldvalue = "[XML]";
                        $newvalue = "[XML]";
                    } else {
                        $oldvalue = $rsold[$fldname];
                        $newvalue = $rsnew[$fldname];
                    }
                    WriteAuditLog($usr, "U", 'film', $fldname, $key, $oldvalue, $newvalue);
                }
            }
        }
    }

    // Write audit trail (delete page)
    public function writeAuditTrailOnDelete(&$rs)
    {
        global $Language;
        if (!$this->AuditTrailOnDelete) {
            return;
        }

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rs['film_id'];

        // Write audit trail
        $usr = CurrentUserIdentifier();
        foreach (array_keys($rs) as $fldname) {
            if (array_key_exists($fldname, $this->Fields) && $this->Fields[$fldname]->DataType != DataType::BLOB) { // Ignore BLOB fields
                if ($this->Fields[$fldname]->HtmlTag == "PASSWORD") { // Password Field
                    $oldvalue = $Language->phrase("PasswordMask");
                } elseif ($this->Fields[$fldname]->DataType == DataType::MEMO) { // Memo field
                    $oldvalue = Config("AUDIT_TRAIL_TO_DATABASE") ? $rs[$fldname] : "[MEMO]";
                } elseif ($this->Fields[$fldname]->DataType == DataType::XML) { // XML field
                    $oldvalue = "[XML]";
                } else {
                    $oldvalue = $rs[$fldname];
                }
                WriteAuditLog($usr, "D", 'film', $fldname, $key, $oldvalue);
            }
        }
    }

    // Table level events

    // Table Load event
    public function tableLoad()
    {
        // Enter your code here
    }

    // Recordset Selecting event
    public function recordsetSelecting(&$filter)
    {
        // Enter your code here
    }

    // Recordset Selected event
    public function recordsetSelected($rs)
    {
        //Log("Recordset Selected");
    }

    // Recordset Search Validated event
    public function recordsetSearchValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Recordset Searching event
    public function recordsetSearching(&$filter)
    {
        // Enter your code here
    }

    // Row_Selecting event
    public function rowSelecting(&$filter)
    {
        // Enter your code here
    }

    // Row Selected event
    public function rowSelected(&$rs)
    {
        //Log("Row Selected");
    }

    // Row Inserting event
    public function rowInserting($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, $rsnew)
    {
        //Log("Row Inserted");
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, $rsnew)
    {
        //Log("Row Updated");
    }

    // Row Update Conflict event
    public function rowUpdateConflict($rsold, &$rsnew)
    {
        // Enter your code here
        // To ignore conflict, set return value to false
        return true;
    }

    // Grid Inserting event
    public function gridInserting()
    {
        // Enter your code here
        // To reject grid insert, set return value to false
        return true;
    }

    // Grid Inserted event
    public function gridInserted($rsnew)
    {
        //Log("Grid Inserted");
    }

    // Grid Updating event
    public function gridUpdating($rsold)
    {
        // Enter your code here
        // To reject grid update, set return value to false
        return true;
    }

    // Grid Updated event
    public function gridUpdated($rsold, $rsnew)
    {
        //Log("Grid Updated");
    }

    // Row Deleting event
    public function rowDeleting(&$rs)
    {
        // Enter your code here
        // To cancel, set return value to False
        return true;
    }

    // Row Deleted event
    public function rowDeleted($rs)
    {
        //Log("Row Deleted");
    }

    // Email Sending event
    public function emailSending($email, $args)
    {
        //var_dump($email, $args); exit();
        return true;
    }

    // Lookup Selecting event
    public function lookupSelecting($fld, &$filter)
    {
        //var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
        // Enter your code here
    }

    // Row Rendering event
    public function rowRendering()
    {
        // Enter your code here
    }

    // Row Rendered event
    public function rowRendered()
    {
        // To view properties of field class, use:
        //var_dump($this-><FieldName>);
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
