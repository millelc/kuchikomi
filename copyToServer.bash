cd /Applications/MAMP/htdocs/kuchikomi/
php app/console cache:clear
php app/console cache:clear --env=prod
cd app
cd cache
rm -r dev
rm -r prod
cd ..
cd logs
rm *
scp -r /Applications/MAMP/htdocs/kuchikomi nearforge@192.168.1.253:/var/www/