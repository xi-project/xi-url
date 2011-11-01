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

        $this->manipulator = new UrlManipulator(
            'http://www.example.com:10088/some/path'
        );
    }

    /**
     * @test
     */
    public function getsUrl()
    {
        $this->assertEquals(
            'http://www.example.com:10088/some/path',
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
    public function getsPath()
    {
        $this->assertEquals('/some/path', $this->manipulator->getPath());
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

    /**
     * @test
     */
    public function handlesDomainNameAsUrl()
    {
        $manipulator = new UrlManipulator('www.example.com');

        $this->assertEquals('http', $manipulator->getScheme());
        $this->assertEquals('www.example.com', $manipulator->getHost());
        $this->assertEquals('', $manipulator->getPath());
    }

    /**
     * @test
     */
    public function setsPath()
    {
        $this->manipulator->setPath('/foo');

        $this->assertEquals('/foo', $this->manipulator->getPath());
    }

    /**
     * @test
     */
    public function settersAreFluent()
    {
        $this->assertSame(
            $this->manipulator,
            $this->manipulator->setDomain('quux.com')
        );

        $this->assertSame(
            $this->manipulator,
            $this->manipulator->setSubdomain('foo')
        );

        $this->assertSame(
            $this->manipulator,
            $this->manipulator->setPath('/bar')
        );
    }

    /**
     * @test
     */
    public function handlesOnlyTopLevelDomain()
    {
        $manipulator = new UrlManipulator('http://localhost/login');

        $this->assertEquals('localhost', $manipulator->getHost());
        $this->assertEquals('localhost', $manipulator->getDomain());
        $this->assertEquals('', $manipulator->getSubdomain());
        $this->assertEquals('/login', $manipulator->getPath());
    }

    /**
     * @test
     * @dataProvider domainProvider
     * @param string $domain
     * @param string $expectedSubdomain
     * @param string $expectedDomain
     */
    public function handlesDifferentLevelsOfDomain($domain, $expectedSubdomain,
        $expectedDomain
    ) {
        $this->manipulator->setDomain($domain);

        $this->assertEquals(
            $expectedDomain,
            $this->manipulator->getDomain(),
            'Domain matches expected domain.'
        );

        $this->assertEquals(
            $expectedSubdomain,
            $this->manipulator->getSubdomain(),
            'Subdomain matches expected subdomain.'
        );
    }

    /**
     * @return array
     */
    public function domainProvider()
    {
        return array(
            array('foobar.com',       'www', 'foobar.com'),
            array('foo.bar.quux.com', 'www', 'foo.bar.quux.com'),
            array('localhost',        'www', 'localhost'),
        );
    }
}
