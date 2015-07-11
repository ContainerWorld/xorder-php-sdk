<?php

namespace XOrder\Tests\Exceptions;

use PHPUnit_Framework_TestCase;
use XOrder\Exceptions\XOrderValidationException;

/**
 * @covers XOrder\Exceptions\XOrderValidationException
 */
class XOrderValidationExceptionTest extends PHPUnit_Framework_TestCase {

    /**
     * @test
     * @covers XOrder\Exceptions\XOrderValidationException::__construct
     * @covers XOrder\Exceptions\XOrderValidationException::getErrors
     * @expectedException XOrder\Exceptions\XOrderValidationException
     * @expectedExceptionMessage message
     */
    public function throw_exception()
    {
        $error = new \StdClass();
        $error->message = 'message';
        $expected = [$error];

        throw new XOrderValidationException($expected);
    }

    /**
     * @test
     * @covers XOrder\Exceptions\XOrderValidationException::__construct
     * @covers XOrder\Exceptions\XOrderValidationException::getErrors
     */
    public function throw_and_catch_new_exception_then_get_errors()
    {
        $error = new \StdClass();
        $error->message = 'message';
        $expected = [$error];

        try {
            throw new XOrderValidationException($expected);
        }

        catch (XOrderValidationException $e) {
            $exception = $e;
            $errors = $e->getErrors();
        }

        $this->assertInstanceOf('XOrder\\Exceptions\\XOrderValidationException', $exception);
        $this->assertEquals($expected, $errors);
    } 

}