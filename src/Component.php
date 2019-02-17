<?php

namespace lajax\httpauth;

use Yii;
use yii\web\UnauthorizedHttpException;

/**
 * Yii2 Http Authentication component.
 *
 * config:
 *
 * ~~~
 * 'bootstrap' => ['httpAuth'],
 * 'components' => [
 *      // ...
 *      'httpAuth' => [
 *          'class' => 'lajax\httpauth\Component',
 *          'allowedIps' => ['127.0.0.1', '127.0.0.2'],
 *          'users' => [
 *              'mrsith' => '123456',
 *              'mrssith' => 'e10adc3949ba59abbe56e057f20f883e',
 *          ],
 *          'errorAction' => 'site/error',
 *      ],
 *      // ...
 * ],
 * // ...
 * ~~~
 *
 * @author Lajos Molnár <lajax.m@gmail.com>
 *
 * @since 1.0
 */
class Component extends \yii\base\Component
{
    /**
     * @var string[] Username and password pairs. The value can be either an actual password,
     * or an MD5 hash of the password.
     */
    public $users;

    /**
     * @var string[] The list of IPs that are allowed to access this application.
     */
    public $allowedIps = ['127.0.0.1', '::1'];

    /**
     * @var string The route of errorHandler page.
     */
    public $errorAction;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (Yii::$app->request->isConsoleRequest || $this->_checkAllowedIps() || $this->_checkHttpAuthentication()) {
            return;
        }

        Yii::$app->response->headers->add('WWW-Authenticate', 'Basic realm="HTTP authentication"');

        if ($this->errorAction) {
            Yii::$app->errorHandler->errorAction = $this->errorAction;
        }

        throw new UnauthorizedHttpException(Yii::t('yii', 'You are not allowed to perform this action.'), 401);
    }

    /**
     * @return bool Whether the application can be accessed by the current user.
     */
    private function _checkAllowedIps()
    {
        $ip = Yii::$app->request->getUserIP();
        foreach ($this->allowedIps as $filter) {
            if ($filter === '*' || $filter === $ip || (($pos = strpos($filter, '*')) !== false && !strncmp($ip, $filter, $pos))) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return bool Whether the application can be accessed by the current user.
     */
    private function _checkHttpAuthentication()
    {
        $username = Yii::$app->request->getAuthUser();
        $password = Yii::$app->request->getAuthPassword();
        if (isset($this->users[$username]) && ($password == $this->users[$username] || md5($password) == $this->users[$username])) {
            return true;
        }

        return false;
    }
}
