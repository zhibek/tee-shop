VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  config.vm.box = "ubuntu/trusty64"
  config.vm.synced_folder "./", "/var/www", id: "web-root" , owner: "www-data", group: "www-data", mount_options: ["dmode=775,fmode=664"]
  config.vm.network "forwarded_port", guest: 22, host: 2280, id: "ssh", auto: true
  config.vm.network "private_network", ip: "10.1.1.80"

  config.vm.provider "virtualbox" do |vb|
    vb.customize ["modifyvm", :id, "--name", "tee-shop"]
    vb.customize ["modifyvm", :id, "--memory", "1024"]
    vb.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
    vb.customize ["modifyvm", :id, "--natdnsproxy1", "on"]
    #vb.gui = true
  end

  config.berkshelf.enabled = true
  config.berkshelf.berksfile_path = "chef/Berksfile"

  config.vm.provision :chef_solo do |chef|
    chef.log_level = "debug"
    chef.verbose_logging = true
    chef.run_list = [
      "recipe[site::default]"
    ]
  end
 config.vm.provision :shell, inline: "DISPLAY=:1 xvfb-run java -jar /var/www/selenium/selenium-server.jar &", run: "always", privileged: false

end