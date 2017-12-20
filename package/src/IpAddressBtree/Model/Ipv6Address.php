<?php

namespace IpAddressBtree\Model;

class Ipv6Address extends AbstractIpAddress
{
    const VERSION = 'IPv6';

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
        return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
    }

    /**
     * {@inheritdoc}
     */
    public function pack()
    {
        return (string) gmp_import(inet_pton($this->value));
    }

    /**
     * {@inheritdoc}
     */
    public static function unpack($packed)
    {
        return new self(
            inet_ntop(str_pad(gmp_export($packed), 16, "\0", STR_PAD_LEFT))
        );
    }
}
