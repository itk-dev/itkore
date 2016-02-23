# Pathauto menu-link-parents hack

On drupal 8 the node:menu-link:parents:join-path token only work when a node is saved a second time.

This module simply automatically save the node a second time to workaround this bug.

Eventually this is not a perfect solution. See https://github.com/md-systems/pathauto/issues/76 for more information.
