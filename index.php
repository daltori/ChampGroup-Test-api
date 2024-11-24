<?php

/**
 * index.php -- script that connects to Api https://pokerocket.com/ 
 *              and updates data in Google Sheets.
 * Test 
 *
 * @author		ChampGroup
 * @author		David Alejandro T. - <ing.david.torres@outlook.com>
 * @version		1.0
 * 
 */
require_once 'src/ApiConection.php';
require_once 'src/GoogleSheets.php';
include('view.php');

$oConector = new ApiConection('https://pokerocket.com/');
$aRespose  = $oConector->f_ExeCurl('get-auth', 'GET');
$oConector->f_validateStatus($aRespose);
$aToken    = json_decode($aRespose['response'], true);
$sToken    = $aToken['auth_bearer'];
$aHeaders  = $oConector->f_AddToken($sToken);
$aRespose  = $oConector->f_ExeCurl('get-csv', 'POST', $aHeaders);
$oConector->f_validateStatus($aRespose);
$aData     = explode("\n", $aRespose['response']);
$aData     = f_TransData($aData);
$oGoogle   = new GoogleSheets ();
$oGoogle->f_SaveValues($aData);
echo ' <img src="https://cdn.iconscout.com/icon/free/png-256/free-logotipo-120-116259.png?f=webp">';
echo ' <div class="success-message"> ¡Operation completed successfully!</div> ';

/**
 * Data Transformation
 * @param  Array  $aData             -Data retrieved from API queries, prepared for transformation and saving to a file.
 * @return String $aResult           -Response data prepared for sending to a Google Sheets object.
 */
function f_TransData($aData)
{
    $aResult = [];
    foreach ($aData as $sData) {
        if (!empty($sData)) {
            array_push($aResult, explode(',', $sData));
        }
    }
    return $aResult;
}


