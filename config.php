<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

use humhub\modules\user\components\ActiveQueryUser;
use humhub\modules\user\models\User;
use humhub\modules\user\widgets\ProfileHeaderCounterSet;
use humhub\widgets\LayoutAddons;
use humhub\modules\user\widgets\ProfileSidebar;
use humhub\widgets\BaseStack;

return [
    'id' => 'youracclaim',
    'class' => 'humhub\modules\youracclaim\Module',
    'namespace' => 'humhub\modules\youracclaim',
    'events' => [
        [ProfileSidebar::class, ProfileSidebar::EVENT_BEFORE_RUN, [\humhub\modules\youracclaim\Events::class, 'onProfileSidebarInit']],
        [ProfileHeaderCounterSet::class, ProfileHeaderCounterSet::EVENT_INIT, [\humhub\modules\youracclaim\Events::class, 'onProfileHeaderCounterInit']],
        ['humhub\modules\popovervcard\widgets\VCardAddons', BaseStack::EVENT_INIT, [\humhub\modules\youracclaim\Events::class, 'onVCardInit']]
    ],
];
?>