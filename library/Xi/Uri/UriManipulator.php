<?php

namespace Xi\Uri;

/**
 * A simple URI manipulator.
 *
 * Subdomain is assumed to be everything after the top level domain and the
 * second-level domain.
 *
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

    /**
     * @var string
     */
    private $host;

    /**
     * @var integer
     */
    private $port;

    /**
     * @param  string         $uri
     * @return UriManipulator
     */
    public function __construct($uri)
    {
        $parts = parse_url($uri);

        if (isset($parts['scheme'])) {
            $this->scheme = $parts['scheme'];
        }

        $this->host = isset($parts['host']) ? $parts['host'] : $parts['path'];

        if (isset($parts['port'])) {
            $this->port = $parts['port'];
        }
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
     * @return integer
     */
    public function getPort()
    {
        return $this->port;
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
     * @param string $subdomain
     */
    public function setSubdomain($subdomain)
    {
        $this->host = sprintf('%s.%s', $subdomain, $this->getDomain());
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
