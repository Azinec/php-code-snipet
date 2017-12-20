<?php

namespace IpAddressBtree\Storage;

use IpAddressBtree\Model\IpAddressInterface;
use IpAddressBtree\Tree\BtreeDriverInterface;

class Storage implements StorageInterface
{
    /**
     * @var BtreeDriverInterface
     */
    private $btree;

    /**
     * Storage constructor.
     *
     * @param BtreeDriverInterface $btree
     */
    public function __construct(BtreeDriverInterface $btree)
    {
        $this->btree = $btree;
    }

    /**
     * {@inheritdoc}
     */
    public function store(IpAddressInterface $address)
    {
        $packed = $address->pack();
        $count = $this->btree->get($packed);

        $count = null === $count ?
            1 :
            ++$count
        ;

        $saved = $this->btree->set($packed, $count);

        return true === $saved ? $count : false;
    }

    /**
     * {@inheritdoc}
     */
    public function count(IpAddressInterface $address)
    {
        $packed = $address->pack();
        $count = $this->btree->get($packed);

        return null === $count ?
            0 :
            $count
        ;
    }
}
