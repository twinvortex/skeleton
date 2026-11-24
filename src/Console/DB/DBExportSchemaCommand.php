<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Vortex\Config\Config;

class DBExportSchemaCommand extends Command {

	private $config;

	protected function configure(): void {
		$this
			->setName('db:export-schema')
			->setDescription('Export Database Schema')
			->addArgument('file', InputArgument::REQUIRED, 'The database file where you want to save the db schema');
	}

	protected function execute(InputInterface $input, OutputInterface $output): int {
		$file = $input->getArgument('file');

		// Get database configuration so we can export the database
		$this->config = new Config();
		$stage        = $this->config->get('stage');

		$dbUser = $this->config->get($stage, 'username');
		$dbPass = $this->config->get($stage, 'password');
		$dbName = $this->config->get($stage, 'database');

		if ($file) {
			$file = $this->config->get('dbs_path') . '/' . $file . '-schema.sql';
			$output->writeln('<info>Writing database to ' . $file . '</info>');

			$env     = $dbPass !== '' ? ['MYSQL_PWD' => $dbPass] : null;
			$process = new Process(['mysqldump', '--no-data', '-u' . $dbUser, $dbName], null, $env);
			$process->run();

			if ( ! $process->isSuccessful()) {
				throw new \RuntimeException($process->getErrorOutput());
			}

			file_put_contents($file, $process->getOutput());
		}

		return Command::SUCCESS;
	}

}
