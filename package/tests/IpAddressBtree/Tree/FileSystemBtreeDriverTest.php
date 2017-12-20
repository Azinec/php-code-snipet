<?php

namespace IpAddressBtree\Tree;

use PHPUnit\Framework\TestCase;

class FileSystemBtreeDriverTest extends TestCase
{
    const TMP_FILE = '/tmp/btree.test';

    /**
     * 127.0.0.1 => 1245
     * 192.168.0.1 => 5030
     * 10.11.1.8 => 65536
     * 195.128.10.5 => 32789655.
     */
    const FIXTURE_FILE = '/fixtures/test.tree';

    /**
     * @var FileSystemBtreeDriver
     */
    private static $btree = null;

    public function setUp()
    {
        self::$btree = FileSystemBtreeDriver::load(['file_name' => self::TMP_FILE]);

        parent::setUp();
    }

    public function tearDown()
    {
        unlink(self::TMP_FILE);

        parent::tearDown();
    }

    /**
     * @return array
     */
    public function dataSet()
    {
        return [
            ['key', 'value', true],
            ['_0036', 7, true],
            ['#%^', '979878', true],
            ['9501', '!@#$%^', true],
            ['null', null, true],
        ];
    }

    /**
     * @covers \Btree::set()
     * @dataProvider dataSet()
     *
     * @param string $key
     * @param string $value
     */
    public function testSet($key, $value)
    {
        $result = self::$btree->set($key, $value);

        static::assertTrue($result);
    }

    /**
     * @covers \Btree::get()
     * @dataProvider dataSet()
     *
     * @param string $key
     * @param string $value
     */
    public function testGet($key, $value)
    {
        self::$btree->set($key, $value);

        static::assertSame($value, self::$btree->get($key));
    }

    /**
     * @return array
     */
    public function fixtureData()
    {
        return [
            ['127.0.0.1', 1245],
            ['192.168.0.1', 5030],
            ['10.11.1.8', 65536],
            ['195.128.10.5', 32789655],
        ];
    }

    /**
     * @dataProvider fixtureData()
     *
     * @param string $key
     * @param string $expectingValue
     */
    public function testGetExisting(string $key, string $expectingValue)
    {
        $tree = FileSystemBtreeDriver::load(['file_name' => __DIR__.self::FIXTURE_FILE]);

        static::assertSame($expectingValue, $tree->get($key));
    }
}
