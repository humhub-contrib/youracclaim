<?php

namespace humhub\modules\youracclaim\components;

use humhub\modules\user\models\User;
use humhub\modules\youracclaim\models\Badge;
use yii\base\Exception;
use yii\httpclient\Client;
use yii\httpclient\CurlTransport;
use yii\httpclient\Request;


class AcclaimAPI extends Client
{

    public $baseUrl;
    public $organizationId;
    public $apiUser;
    public $apiSecret;


    /**
     * @return Request request instance.
     */
    public function createRequest()
    {
        $this->setTransport(CurlTransport::class);
        $request = parent::createRequest();
        $request->addHeaders(['Authorization' => 'Basic ' . base64_encode($this->apiUser . ":" . $this->apiSecret)]);
        return $request;
    }

    /**
     * @param User $user
     * @return array
     * @throws Exception
     */
    public function getIssued(User $user)
    {
        $email = $user->email;

        $response = $this->get('v1/organizations/' . $this->organizationId . '/badges', ['filter' => 'recipient_email::' . $email])->send();

        if (!$response->isOk) {
            throw new Exception("Response is not ok!");
        }

        $badges = [];
        foreach ($response->data['data'] as $badgeData) {
            $badges[] = Badge::createBadge($badgeData);
        }

        return $badges;
    }


}
