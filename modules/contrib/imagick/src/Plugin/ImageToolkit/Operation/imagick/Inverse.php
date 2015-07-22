<?php

/**
 * @file
 * Contains \Drupal\imagick\Plugin\ImageToolkit\Operation\imagick\Inverse.
 */

namespace Drupal\imagick\Plugin\ImageToolkit\Operation\imagick;

/**
 * Defines imagick inverse operation.
 *
 * @ImageToolkitOperation(
 *   id = "imagick_inverse",
 *   toolkit = "imagick",
 *   operation = "inverse",
 *   label = @Translation("Inverse"),
 *   description = @Translation("Inverses the image's colors")
 * )
 */
class Inverse extends ImagickImageToolkitOperationBase {

  /**
   * {@inheritdoc}
   */
  protected function arguments() {
    return array();
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(array $arguments = array()) {
    /* @var $res \Imagick */
    $res = $this->getToolkit()->getResource();

    return $res->negateImage(FALSE);
  }

}
