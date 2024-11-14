<?php

namespace rkvcs\cmspp;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

use function Termwind\render;

class Input
{
    public static function ask(string $question)
    {
        render('<div class="my-1 px-1 bg-green-300">Hello!</div>');

        $process = new Process(['ls', '-lsa']);
        $process->run();

        // executes after the command finishes
        if (! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();

        // ---

        $process = new Process(['composer', '-V']);
        $process->run();
        echo $process->getOutput();
    }
}
