<?php
namespace ArcaSolutions\EventBundle\Sample;

use ArcaSolutions\EventBundle\Entity\Eventcategory;

class EventcategorySample extends Eventcategory
{
    /**
     * EventcategorySample constructor.
     *
     * @param misc $translator
     * @param int $counter
     */
    public function __construct($translator, $counter)
    {
        $this->setTitle($translator->trans('Category ').++$counter)
            ->setActiveEvent(rand() % 100 + 1)
            ->setFriendlyUrl('category-sample')
            ->setEnabled('y');
    }
}
