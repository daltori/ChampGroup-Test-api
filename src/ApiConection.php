<?php

/**
 * ApiConection.php -- Class for making requests to the API at https://pokerocket.com/
 *                    
 * Test 
 *
 * @author		ChampGroup
 * @author		David Alejandro T. - <ing.david.torres@outlook.com>
 * @version		1.0
 * 
 */
$aConfig = include('config.php');
class ApiConection
{
    private $cUrl ;
    public function __construct($cUrl)
    {
        $this->cUrl = $cUrl;
    }
/**
 * Curl execution
 * @param  String $sEndpoint       -String containing the request to execute.
 * @param  String $sType           -The request type  'GET' or 'POST'.
 * @param  Array  [$aHeaders]      -(Optional) Request headers.
 * @return Array  $oResponse       -Response data from the API endpoint.
 */
    function f_ExeCurl($sEndpoint, $sType, $aHeaders = [])
    {
        $oCurl    = curl_init();
        $aCurlCof = array(
            CURLOPT_URL => $this->cUrl . $sEndpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $sType,
            CURLOPT_HTTPHEADER => $aHeaders
        );
        curl_setopt_array($oCurl, $aCurlCof);
        $oResponse['response'] = curl_exec($oCurl);
        $oResponse['code']     = curl_getinfo($oCurl, CURLINFO_HTTP_CODE);
        if (curl_errno($oCurl)) {
            $oResponse['error'] = curl_error($oCurl);
        }
        curl_close($oCurl);
        return $oResponse;
    }

    function f_AddToken( $sToken, $aHeaders = [])
    {
        array_push($aHeaders, 'Authorization: Bearer ' . $sToken);
        return $aHeaders;
    }

    function f_validateStatus($aRespose){
        if ($aRespose['code'] != 200){
    
            echo('A mistake happened in the request.');
            echo('<br>');
            echo('Code : '.$aRespose['code']);
            echo('<br>');
            echo('Error : '.$aRespose['error']);
            echo('<br>');
            die();
        }
    
     }
}
