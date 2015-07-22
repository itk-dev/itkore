<?php

/**
 * @file
 * Contains \Drupal\imagick\Plugin\ImageToolkit\Operation\imagick\Swirl.
 */

namespace Drupal\imagick\Plugin\ImageToolkit\Operation\imagick;

/**
 * Defines imagick swirl operation.
 *
 * @ImageToolkitOperation(
 *   id = "imagick_swirl",
 *   toolkit = "imagick",
 *   operation = "swirl",
 *   label = @Translation("Swirl"),
 *   description = @Translation("Adds a swirl effect to an image.")
 * )
 */
class Swirl extends ImagickImageToolkitOperationBase {

  /**
   * {@inheritdoc}
   */
  protected function arguments() {
    return array(
      'degrees' => array(
        'description' => 'The amplitude of the wave effect.',
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(array $arguments = array()) {
    /* @var $res \Imagick */
    $res = $this->getToolkit()->getResource();

    return $res->swirlImage($arguments['degrees']);
  }

}
