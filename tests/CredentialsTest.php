<?php

namespace XOrder\Tests;

use PHPUnit_Framework_TestCase;
use XOrder\Credentials;

/**
 * @covers XOrder\Credentials
 */
class CredentialsTest extends PHPUnit_Framework_TestCase {

    /**
     * @test
     * @covers XOrder\Credentials::__construct
     */
    public function create_new_credentials()
    {
        $credentials = new Credentials('username', 'password', 'account');
        
        $this->assertInstanceOf('XOrder\\Credentials', $credentials);
    } 

    /**
     * @test
     * @covers XOrder\Credentials::__toString
     * @covers XOrder\Credentials::toArray
     */
    public function covert_credentials_to_array()
    {
        $credentials = new Credentials('username', 'password', 'account');
        $expected = ['username', 'password', 'account'];
        $array = $credentials->toArray();

        $this->assertTrue(is_array($array));
        $this->assertEquals($expected, $array);
    } 

    /**
     * @test
     * @covers XOrder\Credentials::toArray
     */
    public function covert_credentials_to_string()
    {
        $credentials = new Credentials('username', 'password', 'account');
        $expected = 'username,password,account';
        $string = (string) $credentials;

        $this->assertTrue(is_string($string));
        $this->assertEquals($expected, $string);
    }    

    /**
     * @test
     * @covers XOrder\Credentials::getAccount
     */
    public function get_account()
    {
        $credentials = new Credentials('username', 'password', 'account');
        $account = $credentials->getAccount();

        $this->assertEquals('account', $account);
    }    

    /**
     * @test
     * @covers XOrder\Credentials::getAccount
     * @covers XOrder\Credentials::getBcldbId
     */
    public function get_bcldb_id()
    {
        $credentials = new Credentials('username', 'password', 'account');
        $account = $credentials->getBcldbId();

        $this->assertEquals('account', $account);
    }

    /**
     * @test
     * @covers XOrder\Credentials::getPassword
     */
    public function get_password()
    {
        $credentials = new Credentials('username', 'password', 'account');
        $password = $credentials->getPassword();

        $this->assertEquals('password', $password);
    }

    /**
     * @test
     * @covers XOrder\Credentials::getUsername
     */
    public function get_username()
    {
        $credentials = new Credentials('username', 'password', 'account');
        $username = $credentials->getUsername();

        $this->assertEquals('username', $username);
    }   

}