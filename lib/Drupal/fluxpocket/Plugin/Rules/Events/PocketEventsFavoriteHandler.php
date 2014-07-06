<?php

/**
 * @file
 * Contains PocketEventFavoriteHandler.
 */

namespace Drupal\fluxpocket\Plugin\Rules\EventHandler;

/**
 * Event handler for New favorite Item
 */
class PocketEventFavoriteHandler extends PocketEventHandlerBase {

  /**
   * Defines the event.
   */
  public static function getInfo() {
    return static::getInfoDefaults() + array(
      'name' => 'fluxpocket_event_favorite',
      'label' => t("A URL is added to favorites in Pocket"),
      'variables' => array(
        'account' => static::getServiceVariableInfo(),
        'pocket' => static::getEntryVariableInfo(),
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getTaskHandler() {
    return 'Drupal\fluxpocket\Tasks\PocketFavoriteTask';
  }

  /**
   * {@inheritdoc}
   */
  public function summary() {
    $settings = $this->getSettings();
    $account = entity_load_single('fluxservice_account', $settings['account']);
    if ($settings['account'] && $account) {
      return t('New favorite item in the Pocket of %account.', array(
          '%account' => "{$account->label()}"
      ));
    }
    return $this->eventInfo['label'];
  }
}
