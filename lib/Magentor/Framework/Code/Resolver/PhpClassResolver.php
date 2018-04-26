<?php

namespace Magentor\Framework\Code\Resolver;


class PhpClassResolver implements PhpClassInterface
{

    /** @var array */
    protected $parts = [];

    /** @var string */
    protected $vendor;

    /** @var string */
    protected $package;

    /** @var string */
    protected $namespace;

    /** @var string */
    protected $className;

    /** @var string */
    protected $classPath;

    /** @var string */
    protected $fullClassName;


    /**
     * PhpClassInterface constructor.
     *
     * @param string $class
     */
    public function __construct(string $class = null)
    {
        if (!empty($class)) {
            $this->renew($class);
        }
    }


    /**
     * @param string $class
     *
     * @return $this
     */
    public function renew(string $class)
    {
        $this->buildParts($class);
        return $this;
    }


    /**
     * @return string
     */
    public function getNamespace() : string
    {
        return $this->namespace;
    }


    /**
     * @return string
     */
    public function getClassName() : string
    {
        return $this->className;
    }


    /**
     * @return string
     */
    public function getClassPath() : string
    {
        return $this->classPath;
    }


    /**
     * @return string
     */
    public function getFullClassName($absolute = false, $append = false) : string
    {
        $fullClassName = implode(BS, $this->getParts());
        
        if (true === $absolute) {
            $fullClassName = BS . $fullClassName;
        }
        
        if (true === $append) {
            $fullClassName .= '::class';
        }
        
        return $fullClassName;
    }


    /**
     * @return string
     */
    public function getVendor() : string
    {
        return $this->vendor;
    }


    /**
     * @return string
     */
    public function getPackage() : string
    {
        return $this->package;
    }


    /**
     * @return array
     */
    public function getParts() : array
    {
        $this->buildParts();
        return $this->parts;
    }
    
    
    /**
     * @param string $vendor
     *
     * @return $this
     */
    public function setVendor(string $vendor)
    {
        $this->vendor = $vendor;
        $this->buildParts();
        return $this;
    }
    
    
    /**
     * @param string $package
     *
     * @return $this
     */
    public function setPackage(string $package)
    {
        $this->package = $package;
        $this->buildParts();
        return $this;
    }
    
    
    /**
     * @param string $className
     *
     * @return $this
     */
    public function setClassName(string $className)
    {
        $this->className = $className;
        $this->buildParts();
        return $this;
    }
    
    
    /**
     * @param string|null $class
     *
     * @return $this
     */
    protected function rebuild(string $class = null)
    {
        $class = $this->clearClassString($class);
    
        /** @var array $parts */
        $parts = explode(BS, $class);
        
        $this->vendor    = array_shift($parts);
        $this->package   = array_shift($parts);
        $this->className = array_pop($parts);
        
        $this->classPath = $this->joinClass($parts);
        
        $this->namespace = $this->joinClass([
            $this->vendor,
            $this->package,
            $this->classPath
        ]);
        
        return $this;
    }
    
    
    /**
     * @return $this
     */
    protected function buildParts(string $class = null)
    {
        if (!empty($class)) {
            $this->rebuild($class);
        }
        
        $fullClass = $this->joinClass([
            $this->vendor,
            $this->package,
            $this->classPath,
            $this->className,
        ]);
    
        $this->parts = [];
    
        foreach (explode(BS, $fullClass) as $part) {
            $part = $this->clearClassString($part);
        
            if (empty($part)) {
                continue;
            }
    
            $this->parts[] = $part;
        }
        
        return $this;
    }


    /**
     * @param string $class
     *
     * @return string
     */
    protected function clearClassString(string $class) : string
    {
        $class = str_replace('.php', null, $class);
        $class = trim(trim($class), '/\\');
        $class = str_replace('/', BS, $class);

        return $class;
    }
    
    
    /**
     * @param array $parts
     *
     * @return string
     */
    protected function joinClass(array $parts)
    {
        foreach ($parts as $key => $value) {
            if (!empty($value)) {
                continue;
            }
            
            unset($parts[$key]);
        }
        
        return implode(BS, $parts);
    }
}
