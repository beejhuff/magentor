<?php

namespace Magentor\Framework\Code\Template\Xml\Config;

use Magentor\Framework\Code\Template\Xml\XmlAbstract;
use Magentor\Framework\Code\Template\Xml\XmlElement;

class Acl extends XmlAbstract
{
    
    /** @var string */
    protected $schemaLocation = 'urn:magento:framework:Acl/etc/acl.xsd';
    
    /** @var XmlElement */
    protected $aclXml = null;
    
    /** @var XmlElement */
    protected $resourcesXml = null;
    
    /** @var array */
    protected $sequencesCache = [];
    
    
    /**
     * Module constructor.
     *
     * @param string      $module
     * @param string      $vendor
     * @param string|null $setupVersion
     */
    public function __construct(string $module, string $vendor, array $resources = [])
    {
        parent::__construct($module, $vendor);
    }
    
    
    /**
     * @param string      $code
     * @param string|null $title
     * @param int         $sortOrder
     *
     * @return \SimpleXMLElement
     */
    public function addResource(string $code, string $title = null, int $sortOrder = 10)
    {
        /** @var \SimpleXMLElement $resource */
        $resource = $this->resourcesXml->addChild($this->buildResourceCode($code));
        $resource->addAttribute('title', $title ?: $code);
        $resource->addAttribute('sortOrder', (int) $sortOrder);
        
        return $resource;
    }
    
    
    /**
     * @param string $code
     *
     * @return string
     */
    protected function buildResourceCode(string $code)
    {
        $moduleName = $this->getModuleName();
        return $moduleName . ':'  . $code;
    }
    
    
    /**
     * @param XmlElement $xml
     *
     * @return $this
     */
    protected function prepare(XmlElement $xml)
    {
        if (is_null($this->aclXml)) {
            $this->aclXml = $xml->addChild('acl');
            $this->resourcesXml = $this->aclXml->addChild('resources');
        }
        
        return $this;
    }
}