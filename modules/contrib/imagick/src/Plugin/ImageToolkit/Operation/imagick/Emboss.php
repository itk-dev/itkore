<?php

/**
 * @file
 * Contains \Drupal\imagick\Plugin\ImageToolkit\Operation\imagick\Emboss.
 */

namespace Drupal\imagick\Plugin\ImageToolkit\Operation\imagick;

/**
 * Defines imagick emboss operation.
 *
 * @ImageToolkitOperation(
 *   id = "imagick_emboss",
 *   toolkit = "imagick",
 *   operation = "emboss",
 *   label = @Translation("Emboss"),
 *   description = @Translation("Applies the emboss effect on an image")
 * )
 */
class Emboss extends ImagickImageToolkitOperationBase {

  /**
   * {@inheritdoc}
   */
  protected function arguments() {
    return array(
      'radius' => array(
        'description' => 'The radius of the emboss effect.',
      ),
      'sigma' => array(
        'description' => 'The sigma of the emboss effect.',
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(array $arguments = array()) {
    /* @var $res \Imagick */
    $res = $this->getToolkit()->getResource();

    return $res->embossImage($arguments['radius'], $arguments['sigma']);
  }

}
