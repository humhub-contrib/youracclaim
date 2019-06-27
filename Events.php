<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\youracclaim;


use humhub\modules\ui\widgets\CounterSetItem;
use humhub\modules\user\models\User;
use humhub\modules\user\widgets\ProfileHeaderCounterSet;
use humhub\modules\user\widgets\ProfileSidebar;
use humhub\modules\youracclaim\widgets\BadgesSnippet;
use humhub\modules\youracclaim\widgets\VCardAddon;
use Yii;
use yii\helpers\Url;

class Events
{
    public static function onProfileSidebarInit($event)
    {
        /** @var ProfileSidebar $sidebar */
        $sidebar = $event->sender;
        $sidebar->addWidget(
            BadgesSnippet::class,
            ['user' => $sidebar->user],
            ['sortOrder' => 1]
        );
    }


    public static function onProfileHeaderCounterInit($event)
    {
        /** @var ProfileHeaderCounterSet $counterSet */
        $counterSet = $event->sender;

        /** @var Module $module */
        $module = Yii::$app->getModule('youracclaim');

        $badgeCount = count($module->getBadgeProvider()->getUserBadges($counterSet->user));

        $counterSet->counters[] = new CounterSetItem([
            'label' => Yii::t('YouracclaimModule.base', 'Badges'),
            'value' => $badgeCount,
            'url' => Url::to(['/youracclaim/profile/list-badges', 'container' => $counterSet->user]),
            'linkOptions' => ['data-target' => '#globalModal']
        ]);

    }

    public static function onVCardInit($event)
    {
        /** @var humhub\modules\popovervcard\widgets\VCardAddons $vcardAddons */
        $vcardAddons = $event->sender;

        if ($vcardAddons->container instanceof User) {
            $vcardAddons->addWidget(VCardAddon::class, ['user' => $vcardAddons->container]);
        }
    }
}
