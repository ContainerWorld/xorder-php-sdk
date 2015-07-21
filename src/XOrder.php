<?php

/**
 * xOrder.
 *
 * @package     craftt/xorder-php
 * @author      Ryan Stratton <ryan@craftt.com>
 * @copyright   Copyright (c) Ryan Stratton
 * @license     https://github.com/craftt/xorder-php-sdk/blob/master/LICENSE.md Apache 2.0
 * @link        https://github.com/craftt/xorder-php-sdk
 */

namespace XOrder;

use XOrder\Contracts\XOrderInterface;
use XOrder\Exceptions\FileDoesNotExistException;

/**
 * XOrder
 */
class XOrder implements XOrderInterface {

    /**
     * @var \SimpleXMLElement
     */
    public $xml;

    /**
     * Constructor
     *
     * To create an XOrder you can pass either a file path
     * or the xml as a string.  Just make sure to pass true
     * as the second argument when passing a file path.
     *
     * @param string  $xml
     * @param boolean $file
     */
    public function __construct($xml, $file = false)
    {
        if ($file) {
            $this->fromFile($xml);
        }

        else {
            $this->fromString($xml);
        }
    }

    /**
     * Get the string representation of the XML builder
     * object.
     *
     * @return string
     */
    public function getXML()
    {
        return $this->xml->saveXML();
    }

    /**
     * Load the xml order from file.
     *
     * @param  string $xml
     * @throws \XOrder\Exceptions\FileDoesNotExistException
     * @return \XOrder\XOrder
     */
    public function fromFile($xml)
    {
        if (!file_exists($xml)) {
            throw new FileDoesNotExistException('The xorder file does not exists.');
        }

        $this->xml = simplexml_load_file($xml);

        return $this;
    }

    /**
     * load the xml order from string.
     *
     * @param  string $xml
     * @return \XOrder\XOrder
     */
    public function fromString($xml)
    {
        $this->xml = simplexml_load_string($xml);

        return $this;
    }

    /**
     * Get the string representation of the XML builder
     * object.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getXML();
    }

}
