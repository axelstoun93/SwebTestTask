<?php

namespace SpaceWeb;

use SpaceWeb\Exceptions\SpaceWebCurlException;


/**
 * Класс отвечает за обмен данными с api SpaceWeb
 * Class SpaceWebCurlClient
 * @package SpaceWeb
 */
class SpaceWebCurlClient
{

    /**
     * @var SpaceWebResponseFactory
     */
    private SpaceWebResponseFactory $spaceWebResponseFactory;

    /**
     * @var array|string[]
     */
    private array $defaultHeaders = [
        'Content-Type' => 'application/json; charset=utf-8',
        'Accept' => 'application/json',
    ];

    /**
     * @var string
     */
    private string $bearerToken;

    /**
     * @var
     */
    private $curl;

    /**
     * @var int
     */
    private int $timeout = 80;

    /**
     * @var int
     */
    private int $connectionTimeout = 30;

    /**
     * @var string
     */
    private string $url = 'https://api.sweb.ru/';

    /**
     * SpaceWebCurlClient constructor.
     */
    public function __construct()
    {
        $this->spaceWebResponseFactory = new SpaceWebResponseFactory();
    }

    /**
     * Метод запроса
     * @param string $path
     * @param SpaceWebRequest $request
     * @param array $headers
     * @return SpaceWebResponse|SpaceWebResponseExtended
     * @throws SpaceWebCurlException
     */
    public function call(string $path, SpaceWebRequest $request, array $headers = [])
    {
        $headers = $this->prepareHeaders($headers);

        $url = $this->prepareUrl($path);

        $this->prepareCurl($request, $this->implodeHeaders($headers), $url);

        list($httpBody, $responseInfo) = $this->sendRequest();

        $this->closeCurlConnection();

        return $this->spaceWebResponseFactory->create($this->decodeData($httpBody));
    }

    /**
     * Метод декодирует json строку
     * @param array $httpBody
     * @return mixed
     */
    public function decodeData(string $httpBody)
    {
        return json_decode($httpBody, true);
    }

    /**
     * Метод отправляет запрос
     * @return array
     * @throws SpaceWebCurlException
     */
    public function sendRequest(): array
    {
        $response = curl_exec($this->curl);
        $httpHeaderSize = curl_getinfo($this->curl, CURLINFO_HEADER_SIZE);
        $httpBody = substr($response, $httpHeaderSize);
        $responseInfo = curl_getinfo($this->curl);
        $curlError = curl_error($this->curl);
        $curlErrno = curl_errno($this->curl);
        if ($response === false) {
            $this->handleCurlError($curlError, $curlErrno);
        }

        return [$httpBody, $responseInfo];
    }

    /**
     * Метод расширяет заголовок запроса
     * @param array $headers
     * @return array
     */
    private function prepareHeaders(array $headers): array
    {
        $headers = array_merge($this->defaultHeaders, $headers);

        if (!empty($this->bearerToken)) {
            $headers['Authorization'] = 'Bearer ' . $this->bearerToken;
        }

        return $headers;
    }

    /**
     * Метод готовит заголовок для использования
     * в curl_setopt
     * @param array $headers
     * @return string[]
     */
    private function implodeHeaders(array $headers)
    {
        return array_map(
            function ($key, $value) {
                return $key . ':' . $value;
            },
            array_keys($headers),
            $headers
        );
    }

    /**
     * Метод устанавливает
     * опции curl соединения
     * @param $optionName
     * @param $optionValue
     * @return bool
     */
    public function setCurlOption($optionName, $optionValue): bool
    {
        return curl_setopt($this->curl, $optionName, $optionValue);
    }

    /**
     * Метод устанавливает токен
     * для использования в запросах
     * @param string $token
     */
    public function setBearerToken(string $token): void
    {
        $this->bearerToken = $token;
    }

    /**
     * Метод инициализирует curl
     * @return false|resource
     * @throws \Exception
     */
    private function initCurl()
    {
        if (!extension_loaded('curl')) {
            throw new SpaceWebCurlException('curl error');
        }

        $this->curl = curl_init();

        return $this->curl;
    }

    /**
     * Метод закрывать
     * curl соединение
     */
    public function closeCurlConnection(): void
    {
        if ($this->curl !== null) {
            curl_close($this->curl);
        }
    }

    /**
     * Метод передает параметры
     * в тело запроса
     * @param $request
     */
    public function setBody($request): void
    {
        if (!empty($request)) {
            $this->setCurlOption(CURLOPT_POSTFIELDS, $request->toJson());
        }
    }

    /**
     * Метод подготавливает url строку
     * @param $path
     * @return string
     */
    private function prepareUrl($path): string
    {
        return $this->getUrl() . $path;
    }

    /**
     * Метод возвращает url строку
     * @return string
     */
    private function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Метод подготавливает
     * данные перед запросом
     * @param $request
     * @param $headers
     * @param $url
     * @throws \Exception
     */
    private function prepareCurl($request, $headers, $url): void
    {
        $this->initCurl();

        $this->setCurlOption(CURLOPT_URL, $url);

        $this->setCurlOption(CURLOPT_RETURNTRANSFER, true);

        $this->setCurlOption(CURLOPT_HEADER, true);

        $this->setCurlOption(CURLOPT_POST, true);

        $this->setBody($request);

        $this->setCurlOption(CURLOPT_HTTPHEADER, $headers);

        $this->setCurlOption(CURLOPT_CONNECTTIMEOUT, $this->connectionTimeout);

        $this->setCurlOption(CURLOPT_TIMEOUT, $this->timeout);
    }

    /**
     * Метод обрабатывает ошибки от curl
     * @param $error
     * @param $errno
     * @throws SpaceWebCurlException
     */
    private function handleCurlError($error, $errno)
    {
        switch ($errno) {
            case CURLE_COULDNT_CONNECT:
            case CURLE_COULDNT_RESOLVE_HOST:
            case CURLE_OPERATION_TIMEOUTED:
                $msg = 'Could not connect to api SpaceWeb. Please check your internet connection and try again.';
                break;
            case CURLE_SSL_CACERT:
            case CURLE_SSL_PEER_CERTIFICATE:
                $msg = 'Could not verify SSL certificate.';
                break;
            default:
                $msg = 'Unexpected error communicating.';
        }
        $msg .= "\n\n(Network error [errno $errno]: $error)";
        throw new SpaceWebCurlException($msg);
    }

}
