<?php
class A {
    static function who() {
        echo __CLASS__;
    }
    static function test() {
        echo __CLASS__;
        static::who();
        self::who();
    }
}

class B extends A {
    static function who() {
        echo __CLASS__;
    }
}

B::test();

