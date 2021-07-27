<?php 

$latestVersion = json_decode(file_get_contents('https://ddragon.leagueoflegends.com/api/versions.json'))[0];
$championData = json_decode(file_get_contents('http://ddragon.leagueoflegends.com/cdn/'.$latestVersion.'/data/vn_VN/champion.json'))->data;
$champions = array();
foreach ($championData AS $championName => $value) {
	$champions[] = $championName;
}

$skinsExport = array();
$skinsName = array();
foreach ($champions AS $champ) {
	$champData = json_decode(file_get_contents('http://ddragon.leagueoflegends.com/cdn/'.$latestVersion.'/data/vn_VN/champion/'.$champ.'.json'));
	$skins = $champData->data->{$champ}->skins;
	
	foreach ($skins AS $skin) {
		if ($skin->name == 'default') {
			$name = vn_to_str($champ);
			$skinsExport[$name] = 'http://ddragon.leagueoflegends.com/cdn/img/champion/tiles/'.$champ.'_0.jpg';
			$skinsName[] = $champ;
		} else {
			$name = vn_to_str($skin->name);
			$skinsExport[$name] = 'http://ddragon.leagueoflegends.com/cdn/img/champion/loading/'.$champ.'_'.$skin->num.'.jpg';
			$skinsName[] = $skin->name;
		}
	}
	echo "Xong ".$champ."\n";
}


file_put_contents('lol_image_data.json', json_encode($skinsExport));
file_put_contents('skinsName.json', json_encode($skinsName));
exit();

function xoa_dau($name_to_get_image) {
    $name_to_get_image = str_replace(['wukong', 'monkeyking'], ['ngokhong', 'ngokhong'], strtolower($name_to_get_image));
    if (preg_match("/nunu/", strtolower($name_to_get_image)) && !preg_match("/willump/", strtolower($name_to_get_image))) {
        $name_to_get_image = str_replace('nunu', 'nunu&willump', strtolower($name_to_get_image));
    }
    return vn_to_str($name_to_get_image);
}

function vn_to_str($str)
{

    $unicode = array(

        'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',

        'd' => 'đ',

        'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',

        'i' => 'í|ì|ỉ|ĩ|ị',

        'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',

        'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',

        'y' => 'ý|ỳ|ỷ|ỹ|ỵ',

        'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',

        'D' => 'Đ',

        'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',

        'I' => 'Í|Ì|Ỉ|Ĩ|Ị',

        'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',

        'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',

        'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',

    );

    foreach ($unicode as $nonUnicode => $uni) {

        $str = preg_replace("/($uni)/i", $nonUnicode, $str);

    }
    $str = str_replace(' ', '', $str);
    $str = str_replace('-', '', $str);
    $str = str_replace(".", '', $str);
    $str = str_replace('\'', '', $str);

    return strtolower($str);
}