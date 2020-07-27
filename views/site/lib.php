<?php
require 'db.php';
function curl_get($url, $proxy_ip)
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
    if (curl_exec($ch) === false) {
        echo 'Curl error: ' . curl_error($ch);
    } else {
        echo 'Operation completed without any errors</br>';
    }
    curl_close($ch);
    return $data;
}

function catalogArray($data)
{
    $catalogArray = array();
    while ($row = mysqli_fetch_assoc($data)) {
        $catalogArray[] = $row;
    }
    return $catalogArray;
}

function getShopData($first, $sec)
{
    $mysql = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME) or die(mysqli_error($mysql));
    $insInShpDt = "INSERT IGNORE INTO shopsdata (shopName, url)
        VALUES('$first', '$sec')";
    mysqli_query($mysql, $insInShpDt) or die(mysqli_error($mysql));
}

function getShopUrl($i)
{
    $mysql = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME) or die(mysqli_error($mysql));
    $insInShpDt = "SELECT url FROM `shopsdata` WHERE id = $i AND parsed = '0'";
    $result = mysqli_query($mysql, $insInShpDt) or die(mysqli_error($mysql));
    return catalogArray($result);
}

function parsedUrl($i)
{
    $mysql = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME) or die(mysqli_error($mysql));
    $insInShpDt = "UPDATE shopsdata SET `parsed` = 1 WHERE id = $i";
    mysqli_query($mysql, $insInShpDt) or die(mysqli_error($mysql));
}

function clearTable()
{
    $mysql = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME) or die(mysqli_error($mysql));
    $clearCpnDt = "TRUNCATE couponsdata";
    mysqli_query($mysql, $clearCpnDt) or die(mysqli_error($mysql));
}

function getCoupData($shop_id, $title, $content, $ends_at)
{
    $mysql = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME) or die(mysqli_error($mysql));
    $insInCoupDt = "INSERT IGNORE INTO couponsdata (shop_id, title, content, ends_at)
        VALUES('$shop_id', '$title', '$content', '$ends_at')";
    mysqli_query($mysql, $insInCoupDt);
}
