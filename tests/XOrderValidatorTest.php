<?php

namespace XOrder\Tests;

use PHPUnit_Framework_TestCase;
use XOrder\XOrder;
use XOrder\XOrderValidator;

/**
 * @covers XOrder\XOrderValidator
 */
class XOrderValidatorTest extends PHPUnit_Framework_TestCase {

    /**
     * @test
     * @covers XOrder\XOrderValidator::__construct
     */
    public function create_new_xorder_validator()
    {
        $xorder = new XOrder('tests/fixtures/xorder.xml', true);
        $validator = new XOrderValidator($xorder);

        $this->assertInstanceOf('XOrder\XOrderValidator', $validator);
    }

    /**
     * @test
     * @covers XOrder\XOrderValidator::getSchema
     */
    public function get_default_schema_filename()
    {
        $xorder = new XOrder('tests/fixtures/xorder.xml', true);
        $validator = new XOrderValidator($xorder);
        $schema = $validator->getSchema();

        $this->assertInternalType('string', $schema);
    }

    /**
     * @test
     * @covers XOrder\XOrderValidator::getSchema
     */
    public function get_schema_filename_that_does_exist()
    {
        $xorder = new XOrder('tests/fixtures/xorder.xml', true);
        $validator = new XOrderValidator($xorder);
        $schema = $validator->getSchema('./src/Schema/XOrderSchema.xsd');

        $this->assertInternalType('string', $schema);
    }      

    /**
     * @test
     * @covers XOrder\XOrderValidator::getSchema
     * @expectedException XOrder\Exceptions\FileDoesNotExistException
     */
    public function get_schema_filename_that_does_not_exist()
    {
        $xorder = new XOrder('tests/fixtures/xorder.xml', true);
        $validator = new XOrderValidator($xorder);
        $schema = $validator->getSchema('fake_schema.xml');
    }    

    /**
     * @test
     * @covers XOrder\XOrderValidator::validate
     */
    public function validates_a_valid_xorder()
    {
        $xorder = new XOrder('tests/fixtures/xorder.xml', true);
        $validator = new XOrderValidator($xorder);

        $this->assertTrue($validator->validate());
    }

    /**
     * @test
     * @covers XOrder\XOrderValidator::validate
     * @covers XOrder\Exceptions\XOrderValidationException::__construct
     * @expectedException XOrder\Exceptions\XOrderValidationException
     */
    public function validates_an_invalid_xorder()
    {
        $xorder = new XOrder('<fakeOrder></fakeOrder>');
        $validator = new XOrderValidator($xorder);
        $validator->validate();
    }

}