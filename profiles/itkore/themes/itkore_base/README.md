#Itkore base theme
* A basic theme grayscaled. Subthemes made for ITKrate should always use this theme as a base theme.

##Setting up styles for your subtheme
* Include the _imports.scss from itkore_base. This holds base styling for all modules, components etc.
* Add a _theme.scss to set the variables required. This includes colors and font.
* Disable the styles.css from itkore_base in [theme].info.yml
* Remember to add your compiled css to the theme as a library in [theme].info.yml and [theme].libraries.yml

##Setting up blocks for your subtheme.
* Each theme has it's own block setup.
* Add a config/install folder in your theme.
* Add your block configuration to this folder (Without language code and uuid)
* The blocks will be added to the theme during install.