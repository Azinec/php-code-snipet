<?php

namespace IpAddressBtree\Model;

use PHPUnit\Framework\TestCase;

class Ipv4AddressTest extends TestCase
{
    /**
     * @param string $ip
     * @dataProvider validIps()
     */
    public function testValidConstruction(string $ip)
    {
        $ipAddress = new Ipv4Address($ip);

        static::assertEquals($ipAddress, (string) $ipAddress);
    }

    /**
     * @param string $ip
     * @param $packed
     * @dataProvider validIps()
     */
    public function testPack(string $ip, $packed)
    {
        $ipAddress = new Ipv4Address($ip);

        static::assertSame($packed, $ipAddress->pack());
    }

    /**
     * @param string $ip
     * @param $packed
     * @dataProvider validIps()
     */
    public function testUnPack(string $ip, $packed)
    {
        $ipAddress = Ipv4Address::unpack($packed);

        static::assertInstanceOf(Ipv4Address::class, $ipAddress);
        static::assertSame($ip, (string) $ipAddress);
    }

    /**
     * @param string $ip
     * @dataProvider badIps()
     * @expectedException \IpAddressBtree\Exception\BadIpAddressException
     */
    public function testInvalidConstruction(string $ip)
    {
        $this->setExpectedExceptionFromAnnotation();
        new Ipv4Address($ip);
    }

    /**
     * @return array
     */
    public function validIps()
    {
        return [
            ['127.0.0.1', 2130706433],
            ['192.168.0.1', 3232235521],
            ['10.11.1.8', 168493320],
            ['195.128.10.5', 3279948293],
        ];
    }

    public function badIps()
    {
        return [
            ['127.X.0.1'],
            ['192168.0.1'],
            ['10.11.1.bad'],
            ['very.bad.ip.address'],
            ['192.168.10.256'],
        ];
    }
}
