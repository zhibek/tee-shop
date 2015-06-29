tee-shop
========

A Magento installation with functionality for tee-shop.

Installation
------------

### Clone repo and provision with vagrant:

    git clone --recursive git@github.com:zhibek/tee-shop.git
    cd tee-shop
    vagrant up


### Add the IP to your hosts file:

    10.1.1.80     tee-shop.local


### Access the box:

**This box requires the vagrant-berkshelf plugin.**
If you haven't already got this plugin, please follow the install instructions here:
https://github.com/berkshelf/vagrant-berkshelf

To access the vagrant environment from the terminal, change to the vagrant directory and type 

    vagrant ssh


### View the site:

Visit [http://tee-shop.local/](http://tee-shop.local/) to view the site.