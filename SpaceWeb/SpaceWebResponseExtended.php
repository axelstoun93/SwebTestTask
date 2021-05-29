<?php

namespace SpaceWeb;

use SpaceWeb\Data\SpaceWebResponseExtendedInterface;

/**
 * Объект расширеного ответа от сервера
 * Class SpaceWebResponseExtended
 * @package SpaceWeb
 */
class SpaceWebResponseExtended extends AbstractResponse implements SpaceWebResponseExtendedInterface
{

    public function getCode(): string
    {
        return $this->getError()['code'];
    }

    public function getData(): array
    {
        return $this->getError()['data'];
    }

    public function getMessage(): string
    {
        return $this->getError()['message'];
    }
}
