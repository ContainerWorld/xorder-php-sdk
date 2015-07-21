<?php

/**
 * xOrder Client Credentials.
 *
 * @package     craftt/xorder-php
 * @author      Ryan Stratton <ryan@craftt.com>
 * @copyright   Copyright (c) Ryan Stratton
 * @license     https://github.com/craftt/xorder-php-sdk/blob/master/LICENSE.md Apache 2.0
 * @link        https://github.com/craftt/xorder-php-sdk
 */

namespace XOrder;

/**
 * Credentials
 */
class Credentials {

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $account;

    /**
     * Constructor
     *
     * @param string $username
     * @param string $password
     * @param string $account
     */
    public function __construct($username, $password, $account)
    {
        $this->username = $username;
        $this->password = $password;
        $this->account = $account;
    }

    /**
     * Returns a comma seperated string of the credentials
     * properties without the password.
     *
     * @return string
     */
    public function __toString()
    {
        return implode(',', $this->toArray());
    }

    /**
     * Get the BCLDB account id.
     *
     * @return string
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Get the BCLDB account id.
     *
     * @return string
     */
    public function getBcldbId()
    {
        return $this->getAccount();
    }

    /**
     * Get the password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get the user's credentials as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [$this->username, $this->password, $this->account];
    }
    
}
