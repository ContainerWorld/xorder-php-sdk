<?php

namespace XOrder\Tests;

use PHPUnit_Framework_TestCase;
use XOrder\Session;

/**
 * @covers XOrder\Session
 */
class SessionTest extends PHPUnit_Framework_TestCase {

    /**
     * @var string
     */
    public $valid = '
        <uservalidation>
            <userstatus>valid</userstatus>
            <username>username</username>
            <sessionId>id</sessionId>
            <bcldbNum>account</bcldbNum>
            <useDiscPriceFlag>N</useDiscPriceFlag>
            <archiveFileFlag>N</archiveFileFlag>
            <useBrandDataFlag>N</useBrandDataFlag>
            <xOrderMessage>xorder</xOrderMessage>
        </uservalidation>';

    /**
     * @var string
     */
    public $invalid = '
        <uservalidation>
            <error>error</error>
        </uservalidation>';

    /**
     * @test
     * @expectedException XOrder\Exceptions\InvalidCredentialsException
     * @covers XOrder\Session::__construct
     * @covers XOrder\Session::set
     */
    public function create_new_session_with_invalid_response()
    {
        $session = new Session($this->invalid);

        $this->assertInstanceOf('XOrder\Session', $session);
    }

    /**
     * @test
     * @covers XOrder\Session::__construct
     * @covers XOrder\Session::set
     */
    public function create_new_session_with_valid_response()
    {
        $session = new Session($this->valid);

        $this->assertInstanceOf('XOrder\Session', $session);
    }

    /**
     * @test
     * @covers XOrder\Session::destroy
     */
    public function destroy_a_session()
    {
        $session = new Session($this->valid);

        $session->destroy();

        $this->assertNull($session->data);
        $this->assertFalse($session->isValid());
    }

    /**
     * @test
     * @covers XOrder\Session::getAccount
     * @covers XOrder\Session::getBcldbNum
     */
    public function get_account_from_valid_session()
    {
        $session = new Session($this->valid);
        $account = $session->getBcldbNum();

        $this->assertEquals('account', $account);
    }

    /**
     * @test
     * @covers XOrder\Session::getId
     */
    public function get_session_id_from_valid_session()
    {
        $session = new Session($this->valid);
        $id = $session->getId();

        $this->assertEquals('id', $id);
    }    

    /**
     * @test
     * @covers XOrder\Session::getMessage
     */
    public function get_message_from_valid_session()
    {
        $session = new Session($this->valid);
        $message = $session->getMessage();

        $this->assertEquals('xorder', $message);
    } 

    /**
     * @test
     * @covers XOrder\Session::getUsername
     */
    public function get_username_from_valid_session()
    {
        $session = new Session($this->valid);
        $username = $session->getUsername();

        $this->assertEquals('username', $username);
    }

    /**
     * @test
     * @covers XOrder\Session::isValid
     */
    public function get_session_is_valid()
    {
        $session = new Session($this->valid);

        $this->assertTrue($session->isValid());
    } 


}