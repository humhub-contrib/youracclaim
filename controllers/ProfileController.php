<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\youracclaim\controllers;

use humhub\modules\admin\components\Controller;
use humhub\modules\content\components\ContentContainerController;
use humhub\modules\user\models\User;
use humhub\modules\youracclaim\Module;

/**
 * Class ProfileController
 *
 * @property Module $module
 * @package humhub\modules\youracclaim\controllers
 */
class ProfileController extends ContentContainerController
{

    /**
     * @inheritdoc
     */
    public $validContentContainerClasses = [User::class];

    public function actionIndex()
    {
        return $this->render('index', []);
    }

    public function actionListBadges()
    {
        /** @var User $user */
        $user = $this->contentContainer;

        $badges = $this->module->getBadgeProvider()->getUserBadges($user);

        return $this->renderPartial('list-badges', [
            'badges' => $badges
        ]);
    }

}