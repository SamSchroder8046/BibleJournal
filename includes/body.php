<?php
function getBody($content){
    $body = <<<BODY
        <body>
            $content
        </body>
        <script src="../includes/scripts.js"></script>
        </html>
BODY;
    return $body;
}
?>