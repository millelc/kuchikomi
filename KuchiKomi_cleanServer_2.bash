#!/bin/sh

cd /var/www
sudo chmod 777 kuchikomi/app/cache/
sudo chmod 777 kuchikomi/app/logs/

sudo rm -r kuchikomi/web/images
sudo cp -r temp_image/images/ kuchikomi/web/
sudo rm -r temp_image