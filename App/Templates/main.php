<?php
use App\View\View;
echo View::renderHtml('layout.header', $header, $request);
//echo View::route('page404', ['slug' => 'ff']);
?>
<!--<h1>Все ок</h1>-->

<?php

//dump($user);
echo View::renderHtml('layout.footer', $footer);
?>