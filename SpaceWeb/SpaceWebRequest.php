<?php

namespace SpaceWeb;

use SpaceWeb\Data\SpaceWebRequestInterface;

/**
 * Объект запроса
 * Class SpaceWebRequest
 * @package SpaceWeb
 */
class SpaceWebRequest implements SpaceWebRequestInterface
{
    /**
     * Текущая версия JSON-RPC
     * @var string
     */
    public $jsonrpc = '2.0';

    /**
     * Текущая версия приложения используется для обеспечения совместимости с Back-End
     * @var string
     */
    public $version = '1.74.20210524153627';

    /**
     * Публичный метод объекта
     * по умолчанию для всех объектов "index".
     * @var string
     */
    public $method = 'index';

    /**
     * Ассоциативный массив параметров метода
     * (ключ элемента массива - имя параметра)
     * @var array
     */
    public $params = [];

    /**
     * Уникальный идентификатор запроса
     * @var
     */
    public $id;

    /**
     * Идентификатор пользователя, который отправляет запрос.
     * Носит только информационный характер,
     * сверяется со значением сессии токена и в
     * случае расхождения приводит к ошибке авторизации
     * @var
     */
    public $user;

    /**
     * Трансформирует объект в массив
     * @return array
     */
    public function toArray()
    {
        return (array)$this;
    }

    /**
     * Трансформирует объект в json строку
     * @return false|string
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }

    /**
     * Устанавливает метод запроса
     * @param string $method
     */
    public function setMethod(string $method)
    {
        $this->method = $method;
    }

    /**
     * Устанавливает параметры запроса
     * @param array $params
     */
    public function setParams(array $params)
    {
        $this->params = $params;
    }

    /**
     * Устанавливает
     * идентификатор пользователя, который отправляет запрос
     * @param string $user
     */
    public function setUser(string $user)
    {
        $this->user = $user;
    }

    /**
     * Устанавливает версия Front-End приложения
     * @param string $version
     */
    public function setVersion(string $version)
    {
        $this->version = $version;
    }


    /**
     * Устанавливает версия JSON-RPC
     * @param string $jsonrpc
     */
    public function setJsonRPC(string $jsonrpc)
    {
        $this->jsonrpc = $jsonrpc;
    }


}
