# encoding: utf-8
# vim: ft=ruby expandtab shiftwidth=2 tabstop=2

require 'yaml'

Vagrant.require_version '>= 1.8.6'

Vagrant.configure(2) do |config|

  vccw_version = '3.21.1';

  _conf = YAML.load(
    File.open(
      File.join(File.dirname(__FILE__), 'provision/default.yml'),
      File::RDONLY
    ).read
  )

  if File.exists?(File.join(ENV["HOME"], '.vccw/config.yml'))
    _custom = YAML.load(
      File.open(
        File.join(ENV["HOME"], '.vccw/config.yml'),
        File::RDONLY
      ).read
    )
    _conf.merge!(_custom) if _custom.is_a?(Hash)
  end

  if File.exists?(File.join(File.dirname(__FILE__), 'site.yml'))
    _site = YAML.load(
      File.open(
        File.join(File.dirname(__FILE__), 'site.yml'),
        File::RDONLY
      ).read
    )
    _conf.merge!(_site) if _site.is_a?(Hash)
  end

  # forcing config variables
  _conf["vagrant_dir"] = "/vagrant"

  config.vm.define _conf['hostname'] do |v|
  end

  config.vm.box = ENV['wp_box'] || _conf['wp_box']
  config.ssh.forward_agent = true

  config.vm.box_check_update = _conf['check_update'] || true

  config.vm.hostname = _conf['hostname']
  config.vm.network :private_network, ip: _conf['ip']

  if Vagrant.has_plugin?('vagrant-vbguest')
    config.vbguest.auto_update = true
    config.vbguest.installer_options = { enablerepo: ['C*-base', 'C*-updates'] }
  end

  config.vm.synced_folder _conf['synced_folder'],
      _conf['document_root'], :create => "true", :mount_options => ['dmode=755', 'fmode=644'],
      SharedFoldersEnableSymlinksCreate: false, :type => "virtualbox"

  if Vagrant.has_plugin?('vagrant-hostmanager')
    config.hostmanager.enabled = true
    config.hostmanager.manage_host = true
    config.hostmanager.manage_guest = true
    config.hostmanager.ignore_private_ip = false
    config.hostmanager.include_offline = true
  elsif Vagrant.has_plugin?('vagrant-hostsupdater')
    config.hostsupdater.aliases = _conf['hostname_aliases']
    config.hostsupdater.remove_on_suspend = true
  end

  if File.exists?(File.join(File.dirname(__FILE__), 'provision-pre.sh')) then
    config.vm.provision :shell, :path => File.join( File.dirname(__FILE__), 'provision-pre.sh' )
  end

  config.vm.provision "shell" do |sh|
    timezone = ENV['TZ'] ? ENV['TZ'] : "UTC"
    sh.inline = "timedatectl set-timezone $1"
    sh.args = timezone
  end

  config.vm.provider :virtualbox do |vb|
    vb.linked_clone = _conf['linked_clone']
    vb.name = _conf['hostname']
    vb.memory = _conf['memory'].to_i
    vb.cpus = _conf['cpus'].to_i
    if 1 < _conf['cpus'].to_i
      vb.customize ['modifyvm', :id, '--ioapic', 'on']
    end
    vb.customize ['modifyvm', :id, '--natdnsproxy1', 'on']
    vb.customize ['modifyvm', :id, '--natdnshostresolver1', 'on']
    vb.customize ['setextradata', :id, 'VBoxInternal/Devices/VMMDev/0/Config/GetHostTimeDisabled', 0]
  end

  config.vm.provision "ansible_local" do |ansible|
    ansible.compatibility_mode = "2.0"
    ansible.extra_vars = {
      vccw: _conf
    }
    ansible.playbook = "provision/playbook.yml"
  end

  if File.exists?(File.join(ENV["HOME"], '.vccw/playbook-post.yml'))
    config.vm.provision "ansible" do |ansible|
      ansible.compatibility_mode = "2.0"
      ansible.extra_vars = {
        vccw: _conf
      }
      ansible.playbook = File.join(ENV["HOME"], '.vccw/playbook-post.yml')
    end
  end

  if File.exists?(File.join(ENV["HOME"], '.vccw/provision-post.sh'))
    config.vm.provision :shell, :privileged => false, :path => File.join(ENV["HOME"], '.vccw/provision-post.sh')
  end

  if File.exists?(File.join(File.dirname(__FILE__), 'playbook-post.yml')) then
    config.vm.provision "ansible_local" do |ansible|
      ansible.compatibility_mode = "2.0"
      ansible.extra_vars = {
        vccw: _conf
      }
      ansible.playbook = "playbook-post.yml"
    end
  end

  if File.exists?(File.join(File.dirname(__FILE__), 'provision-post.sh')) then
    config.vm.provision :shell, :privileged => false, :path => File.join( File.dirname(__FILE__), 'provision-post.sh' )
  end

  if File.exists?(File.join(File.dirname(__FILE__), 'run-always.sh')) then
    config.vm.provision :shell, :path => File.join( File.dirname(__FILE__), 'run-always.sh' ), run: 'always'
  end
end
