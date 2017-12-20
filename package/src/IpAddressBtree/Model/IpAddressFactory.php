<?php

namespace IpAddressBtree\Model;

use IpAddressBtree\Exception\BadIpAddressException;

class IpAddressFactory implements IpAddressFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(string $ipAddress)
    {
        if (false !== filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return new Ipv4Address($ipAddress);
        }

        if (false !== filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            return new Ipv6Address($ipAddress);
        }

        throw new BadIpAddressException($ipAddress);
    }
}
