<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Vortex\Config\Config;

class DBImportCommand extends Command {

	private $config;

	protected function configure(): void {
		$this
			->setName('db:import')
			->setDescription('Import Database')
			->addArgument('file', InputArgument::REQUIRED, 'Import database from file.');
	}

	protected function execute(InputInterface $input, OutputInterface $output): int {
		$file = $input->getArgument('file');

		// Get database configuration so we can import the database
		$this->config = new Config();
		$stage        = $this->config->get('stage');

		$dbUser = $this->config->get($stage, 'username');
		$dbPass = $this->config->get($stage, 'password');
		$dbName = $this->config->get($stage, 'database');

		if ($file) {
			$file = $this->config->get('dbs_path') . '/' . $file . '.sql';
			if ( ! is_readable($file)) {
				$output->writeln('<error>Database file not readable: ' . $file . '</error>');
				return Command::FAILURE;
			}

			$output->writeln('<info>Importing database from ' . $file . ' to DB: ' . $dbName . '</info>');

			$env    = $dbPass !== '' ? ['MYSQL_PWD' => $dbPass] : null;
			$handle = fopen($file, 'rb');
			try {
				$process = new Process(['mysql', '-u' . $dbUser, $dbName], null, $env);
				$process->setInput($handle);
				$process->run();
			} finally {
				if (is_resource($handle)) {
					fclose($handle);
				}
			}

			if ( ! $process->isSuccessful()) {
				throw new \RuntimeException($process->getErrorOutput());
			}

			$output->writeln($process->getOutput());
		}

		return Command::SUCCESS;
	}

}
