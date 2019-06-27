<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\youracclaim\models;

use yii\base\Model;


/**
 * Class Badge
 * @package humhub\modules\youracclaim\models
 */
class Badge extends Model
{

    public $id;
    public $title;
    public $description;
    public $imageUrl;
    public $url;
    public $data;
    public $issuedAt;


    public static function createBadge($badgeData)
    {
        $issuedAt = new \DateTime($badgeData['issued_at']);

        return new static([
            'id' => $badgeData['badge_template']['id'],
            'url' => $badgeData['badge_template']['url'],
            'imageUrl' => $badgeData['badge_template']['image_url'],
            'title' => $badgeData['badge_template']['name'],
            'description' => $badgeData['badge_template']['description'],
            'data' => $badgeData,
            'issuedAt' => $issuedAt->getTimestamp()
        ]);
    }

}