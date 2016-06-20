#Setup guidelines

##About
ITKore represents a drupal 8 platform from which new drupal 8 sites may be built. This way some of the trivial tasks are bypassed to start the project a little further ahead.

##Creating a project based on this install profile
Either clone this repo and manually fetch the modules required or follow directions below.
 
* Copy the scripts folder found in aakb/vagrant/itkore repository. This should include an install.sh and site_setup.sh
* Run install.sh (Fetches all required files in the latest stable version)
* Run site_setup.sh (Runs a Drupal installation) 

When including ITKore profile in your site you probably want to detach the repository after initial install, to store your project files seperately.

##Adding to and changing ITKore profile
* New modules should be added to the profiles composer.json file as a requirement. This will ensure the module is being fetched
* After modifying install profile composer.json file run: "composer drupal-update". This will use composer manager to update the project composer.json file located in document root.
* New modules should also be added to the itkore.info.yml file as a dependency. Future builds will then enable the module.
* Additional settings should be added in itkore.profile file.

##Modules

###ITKore
ITKore contains the following modules

* ITKore base
   * Provides an admin interface for site specific config settings
* ITKore blocks
   * Sets up default blocks for main theme and admin theme
* ITKore content types
   * Provides four content types
      1. News
      2. Page
      3. Overview page
      4. Event
* ITKore enable
   * Enables all modules and sets some simple variables
* ITKore fields
   * Holds field definitions
* ITkore language
   * Sets up danish language
* ITKore text filters
   * Sets up text filters
* ITKore user roles
   * Sets up user roles and permissions
* ITKore user theme
   * Sets up login form to use admin theme

###Other
To support the build som basic drupal contrib and custom ITK modules are added.

* ITK cookie message
   * Provides cookie warning
* ITK instagram hashtag
   * Provides a hashtag field type
* ITK paragraph
   * Provides default paragraph types commonly used by ITK
* Ctools
* Imce
* Pathauto
* Redirect
* Token
* Paragraphs
* Youtube field

##Theme
An ITKore theme is available. This is primarily used for presentation purposes. A new site will usually include a new theme made from scratch. The ITKore theme may hold some components that can be used in the new theme.
Adminimal theme is used as a backend theme for editors and admins
