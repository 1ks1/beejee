<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

//db config
define ('HOST','localhost');
define ('DBNAME','test');
define ('CHARSET','utf8');
define ('USER','root');
define ('PASSWORD','');

//admin config
define ('ADMIN_EMAIL','admin');
define ('ADMIN_PASSWORD','123');