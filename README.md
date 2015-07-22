**_Private repository because included font is commercial_**


Setup guidelines
================

### The short version

```
vagrant up
vagrant ssh
/vagrant/install.sh
```


### The long version

Create virtual machine:

```
vagrant up
cd /vagrant
```

Download Drupal:

```
drush dl drupal-8.0.0-beta10 --drupal-project-rename=htdocs
```

Apply [patch 1838242-65](https://www.drupal.org/files/issues/1838242-65.patch) ([Improve Views integration for datetime field](https://www.drupal.org/node/1838242)):

```
cd htdocs
curl https://www.drupal.org/files/issues/1838242-65.patch | patch --strip=1 --force
cd -
```

Clone this repository:

```
cd htdocs/sites
git clone git@github.com:aakb/dokk1.git all
cd -
```

Install Drupal:

```
cd htdocs
drush --yes site-install minimal --db-url='mysql://root:vagrant@localhost/dokk1' --site-name=dokk1 --account-name=admin --account-pass=admin --writable
```

Install modules:

```
drush --yes pm-enable dokk_enable
drush --yes pm-enable dokk seven
drush --yes updatedb
```

Edit sites/default/settings.php and append

```
$config_directories['staging'] = 'sites/all/config/staging';
$config_directories['active'] = 'sites/all/config/active';
```

by running these commands

```
chmod a+w sites/default/settings.php
echo "\$config_directories['staging'] = 'sites/all/config/staging';" >> sites/default/settings.php
echo "\$config_directories['active'] = 'sites/all/config/active';" >> sites/default/settings.php
```

Import configuration:

First, we need to set the site uuid and default language

```
mkdir -p tmp-config
cp sites/all/config/staging/system.site.yml sites/all/config/staging/language.entity.en.yml tmp-config
drush --yes config-import --partial --source=./tmp-config/
rm -r tmp-config
```

Then, we import all configuration

```
drush --yes config-import staging
drush --yes updatedb
```

Done!

WAYF configuration
------------------

Outside vagrant box, in vagrant/dokk1:

```
mkdir -p wayf
curl --location '«url of koba_wayf.yml, cf. Skype»' > wayf/wayf_dk_login.settings.yml
vagrant ssh
cd /vagrant/htdocs
drush --yes config-import --source=../wayf/ --partial
drush cache-rebuild
```


Loading data
------------

You can load data from stg.dokk1.dk like this

```
drush pull-stg
```

Or from dev.dokk1.dk like this

```
drush pull-dev
```

Resetting the admin password
----------------------------

```
drush user-password admin --password=admin
```

Local (development) settings
----------------------------

Local developer settings can – and should – be kept in a local settings file:

```
vagrant ssh
cd /vagrant/htdocs
chmod a+w sites/default/
cp sites/example.settings.local.php sites/default/settings.local.php
chmod a+w sites/default/settings.local.php
```

Edit sites/default/settings.local.php and make the changes you want.

### Full error reporting

Add this to settings.local.php

```
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
```

### Disable Twig cache

Add this line:

```
$settings['container_yamls'][] = __DIR__ . '/services.local.yml';
```

and create the file sites/default/services.local.yml with this content:

```
parameters:
  twig.config:
    debug: true
    auto_reload: true
    cache: false
```

Finally, edit sites/settings.local.php and uncomment these lines
```
if (file_exists(__DIR__ . '/settings.local.php')) {
  include __DIR__ . '/settings.local.php';
}
```

Clear cache and start hacking
```
drush cache-rebuild
```


# Deploying on server

1. Perform a backup

    ```
    cd htdocs
    drush archive-dump
    ```

2. Clone any new modules

    ```
    cd htdocs/modules
	git clone «…»
    ```

3. Checkout release

    ```
    cd htdocs/sites/all
    git checkout master
	git pull
    git checkout «some release tag»
	```

4. Import partial configuration

    ```
    drush config-import --partial
	drush cache-rebuild
	drush updatedb
    ```

-------------------------------------------------------------------------------

**Note:**

It is possible to use the old sites/all/modules sites/all/themes structure.

"sites/all/* directories remain intact and even have precedence over top-level directories (in case the same extension appears in both locations) for legacy/historical reasons.
Drupal 8 ships with the top-level directories by default and encourages users to use them. The sites/all/* directories no longer exist by default (but remain to be functional, if existent)." -https://www.drupal.org/node/1766160

We choose this approach in order to maintain a single git repository sites/all.
All contrib and custom files should be moved to this location.
This may not be possible throughout the project, and we may need to create a different git structure at a later stage.

- If using codekit create a compass project from the "themes/dokk" directory.

Structure
------------

- Contributed modules are located at sites/all/modules/contrib
- Custom modules are located at sites/all/modules
- Default system templates are located at core/modules/* (check system module for several base templates).
  These templates should be copied into sites/all/themes/dokk/templates

Workflow
-----------

- When changing configuration locally, export these configurations to appropriate yml files in the sites/all/config/staging directory.

	```
	drush config-export staging
	```

- Push/pull them to server and synchronize on server
