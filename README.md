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
drush dl drupal-8.0.0-beta12 --drupal-project-rename=htdocs
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
git clone git@github.com:aakb/itkore.git all
cd -
```

Install Drupal:

```
cd htdocs
drush --yes site-install minimal --db-url='mysql://root:vagrant@localhost/itkore' --site-name=itkore --account-name=admin --account-pass=admin --writable
```

Install modules:

```
drush --yes pm-enable itkore_enable
drush --yes pm-enable itkore seven
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

- If using codekit create a compass project from the "themes/itkore" directory.

Structure
------------

- Contributed modules are located at sites/all/modules/contrib
- Custom modules are located at sites/all/modules
- Default system templates are located at core/modules/* (check system module for several base templates).
  These templates should be copied into sites/all/themes/itkore/templates
  
Itkore Enable Module
------------

This is just a shortcut to enable dependencies all at once. Any modules added to this install should also be added as dependencies to this module.   


Workflow
-----------

- When changing configuration locally, export these configurations to appropriate yml files in the sites/all/config/staging directory.

	```
	drush config-export staging
	```

- Push/pull them to server and synchronize on server


The Roads Not Taken
----------------------

- Install Profiles: Have to live in /profiles - this repo is designed to live under /sites/all - so in order to use a install profile it would need it's own repo. 
  As long as we don't need anything then managing dependencies this can be achieved with the Itkore Enable Module.
- Drush make: There is a know bug when using pm-enable with D8 that results in an infinite loop. This means we have to have contrib modules as part of this repo. 
  They can't (easily) be downloaded on demand - https://github.com/drush-ops/drush/issues/5
