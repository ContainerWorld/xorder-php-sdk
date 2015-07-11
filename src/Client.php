<?php

/**
 * xOrder Client.
 *
 * @package     container-world/xorder
 * @author      Ryan Stratton <ryan@craftt.com>
 * @copyright   Copyright (c) Ryan Stratton
 * @license     https://github.com/craftt/xorder-php-sdk/blob/master/LICENSE.md Apache 2.0
 * @link        https://github.com/craftt/xorder-php-sdk
 */

namespace XOrder;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\ClientInterface as HttpClientInterface;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use XOrder\Contracts\ClientInterface;
use XOrder\Contracts\SessionInterface;
use XOrder\Credentials;
use XOrder\Exceptions\InvalidCredentialsException;
use XOrder\Exceptions\InvalidSessionException;
use XOrder\Exceptions\XOrderConnectionException;
use XOrder\Response;
use XOrder\Session;

/**
 * Client
 */
class Client implements ClientInterface {

    /**
     * @var \Psr\Http\Message\UriInterface
     */
    public $baseUri;

    /**
     * @var \XOrder\Credentials
     */
    public $credentials;

    /**
     * @var \GuzzleHttp\ClientInterface
     */
    public $http;

    /**
     * @var \XOrder\SessionInterface
     */
    public $session;

    /**
     * Constructor
     *
     * @param \XOrder\Credentials|null $credentials
     */
    public function __construct(Credentials $credentials = null)
    {
        $this->credentials = $credentials;
        $this->baseUri = new Uri('http://styx.containerworld.ca/');
    }

    /**
     * Logout from the
     */
    public function __destruct()
    {
        $this->logout();
    }

    /**
     * Get the credentials.
     *
     * @return \XOrder\Credentials
     */
    public function credentials()
    {
        if (!$this->hasCredentials()) {
            throw new InvalidCredentialsException('Please set your credentials!');
        }

        return $this->credentials;
    }

    /**
     * Get the logon xml.
     *
     * @return string
     */
    public function getLogonMessage()
    {
        list($username, $password, $account) = $this->credentials()->toArray();
        $xml = '<xLogon><userid>%s</userid><password>%s</password><bcldbNum>%s</bcldbNum></xLogon>';
        return sprintf($xml, $username, $password, $account);
    }

    /**
     * Get the logout xml.
     *
     * @return string
     */
    public function getLogoutMessage()
    {
        list($username, , $account) = $this->credentials()->toArray();
        $xml = '<xLogout><userid>%s</userid><sessionId>%s</sessionId><bcldbNum>%s</bcldbNum></xLogout>';
        return sprintf($xml, $username, $this->session()->getId(), $account);
    }

    /**
     * Build a uri based on the baseUri.
     *
     * @param  string $path
     * @return \Psr\Http\Message\UriInterface
     */
    public function getUri($path)
    {
        return new Uri($this->baseUri . $path);
    }

    /**
     * Check if the client has the login credentials.
     *
     * @return boolean
     */
    public function hasCredentials()
    {
        return ($this->credentials instanceof Credentials);
    }

    /**
     * Check if the client has an active session.
     *
     * @return boolean
     */
    public function hasSession()
    {
        return ($this->session instanceof SessionInterface && $this->session->isValid());
    }

    /**
     * Get the guzzle client. If one doesn't exist
     * we'll create one.
     *
     * @return \GuzzleHttp\Client
     */
    public function http()
    {
        if (!$this->http instanceof HttpClientInterface) {
            $this->http = new HttpClient;
        }

        return $this->http;
    }

    /**
     * Login to the Container World LoginServlet.
     *
     * @param  \XOrder\Credentials [$credentials]
     * @return \XOrder\Client
     */
    public function login(Credentials $credentials = null)
    {
        if (!is_null($credentials)) {
            $this->credentials = $credentials;
        }

        $request = $this->makeRequest('POST', $this->getUri('xOrder/LogonServlet'), [
                'Content-Type' => 'text/xml'
            ], $this->getLogonMessage());

        $response = $this->http()->send($request);

        if ($response->getStatusCode() !== 200 || !$response instanceof ResponseInterface) {
            throw new XOrderConnectionException('Could not connect to xOrder.');
        }

        $this->session = new Session($response->getBody()->getContents());
        
        return $this;
    }

    /**
     * End the session with the container world xOrder servlet.
     *
     * @return \XOrder\Response|boolean
     */
    public function logout()
    {
        if (!$this->hasSession()) {
            return true;
        }

        $request = $this->makeRequest('POST', $this->getUri('xOrder/LogonServlet'), [
                'Content-Type' => 'text/xml'
            ], $this->getLogoutMessage());

        $response = $this->http()->send($request);

        if ($response->getStatusCode() !== 200 || !$response instanceof ResponseInterface) {
            throw new XOrderConnectionException('Could not connect to xOrder.');
        }

        $this->session()->destroy();

        return new Response($response->getBody()->getContents());
    }

    /**
     * Generate a new request messsage.
     *
     * @param  string $method
     * @param  string $uri
     * @param  array $headers
     * @param  string $body
     * @return \Psr\Http\Message\RequestInterface
     */
    public function makeRequest($method, $uri, $headers, $body)
    {
        return new Request($method, $uri, $headers, $body);
    }

    /**
     * Send an order to the xOrder servlet.
     *
     * @param  \XOrder\XOrder $xorder
     * @param  boolean $validate
     * @return \XOrder\Response
     */
    public function send(XOrder $xorder, $validate = false)
    {
        $contentType = $validate ? 'validate/xml' : 'text/xml';

        $response = $this->http()->send(
            $this->makeRequest('POST', $this->getUri('xOrder/xOrderServlet'), [
                'Content-Type' => $contentType,
                'userid' => $this->credentials()->getUsername(),
                'password' => $this->credentials()->getPassword(),
                'sessionId' => $this->session()->getId(),
                'bcldbNum' => $this->credentials()->getAccount(),
                'filename' => 'xorder.xml'
            ], $xorder->getXML())
        );

        if ($response->getStatusCode() !== 200 || !$response instanceof ResponseInterface) {
            throw new \Exception('Could not connect to xOrder.');
        }

        return new Response($response->getBody()->getContents());
    }

    /**
     * Get the session object.  If one doesn't exist
     * we'll create one.
     *
     * @return \XOrder\SessionInterface
     */
    public function session()
    {
        if (!$this->hasSession()) {
            throw new InvalidSessionException('You must login before sending xorders.');
        }

        return $this->session;
    }

    /**
     * Set the base URI.
     *
     * @param Psr\Http\Message\UriInterface $uri
     */
    public function setBaseUri(UriInterface $uri)
    {
        $this->baseUri = $uri;
    }

    /**
     * Set the HTP Client.
     *
     * @param \GuzzleHttp\ClientInterface $client
     */
    public function setHttpClient(HttpClientInterface $client)
    {
        $this->http = $client;
    }

    /**
     * Send a request to the XOrder Servlet to validate
     * the passed order.
     *
     * @param  \XOrder\XOrder $xorder
     * @return \XOrder\Response
     */
    public function validate(XOrder $xorder)
    {
        return $this->send($xorder, true);
    }

}
