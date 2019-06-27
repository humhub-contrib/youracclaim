<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\youracclaim\components;

use humhub\modules\user\models\User;
use humhub\modules\youracclaim\models\Badge;
use humhub\modules\youracclaim\Module;
use Yii;
use yii\helpers\Url;
use yii\httpclient\Client;


class AcclaimOAuthAPI extends Client
{

    public $baseUrl;
    public $applicationId;
    public $secret;


    public function buildAuthorizeUrl()
    {
        return $this->baseUrl . '/oauth/authorize' .
            '?client_id=' . $this->applicationId .
            '&redirect_uri=' . urlencode($this->getCallbackUrl()) .
            '&response_type=code&state=humhub';
    }


    public function getBadges(User $user)
    {
        $accessToken = $this->getAccessToken($user);
        if (empty($accessToken)) {
            return [];
        }

        $response = $this->get('oauth/v1/users/self/badges/', [
            'access_token' => $accessToken
        ])->send();

        if (!$response->isOk) {
            $this->deleteAccessToken($user);
            Yii::error('Could get get user badges using OAuth2: ' . $response->getContent());
            return [];
        }

        $badges = [];
        foreach ($response->data['data'] as $badgeData) {
            $badges[] = Badge::createBadge($badgeData);
        }

        return $badges;
    }

    public function storeToken($code, User $user)
    {
        $response = $this->post(
            '/oauth/token',
            [
                'client_id' => $this->applicationId,
                'client_secret' => $this->secret,
                'code' => $code,
                'grant_type' => 'authorization_code',
                'redirect_uri' => $this->getCallbackUrl()
            ]
        )->send();

        if ($response->isOk && isset($response->data['access_token'])) {

            /** @var Module $module */
            $module = Yii::$app->getModule('youracclaim');

            $module->settings->user($user)->set('oauthAccessToken', $response->data['access_token']);
            $module->settings->user($user)->set('oauthRefreshToken', $response->data['refresh_token']);

            return true;
        }

        return false;
    }

    public function isConnected(User $user)
    {
        $accessToken = $this->getAccessToken($user);
        if (empty($accessToken)) {
            return false;
        }


        $response = $this->get('oauth/v1/users/self', [
            'access_token' => $accessToken
        ])->send();

        if ($response->isOk) {
            return true;
        } else {
            $this->deleteAccessToken($user);
        }

        return false;
    }

    protected function getAccessToken(User $user)
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('youracclaim');
        return $module->settings->user($user)->get('oauthAccessToken');
    }

    protected function deleteAccessToken(User $user)
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('youracclaim');
        return $module->settings->user($user)->delete('oauthAccessToken');
    }

    protected function getCallbackUrl()
    {
        return Url::to([
            '/youracclaim/oauth/callback'
        ], 'https');

    }
}
