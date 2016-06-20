<?php
/**
 * @file
 * Contains \Drupal\itk_instagram_hashtag\Plugin\Field\FieldFormatter\InstagramHashtagDefaultFormatter.
 */

namespace Drupal\itk_instagram_hashtag\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\SafeMarkup;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'field_instagram_hashtag_default_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "field_instagram_hashtag_default_formatter",
 *   label = @Translation("Instagram hashtag default formatter"),
 *   module = "itk_instagram_hashtag",
 *   field_types = {
 *     "field_instagram_hashtag"
 *   }
 * )
 */
class InstagramHashtagDefaultFormatter extends FormatterBase {
  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $instagramConfig = \Drupal::config('itk_instagram_hashtag.settings');

    $elements = array();
    foreach ($items as $delta => $item) {
      // Remove # from instagram_hashtag
      $instagramHashtag = str_replace('#', '', SafeMarkup::checkPlain($item->value));

      // Render output using itk_instagram_hashtag_default theme.
      $source = array(
        '#theme' => 'itk_instagram_hashtag_default_theme',
        '#instagram_hashtag' => $instagramHashtag,
        '#attached' => array(
          'library' => array(
            'itk_instagram_hashtag/base'
          ),
          'drupalSettings' => array(
            'itkInstagramHashtag' => array(
              'clientId' => $instagramConfig->get('itk_instagram_hashtag.client_id'),
              'resolution' => $instagramConfig->get('itk_instagram_hashtag.resolution'),
              'sortBy' => $instagramConfig->get('itk_instagram_hashtag.sort_by'),
              'limit' => $instagramConfig->get('itk_instagram_hashtag.limit'),
              'enableCaption' => $instagramConfig->get('itk_instagram_hashtag.enable_caption'),
            ),
          ),
        )
      );

      $elements[$delta] = array('#markup' => \Drupal::service('renderer')->render($source));
    }

    return $elements;
  }

}