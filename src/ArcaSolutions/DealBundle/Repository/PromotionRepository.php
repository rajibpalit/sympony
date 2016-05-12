<?php

namespace ArcaSolutions\DealBundle\Repository;

use ArcaSolutions\CoreBundle\Interfaces\EntityModulesRowInterface;
use ArcaSolutions\CoreBundle\Repository\EntityModulesRowRepository;

class PromotionRepository  extends EntityModulesRowRepository implements EntityModulesRowInterface
{
    /**
     * Returns module name in lowercase
     *
     * @return string
     */
    function getModuleName()
    {
        return 'deal';
    }
}
