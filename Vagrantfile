VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "gajdaw/symfony"

  # Necessary to set up username and email for git
  config.vm.provision "shell", path: "setup.sh"

end
