<?php
function getBody($content){
    $header = <<<BODY
        <body>
            $content
        </body>
        </html>
BODY;
    return $header;
}
?>