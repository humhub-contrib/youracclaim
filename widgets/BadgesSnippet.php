<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\youracclaim\widgets;

use humhub\modules\youracclaim\Module;
use Yii;

/**
 * UserFollowerWidget lists all followers of the user
 *
 * @package humhub.modules_core.user.widget
 * @since 0.5
 * @author Luke
 */
class BadgesSnippet extends \yii\base\Widget
{

    public $user;

    public function run()
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('youracclaim');

        $badges = $module->getBadgeProvider()->getUserBadges($this->user);

        $showOAuthNotice = false;
        if ($this->user->id === Yii::$app->user->id && $module->getAcclaimOauthApi() !== null && !$module->getAcclaimOauthApi()->isConnected($this->user)) {
            $showOAuthNotice = true;
        }

        if (count($badges) === 0 && !$showOAuthNotice) {
            return '';
        }


        return $this->render('badges-snippet', [
            'badges' => $badges,
            'user' => $this->user,
            'isOwnProfile' => ($this->user->id === Yii::$app->user->id),
            'showOAuthNotice' => $showOAuthNotice
        ]);
    }

}

?>
