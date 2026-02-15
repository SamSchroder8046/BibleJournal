<?php
function getHeader(){
    $header = <<<HEADER
        <header id="header">
            <div id="header-container">
                <img id="nav-dropdown" src="../public/assets/images/arrow-down.svg">
            </div>
        </header>
HEADER;
    return $header;
}
?>