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

        $this->manipulator = new UriManipulator('http://www.example.com:10088');
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
    public function getsPort()
    {
        $this->assertEquals('10088', $this->manipulator->getPort());
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

    /**
     * @test
     */
    public function setsSubdomain()
    {
        $this->manipulator->setSubdomain('foo-bar');

        $this->assertEquals('foo-bar', $this->manipulator->getSubdomain());
        $this->assertEquals(
            'foo-bar.example.com',
            $this->manipulator->getHost()
        );
    }

    /**
     * @test
     */
    public function handlesDomainNameAsUri()
    {
        $manipulator = new UriManipulator('www.example.com');

        $this->assertEquals('www.example.com', $manipulator->getHost());
        $this->assertEquals('http', $manipulator->getScheme());
    }
}
