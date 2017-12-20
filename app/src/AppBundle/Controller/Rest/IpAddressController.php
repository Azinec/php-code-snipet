<?php

namespace AppBundle\Controller\Rest;

use AppBundle\Dto\StoredIpAddressDto;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use IpAddressBtree\Model\IpAddressFactoryInterface;
use IpAddressBtree\Storage\StorageInterface;

/**
 * Class IpAddressController.
 *
 * @Rest\NamePrefix("api.ip_address.")
 * @Rest\Prefix("address")
 */
class IpAddressController extends FOSRestController
{
    /**
     * @var IpAddressFactoryInterface
     */
    private $factory;

    /**
     * @var StorageInterface
     */
    private $storage;

    /**
     * IpAddressStorageController constructor.
     *
     * @param IpAddressFactoryInterface $factory
     * @param StorageInterface          $storage
     */
    public function __construct(IpAddressFactoryInterface $factory, StorageInterface $storage)
    {
        $this->factory = $factory;
        $this->storage = $storage;
    }

    /**
     * @Rest\Get("")
     * @Rest\QueryParam(name="ip", strict=true, description="IP address to query")
     * @Rest\View(statusCode=200)
     *
     * @param ParamFetcher $fetcher
     * @param ParamFetcher $fetcher
     *
     * @return StoredIpAddressDto
     */
    public function queryAction(ParamFetcher $fetcher)
    {
        $count = $this->storage->count(
            $ipAddress = $this->factory->create($ip = $fetcher->get('ip', true))
        );

        return new StoredIpAddressDto($ip, $count, $ipAddress->getIpProtocolVersion());
    }

    /**
     * @Rest\Post("")
     * @Rest\RequestParam(name="ip", strict=true, description="IP address to store")
     * @Rest\View(statusCode=201)
     *
     * @param ParamFetcher $fetcher
     *
     * @return StoredIpAddressDto
     */
    public function storeAction(ParamFetcher $fetcher)
    {
        $count = $this->storage->store(
            $ipAddress = $this->factory->create($ip = $fetcher->get('ip', true))
        );

        return new StoredIpAddressDto($ip, $count, $ipAddress->getIpProtocolVersion());
    }
}
