<?php

namespace spec\lajax\httpauth;

use yii\base\Configurable;
use yii\web\Application;
use yii\web\UnauthorizedHttpException;
use PhpSpec\ObjectBehavior;

class ComponentSpec extends ObjectBehavior
{
    /**
     * @var Application
     */
    private $app;

    public function let()
    {
        unset($_SERVER['PHP_AUTH_USER']);
        unset($_SERVER['PHP_AUTH_PW']);

        $this->app = new Application([
            'id' => 'testapp',
            'basePath' => __DIR__,
        ]);
        $this->app->request->setIsConsoleRequest(false);

        $this->beConstructedWith([
            'allowedIps' => [
                '127.0.0.1',
                '127.0.100.*',
                '::1',
                'fe80:0:0:0:202:b3ff:fe1e:*',
            ],
            'users' => [
                'test' => 'pw123456',
                'test_md5' => md5('pw654321'),
            ],
        ]);
    }

    public function it_is_configurable()
    {
        $this->shouldBeAnInstanceOf(Configurable::class);
    }

    public function it_accepts_authorized_ipv4_address()
    {
        $this->setAuthorizedUserIp();

        $this->shouldNotThrow(UnauthorizedHttpException::class)
            ->duringInstantiation();
    }

    public function it_accepts_authorized_ipv6_address()
    {
        $this->setUserIp('::1');

        $this->shouldNotThrow(UnauthorizedHttpException::class)
            ->duringInstantiation();
    }

    public function it_accepts_authorized_ipv4_address_when_ip_is_configured_with_asterisk()
    {
        $this->setUserIp('127.0.100.100');

        $this->shouldNotThrow(UnauthorizedHttpException::class)
            ->duringInstantiation();
    }

    public function it_accepts_authorized_ipv6_address_when_ip_is_configured_with_asterisk()
    {
        $this->setUserIp('fe80:0:0:0:202:b3ff:fe1e:8329');

        $this->shouldNotThrow(UnauthorizedHttpException::class)
            ->duringInstantiation();
    }

    public function it_accepts_correct_username_and_password_on_unauthorized_ip_address()
    {
        $this->setUnauthorizedUserIp();
        $this->setHttpAuth('test', 'pw123456');

        $this->shouldNotThrow(UnauthorizedHttpException::class)
            ->duringInstantiation();
    }

    public function it_accepts_correct_username_and_password_on_unauthorized_ip_address_when_password_is_hashed_in_config()
    {
        $this->setUnauthorizedUserIp();
        $this->setHttpAuth('test_md5', 'pw654321');

        $this->shouldNotThrow(UnauthorizedHttpException::class)
            ->duringInstantiation();
    }

    public function it_throws_an_exception_on_unauthorized_ip_address()
    {
        $this->setUnauthorizedUserIp();

        $this->shouldThrow(UnauthorizedHttpException::class)
            ->duringInstantiation();
    }

    public function it_should_not_run_on_console_application()
    {
        $this->setUnauthorizedUserIp();
        $this->app->request->setIsConsoleRequest(true);

        $this->shouldNotThrow(UnauthorizedHttpException::class)
            ->duringInstantiation();
    }

    private function setUnauthorizedUserIp()
    {
        $this->setUserIp('1.1.1.1');
    }

    private function setAuthorizedUserIp()
    {
        $this->setUserIp('127.0.0.1');
    }

    private function setUserIp(string $ip)
    {
        $_SERVER['REMOTE_ADDR'] = $ip;
    }

    private function setHttpAuth(string $username, string $password)
    {
        $_SERVER['PHP_AUTH_USER'] = $username;
        $_SERVER['PHP_AUTH_PW'] = $password;
    }
}
