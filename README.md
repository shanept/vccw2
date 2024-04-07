# VCCW (New and improved)

This is a Vagrant configuration designed for development of WordPress plugins, themes, or websites.

**New and Improved!**  
The old version of VCCW relied on an old vagrant box that was well out of date. Spinning it up in 2024 resulted in so many errors... This edition is based upon raw ubuntu images, to achieve the same level of operability. It aims to be compatible with old VCCW instances whilst embracing more modern software.

CentOS 7 compatibility is in progress, with newer versions to follow. Spin it up and see if you can get it working! We would love a pull request!

## Getting Started

1. [Download the ZIP][1] from GitHub.
1. Unzip to where you wish to instantiate your vagrant machine.
1. **(optional)** Install any additional vagrant plugins (see below).
1. Change any configuration settings to suit your requirements (see below).
1. ``vagrant up``

## Configuration

1. Copy `provision/default.yml` to `site.yml`.
1. Edit the `site.yml`.
1. Run `vagrant up`.

### Note

* The `site.yml` has to be in the same directory with Vagrantfile.

## Vagrant Plugins

We currently support the following vagrant plugins:

- hostmanager
- hostsupdater
- vbguest

[1]: https://github.com/shanept/vccw2/archive/refs/heads/master.zip
