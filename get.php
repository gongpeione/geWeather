<?php
//phpinfo();
    $input = $_GET;

	if(isset($input['id']))
        $id = mysql_real_escape_string($input['id']);

    $mysql = new SaeMysql();

    $date = date('Y-m-d',time());
    $sql = "SELECT * FROM `shu_weather` where date = '$date' and cityID = '$id'";
    $dataFromDB = $mysql->getData( $sql );

    if(!empty($dataFromDB[0]['data'])) 
    {
        //print_r(json_decode($dataFromDB[0]['data']));
        header("Content-type:text/html;charset=utf8");
        echo htmlentities(urldecode($dataFromDB[0]['data']));
    } 
    else 
    {
            //echo $id;
        preg_match_all('/[0-9]{9}/', $id, $matches);
        
        $id = $matches[0][0];
        

            $url = "http://m.weather.com.cn/mweather/$id.shtml";
            
            $order = array("\r\n","\n","\r");
            
            while(1)
            {            
                $content = str_replace($order,'',curl_get($url));
                $forcast = explode('</span></li><li><b>明天', $content);

                preg_match_all('/<a href="\/manage\/citmani.html" title="更换城市">(.*?)<\/a>/', $content, $cityName);
                preg_match_all('/<h2>(.*)<span><\/span><\/h2>/', $content, $time);
                preg_match_all('/<td width="30%"><span>(.*)<\/span><span>(.*)<\/span><span>(.*)<\/span><\/td>/', $content, $basicInfo);
                preg_match_all('/class="wd">([0-9]+)℃<\/td>/', $content, $currentTemp);
                preg_match_all('/<li><b>(.*)<\/b>.*<i><img src=".*" alt="(.*)"\/><img src=".*" alt="(.*)"\/><\/i><span>([0-9]+)℃\/([0-9]+)℃<\/span><\/li>/isU', '<li><b>明天' . $forcast[1], $tommorrow);
                //
                
                //print_r($tommorrow);
                //print_r($today);
                
                //echo $content;
            
    			
                $i = 0; 
                $data['weatherinfo']['currentTemp'] = null;
                $data['weatherinfo']['cityName'] = $cityName[1][0];
                $data['weatherinfo']['time'] = $time[1][0];
                $data['weatherinfo']['basicInfo'] = $basicInfo[1][0] . '|' . $basicInfo[2][0] . '|' . $basicInfo[3][0];
                $data['weatherinfo']['currentTemp'] = $currentTemp[1][0];
                //print_r($tommorrow);
                foreach ($tommorrow[1] as $key => $value) {
                    $data['weatherinfo']['weather_' . $i] = $tommorrow[2][$key] . '|' . $tommorrow[3][$key];
                    $data['weatherinfo']['temp_' . $i] = $tommorrow[4][$key] . '|' . $tommorrow[5][$key];
                    
                    $i++;
                }
                
                if($data['weatherinfo']['currentTemp'] == null)
                    continue;
                else
                    break;
            }

            foreach($data['weatherinfo'] as $key => $value)
            {
                $data['weatherinfo'][$key] = urlencode($value);
            }
            

            ob_start();
            
            $data = json_encode($data);
    			header("Content-type:text/html;charset=utf8");
            echo htmlentities(urldecode($data));
            //print_r(json_decode($data));

            ob_end_flush();

            $sql = "INSERT  INTO `shu_weather` ( `id`, `date`, `cityID`, `data`) VALUES ('NULL', '" . $date . "', '" . $id . "' , '" . addslashes($data) . "')";
    		$mysql->runSql($sql);
    }

    if ($mysql->errno() != 0)
    {
        die("Error:" . $mysql->errmsg());
    }

    $mysql->closeDb();    

    //$content = file_get_contents('citys.json');
    //print_r(json_decode($content));

	
function encode_json($str){  
    $code = json_encode($str);  
    return preg_replace("#\\\u([0-9a-f]+)#ie", "iconv('UTF-8', 'UTF-8', pack('H4', '\\1'))", $code);  
} 

function curl_get($url)
	{
		// 1. 初始化
		$ch = curl_init();
		// 2. 设置选项，包括URL
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		// 3. 执行并获取HTML文档内容
		$output = curl_exec($ch);
		// 4. 释放curl句柄
		curl_close($ch);
		return $output;
	}


    ?>