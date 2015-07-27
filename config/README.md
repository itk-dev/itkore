Itkore configuration
===================



1. Update drush
---------------

```
vagrant ssh
```

```
sudo -i
apt-get install php5-readline
cd /opt/drush
git checkout .
git pull .
composer install
exit
```

```
cd /vagrant/htdocs/
drush cache-rebuild drush
```

2. Export active configuration
------------------------------

```
cd /vagrant/htdocs/
drush config-export staging
```

**Important**: Check that only the actual, real changes will be exported!

Cancel the export if too much will be exported. Otherwise, confirm the export.

Make sure that all config files and directories have the correct permissions:

```
find /vagrant/htdocs/sites/all/config -type d -exec chmod -c 777 {} \;
find /vagrant/htdocs/sites/all/config -name '*.yml' -exec chmod -c 777 {} \;
```

3. Commit to Git
----------------

Commit your configuration changes.
