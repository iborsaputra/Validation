<?php

namespace Respect\Validation\Rules;

use Respect\Validation\Exceptions\ComponentException;

class Alpha extends AbstractRule
{

    public $additionalChars = "\n\r\t ";
    protected $ctype_func = 'ctype_alpha';

    public function __construct($additionalChars='')
    {
        if (!is_string($additionalChars)) {
            throw new ComponentException('Invalid list of additional characters to be loaded');
        }
        $this->additionalChars .= $additionalChars;
    }

    public function validate($input)
    {
        if (!is_scalar($input)) {
            return false;
        }

        $input = (string) $input;
        $cleanInput = str_replace(str_split($this->additionalChars), '', $input);

        return ($cleanInput !== $input && $cleanInput === '')
               || call_user_func($this->ctype_func, $cleanInput)
               || $cleanInput === '';
    }

}
