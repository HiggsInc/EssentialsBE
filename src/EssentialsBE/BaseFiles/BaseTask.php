<?php

declare(strict_types = 1);

namespace EssentialsBE\BaseFiles;

use EssentialsBE\Loader;
use pocketmine\scheduler\PluginTask;

abstract class BaseTask extends PluginTask{
    /** @var BaseAPI */
    private $api;

    /**
     * @param BaseAPI $api
     */
    public function __construct(BaseAPI $api){
        parent::__construct($api->getEssentialsBEPlugin());
        $this->api = $api;
    }

    /**
     * @return Loader
     */
    public final function getPlugin(): Loader{
        return $this->getAPI()->getEssentialsBEPlugin();
    }

    /**
     * @return BaseAPI
     */
    public final function getAPI(): BaseAPI{
        return $this->api;
    }
}