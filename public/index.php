<?php
include "../includes/header.php";
include "../includes/body.php";

function getBibleData() {
    $response = file_get_contents("https://cdn.jsdelivr.net/gh/wldeh/bible-api/bibles/bibles.json");
    $data = json_decode($response, true);
    return $data;
}

function organiseData($data) {
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
    $dataObject = [$data, $versions, $languages];
    return $dataObject;
}

function buildContent($organisedData) {
    $jsonData = json_encode($organisedData[0]);
    $languages = $organisedData[2];
    $content = "<h1>Bible Journal</h1><h2 id='subHeader'>Languages:</h2><ul id='displayList'>";
    foreach ($languages as $language) {
        $content .= "<li data_content_type='language' attr_language='$language' class='language-item' >$language</li>";
    }
    $content.="</ul>";
    $configData = json_encode(file_get_contents('../data/config.json'));
    $content .= "<script>bibleData = $jsonData;</script>";
    $content .= "<script>config = $configData;</script>";
    return $content;
}

function displayContent($content) {
    echo getHeader();
    echo getBody($content);
}

function main () {
    $data = getBibleData();
    $organisedData = organiseData($data);
    $content = buildContent($organisedData);
    displayContent($content);
}

main();
?>