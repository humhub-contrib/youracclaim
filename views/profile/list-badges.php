<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

use humhub\widgets\ModalDialog;
use yii\bootstrap\Html;

/* @var $badges \humhub\modules\youracclaim\models\Badge[] */

?>

<?php ModalDialog::begin(['header' => 'Badges']) ?>

    <div class="modal-body">
        <?php foreach ($badges as $badge): ?>
            <div class="media" style="padding-bottom:12px">
                <div class="media-left" style="padding-right:12px">
                    <?= Html::a(Html::img($badge->imageUrl, ['width' => 72]), $badge->url, ['target' => '_blank']); ?>
                    &nbsp;
                </div>
                <div class="media-body" style="padding-bottom:0px">
                    <h4 class="media-heading"><?=
                        Html::a(
                            Html::encode($badge->title),
                            $badge->url, ['target' => '_blank']
                        ); ?>
                    </h4>
                    <?= Html::encode($badge->description) ?>
                    <div class="media-footer" style="padding-top:3px">
                        <small>
                            <?= Yii::t('YouracclaimModule.base', 'Issued at:'); ?>
                            <?= Yii::$app->formatter->asDate($badge->issuedAt); ?>
                            &middot; <?= Html::a(Yii::t('YouracclaimModule.base', 'Open details'), $badge->url, ['target' => '_blank']); ?>
                        </small>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <script type="text/javascript">

        // scroll to top of list
        $(".modal-body").animate({scrollTop: 0}, 200);

    </script>

<?php ModalDialog::end() ?>