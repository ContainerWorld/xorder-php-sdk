<?php

/**
 * xOrder Session Interface.
 *
 * @package     container-world/xorder
 * @author      Ryan Stratton <ryan@craftt.com>
 * @copyright   Copyright (c) Ryan Stratton
 * @license     https://github.com/craftt/xorder-php-sdk/blob/master/LICENSE.md Apache 2.0
 * @link        https://github.com/craftt/xorder-php-sdk
 */

namespace XOrder\Contracts;

/**
 * Session Interface
 */
interface SessionInterface {

    /**
     * Destroy the session data.
     *
     * @return void
     */
    public function destroy();

    /**
     * Get the BCLDB account number.
     *
     * @return string
     */
    public function getAccount();

    /**
     * Get the BCLDB account number.
     *
     * @return string
     */
    public function getBcldbNum();

    /**
     * Get the session id.
     *
     * @return string
     */
    public function getId();

    /**
     * Get the xOrder message.
     *
     * @return string
     */
    public function getMessage();

    /**
     * Get the username.
     *
     * @return string
     */
    public function getUsername();

    /**
     * Check of the session has an error.
     *
     * @return boolean
     */
    public function hasError();

    /**
     * Check if the session is valid.
     *
     * @return boolean
     */
    public function isValid();

    /**
     * Create the session from a response.
     *
     * @param  string $response
     * @return this
     */
    public function set($response);    
    
}
