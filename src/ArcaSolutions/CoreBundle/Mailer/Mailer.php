<?php

namespace ArcaSolutions\CoreBundle\Mailer;

use Symfony\Component\DependencyInjection\Container;

class Mailer extends \Swift_Message
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var string
     */
    private $sendMailParameter = 'sitemgr_send_email';

    /**
     * @var string
     */
    private $generalMailParameter = 'sitemgr_email';

    /**
     * Create a new Message.
     *
     * Details may be optionally passed into the constructor.
     *
     * @param Container $container
     * @param string $subject
     * @param string $body
     * @param string $contentType
     * @param string $charset
     */
    public function __construct(
        Container $container,
        $subject = null,
        $body = null,
        $contentType = null,
        $charset = null
    ) {
        $this->container = $container;
        parent::__construct($subject, $body, $contentType, $charset);
    }

    /**
     * Create a new Message.
     *
     * @param Container $container
     * @param string $subject
     * @param string $body
     * @param string $contentType
     * @param string $charset
     *
     * @return Mailer
     */
    public static function newMail(
        Container $container,
        $subject = null,
        $body = null,
        $contentType = null,
        $charset = null
    ) {
        return new self($container, $subject, $body, $contentType, $charset);
    }

    /**
     * @inheritdoc
     */
    public function setTo($addresses, $name = null)
    {
        if (!is_array($addresses) && is_null($name)) {
            $addresses = array($addresses => $name);
        }

        /* Adds general e-mail addresses  */
        $settings = $this->container->get('doctrine')->getRepository('WebBundle:Setting');

        $generalMail = $settings->getSetting($this->sendMailParameter);

        if ($generalMail === 'on') {
            $generalTo = $settings->getSetting($this->generalMailParameter);
            $generalTo = explode(',', $generalTo);
            $addresses = array_filter(array_merge_recursive($addresses, $generalTo));
        }

        if (!$this->_setHeaderFieldModel('To', (array)$addresses)) {
            $this->getHeaders()->addMailboxHeader('To', (array)$addresses);
        }

        return $this;
    }

    /**
     * Send the given Message like it would be sent in a mail client.
     *
     * All recipients (with the exception of Bcc) will be able to see the other
     * recipients this message was sent to.
     *
     * Recipient/sender data will be retrieved from the Message object.
     *
     * The return value is the number of recipients who were accepted for
     * delivery.
     *
     * @param array $failedRecipients An array of failures by-reference
     *
     * @return int
     */
    public function send(&$failedRecipients = null)
    {
        return $this->container->get('mailer')->send($this, $failedRecipients);
    }

}
