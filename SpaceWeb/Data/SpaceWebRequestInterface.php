<?php

namespace SpaceWeb\Data;

interface SpaceWebRequestInterface {

    /**
     * Устанавливает метод запроса
     * @param string $method
     */
    public function setMethod(string $method);

    /**
     * Устанавливает параметры запроса
     * @param array $params
     */
    public function setParams(array $params);


    /**
     * Устанавливает
     * идентификатор пользователя, который отправляет запрос
     * @param string $user
     */
    public function setUser(string $user);

    /**
     * Устанавливает версию Front End приложения
     * @param string $version
     */
    public function setVersion(string $version);


    /**
     * Устанавливает версия JSON-RPC
     * @param string $jsonrpc
     */
    public function setJsonRPC(string $jsonrpc);
}
