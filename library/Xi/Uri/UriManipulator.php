<?php

namespace Xi\Uri;

/**
* @category Xi
* @package  Uri
* @author   Mikko Hirvonen <mikko.petteri.hirvonen@gmail.com>
* @license  http://www.opensource.org/licenses/BSD-3-Clause New BSD License
*/
class UriManipulator
{
    /**
     * @var string
     */
    private $scheme = 'http';

    private $host;

    /**
     * @param  string         $uri
     * @return UriManipulator
     */
    public function __construct($uri)
    {
        $parts = parse_url($uri);

        $this->scheme = $parts['scheme'];
        $this->host   = $parts['host'];
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return sprintf(
            '%s://%s',
            $this->getScheme(),
            $this->getHost()
        );
    }

    /**
     * @return string
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Gets the domain part of the domain name. For "www.example.com"
     * returns "example.com".
     *
     * @return string
     */
    public function getDomain()
    {
        preg_match('/([^.]+\.[^.]+)$/', $this->host, $matches);

        return $matches[1];
    }

    /**
     * Gets the subdomain part of the domain name. For "www.example.com"
     * returns "www".
     *
     * @return string
     */
    public function getSubdomain()
    {
        preg_match('/([^.]+)./', $this->host, $matches);

        return $matches[1];
    }

    /**
     * @test
     */
    public function getsUri()
    {
        $manipulator = new UriManipulator('http://www.example.com');

        $this->assertEquals('http://www.example.com', $manipulator->getUri());
    }
}
