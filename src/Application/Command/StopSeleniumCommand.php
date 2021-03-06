<?php

namespace BeubiQA\Application\Command;

use BeubiQA\Application\Selenium\SeleniumHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class StopSeleniumCommand extends Command
{
    /** @var SeleniumHandler  */
    protected $seleniumHandler;

    /**
     * @param SeleniumHandler $seleniumHandler
     */
    public function __construct(SeleniumHandler $seleniumHandler)
    {
        $this->seleniumHandler = $seleniumHandler;
        parent::__construct('start');
    }

    protected function configure()
    {
        $this
        ->setName('stop')
        ->addOption(
            'timeout',
            't',
            InputOption::VALUE_REQUIRED,
            'Set how much you are willing to wait until selenium server is stopped (in seconds)',
            30
        )
        ->addOption(
            'port',
            'p',
            InputOption::VALUE_REQUIRED,
            'Set how much you are willing to wait until selenium server is stopped (in seconds)',
            4444
        )
        ->setDescription('Stops selenium server');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setStopperOptionsFromInput($input);
        $this->seleniumHandler->stop();
        $output->writeln(PHP_EOL, true);
        $output->writeln("\nDone");
    }

    /**
     * @param InputInterface $input
     */
    private function setStopperOptionsFromInput(InputInterface $input)
    {
        $stopper = $this->seleniumHandler->getStopper();
        $stopper->getStopOptions()->setSeleniumPort($input->getOption('port'));
        $stopper->getResponseWaitter()->setTimeout($input->getOption('timeout'));
    }
}
