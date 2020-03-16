<?php


namespace StKevich\Component;


interface HttpAdapterInterface
{
    /**
     * @param string $url
     * @return string
     */
    public function get(string $url): ?string;

    /**
     * @param string $url
     * @param array $params
     */
    public function post(string $url, array $params): void;

    /**
     * @param string $url
     * @param array $params
     */
    public function put(string $url, array $params): void;

}
