<?php

declare(strict_types=1);

namespace NelsonMartell\Scripts;

use Composer\IO\IOInterface;
use Composer\Script\Event;

/**
 *
 *
 */
class CustomPhpCodeSniffer
{
    /**
     * Custom PHP Code Sniffer Fixer to be run with lint-staged pre-commit hook.
     *
     * Note: This should not run on this file to avoid replacements issues.
     *
     * @param Event $event
     */
    public static function fix(Event $event): void
    {
        $start_time = microtime(true);

        $rootDir = realpath(__DIR__ . '/..');

        $cmd = str_replace($rootDir . DIRECTORY_SEPARATOR, '', realpath($rootDir . '/vendor/bin/phpcbf'));

        $files = $event->getArguments();
        $count = count($files);

        if ($count > 0) {
            $event->getIO()->write('<options=bold>Checking Coding Standard of PHP files</>.');

            $output = [];
            $return = 0;

            foreach ($files as $i => $file) {
                $realPath = realpath($file);

                if ($realPath === realpath(__FILE__)) {
                    // Do not self-fix this file
                    continue;
                }

                $relativeFile =  str_replace($rootDir . DIRECTORY_SEPARATOR, '', $realPath);
                $relativeFile =  str_replace(DIRECTORY_SEPARATOR, '/', $relativeFile);

                $type = stripos($relativeFile, '.php', -4) === false ? 'directory' : 'file';

                $event->getIO()->write("Improving <options=bold>${relativeFile}</> ${type}...");

                // NOTE: workarround: need to run 2 times due to a bug that exits 1 instead of 0 when a file gets fixed
                exec("${cmd} \"${relativeFile}\" || ${cmd} \"${relativeFile}\" -q", $output, $return);

                $event->getIO()->write($output, true, IOInterface::VERBOSE);

                if ($return !== 0) {
                    $event->getIO()->error("Error! Unable to autofix the ${relativeFile} file!");
                    $event->getIO()->write('Run `composer cs:lint` to check manually the conflicting files');
                    exit(1);
                }
            }
        }

        $event->getIO()->write('<info>Everything is awesome!</info>');

        $end_time       = microtime(true);
        $execution_time = round($end_time - $start_time, 2);

        $event->getIO()->write("Done in ${execution_time}s");
    }
}
