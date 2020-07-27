<?php
require "lib.php";
include_once '../vendor/simple_html_dom.php';
clearTable();
set_time_limit(60);
$url = 'https://www.coupons.com/coupon-codes/stores/';
$proxy_ip = '173.44.37.82:1080';
$mainHtml = curl_get($url, $proxy_ip);
$mainDom = str_get_html($mainHtml);
$stores = $mainDom->find(".item");
foreach ($stores as $store) {
    $nameStores = $store->plaintext;
    $aTag = $store->find('a', 0);
    $storesUrl = $aTag->href;
    getShopData($nameStores, $storesUrl);
}
for ($i = 1; $i <= count($stores); $i++) {
    $getShop = getShopUrl($i);
    foreach ($getShop as $key) {
        $eachUrl = $key['url'];
        $storeHtml = curl_get($eachUrl, $proxy_ip);
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
            if (getCoupData($i, $couponTitle, $couponContentValue, $d2) === false) {
                mysqli_error($mysql);
                continue;
            }
            parsedUrl($i);
        }
    }
}
