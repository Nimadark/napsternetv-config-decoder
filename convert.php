<?php

require_once 'napsternetv.php';
//=======
$tablesData = json_decode(file_get_contents('tables.json'), true);
$wbTables = new WhiteboxTables($tablesData['nr'], $tablesData['xor'], $tablesData['tyboxes'], $tablesData['tboxesLast'], $tablesData['mbl']);
$wbaes = new WBAESCTR($wbTables);
$importer = new ConfigImporter($wbaes);


$ConfigFile = file_get_contents('test.npvt'); //input .npvt
$result = $importer->importConfig($ConfigFile);
print_R($result);
