<?php

namespace ScratchPad\Logger;

class MemoryLogger implements LoggerInterface
{
    use LoggerImpl;

    public $logs = [];

    public function log(array $message, array $option = [])
    {
        $this->logs[] = $message;
    }
}