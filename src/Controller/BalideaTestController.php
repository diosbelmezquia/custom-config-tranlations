<?php

namespace Drupal\balidea_test\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for Balidea Test.
 */
class BalideaTestController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build(): array {
    // Get the config for module.
    $config = $this->config('balidea_test.settings');

    $build['content'] = [
      '#theme' => 'balidea_test_template',
      '#data' => [
        'text' => $config->get('balidea_text.value'),
        'number' => $config->get('balidea_number'),
      ],
    ];

    return $build;
  }

}
