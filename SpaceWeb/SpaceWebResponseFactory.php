<?php

namespace SpaceWeb;

/**
 * Фабрика для создания обьектов ответа
 * Class SpaceWebResponseFactory
 * @package SpaceWeb
 */
class SpaceWebResponseFactory
{

    /**
     * Возвращает объект ответа
     * @param array $response
     * @return SpaceWebResponse|SpaceWebResponseExtended
     */
    public function create(array $response)
    {
        if (isset($response['result']['data']) || isset($response['error']['data'])) {
            return new SpaceWebResponseExtended($response);
        } else {
            return new SpaceWebResponse($response);
        }
    }

}
