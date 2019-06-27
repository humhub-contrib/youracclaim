<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\youracclaim;

use humhub\modules\youracclaim\components\AcclaimAPI;
use humhub\modules\youracclaim\components\AcclaimOAuthAPI;
use humhub\modules\youracclaim\components\BadgeProvider;
use yii\helpers\Url;

class Module extends \humhub\components\Module
{
    private $_acclaimApi = null;
    private $_acclaimOauthApi = null;
    private $_badgeProvider = null;


    public $badgeCachingDuration = 600;

    public $resourcesPath = 'resources';

    public function getConfigUrl()
    {
        return Url::to(['/youracclaim/admin']);
    }

    /**
     * @return AcclaimOAuthAPI|null
     */
    public function getAcclaimOauthApi()
    {
        if ($this->_acclaimOauthApi !== null) {
            return $this->_acclaimOauthApi;
        }

        if (empty($this->settings->get('oauthSecret')) ||
            empty($this->settings->get('oauthApplicationId'))) {
            return null;
        }

        $this->_acclaimOauthApi = new AcclaimOAuthAPI([
            'baseUrl' => $this->settings->get('oauthBaseUrl'),
            'secret' => $this->settings->get('oauthSecret'),
            'applicationId' => $this->settings->get('oauthApplicationId')
        ]);

        return $this->_acclaimOauthApi;
    }

    /**
     * @return AcclaimAPI|null
     */
    public function getAcclaimOrganizationApi()
    {
        if ($this->_acclaimApi !== null) {
            return $this->_acclaimApi;
        }

        $apiBaseUrl = $this->settings->get('apiBaseUrl');
        $orgId = $this->settings->get('orgId');
        $orgSecret = $this->settings->get('orgSecret');

        if (empty($apiBaseUrl) || empty($orgId) || empty($orgSecret)) {
            return null;
        }

        $this->_acclaimApi = new AcclaimAPI([
            'baseUrl' => $apiBaseUrl,
            'apiUser' => $orgSecret,
            'organizationId' => $orgId
        ]);

        return $this->_acclaimApi;
    }

    public function getBadgeProvider()
    {
        if ($this->_badgeProvider !== null) {
            return $this->_badgeProvider;
        }

        $this->_badgeProvider = new BadgeProvider();
        return $this->_badgeProvider;
    }

}
