<?php
class BibleJSONData
{
    public $books = [];
    private $booksOfTheBible = [

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

    // stores chapter api data as json in books attribute
    public function storeChapterData($dataInput) {
        $data = $dataInput["data"];
        $book = $data[0]["book"];
        $chapter = $data[0]["chapter"];
        if (!isset($this->books[$book])) {
            $this->books[$book] = $data;
        } elseif (!isset($this->books[$book][$chapter])) {
            $this->books[$book][$chapter] = $data;
        }
    }

    public function getCurrentJSON() {
        return json_encode($this->books);
    }

    public function echoJSON() {
        echo $this->getCurrentJSON();
    }
}

function getBibleConfigData() {
    $response = file_get_contents("https://cdn.jsdelivr.net/gh/wldeh/bible-api/bibles/bibles.json");
    if ($response === false) { echo "<h1>Could not get Bible data</h1>"; return null; }
    $data = json_decode($response, true);
    foreach($data as $version) {// delete me
        if ($version['language']['name'] === "English") {
            echo print_r($version);
            echo "<br>";
        }
    }
    return $data;
}

function getBibleChapterData($id, $book, $chapter) {
    $response = file_get_contents("https://cdn.jsdelivr.net/gh/wldeh/bible-api/bibles/{$id}/books/{$book}/chapters/{$chapter}.json");
    $data = json_decode($response, true);
    return $data;
}

function storeBibleChapterData($data, $bibleJSONObj) {
    $bibleJSONObj->storeChapterData($data);
//    $bibleJSONObj->echoJSON();
    file_put_contents("./data/bible.json", $bibleJSONObj->getCurrentJSON());
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