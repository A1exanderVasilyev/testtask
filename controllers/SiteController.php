<?php

namespace app\controllers;

use app\models\Couponsdata;
use yii\web\Controller;
use app\models\ShopsData;
use yii\db\ActiveRecord;

class SiteController extends Controller
{
    public function actionIndex()
    {
        set_time_limit(120);
        #Couponsdata::clearTable();
        $url = 'https://www.coupons.com/coupon-codes/stores/';
        $proxy_ip = '173.44.37.82:1080';
        $mainHtml = ShopsData::curl_get($url, $proxy_ip);
        $mainDom = str_get_html($mainHtml);
        $stores = $mainDom->find(".item");
        foreach ($stores as $store) {
            $nameStores = $store->plaintext;
            $aTag = $store->find('a', 0);
            $storesUrl = $aTag->href;
            ShopsData::insShopData($nameStores, $storesUrl);
        }
        for ($i = 1; $i <= count($stores); $i++) {
            $getShop = ShopsData::getShopUrl($i);
            if ($getShop != NULL) {
                foreach ($getShop as $eachShop) {
                    $storeHtml = ShopsData::curl_get($eachShop, $proxy_ip);
                    $storeDom = str_get_html($storeHtml);
                    $coupons = $storeDom->find(".coupons-row-detail");
                    foreach ($coupons as $coupon) {
                        $titleCoup = $coupon->find(".couponTitle", 0);
                        $couponTitle = $titleCoup->plaintext;
                        $couponContent = $coupon->find(".coupon-description", 0);
                        $couponContentValue = $couponContent->plaintext;
                        $couponEndsAt = $coupon->find("div.expire-row span", 0);
                        $couponEndsAtValue = $couponEndsAt->plaintext;
                        $formatEndsDate = strtotime($couponEndsAtValue);
                        $d2 = date("Y-m-d", $formatEndsDate);
                        if (CouponsData::insCoupData($i, $couponTitle, $couponContentValue, $d2) == false) {
                            continue;
                        }
                    }
                    ShopsData::parsedUrl($i);
                }
            }
        }
    }
}
