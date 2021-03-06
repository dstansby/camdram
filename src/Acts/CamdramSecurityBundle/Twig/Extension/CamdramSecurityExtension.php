<?php

namespace Acts\CamdramSecurityBundle\Twig\Extension;

use Acts\CamdramSecurityBundle\Security\OwnableInterface;
use Acts\CamdramSecurityBundle\Security\SecurityUtils;

class CamdramSecurityExtension extends \Twig_Extension
{
    /**
     * @var SecurityUtils
     */
    protected $utils;

    /**
     * @param OAuthHelper $helper
     */
    public function __construct(SecurityUtils $utils)
    {
        $this->utils = $utils;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
             new \Twig_SimpleFunction('camdram_security_services', [$this, 'getServices']),
             new \Twig_SimpleFunction('acl_entries', [$this, 'getAclEntries']),
             new \Twig_SimpleFunction('is_granted', [$this, 'isGranted']),
             new \Twig_SimpleFunction('is_owner', [$this, 'isOwner']),
             new \Twig_SimpleFunction('has_role', [$this, 'hasRole']),
             new \Twig_SimpleFunction('has_owners', [$this, 'hasOwners'])
        );
    }

    /**
     * @return array
     */
    public function getServices()
    {
        return $this->utils->getServices();
    }

    public function getAclEntries($role, $class = null)
    {
        return $this->utils->getAclEntries($role, $class);
    }

    public function isGranted($attributes, $object = null, $fully_authenticated = false)
    {
        return $this->utils->isGranted($attributes, $object, $fully_authenticated);
    }

    public function isOwner($object)
    {
        return $this->utils->isOwner($object);
    }

    public function hasRole($role)
    {
        return $this->utils->hasRole($role);
    }

    public function hasOwners(OwnableInterface $object)
    {
        return $this->utils->hasOwners($object);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'camdram_security';
    }
}
