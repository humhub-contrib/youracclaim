<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\youracclaim\controllers;

use humhub\modules\user\components\BaseAccountController;
use humhub\modules\youracclaim\components\AcclaimOAuthAPI;
use humhub\modules\youracclaim\Module;
use Yii;
use yii\helpers\Url;
use yii\web\HttpException;


/**
 * Class OauthController
 *
 * @property Module $module
 * @package humhub\modules\youracclaim\controllers
 */
class OauthController extends BaseAccountController
{
    /**
     * @var AcclaimOAuthAPI
     */
    protected $api;

    public function beforeAction($action)
    {
        $this->api = $this->module->getAcclaimOauthApi();
        if ($this->api === null) {
            throw new HttpException('404', 'OAuth2 API not enabled!');
        }

        return parent::beforeAction($action);
    }


    public function actionIndex()
    {

        return $this->redirect($this->api->buildAuthorizeUrl());
    }


    public function actionCallback($code)
    {
        /** @var User $user */
        $user = Yii::$app->user->getIdentity();

        $this->module->getBadgeProvider()->flushCache($user);

        if ($this->api->storeToken($code, $user)) {
            $this->view->setStatusMessage(
                'success',
                Yii::t('YouracclaimModule.base', 'Successfully connected to YourAcclaim!')
            );
        } else {
            $this->view->setStatusMessage(
                'error',
                Yii::t('YouracclaimModule.base', 'Could not connect your account to YourAcclaim!')
            );
        }

        return $this->redirect(Url::to(['/user/profile', 'container' => $user]));
    }
}