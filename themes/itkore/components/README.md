ITK components
==============

Configuration
-------------
1. Fetch the boilerplate repository.
2. Copy the desired components sass file into your sass components directory.
3. Import the components: _[component_name].scss in your styles.scss file.
4. Follow the example files to use the styles.


Components
-----------
1. ITK tabs
2. ITK menu
3. ITK messages




ITK tabs
--------
####Description:####
Provides styles for displaying tabs with rounded corners.

####State classes:####
**Tabs wrapper**: is-full-width (Requires a tabs count attribute. -  The static number of tabs inside wrapper)

**Tabs** : is-active




ITK menu
--------
####Description:####
Requires IE 10 (Uses CSS animations.)

Provides styles for an animated side menu. An example javascript (jquery) file is provided which adds and removes the state classes used.

####State classes:####
**HTML and body tags**: is-locked (Locking the content in place - disables scrolling)

**Menu**: is-visible, is-hidden

**Overlay link** : is-visible




ITK messages
--------
####Description:####
Provides styles for messages.

####State classes:####
**Message style**: is-info, is-warning, is-error