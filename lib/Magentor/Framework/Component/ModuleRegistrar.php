<?php

namespace Magentor\Framework\Component;

class ModuleRegistrar implements ModuleRegistrarInterface
{

    /** @var array */
    protected static $paths = [
        self::TYPE_MODULES => [],
    ];
    
    /** @var array */
    protected static $commands = [];


    /**
     * @param string $moduleName
     * @param string $path
     * @param array  $commands
     */
    public static function register($moduleName, $path, array $commands = [])
    {
        self::$paths[self::TYPE_MODULES][$moduleName] = str_replace('\\', '/', $path);
        self::registerCommands($moduleName, $commands);
    }


    /**
     * @return array
     */
    public static function getPaths()
    {
        return self::$paths[self::TYPE_MODULES];
    }
    
    
    /**
     * @return array
     */
    public static function getCommands()
    {
        return (array) self::$commands;
    }
    
    
    /**
     * @param string $moduleName
     * @param array  $commands
     */
    protected static function registerCommands($moduleName, array $commands = [])
    {
        foreach ($commands as $class => $options) {
            $commandClass   = $class;
            $commandOptions = (array) $options;
            
            if (!class_exists($class) && class_exists($options)) {
                $commandClass   = $options;
                $commandOptions = [];
            }
        
            $commandOptions['module'] = $moduleName;
        
            self::$commands[] = $commandClass;
        }
    }
}
