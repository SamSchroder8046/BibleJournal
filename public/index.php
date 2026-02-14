<?php
include "../includes/head.php";
include "../includes/body.php";

function getBibleData() {
    $response = file_get_contents("https://cdn.jsdelivr.net/gh/wldeh/bible-api/bibles/bibles.json");
    $data = json_decode($response, true);
//    echo print_r($data);
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

function updateVersions() {

}

function buildContent($organisedData) {
    $jsonData = json_encode($organisedData[0]);
    $versions = $organisedData[1];
    $languages = $organisedData[2];
    $languageRadios = "";
    foreach ($languages as $language) {
        $languageRadios .= <<<RADIO
    <div class="language-container" id="$language-container">
        <input class="language-radio-button" type="radio" id="$language" name="bible-language" value="$language" required>
        <label class="language-label" for="$language">$language</label><br>
    </div>
RADIO;
    }
    $versionRadios = "";
    foreach ($versions as $version) {
        $versionName = $version['version'];
        $versionRadios .= <<<RADIO
    <div class="version-container" id="$versionName-container">
        <input class="version-radio-button" type="radio" id="$versionName" name="bible-version" value="$versionName" required>
        <label class="version-label" for="$versionName">$versionName</label><br>
    </div>
RADIO;
    }
    $content = <<<CONTENT
    <div class="form-container">
        <h2>Configure your Bible</h2>
        <form class="form" action="index.php">
            <h3>Enter your name</h3>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name"><br>
            <h3>Choose your language</h3>
            <div id="language-radio-container">
                $languageRadios
            </div>
            <h3>Choose your version</h3>
            <div id="version-radio-container">
<!--                $versionRadios-->
            </div>
            <br>
            <div class="submit-button-container">
                <input class="submit-button" type="submit">
            </div>
        </form>
    </div>
CONTENT;

//    $content .= "<h1>Bible Journal</h1><h2 id='subHeader'>Languages:</h2><ul id='displayList'>";
//    foreach ($languages as $language) {
//        $content .= "<li data_content_type='language' attr_language='$language' class='language-item' >$language</li>";
//    }
//    $content.="</ul>";
    $configData = json_encode(file_get_contents('../data/config.json'));
    $content .= "<script>bibleData = $jsonData;</script>";
    $content .= "<script>config = $configData;</script>";
    return $content;
}

function displayContent($content) {
    echo getHead();
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