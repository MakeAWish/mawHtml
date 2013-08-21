<?php

namespace Sch\WlBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Nelmio\Alice\ORM\Doctrine;
use Nelmio\Alice\Loader\Yaml;

class AliceLoadFakersCommand  extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('wl:fakers:load')
            ->setDescription('Load fixtures');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $bundles = $this->getContainer()->getParameter('kernel.bundles');

        $persister = new Doctrine($this->getContainer()->get('doctrine')->getManager());

        $loader = new Yaml('fr_FR', array($this));
        foreach ($bundles as $bundle) {
            $path = $this->getBundleDir($bundle);
            $fixturePath = $path . '/Resources/data/fakers.yml';
            if (file_exists($fixturePath)) {
                $output->writeln('import data from ' . $fixturePath);

                $objects = $loader->load($fixturePath);
                $persister->persist($objects);
            }
        }
    }

    public function choiceOne($array)
    {
        return $array[array_rand($array)];
    }

    public function uniqueKey()
    {
        return md5(rand(1000, 99999) . time());
    }

    private function getBundleDir($bundle)
    {
        $reflector = new \ReflectionClass($bundle);

        return dirname($reflector->getFileName());
    }
}