<?php
function getBody($content){
    $header = <<<BODY
        <body>
            $content
        </body>
        <script src="../includes/scripts.js"></script>
        </html>
BODY;
    return $header;
}
?>