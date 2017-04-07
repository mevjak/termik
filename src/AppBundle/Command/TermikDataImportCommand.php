<?php

namespace AppBundle\Command;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Sensor;
use AppBundle\Entity\Record;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TermikDataImportCommand extends ContainerAwareCommand
{
    /** @var  EntityManager */
    private $manager;

    /** @var  RegistryInterface */
    private $registry;

    /** */
    protected function configure()
    {
        $this
            ->setName('termik:data-import')
            ->setDescription('Import CSV data from file');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->registry = $this->getContainer()->get('doctrine');
        $this->manager = $this->registry->getManager();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $finder = new Finder();
        $finder
            ->in($this->getContainer()->getParameter('termik.import.file_path'))
            ->depth('== 0')
            ->name($this->getContainer()->getParameter('termik.import.file_regex'))
            ->sortByName();

        foreach ($finder as $file) {
            $this->importFile($file, $output);
        }
    }

    /**
     * @param SplFileInfo $file
     * @param OutputInterface $output
     */
    private function importFile(SplFileInfo $file, OutputInterface $output)
    {
        $output->writeln(sprintf('Start importing %s', $file->getRealPath()));

        if (($handle = fopen($file->getRealPath(), 'r')) !== false) {
            while (($values = fgetcsv($handle, null, $this->getContainer()
                    ->getParameter('termik.import.file_delimiter'))) !== false) {
                if (!$sensor = $this->registry->getRepository('AppBundle:Sensor')
                    ->findOneBy(['shortname' => $values[0]])
                ) {
                    $sensor = new Sensor();
                    $sensor->setShortname($values[0]);
                    $this->manager->persist($sensor);
                }

                $record = new Record();

                $record->setSensor($sensor);
                $record->setCreatedAt(new \DateTime($values[1]));
                $record->setTemperature($values[2]);
                $this->manager->persist($record);

                $sensor->setLastRecord($record);
                $this->manager->persist($sensor);

                $this->manager->flush();
                $this->manager->clear();
            }
        }

        $output->writeln(sprintf('%s imported', $file->getRealPath()));
    }
}
