Wordpress Staging
-----------------
```
sudo su
apt-get -y update
add-apt-repository ppa:ondrej/php
apt-get -y update
apt-get -y install php5.6 php5.6-mcrypt php5.6-mbstring php5.6-curl php5.6-cli php5.6-mysql php5.6-gd php5.6-intl php5.6-xsl mailutils php5.6-json
a2enmod rewrite headers
php5enmod mcrypt

nano /etc/apache2/sites-enabled/000-default.conf

<VirtualHost *:80>
        #ServerName example.com
        #ServerAlias www.example.com
        DocumentRoot /var/www/staging

        <Directory /var/www/staging>
                Options -Indexes
                AllowOverride All
                Order allow,deny
                Allow from all
        </Directory>
</VirtualHost>

cd /var/www/html
rm -rf *
cd ../
mkdir staging
cd staging
git clone https://github.com/smartaiman/wordpress.git .
chmod -R 744 .
chown -R www-data:www-data .

service apache2 restart
```
After Wordpress Is Configured
-----------------------------
```
define('WP_REDIS_HOST', '');
```
