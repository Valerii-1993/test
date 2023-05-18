<?php

$partner = !empty($_POST['partner']) ? stripslashes( htmlspecialchars( $_POST[ 'partner' ] ) ) : null;
$name = !empty($_POST['name']) ? stripslashes( htmlspecialchars( $_POST[ 'name' ] ) ) : null;
$phone = !empty($_POST['phone']) ? stripslashes( htmlspecialchars( $_POST[ 'phone' ] ) ) : null;
$country = !empty($_POST['country']) ? stripslashes( htmlspecialchars( $_POST[ 'country' ] ) ) : null;
$s_country = !empty($_POST['order[country]']) ? stripslashes( htmlspecialchars( $_POST[ 'order[country]' ] ) ) : null;
$price = !empty($_POST['price']) ? stripslashes( htmlspecialchars( $_POST[ 'price' ] ) ) : null;
$wish_price = isset($_POST['wish_price']) ? stripslashes( htmlspecialchars( $_POST[ 'wish_price' ] ) ) : null;
$special_price = isset($_POST['special_price']) ? stripslashes( htmlspecialchars( $_POST[ 'special_price' ] ) ) : null;
$product_name = !empty($_POST['product_name']) ? stripslashes( htmlspecialchars( $_POST[ 'product_name' ] ) ) : null;
$promo_language = !empty($_POST['promo_language']) ? stripslashes( htmlspecialchars( $_POST[ 'promo_language' ] ) ) : null;
$sub1 = !empty($_POST['sub1']) ? stripslashes( htmlspecialchars( $_POST[ 'sub1' ] ) ) : null;
$sub2 = !empty($_POST['sub2']) ? stripslashes( htmlspecialchars( $_POST[ 'sub2' ] ) ) : null;
$sub3 = !empty($_POST['sub3']) ? stripslashes( htmlspecialchars( $_POST[ 'sub3' ] ) ) : null;
$sub4 = !empty($_POST['sub4']) ? stripslashes( htmlspecialchars( $_POST[ 'sub4' ] ) ) : null;

$utm_source = !empty($_POST['utm_source']) ? stripslashes( htmlspecialchars( $_POST[ 'utm_source' ] ) ) : null;
$utm_site = !empty($_POST['utm_site']) ? stripslashes( htmlspecialchars( $_POST[ 'utm_site' ] ) ) : null;
$utm_medium = !empty($_POST['utm_medium']) ? stripslashes( htmlspecialchars( $_POST[ 'utm_medium' ] ) ) : null;
$utm_campaign = !empty($_POST['utm_campaign']) ? stripslashes( htmlspecialchars( $_POST[ 'utm_campaign' ] ) ) : null;
$utm_content = !empty($_POST['utm_content']) ? stripslashes( htmlspecialchars( $_POST[ 'utm_content' ] ) ) : null;
$utm_term = !empty($_POST['utm_term']) ? stripslashes( htmlspecialchars( $_POST[ 'utm_term' ] ) ) : null;

$flow = !empty($_POST['flow']) ? stripslashes( htmlspecialchars( $_POST[ 'flow' ] ) ) : null;
$pxl = !empty($_POST['pxl']) ? stripslashes( htmlspecialchars( $_POST[ 'pxl' ] ) ) : null;

$getlandingUrl = !empty($_POST['landingUrl']) ? stripslashes( htmlspecialchars( $_POST[ 'landingUrl' ] ) ) : null;
$getofferId = !empty($_POST['offerId']) ? stripslashes( htmlspecialchars( $_POST[ 'offerId' ] ) ) : null;
$referrer = !empty($_POST['referrer']) ? stripslashes( htmlspecialchars( $_POST[ 'referrer' ] ) ) : null;
$channel = !empty($_POST['channel']) ? stripslashes( htmlspecialchars( $_POST[ 'channel' ] ) ) : null;
$stream_id = !empty($_POST['stream_id']) ? stripslashes( htmlspecialchars( $_POST[ 'stream_id' ] ) ) : null;


$ip=!empty($_POST['ip']) ? stripslashes( htmlspecialchars( $_POST[ 'ip' ] ) ) : null;



if($partner == 'omni') {
    $name = !empty($_POST['order']['fio']) ? stripslashes( htmlspecialchars( $_POST['order']['fio'] ) ) : null;
    $phone = !empty($_POST['order']['phone']) ? stripslashes( htmlspecialchars( $_POST['order']['phone'] ) ) : null;
}

function getIPAddress() {
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    elseif(!empty($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    else {
        $ip = '94.219.203.89';
    }
    return $ip;
}

function WriteOrders($name, $phone, $country, $product_name, $partner) {
    $date = date("d-m-Y H:i");
    $binom_version = !empty($_POST['binom_version']) ? stripslashes( htmlspecialchars( $_POST[ 'binom_version' ] ) ) : null;
    $data = $date . ';' . $name . ';' . $phone . ';' . $country . ';' . $product_name . ';' . $partner . ';' . $binom_version . ';' . PHP_EOL;
    $myfile = fopen("orders_log.csv", "a") or die("Unable to open file!");
    fwrite($myfile, $data);
    fclose($myfile);
}

if ( !empty( $name ) && !empty( $phone ) ) {
    switch ( $partner ) {
        case "drcash":
            // Required params
            $token = 'ZJU1MMYXYWETNJZHMS00MMI4LWFLMMETM2I2ZWNJYTLKYZMX';

            // Fields to send
            $post_fields = [
                'stream_code'   => $flow,
                'client'        => [
                    'phone'     => $phone,
                    'name'      => $name,
                    'ip'        => getIPAddress(),
                    'country'   => $country,
                ],
                'sub1'      => $sub1,
                'sub2'      => $sub2,
                'sub3'      => $sub3,
                'sub4'      => $sub4,
            ];

            $headers = [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://order.drcash.sh/v1/order");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_fields));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_HEADER, true);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $body = substr($response, $header_size);

            curl_close ($ch);

            if ($httpcode != 200) {
                echo 'Error: ' . $httpcode;
                echo '<br>';
                echo $response;
            }
            if ($httpcode == 200) {
                WriteOrders($name, $phone, $country, $product_name, $partner);
                header('Location: ' . 'success.php');
            }
            break;
        case "everad":
            $order = array (
                'campaign_id' => $flow,
                'name' => $name,
                'phone' => $phone,
                'sid1' => $sub1,
                'sid2' => $sub2,
                'sid3' => $sub3,
            );

            $order['ip'] = getIPAddress();

            $parsed_referer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY);
            parse_str($parsed_referer, $referer_query);

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://tracker.everad.com/conversion/new" );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt($ch, CURLOPT_POST,           1 );
            curl_setopt($ch, CURLOPT_POSTFIELDS,     http_build_query(array_merge($referer_query, $order)) );
            curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: application/x-www-form-urlencoded'));

            $result=curl_exec ($ch);

            if ($result === 0) {
                echo "Timeout! Everad CPA 2 API didn't respond within default period!";
            } else {
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($httpCode === 200) {
                    WriteOrders($name, $phone, $country, $product_name, $partner);
                    header('Location: ' . 'success.php');
                } else if ($httpCode === 400) {
                    echo "The order data is invalid! Perhaps you have already made an order for this number.";
                } else {
                    echo "Unknown error happened! Order is not accepted! Check campaign_id, probably no landing exists for your campaign!";
                }
            }

            break;
        case "aff1":
            $api_key = 'mUIO8bObC2m8wWAV';
            $target_hash = $flow;

            $params = array(
                'api_key' => $api_key,
                'country_code' => $country,
                'target_hash' => $target_hash,
                'call_language' => 'value',
                'name' => $name,
                'phone' => $phone,
                'data1' => '',
                'data2' => $sub2,
                'data3' => $sub3,
                'data4' => $sub4,
                'clickid' => $sub1,
                'ip' => getIPAddress(),
                'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '',
                'referer' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '',
                'price' => $price,
                'browser_locale' => getBrowserLocale(),
                'pxl' => $pxl
            );

            $ch = curl_init('https://api.aff1.com/v3/lead.create');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

            $response = curl_exec($ch);
            curl_close($ch);

            $result = json_decode($response, true);

            if ($result === null) {
                var_dump('The field is not filled correctly!');
            } else {
                $parameters = [
                    'pxl' => $params['pxl'],
                ];
                WriteOrders($name, $phone, $country, $product_name, $partner);
                header('Location: ' . 'success.php?' . http_build_query($parameters));
            }


            break;

        case "limonad":
            $api_url = "https://sendmelead.com/api/v3/lead/add";
            $webmaster_token = "1b57da7c37bbcbd66bc8abff48d95980";
            $args = array(
                'name' => $name,
                'phone' => $phone,
                'offerId' => $getofferId,
                'domain' => "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"],
                'ip' => getIPAddress(),
                'utm_campaign' => key_exists('utm_campaign', $_POST) ? $_POST['utm_campaign'] : null,
                'utm_content' => key_exists('utm_content', $_POST) ? $_POST['utm_content'] : null,
                'utm_medium' => key_exists('utm_medium', $_POST) ? $_POST['utm_medium'] : null,
                'utm_source' => $sub3,
                'utm_term' => $sub4,
                'clickid' => $sub1,
                'pxl' => $pxl,
            );

            $data = json_encode($args);
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $api_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data),
                    'X-Token: '.$webmaster_token,
                ),
            ));

            $result = curl_exec($curl);
            curl_close($curl);
            $result = json_decode($result, true);

            if ($result === null) {
                var_dump('The field is not filled correctly!');
            } else {
                $parameters = [
                    'pxl' => $args['pxl'],
                ];
                WriteOrders($name, $phone, $country, $product_name, $partner);
                header('Location: ' . 'success.php?' . http_build_query($parameters));
            }
            break;

        case "leadrock":
            $api_key = '21975';
            $secret = '5jwvPB0TBF0lH4auX1fMSpeSADnAHLuG';

            $params = [
                'flow_url' => 'https://leadrock.com/'.$flow,
                'user_phone' => $phone,
                'user_name' => $name,
                'other' => '',
                'ip' => getIPAddress(),
                'ua' => $_SERVER['HTTP_USER_AGENT'],
                'api_key' => $api_key,
                'sub1' => $sub1,
                'sub2' => $sub2,
                'sub3' => $sub3,
                'sub4' => $sub4,
            ];

            $url = 'https://leadrock.com/api/v2/lead/save';
            $trackUrl = $params['flow_url'] . (strpos($params['flow_url'], '?') === false ? '?' : '') . '&ajax=1' . '&ip=' . $params['ip'] . '&ua=' . $params['ua'];

            foreach ($params as $param => $value) {
                if (strpos($param, 'sub') === 0) {
                    $trackUrl .= '&' . $param . '=' . $value;
                    unset($params[$param]);
                }
            }

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $trackUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            $params['track_id'] = curl_exec($ch);

            $params['sign'] = sha1(http_build_query($params) . $secret);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
            curl_exec($ch);
            curl_close($ch);

            header('Location: ' . 'success.php?pxl='.$pxl);

            break;


        case "leadbit":
            $order = array(
                'name' => $name,
                'phone' => $phone,
                'landing' => $getlandingUrl,
                'flow_hash' => $flow,
                'country' => $country,
                'referrer' => $referrer,
                'sub1' => $sub1,
                'sub2' => $sub2,
                'sub3' => $sub3,
                'sub4' => $sub4
            );

            $url = "http://wapi.leadbit.com/api/pub/new-order/_5fa527ef6fead916950472";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
            curl_setopt($ch, CURLOPT_REFERER, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $order);

            $result = curl_exec( $ch );
            $httpCode = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
            curl_close($ch);

            $mess = "Ответ: {$result}\nСообщение:{$httpCode}";
            //          echo "Enter your name and phone number in the format +7 999 999 99 99";
            $success_url = 'success.php';


            WriteOrders($name, $phone, $country, $product_name, $partner);
            header( 'Location: ' . $success_url );
            break;

        case "terraleads":
            class CApiConnector
            {
                private $data;

                public function __get($varName){

                    if (!array_key_exists($varName,$this->data)){
                        //this attribute is not defined!
                        throw new Exception('.....');
                    }
                    else return $this->data[$varName];

                }

                public function __set($varName,$value){
                    $this->data[$varName] = $value;
                }


                public $config = array(
                    'api_key' => '6ed53fc7e094eb9b0168ef82967e04c9',
                    'user_id' => 46478,
                    'api_domain' => 'http://tl-api.com',
                );

                public function create($params, $getofferId)
                {
                    $data = array(
                        'name'      => empty($params['name']) ? '' : trim($params['name']),    //name
                        'phone'     => empty($params['phone']) ? '' : trim($params['phone']),   //phone
                        'offer_id'  => $getofferId,
                        'country'   => empty($params['country']) ? '' : trim($params['country']), //country
                    );

                    $not_require_params = array(
                        'tz', //Time zone
                        'address', //Address
                        'region', //Region
                        'city', //City
                        'zip', //Zip
                        'stream_id', //Stream ID
                        'count', //Count
                        'email', //Email
                        'user_comment', //Comment

                        //utm marks
                        'utm_source',
                        'utm_medium',
                        'utm_campaign',
                        'utm_term',
                        'utm_content',

                        //sub-parameters
                        'sub_id',
                        'sub_id_1',
                        'sub_id_2',
                        'sub_id_3',
                        'sub_id_4',

                        'referer', //User Agent
                        'user_agent', //User Agent
                        'ip', //IP
                        'extra_data' //flag that indicates that an lead can be supplemented with data
                    );

                    if( !empty($params) )
                    {
                        foreach ( $params as $param_key => $param_value )
                        {
                            if( in_array($param_key, $not_require_params) )
                            {
                                $data[$param_key] = $param_value;
                            }
                        }
                    }

                    return $this->get_data($data, 'lead', 'create');
                }

                public function extra($params)
                {
                    $data = array(
                        'id' => $params['id'], //lead ID
                    );

                    $not_require_params = array(
                        'name', //Name
                        'phone', //Phone
                        'count', //Quantity of ordered goods
                        'zip', //Zip code, postcode
                        'address', //Address
                        'building', //House number
                        'apartment', //Apartment number
                        'user_comment', //Comment
                    );

                    if( !empty($params) )
                    {
                        foreach ( $params as $param_key => $param_value )
                        {
                            if( in_array($param_key, $not_require_params) )
                            {
                                $data[$param_key] = $param_value;
                            }
                        }
                    }

                    return $this->get_data($data, 'lead', 'extra');
                }

                public function status($id)
                {
                    return $this->get_data(array(
                        'id'  => $id,
                    ), 'lead', 'status');
                }

                public function ip()
                {
                    return $this->get_data([], 'ip', 'get');
                }

                protected function check_sum($json_data){
                    return sha1($json_data . $this->config['api_key']);
                }

                protected function request($data, $model, $method, $headers = array())
                {
                    $data = array(
                        'user_id' => $this->config['user_id'],
                        'data' => $data
                    );

                    $json_data = json_encode($data);

                    $api_url = $this->config['api_domain'].'/api/'.$model.'/'.$method.'?'.http_build_query(array(
                            'check_sum' => $this->check_sum($json_data)
                        ));

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $api_url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

                    if( !empty($headers) )
                    {
                        $http_headers = array();

                        foreach( $headers as $header_name => $header_value )
                        {
                            $http_headers[] = $header_name.': '.$header_value;
                        }

                        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_headers);
                    }

                    $result = curl_exec($ch);

                    $curl_error = curl_error($ch);
                    $curl_errno = curl_errno($ch);
                    $http_code  = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                    curl_close ($ch);

                    $response = array(
                        'error'      => $curl_error,
                        'errno'      => $curl_errno,
                        'http_code'  => $http_code,
                        'result'     => $result,
                    );

                    return $response;
                }

                protected function get_data($data, $model, $method)
                {
                    $response = $this->request($data, $model, $method);

                    if( $response['http_code'] == 200 && $response['errno'] === 0 )
                    {
                        $body = json_decode($response['result']);

                        if( json_last_error() === JSON_ERROR_NONE )
                        {
                            if( $body->status == 'ok' )
                            {
                                return $body->data;
                            }
                            elseif( $body->status == 'error' )
                            {
                                throw new Exception($body->error);
                            }
                            else
                            {
                                throw new Exception('Unknown response status');
                            }
                        }
                        else
                        {
                            throw new Exception('JSON response error');
                        }
                    }else{
                        if( !empty($response['result']) )
                        {
                            $body = json_decode($response['result']);

                            if( json_last_error() === JSON_ERROR_NONE )
                            {
                                if( $body->status == 'error' )
                                {
                                    throw new Exception($body->error);
                                }
                                else
                                {
                                    throw new Exception('Unknown response status');
                                }
                            }
                            else
                            {
                                throw new Exception('JSON response error');
                            }
                        }
                        else
                        {
                            throw new Exception('HTTP request error. '.$response['error']);
                        }
                    }
                }
            }

            try {
                $apiConnector = new CApiConnector($getofferId);

                if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } else {
                    $ip = $_SERVER['REMOTE_ADDR'];
                }

                $data = array(
                    'name' => $name,
                    'phone' => $phone,
                    'country' => $country,
                    'tz' => 2,
                    'sub_id'        => $sub1,
                    'sub_id_1'      => $sub2,
                    'sub_id_2'      => $sub3,
                    'sub_id_3'      => $sub4,
                );

                if( !empty($stream_id) ){
                    $data['stream_id'] = $stream_id;
                }

                $lead = $apiConnector->create($data, $getofferId);

                if( $lead ){
                    WriteOrders($name, $phone, $country, $product_name, $partner);
                    header('Location: success.php?id='.$lead->id. '&pxl='.$pxl);
                }

            }
            catch (Exception $e) {
                echo $e->getMessage();
            }

            break;

        case "shakes":
            $apiKey = '9698c5a765b909765ecf2ff99fde1180';
            $domain = 'shakes.pro';
            $landingUrl = $getlandingUrl;
            $offerId = $getofferId;
            $streamCode = $flow;
            $successPage = 'success-in.php';
            $errorPage = '#';
            $client_ip = getIPAddress();

            $url = "http://$domain?r=/api/order/in&key=$apiKey";
            $order = [
                'countryCode' => $country,
                'createdAt' => date('Y-m-d H:i:s'),
                'ip' => $client_ip, // ip пользователя
                'landingUrl' => $landingUrl,
                'name' => $name,
                'offerId' => $getofferId,
                'phone' => $phone,
                'referrer' => $referrer,
                'streamCode' => $streamCode,
                'sub1' => $sub1,
                'sub2' => $sub2,
                'sub3' => $sub3,
                'sub4' => $sub4,
                'userAgent' => (!empty($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '-'),
            ];

            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $order);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            try {
                $responseBody = curl_exec($curl);

                @file_put_contents(
                    _DIR_ . '/shakes.response.log',
                    date('Y.m.d H:i:s') . ' ' . $responseBody,
                    FILE_APPEND
                );

                if (empty($responseBody)) {
                    throw new Exception('Error: Empty response for order. ' . var_export($order, true));
                }
                /**
                 * @var StdClass $response
                 */
                $response = json_decode($responseBody, true);
                // возможно пришел некорректный формат
                if (empty($response)) {
                    throw new Exception('Error: Broken json format for order. ' . PHP_EOL . var_export($order, true));
                }
                // заказ не принят API
                if ($response['status'] != 'ok') {
                    throw new Exception('Success: Order is accepted. '
                        . PHP_EOL . 'Order: ' . var_export($order, true)
                        . PHP_EOL . 'Response: ' . var_export($response, true)
                    );
                }

                WriteOrders($name, $phone, $country, $product_name, $partner);
                curl_close($curl);

                if(!empty($successPage) && is_file(__DIR__ . '/' . $successPage)) {
                    header('Location:' . $successPage . '?pxl=' . $pxl . '&country=' . $country );
                }
            } catch (Exception $e) {

                @file_put_contents(
                    __DIR__ . '/order.error.log',
                    date('Y.m.d H:i:s') . ' ' . $e->getMessage() . PHP_EOL . $e->getTraceAsString(),
                    FILE_APPEND
                );

                if(!empty($errorPage) && is_file(__DIR__ . '/' . $errorPage)) {
                    include __DIR__ . '/' . $errorPage;
                }
            }
            break;

        case "lucky":
            $userAgent = $_SERVER[ 'HTTP_USER_AGENT' ]; // userAgent ( Поле обязательное )
            $order = array(
                'campaign_hash' => $flow,
                'ip' => $_SERVER[ 'REMOTE_ADDR' ],
                'name' => $name,
                'phone' => $phone,
                'user_agent' => $userAgent,
                'country' => $country,
                'subid1' => $sub1,
                'subid2' => $sub2,
                'subid3' => $sub3,
                'utm_medium' => $sub3,
                'utm_term' => $sub4
            );

            $ch = curl_init();

            curl_setopt( $ch, CURLOPT_URL, "https://lucky.online/api/v1/lead-create/webmaster?api_key=" );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt( $ch, CURLOPT_POST, 1 );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $order ) );
            curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/x-www-form-urlencoded' ) );

            $result = curl_exec( $ch );
            $httpCode = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
            $mess = "Ответ: {$result}\nСообщение:{$httpCode}";

            WriteOrders($name, $phone, $country, $product_name, $partner);
            $success_url = 'success.php?pxl=' . $pxl . '&country=' . $country;
            header( 'Location: ' . $success_url );

            break;

        case "omni":
            require_once dirname(__FILE__) . '/OmniApi3/OmniApi_User_03.php';
            if(!empty($_POST))
            {
                /** @var OmniApi_User_03 $api */
                $api = OmniApi_User_03::init()
                    ->setToken('I7PV6RkWZeUXNxdKhCX8PP')
                    ->setSecret('gnI7VDHFdMNzhqXJCojMRd');

                $discount = !empty($_POST['order']['discount']) ? $_POST['order']['discount'] : '';
                $timezone = !empty($_POST['order']['timezone']) ? $_POST['order']['timezone'] : '';

                $country_log = $country;
                if($country == 'rueu') { $country = ''; }
                if(!empty($s_country)) { $country = $s_country; }

                if($wish_price !== null) {
                    $price = null;
                }

                /** @var OmniApiCreateOrder $entity */
                $entity = $api->initCreateOrder()
                    ->setSpecialPrice($special_price)
                    ->setWishPrice($wish_price)
                    ->setPrice($price)
                    ->setIsRoulette()
                    ->setProductId($getofferId)
                    ->setPromoLanguage($promo_language)
                    ->setPayAction('confirmed')
                    ->setTrafficFlowId($flow)
                    ->setCountry($country)
                    ->setFio($name)
                    ->setDiscount($discount)
                    ->setTimezone($timezone)
                    ->setPbid($sub1)
                    ->setPhone($phone)
                    ->setUtmSource($utm_source)
                    ->setUtmSite($utm_site)
                    ->setUtmMedium($utm_medium)
                    ->setUtmCampaign($utm_campaign)
                    ->setUtmContent($utm_content)
                    ->setUtmTerm($utm_term);

                $response = $api->request($entity);

                header('Content-Type: application/json');
                if($response['success']){
                    print(json_encode([
                        'order_created' => [
                            'phone' => $phone,
                            'fio' => $name,

                        ]
                    ]));
                    WriteOrders($name, $phone, $country_log, $product_name, $partner);
//              $success_url = 'success.php?pxl=' . $pxl . '&country=' . $country;
//              header( 'Location: ' . $success_url );

                } else {
                    $error = 'l_pl55';
                    $responseErrorKeys = array_keys($response['error']);
                    $errorCode = $responseErrorKeys[0];
                    if($errorCode == '203103') $error = 'l_pl1';
                    if($errorCode == '203104') $error = 'l_pl53';
                    if($errorCode == '203109') $error = 'l_pl7';
                    print(json_encode([
                        'order_created' => [
                            'error' => $error,
                            '$response' => $response,
                            'country' => $country
                        ]
                    ]));
                }
                exit;
            }

            break;

        case "kma":
            $url = 'https://api.kma.biz/lead/add';
            $api_key = 'CwKVVCR68CyXQ_w-__gIX-Ee5vsKdw1i';
            $referer = $_SERVER['HTTP_REFERER'];
            $ip = getIPAddress();

            $order = [
                'channel' => $channel,
                'name' => $name,
                'phone' => $phone,
                'offer_id' => $getofferId,
                'ip' => $ip,
                'country' => $country,
                'referer' => $referer,
                'data1' => $sub1,
                'data2' => $sub2,
                'data3' => $sub3,
                'data4' => $sub4,
            ];
            $headers = [
                'Authorization: Bearer ' . $api_key,
                'Content-Type: application/x-www-form-urlencoded',
                'User-Agent:' . $_SERVER['HTTP_USER_AGENT']
            ];

            if ($curl = curl_init()) {

                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_HEADER, false);
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($order));
                curl_setopt($curl, CURLINFO_HEADER_OUT, true);
                $result = curl_exec($curl);
                curl_close($curl);
            }
            $res = json_decode($result, true);
            if($res['code'] == 0){
                WriteOrders($name, $phone, $country, $product_name, $partner);
                $success_url = 'success.php?pxl=' . $pxl . '&country=' . $country;
                header('Location:'. $success_url);
            }else{
                echo $res['message'];
            }
            break;

        case "metacpa":
            $country_code = $country;
            switch ($country) {
                case 'bg':
                    $country = '31697';
                    break;
                case 'Deutschland':
                    $country = '64127';
                    break;
                case 'es':
                    $country = '46846';
                    break;
                case 'it':
                    $country = '48162';
                    break;
                case 'pl':
                    $country = '32250';
                    break;
                case 'Россия':
                    $country = '26927';
                    break;
                case 'by':
                    $country = '28953';
                    break;
                case 'ro':
                    $country = '29625';
                    break;
                case 'kz':
                    $country = '28711';
                    break;
                case 'cz':
                    $country = '92368';
                    break;
                case 'lt':
                    $country = '28525';
                    break;
                case 'lv':
                    $country = '26932';
                    break;
                case 'ee':
                    $country = '26930';
                    break;
                case 'sk':
                    $country = '339464';
                    break;
                case 'hu':
                    $country = '31134';
                    break;
                case 'vn':
                    $country = '36864';
                    break;
            }
            $ip = getIPAddress();

            $order = array(
                'flow_id' => $flow,
                'offerId' => $getofferId,
                'ip' => $ip,
                'name' => $name,
                'phone' => $phone,
                'geo' => $country,
                'sub1' => $sub1,
                'sub2' => $sub2,
                'sub3' => $sub3,
                'sub4' => $sub4
            );

            $ch = curl_init();

            curl_setopt( $ch, CURLOPT_URL, "http://metacpa.ru/create" );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt( $ch, CURLOPT_POST, 1 );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $order ) );
            curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/x-www-form-urlencoded' ) );

            $result = curl_exec( $ch );
            $httpCode = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
            $mess = "Ответ: {$result}\nСообщение:{$httpCode}";

            WriteOrders($name, $phone, $country, $product_name, $partner);

            $success_url = 'success.php?pxl=' . $pxl . '&country=' . $country_code;
            header( 'Location: ' . $success_url );

            break;

        case "everad":
            $order = array(
                'campaign_id' => $flow,
                'utm_content' => $sub1,
                'utm_term' => $sub4,
                'ip' => $_SERVER[ 'REMOTE_ADDR' ],
                'name' => $name,
                'phone' => $phone,
                'country_code' => $country,
                'sid1' => $sub1,
                'sid2' => $sub2,
                'sid3' => $sub3,
                'sid4' => $sub4
            );

            $ch = curl_init();

            curl_setopt( $ch, CURLOPT_URL, "https://tracker.everad.com/conversion/new" );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt( $ch, CURLOPT_POST, 1 );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $order ) );
            curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/x-www-form-urlencoded' ) );

            $result = curl_exec( $ch );
            $httpCode = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
            $mess = "Ответ: {$result}\nСообщение:{$httpCode}";

            WriteOrders($name, $phone, $country, $product_name, $partner);
            $success_url = 'success.php?pxl=' . $pxl . '&country=' . $country;
            header( 'Location: ' . $success_url );

            break;

        case "leadtrade":
            $post = [
                'name' => $name,
                'phone' => $phone,
                'aim' => stripslashes( htmlspecialchars( $_POST[ 'aim' ] ) ),
                'productsum' => stripslashes( htmlspecialchars( $_POST[ 'productsum' ] ) ),
                'hash' => stripslashes( htmlspecialchars( $_POST[ 'hash' ] ) ),
                'subid1' => $sub1,
                'subid2' => $sub2,
                'subid3' => $sub3,
                'subid4' => $sub4,
                'ip' => getIPAddress(),
            ];
            var_dump($post);

            $ch = curl_init("https://leadtrade.ru/api/send_lead");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Linux x86_64)
              AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.152
              Safari/537.36");

            $doc = curl_exec($ch);
            curl_close($ch);

            WriteOrders($name, $phone, $country, $product_name, $partner);
            $success_url = 'success.php?name=' . $name . '&product_name=' . $product_name . '&sub1=' . $sub1 . '&pxl=' . $pxl . '&sub2=' . $sub2 . '&phone=' . $phone . '&country=' . $country;
            header( 'Location: ' . $success_url );

            break;

        case "adcombo":
            $API_URL = 'https://api.adcombo.com/api/v2/order/create/';
            $API_KEY = '034ab58d67d42da4f33a36e97a1f1fd7';

            $order = array(
                'api_key' => $API_KEY,
                'name' => $name,
                'phone' => $phone,
                'offer_id' => $getofferId,
                'country_code' => $country,
                'price' => $price,
                'base_url' => $_SERVER['REQUEST_URI'],
                'ip' => getIPAddress(),
                'referrer' => $_SERVER['HTTP_REFERER'],

                'subacc' => $sub1,
                'subacc2' => $sub2,
                'subacc3' => $sub3,
                'subacc4' => $sub4,

                'clickid' => $sub1,
                'esub' => stripslashes( htmlspecialchars( $_POST[ 'esub' ] ) ),
            );

            $url = $API_URL.'?'.http_build_query($order);
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true
            ));
            $res = curl_exec($curl);
            curl_close($curl);
            $res = json_decode($res, true);
            if ($res['code'] == 'ok') {
                $_SESSION['printname']= $name;
                $_SESSION['printphone']=$phone;
                echo $res['msg'] . ": " . $res['order_id'];
                echo $url;
                WriteOrders($name, $phone, $country, $product_name, $partner);
                $success_url = 'success-' . $country . '.php?name=' . $name . '&product_name=' . $product_name . '&sub1=' . $sub1 . '&pxl=' . $pxl . '&sub2=' . $sub2 . '&phone=' . $phone . '&country=' .  $country;
                header( 'Location: ' . $success_url );
            } else {
                echo $res['error'];
            }

            break;









            case "webvork":
                $TOKEN = 'bfe650970fae3dddcba0b76d6bf28e16';
                $ENDPOINT_1 = 'https://api.webvork.com/v1/new-lead';
                $ENDPOINT_2 = 'https://api2.webvork.com/v1/new-lead';

                if (!empty($_POST)) {
                    $data = array(
                        'token' => $TOKEN,
                        'offer_id' => $getofferId,
                        'name' => $name,
                        'phone' => $phone,
                        'country' => $s_country,
                        'utm_source' => $utm_source,
                        'utm_medium' => $utm_medium,
                        'utm_campaign' => $utm_campaign,
                        'utm_content' => $utm_content,
                        'utm_term' => $utm_term,
                        'ip' => getIPAddress(),
                    );
                 $count = 3;
                    while ($count--) {
                        if (apiWebvorkV1NewLead($data)) {
                            break;
                        } else {
                            sleep(2);
                        }
                    }

            header("Location: success.php");
            die();
        }

        healthCheck();
        // Classes and functions
        function healthCheck()
        {
            checkUserAgent();
            echo '<h3>Health check</h3>';
            if ('3532ccb861ab10ef86a6d073c27c1246' == $TOKEN) {
                echo 'Error: TOKEN is registered by default, you need to replace it with a token from your personal account. <br>';
            }

            try {
                $data = array(
                    'token' => $TOKEN,
                    'offer_id' => 1,
                    'ip' => getIPAddress(),
                    'name' => 'Test',
                    'phone' => '+12345',
                    'country' => 'IT',
                );

                $client = new SuperClient();
                $client->addEndpoint(ENDPOINT_2)
                    ->addEndpoint(ENDPOINT_2)
                    ->setWaitHttpStatus200(true);

                $response = $client->send($data);

                if ($response) {
                    echo 'API test sent, result: ' . $response . '<br>';
                } else {
                    echo 'Error: Failed to send request <br>';
                }
            } catch (Exception $e) {
                echo 'Error: ' . $e->getMessage() . '<br>';
            }
        }

        function checkUserAgent()
        {
            if (
                empty($_SERVER['HTTP_USER_AGENT'])
                || !preg_match('#Windows|Mac|Linux|Android|iPad|iPhone#i', $_SERVER['HTTP_USER_AGENT'])
            ) {
                die();
            }
        }

        function apiWebvorkV1NewLead($data)
        {
            checkData($data);

            $client = new SuperClient();
            $client->addEndpoint(ENDPOINT_1)
                ->addEndpoint(ENDPOINT_2)
                ->setWaitHttpStatus200(true);

            $response = $client->send($data);

            $json = json_decode($response, true);

            if (isset($json['status'])) {

                return true;
            }

            return false;
        }

        function checkData($data)
        {
            // the token is missing or registered by default
            if (empty($data['token']) || '3532ccb861ab10ef86a6d073c27c1246' == $data['token']) {
                header("Location: /?error=token");
                die();
            }
            // the offer is missing or registered by default
            if (empty($data['offer_id'])) {
                header("Location: /?error=offer");
                die();
            }
            // the phone is missing
            if (empty($data['phone'])) {
                header("Location: /?error=phone");
                die();
            }
            // the country is missing
            if (empty($data['country'])) {
                header("Location: /?error=country");
                die();
            }
        }

        class SuperClient
        {
            /** @var array */
            private $endpoints;
            /** @var array */
            private $requests;
            /** @var int */
            private $socketTimeout;
            /** @var array */
            private $response;
            /** @var false */
            private $waitHttpStatus200;

            public function __construct()
            {
                $this->requests = array();
                $this->socketTimeout = 20;
                $this->response = array();
                $this->endpoints = array();
                $this->waitHttpStatus200 = false;
            }

            public function send($data)
            {
                if (!count($this->endpoints)) {
                    throw new \Exception('add endpoint first ->addEndpoint($url)');
                }

                $content = http_build_query($data);
                $data['requestId'] = sha1(time() . $content);

                foreach ($this->endpoints as $endpoint) {
                    $this->sendHttpRequest($endpoint, $data);
                }

                $response = $this->catchResponse();
                $this->closeAllRequests();

                return $response ? $this->getResponseBody($response['rawResponse']) : '';
            }

            public function addEndpoint($url)
            {
                $this->endpoints[] = $url;

                return $this;
            }

            public function setWaitHttpStatus200($val)
            {
                $this->waitHttpStatus200 = $val;

                return $this;
            }

            private function sendHttpRequest($url, $data)
            {
                $urlParsed = parse_url($url);

                $scheme = !empty($urlParsed['scheme']) ? $urlParsed['scheme'] : 'http'; // https
                $host = !empty($urlParsed['host']) ? $urlParsed['host'] : null;  // www.google.com
                $port = !empty($urlParsed['port']) ? $urlParsed['port'] : null; // 8080
                $path = !empty($urlParsed['path']) ? $urlParsed['path'] : '/'; // /path
                $query = !empty($urlParsed['query']) ? '?' . $urlParsed['query'] : ''; // ?search=1


                if (!$port && 'https' == $scheme) {
                    $port = 443;
                }

                if (!$port && 'http' == $scheme) {
                    $port = 80;
                }

                $hostname = ('https' == $scheme)
                    ? 'ssl://' . $host . ':' . $port
                    : $host . ':' . $port;

                $context = stream_context_create(
                    array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true,
                        )
                    )
                );

                $fp = @stream_socket_client(
                    $hostname,
                    $error_code,
                    $error_message,
                    $this->socketTimeout,
                    STREAM_CLIENT_CONNECT,
                    $context
                );

                if ($fp) {
                    $content = http_build_query($data);
                    stream_set_blocking($fp, false);
                    $httpRequest = "POST " . $path . $query . " HTTP/1.0\r\n";
                    $httpRequest .= "Host: " . $host . "\r\n";
                    $httpRequest .= "Content-Type: application/x-www-form-urlencoded\r\n";
                    $httpRequest .= "Content-Length: " . strlen($content) . "\r\n";
                    $httpRequest .= "Connection: Close\r\n\r\n";
                    $httpRequest .= $content;

                    fwrite($fp, $httpRequest);
                    $this->addRequest($url, $fp);
                }

                return $this;
            }

            private function catchResponse()
            {
                $this->response = array();

                $startReadingTime = time();
                while (true) {
                    if (!count($this->requests)) {
                        return array();
                    }

                    $someDataRecieved = false;

                    foreach ($this->requests as $key => $requestData) {
                        if (!feof($requestData['fp'])) {
                            $part = fgets($requestData['fp'], 1024);
                            if ($part) {
                                $someDataRecieved = true;
                                $this->requests[$key]['rawResponse'] .= $part;
                            }
                        } else {
                            if ($this->waitHttpStatus200) {
                                if ($this->checkHttpStatus200($this->requests[$key]['rawResponse'])) {
                                    $this->response = $this->requests[$key];

                                    return $this->response;
                                } else {
                                    $this->closeRequestByKey($key);
                                }
                            } else {
                                $this->response = $this->requests[$key];

                                return $this->response;
                            }
                        }
                    }

                    if (time() - $startReadingTime >= $this->socketTimeout) {

                        return $this->response;
                    }

                    if (!$someDataRecieved) {
                        usleep(100000);
                    }
                }
            }

            private function addRequest($url, $fp)
            {
                $this->requests[] = array(
                    'url' => $url,
                    'fp' => $fp,
                    'rawResponse' => '',
                );
            }

            private function closeRequestByKey($key)
            {
                if (isset($this->requests[$key]['fp'])) {
                    @fclose($this->requests[$key]['fp']);
                }
                unset($this->requests[$key]);
            }

            private function closeAllRequests()
            {
                foreach ($this->requests as $key => $treadData) {
                    $this->closeRequestByKey($key);
                }
            }

            private function checkHttpStatus200($string)
            {
                $firstLine = strstr($string, "\r\n", true);
                if ($firstLine && strpos($firstLine, '200') !== false) {
                    return true;
                }

                return false;
            }
            private function getResponseBody($string)
            {
                $body = substr($string, strpos($string, "\r\n\r\n") + 4, strlen($string));

                return $body;
            }
        }
                    break;

} else {
    switch ( $country ) {
        case "en":
            echo "Something went wrong, please fill out all the fields";
            sleep( 3 );
            header( 'location:' . $_SERVER[ 'HTTP_REFERER' ] );

            break;
        case "ru":
            echo "Что-то пошло не так, заполните все поля формы";
            sleep( 3 );
            header( 'location:' . $_SERVER[ 'HTTP_REFERER' ] );
            break;
        default:
            echo "Something went wrong, please fill out all the fields";
            sleep( 3 );
            header( 'location:' . $_SERVER[ 'HTTP_REFERER' ] );
    }

}

?>
