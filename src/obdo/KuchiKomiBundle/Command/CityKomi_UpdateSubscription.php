<?php
exec("cd /homez.544/citykomi/obdo/");
exec("/usr/local/bin/php.ORIG.5_3 -d magic_quotes_gpc=0 -d register_globals=0 /homez.544/citykomi/obdo/app/console subscription:update");
?>