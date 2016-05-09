<?php

/**
 * Debug function
 * d($var);
 */
function d($var)
{
    echo '<pre>';
    yii\helpers\VarDumper::dump($var, 10, true);
    echo '</pre>';
}

/**
 * Debug function with die() after
 * dd($var);
 */
function dd($var)
{
    d($var);
    die();
}

/* Include configuration file */
function settings($key) {
    $settings = json_decode(file_get_contents(__DIR__.'/settings.json'), true);
    return $settings[$key];
}

/* Get all setting */
function getAllSettings() {
	return json_decode(file_get_contents(__DIR__.'/settings.json'), true);
}

function saveAllSettings($settings) {
	try {
        $fh = fopen(__DIR__.'/settings.json','w');
        fwrite($fh, json_encode($settings, JSON_UNESCAPED_UNICODE));
        fclose($fh);
    }
    catch (Exception $e) {
        // d($e);
    }
}