<?php
include "../includes/header.php";
include "../includes/body.php";

$response = file_get_contents("https://cdn.jsdelivr.net/gh/wldeh/bible-api/bibles/bibles.json");
$data = json_decode($response, true);
/*
echo print_r($data[0]);
echo print_r($data[1]);
*/

$content = "<h1>Bible Journal</h1><h2>Languages:</h2><ul>";
$languages = [];

foreach ($data as $version) {
    $language = $version['language']['name'];
    if (!in_array($language, $languages)) {
        array_push($languages, $language);
    }
}

//echo print_r($countries);
foreach ($languages as $language) {
    $content .= "<li>$language</li>";
}
$content.="</ul>";

echo getHeader();
echo getBody($content);
?>