<?php
function getBody($content){
    $body = <<<BODY
        <body>
            $content
        </body>
        <script src="./public/assets/scripts/scripts.js"></script>
        </html>
BODY;
    return $body;
}
?>