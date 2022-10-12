<?php

namespace App\Service;

class Common
{
    /**
     * Copy input array removing its keys.
     * @param mixed[] $array
     *
     * @return mixed[]
     */
    public static function boo(array $array): array
    {
        $result = [];
        array_walk_recursive($array, function ($a) use (&$result) {
            $result[] = $a;
        });

        return $result;
    }

    /**
     * Create a new array using the two given as inputs.
     * All elements of the first one are used without keys.
     * Then another input is added using 'k' and 'v' elements as key and value respectively.
     * 
     * Ex. foo(
     *      ['a' => 'a1', 'b' => 'b1', 'c' => 'c1'],
     *      ['a' => 'a2', 'b' => 'b2', 'k' => 'k2', 'v' => 'v2']
     *     )
     *      should return
     *      [ 'a1', 'b1', 'c1', 'k2' => 'v2' ]
     * 
     * @param mixed[] $array1
     * @param mixed[] $array2
     *
     * @return mixed[] transformed array
     * 
     * @TODO : we should test `array_key_exists` on $array2 with 'k' and 'v' before to use them.
     *      But we need to define expected behavior if they don't exist before implementing anyting.
     */
    public static function foo(array $array1, array $array2): array
    {
        return [...$array1, $array2['k'] => $array2['v']];
    }

    /**
     * Returns true if $array2 doesn't use any key already used in $array1  
     * 
     * @param mixed[] $array1
     * @param mixed[] $array2
     *
     * @return bool
     */
    public static function bar(array $array1, array $array2): bool
    {
        $r = array_filter(array_keys($array1), fn ($k) => !in_array($k, $array2));

        return count($r) == 0;
    }
}
