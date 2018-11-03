<?php
/**
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @copyright (c) Tobias Merkl | 2018
 * @link https://oxid-module.eu
 * @package tabslTrackingMore
 * @version 1.0.0
 **/

require_once(getShopBasePath() . 'modules/tabsl/tabslTrackingMore/core/libs/TrackingMore.php');

/**
 * Class tabsltrackingmore_core
 */
class tabsltrackingmore_core extends oxSuperCfg
{
    /**
     * @var string
     */
    CONST PARCEL_DELIMITER = ',';

    /**
     * @var null
     */
    protected $_oOrder = null;

    /**
     * @var string
     */
    protected $_sDefaultCarrier = 'dhl-germany';

    /**
     * @var string
     */
    protected $_dhlTrackApiUrl = 'https://www.dhl.de/int-verfolgen/search?';

    /**
     * @return array
     */
    public function getStatusHistory()
    {
        foreach ($this->getParcels() as $sParcel) {
            $aParcel = $this->_getTrackDataFromApi($sParcel);
            foreach ($aParcel['data']['origin_info']['trackinfo'] as $aStatus) {
                $sDescription = $this->_clearChars($aStatus['StatusDescription']);
                $aStati[] = ['status' => $sDescription, 'label' => $this->getParcelLabel($sDescription), 'date' => $aStatus['Date'], 'details' => $aStatus['Details'], 'cpstatus' => $aStatus['checkpoint_status']];
            }
            $aParcels[$sParcel] = ['status' => $aStati, 'time' => $aParcel['data']['stayTimeLength']];
        }

        return $aParcels;
    }

    /**
     * @return int
     */
    public function getLastStatus()
    {
        foreach ($this->getParcels() as $sParcel) {
            $aParcel = $this->_getTrackDataFromApi($sParcel);
            $sDescription = $this->_clearChars($aParcel['data']['origin_info']['trackinfo'][0]['StatusDescription']);
            $aParcels[$sParcel] = ['status' => $sDescription, 'label' => $this->getParcelLabel($sDescription), 'date' => $aParcel['data']['origin_info']['trackinfo'][0]['Date'], 'time' => $aParcel['data']['stayTimeLength']];
        }

        return $aParcels;
    }

    /**
     * @param $sParcel
     * @return null
     * @throws oxSystemComponentException
     */
    public function getExpectedDeliveryTime($sParcel)
    {
        $oCurl = oxNew('oxCurl');
        $oCurl->setMethod('GET');
        $sLanguage = $this->_getOrderLanguage();
        $oCurl->setUrl($this->_dhlTrackApiUrl . 'language=' . $sLanguage . '&lang=' . $sLanguage . '&domain=' . $sLanguage . '&piececode=' . $sParcel);
        $sOutput = $oCurl->execute();

        preg_match('/zustellung(.*)istZugestellt/', $sOutput, $matches, PREG_OFFSET_CAPTURE, 0);
        $sData = $matches[0][0];
        $sData = str_replace('\\', '', $sData);
        $sData = str_replace('+02:00', '', $sData);
        $sData = '{"' . str_replace(',"istZugestellt', '}', $sData);
        $oData = json_decode($sData);

        if ($oData->zustellung->zustellzeitfensterVon && $oData->zustellung->zustellzeitfensterBis) {
            $aData['from'] = str_replace('T', ' ', $oData->zustellung->zustellzeitfensterVon);
            $aData['to'] = str_replace('T', ' ', $oData->zustellung->zustellzeitfensterBis);
            return $aData;
        }

        return null;
    }

    /**
     * @return array
     */
    public function getParcels()
    {
        if (strstr($this->_oOrder->oxorder__oxtrackcode->value, self::PARCEL_DELIMITER)) {
            $aParcels = explode(self::PARCEL_DELIMITER, $this->_oOrder->oxorder__oxtrackcode->value);
        } else {
            $aParcels[] = $this->_oOrder->oxorder__oxtrackcode->value;
        }

        return $aParcels;
    }

    /**
     * @param $sStatus
     * @return string
     */
    public function getParcelLabel($sStatus)
    {
        if (strstr($sStatus, 'erfolgreich zugestellt') || strstr($sStatus, '  abgeholt')) {
            return 'green';
        }

        return 'black';
    }

    /**
     * @param oxOrder $oOrderObject
     */
    public function setOrder(oxOrder $oOrderObject)
    {
        if ($this->_oOrder === null) {
            if (is_object($oOrderObject)) {
                $this->_oOrder = $oOrderObject;
            }
        }
    }

    /**
     * @return array|null
     */
    protected function _getTrackDataFromApi($sParcel)
    {
        try {
            $oTrack = new TrackingMore();
            $aTrackData = $oTrack->getSingleTrackingResult($this->_sDefaultCarrier, $sParcel, $this->_getOrderLanguage());
            return $aTrackData;
        } catch (Exception $oEx) {
            $oUtilsView = oxRegistry::get("oxUtilsView");
            $oUtilsView->addErrorToDisplay($oEx, false);
        }

        return null;
    }

    /**
     * @return string
     */
    protected function _getOrderLanguage()
    {
        return oxRegistry::getLang()->getLanguageAbbr($this->_oOrder->oxorder__oxlang->value);
    }

    /**
     * @param $str
     * @return null|string|string[]
     */
    protected
    function _clearChars($str)
    {
        $str = str_replace('\u', 'u', $str);
        return preg_replace('/u([\da-fA-F]{4})/', '&#x\1;', $str);
    }

}
