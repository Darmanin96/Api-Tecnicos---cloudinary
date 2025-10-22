<?php
function renderJSON($data) {
    if (ob_get_length()) {
        ob_clean();
    }
    
    header("Content-Type: application/json; charset=utf-8");
    
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    
    exit;
}
?>