# itk_instagram_hashtag

A Drupal 8 module that adds a field type (Instagram Hashtag) that displays images from instagram with instafeed.js: http://instafeedjs.com/

## Installation

Add the module to the modules folder and enable it.
Go to configuration -> Instagram Hashtag and set configuration options.

## Configuration Options

This data is a short version of the options available at http://instafeedjs.com/.

### Client Id

Instagram client id. This is acquired from https://instagram.com/developer/ under "Manage Clients".

### Resolution

The resolution of the images from instagram.

#### Available options

* thumbnail - 150x150 (default)
* low_resolution - 306x306
* standard_resolution - 612x612

### Sort By

How the results are sorted.

#### Available options

* none - As they come from Instagram. (default)
* most-recent - Newest to oldest.
* least-recent - Oldest to newest.
* most-liked - Highest # of likes to lowest.
* least-liked - Lowest # likes to highest.
* most-commented - Highest # of comments to lowest.
* least-commented - Lowest # of comments to highest.
* random - Random order.

### Limit

The maximum number of images to get.

### Display captions

Should the captions be visible below the images?