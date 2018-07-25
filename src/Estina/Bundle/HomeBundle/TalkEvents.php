<?php

namespace Estina\Bundle\HomeBundle;

/**
 * TalkEvents
 */
class TalkEvents
{
    const CANCEL = 'talk.cancel';
    const CONFIRM = 'talk.confirm';
    const CREATE = 'talk.create';
    const UPDATE = 'talk.update';

    public static function getName($event)
    {
      $map = [
        self::CANCEL => 'Canceled',
        self::CONFIRM => 'Confirmed',
        self::CREATE => 'Created',
        self::UPDATE => 'Updated'
      ];

      if (!isset($map[$name])) {
        throw new \InvalidArgumentException("No name set for event '{$event}'");
      }

      return $map[$name];
    }
}
