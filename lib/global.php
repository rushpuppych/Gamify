<?php
function getConfig($strKey) {$arrConfig = [];
// ============================================================================
// GLOBAL CONFIG PART
// ============================================================================
// This is the Security Salt for Hashing Operations
$arrConfig['security']['salt'] = 'ThisShouldBeASecret!';

// Page Options
$arrConfig['page']['impressum_info'] = 'Gamify Portal der Klasse HE16<br>';
$arrConfig['page']['impressum_logo'] = 'http://www.todo-gmbh.ch/wp-content/uploads/Referenzen/referate/hf-ict.png';
$arrConfig['page']['impressum_name'] = 'Höhere Fachschule HF-ICT';
$arrConfig['page']['impressum_street'] = 'Gründenstrasse 46';
$arrConfig['page']['impressum_place'] = 'CH-4132 Muttenz';
$arrConfig['page']['impressum_website'] = 'www.hf-ict.ch';
$arrConfig['page']['impressum_email'] = 'info@hf-ict.ch';
$arrConfig['page']['impressum_phone'] = '+41 (0) 61 552 94 94';

// Database Connection
$arrConfig['database']['database'] = 'gamify';
$arrConfig['database']['host'] = 'localhost';
$arrConfig['database']['user'] = 'root';
$arrConfig['database']['password'] = '';
$arrConfig['database']['port'] = 3306;

// Server Config (no slash at the end of the path)
$arrConfig['server']['root_path'] = 'http://localhost:8080/Gamify';

// Mail Config (for notifications)
$arrConfig['mail']['host'] = '';
$arrConfig['mail']['smtp_auth'] = true;
$arrConfig['mail']['username'] = '';
$arrConfig['mail']['password'] = '';
$arrConfig['mail']['smtp_secure'] = 'tls';
$arrConfig['mail']['port'] = 587;
$arrConfig['mail']['enable_email_notification'] = true;

// Gamify Behaviour
$arrConfig['game']['create_quests'] = 'all'; // all = All can create ['1','2'] = Only Account 1 and 2 can create quests
$arrConfig['game']['battle_time_from'] = '08:00';
$arrConfig['game']['battle_time_to'] = '17:00';
$arrConfig['game']['battle_days'] = 'xxxxx--'; // x = Battle day, - = No Battle day

// ============================================================================
// DO NOT CHANGE ANYTHING BELOW HERE
// ============================================================================
return $arrConfig[$strKey];}

CONST RARITY_POOR = 0;
CONST RARITY_COMMON = 1;
CONST RARITY_UNCOMMON = 2;
CONST RARITY_EPIC = 3;
CONST RARITY_LEGENDARY = 4;
CONST RARITY_DIVINE = 5;
