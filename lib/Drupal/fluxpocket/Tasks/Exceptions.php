<?php namespace Drupal\fluxpocket\Tasks\Pocket;

class NoConsumerKeyException extends \UnexpectedValueException {}
class NoItemException extends \UnexpectedValueException {}
class InvalidItemTypeException extends \UnexpectedValueException {}
class NoPocketQueueException extends \UnexpectedValueException {}
