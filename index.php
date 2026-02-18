<?php
session_start();

$_SESSION["bible_version"] = isset($_POST['bible-version']) ? (string) $_POST['bible-version'] : "en-US-kjvcpb" ;

include "./includes/head.php";
include "./includes/body.php";
include "./includes/header.php";
include "./includes/bibleDataHelper.php";

$defaultVersionId = "en-US-kjvcpb";
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

function buildAppContent($versionId, $book="genesis", $chapter="1") {
    if (getCachedChapter($versionId, $book, $chapter)) {
        $data = getCachedChapter($versionId, $book, $chapter);
    } else {
        $data = getBibleChapterData($versionId, $book, $chapter);
//        echo print_r($data);
//        var_dump(json_encode($data));
        if ($data) {
            putCachedChapter($versionId, $book, $chapter, json_encode($data));
        } else { return false; }
    }
//    echo print_r($data);
    $content = "<div id='bible-container'>";
    foreach ($data["data"] as $verseData) {
        $verse = $verseData["verse"];
        $verseContent = $verseData["text"];
        $verseStr = trim((string) $verse);
        if (ctype_digit($verseStr)) {
            $verseNum = (int) $verseStr;
            $isEven = ($verseNum % 2 == 0);
        } else {
            $isEven = false;
        }
        if ($isEven) {
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

function getChapter($id, $chapter, $chaptersData) {
    $book = trim(strtolower($chaptersData[0]["data"][0]["book"]));
    $content = getHeader($chaptersData);
    $content .= buildAppContent($id, $book, $chapter);
    return $content;
}

function main () {
    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        $data = getBibleConfigData();
        $organisedData = organiseConfigData($data);
        $content = buildFormContent($organisedData);
    } else {
        $content = "";
        $versionId = $_SESSION["bible_version"];
        $allBibleChaptersData = getAllBibleChaptersData($versionId);
        $navButtonPressed = false;
        foreach ($allBibleChaptersData as $chapterData) {
            $chapter = $chapterData["data"][0]["chapter"];
            if (isset($_POST["chapter$chapter-button"])) {
                $content .= getChapter($versionId, $chapter, $allBibleChaptersData);
                $navButtonPressed = true;
            };
        }
        if ($navButtonPressed === false) {
            $content .= getHeader($allBibleChaptersData);
            $content .= buildAppContent($versionId);
        }
    }
    displayContent($content);
}

main();
?>