Wordpress Staging
-----------------
```
sudo su
apt-get update
apt-get upgrade -y
apt-get dist-upgrade -y
apt-get autoremove -y
apt-get install apache2 php5 php5-cli php5-fpm php5-gd libssh2-php libapache2-mod-php5 php5-mcrypt mysql-server php5-mysql git unzip zip postfix php5-curl mailutils php5-json phpmyadmin -y
a2enmod rewrite headers
php5enmod mcrypt

nano /etc/apache2/sites-enabled/000-default.conf

Include /etc/phpmyadmin/apache.conf
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

nano /etc/phpmyadmin/config.inc.php
--ADD LINES BELOW THE PMA CONFIG AREA AND FILL IN DETAILS--
$i++;
$cfg['Servers'][$i]['host']          = '__FILL_IN_DETAILS__';
$cfg['Servers'][$i]['port']          = '3306';
$cfg['Servers'][$i]['socket']        = '';
$cfg['Servers'][$i]['connect_type']  = 'tcp';
$cfg['Servers'][$i]['extension']     = 'mysql';
$cfg['Servers'][$i]['compress']      = FALSE;
$cfg['Servers'][$i]['auth_type']     = 'config';
$cfg['Servers'][$i]['user']          = '__FILL_IN_DETAILS__';
$cfg['Servers'][$i]['password']      = '__FILL_IN_DETAILS__';

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
