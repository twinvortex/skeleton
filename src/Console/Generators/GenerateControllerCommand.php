<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Vortex\Config\Config;

class GenerateControllerCommand extends Command {

	private $config;

	protected function configure(): void {
		$this->setName('gen:ctrl')
			->setDescription('Generate Controller + Model files')
			->addArgument('name', InputArgument::REQUIRED, 'The name of the controller file');
	}

	protected function execute(InputInterface $input, OutputInterface $output): int {

		$name = $input->getArgument('name');
		$this->config = new Config();

		// Open generators
		$ctrlTemp = file_get_contents(__DIR__ . '/temp/controller.temp');
		$modelTemp = file_get_contents(__DIR__ . '/temp/model.temp');

		$ctrlTemp = str_replace('{classname}', $name . 'Controller', $ctrlTemp);
		$modelTemp = str_replace('{classname}', $name, $modelTemp);

		$ctrlFile = $this->config->get('controllers_path') . '/' . $name . 'Controller.php';
		$modelFile = $this->config->get('models_path') . '/' . $name . '.php';

		if (file_exists($ctrlFile)) {
			$output->writeln('<bg=red>A controller with this name: ' . $ctrlFile . ' already exists</bg=red>');
			return Command::FAILURE;
		}

		if (file_exists($modelFile)) {
			$output->writeln('<bg=red>A Model with this name: ' . $name . '.php already exists</bg=red>');
			return Command::FAILURE;
		}

		file_put_contents($ctrlFile, $ctrlTemp);
		file_put_contents($modelFile, $modelTemp);

		$output->writeln('<info>Controller: ' . $ctrlFile . ' created!</info>');
		$output->writeln('<info>Model: ' . $modelFile . ' created!</info>');

		return Command::SUCCESS;
	}

}
