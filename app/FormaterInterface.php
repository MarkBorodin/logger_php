<?php

namespace App;

interface FormaterInterface
{
    public function format($level, $message, array $context): string;
}