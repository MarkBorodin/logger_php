<?php

namespace App;

class Formater implements FormaterInterface
{
    public function format($level, $message, array $context): string
    {
        $data = '[' . date("Y-m-d H:i:s:v") . ']' . '[' . $level . ']' . '[' . $message . ']';
        $data .= json_encode($context);
        return $data;
    }
}