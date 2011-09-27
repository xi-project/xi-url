<?php

namespace Xi\Uri;

use PHPUnit_Framework_TestCase;

/**
* @category Xi
* @package  Uri
* @author   Mikko Hirvonen <mikko.petteri.hirvonen@gmail.com>
* @license  http://www.opensource.org/licenses/BSD-3-Clause New BSD License
*/
class UriManipulatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var UriManipulator
     */
    private $manipulator;

    public function setUp()
    {
        parent::setUp();

        $this->manipulator = new UriManipulator('http://www.example.com');
    }

    /**
     * @test
     */
    public function getsUri()
    {
        $this->assertEquals(
            'http://www.example.com',
            $this->manipulator->getUri()
        );
    }

    /**
     * @test
     */
    public function getsScheme()
    {
        $this->assertEquals('http', $this->manipulator->getScheme());
    }

    /**
     * @test
     */
    public function getsHost()
    {
        $this->assertEquals('www.example.com', $this->manipulator->getHost());
    }

    /**
     * @test
     */
    public function getsDomain()
    {
        $this->assertEquals('example.com', $this->manipulator->getDomain());
    }

    /**
     * @test
     */
    public function getsSubdomain()
    {
        $this->assertEquals('www', $this->manipulator->getSubdomain());
    }
}
