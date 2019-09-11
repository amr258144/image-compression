<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__.'/../../config/config.php';
require_once 'Builder.php';
use app\Controllers\Builder;
require_once 'BuilderFactory.php';
use app\Controllers\BuilderFactory;

if(is_array($_REQUEST)) {
	array_filter($_REQUEST, function($val, $k) {
		if($val == '') unset($_REQUEST[$k]);
	}, ARRAY_FILTER_USE_BOTH);
}

$server = SERVER;
$secret = SECRET_KEY;
$original_image = $_REQUEST['original_image'];
$buildURL = BuilderFactory::construct($server, $secret)->url($original_image);;
$width = $height = 700;
/*print_r(parse_url($original_image));
echo "<br>";*/
$imagePath = substr($original_image, 0, strrpos($original_image, '/') + 1);
$imageName = rawurlencode(substr($original_image, (strrpos($original_image, '/') + 1)));
$original_image = $imagePath.$imageName;
// exit;
if($_REQUEST['feature'] == 'resize') {
	$width = isset($_REQUEST['width']) ? $_REQUEST['width'] : 700;
	$height = isset($_REQUEST['height']) ? $_REQUEST['height'] : 700;
	$buildURL = BuilderFactory::construct($server, $secret)->url($original_image)->resize($width, $height);
} elseif($_REQUEST['feature'] == 'fitin') {
	$width = isset($_REQUEST['width']) ? $_REQUEST['width'] : 700;
	$height = isset($_REQUEST['height']) ? $_REQUEST['height'] : 700;
	$buildURL = BuilderFactory::construct($server, $secret)->url($original_image)->fitIn($width, $height);
} elseif($_REQUEST['feature'] == 'smart_crop') {
	$width = isset($_REQUEST['width']) ? $_REQUEST['width'] : 700;
	$height = isset($_REQUEST['height']) ? $_REQUEST['height'] : 700;
	$buildURL = BuilderFactory::construct($server, $secret)->url($original_image)->smartCrop(true)->resize($width, $height);
} elseif($_REQUEST['feature'] == 'crop') {
	$top_left_X = $_REQUEST['top_left_X'];
	$top_left_Y = $_REQUEST['top_left_Y'];
	$bottom_right_X = $_REQUEST['bottom_right_X'];
	$bottom_right_Y = $_REQUEST['bottom_right_Y'];
	$buildURL = BuilderFactory::construct($server, $secret)->url($original_image)->smartCrop(true)->crop($top_left_X, $top_left_Y, $bottom_right_X, $bottom_right_Y);
}

if(isset($_REQUEST['filters']) && !empty($_REQUEST['filters'])) {
	foreach($_REQUEST['filters'] as $k => $filter) {
		if(array_key_exists($filter, $_REQUEST)) {
			$buildURL->addFilter($filter, $_REQUEST[$filter]);
		}
	}
}

echo $twig->render('output.html', ['original_image' => $original_image, 'new_image' => $buildURL, 'width' => $width, 'height' => $height, 'base_url' => BASE_URL, 'secret_key' => $secret]);

?>