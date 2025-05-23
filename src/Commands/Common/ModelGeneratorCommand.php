<?php

namespace Jejookit\Generator\Commands\Common;

use Jejookit\Generator\Commands\BaseCommand;
use Jejookit\Generator\Generators\ModelGenerator;

class ModelGeneratorCommand extends BaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'Jejookit:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create model command';

    public function handle()
    {
        parent::handle();

        /** @var ModelGenerator $modelGenerator */
        $modelGenerator = app(ModelGenerator::class);
        $modelGenerator->generate();

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
