<?php

namespace Jejookit\Generator\Commands\Scaffold;

use Jejookit\Generator\Commands\BaseCommand;
use Jejookit\Generator\Generators\Scaffold\RequestGenerator;

class RequestsGeneratorCommand extends BaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'Jejookit.scaffold:requests';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a full CRUD views for given model';

    public function handle()
    {
        parent::handle();

        /** @var RequestGenerator $requestGenerator */
        $requestGenerator = app(RequestGenerator::class);
        $requestGenerator->generate();

        $this->performPostActions();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return array_merge(parent::getOptions(), []);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array_merge(parent::getArguments(), []);
    }
}
