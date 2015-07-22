<?php

/**
 * @file
 * Contains \Drupal\imagick\Plugin\ImageToolkit\Imagick.
 */

namespace Drupal\imagick\Plugin\ImageToolkit;

use Drupal\system\Plugin\ImageToolkit\GDToolkit;
use Drupal\Core\Form\FormStateInterface;
use Drupal\imagick\ImagickException;
use Imagick;

/**
 * Defines the Imagick toolkit for image manipulation within Drupal.
 *
 * @ImageToolkit(
 *   id = "imagick",
 *   title = @Translation("Imagick image manipulation toolkit")
 * )
 */
class ImagickToolkit extends GDToolkit {

  /**
   * {@inheritdoc}
   */
  protected function load() {
    // Return immediately if the image file is not valid.
    if (!$this->isValid()) {
      return FALSE;
    }

    try {
      $resource = $this->getImage()->getSource();
      $path = \Drupal::service('file_system')->realpath($resource);

      $res = new Imagick($path);
      $this->setResource($res);
      return TRUE;
    }
    catch (ImagickException $e) {
      return FALSE;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function save($destination) {
    /* @var $res \Imagick */
    $res = $this->getResource();

    $scheme = file_uri_scheme($destination);
    // Work around lack of stream wrapper support in imagejpeg() and imagepng().
    if ($scheme && file_stream_wrapper_valid_scheme($scheme)) {
      // If destination is not local, save image to temporary local file.
      $local_wrappers = file_get_stream_wrappers(STREAM_WRAPPERS_LOCAL);
      if (!isset($local_wrappers[$scheme])) {
        $permanent_destination = $destination;
        $destination = drupal_tempnam('temporary://', 'imagick_');
      }
      // Convert stream wrapper URI to normal path.
      $destination = drupal_realpath($destination);
    }

    // If preferred format is set, use it as prefix for writeImage
    // If not this will throw a ImagickException exception
    try {
      $image_format = strtolower($res->getImageFormat());
      $destination = implode(':', array($image_format, $destination));
    }
    catch (ImagickException $e) {}

    // Only compress JPEG files because other filetypes will increase in filesize
    if (isset($image_format) && in_array($image_format, array('jpeg', 'jpg'))) {

      // Use image quality if it has been set by an effect
      $effect_quality = $res->getImageProperty('quality');

      if (!empty($effect_quality)) {
        $res->setImageCompressionQuality($effect_quality);
      }
      else {
        $quality = $this->configFactory->get('imagick.config')->get('jpeg_quality');
        $res->setImageCompressionQuality($quality);
      }
    }

    // Write image to destination
    if (!$res->writeImage($destination)) {
      return FALSE;
    }

    // Move temporary local file to remote destination.
    if (isset($permanent_destination)) {
      return (bool) file_unmanaged_move($destination, $permanent_destination, FILE_EXISTS_REPLACE);
    }
    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function getWidth() {
    if ($this->preLoadInfo) {
      return $this->preLoadInfo[0];
    }
    elseif ($resource = $this->getResource()) {
      $data = $resource->getImageGeometry();
      return $data['width'];
    }
    else {
      return NULL;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getHeight() {
    if ($this->preLoadInfo) {
      return $this->preLoadInfo[1];
    }
    elseif ($resource = $this->getResource()) {
      $data = $resource->getImageGeometry();
      return $data['height'];
    }
    else {
      return NULL;
    }
  }

  /**
   * @return \Imagick
   */
  public function getResource() {
    return parent::getResource();
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form['image_jpeg_quality'] = array(
      '#type' => 'number',
      '#title' => t('JPEG quality'),
      '#description' => t('Define the image quality for JPEG manipulations. Ranges from 0 to 100. Higher values mean better image quality but bigger files.'),
      '#min' => 0,
      '#max' => 100,
      '#default_value' => $this->configFactory->get('imagick.config')->get('jpeg_quality'),
      '#field_suffix' => t('%'),
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $this->configFactory->getEditable('imagick.config')
      ->set('jpeg_quality', $form_state->getValue(array('imagick', 'image_jpeg_quality')))
      ->save();
  }

  /**
   * {@inheritdoc}
   */
  public function getRequirements() {
    $requirements = array();

    // Check for filter and rotate support.
    if (!$this->isAvailable()) {
      $requirements['not_installed'] = array(
        'title' => 'ImageMagick PHP extension',
        'value' => t('Not installed'),
        'severity' => REQUIREMENT_ERROR,
        'description' => t('The Imagick image toolkit requires that the Imagick extension for PHP be installed and configured properly. For more information see <a href="@url">PHP\'s ImageMagick documentation</a>.', array('@url' => 'http://php.net/manual/book.imagick.php')),
      );
    }

    return $requirements;
  }

  /**
   * {@inheritdoc}
   */
  public static function isAvailable() {
    // imagick support is available.
    return extension_loaded('imagick');
  }

}