<?php

namespace IpAddressBtree\Model;

interface IpAddressInterface
{
    /**
     * Check if $value is a valid IP address.
     *
     * @param string $value
     *
     * @return mixed
     */
    public function isValid(string $value);

    /**
     * Converts IP address to scalar type store into data structure.
     *
     * @return mixed
     */
    public function pack();

    /**
     * Returns new IP address from $packed value.
     *
     * @param $packed
     *
     * @return string
     */
    public static function unpack($packed);

    /**
     * Return a version of IP protocol.
     *
     * @return string
     */
    public function getIpProtocolVersion();

    /**
     * @return string
     */
    public function __toString();
}
