<?php

/**
 * xOrder Validator.
 *
 * @package     container-world/xorder
 * @author      Ryan Stratton <ryan@craftt.com>
 * @copyright   Copyright (c) Ryan Stratton
 * @license     https://github.com/craftt/xorder-php-sdk/blob/master/LICENSE.md Apache 2.0
 * @link        https://github.com/craftt/xorder-php-sdk
 */

namespace XOrder;

use XOrder\Exceptions\FileDoesNotExistException;
use XOrder\Exceptions\XOrderValidationException;

/**
 * XOrder
 */
class XOrderValidator {

    /**
     * @var array
     */
    public $errors = [];

    /**
     * @var string
     */
    public $schema = '/schema/XOrderSchema.xsd';

    /**
     * Constructor
     *
     * @param XOrder\XOrder $xorder
     */
    public function __construct(XOrder $xorder)
    {
        $this->xorder = $xorder;
    }

    /**
     * Get the schema file.
     *
     * @param  string|null $schema
     * @return string
     */
    public function getSchema($schema = null)
    {
        if (is_null($schema)) {
            return __DIR__ . $this->schema;
        }

        if (!file_exists($schema)) {
            throw new FileDoesNotExistException('The schema file does not exists.');
        }

        return $schema;
    }

    /**
     * Validate the xml document against the xOrder Schema.  Or
     * you can pass in the path to your preferred schema.
     *
     * @param  string|null $schema
     * @throws \XOrder\Exceptions\XOrderValidationException
     * @return boolean
     */
    public function validate($schema = null)
    {
        libxml_use_internal_errors(true);

        $dom = dom_import_simplexml($this->xorder->xml)->ownerDocument;
        $valid = $dom->schemaValidate($this->getSchema($schema));

        if (!$valid) {
            $errors = libxml_get_errors();
            throw new XOrderValidationException($errors);
        }

        libxml_use_internal_errors(false);

        return $valid;
    }

}
