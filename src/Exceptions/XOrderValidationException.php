<?php

/**
 * xOrder Validation Exception.
 *
 * @package     craftt/xorder-sdk
 * @author      Ryan Stratton <ryan@craftt.com>
 * @copyright   Copyright (c) Ryan Stratton
 * @license     https://github.com/craftt/xorder-php-sdk/blob/master/LICENSE.md Apache 2.0
 * @link        https://github.com/craftt/xorder-php-sdk
 */

namespace XOrder\Exceptions;

use Exception;

/**
 * XOrder Validation Exception
 * @codeCoverageIgnore
 */
class XOrderValidationException extends Exception
{

    /**
     * @var array
     */
    public $errors;

    /**
     * Constructor
     *
     * @param array $errors
     */
    public function __construct(array $errors)
    {
        parent::__construct($errors[0]->message);
        $this->errors = $errors;
    }

    /**
     * Get the array of xml validation errors.
     *
     * @return array
     */
    final public function getErrors()
    {
        return $this->errors;
    }
}
