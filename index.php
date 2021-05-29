<?php
require_once __DIR__.'/autoload.php';

use SpaceWeb\SpaceWeb;

$testClass = new SpaceWeb();

try {

    $testClass->authorization('spacewebap', 'HZq9MRwyj');
    print_r($testClass->addDomain('a159014db5dc1.ru', 'manual'));

}catch (Exception $exception){
    print_r($exception->getMessage());
}
