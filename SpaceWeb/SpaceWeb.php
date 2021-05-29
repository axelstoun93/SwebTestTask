<?php

namespace SpaceWeb;

use SpaceWeb\Exceptions\SpaceWebException;

/**
 * Класс реализует API SpaceWeb
 * Class SpaceWeb
 * @package SpaceWeb
 */
class SpaceWeb
{

    /**
     * @var SpaceWebCurlClient
     */
    private SpaceWebCurlClient $spaceWebCurlClient;

    /**
     * SpaceWeb constructor.
     */
    public function __construct()
    {
        $this->spaceWebCurlClient = new SpaceWebCurlClient();
    }

    /**
     * Метод осуществляет получения
     * Токена по логину и поролю для дальнейшей работы класса
     * @param string $login
     * @param string $password
     */
    public function authorization(string $login, string $password): string
    {
        $createRequest = new SpaceWebRequest();
        $createRequest->setMethod('getToken');
        $createRequest->setParams(['login' => $login, 'password' => $password]);

        $createResponse = $this->spaceWebCurlClient->call('notAuthorized', $createRequest);

        if ($createResponse->isErrorResponse()) {
            throw new SpaceWebException('Не удалось получить токен, проверьте логин и пароль!');
        }

        $token = $createResponse->getResult();

        $this->setBearerToken($createResponse->getResult());

        return $token;
    }


    /**
     * Метод устанавливает классу токен
     * @param string $login
     * @param string $password
     */
    public function setBearerToken(string $token)
    {
        $this->spaceWebCurlClient->setBearerToken($token);
    }

    /**
     * Метод добавляет домен
     * @param string $domain
     * @param string $prolongType
     * @param null $dir
     */
    public function addDomain(string $domain, string $prolongType, $dir = null)
    {
        $createRequest = new SpaceWebRequest();
        $createRequest->setMethod('move');
        $createRequest->setParams(['domain' => $domain, 'prolongType' => $prolongType, 'dir' => $dir]);

        $createResponse = $this->spaceWebCurlClient->call('domains', $createRequest);

        return $createResponse;
    }

}





