<?php

namespace IpAddressBtree\Model;

use PHPUnit\Framework\TestCase;

class Ipv6AddressTest extends TestCase
{
    /**
     * @param string $ip
     * @dataProvider validIps()
     */
    public function testValidConstruction(string $ip)
    {
        $ipAddress = new Ipv6Address($ip);

        static::assertEquals($ipAddress, (string) $ipAddress);
    }

    /**
     * @param string $ip
     * @param $packed
     * @dataProvider validIps()
     */
    public function testPack(string $ip, $packed)
    {
        $ipAddress = new Ipv6Address($ip);
        static::assertSame($packed, $ipAddress->pack());
    }

    /**
     * @param string $ip
     * @param $packed
     * @dataProvider validIps()
     */
    public function testUnpack(string $ip, $packed)
    {
        $ipAddress = Ipv6Address::unpack($packed);
        static::assertSame($ip, (string)$ipAddress);
    }

    /**
     * @param string $ip
     * @dataProvider invalidIps()
     * @expectedException \IpAddressBtree\Exception\BadIpAddressException
     */
    public function testInvalidConstruction(string $ip)
    {
        $this->setExpectedExceptionFromAnnotation();
        new Ipv6Address($ip);
    }

    /**
     * @return array
     */
    public function validIps()
    {
        return [
            ['d41:cdba::3257:9652', '17621635871415646389207675631576782418'],
            ['20a:cdba::3257:9652', '2714551590562156267696620670385886802'],
            ['201:cdba::3257:9652', '2667820918835342819039846203422905938'],
            ['2001:db8:3c4d:7777:260:3eff:fe15:9501', '42540766429945344891240227835850626305'],
        ];
    }

    /**
     * @return array
     */
    public function invalidIps()
    {
        return [
            ['d41:cdba::3257:what'],
            ['20a:cdba:0:0:0:0:xyz:9652'],
            ['dummy:ipv6:address'],
            ['W001:DB8:3C4D:7777:260:3EFF:FE15:9501'],
        ];
    }
}
