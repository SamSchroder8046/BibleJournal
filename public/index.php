<?php
include "../includes/header.php";
include "../includes/body.php";

$response = file_get_contents("https://cdn.jsdelivr.net/gh/wldeh/bible-api/bibles/bibles.json");
$data = json_decode($response, true);

$versions = [];
foreach ($data as $version) {
    array_push($versions, $version);
}
asort($versions);

$languages = [];
foreach ($data as $version) {
    $language = $version['language']['name'];
    if (!in_array($language, $languages)) {
        array_push($languages, $language);
    }
}
asort($languages);

//echo print_r($data[0]);
//echo print_r($data[1]);

$content = "<h1>Bible Journal</h1><h2 id='subHeader'>Languages:</h2><ul id='displayList'>";

foreach ($languages as $language) {
    $content .= "<li data_content_type='language' attr_language='$language' class='language-item' >$language</li>";
}
$content.="</ul>";

$jsonData = json_encode($data);
$content .= "<script>bibleData = $jsonData;</script>";

echo getHeader();
echo getBody($content);
?>