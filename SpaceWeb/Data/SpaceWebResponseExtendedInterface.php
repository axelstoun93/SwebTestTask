<?php

namespace SpaceWeb\Data;

/**
 * Интерфес расширяет ответ от сервера
 * Interface SpaceWebResponseInterface
 * @package SpaceWeb\Data
 */
interface SpaceWebResponseExtendedInterface
{

    /**
     * code - 1 - успешное выполнение, 0 - ошибка
     * @return string
     */
    public function getCode(): string;

    /**
     * кастомизированное сообщение о результате
     * @return array
     */
    public function getData(): array;

    /**
     *  объект дополнительных данных (может быть пустым)
     * @return string
     */
    public function getMessage(): string;
}
