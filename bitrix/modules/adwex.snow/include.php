<?php
spl_autoload_register(function ($className) {
    $classVendors = array(
        'AdwexSnow',
    );
    $file = '';
    foreach ($classVendors as $classVendor) {
        if (false !== strpos($className, $classVendor)) {
            $file = __DIR__ . '/lib/' . $className . '.php';
            break;
        }
    }
    if (!empty($file)) {
        $file = str_replace('\\', '/', $file);
        if (file_exists($file)) {
            require_once($file);
        }
    }
});
?>