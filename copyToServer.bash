cd /nearforge/web/kuchikomi/
php app/console cache:clear
php app/console cache:clear --env=prod
cd app
cd cache
rm -r dev
rm -r prod
cd ..
cd logs
rm *
scp -r /nearforge/web/kuchikomi nearforge@192.168.1.253:/var/www/