<?php

/**
 * GoogleSheets.php -- Class to establish a connection and update information with Google Sheets.
 * Test 
 *
 * @author		ChampGroup
 * @author		David Alejandro T. - <ing.david.torres@outlook.com>
 * @version		1.0
 * 
 */
require 'vendor/autoload.php';
include('config.php');
use Google\Client;
use Google\Service\Sheets;

class GoogleSheets
{
    private $cSheetId   ;
    private $cKeyRoute  ;
    private $sRange     = "Hoja 1!A1";
    private $oSheets;

    public function __construct()
    {
        try {
            global  $aConfig;
            $this->cSheetId   = $aConfig['id_sheets'];
            $this->cKeyRoute  = $aConfig['key_source'];
            $oClient = new Client();
            $oClient->setApplicationName("Google Sheets API PHP");
            $oClient->setScopes([Sheets::SPREADSHEETS]);
            $oClient->setAuthConfig($this->cKeyRoute);
            $this->oSheets = new Sheets($oClient);
        } catch (Exception $e) {
            echo 'Error al inicializar la conexión: ' . $e->getMessage();
        }
    }
    public function f_SaveValues($aValues)
    {
        try {
            $oBody = new Sheets\Valuerange([
                'values' => $aValues
            ]);
            $aParams = ['valueInputOption' => 'RAW'];
            $this->oSheets->spreadsheets_values->update($this->cSheetId, $this->sRange, $oBody, $aParams);
        } catch (Exception $e) {
            echo 'Error general: ' . $e->getMessage();
        }
    }
}
