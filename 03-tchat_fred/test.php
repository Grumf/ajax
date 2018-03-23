<?php

echo "<pre>";
var_dump($_SERVER);

echo '</pre>';

echo gethostbyname($_SERVER['SERVER_NAME']);

echo gethostbyaddr('127.0.0.1');