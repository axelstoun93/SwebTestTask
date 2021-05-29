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

    /**
     * code - 1 - успешное выполнение, 0 - ошибка
     * @return string
     */
    public function getCode(): string
    {
        return $this->getError()['code'];
    }

    /**
     *  Объект дополнительных данных (может быть пустым)
     * @return string
     */
    public function getData(): array
    {
        return $this->getError()['data'];
    }

    /**
     * Кастомизированное сообщение о результате
     * @return array
     */
    public function getMessage(): string
    {
        return $this->getError()['message'];
    }
}
