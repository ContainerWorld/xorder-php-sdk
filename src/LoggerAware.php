<?php

/**
 * Logger Aware Trait.
 *
 * @package     craftt/xorder-php
 * @author      Ryan Stratton <ryan@craftt.com>
 * @copyright   Copyright (c) Ryan Stratton
 * @license     https://github.com/craftt/xorder-php-sdk/blob/master/LICENSE.md Apache 2.0
 * @link        https://github.com/craftt/xorder-php-sdk
 */

namespace XOrder;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

trait LoggerAware {

    /**
     * @var \Psr\Log\LoggerInterface
     */
    public $logger;

    /**
     * Check if the instance has a valid logger.
     * 
     * @return boolean
     */
    public function hasLogger()
    {
        return ($this->logger instanceof LoggerInterface);
    }

    /**
     * Get the logger instance.
     * 
     * @return \Psr\Log\LoggerInterface
     */
    public function logger()
    {
        if (!$this->hasLogger()) {
            $this->logger = new NullLogger;
        }

        return $this->logger;
    }

    /**
     * Sets a logger instance on the object
     *
     * @param LoggerInterface $logger
     * @return null
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

}
