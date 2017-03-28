<?php
namespace MainBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;


class MagicCommand extends Command
{

    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('magic')
            // the short description shown while running "php bin/console list"
            ->setDescription('Creates a new user.')
            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to create a user...');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(
            [
                'Used commands',
                "",
                "<fg=cyan;bg=black>$ php bin/console doctrine:database:drop --force</>",
                "<fg=cyan;bg=black>$ php bin/console doctrine:generate:entities MainBundle</>",
                "<fg=cyan;bg=black>$ php bin/console doctrine:schema:update --force</>",
                "<fg=cyan;bg=black>$ php bin/console doctrine:fixtures:load</>",
            ]
        );

        //doctrine:schema:drop --force
        $databaseDropCommand = $this->getApplication()->find('doctrine:schema:drop');
        $databaseDropArguments = [
            'command' => 'doctrine:schema:drop',
            '--force' => true,
        ];

        $databaseDropInput = new ArrayInput($databaseDropArguments);
        $databaseDropCommand->run($databaseDropInput, $output);


        //doctrine:generate:entities MainBundle
        $databaseDropCommand = $this->getApplication()->find('doctrine:generate:entities');
        $databaseDropArguments = [
            'command' => 'doctrine:generate:entities',
            'name' => 'MainBundle',
        ];

        $databaseDropInput = new ArrayInput($databaseDropArguments);
        $databaseDropCommand->run($databaseDropInput, $output);


        //doctrine:schema:update --force
        $databaseDropCommand = $this->getApplication()->find('doctrine:schema:update');
        $databaseDropArguments = [
            'command' => 'doctrine:schema:update',
            '--force' => true,
        ];

        $databaseDropInput = new ArrayInput($databaseDropArguments);
        $databaseDropCommand->run($databaseDropInput, $output);


        //doctrine:fixtures:load
        $databaseDropCommand = $this->getApplication()->find('doctrine:fixtures:load');
        $databaseDropArguments = [
            'command' => 'doctrine:fixtures:load',
        ];

        $databaseDropInput = new ArrayInput($databaseDropArguments);
        $databaseDropCommand->run($databaseDropInput, $output);
    }
}
