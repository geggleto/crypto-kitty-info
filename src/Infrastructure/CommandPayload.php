<?php


namespace Kitty\Infrastructure;


class CommandPayload implements \JsonSerializable
{
    /**
     * @var array
     */
    private $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function jsonSerialize()
    {
        return $this->payload;
    }
}