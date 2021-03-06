<?php

namespace CanalTP\SamCoreBundle\Component;

use CanalTP\SamEcoreApplicationManagerBundle\Component\AbstractBusinessComponent;
use CanalTP\SamEcoreApplicationManagerBundle\Permission\BusinessPermissionManagerInterface;
use CanalTP\SamCoreBundle\Menu\BusinessMenuItem;

/**
 * Description of BusinessComponent
 *
 * @author Rémy Abi Khalil <remy.abikhalil@canaltp.fr>
 */
class BusinessComponent extends AbstractBusinessComponent
{
    private $businessPermissionManager;
    private $container;

    public function __construct(
        BusinessPermissionManagerInterface $businessPermissionManager,
        $serviceContainer
    )
    {
        $this->businessPermissionManager = $businessPermissionManager;
        $this->container = $serviceContainer;
    }

    public function getId() {
        return 'sam_business_component';
    }

    public function getName()
    {
        return 'Sam Business component';
    }

    public function getMenuItems()
    {
        $client = new BusinessMenuItem();
        $client->setAction('#');
        $client->setName('Client');
        $client->setRoute('sam_customer_list');

        $user = new BusinessMenuItem();
        $user->setAction('#');
        $user->setName('Utilisateur');
        $user->setRoute('sam_user_list');

        $role = new BusinessMenuItem();
        $role->setAction('#');
        $role->setName('Role');
        $role->setRoute('sam_role');

        $perm = new BusinessMenuItem();
        $perm->setAction('#');
        $perm->setName('Permission');
        $perm->setRoute('sam_security_business_right_edit');
        
        $navIo = new BusinessMenuItem();
        $navIo->setAction('#');
        $navIo->setName('Navitia.io');
        $navIo->setRoute('nmm_navitiaio_user');

        $menu = array();
        if ($this->container->get('security.context')->isGranted('BUSINESS_VIEW_USER')
            || $this->container->get('security.context')->isGranted('BUSINESS_MANAGE_USER')) {
            $menu[] = $user;
        }

        if ($this->container->get('security.context')->isGranted('BUSINESS_VIEW_ROLE')
            || $this->container->get('security.context')->isGranted('BUSINESS_MANAGE_ROLE')) {
            $menu[] = $role;
        }

        if ($this->container->get('security.context')->isGranted('BUSINESS_MANAGE_PERMISSION')) {
            $menu[] = $perm;
        }

        if ($this->container->get('security.context')->isGranted('BUSINESS_MANAGE_CLIENT')) {
            $menu[] = $client;
        }
        
        if ($this->container->get('security.context')->isGranted('BUSINESS_MANAGE_NAVITIA_USER')) {
            $menu[] = $navIo;
        }

        return $menu;
    }

    public function getPerimetersManager()
    {
        throw new \Exception(sprintf("%s method not implemented", __METHOD__), 1);
    }

    public function getPermissionsManager() {
        return $this->businessPermissionManager;
    }
}
