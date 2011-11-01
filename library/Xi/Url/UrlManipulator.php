<?php

namespace Xi\Url;

/**
 * A simple URL manipulator.
 *
 * By default, domain is considered to be top-level domain and second-level
 * domain, and subdomain is considered to be everything after that.
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
    private $domain;

    /**
     * @var string
     */
    private $subdomain;

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

        $host = isset($parts['host']) ? $parts['host'] : $parts['path'];

        $this->setDomainByHost($host);
        $this->setSubdomainByHost($host);

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
        return $this->subdomain
            ? $this->subdomain . '.' . $this->domain
            : $this->domain;
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
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Sets the domain part.
     *
     * @param  string         $domain
     * @return UrlManipulator
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * @return string
     */
    public function getSubdomain()
    {
        return $this->subdomain;
    }

    /**
     * @param  string         $subdomain
     * @return UrlManipulator
     */
    public function setSubdomain($subdomain)
    {
        $this->subdomain = $subdomain;

        return $this;
    }

    /**
     * Gets the domain part of the domain name. For "www.example.com" returns
     * "example.com".
     *
     * @param string $host
     */
    private function setDomainByHost($host)
    {
        preg_match('/(([^.]+\.)?[^.]+)$/', $host, $matches);

        $this->domain = $matches[1];
    }

    /**
     * Gets the subdomain part of the domain name.
     *
     * Examples:
     *
     * www.example.com     => www
     * one.two.example.com => one.two
     *
     * @param string $host
     */
    private function setSubdomainByHost($host)
    {
        preg_match('/(.+)\.([^.]+\.[^.]+)$/', $host, $matches);

        $this->subdomain = isset($matches[1]) ? $matches[1] : '';
    }
}
