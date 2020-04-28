<?php

    require 'paypal/autoload.php';

    define('URL_SITIO','http://localhost/paypal/');

    $apiContext = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential(
            'AeWsla4-GlQTUaZkcLeUGWzeSA6a7Z6eLtI4yhGhMvgm2F1TSn4Fk-8nhf7uyuLXdbzkabAZH3pEfQLH',     // ClientID
            'EJ3DjuMuKKfSp9Rt6Dxl9Pfe6prJssbZq15DkeRQFQlMThswj8kNrzBSGZSo-oh2VTgXkMo4bw4XOaTt'      // ClientSecret
        )
);

?>