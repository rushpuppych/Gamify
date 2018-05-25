
<?php
SESSION_START();

// Includes
include_once "../lib/global.php";
include_once "../models/class.BaseModel.php";
include_once "../models/class.CharacterModel.php";


// Only Accept Post Requests
if($_SERVER['REQUEST_METHOD'] != 'POST') {exit;}

// Load Delegation Players
$objCharacterModel = new CharacterModel();
$arrResult = $objCharacterModel->getAllPlayerNames();

$arrFractions = [];
foreach($arrResult as $arrPlayer) {
    // Build Fraction Name
    $strFraction = $arrPlayer['fraction'];
    $arrFractionName = explode('_', $strFraction);
    foreach($arrFractionName as $numKey => $strName) {
        $arrFractionName[$numKey] = ucfirst($strName);
    }
    $strFraction = implode(' ', $arrFractionName);

    // Not show own player
    if($arrPlayer['id'] == $_SESSION['user']['character']['id']) {
      continue;
    }

    // Add Player to fraction
    $arrPlayer['fraction'] = $strFraction;
    $arrFractions[$strFraction][] = $arrPlayer;
}

// Send Response
echo json_encode(['status' => true, 'fractions' => $arrFractions]);
exit;
