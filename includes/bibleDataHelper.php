<?php
//class BibleJSONData
//{
//    public $books = [];
//
//    // stores chapter api data as json in books attribute
//    public function storeChapterData($dataInput) {
//        $data = $dataInput["data"];
//        $book = $data[0]["book"];
//        $chapter = $data[0]["chapter"];
//        if (!isset($this->books[$book])) {
//            $this->books[$book] = $data;
//        } elseif (!isset($this->books[$book][$chapter])) {
//            $this->books[$book][$chapter] = $data;
//        }
//    }
//
//    public function getJSON() {
//        return json_encode($this->books);
//    }
//
//    public function echoJSON() {
//        echo $this->getJSON();
//    }
//}

$booksOfTheBible = [

    // Old Testament
    "genesis",
    "exodus",
    "leviticus",
    "numbers",
    "deuteronomy",
    "joshua",
    "judges",
    "ruth",
    "1samuel",
    "2samuel",
    "1kings",
    "2kings",
    "1chronicles",
    "2chronicles",
    "ezra",
    "nehemiah",
    "esther",
    "job",
    "psalms",
    "proverbs",
    "ecclesiastes",
    "songofsolomon",
    "isaiah",
    "jeremiah",
    "lamentations",
    "ezekiel",
    "daniel",
    "hosea",
    "joel",
    "amos",
    "obadiah",
    "jonah",
    "micah",
    "nahum",
    "habakkuk",
    "zephaniah",
    "haggai",
    "zechariah",
    "malachi",

    // New Testament
    "matthew",
    "mark",
    "luke",
    "john",
    "acts",
    "romans",
    "1corinthians",
    "2corinthians",
    "galatians",
    "ephesians",
    "philippians",
    "colossians",
    "1thessalonians",
    "2thessalonians",
    "1timothy",
    "2timothy",
    "titus",
    "philemon",
    "hebrews",
    "james",
    "1peter",
    "2peter",
    "1john",
    "2john",
    "3john",
    "jude",
    "revelation"

];

// creates a unique key for each chapter
function cacheKey($version, $book, $chapter) {
    return sha1($version . "|" . $book . "|" . $chapter);
}

// creates path for the cached bible chapter file to be saved
function createCachePath($key) {
    return __DIR__ . "/../data/cache/" . $key . ".json";
}

// returns decoded json data from the specified cache file
function getCachedChapter($version, $book, $chapter) {
    $key = cacheKey($version, $book, $chapter);
    $path = createCachePath($key);
    if (!is_file($path)) {
        return false;
    }

    $raw = file_get_contents($path);
    $decoded = json_decode($raw, true);

    if ($decoded === null && json_last_error() !== JSON_ERROR_NONE) { return false; } else { return $decoded; }
}

// writes the json data to the cache file
function putCachedChapter($version, $book, $chapter, $json) {
    if (!is_string($json) || trim($json) === "" || trim($json) === "null") { return false; }
    $key = cacheKey($version, $book, $chapter);
    $path = createCachePath($key);
    $file = fopen($path, "c");
    if ($file === false) { return false; }

    // lock the file and if successful clear the file and write the json data
    if (flock($file, LOCK_EX)) {
        ftruncate($file, 0);
        fwrite($file, $json);
        fflush($file);
        flock($file, LOCK_UN);
    }
    fclose($file);
    return true;

}

function getBibleConfigData() {
    $response = file_get_contents("https://cdn.jsdelivr.net/gh/wldeh/bible-api/bibles/bibles.json");
    if ($response === false) { echo "<h1>Could not get Bible data</h1>"; return null; }
    $data = json_decode($response, true);
    foreach($data as $version) {// delete me
        if ($version['language']['name'] === "English") {
            echo print_r($version); // delete me
            echo "<br>"; // delete me
        }
    }
    return $data;
}

function getBibleChapterData($id, $book, $chapter) {
    $response = file_get_contents("https://cdn.jsdelivr.net/gh/wldeh/bible-api/bibles/{$id}/books/{$book}/chapters/{$chapter}.json");
    if (!$response) { return false; }
    $data = json_decode($response, true);
    return $data;
}

function getAllBibleChaptersData($id, $book="genesis") {
    $chapter = 1;
    $chapterData = [];
    $hasChapter = true;
    while ($hasChapter) {
        $data = getCachedChapter($id, $book, $chapter);
        if ($data === false) { $data = getBibleChapterData($id, $book, $chapter); }
        if ($data === false) {
            $hasChapter = false;
        } else {
            putCachedChapter($id, $book, $chapter, json_encode($data));
            $chapterData[] = $data;
            $chapter++;
        }
    }
    return $chapterData;
}

//function getBibleChapterJSON($id, $book, $chapter) {
//    $response = file_get_contents("https://cdn.jsdelivr.net/gh/wldeh/bible-api/bibles/{$id}/books/{$book}/chapters/{$chapter}.json");
//    return $response;
//}

function storeBibleChapterData($data) {
    putCachedChapter($data["version"], $data["book"], $data["chapter"], json_encode($data));
}

function organiseConfigData($data)
{
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
?>