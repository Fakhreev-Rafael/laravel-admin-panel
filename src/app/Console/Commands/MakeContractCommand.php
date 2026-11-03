<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeContractCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:contract {name : Name of the contract}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new contract';

    /**
     * The filesystem manager.
     * 
     * @var \Illuminatet\Filesystem\Filesystem $filesystem
     */
    protected Filesystem $filesystem;

    /**
     * 
     */
    public function __construct(FileSystem $filesystem)
    {
        parent::__construct();
        $this->filesystem = $filesystem;
    }

    /**
     * Return the handled path.
     * 
     * @param string $name
     * 
     * @return string
     */
    protected function getPath(string $name): string
    {
        $path = str_replace('\\', '/', $name);
        return app_path("Contracts/{$path}Interface.php");
    }

    /**
     * Return the namespace.
     * 
     * @param string $name
     * 
     * @return string
     */
    protected function getNamespace(string $name): string
    {
        $parts = explode('/', $name);
        array_pop($parts);
        
        $namespace = 'App\\Contracts';
        if (!empty($parts)) {
            $namespace .= '\\' . implode('\\', $parts);
        }
        
        return $namespace;
    }

    /**
     * Return the class name.
     * 
     * @param string $name
     * 
     * @return string
     */
    protected function getClassName(string $name): string
    {
        $parts = explode('/', $name);
        return end($parts) . 'Interface';
    }

    /**
     * Make a new directory.
     * 
     * @param string $path
     * 
     * @return void
     */
    protected function makeDirectory(string $path): void
    {
        if (!$this->filesystem->isDirectory(dirname($path))) {
            $this->filesystem->makeDirectory(dirname($path), 0755, true);
            $this->line("The directory was created: " . dirname($path));
        }
    }

    /**
     * Return the content of the stub.
     * 
     * @return string
     */
    protected function getStubContent(): string
    {        
        $localStub = base_path('app/Console/stubs/contract.interface.stub');
        $this->line("Using a local stub: {$localStub}");
        return $this->filesystem->get($localStub);
    }

    /**
     * Replace placeholders in the stub.
     * 
     * @param string $stub
     * @param string $name
     * 
     * @return string
     */
    protected function replacePlaceholders(string $stub, string $name): string
    {
        $namespace = $this->getNamespace($name);
        $className = $this->getClassName($name);

        // $this->line($namespace);
        $this->line($className);
        
        $replacements = [
            'DummyNamespace' => $namespace,
            'DummyInterface' => $className,
        ];
        
        return str_replace(
            array_keys($replacements),
            array_values($replacements),
            $stub
        );
    }

    /**
     * Execute the console command.
     * 
     * @return int
     */
    public function handle(): int
    {
        $name = $this->argument('name');

        $path = $this->getPath($name);

        if ($this->filesystem->exists($path)) {
            $this->error("Contract {$name} already exists by path: {$path}");
            return self::FAILURE;
        }

        try {
            $this->makeDirectory($path);

            $stub = $this->getStubContent();

            $content = $this->replacePlaceholders($stub, $name);

            $this->filesystem->put($path, $content);

            $this->info("✓ Contract {$name}Interface was created successfully!");
            $this->line("  Path is: {$path}");

            return self::SUCCESS;


        } catch (\Exception $e) {
            $this->error("Error creating contract: {$e->getMessage()}");
            return self::FAILURE;
        }
        
        return 0;
    }
}
