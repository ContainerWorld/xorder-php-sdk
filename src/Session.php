<?php

/**
 * xOrder Session.
 *
 * @package     container-world/xorder
 * @author      Ryan Stratton <ryan@craftt.com>
 * @copyright   Copyright (c) Ryan Stratton
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        https://github.com/craftt/xorder-php-sdk
 */

namespace XOrder;

use SimpleXMLElement;
use XOrder\Contracts\SessionInterface;
use XOrder\Exceptions\InvalidCredentialsException;

/**
 * Session
 */
class Session implements SessionInterface {

    /**
     * @var \SimpleXMLElement
     */
    public $data;

    /**
     * Constructor
     *
     * @param string|null $response
     */
    public function __construct($response)
    {
        $this->set($response);

        if ($this->hasError()) {
            throw new InvalidCredentialsException($this->data->error);
        }
    }

    /**
     * Destroy the session data.
     *
     * @return void
     */
    public function destroy()
    {
        $this->data = null;
    }

    /**
     * Get the BCLDB account number.
     *
     * @return string
     */
    public function getAccount()
    {
        return (string) $this->data->bcldbNum;
    }

    /**
     * Get the BCLDB account number.
     *
     * @return string
     */
    public function getBcldbNum()
    {
        return $this->getAccount();
    }

    /**
     * Get the session id.
     *
     * @return string
     */
    public function getId()
    {
        return (string) $this->data->sessionId;
    }

    /**
     * Get the xOrder message.
     *
     * @return string
     */
    public function getMessage()
    {
        return (string) $this->data->xOrderMessage;
    }

    /**
     * Get the username.
     *
     * @return string
     */
    public function getUsername()
    {
        return (string) $this->data->username;
    }

    /**
     * Check of the session has an error.
     *
     * @return boolean
     */
    public function hasError()
    {
        return property_exists($this->data, 'error');
    }

    /**
     * Check if the session is valid.
     *
     * @return boolean
     */
    public function isValid()
    {
        return ($this->data instanceof SimpleXMLElement
            && property_exists($this->data, 'userstatus')
            && (string) $this->data->userstatus === 'valid');
    }

    /**
     * Create the session from a response.
     *
     * @param  string $response
     * @throws \XOrder\InvalidCredentialsException
     * @return this
     */
    public function set($response)
    {
        $this->data = new SimpleXMLElement($response);
        return $this;
    }

}
