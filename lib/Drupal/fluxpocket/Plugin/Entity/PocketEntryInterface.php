<?php

/**
 * @file
 * Contains FeedEntryInterface.
 */

namespace Drupal\fluxpocket\Plugin\Entity;

use Drupal\fluxservice\Entity\RemoteEntityInterface;

/**
 * Provides a common interface for all Pocket objects.
 */
interface PocketEntryInterface extends RemoteEntityInterface {

  /**
   * Gets the given url
   *
   * @return string
   */
  public function getGivenUrl();

  /**
   * Gets the resolved Url
   *
   * @return string
   */
  public function getResolvedUrl();

  /**
   * Gets the url's addition time
   *
   * @return string|null
   */
  public function getTimeAdded();

  /**
   * Gets the url updation time
   *
   * @return string
   */
  public function getTimeUpdated();

  /**
   * Gets the Url's Excerpt.
   *
   * @return string
   *   The feed's description.
   */
  public function getExcerpt();

  /**
   * Gets the item's ID.
   *
   * @return string
   */
  public function getId();

  /**
   * Gets the tag's
   *
   * @return string
   */
  public function getTags();

  /**
   * Gets the given title.
   *
   * @return string|null
   */
  public function getGivenTitle();

  /**
   * Gets the resolved title.
   *
   * @return string|null
   */
  public function getResolvedTitle();

  /**
   * Gets the number of words.
   *
   * @return string|null
   */
  public function getWordCount();

}
