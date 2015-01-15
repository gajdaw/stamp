<?php

namespace Stamp\Console;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Stamp\Console\Command\RawRunCommand;
use Stamp\Console\Command\PatchUpCommand;
use Stamp\Console\Command\MinorUpCommand;
use Stamp\Console\Command\MajorUpCommand;
use RuntimeException;
use Stamp\Version;

/**
 * The command line application entry point
 */
class Application extends BaseApplication
{

    private $config;
    private $container;

    /**
     * @param string $version
     */
    public function __construct()
    {
        parent::__construct('stamp', Version::VERSION);

        $this->add(new RawRunCommand());
        $this->add(new PatchUpCommand());
        $this->add(new MinorUpCommand());
        $this->add(new MajorUpCommand());
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    public function doRun(InputInterface $input, OutputInterface $output)
    {
        $this->config = $this->parseConfigurationFile($input);

        $this->container = new ContainerBuilder();
        $loader = new YamlFileLoader($this->container, new FileLocator(__DIR__ . '/../Resources'));
        $loader->load('services.yml');

        return parent::doRun($input, $output);
    }

    /**
     * @param InputInterface $input
     *
     * @return array
     *
     * @throws \RuntimeException
     */
    protected function parseConfigurationFile(InputInterface $input)
    {
        $paths = array('stamp.yml', 'stamp.yml.dist');

        if ($customPath = $input->getParameterOption(array('-c', '--config'))) {
            if (!file_exists($customPath)) {
                throw new RuntimeException('Custom configuration file not found at ' . $customPath);
            }
            $paths = array($customPath);
        }

        foreach ($paths as $path) {
            if ($path && file_exists($path) && $parsedConfig = Yaml::parse(file_get_contents($path))) {
                return $parsedConfig;
            }
        }

        return null;
    }

    /**
     * @return ServiceContainer
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

}
