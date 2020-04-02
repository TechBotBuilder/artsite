<!--
//index.php
//homepage

Layout:
(Header,
menu)

hero image

message

(email newsletter signup link
footer)
-->

<?php

require_once "../templates/common.php";

template\header("Tonya Ramsey Fine Art");

//do a big image instead of a page title.
$main_image = '';//get newest/static image. perhaps settings between two options in Config DB.
require_once "../templates/big_image.php";
template\big_image($main_image);


template\start_content('');//in-page title is empty so we don't display a title in this home page (we displayed a big image instead).

require_once("../templates/message.php");
$message = 'Thank you for visiting my site and welcome!';//TODO get message from Config DB
template\message($message);

template\end_content();

template\footer();

?>