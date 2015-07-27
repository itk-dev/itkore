<?php

/**
 * @file
 * Contains \Drupal\imagick\Plugin\ImageToolkit\Operation\imagick\Decipher
 */

namespace Drupal\imagick\Plugin\ImageToolkit\Operation\imagick;

use Imagick;

/**
 * Defines imagick decipher operation.
 *
 * @ImageToolkitOperation(
 *   id = "imagick_decipher",
 *   toolkit = "imagick",
 *   operation = "decipher",
 *   label = @Translation("Decipher"),
 *   description = @Translation("Applies the decipher effect on an image")
 * )
 */
class Decipher extends ImagickImageToolkitOperationBase {

  /**
   * {@inheritdoc}
   */
  protected function arguments() {
    return array(
      'password' => array(
        'description' => 'The password to decrypt the image with.',
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(array $arguments = array()) {
    /* @var $res \Imagick */
    $res = $this->getToolkit()->getResource();

    return $res->decipherImage($arguments['password']);
  }

}
