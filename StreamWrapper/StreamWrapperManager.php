<?php


namespace Oneup\FlysystemBundle\StreamWrapper;


use Twistor\FlysystemStreamWrapper;

class StreamWrapperManager
{
    /**
     * @var ProtocolMap
     */
    private $protocolMap;

    /**
     * StreamWrapperManager constructor.
     *
     * @param ProtocolMap $protocolMap
     */
    public function __construct(ProtocolMap $protocolMap)
    {
        $this->protocolMap = $protocolMap;
    }

    /**
     * @throws \Exception
     */
    public function register()
    {
        foreach ($this->protocolMap as $protocol => $filesystem) {
            if (!FlysystemStreamWrapper::register($protocol, $filesystem)) {
                throw new \Exception(sprintf('Unable to register stream wrapper protocol "%s://"', $protocol));
            }
        }
    }

    /**
     * @throws \Exception
     */
    public function unregister()
    {
        foreach ($this->protocolMap as $protocol => $filesystem) {
            if (!FlysystemStreamWrapper::unregister($protocol)) {
                throw new \Exception(sprintf('Unable to unregister stream wrapper protocol "%s://"', $protocol));
            }
        }
    }
}
