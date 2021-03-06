<?php

/**
 * @file
 * Contains PocketEventEntriesHandler.
 */

namespace Drupal\fluxpocket\Plugin\Rules\EventHandler;

use Drupal\fluxpocket\Plugin\Service\PocketAccountInterface;

/**
 * Event handler for addition of url to pocket.
 */
class PocketEventEntriesHandler extends PocketEventHandlerBase {

  /**
   * Defines the event.
   */
  public static function getInfo() {
    return static::getInfoDefaults() + array(
      'name' => 'fluxpocket_event_entries',
      'label' => t("A new URL was added in Pocket"),
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
    return 'Drupal\fluxpocket\Tasks\PocketAddTask';
  }

  /**
   * {@inheritdoc}
   */
  public function summary() {
    $settings = $this->getSettings();
    $account = entity_load_single('fluxservice_account', $settings['account']);
    if ($settings['account'] && $account) {
      return t('A new Entry appears on the Pocket of %account.', array(
          '%account' => "{$account->label()}",
      ));
    }
    return $this->eventInfo['label'];
  }
}
