<?php

namespace IpAddressBtree\Storage;

use IpAddressBtree\Model\Ipv4Address;
use IpAddressBtree\Model\Ipv6Address;
use IpAddressBtree\Tree\FileSystemBtreeDriver;
use PHPUnit\Framework\TestCase;

class StorageTest extends TestCase
{
    const FILENAME = '/tmp/btree.test';

    /**
     * @var Storage
     */
    private static $storage;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $btree = FileSystemBtreeDriver::load(['file_name' => self::FILENAME]);
        self::$storage = new Storage($btree);

        parent::setUp();
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        unlink(self::FILENAME);
        parent::tearDown();
    }

    /**
     * @covers \Storage::store()
     * @dataProvider ipsV4()
     *
     * @param string $ip
     */
    public function testStore(string $ip)
    {
        $ip = new Ipv4Address($ip);
        $result = self::$storage->store($ip);

        static::assertSame(1, $result);
    }

    /**
     * @covers \Storage::get()
     * @dataProvider ipsV4()
     *
     * @param string $ip
     * @param int    $repeatStores
     */
    public function testStoreGetIpsV4(string $ip, int $repeatStores)
    {
        $ipAddress = new Ipv4Address($ip);

        for ($counter = 0; $counter < $repeatStores; ++$counter) {
            static::assertSame($counter, self::$storage->count($ipAddress));
            $storedCounter = self::$storage->store($ipAddress);
            static::assertSame($counter + 1, $storedCounter);
        }

        static::assertSame($repeatStores, self::$storage->count($ipAddress));
    }

    /**
     * @covers Storage::count()
     * @dataProvider ipsV6()
     *
     * @param string $ip
     * @param int    $repeatStores
     */
    public function testStoreGetIpsV6(string $ip, int $repeatStores)
    {
        $ipAddress = new Ipv6Address($ip);

        for ($counter = 0; $counter < $repeatStores; ++$counter) {
            static::assertSame($counter, self::$storage->count($ipAddress));
            $storedCounter = self::$storage->store($ipAddress);
            static::assertSame($counter + 1, $storedCounter);
        }

        static::assertSame($repeatStores, self::$storage->count($ipAddress));
    }

    /**
     * @return array
     */
    public function ipsV4()
    {
        return [
            ['127.0.0.1', 100],
            ['192.168.0.1', 150],
            ['10.11.1.8', 200],
            ['195.128.10.5', 250],
        ];
    }

    /**
     * @return array
     */
    public function ipsV6()
    {
        return [
            ['d41:cdba::3257:9652', 300],
            ['20a:cdba::3257:9652', 350],
            ['201:cdba::3257:9652', 400],
            ['2001:db8:3c4d:7777:260:3eff:fe15:9501', 500],
        ];
    }
}
