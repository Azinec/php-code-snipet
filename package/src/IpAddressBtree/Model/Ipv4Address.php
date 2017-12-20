<?php

namespace IpAddressBtree\Model;

class Ipv4Address extends AbstractIpAddress
{
    const VERSION = 'IPv4';

    /**
     * {@inheritdoc}
     */
    public function getIpProtocolVersion()
    {
        return self::VERSION;
    }

    /**
     * {@inheritdoc}
     */
    public function isValid(string $value)
    {
        return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }

    /**
     * {@inheritdoc}
     */
    public function pack()
    {
        return ip2long($this->value);
    }

    /**
     * @param int $packed
     *
     * @return string
     */
    public static function unpack($packed)
    {
        $ip = long2ip($packed);

        return new self($ip);
    }
}
