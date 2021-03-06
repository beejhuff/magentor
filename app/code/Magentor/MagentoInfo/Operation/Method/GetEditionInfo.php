<?php

namespace Magentor\MagentoInfo\Operation\Method;

use Magentor\Framework\Magento\Operation\MethodAbstract;

class GetEditionInfo extends MethodAbstract
{

    /**
     * @inheritdoc
     */
    public function executeMagentoOne()
    {
        return \Mage::getEditionInfo();
    }


    /**
     * @inheritdoc
     */
    public function executeMagentoTwo()
    {
        return false;
    }
}
