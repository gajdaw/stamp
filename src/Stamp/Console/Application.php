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
use Stamp\Console\Command\PatchUpCommand;

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
    public function __construct($version = '0.1-dev')
    {
        parent::__construct('stamp', $version);

        $this->add(new PatchUpCommand());
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
        $paths = array('stamp.yml','stamp.yml.dist');

        if ($customPath = $input->getParameterOption(array('-c','--config'))) {
            if (!file_exists($customPath)) {
                throw new RuntimeException('Custom configuration file not found at '.$customPath);
            }
            $paths = array($customPath);
        }

        $config = array();
        foreach ($paths as $path) {
            if ($path && file_exists($path) && $parsedConfig = Yaml::parse(file_get_contents($path))) {
                $config = $parsedConfig;
                break;
            }
        }

        if ($homeFolder = getenv('HOME')) {
            $localPath = $homeFolder.'/.stamp.yml';
            if (file_exists($localPath) && $parsedConfig = Yaml::parse(file_get_contents($localPath))) {
                $config = array_replace_recursive($parsedConfig, $config);
            }
        }

        return $config;
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
