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
 * Class tabsltrackingmore_oxorder
 */
class tabsltrackingmore_oxorder extends tabsltrackingmore_oxorder_parent
{

    /**
     * @var null|object
     */
    protected $_oTabslTrackingMore = null;

    /**
     * tabsltrackingmore_oxorder constructor.
     * @throws oxSystemComponentException
     */
    public function __construct()
    {
        parent::__construct();
        $this->_oTabslTrackingMore = oxNew('tabsltrackingmore_core');
    }

    /**
     * @return mixed
     */
    public function getTtmLastStatus()
    {
        $this->_oTabslTrackingMore->setOrder($this);
        return $this->_oTabslTrackingMore->getLastStatus();
    }

    /**
     * @return mixed
     */
    public function getTtmExpectedDeliveryDate()
    {
        $this->_oTabslTrackingMore->setOrder($this);
        return $this->_oTabslTrackingMore->getExpectedDeliveryTime();
    }


}
