cd /nearforge/web/kuchikomi/
php app/console cache:clear
php app/console cache:clear --env=prod
cd app
cd cache
rm -r dev
rm -r prod
rm -r test
cd ..
cd logs
rm *
scp /nearforge/web/kuchikomi/composer.json root@obdopublic:/var/www/kuchikomi/
scp /nearforge/web/kuchikomi/composer.lock root@obdopublic:/var/www/kuchikomi/
scp /nearforge/web/kuchikomi/composer.phar root@obdopublic:/var/www/kuchikomi/

scp -r /nearforge/web/kuchikomi/app root@obdopublic:/var/www/kuchikomi/
scp -r /nearforge/web/kuchikomi/bin root@obdopublic:/var/www/kuchikomi/
scp -r /nearforge/web/kuchikomi/src root@obdopublic:/var/www/kuchikomi/
scp -r /nearforge/web/kuchikomi/web root@obdopublic:/var/www/kuchikomi/

scp -r /nearforge/web/kuchikomi/doc/obdopublic/DataFixtures/* root@obdopublic:/var/www/kuchikomi/src/obdo/KuchiKomiRESTBundle/DataFixtures/ORM/
scp -r /nearforge/web/kuchikomi/doc/obdopublic/config/parameters.yml root@obdopublic:/var/www/kuchikomi/app/config/
scp -r /nearforge/web/kuchikomi/doc/obdopublic/config/parameters.yml.dist root@obdopublic:/var/www/kuchikomi/app/config/