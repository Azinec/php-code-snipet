<?php

namespace IpAddressBtree\Storage;

use IpAddressBtree\Model\IpAddressInterface;

interface StorageInterface
{
    /**
     * Stores specified IpAddress
     *
     * @param IpAddressInterface $address
     * @return bool
     */
    public function store(IpAddressInterface $address);

    /**
     * Retrieve a count of stored IpAddresses
     *
     * @param IpAddressInterface $address
     * @return integer
     */
    public function count(IpAddressInterface $address);
}