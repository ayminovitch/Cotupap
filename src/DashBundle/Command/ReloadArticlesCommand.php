<?php


namespace DashBundle\Command;


use DashBundle\Service\CronArticlesReload;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ReloadArticlesCommand extends Command
{
    private $reloadArticles;
//    protected static $defaultName = 'webside:reload-articles';

    protected function configure()
    {
        $this->setDescription('Reload Articles List From Cotupap SOAP Webservice.')
            ->setHelp('This command allow you to reload Articles List from Cotupap webservice and save them to localstorage in xml file...');
    }
//    private $container;
//    public function __construct(ContainerInterface $container)
//    {
//        $this->container = $container;
//        parent::__construct();
//    }
//    public function __construct()
//    {
//        $reloadArticles = new CronArticlesReload();
//        $this->reloadArticles = $reloadArticles;
//        parent::__construct();
//    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
//        $test = $this->get(CronArticlesReload::class);
        $output->writeln([
            'The Webside',
            '===========',
            'Downloading Articles from 41.224.242.16:8080',
            '============================================',
        ]);
    }

}