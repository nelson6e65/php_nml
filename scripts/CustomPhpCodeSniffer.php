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

        $ignoredPaths = [];

        if ($count > 0) {
            $event->getIO()->write("Checking PHP Coding Standard of ${count} paths.");

            foreach ($files as $i => $file) {
                $realPath = realpath($file);

                if (!$realPath) {
                    $ignoredPaths[] = $file;
                    continue;
                }

                if ($realPath === realpath(__FILE__)) {
                    // Do not self-fix this file
                    continue;
                }

                $relativePath =  str_replace(
                    [$rootDir . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR],
                    ['', '/'],
                    $realPath
                );

                $type = strlen($relativePath) < 4 || stripos($relativePath, '.php', -4) === false ? 'directory' : 'file';

                $event->getIO()->write("Improving <info>${relativePath}</info> ${type}...");

                $output = [];
                $return = 0;

                // NOTE: workarround: need to run 2 times due to a bug that exits 1 instead of 0 when a file gets fixed
                exec("${cmd} \"${realPath}\" || ${cmd} \"${realPath}\" -q", $output, $return);

                $event->getIO()->write($output, true, IOInterface::VERBOSE);

                if ($return !== 0) {
                    $event->getIO()->error("Error! Unable to autofix the ${relativePath} file!");
                    $event->getIO()->write('<comment>Run <options=bold>`composer cs:lint`</> to check manually the conflicting files</comment>');
                    exit(1);
                }
            }
        }

        $event->getIO()->write('<info>Everything is awesome!</info>');

        $end_time       = microtime(true);
        $execution_time = round($end_time - $start_time, 2);

        $event->getIO()->write("Done in ${execution_time}s");

        if (count($ignoredPaths)) {
            $ignoredPaths = array_map(function ($item) {
                return '  - ' . $item;
            }, $ignoredPaths);

            $event->getIO()->write('<comment>Note: Some paths were not found:</comment>');
            $event->getIO()->write($ignoredPaths);
        }
    }
}
