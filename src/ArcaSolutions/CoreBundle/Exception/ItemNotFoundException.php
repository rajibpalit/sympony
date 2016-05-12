<?php
namespace ArcaSolutions\CoreBundle\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class UnavailableItemException
 *
 * @package ArcaSolutions\CoreBundle\Exception
 */
class ItemNotFoundException extends HttpException
{
    /**
     * Constructor
     *
     * @param string          $message
     * @param \Exception|null $previous
     * @param int             $code
     */
    public function __construct($message = 'Page not exist', \Exception $previous = null, $code = 0)
    {
        parent::__construct(404, $message, $previous, [], $code);
    }
}
