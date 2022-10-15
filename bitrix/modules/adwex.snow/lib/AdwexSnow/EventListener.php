<?php
namespace AdwexSnow;

class EventListener {
    public static function OnEndBufferContent(&$content) {
        \AdwexSnow::addSnow($content);
    }
}