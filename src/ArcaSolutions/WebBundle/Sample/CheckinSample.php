<?php
namespace ArcaSolutions\WebBundle\Sample;

use ArcaSolutions\WebBundle\Entity\Checkin;

class CheckinSample extends Checkin
{
    /**
     * CheckinSample constructor.
     *
     * @param misc $translator
     * @param string $type
     */
    public function __construct($translator, $type = 'listing')
    {
        $this->setItemType($type)
            ->setAdded(new \DateTime('now'))
            ->setProfile(new AccountprofilecontactSample($translator))
            ->setCheckinName($translator->trans('Visitor'))
            ->setQuickTip($translator->trans('Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica formas.'));
    }
}
