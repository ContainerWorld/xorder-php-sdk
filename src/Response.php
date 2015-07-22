<?php

/**
 * xOrder Response.
 *
 * @package     craftt/xorder-sdk
 * @author      Ryan Stratton <ryan@craftt.com>
 * @copyright   Copyright (c) Ryan Stratton
 * @license     https://github.com/craftt/xorder-php-sdk/blob/master/LICENSE.md Apache 2.0
 * @link        https://github.com/craftt/xorder-php-sdk
 */

namespace XOrder;

use SimpleXMLElement;
use XOrder\Contracts\ResponseInterface;

/**
 * Session
 */
class Response implements ResponseInterface
{

    /**
     * @var \SimpleXMLElement
     */
    private $data;

    /**
     * Constructor
     *
     * @param string $xml
     */
    public function __construct($xml)
    {
        $this->data = new SimpleXMLElement($xml);
    }

    /**
     * Property overloader.
     *
     * @param  string $property
     * @throws \ErrorException
     * @return mixed
     */
    public function __get($property)
    {
        if ($property === 'data') {
            return $this->data;
        }

        if (property_exists($this->data, $property)) {
            return $this->data->$property;
        }

        return null;
    }

    /**
     * Covert XML response data to array.
     *
     * @return array
     */
    public function toArray()
    {
        return json_decode($this->toJson(), true);
    }

    /**
     * Convery XML response data to JSON.
     *
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->data);
    }
}
