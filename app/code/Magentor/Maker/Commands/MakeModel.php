<?php

namespace Magentor\Maker\Commands;

use Magentor\Framework\Code\Generation\MagentoTwo\Module\Model;
use Magentor\Framework\Code\Generation\MagentoTwo\ModuleComponentBuilder;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeModel extends CommandAbstract
{

    protected $name        = 'make:model';
    protected $description = 'Creates a Magento model for a given module.';
    
    
    /**
     * @return array
     */
    protected function getOptions()
    {
        return [
            'create-resources' => [
                'shortcut'    => 'r',
                'description' => "Create the resources with the model.",
            ]
        ];
    }


    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $vendor = $input->getArgument('vendor');
            $module = $input->getArgument('module');
            $name   = $input->getArgument('name');
    
            /** @var Model $builder */
            $builder = ModuleComponentBuilder::buildModel($name, $module, $vendor);
            
            $output->writeln('Model was created!');
    
            $resourceClass = null;
            $withResources = $input->getOption('create-resources');
            
            if (true === $withResources) {
                $resourceClass = $this->buildResourceModel()
                                      ->classResolver()
                                      ->getFullClassName(true, true);
                
                $this->buildResourceCollection(
                    $builder->classResolver()->getFullClassName(true, true),
                    $resourceClass
                );
            }
    
            $builder->buildDefaultMethod($resourceClass);
    
            $builder->write();
        } catch (\Exception $e) {
            $output->writeln(['Error', $e->getMessage()]);
            return;
        }
    }
    
    
    /**
     * @param string $name
     * @param string $module
     * @param string $vendor
     *
     * @return \Magentor\Framework\Code\Generation\MagentoTwo\Module\AbstractModulePhp
     *
     * @throws \Magentor\Framework\Exception\GenericException
     */
    protected function getBuilder(string $name, string $module, string $vendor)
    {
        return ModuleComponentBuilder::build($this->builder, [$name, $module, $vendor]);
    }
    
    
    /**
     * @throws \Magentor\Framework\Exception\GenericException
     */
    protected function buildResourceModel()
    {
        $vendor = $this->getArgument('vendor');
        $module = $this->getArgument('module');
        $name   = $this->getArgument('name');
        
        $builder  = ModuleComponentBuilder::buildResourceModel($name, $module, $vendor);
        $builder->buildDefaultMethod();
        
        $builder->write();
        
        return $builder;
    }
    
    
    /**
     * @return \Magentor\Framework\Code\Generation\MagentoTwo\Module\ResourceCollection
     * @throws \Magentor\Framework\Exception\GenericException
     */
    protected function buildResourceCollection(string $modelClass = null, string $resourceModelClass = null)
    {
        $vendor = $this->getArgument('vendor');
        $module = $this->getArgument('module');
        $name   = $this->getArgument('name') . DS . 'Collection';
    
        $builder  = ModuleComponentBuilder::buildResourceCollection($name, $module, $vendor);
        $builder->buildDefaultMethod($modelClass, $resourceModelClass);
        $builder->write();
        
        return $builder;
    }
}
