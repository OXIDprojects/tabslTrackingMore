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

/**
 * Class tabsltrackingmore_tracking
 */
class tabsltrackingmore_tracking extends oxAdminDetails
{

    /**
     * @return string
     */
    public function render()
    {
        parent::render();
        return "tabsltrackingmore_tracking.tpl";
    }

    /**
     * @return mixed
     * @throws oxSystemComponentException
     */
    public function getParcels()
    {
        $sOrderId = $this->getEditObjectId();
        $oOrder = oxNew('oxOrder');
        if ($oOrder->load($sOrderId)) {
            $oTabslTrackingMore = oxNew('tabsltrackingmore_core');
            $oTabslTrackingMore->setOrder($oOrder);
            return $oTabslTrackingMore->getStatusHistory();
        }
    }

}
