<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\youracclaim\widgets;

use humhub\components\Widget;
use Yii;


/**
 * Class VCardAddon
 * @package humhub\modules\youracclaim\widgets
 */
class VCardAddon extends Widget
{
    public $user;

    public function run()
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('youracclaim');

        $badges = $module->getBadgeProvider()->getUserBadges($this->user);

  #      if (count($badges) === 0) {
 #           return '';
#        }

        return $this->render('vcard-section', ['badges' => $badges]);
    }
}