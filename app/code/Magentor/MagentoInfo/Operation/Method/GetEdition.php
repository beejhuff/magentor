<?php

namespace Magentor\MagentoInfo\Operation\Method;

use Magentor\Framework\Magento\Operation\MethodAbstract;

class GetEdition extends MethodAbstract
{

    /**
     * @inheritdoc
     */
    public function executeMagentoOne()
    {
        return \Mage::getEdition();
    }


    /**
     * @inheritdoc
     */
    public function executeMagentoTwo()
    {
        return false;
    }
}
