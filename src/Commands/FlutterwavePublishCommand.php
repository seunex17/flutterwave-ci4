<?php

declare(strict_types=1);
/**
     * Copyright (C) ZubDev Digital Media - All Rights Reserved
     *
     * File: FlutterwavePublishCommand.php
     * Author: Zubayr Ganiyu
     *   Email: <seunexseun@gmail.com>
     *   Website: https://zubdev.net
     * Date: 10/4/24
     * Time: 7:42 AM
     */

namespace Seunex17\FlutterwaveCi4\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Autoload;

class FlutterwavePublishCommand extends BaseCommand
{
    /**
     * The group the command is lumped under
     * when listing commands.
     *
     * @var string
     */
    protected $group = 'Flutterwave';

    /**
     * The Command's name
     *
     * @var string
     */
    protected $name = 'flutterwave:publish';

    /**
     * the Command's usage description
     *
     * @var string
     */
    protected $usage = 'flutterwave:publish';

    /**
     * the Command's short description
     *
     * @var string
     */
    protected $description = 'Publish flutterwave functionality into the current application.';

    /**
     * the Command's options description
     *
     * @var array
     */
    protected $options = [
        '-f' => 'Force overwrite all existing files in destination',
    ];

    protected string $sourcePath;

    /**
     * {@inheritDoc}
     */
    public function run(array $params): void
    {
        $this->determineSourcePath();

        $this->publishConfig();
    }

    /**
     * Publish config auth.
     *
     * @return mixed
     */
    protected function publishConfig()
    {
        $path = "{$this->sourcePath}/Config/Flutterwave.php";

        $content = file_get_contents($path);
        $content = str_replace('namespace Seunex17\FlutterwaveCi4\Config', 'namespace Config', $content);
        $content = str_replace("use CodeIgniter\\Config\\BaseConfig;\n", '', $content);
        $content = str_replace('extends BaseConfig', 'extends \\Seunex17\\FlutterwaveCi4\\Config\\Flutterwave', $content);

        $namespace = defined('APP_NAMESPACE') ? APP_NAMESPACE : 'App';

        $this->writeFile('Config/Flutterwave.php', $content);
    }

    /**
     * Determines the current source path from which all other files are located.
     *
     * @return void
     */
    protected function determineSourcePath(): void
    {
        $this->sourcePath = realpath(__DIR__ . '/../');

        if ($this->sourcePath === '/' || empty($this->sourcePath)) {
            CLI::error('Unable to determine the correct source directory. Bailing.');

            exit();
        }
    }

    /**
     * Write a file, catching any exceptions and showing a
     * nicely formatted error.
     *
     * @return void
     */
    protected function writeFile(string $path, string $content): void
    {
        $config  = new Autoload();
        $appPath = $config->psr4[APP_NAMESPACE];

        $filename  = $appPath . $path;
        $directory = dirname($filename);

        if (! is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        if (file_exists($filename)) {
            $overwrite = (bool) CLI::getOption('f');

            if (! $overwrite && CLI::prompt("File '{$path}' already exists in destination. Overwrite?", ['n', 'y']) === 'n') {
                CLI::error("Skipped {$path}. If you wish to overwrite, please use the '-f' option or reply 'y' to the prompt.");

                return;
            }
        }

        if (write_file($filename, $content)) {
            CLI::write(CLI::color('Created: ', 'green') . $path);
        } else {
            CLI::error("Error creating {$path}.");
        }
    }
}
