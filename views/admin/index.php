<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<div class="panel panel-default">
    <div class="panel-heading"><?= Yii::t('YouracclaimModule.base', '<strong>YourAcclaim</strong> Badges Configuration'); ?></div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin(['id' => 'configure-form', 'enableClientValidation' => false, 'enableClientScript' => false]); ?>

        <div class="row">
            <div class="col-md-6">
                <h4><?= Yii::t('YouracclaimModule.base', 'Organization API'); ?></h4>
                <p><?= Yii::t('YouracclaimModule.base', 'Show your organization badges on user profiles.'); ?></p>
                <br/>

                <?= $form->field($model, 'apiBaseUrl'); ?>
                <?= $form->field($model, 'orgId'); ?>
                <?= $form->field($model, 'orgSecret'); ?>

            </div>
            <div class="col-md-6">
                <h4><?= Yii::t('YouracclaimModule.base', 'OAuth2 API'); ?></h4>
                <p><?= Yii::t('YouracclaimModule.base', 'Allows the users to add third party badges to their profile.'); ?></p>
                <br/>

                <?= $form->field($model, 'oauthBaseUrl'); ?>
                <?= $form->field($model, 'oauthApplicationId'); ?>
                <?= $form->field($model, 'oauthSecret'); ?>
            </div>

        </div>


        <div class="form-group">
            <?= Html::submitButton(Yii::t('base', 'Save'), ['class' => 'btn btn-primary', 'data-ui-loader' => '']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>