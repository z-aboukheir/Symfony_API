<?php

namespace ContainerN325N71;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_TIMOa3tService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.tIMOa3t' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.tIMOa3t'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'countryRepository' => ['privates', 'App\\Repository\\CountryRepository', 'getCountryRepositoryService', true],
            'entityManager' => ['services', 'doctrine.orm.default_entity_manager', 'getDoctrine_Orm_DefaultEntityManagerService', false],
        ], [
            'countryRepository' => 'App\\Repository\\CountryRepository',
            'entityManager' => '?',
        ]);
    }
}