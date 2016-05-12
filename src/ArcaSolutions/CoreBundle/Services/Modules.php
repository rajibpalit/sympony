<?php
namespace ArcaSolutions\CoreBundle\Services;

use ArcaSolutions\MultiDomainBundle\Doctrine\DoctrineRegistry;


/**
 * Class Modules
 *
 * @package ArcaSolutions\CoreBundle\Services
 */
class Modules
{
    /**
     * @var DoctrineRegistry
     */
    private $doctrine;

    /**
     * Deal has a different name in DB
     * @var array
     */
    private $modules = ['listing', 'event', 'classified', 'article', 'banner', 'promotion', 'blog'];

    /**
     * Modules constructor.
     *
     * @param DoctrineRegistry $doctrine
     */
    public function __construct(DoctrineRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * It checks if edirectory's modules are enabled. It uses its variable called modules for it
     * To add new modules, just change the variable
     *
     * @return array
     */
    public function getAvailableModules()
    {
        /* per domain */
        return $this->doctrine->getRepository('WebBundle:Setting')->whichModulesAreAvailable($this->modules);
    }

    /**
     * It checks if module is available
     *
     * @param string $module
     * @return bool
     * @throws \Exception
     */
    public function isModuleAvailable($module = '')
    {
        if (!$this->isModule($module)) {
            throw new \Exception('You must pass a valid module');
        }

        if ($module == 'deal') {
            $module = 'promotion';
        }

        return $this->doctrine->getRepository('WebBundle:Setting')->isModuleAvailable($module);
    }

    public function isModule($possible_module = '')
    {
        if ($possible_module == 'deal') {
            $possible_module = 'promotion';
        }

        return in_array($possible_module, $this->modules);
    }
}
