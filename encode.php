<?php
function e(string $str ,$charset = 'UTF-8') :string {
    return htmlspecialchars($str,ENT_QUOTES | ENT_HTML5,$charset);
}