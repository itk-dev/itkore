<?php
/**
 * @file
 * Contains \Drupal\itk_instagram_hashtag\Plugin\Field\FieldWidget\InstagramDefaultWidget.
 */

namespace Drupal\itk_instagram_hashtag\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'field_instagram_hashtag_default_widget' widget.
 *
 * @FieldWidget(
 *   id = "field_instagram_hashtag_default_widget",
 *   label = @Translation("Instagram hashtag default widget"),
 *   module = "itk_instagram_hashtag",
 *   field_types = {
 *     "field_instagram_hashtag"
 *   }
 * )
 */
class InstagramHashtagDefaultWidget extends WidgetBase {
  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {

    $element['value'] = array(
      '#title' => t('Instagram hashtag'),
      '#type' => 'textfield',
      '#default_value' => isset($items[$delta]->value) ? $items[$delta]->value : NULL,
    );
    return $element;
  }
}