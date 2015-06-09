<?php
echo "<meta charset='utf8'>";

$content = file_get_contents('cityID');
//echo $content;
$data = unserialize($content);

$name = $_GET['city'];

foreach($data as $key => $value)
{
	if($key == $name)
    {
    	echo $value;
        return;
    }
}
echo "Cannot find this city";

//print_r(array_search($name,$data));


//var_dump($a);
//echo json_decode($content);
//$list = ob2ar(json_decode(file_get_contents('citys.json')));
//print_r($list);
/*    
$cityList = array();
$i = 0;
foreach($list['citylist'] as $values)
{
    //print_r($values["c"]["d"]);
    if(isset($values['c']['d']))
    {
        foreach($values['c']['d'] as $data)
            $cityList[$data['city']] = $data['cityid'];
    }
    else
    {
        foreach($values["c"] as $value)
        {
            if(isset($value["d"]['city']))
                $cityList[$value["d"]['city']] = $value["d"]['cityid'];
            else 
                foreach($value["d"] as $data)
                    $cityList[$data['city']] = $data['cityid'];
        }
    }
    $i++;
}
//unset($cityList[1]);
//print_r($cityList);
echo serialize($cityList);
        
        
    function ob2ar($obj) {
    if(is_object($obj)) {
        $obj = (array)$obj;
        $obj = ob2ar($obj);
    } elseif(is_array($obj)) {
        foreach($obj as $key => $value) {
            $obj[$key] = ob2ar($value);
        }
    }
    return $obj;
}
*/
?>