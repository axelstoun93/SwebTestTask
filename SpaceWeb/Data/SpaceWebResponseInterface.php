<?php

namespace SpaceWeb\Data;

/**
 * Интерфес ответа от сервера
 * Interface SpaceWebResponseInterface
 * @package SpaceWeb\Data
 */
interface SpaceWebResponseInterface
{

    /**
     * Возвращает версия JSON-RPC
     * @param string $jsonRPC
     * @return string
     */
    public function getJsonRPC(string $jsonRPC): string;

    /**
     * Возвращает текущая версия приложения
     * @param string $version
     * @return string
     */
    public function getVersion(string $version): string;

    /**
     * Возвращает свойство result
     * @return mixed
     */
    public function getResult();

    /**
     * Запрос успешно отработал,
     * но вернул ответ с ошибками
     * @return bool
     */
    public function isErrorResponse(): bool;

    /**
     * Запрос успешно отработал
     * @return bool
     */
    public function isSuccessResponse(): bool;

    /**
     * Возвращает свойство error
     * @return mixed
     */
    public function getError(): array;

}
