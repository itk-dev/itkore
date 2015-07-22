<?php

/**
 * @file
 * Contains \Drupal\imagick\Plugin\ImageToolkit\Operation\imagick\Mirror.
 */

namespace Drupal\imagick\Plugin\ImageToolkit\Operation\imagick;

/**
 * Defines imagick mirror operation.
 *
 * @ImageToolkitOperation(
 *   id = "imagick_mirror",
 *   toolkit = "imagick",
 *   operation = "mirror",
 *   label = @Translation("Mirror"),
 *   description = @Translation("Mirrors the image.")
 * )
 */
class Mirror extends ImagickImageToolkitOperationBase {

  /**
   * {@inheritdoc}
   */
  protected function arguments() {
    return array(
      'flip' => array(
        'description' => 'Mirror image verticaly.',
      ),
      'flop' => array(
        'description' => 'Mirror image horizontaly.',
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(array $arguments = array()) {
    /* @var $res \Imagick */
    $res = $this->getToolkit()->getResource();

    if ($arguments['flip']) {
      $res->flipImage();
    }
    if ($arguments['flop']) {
      $res->flopImage();
    }
    return $res;
  }

}
