<?php

namespace Magentor\MagentoInfo\Operation;

class Command extends \Magentor\Framework\Magento\Operation\CommandAbstract implements CommandInterface
{

    /**
     * @return bool|mixed|string
     * @throws \Exception
     */
    public function getVersion()
    {
        return $this->executeCommand(Method\GetVersion::class);
    }


    /**
     * @return bool|mixed|string
     * @throws \Exception
     */
    public function getEdition()
    {
        return $this->executeCommand(Method\GetEdition::class);
    }


    /**
     * @return bool|mixed|string
     * @throws \Exception
     */
    public function getEditionInfo()
    {
        return $this->executeCommand(Method\GetEditionInfo::class);
    }


    /**
     * @return bool|mixed|string
     * @throws \Exception
     */
    public function getBaseDir()
    {
        return $this->executeCommand(Method\GetBaseDir::class);
    }


    /**
     * @param string $path
     * @param null   $store
     * @return bool|mixed|null|string
     * @throws \Exception
     */
    public function getStoreConfig($path, $store = null)
    {
        return $this->executeCommand(Method\GetStoreConfig::class, [
            'path'  => $path,
            'store' => $store
        ]);
    }


    /**
     * @param null $secure
     * @return bool|mixed|string
     * @throws \Exception
     */
    public function getBaseUrl($secure = null)
    {
        return $this->executeCommand(Method\GetBaseUrl::class, ['secure' => $secure]);
    }


    /**
     * @return bool|mixed
     * @throws \Exception
     */
    public function isInstalled()
    {
        return $this->executeCommand(Method\GetIsInstalled::class);
    }
}
