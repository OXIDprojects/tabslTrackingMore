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
 * Metadata version
 */
$sMetadataVersion = '1.1';

/**
 * Module information
 */
$aModule = [
    'id'          => 'tabslTrackingMore',
    'title'       => 'tabsl|TrackingMore',
    'description' => 'Tracking module for https://www.trackingmore.com/api-index-en.html',
    'thumbnail'   => '',
    'version'     => '1.0.0',
    'author'      => 'Tobias Merkl',
    'url'         => 'https://github.com/tabsl/tabslTrackingMore',
    'email'       => '',
    'extend'      => [
        'oxorder' => 'tabsl/tabslTrackingMore/application/models/tabsltrackingmore_oxorder',
    ],
    'files'       => [
        'tabsltrackingmore_core'     => 'tabsl/tabslTrackingMore/application/models/tabsltrackingmore_core.php',
        'tabsltrackingmore_tracking' => 'tabsl/tabslTrackingMore/application/controllers/admin/tabsltrackingmore_tracking.php',
    ],
    'templates'   => [
        'tabsltrackingmore_tracking.tpl' => 'tabsl/tabslTrackingMore/application/views/admin/tpl/tabsltrackingmore_tracking.tpl',
    ],
    'blocks'      => [
        ['template' => 'order_overview.tpl', 'block' => 'admin_order_overview_checkout', 'file' => '/out/blocks/admin_order_overview_checkout.tpl'],

    ],
    'settings'    => [
    ],
];
