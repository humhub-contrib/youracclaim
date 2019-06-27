<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\youracclaim\models;

use Yii;

class ConfigureForm extends \yii\base\Model
{

    public $apiBaseUrl;
    public $orgId;
    public $orgSecret;

    public $oauthBaseUrl;
    public $oauthApplicationId;
    public $oauthSecret;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['apiBaseUrl', 'orgId', 'orgSecret', 'oauthBaseUrl', 'oauthApplicationId', 'oauthSecret'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'apiBaseUrl' => Yii::t('YouracclaimModule.base', 'API base url'),
            'orgId' => Yii::t('YouracclaimModule.base', 'Organization ID'),
            'orgSecret' => Yii::t('YouracclaimModule.base', 'Organization Secret'),
            'oauthBaseUrl' => Yii::t('YouracclaimModule.base', 'OAuth2: Base Url'),
            'oauthApplicationId' => Yii::t('YouracclaimModule.base', 'OAuth2: Application ID'),
            'oauthSecret' => Yii::t('YouracclaimModule.base', 'OAuth2: Secret'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
            'apiBaseUrl' => Yii::t('YouracclaimModule.base', 'Example: https://sandbox-api.youracclaim.com or https://api.youracclaim.com'),
            'orgId' => Yii::t('YouracclaimModule.base', 'Required to enable the organization API'),
            'orgSecret' => Yii::t('YouracclaimModule.base', 'Required to enable the organization API'),
            'oauthBaseUrl' => Yii::t('YouracclaimModule.base', 'Example: https://sandbox.youracclaim.com or https://www.youracclaim.com'),
            'oauthApplicationId' => Yii::t('YouracclaimModule.base', 'Required to enable the OAuth2 API'),
            'oauthSecret' => Yii::t('YouracclaimModule.base', 'Required to enable the OAuth2 API'),
        ];
    }

    public function loadSettings()
    {
        $settings = Yii::$app->getModule('youracclaim')->settings;

        $this->apiBaseUrl = $settings->get('apiBaseUrl');
        $this->orgId = $settings->get('orgId');
        $this->orgSecret = $settings->get('orgSecret');

        $this->oauthBaseUrl = $settings->get('oauthBaseUrl');
        $this->oauthSecret = $settings->get('oauthSecret');
        $this->oauthApplicationId = $settings->get('oauthApplicationId');

        return true;
    }

    public function saveSettings()
    {
        $settings = Yii::$app->getModule('youracclaim')->settings;

        $settings->set('apiBaseUrl', $this->apiBaseUrl);
        $settings->set('orgId', $this->orgId);
        $settings->set('orgSecret', $this->orgSecret);
        $settings->set('oauthBaseUrl', $this->oauthBaseUrl);
        $settings->set('oauthSecret', $this->oauthSecret);
        $settings->set('oauthApplicationId', $this->oauthApplicationId);

        return true;
    }

}
