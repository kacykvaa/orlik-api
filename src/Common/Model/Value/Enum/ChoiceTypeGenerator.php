<?php
declare(strict_types=1);

namespace App\Common\Model\Value\Enum;


use MyCLabs\Enum\Enum;

class ChoiceTypeGenerator
{
    /**
     * @throws \Exception
     */
    public static function generate(string $fqcn): array
    {
        if(!is_a($fqcn, Enum::class, true)){
            throw new \Exception('You need to pass subclass of '. Enum::class);
        }

        $values = $fqcn::values();

        $choices = [];
        foreach($values as $value) {
            $choices[(string) $value] = (string) $value;
        }

        return $choices;
    }
}