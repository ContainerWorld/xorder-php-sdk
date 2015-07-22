<?php

/**
 * xOrder Response Interface.
 *
 * @package     craftt/xorder-sdk
 * @author      Ryan Stratton <ryan@craftt.com>
 * @copyright   Copyright (c) Ryan Stratton
 * @license     https://github.com/craftt/xorder-php-sdk/blob/master/LICENSE.md Apache 2.0
 * @link        https://github.com/craftt/xorder-php-sdk
 */

namespace XOrder\Contracts;

/**
 * XOrder Interface
 */
interface ResponseInterface
{

    /**
     * Covert XML response data to array.
     *
     * @return array
     */
    public function toArray();

    /**
     * Convery XML response data to JSON.
     *
     * @return string
     */
    public function toJson();
}
