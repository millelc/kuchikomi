#!/bin/sh

cd /var/www
sudo mkdir temp_image
sudo chmod 777 temp_image
sudo cp -r kuchikomi/web/images/ temp_image/

sudo rm -r kuchikomi
sudo mkdir kuchikomi
sudo chmod 777 kuchikomi