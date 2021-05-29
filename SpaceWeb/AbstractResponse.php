<?php

namespace SpaceWeb;

use SpaceWeb\Data\SpaceWebResponseInterface;

/**
 * Абстрактный объект ответа
 * @package SpaceWeb
 */
abstract class AbstractResponse implements SpaceWebResponseInterface
{

    /**
     * Уникальный идентификатор запроса
     * @var
     */
    public $id;

    /**
     * Текущая версия JSON-RPC
     * @var
     */
    public $jsonrpc;

    /**
     * Текущая версия приложения используется для
     * обеспечения совместимости с Back-End
     * @var
     */
    public $version;

    /**
     * Результат, который возвращает вызванный метод
     * @var
     */
    public $result;

    /**
     * объект ошибки, который содержит
     * (
     *  code - код ошибки http://xmlrpcepi.sourceforge.net/specs/rfc.fault_codes.php
     *  и
     *  message - текст ошибки
     * )
     * @var
     */
    public $error;

    /**
     * AbstractResponse constructor.
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->setProperty($response);
    }

    /**
     * Метод устанавливает свойства объекта
     * @param array $response
     */
    public function setProperty(array $response)
    {
        $arrayObjectProperty = get_object_vars($this);

        foreach ($arrayObjectProperty as $key => $property) {
            if (!empty($response[$key])) {
                $this->$key = $response[$key];
            }
        }
    }

    /**
     * Возвращает свойство result
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Запрос успешно отработал, но вернул ответ с ошибками
     * @return bool
     */
    public function isErrorResponse():bool
    {
        return (!empty($this->error));
    }

    /**
     * Запрос успешно отработал
     * @return bool
     */
    public function isSuccessResponse():bool
    {
        return !$this->isErrorResponse();
    }

    /**
     * Возвращает версия JSON-RPC
     * @param string $jsonRPC
     * @return string
     */
    public function getJsonRPC(string $jsonRPC): string
    {
        // TODO: Implement getJsonRPC() method.
    }

    /**
     * Возвращает текущая версия приложения
     * @param string $version
     * @return string
     */
    public function getVersion(string $version): string
    {
        // TODO: Implement getVersion() method.
    }

    /**
     * Возвращает свойство error
     * @return mixed
     */
    public function getError():array
    {
        return $this->error;
    }

}
