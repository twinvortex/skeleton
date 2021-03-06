<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Vortex\Config\Config;

class DBExportCommand extends Command {

	private $config;

	protected function configure() {
		$this
			->setName('db:export')
			->setDescription('Export Database')
			->addArgument('file', InputArgument::REQUIRED, 'The database file where you want to save the db');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$file = $input->getArgument('file');

		// Get database configuration so we can export the database
		$this->config = new Config();
		$stage        = $this->config->get('stage');
		$dbUser       = $this->config->get($stage, 'username');
		$dbPass       = $this->config->get($stage, 'password');
		$dbName       = $this->config->get($stage, 'database');

		if ($file) {
			$file = $this->config->get('dbs_path') . '/' . $file . '.sql';
			$output->writeln('<info>Writing database to ' . $file . '</info>');

			$process = new Process('mysqldump -u"' . $dbUser . '" -p"' . $dbPass . '" ' . $dbName . ' > ' . $file);
			$process->run();

			// Export sql file for codeceptions in /tests
			$dumpLocation = $this->config->get('main_path') . '/tests/_data/';
			if (is_dir($dumpLocation)) {
				$process = new Process('mysqldump -u"' . $dbUser . '" -p"' . $dbPass . '" ' . $dbName . ' > ' . $dumpLocation . 'dump.sql');
				$process->run();
				$output->writeln('<info>Exported database for tests in ' . $dumpLocation . 'dump.sql</info>');
			}

			if ( ! $process->isSuccessful()) {
				throw new \RuntimeException($process->getErrorOutput());
			}

			$output->writeln($process->getOutput());
		}
	}

}
