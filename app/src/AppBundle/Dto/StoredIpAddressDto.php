<?php

namespace AppBundle\Dto;

use JMS\Serializer\Annotation as Jms;

class StoredIpAddressDto
{
    /**
     * @Jms\Type("string")
     *
     * @var string
     */
    private $ip;

    /**
     * @Jms\Type("string")
     *
     * @var string
     */
    private $type;

    /**
     * @Jms\Type("integer")
     *
     * @var int
     */
    private $count;

    /**
     * StoredIpAddressDto constructor.
     *
     * @param string $ip
     * @param $type
     * @param $count
     */
    public function __construct(string $ip, int $count, string $type)
    {
        $this->ip = $ip;
        $this->type = $type;
        $this->count = $count;
    }
}
