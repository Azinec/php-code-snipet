<?php

namespace IpAddressBtree\Model;

use IpAddressBtree\Exception\BadIpAddressException;

abstract class AbstractIpAddress implements IpAddressInterface
{
    /**
     * @var string
     */
    protected $value;

    /**
     * AbstractIpAddress constructor.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        if (false === static::isValid($value)) {
            throw new BadIpAddressException($value, static::getIpProtocolVersion());
        }

        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->value;
    }
}
