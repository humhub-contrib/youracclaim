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
use yii\base\Component;


/**
 * Class BadgeProvider
 * @package humhub\modules\youracclaim\components
 */
class BadgeProvider extends Component
{

    public $_loadedUserBadges = [];

    const CACHE_ID_ORGANIZATION = 'acclaim_u_badges_';
    const CACHE_ID_USER = 'acclaim_o_badges_';


    public function getUserBadges(User $user)
    {
        if (isset($this->_loadedUserBadges[$user->id]) && is_array($this->_loadedUserBadges[$user->id])) {
            return $this->_loadedUserBadges[$user->id];
        }

        /** @var Module $module */
        $module = $this->getModule();

        $badges = [];
        $orgApi = $module->getAcclaimOrganizationApi();
        if ($orgApi !== null) {
            $badges = Yii::$app->cache->getOrSet(static::CACHE_ID_ORGANIZATION . $user->id, function () use ($user, $module, $orgApi) {
                return $orgApi->getIssued($user);
            }, $module->badgeCachingDuration);
        }

        $userBadges = [];
        $oauthApi = $module->getAcclaimOauthApi();
        if ($oauthApi !== null) {
            $userBadges = Yii::$app->cache->getOrSet(static::CACHE_ID_USER . $user->id, function () use ($user, $module, $oauthApi) {
                return $oauthApi->getBadges($user);
            }, $module->badgeCachingDuration);
        }

        $this->_loadedUserBadges[$user->id] = $this->removeDuplicates(array_merge($badges, $userBadges));

        return $this->_loadedUserBadges[$user->id];
    }


    public function flushCache($user)
    {
        Yii::$app->cache->delete(static::CACHE_ID_ORGANIZATION . $user->id);
        Yii::$app->cache->delete(static::CACHE_ID_USER . $user->id);
    }


    protected function removeDuplicates($badgeArray)
    {
        $newBadgeArray = [];

        /** @var Badge $badge */
        foreach ($badgeArray as $badge) {
            $newBadgeArray[$badge->id] = $badge;
        }

        return $newBadgeArray;
    }


    /**
     * @return Module
     */
    protected function getModule()
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('youracclaim');

        return $module;
    }
}