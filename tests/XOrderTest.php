<?php

namespace XOrder\Tests;

use PHPUnit_Framework_TestCase;
use XOrder\XOrder;

/**
 * @covers XOrder\XOrder
 */
class XOrderTest extends PHPUnit_Framework_TestCase {

    /**
     * @test
     * @covers XOrder\XOrder::__construct
     * @covers XOrder\XOrder::fromFile
     */
    public function create_new_xorder_from_filename_in_constructor()
    {
        $xorder = new XOrder('tests/fixtures/xorder.xml', true);

        $this->assertInstanceOf('XOrder\Xorder', $xorder);
        $this->assertInternalType('string', $xorder->getXML());
    }

    /**
     * @test
     * @expectedException XOrder\Exceptions\FileDoesNotExistException
     * @covers XOrder\XOrder::__construct
     * @covers XOrder\XOrder::fromFile
     */
    public function create_new_xorder_from_invlaid_filename_in_constructor()
    {
        $xorder = new XOrder('xorder.xml', true);
    }         

    /**
     * @test
     * @covers XOrder\XOrder::__construct
     * @covers XOrder\XOrder::fromString
     */
    public function create_new_xorder_from_string_in_constructor()
    {
        $xml = file_get_contents('tests/fixtures/xorder.xml');
        $xorder = new XOrder($xml);

        $this->assertInstanceOf('XOrder\Xorder', $xorder);
        $this->assertInternalType('string', $xorder->getXML());
    }

    /**
     * @test
     * @covers XOrder\XOrder::__construct
     * @covers XOrder\XOrder::__toString
     * @covers XOrder\XOrder::getXML
     */
    public function coverts_to_xml_string()
    {
        $xml = file_get_contents('tests/fixtures/xorder.xml');
        $xorder = new XOrder($xml);

        $this->assertInstanceOf('XOrder\Xorder', $xorder);
        $this->assertInternalType('string', (string) $xorder);
    }    

    /**
     * @test
     * @covers XOrder\XOrder::getXML
     */
    public function get_xml_from_valid_xorder()
    {
        $xml = file_get_contents('tests/fixtures/xorder.xml');
        $xorder = new XOrder($xml);

        $this->assertInternalType('string', $xorder->getXML());
    }

}