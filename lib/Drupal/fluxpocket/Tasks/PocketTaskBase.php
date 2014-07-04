<?php

/**
 * @file
 * Contains PocketTaskBase.
 */

namespace Drupal\fluxpocket\Tasks;

use Drupal\fluxservice\Rules\TaskHandler\RepetitiveTaskHandlerBase;

/**
 * Base class for Pocket task handlers that dispatch Rules events.
 *
 * Provides a repetitive task that is repetitively run by Rules Scheduler
 * depending on the configured polling interval.
 *
 * Tasks get automatically scheduled when the respective event has been
 * configured via CronEventHandlerBase, i.e. each Task is referred by an Event.
 */
class PocketTaskBase extends RepetitiveTaskHandlerBase {

  /**
   * The account associated with this task.
   *
   * @var \Drupal\fluxpocket\Plugin\Service\PocketAccount
   */
  protected $account;

  /**
   * Gets the configured event name to dispatch.
   */
  public function getEvent() {
    return $this->task['identifier'];
  }

  /**
   * Gets the configured Pocket account.
   *
   * @throws \RulesEvaluationException
   *   If the account cannot be loaded.
   *
   * @return \Drupal\fluxpocket\Plugin\Service\PocketAccount
   *   The account associated with this task.
   */
  public function getAccount() {
    if (isset($this->account)) {
      return $this->account;
    }
    if (!$account = entity_load_single('fluxservice_account', $this->task['data']['account'])) {
      throw new \RulesEvaluationException('The specified Pocket account cannot be loaded.', array(), NULL, \RulesLog::ERROR);
    }
    $this->account = $account;
    return $this->account;
  }

  /**
   * {@inheritdoc}
   */
  public function afterTaskQueued() {
    try {
      $service = $this->getAccount()->getService();

      // Continuously reschedule the task.
      db_update('rules_scheduler')
        ->condition('tid', $this->task['tid'])
        ->fields(array('date' => $this->task['date'] + $service->getPollingInterval()))
        ->execute();
    }
    catch(\RulesEvaluationException $e) {
      rules_log($e->msg, $e->args, $e->severity);
    }
  }

}
