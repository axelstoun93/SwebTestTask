<?php

require_once '../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use SpaceWeb\Data\SpaceWebResponseInterface;
use SpaceWeb\SpaceWeb;

class TestSpaceWeb extends TestCase
{

    private SpaceWeb $spaceWeb;
    private string $login = 'spacewebap';
    private string $password = 'HZq9MRwyj';

    protected function setUp(): void
    {
        parent::setUp();
        $this->spaceWeb = new SpaceWeb();
    }

    /**
     * Метод проверяет авторизацию и получения токина
     * @throws \SpaceWeb\Exceptions\SpaceWebException
     */
    public function testAuthorisation()
    {
        $token = $this->spaceWeb->authorization($this->login, $this->password);
        $this->assertIsString($token);
    }

    /**
     * Метод проверяет добавления домена
     * @throws \SpaceWeb\Exceptions\SpaceWebException
     */
    public function testAddDomain()
    {
        $domain = 'a159014db5dc152.ru';
        $prolongType = 'manual';
        $this->spaceWeb->authorization($this->login, $this->password);
        $response = $this->spaceWeb->addDomain($domain, $prolongType);

        $this->assertTrue($response instanceof SpaceWebResponseInterface);

        if ($response->isErrorResponse()) {
            $this->fail($response->getMessage());
        }
    }

}
