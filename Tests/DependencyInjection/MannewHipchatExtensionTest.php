<?php

namespace Mannew\HipchatBundle\Tests\DependencyInjection;

use Mannew\HipchatBundle\DependencyInjection\MannewHipchatExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class MannewHipchatExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MannewHipchatExtension
     */
    private $extension;

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testLoadConfigThrowsExceptionOnMissingAuthToken()
    {
        $config = array();
        $this->extension->load(array($config), $container = $this->getContainer());
    }

    public function testLoadConfigWithAuthToken()
    {
        $testToken = 'testtoken';
        $config = array(
            'auth_token' => $testToken
        );
        $this->extension->load(array($config), $container = $this->getContainer());

        $this->assertEquals($testToken, $container->getParameter('mannew_hipchat.auth_token'));
        $this->assertTrue($container->hasDefinition('hipchat'));
    }

    /**
     * Initialize the extension.
     */
    protected function setUp()
    {
        $this->extension = new MannewHipchatExtension();
    }

    /**
     * Constructs and returns a ContainerBuilder to be used for testing purposes.
     *
     * @return ContainerBuilder
     */
    private function getContainer()
    {
        $container = new ContainerBuilder();
        $container->setParameter('kernel.cache_dir', sys_get_temp_dir());
        $container->setParameter('kernel.bundles', array());

        return $container;
    }
}
