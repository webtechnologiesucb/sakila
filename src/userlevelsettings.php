<?php
/**
 * PHPMaker 2024 User Level Settings
 */
namespace PHPMaker2024\Sakila;

/**
 * User levels
 *
 * @var array<int, string>
 * [0] int User level ID
 * [1] string User level name
 */
$USER_LEVELS = [["-2","Anonymous"]];

/**
 * User level permissions
 *
 * @var array<string, int, int>
 * [0] string Project ID + Table name
 * [1] int User level ID
 * [2] int Permissions
 */
$USER_LEVEL_PRIVS = [["{5926973F-F695-4637-B16D-5ACD7449BF12}actor","-2","0"],
    ["{5926973F-F695-4637-B16D-5ACD7449BF12}actor_info","-2","0"],
    ["{5926973F-F695-4637-B16D-5ACD7449BF12}address","-2","0"],
    ["{5926973F-F695-4637-B16D-5ACD7449BF12}category","-2","0"],
    ["{5926973F-F695-4637-B16D-5ACD7449BF12}city","-2","0"],
    ["{5926973F-F695-4637-B16D-5ACD7449BF12}country","-2","0"],
    ["{5926973F-F695-4637-B16D-5ACD7449BF12}customer","-2","0"],
    ["{5926973F-F695-4637-B16D-5ACD7449BF12}customer_list","-2","0"],
    ["{5926973F-F695-4637-B16D-5ACD7449BF12}film","-2","0"],
    ["{5926973F-F695-4637-B16D-5ACD7449BF12}film_actor","-2","0"],
    ["{5926973F-F695-4637-B16D-5ACD7449BF12}film_category","-2","0"],
    ["{5926973F-F695-4637-B16D-5ACD7449BF12}film_list","-2","0"],
    ["{5926973F-F695-4637-B16D-5ACD7449BF12}film_text","-2","0"],
    ["{5926973F-F695-4637-B16D-5ACD7449BF12}inventory","-2","0"],
    ["{5926973F-F695-4637-B16D-5ACD7449BF12}language","-2","0"],
    ["{5926973F-F695-4637-B16D-5ACD7449BF12}nicer_but_slower_film_list","-2","0"],
    ["{5926973F-F695-4637-B16D-5ACD7449BF12}payment","-2","0"],
    ["{5926973F-F695-4637-B16D-5ACD7449BF12}rental","-2","0"],
    ["{5926973F-F695-4637-B16D-5ACD7449BF12}sales_by_film_category","-2","0"],
    ["{5926973F-F695-4637-B16D-5ACD7449BF12}sales_by_store","-2","0"],
    ["{5926973F-F695-4637-B16D-5ACD7449BF12}staff","-2","0"],
    ["{5926973F-F695-4637-B16D-5ACD7449BF12}staff_list","-2","0"],
    ["{5926973F-F695-4637-B16D-5ACD7449BF12}store","-2","0"],
    ["{5926973F-F695-4637-B16D-5ACD7449BF12}audittrail","-2","0"],
    ["{5926973F-F695-4637-B16D-5ACD7449BF12}exportlog","-2","0"],
    ["{5926973F-F695-4637-B16D-5ACD7449BF12}DashboardAll","-2","0"]];

/**
 * Tables
 *
 * @var array<string, string, string, bool, string>
 * [0] string Table name
 * [1] string Table variable name
 * [2] string Table caption
 * [3] bool Allowed for update (for userpriv.php)
 * [4] string Project ID
 * [5] string URL (for OthersController::index)
 */
$USER_LEVEL_TABLES = [["actor","actor","Actor",true,"{5926973F-F695-4637-B16D-5ACD7449BF12}","actorlist"],
    ["actor_info","actor_info","Info Actors",true,"{5926973F-F695-4637-B16D-5ACD7449BF12}","actorinfolist"],
    ["address","address","Address",true,"{5926973F-F695-4637-B16D-5ACD7449BF12}","addresslist"],
    ["category","category","Category",true,"{5926973F-F695-4637-B16D-5ACD7449BF12}","categorylist"],
    ["city","city","City",true,"{5926973F-F695-4637-B16D-5ACD7449BF12}","citylist"],
    ["country","country","Country",true,"{5926973F-F695-4637-B16D-5ACD7449BF12}","countrylist"],
    ["customer","customer","Customer",true,"{5926973F-F695-4637-B16D-5ACD7449BF12}","customerlist"],
    ["customer_list","customer_list2","Customers Lists",true,"{5926973F-F695-4637-B16D-5ACD7449BF12}","customerlist2list"],
    ["film","film","Film",true,"{5926973F-F695-4637-B16D-5ACD7449BF12}","filmlist"],
    ["film_actor","film_actor","Actor-Film",true,"{5926973F-F695-4637-B16D-5ACD7449BF12}","filmactorlist"],
    ["film_category","film_category","Category-Film",true,"{5926973F-F695-4637-B16D-5ACD7449BF12}","filmcategorylist"],
    ["film_list","film_list2","Film List",true,"{5926973F-F695-4637-B16D-5ACD7449BF12}","filmlist2list"],
    ["film_text","film_text","Text-Film",true,"{5926973F-F695-4637-B16D-5ACD7449BF12}","filmtextlist"],
    ["inventory","inventory","Inventory",true,"{5926973F-F695-4637-B16D-5ACD7449BF12}","inventorylist"],
    ["language","language2","Language",true,"{5926973F-F695-4637-B16D-5ACD7449BF12}","language2list"],
    ["nicer_but_slower_film_list","nicer_but_slower_film_list","Best Film List",true,"{5926973F-F695-4637-B16D-5ACD7449BF12}","nicerbutslowerfilmlistlist"],
    ["payment","payment","Payment",true,"{5926973F-F695-4637-B16D-5ACD7449BF12}","paymentlist"],
    ["rental","rental","Rental",true,"{5926973F-F695-4637-B16D-5ACD7449BF12}","rentallist"],
    ["sales_by_film_category","sales_by_film_category","Sales By Category",true,"{5926973F-F695-4637-B16D-5ACD7449BF12}","salesbyfilmcategorylist"],
    ["sales_by_store","sales_by_store","Sales By Store",true,"{5926973F-F695-4637-B16D-5ACD7449BF12}","salesbystorelist"],
    ["staff","staff","Staff",true,"{5926973F-F695-4637-B16D-5ACD7449BF12}","stafflist"],
    ["staff_list","staff_list2","Staff List",true,"{5926973F-F695-4637-B16D-5ACD7449BF12}","stafflist2list"],
    ["store","store","Store",true,"{5926973F-F695-4637-B16D-5ACD7449BF12}","storelist"],
    ["audittrail","audittrail","audittrail",true,"{5926973F-F695-4637-B16D-5ACD7449BF12}","audittraillist"],
    ["exportlog","exportlog","exportlog",true,"{5926973F-F695-4637-B16D-5ACD7449BF12}","exportloglist"],
    ["DashboardAll","DashboardAll","Dashboard All",true,"{5926973F-F695-4637-B16D-5ACD7449BF12}","dashboardall"]];
