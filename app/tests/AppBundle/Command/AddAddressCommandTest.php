<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class AddAddressCommandTest extends KernelTestCase
{
    const VALID_IPV4 = '127.0.0.1';
    const VALID_IPV6 = '2001:db8:a0b:12f0::1';

    /**
     * @var string
     */
    private static $testStorageFile;

    public function setUp()
    {
        self::bootKernel(['environment' => 'test']);
        self::$testStorageFile = self::$kernel->getContainer()->getParameter('storage_file');

        parent::setUp();
    }

    public function tearDown()
    {
        unlink(self::$testStorageFile);
        parent::tearDown();
    }

    /**
     * @expectedException \IpAddressBtree\Exception\BadIpAddressException
     */
    public function testFailedExecute()
    {
        $command = self::$kernel->getContainer()->get('AppBundle\Command\AddAddressCommand');
        $commandTester = new CommandTester($command);

        $this->setExpectedExceptionFromAnnotation();
        $commandTester->execute([
            'ip' => 'some string',
        ]);
    }

    public function testIpV4Execute()
    {
        $command = self::$kernel->getContainer()->get('AppBundle\Command\AddAddressCommand');
        $commandTester = new CommandTester($command);

        $exitCode = $commandTester->execute([
            'ip' => self::VALID_IPV4,
        ]);

        $output = $commandTester->getDisplay();
        static::assertContains('Storing IPv4 address', $output);
        static::assertContains(self::VALID_IPV4, $output);
        static::assertContains('was stored 1 time(s)', $output);
        static::assertSame(0, $exitCode);
    }

    public function testIpV6Execute()
    {
        $command = self::$kernel->getContainer()->get('AppBundle\Command\AddAddressCommand');
        $commandTester = new CommandTester($command);

        $exitCode = $commandTester->execute([
            'ip' => self::VALID_IPV6,
        ]);

        $output = $commandTester->getDisplay();
        static::assertContains('Storing IPv6 address', $output);
        static::assertContains(self::VALID_IPV6, $output);
        static::assertContains('was stored 1 time(s)', $output);
        static::assertSame(0, $exitCode);
    }
}
