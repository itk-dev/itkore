<?php

/**
 * @file
 * Contains \Drupal\imagick\Plugin\ImageToolkit\Operation\imagick\Encipher
 */

namespace Drupal\imagick\Plugin\ImageToolkit\Operation\imagick;

use Imagick;

/**
 * Defines imagick encipher operation.
 *
 * @ImageToolkitOperation(
 *   id = "imagick_encipher",
 *   toolkit = "imagick",
 *   operation = "encipher",
 *   label = @Translation("Encipher"),
 *   description = @Translation("Applies the encipher effect on an image")
 * )
 */
class Encipher extends ImagickImageToolkitOperationBase {

  /**
   * {@inheritdoc}
   */
  protected function arguments() {
    return array(
      'password' => array(
        'description' => 'The password to encrypt the image with.',
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(array $arguments = array()) {
    /* @var $res \Imagick */
    $res = $this->getToolkit()->getResource();

    return $res->encipherImage($arguments['password']);
  }

}
