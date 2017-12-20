<?php

namespace AppBundle\Command;

use IpAddressBtree\Model\IpAddressFactoryInterface;
use IpAddressBtree\Storage\StorageInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddAddressCommand extends Command
{
    const NAME = 'app:address:add';
    const IP_ARGUMENT = 'ip';

    /**
     * @var StorageInterface
     */
    private $storage;

    /**
     * @var IpAddressFactoryInterface
     */
    private $ipAddressFactory;

    /**
     * StoreIpAddressCommand constructor.
     *
     * @param StorageInterface          $storage
     * @param IpAddressFactoryInterface $ipAddressFactory
     */
    public function __construct(
        StorageInterface $storage,
        IpAddressFactoryInterface $ipAddressFactory
    ) {
        $this->storage = $storage;
        $this->ipAddressFactory = $ipAddressFactory;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName(self::NAME)
            ->addArgument(self::IP_ARGUMENT, InputArgument::REQUIRED, 'Specify IP address to store')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $ipAddress = $this->ipAddressFactory->create(
            $ip = $input->getArgument(self::IP_ARGUMENT)
        );

        $output->writeln(sprintf(
            'Storing %s address "%s"',
            $ipAddress->getIpProtocolVersion(),
            $ip
        ));

        $count = $this->storage->store($ipAddress);
        $output->writeln(sprintf(
            'IP address "%s" was stored %s time(s)',
            $ip,
            $count
        ));

        return 0;
    }
}
