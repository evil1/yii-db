<?php

namespace yiiunit\framework\db;

class AnyValue extends CompareValue
{
    /**
     * @var self
     */
    private static $_instance;

    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}
