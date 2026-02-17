<?php
include "./includes/head.php";
include "./includes/body.php";
include "./includes/header.php";
include "./includes/bibleDataHelper.php";

$bibleJSON = new BibleJSONData();
function buildFormContent($organisedData) {
    $jsonData = json_encode($organisedData[0]);
    $versions = $organisedData[1];
    $languages = $organisedData[2];
    $languageOptions = "";
    $defaultLanguage = "English";
    $languageOptions .= <<<OPTION
    <option value="English" selected>English</option>
OPTION;
//    foreach ($languages as $language) {
//        if ($language === $defaultLanguage) {$defaultSelected = " selected";} else {$defaultSelected = "";}
//        $languageOptions .= <<<OPTION
//    <option value

//    }
//    $versionRadios = "";
//    foreach ($versions as $version) {
//        $versionName = $version['version'];
//        $versionRadios .= <<<RADIO
//    <div class="version-container" id="$versionName-container">
//        <input class="version-radio-button" type="radio" id="$versionName" name="bible-version" value="$versionName" required>
//        <label class="version-label" for="$versionName">$versionName</label><br>
//    </div>
//RADIO;
//    }
    $content = <<<CONTENT
    <div class="form-container">
        <h2>Configure your Bible</h2>
        <form class="form" action="index.php" method="post">
            <h3>Enter your name</h3>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" default="user"><br>
            <h3>Choose your language</h3>
            <div id="language-select-container">
                <label for="language">Language:</label>
                <select id="language" name="language">
                    $languageOptions
                </select>
            </div>
            <h3>Choose your version</h3>
            <div id="version-radio-container">
            </div>
            <br>
            <div class="submit-button-container">
                <input class="submit-button" type="submit">
            </div>
        </form>
    </div>
CONTENT;

    $configData = json_encode(file_get_contents('./data/config.json'));
    $content .= "<script>bibleData = $jsonData;</script>";
    $content .= "<script>config = $configData;</script>";
    return $content;
}

function buildAppContent($version, $bibleJSONObject, $book="genesis", $chapter="2") {
    $data = getBibleChapterData($version, $book, $chapter);
    storeBibleChapterData($data, $bibleJSONObject);
//    echo print_r($data);
    $content = "<div id='bible-container'>";
    foreach ($data["data"] as $verseData) {
        $verse = $verseData["verse"];
        $verseContent = $verseData["text"];
        if ($verse % 2 == 0) {
            $background = 'style="background-color: azure"';
        } else {
            $background = 'style="background-color: white"';
        }
        $content .= "<div class='verse-container' $background><p class='verse-number' id='v$verse'>v$verse.</p><a class='verse' id='$book-$chapter-$verse'>$verseContent</a></div>";
    }
    $content .= "</div>";
    return $content;
}

function displayContent($content) {
    echo getHead();
    echo getBody($content);
}

function main ($bibleJSONObject) {
    $data = getBibleConfigData();
    $organisedData = organiseConfigData($data);
    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        $content = buildFormContent($organisedData);
    } else {
        $content = getHeader();
        $content .= buildAppContent($_POST["bible-version"], $bibleJSONObject);
    }
    displayContent($content);
}

main($bibleJSON);
?>