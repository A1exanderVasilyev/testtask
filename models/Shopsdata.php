<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "shopsdata".
 *
 *@property int $id
 *@property string|null $shopName
 *@property string|null $url
 *@property int|null $parsed
 */

class Shopsdata extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'shopsdata';
    }

    public static function curl_get($url, $proxy_ip)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_PROXY, $proxy_ip);
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        #curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxy_user.':'.$proxy_pass);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36");
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public static function insShopData($nameStores, $storesUrl)
    {
        $model = Shopsdata::find()->asArray()->where(['shopName' => $nameStores])->all();
        if ($model == false) {
            Yii::$app->db->createCommand()->upsert('shopsdata', [
                'shopName' => $nameStores,
                'url' => $storesUrl,
                'parsed' => 0,
            ])->execute();
        }
    }

    public static function getShopUrl($i)
    {
        $shopUrl = Shopsdata::find()->asArray()->select('url')->where(['id' => $i, 'parsed' => 0])->limit(1)->one();
        return $shopUrl;
    }

    public static function parsedUrl($i)
    {
        $parsed = Shopsdata::find()->where(['id' => $i])->one();
        $parsed->parsed = 1;
        $parsed->save();
        #return $insInShpDt;
    }
}
