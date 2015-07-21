<?php

namespace XOrder\Tests;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Uri;
use Mockery as M;
use PHPUnit_Framework_TestCase;
use XOrder\Client;
use XOrder\Credentials;
use XOrder\Contracts\SessionInterface;

/**
 * @covers XOrder\Client
 */
class ClientTest extends PHPUnit_Framework_TestCase {

    /**
     * @after
     */
    public function tearDown() 
    {
        M::close();
    }

    /**
     * @test
     * @covers XOrder\Client::__construct
     */
    public function create_new_client_without_credentials()
    {
        $client = new Client();
        $this->assertInstanceOf('XOrder\Client', $client);
    }

    /**
     * @test
     * @covers XOrder\Client::http
     */
    public function creates_a_new_http_request_if_one_doesnt_exist()
    {
        $client = new Client;
        $request = $client->http();

        $this->assertInstanceOf('GuzzleHttp\\ClientInterface', $request);
    }

    /**
     * @test
     * @covers XOrder\Client::credentials
     */
    public function get_valid_credentials()
    {
        $credentials = new Credentials('username', 'password', 'account');
        $client = new Client($credentials);

        $this->assertInstanceOf('XOrder\\Credentials', $client->credentials());
        $this->assertEquals($credentials, $client->credentials());
    }

    /**
     * @test
     * @expectedException XOrder\Exceptions\InvalidCredentialsException
     * @covers XOrder\Client::credentials
     */
    public function get_credentials_when_credentials_have_not_been_set()
    {
        $client = new Client;
        $credentials = $client->credentials();
    }

    /**
     * @test
     * @covers XOrder\Client::setBaseUri
     * @covers XOrder\Client::getUri
     */
    public function get_full_uri_from_base()
    {
        $client = new Client;
        $base = new Uri('http://test.com');
        $client->setBaseUri($base);
        $uri = $client->getUri('/test');

        $this->assertInstanceOf('Psr\\Http\\Message\\UriInterface', $uri);
        $this->assertEquals('http://test.com/test', (string) $uri);

    }

    /**
     * @test
     * @covers XOrder\Client::getLogonMessage
     */
    public function get_logon_message_body_xml()
    {
        $credentials = new Credentials('username', 'password', 'account');
        $client = new Client($credentials);
        $expected = '<xLogon><userid>username</userid><password>password</password><bcldbNum>account</bcldbNum></xLogon>';

        $xml = $client->getLogonMessage();

        $this->assertEquals($expected, $xml);        
    }

    /**
     * @test
     * @covers XOrder\Client::getLogoutMessage
     */
    public function get_logout_message_body_xml()
    {
        $session = M::mock('XOrder\\Contracts\\SessionInterface');
        $session->shouldReceive('getId')->andReturn(1);
        $session->shouldReceive('isValid')->andReturn(true);
        $session->shouldIgnoreMissing();

        $credentials = new Credentials('username', 'password', 'account');
        $client = new Client($credentials);
        $client->session = $session;
        $expected = '<xLogout><userid>username</userid><sessionId>1</sessionId><bcldbNum>account</bcldbNum></xLogout>';

        $xml = $client->getLogoutMessage();

        $this->assertEquals($expected, $xml);        
    }    

    /**
     * @test
     * @covers XOrder\Client::getLogoutMessage
     * @covers XOrder\Client::logout
     */
    public function logout_from_xorder_servlet()
    {
        // $mock = new MockHandler([
        //     new Response(200, [], '<response></response>')
        // ]);

        // $handler = HandlerStack::create($mock);
        // $http = new HttpClient(['handler' => $handler]);

        // $session = M::mock('XOrder\Contracts\SessionInterface');
        // $session->shouldReceive('getId')->andReturn(1);
        // $session->shouldReceive('isValid')->andReturn(true);

        // $credentials = new Credentials('username', 'password', 'account');
        // $client = new Client($credentials);
        // $client->setHttpClient($http);
        // $client->session = $session;

        // $expected = '<xLogout><userid>username</userid><sessionId>1</sessionId><bcldbNum>account</bcldbNum></xLogout>';

        // $message = $client->getLogoutMessage();
        // $result = $client->logout();

        // $this->assertEquals($expected, $message);
        // $this->assertInstanceOf('XOrder\Contracts\ResponseInterface', $result);        
    }

    /**
     * @test
     * @covers XOrder\Client::session
     * @covers XOrder\Client::hasSession
     * @expectedException XOrder\Exceptions\InvalidSessionException
     */
    public function get_session_when_no_session_has_been_set()
    {
        $client = new Client;
        $session = $client->session();

        $this->assertInstanceOf('XOrder\Contracts\SessionInterface', $session);
    }

    /**
     * @test
     * @covers XOrder\Client::login
     * @expectedException Xorder\Exceptions\InvalidCredentialsException
     */
    public function login_without_credentials()
    {
        $client = new Client;
        $client->login();
    }

    /**
     * @test
     * @covers XOrder\Client::makeRequest
     */
    public function make_new_request()
    {
        $client = new Client;
        $method = 'POST';
        $uri = 'http://test.com';
        $headers = ['Content-Type' => 'text/xml'];
        $body = '<xml></xml>';

        $request = $client->makeRequest($method, $uri, $headers, $body);

        $this->assertInstanceOf('Psr\\Http\\Message\\RequestInterface', $request);
        $this->assertInstanceOf('Psr\\Http\\Message\\UriInterface', $request->getUri());
        $this->assertEquals($method, $request->getMethod());
        $this->assertEquals($body, $request->getBody());
    }

    /**
     * @test
     * @covers XOrder\Client::setBaseUri
     */
    public function set_a_base_uri()
    {
        $client = new Client;
        $uri = new Uri('http://test.com');
        $client->setBaseUri($uri);

        $this->assertInstanceOf('Psr\Http\Message\UriInterface', $client->baseUri);
    }     

    /**
     * @test
     * @covers XOrder\Client::setHttpClient
     * @covers XOrder\Client::http
     */
    public function set_a_http_client()
    {
        $client = new Client();
        $mock = M::mock('GuzzleHttp\\ClientInterface')->shouldIgnoreMissing();
        $client->setHttpClient($mock);
        $httpClient = $client->http();

        $this->assertInstanceOf('GuzzleHttp\\ClientInterface', $httpClient);
        $this->assertEquals($mock, $httpClient);
    }

}