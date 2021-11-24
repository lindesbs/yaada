<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ConfigCommand extends Command
{
	protected static $defaultName = 'config';
	protected static $defaultDescription = 'configure your dashboard';

	protected function configure(): void
	{
		$this
			->addArgument('JOB', InputArgument::OPTIONAL, 'Argument description');
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$io = new SymfonyStyle($input, $output);
		$arg1 = $input->getArgument('arg1');

		switch (strtolower($arg1))
		{
			case 'fetchIcons' :
				fetchIcons();
				break;
		}


		$io->success('You have a new command! Now make it your own! Pass --help to see your options.');

		return Command::SUCCESS;
	}


	private function fetchIcons()
	{
		//https://www.google.com/s2/favicons?domain=outlook.office.com
	}
}
