<?php
namespace Stafred\Controller;

/**
 * Class ParseLinkRoute
 * @package Stafred\Controller
 */
final class ParseLinkRoute
{
    /**
     * @var string
     */
    private $rURL;
    /**
     * @var array
     */
    private $result = [];

    /**
     * ParseLinkRoute constructor.
     * @param string|null $url
     */
    public function __construct(?string $url = NULL)
    {
        $this->rURL = $url;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function bindRUrl(string $url)
    {
        $this->rURL = $url;
        return $this;
    }

    /**
     *
     */
    private function startParse()
    {
        $this->result = $this->searchElementsURL();
    }

    /**
     * @param string $str
     * @return array
     */
    private function searchElementsURL(): array
    {
        $elemsURI = [];

        preg_match_all(
            "/\/(?'path'[^\/\\$\{\}]+)|\/\{\\$?(?'args'[^\/\\$\{\}]+)\}|\//i",
            $this->rURL,
            $elemsURI,
            PREG_UNMATCHED_AS_NULL
        );

        return $elemsURI;
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        $this->startParse();
        return array_unique($this->result, SORT_REGULAR);
    }
}