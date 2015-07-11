<?php

namespace XOrder\Tests;

use PHPUnit_Framework_TestCase;
use XOrder\Response;

/**
 * @covers XOrder\Response
 */
class ResponseTest extends PHPUnit_Framework_TestCase {

    /**
     * @var string
     */
    public $xml = '<userlogout><userstatus>loggedoff</userstatus><username>username</username></userlogout>';

    /**
     * @test
     * @covers XOrder\Response::__construct
     */
    public function create_new_response()
    {
        $response = new Response($this->xml);

        $this->assertInstanceOf('XOrder\Response', $response);
    }

    /**
     * @test
     * @covers XOrder\Response::toArray
     */
    public function covert_response_to_array()
    {
        $response = new Response($this->xml);
        
        $array = $response->toArray();

        $this->assertArrayHasKey('userstatus', $array);
    }

    /**
     * @test
     * @covers XOrder\Response::toJson
     */
    public function covert_response_to_json()
    {
        $response = new Response($this->xml);
        
        $json = $response->toJson();

        $this->assertInternalType('string', $json);
    }

    /**
     * @test
     * @covers XOrder\Response::__get
     */
    public function get_all_response_data_from_property_overloader()
    {
        $response = new Response($this->xml);
        $data = $response->data;

        $this->assertInstanceOf('SimpleXMLElement', $data);
    }   

    /**
     * @test
     * @covers XOrder\Response::__get
     */
    public function get_data_from_property_overloader_that_does_not_exist()
    {
        $response = new Response($this->xml);
        $data = $response->fake_proeprty_name;

        $this->assertNull($data);
    }        

    /**
     * @test
     * @covers XOrder\Response::__get
     */
    public function get_userstatus_using_property_overloader()
    {
        $response = new Response($this->xml);
        $data = $response->userstatus;

        $this->assertEquals('loggedoff', $data);
    }

}