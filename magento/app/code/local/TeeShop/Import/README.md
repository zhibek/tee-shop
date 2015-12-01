### Importing products :
    
    php magento/app/code/local/TeeShop/Import/shell/ProductsImport.php --url <URL>

    Notes :
    1. The import process can works both ways (Install / update )
    2. If there's no url given to the command it will use the default URL

#### Setup Import Cron Job :

    1. crontab -e     and insert the following 

        0 0 * * * /bin/sh/ /vagarant/magento/cron.sh
        0 0 * * * /usr/bin/php -f /vagrant/magento/cron.php
    Notes :
    1. Cron job is designed to run each day at midnight. 
    2. Cron.sh checks if there're jobs running before creating new ones to
       prevent execution the same job for multiple times and jobs overlapping.
    3. Magento's cron jobs are rescheduled each 15 min as default configuration. 