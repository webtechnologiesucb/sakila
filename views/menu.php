<?php

namespace PHPMaker2024\Sakila;

// Navbar menu
$topMenu = new Menu("navbar", true, true);
echo $topMenu->toScript();

// Sidebar menu
$sideMenu = new Menu("menu", true, false);
$sideMenu->addMenuItem(33, "mi_DashboardAll", $Language->menuPhrase("33", "MenuText"), "dashboardall", -1, "", IsLoggedIn() || AllowListMenu('{5926973F-F695-4637-B16D-5ACD7449BF12}DashboardAll'), false, false, "", "", false, true);
$sideMenu->addMenuItem(26, "mci_Registers", $Language->menuPhrase("26", "MenuText"), "#", -1, "", true, false, true, "", "", false, true);
$sideMenu->addMenuItem(2, "mi_address", $Language->menuPhrase("2", "MenuText"), "addresslist", 26, "", IsLoggedIn() || AllowListMenu('{5926973F-F695-4637-B16D-5ACD7449BF12}address'), false, false, "", "", false, true);
$sideMenu->addMenuItem(4, "mi_city", $Language->menuPhrase("4", "MenuText"), "citylist", 26, "", IsLoggedIn() || AllowListMenu('{5926973F-F695-4637-B16D-5ACD7449BF12}city'), false, false, "", "", false, true);
$sideMenu->addMenuItem(3, "mi_category", $Language->menuPhrase("3", "MenuText"), "categorylist", 26, "", IsLoggedIn() || AllowListMenu('{5926973F-F695-4637-B16D-5ACD7449BF12}category'), false, false, "", "", false, true);
$sideMenu->addMenuItem(5, "mi_country", $Language->menuPhrase("5", "MenuText"), "countrylist", 26, "", IsLoggedIn() || AllowListMenu('{5926973F-F695-4637-B16D-5ACD7449BF12}country'), false, false, "", "", false, true);
$sideMenu->addMenuItem(12, "mi_language2", $Language->menuPhrase("12", "MenuText"), "language2list", 26, "", IsLoggedIn() || AllowListMenu('{5926973F-F695-4637-B16D-5ACD7449BF12}language'), false, false, "", "", false, true);
$sideMenu->addMenuItem(15, "mi_staff", $Language->menuPhrase("15", "MenuText"), "stafflist", 26, "", IsLoggedIn() || AllowListMenu('{5926973F-F695-4637-B16D-5ACD7449BF12}staff'), false, false, "", "", false, true);
$sideMenu->addMenuItem(29, "mci_Movies", $Language->menuPhrase("29", "MenuText"), "#", -1, "", true, false, true, "", "", false, true);
$sideMenu->addMenuItem(1, "mi_actor", $Language->menuPhrase("1", "MenuText"), "actorlist", 29, "", IsLoggedIn() || AllowListMenu('{5926973F-F695-4637-B16D-5ACD7449BF12}actor'), false, false, "", "", false, true);
$sideMenu->addMenuItem(7, "mi_film", $Language->menuPhrase("7", "MenuText"), "filmlist", 29, "", IsLoggedIn() || AllowListMenu('{5926973F-F695-4637-B16D-5ACD7449BF12}film'), false, false, "", "", false, true);
$sideMenu->addMenuItem(8, "mi_film_actor", $Language->menuPhrase("8", "MenuText"), "filmactorlist", 29, "", IsLoggedIn() || AllowListMenu('{5926973F-F695-4637-B16D-5ACD7449BF12}film_actor'), false, false, "", "", false, true);
$sideMenu->addMenuItem(9, "mi_film_category", $Language->menuPhrase("9", "MenuText"), "filmcategorylist", 29, "", IsLoggedIn() || AllowListMenu('{5926973F-F695-4637-B16D-5ACD7449BF12}film_category'), false, false, "", "", false, true);
$sideMenu->addMenuItem(10, "mi_film_text", $Language->menuPhrase("10", "MenuText"), "filmtextlist", 29, "", IsLoggedIn() || AllowListMenu('{5926973F-F695-4637-B16D-5ACD7449BF12}film_text'), false, false, "", "", false, true);
$sideMenu->addMenuItem(32, "mci_Inventory_Teams", $Language->menuPhrase("32", "MenuText"), "", -1, "", true, false, true, "", "", false, true);
$sideMenu->addMenuItem(11, "mi_inventory", $Language->menuPhrase("11", "MenuText"), "inventorylist", 32, "", IsLoggedIn() || AllowListMenu('{5926973F-F695-4637-B16D-5ACD7449BF12}inventory'), false, false, "", "", false, true);
$sideMenu->addMenuItem(16, "mi_store", $Language->menuPhrase("16", "MenuText"), "storelist", 32, "", IsLoggedIn() || AllowListMenu('{5926973F-F695-4637-B16D-5ACD7449BF12}store'), false, false, "", "", false, true);
$sideMenu->addMenuItem(31, "mci_Rent_Movies", $Language->menuPhrase("31", "MenuText"), "", -1, "", true, false, true, "", "", false, true);
$sideMenu->addMenuItem(6, "mi_customer", $Language->menuPhrase("6", "MenuText"), "customerlist", 31, "", IsLoggedIn() || AllowListMenu('{5926973F-F695-4637-B16D-5ACD7449BF12}customer'), false, false, "", "", false, true);
$sideMenu->addMenuItem(13, "mi_payment", $Language->menuPhrase("13", "MenuText"), "paymentlist", 31, "", IsLoggedIn() || AllowListMenu('{5926973F-F695-4637-B16D-5ACD7449BF12}payment'), false, false, "", "", false, true);
$sideMenu->addMenuItem(14, "mi_rental", $Language->menuPhrase("14", "MenuText"), "rentallist", 31, "", IsLoggedIn() || AllowListMenu('{5926973F-F695-4637-B16D-5ACD7449BF12}rental'), false, false, "", "", false, true);
$sideMenu->addMenuItem(30, "mci_Reports", $Language->menuPhrase("30", "MenuText"), "#", -1, "", true, false, true, "", "", false, true);
$sideMenu->addMenuItem(17, "mi_actor_info", $Language->menuPhrase("17", "MenuText"), "actorinfolist", 30, "", IsLoggedIn() || AllowListMenu('{5926973F-F695-4637-B16D-5ACD7449BF12}actor_info'), false, false, "", "", false, true);
$sideMenu->addMenuItem(18, "mi_customer_list2", $Language->menuPhrase("18", "MenuText"), "customerlist2list", 30, "", IsLoggedIn() || AllowListMenu('{5926973F-F695-4637-B16D-5ACD7449BF12}customer_list'), false, false, "", "", false, true);
$sideMenu->addMenuItem(19, "mi_film_list2", $Language->menuPhrase("19", "MenuText"), "filmlist2list", 30, "", IsLoggedIn() || AllowListMenu('{5926973F-F695-4637-B16D-5ACD7449BF12}film_list'), false, false, "", "", false, true);
$sideMenu->addMenuItem(20, "mi_sales_by_film_category", $Language->menuPhrase("20", "MenuText"), "salesbyfilmcategorylist", 30, "", IsLoggedIn() || AllowListMenu('{5926973F-F695-4637-B16D-5ACD7449BF12}sales_by_film_category'), false, false, "", "", false, true);
$sideMenu->addMenuItem(21, "mi_sales_by_store", $Language->menuPhrase("21", "MenuText"), "salesbystorelist", 30, "", IsLoggedIn() || AllowListMenu('{5926973F-F695-4637-B16D-5ACD7449BF12}sales_by_store'), false, false, "", "", false, true);
$sideMenu->addMenuItem(22, "mi_staff_list2", $Language->menuPhrase("22", "MenuText"), "stafflist2list", 30, "", IsLoggedIn() || AllowListMenu('{5926973F-F695-4637-B16D-5ACD7449BF12}staff_list'), false, false, "", "", false, true);
$sideMenu->addMenuItem(23, "mi_nicer_but_slower_film_list", $Language->menuPhrase("23", "MenuText"), "nicerbutslowerfilmlistlist", 30, "", IsLoggedIn() || AllowListMenu('{5926973F-F695-4637-B16D-5ACD7449BF12}nicer_but_slower_film_list'), false, false, "", "", false, true);
$sideMenu->addMenuItem(27, "mci_Audit", $Language->menuPhrase("27", "MenuText"), "#", -1, "", true, false, true, "", "", false, true);
$sideMenu->addMenuItem(24, "mi_audittrail", $Language->menuPhrase("24", "MenuText"), "audittraillist", 27, "", IsLoggedIn() || AllowListMenu('{5926973F-F695-4637-B16D-5ACD7449BF12}audittrail'), false, false, "", "", false, true);
$sideMenu->addMenuItem(25, "mi_exportlog", $Language->menuPhrase("25", "MenuText"), "exportloglist", 27, "", IsLoggedIn() || AllowListMenu('{5926973F-F695-4637-B16D-5ACD7449BF12}exportlog'), false, false, "", "", false, true);
echo $sideMenu->toScript();
