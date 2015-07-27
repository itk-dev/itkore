<?php

/**
 * @file
 * Contains \Drupal\imagick\Plugin\ImageToolkit\Operation\imagick\Charcoal.
 */

namespace Drupal\imagick\Plugin\ImageToolkit\Operation\imagick;

/**
 * Defines imagick charcoal operation.
 *
 * @ImageToolkitOperation(
 *   id = "imagick_charcoal",
 *   toolkit = "imagick",
 *   operation = "charcoal",
 *   label = @Translation("Charcoal"),
 *   description = @Translation("Applies the charcoal effect on an image")
 * )
 */
class Charcoal extends ImagickImageToolkitOperationBase {

  /**
   * {@inheritdoc}
   */
  protected function arguments() {
    return array(
      'radius' => array(
        'description' => 'The radius of the charcoal effect.',
      ),
      'sigma' => array(
        'description' => 'The sigma of the charcoal effect.',
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(array $arguments = array()) {
    /* @var $res \Imagick */
    $res = $this->getToolkit()->getResource();

    return $res->charcoalImage($arguments['radius'], $arguments['sigma']);
  }

}
