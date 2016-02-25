#Setup guidelines

##About
ITKore represents a drupal 8 platform from which new drupal 8 sites may be built. This way some of the trivial tasks are bypassed to start the project a little further ahead.

When including ITKore in your site you probably want to detach the repo after initial install, to store your project elsewhere.

##Installation
A local setup may use the ITKore vagrant available from the aakb vagrant pack. Installation instructions may be found there.


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

-
* Ctools
* Imce
* Pathauto
* Pathauto menu link parents hack
* Redirect
* Token

##Theme
An ITKore theme is available. This is primarily used for presentation purposes. A new site will usually include a new theme made from scratch. The ITKore theme may hold some components that can be used in the new theme.