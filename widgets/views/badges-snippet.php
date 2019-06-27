<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

use humhub\libs\Html;
use yii\helpers\Url;


/* @var $badges \humhub\modules\youracclaim\models\Badge[] */
/* @var $showOAuthNotice boolean */
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <strong><?= Yii::t('YouracclaimModule.base', 'Badges'); ?></strong> (<?= count($badges) ?>)
        <?= Html::a('<small>' . Yii::t('YouracclaimModule.base', 'Show as list') . '</small>', ['/youracclaim/profile/list-badges', 'container' => $user], ['data-target' => '#globalModal', 'class' => 'pull-right']); ?>

    </div>
    <div class="panel-body">
        <?php if (count($badges) !== 0): ?>
            <?php foreach ($badges as $badge): ?>
                <?= Html::a(Html::img($badge->imageUrl, ['width' => 46, 'style' => 'margin:4px']), $badge->url, ['target' => '_blank']); ?>&nbsp;
            <?php endforeach; ?>
            <br/>
            <br/>
        <?php endif; ?>
        <?php if ($showOAuthNotice): ?>
            <p class="alert alert-default text-color-soft2">
                <strong><?php Yii::t('YouracclaimModule.base', 'Hint:'); ?></strong>
                <?= Yii::t('YouracclaimModule.base', 'Add also badges from other organizations to your profile.'); ?>
                <br/>
                <br/>
                <a href="<?= Url::to(['/youracclaim/oauth']); ?>"
                   class="btn btn-sm btn-success"><?= Yii::t('YouracclaimModule.base', 'Link Acclaim account'); ?></a>
            </p>
        <?php endif; ?>
    </div>
</div>
