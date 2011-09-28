<?php

namespace Xi\Url;

use PHPUnit_Framework_TestCase;

/**
* @category Xi
* @package  Url
* @author   Mikko Hirvonen <mikko.petteri.hirvonen@gmail.com>
* @license  http://www.opensource.org/licenses/BSD-3-Clause New BSD License
*/
class UrlManipulatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var UrlManipulator
     */
    private $manipulator;

    public function setUp()
    {
        parent::setUp();

        $this->manipulator = new UrlManipulator('http://www.example.com:10088');
    }

    /**
     * @test
     */
    public function getsUrl()
    {
        $this->assertEquals(
            'http://www.example.com:10088',
            $this->manipulator->getUrl()
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
     * @dataProvider subdomainProvider
     * @param string $subdomain
     * @param string $expectedHost
     */
    public function handlesDifferentLevelsOfSubdomain($subdomain, $expectedHost)
    {
        $this->manipulator->setSubdomain($subdomain);

        $this->assertEquals($subdomain, $this->manipulator->getSubdomain());
        $this->assertEquals($expectedHost, $this->manipulator->getHost());
    }

    /**
     * @test
     */
    public function handlesDomainNameAsUrl()
    {
        $manipulator = new UrlManipulator('www.example.com');

        $this->assertEquals('www.example.com', $manipulator->getHost());
        $this->assertEquals('http', $manipulator->getScheme());
    }

    /**
     * @return array
     */
    public function subdomainProvider()
    {
        return array(
            array('foo-bar',      'foo-bar.example.com'),
            array('foo.bar',      'foo.bar.example.com'),
            array('foo.bar.quux', 'foo.bar.quux.example.com'),
            array('',             'example.com'),
        );
    }
}
