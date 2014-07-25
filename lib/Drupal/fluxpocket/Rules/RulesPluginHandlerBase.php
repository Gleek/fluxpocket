<?php

/**
 * @file
 * Contains RulesPluginHandlerBase.
 */

namespace Drupal\fluxpocket\Rules;

use Drupal\fluxservice\Rules\FluxRulesPluginHandlerBase;

/**
 * Base class for dropbox Rules plugin handler.
 */
abstract class RulesPluginHandlerBase extends FluxRulesPluginHandlerBase {

  /**
   * Returns info-defaults for pocket plugin handlers.
   */
  public static function getInfoDefaults() {
    return array(
      'category' => 'fluxpocket',
      'access callback' => array(get_called_class(), 'integrationAccess'),
    );
  }

  /**
   * Rules Pocket integration access callback.
   */
  public static function integrationAccess($type, $name) {
    return fluxservice_access_by_plugin('fluxpocket');
  }

  /**
   * Returns info suiting for pocket service account parameters.
   */
  public static function getAccountParameterInfo() {
    return array(
      'type' => 'fluxservice_account',
      'bundle' => 'fluxpocket',
      'label' => t('Pocket account'),
      'description' => t('The Pocket account under which this shall be executed.'),
    );
  }
}
