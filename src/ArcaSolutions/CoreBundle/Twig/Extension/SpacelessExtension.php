<?php
/**
 * Created by PhpStorm.
 * User: faustino
 * Date: 9/14/15
 * Time: 10:22 AM
 */

namespace ArcaSolutions\CoreBundle\Twig\Extension;

/**
 * Class SpacelessExtension
 *
 * @package ArcaSolutions\CoreBundle\Twig\Extension
 */
class SpacelessExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('spaceless', [$this, 'spaceless'], [])
        ];
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public function spaceless($string = '')
    {
        return str_replace(' ','', $string);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        'spaceless_core_extension';
    }
}
