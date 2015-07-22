<?php

/**
 * @file
 * Contains \Drupal\imagick\Plugin\ImageToolkit\Operation\imagick\Edge.
 */

namespace Drupal\imagick\Plugin\ImageToolkit\Operation\imagick;

/**
 * Defines imagick edge operation.
 *
 * @ImageToolkitOperation(
 *   id = "imagick_edge",
 *   toolkit = "imagick",
 *   operation = "edge",
 *   label = @Translation("Edge"),
 *   description = @Translation("Applies the edge effect on an image.")
 * )
 */
class Edge extends ImagickImageToolkitOperationBase {

  /**
   * {@inheritdoc}
   */
  protected function arguments() {
    return array(
      'radius' => array(
        'description' => 'The radius of the edge operation.',
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(array $arguments = array()) {
    /* @var $res \Imagick */
    $res = $this->getToolkit()->getResource();

    return $res->edgeImage($arguments['radius']);
  }

}
