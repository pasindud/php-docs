<?php

$build_langauge = "en"; // or *
$build_extensions = "ext-string"; // or *

require_once 'md/Michelf/Markdown.inc.php';

//^(int)\sfunction\s([a-z]*)\((\s|\S)*((string|int|mixed)(\s|\S)*$([a-z]*))?
//((string|int|mixed)(\s)*(\$)([a-z])*(,))
//
$my_text =file_get_contents("../languages/en/ext-string/stringpos.md") ;


use \Michelf\Markdown;

$my_html = Markdown::defaultTransform($my_text);


file_put_contents("../output/en/ext-string/stringpos.html", $my_html);

// echo "$my_html";