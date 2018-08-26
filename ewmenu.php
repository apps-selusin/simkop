<?php

// Menu
$RootMenu = new cMenu("RootMenu", TRUE);
$RootMenu->AddMenuItem(5, "mi_cf01_home_php", $Language->MenuPhrase("5", "MenuText"), "cf01_home.php", -1, "", AllowListMenu('{B3698D9B-8D4B-412E-A2E5-AFAD2FEE5A23}cf01_home.php'), FALSE, TRUE, "");
$RootMenu->AddMenuItem(6, "mi_t01_nasabah", $Language->MenuPhrase("6", "MenuText"), "t01_nasabahlist.php", -1, "", AllowListMenu('{B3698D9B-8D4B-412E-A2E5-AFAD2FEE5A23}t01_nasabah'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(7, "mci_User", $Language->MenuPhrase("7", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE, "");
$RootMenu->AddMenuItem(1, "mi_t96_employees", $Language->MenuPhrase("1", "MenuText"), "t96_employeeslist.php", 7, "", AllowListMenu('{B3698D9B-8D4B-412E-A2E5-AFAD2FEE5A23}t96_employees'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(2, "mi_t97_userlevels", $Language->MenuPhrase("2", "MenuText"), "t97_userlevelslist.php", 7, "", IsAdmin(), FALSE, FALSE, "");
$RootMenu->AddMenuItem(3, "mi_t98_userlevelpermissions", $Language->MenuPhrase("3", "MenuText"), "t98_userlevelpermissionslist.php", 7, "", IsAdmin(), FALSE, FALSE, "");
$RootMenu->AddMenuItem(4, "mi_t99_audittrail", $Language->MenuPhrase("4", "MenuText"), "t99_audittraillist.php", 7, "", AllowListMenu('{B3698D9B-8D4B-412E-A2E5-AFAD2FEE5A23}t99_audittrail'), FALSE, FALSE, "");
echo $RootMenu->ToScript();
?>
<div class="ewVertical" id="ewMenu"></div>
