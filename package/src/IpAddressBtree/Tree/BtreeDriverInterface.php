<?php

namespace IpAddressBtree\Tree;

interface BtreeDriverInterface
{
    /**
     * Sets $value under $key.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get(string $key);

    /**
     * Gets $value of $key.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return bool
     */
    public function set(string $key, $value);
}
