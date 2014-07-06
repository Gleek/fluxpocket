<?php

/**
 * @file
 * Contains PocketEventArchiveHandler.
 */

namespace Drupal\fluxpocket\Plugin\Rules\EventHandler;

/**
 * Event handler for polling for Archived URLs in Pocket.
 */
class PocketEventArchiveHandler extends PocketEventHandlerBase {

  /**
   * Defines the event.
   */
  public static function getInfo() {
    return static::getInfoDefaults() + array(
      'name' => 'fluxpocket_event_archive',
      'label' => t("A new URL was archived in Pocket"),
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
    return 'Drupal\fluxpocket\Tasks\PocketArchiveTask';
  }

  /**
   * {@inheritdoc}
   */
  public function summary() {
    $settings = $this->getSettings();
    $account = entity_load_single('fluxservice_account', $settings['account']);
    if ($settings['account'] && $account) {
      return t('A new URL is archived in Pocket of %account.', array(
          '%account' => "{$account->label()}"
      ));
    }
    return $this->eventInfo['label'];
  }
}
