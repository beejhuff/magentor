<?php

namespace Magentor\MagentoInfo\Operation\Method;

use Magentor\Framework\Magento\Operation\MethodAbstract;

class GetBaseDir extends MethodAbstract
{

    /**
     * @inheritdoc
     */
    public function executeMagentoOne()
    {
        return \Mage::getBaseDir();
    }


    /**
     * @inheritdoc
     */
    public function executeMagentoTwo()
    {
        return false;
    }
}
