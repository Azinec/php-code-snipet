<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class QueryAddressCommandTest extends KernelTestCase
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
        $command = self::$kernel->getContainer()->get('AppBundle\Command\QueryAddressCommand');
        $commandTester = new CommandTester($command);

        $this->setExpectedExceptionFromAnnotation();
        $commandTester->execute([
            'ip' => 'some string',
        ]);
    }

    public function testIpV4Execute()
    {
        $addCommand = self::$kernel->getContainer()->get('AppBundle\Command\AddAddressCommand');
        $queryCommand = self::$kernel->getContainer()->get('AppBundle\Command\QueryAddressCommand');
        $queryCommandTester = new CommandTester($queryCommand);
        $addCommandTester = new CommandTester($addCommand);

        $this->setExpectedExceptionFromAnnotation();
        $addExitCode = $addCommandTester->execute([
            'ip' => self::VALID_IPV4,
        ]);

        static::assertSame(0, $addExitCode);

        $queryExitCode = $queryCommandTester->execute([
            'ip' => self::VALID_IPV4,
        ]);

        $output = $queryCommandTester->getDisplay();

        static::assertSame(0, $queryExitCode);
        static::assertContains(self::VALID_IPV4, $output);
        static::assertContains('was stored 1 time(s)', $output);
    }

    public function testIpV6Execute()
    {
        $addCommand = self::$kernel->getContainer()->get('AppBundle\Command\AddAddressCommand');
        $queryCommand = self::$kernel->getContainer()->get('AppBundle\Command\QueryAddressCommand');
        $queryCommandTester = new CommandTester($queryCommand);
        $addCommandTester = new CommandTester($addCommand);

        $this->setExpectedExceptionFromAnnotation();
        $addExitCode = $addCommandTester->execute([
            'ip' => self::VALID_IPV6,
        ]);

        static::assertSame(0, $addExitCode);

        $queryExitCode = $queryCommandTester->execute([
            'ip' => self::VALID_IPV6,
        ]);

        $output = $queryCommandTester->getDisplay();

        static::assertSame(0, $queryExitCode);
        static::assertContains(self::VALID_IPV6, $output);
        static::assertContains('was stored 1 time(s)', $output);
    }
}
