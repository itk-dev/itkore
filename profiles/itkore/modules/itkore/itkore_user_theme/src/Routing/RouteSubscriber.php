<?php
/**
 * @file
 * Contains \Drupal\itkore_user_theme\Routing\RouteSubscriber.
 */

namespace Drupal\itkore_user_theme\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Listens to the dynamic route events.
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  public function alterRoutes(RouteCollection $collection) {
    // Change path '/user/login' to '/login'.
    if ($route = $collection->get('user.login')) {
      $route->setOption('_admin_route', 'TRUE');
    }

    if ($route = $collection->get('user.page')) {
      $route->setOption('_admin_route', 'TRUE');
    }

    if ($route = $collection->get('user.pass')) {
      $route->setOption('_admin_route', 'TRUE');
    }

    if ($route = $collection->get('user.register')) {
      $route->setOption('_admin_route', 'TRUE');
    }

    if ($route = $collection->get('user.reset')) {
      $route->setOption('_admin_route', 'TRUE');
    }
  }
}
?>