<?php

namespace Xi\Url;

/**
 * A simple URL manipulator.
 *
 * Subdomain is assumed to be everything after the top level domain and the
 * second-level domain.
 *
 * @category Xi
 * @package  Url
 * @author   Mikko Hirvonen <mikko.petteri.hirvonen@gmail.com>
 * @license  http://www.opensource.org/licenses/BSD-3-Clause New BSD License
 */
class UrlManipulator
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
     * @var string
     */
    private $path;

    /**
     * @param  string         $url
     * @return UrlManipulator
     */
    public function __construct($url)
    {
        $parts = parse_url($url);

        if (isset($parts['scheme'])) {
            $this->scheme = $parts['scheme'];
        }

        $this->host = isset($parts['host']) ? $parts['host'] : $parts['path'];

        if (isset($parts['port'])) {
            $this->port = $parts['port'];
        }

        $this->path = isset($parts['path']) && isset($parts['host'])
            ? $parts['path']
            : '';
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return sprintf(
            '%s://%s%s%s',
            $this->getScheme(),
            $this->getHost(),
            $this->getPort() ? ':' . $this->getPort() : '',
            $this->getPath() ?: ''
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
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param  string         $path
     * @return UrlManipulator
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
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
     * Gets the subdomain part of the domain name.
     *
     * Examples:
     *
     * www.example.com     => www
     * one.two.example.com => one.two
     *
     * @return string
     */
    public function getSubdomain()
    {
        preg_match('/(.+)\.([^.]+\.[^.]+)$/', $this->host, $matches);

        return isset($matches[1]) ? $matches[1] : '';
    }

    /**
     * @param  string         $subdomain
     * @return UrlManipulator
     */
    public function setSubdomain($subdomain)
    {
        $this->host = $subdomain
            ? sprintf('%s.%s', $subdomain, $this->getDomain())
            : $this->getDomain();

        return $this;
    }
}
