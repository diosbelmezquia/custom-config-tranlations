<?php

namespace Drupal\balidea_test\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Balidea test settings.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'balidea_test_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'balidea_test.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Get the config.
    $config = $this->config('balidea_test.settings');

    $form['balidea_text'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Text'),
      '#default_value' => $config->get('balidea_text.value') ?: '',
      '#format' => $config->get('balidea_text.format') ?: filter_default_format(),
      '#row' => 10,
      '#required' => TRUE,
    ];

    $form['balidea_number'] = [
      '#type' => 'number',
      '#required' => TRUE,
      '#min' => 0,
      '#title' => $this->t('Integer number'),
      '#default_value' => $config->get('balidea_number'),
    ];

    // Return the form.
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Validate number integer only.
    if (!is_int($form_state->getValue('balidea_number'))) {
      $this->messenger()->addError($this->t('Only integers numbers are allowed'));
    }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Submitted Message.
    $submitted_message = $form_state->getValue('balidea_text');
    // Save to balidea_test.settings.
    $this->config('balidea_test.settings')
      ->set('balidea_text.value', $submitted_message['value'])
      ->set('balidea_text.format', $submitted_message['format'])
      ->set('balidea_number', $form_state->getValue('balidea_number'))
      ->save();
    // Call the parent Submit function.
    parent::submitForm($form, $form_state);
  }

}
