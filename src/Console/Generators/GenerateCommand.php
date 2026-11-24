<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Vortex\Config\Config;

class GenerateCommand extends Command {

	private $config;

	protected function configure(): void {
		$this->setName('gen:cmd')
			->setDescription('Generate a command file')
			->addArgument('name', InputArgument::REQUIRED, 'The name of the file');
	}

	protected function execute(InputInterface $input, OutputInterface $output): int {

		$name = $input->getArgument('name');
		$this->config = new Config();

		if (is_dir($this->config->get('command_path'))) {

			$file = $this->config->get('command_path') . '/' . $name . 'Command.php';

			$commandTemp = file_get_contents(__DIR__ . '/temp/command.temp');
			$data = str_replace('{classname}', $name . 'Command', $commandTemp);
			if (file_put_contents($file, $data)) {
				$output->writeln('<info>Command generated: ' . $file . '</info>');
				$consoleFile = $this->config->get('main_path') . '/console.php';
				if ($consoleData = file_get_contents($consoleFile)) {
					$consoleData = str_replace('$app->run();', '$app->addCommand(new ' . $name . 'Command);
$app->run();', $consoleData);
					if (file_put_contents($consoleFile, $consoleData)) {
						$output->writeln('<info>Added new command to console file.</info>');
						return Command::SUCCESS;
					} else {
						$output->writeln('<bg=red>There was an error writing to console file</bg=red>');
						return Command::FAILURE;
					}
				} else {
					$output->writeln('<bg=red>Could not get ' . $consoleFile . '</bg=red>');
					return Command::FAILURE;
				}
			} else {
				$output->writeln('<bg=red>Could not write to file: ' . $file . '</bg=red>');
				return Command::FAILURE;
			}

		} else {
			$output->writeln('<bg=red>Not a valid directory: ' . $this->config->get('command_path') . '</bg=red>');
			return Command::FAILURE;
		}

	}

}
