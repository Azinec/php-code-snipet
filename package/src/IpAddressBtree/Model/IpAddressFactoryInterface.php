<?php

namespace IpAddressBtree\Model;


interface IpAddressFactoryInterface
{
    /**
     * @param string $ipAddress
     * @return IpAddressInterface
     */
    public function create(string $ipAddress);
}