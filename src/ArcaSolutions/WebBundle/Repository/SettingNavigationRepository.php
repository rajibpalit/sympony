<?php
namespace ArcaSolutions\WebBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SettingNavigationRepository extends EntityRepository
{
    /**
     * @param string $theme
     * @param string $area
     *
     * @return array
     * @throws \Exception
     */
    public function getMenuByThemeAndArea($theme = '', $area = '')
    {
        if (empty($theme) || empty($area)) {
            throw new \Exception('You must pass a theme to get the menu.');
        }

        return $this->findBy(['theme' => $theme, 'area' => $area], ['order' => 'ASC']);
    }
}
