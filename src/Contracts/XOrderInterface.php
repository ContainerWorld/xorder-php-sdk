<?php

/**
 * xOrder Interface.
 *
 * @package     craftt/xorder-php
 * @author      Ryan Stratton <ryan@craftt.com>
 * @copyright   Copyright (c) Ryan Stratton
 * @license     https://github.com/craftt/xorder-php-sdk/blob/master/LICENSE.md Apache 2.0
 * @link        https://github.com/craftt/xorder-php-sdk
 */

namespace XOrder\Contracts;

/**
 * XOrder Interface
 */
interface XOrderInterface {

    /**
     * Get the string representation of the XML object.
     *
     * @return string
     */
    public function getXML();
  
}
