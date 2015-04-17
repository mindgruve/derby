# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
    config.vm.box = "matyunin/centos7"
    config.vm.synced_folder "./", "/vagrant/", id: "vagrant-root", nfs: true

    config.vm.provider "virtualbox" do |v|
        v.name = "media-centos-7.0"
        v.memory = 4096
    end
    
    config.vm.provision "ansible" do |ansible|
        ansible.playbook = "provision/development/1.0.0/playbook_media_common.yml"
        ansible.sudo = true
    end

    config.vm.provision "ansible" do |ansible|
       ansible.playbook = "provision/development/1.0.0/playbook_media_dev.yml"
       ansible.sudo = true
    end
    
    config.vm.hostname = 'media.mindgruve.dev'
    config.vm.network :private_network, ip: '192.168.43.67'

end
