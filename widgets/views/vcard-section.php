<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

use yii\helpers\Html;

/* @var $this \humhub\components\View */
/* @var $badges \humhub\modules\youracclaim\models\Badge[] */

?>

<br />
<p><strong><?= Yii::t('YouracclaimModule.base', 'Badges ({count}):', ['count' => count($badges)]); ?></strong></p>

<?php foreach ($badges as $badge): ?>
    <?= Html::a(Html::img($badge->imageUrl, ['width' => 46, 'style' => 'margin:4px']), $badge->url, ['target' => '_blank']); ?>&nbsp;
<?php endforeach; ?>

<?php if (count($badges) === 0): ?>
<i><?= Yii::t('YouracclaimModule.base', 'This user has not earned any badges yet.'); ?></i>
<?php endif; ?>
