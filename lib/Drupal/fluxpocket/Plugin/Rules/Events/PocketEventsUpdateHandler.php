<?php

/**
 * @file
 * Contains PocketEventEntriesHandler.
 */

namespace Drupal\fluxpocket\Plugin\Rules\EventHandler;

use Drupal\fluxpocket\Plugin\Service\PocketAccountInterface;

/**
 * Event handler for updation of url to pocket.
 */
class PocketEventUpdateHandler extends PocketEventHandlerBase {

  /**
   * Defines the event.
   */
  public static function getInfo() {
    return static::getInfoDefaults() + array(
      'name' => 'fluxpocket_event_update',
      'label' => t("A  URL was updated in Pocket"),
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
    return 'Drupal\fluxpocket\Tasks\PocketUpdatedTask';
  }

  /**
   * {@inheritdoc}
   */
  public function summary() {
    $settings = $this->getSettings();
    $account = entity_load_single('fluxservice_account', $settings['account']);
    if ($settings['account'] && $account) {
      return t('A new Entry updated on the Pocket of %account.', array(
          '%account' => "{$account->label()}",
      ));
    }
    return $this->eventInfo['label'];
  }
}
