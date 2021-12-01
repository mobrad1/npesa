<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

     /**
     * Unset multiple arguments
     *
     * @param  array $array
     * @param  string $args
     * @return array
     */
    protected function unsetMultiple($array, ...$args)
    {
        foreach($args as $arg){
            unset($array[$arg]);
        }

        return $array;
    }
}
