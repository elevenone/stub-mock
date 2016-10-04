<?php
// @codingStandardsIgnoreFile

namespace Jnjxp\Mockup;

use Aura\Di\Container;
use Aura\Di\ContainerConfig;

use Aura\Router\RouterContainer;

use Fusible\ViewProvider\Config as ViewConfig;
use Faker\Factory as FakerFactory;

/**
 *
 * DI container configuration for Radar classes.
 *
 * @package radar/adr
 *
 */
class Config extends ContainerConfig
{
    /**
     *
     * Defines params, setters, values, etc. in the Container.
     *
     * @param Container $di The DI container.
     *
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function define(Container $di)
    {
        $viewConfig = new ViewConfig;
        $viewConfig->define($di);
        $di->set('jnjxp/mockup:mockup', $di->lazyNew(Mockup::class));
        $di->set('jnjxp/mockup:router', $di->lazyNew(RouterContainer::class));

        $di->params[Mockup::class] = [
            'router'  => $di->lazyGet('jnjxp/mockup:router'),
            'send'    => $di->lazyNew(Send::class),
            'view'    => $di->lazyGet('aura/view:view'),
            'factory' => $di->getInjectionFactory()
        ];

        $di->params[AbstractFakeData::class] = [
            'faker' => $di->lazy([FakerFactory::class, 'create'])
        ];
    }

    /**
     *
     * Modifies constructed container objects.
     *
     * @param Container $di The DI container.
     *
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function modify(Container $di)
    {
        $di;
    }
}
