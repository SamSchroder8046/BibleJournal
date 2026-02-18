<?php

function getHeader($chaptersData){
    $tableContent = "";
    $counter = 0;
    foreach ($chaptersData as $chapterData) {
        $chapter = $chapterData["data"][0]["chapter"];
        if ($counter === 0) {
            $tableContent .= "<tr>";
            $tableContent .= <<<BUTTON
<td>
    <form class="nav-button-form" method="post">
        <input class="nav-button" type="submit" name="chapter$chapter-button" value="$chapter">
    </form>
</td>
BUTTON;
            $counter++;
        } else if ($counter % 11 === 0 || count($chaptersData) === array_search($chapterData, $chaptersData)) {
            $tableContent .= "</tr>";
            $counter = 0;
        } else {
            $tableContent .= <<<BUTTON
<td>
    <form class="nav-button-form" method="post">
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