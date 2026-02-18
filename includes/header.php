<?php

function getHeader($chaptersData){
    $tableContent = "";
    $counter = 0;
    foreach ($chaptersData as $chapterData) {
        if ($counter === 0) {
            $tableContent .= "<tr>";
        } else if ($counter % 6 === 0 || count($chaptersData) === array_search($chapterData, $chaptersData)) {
            $tableContent .= "</tr>";
            $counter = 0;
        } else {
            $chapter = $chapterData["data"][0]["chapter"];
            $tableContent .= <<<BUTTON
<td>
    <form method="post">
        <input class="nav-button" type="submit" name="chapter$chapter-button" value="$chapter">
    </form>
</td>
BUTTON;
        }
        $counter ++;
     }
    $header = <<<HEADER
        <header id="header">
            <div id="header-container">
                <img id="nav-dropdown" src="./public/assets/images/arrow-down.svg">
                <table id="nav-table">
                    $tableContent
                </table>
            </div>
        </header>
HEADER;
    return $header;
}
?>