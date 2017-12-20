<?php

namespace IpAddressBtree\Exception;

class BadIpAddressException extends \RuntimeException
{
    /**
     * BadIpAddressException constructor.
     *
     * @param string $ip
     * @param string $version
     */
    public function __construct(string $ip, string $version= null)
    {
        $message = sprintf(
            'A value "%s" is not valid %s address',
            $ip,
            $version
        );

        parent::__construct($message);
    }
}
