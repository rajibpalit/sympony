<?php
namespace ArcaSolutions\WebBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class EmailNotificationService
{
    /**
     * Messages code
     */
    const RENEWAL_REMINDER_DAY_30 = 1;
    const RENEWAL_REMINDER_DAY_15 = 2;
    const RENEWAL_REMINDER_DAY_7 = 3;
    const RENEWAL_REMINDER_DAY_1 = 4;
    const SPONSOR_ACCOUNT_CREATE = 5;
    const SPONSOR_ACCOUNT_UPDATE = 6;
    const VISITOR_ACCOUNT_CREATE_SITEMGR = 7;
    const VISITOR_ACCOUNT_UPDATE = 8;
    const FORGOTTEN_PASSWORD = 9;
    const NEW_LISTING = 10;
    const NEW_EVENT = 11;
    const NEW_BANNER = 12;
    const NEW_CLASSIFIED = 13;
    const NEW_ARTICLE = 14;
    const CUSTOM_INVOICE = 15;
    const ACTIVE_LISTING = 16;
    const ACTIVE_EVENT = 17;
    const ACTIVE_BANNER = 18;
    const ACTIVE_CLASSIFIED = 19;
    const ACTIVE_ARTICLE = 20;
    const LISTING_SIGNUP = 22;
    const EVENT_SIGNUP = 23;
    const BANNER_SIGNUP = 24;
    const CLASSIFIED_SIGNUP = 25;
    const ARTICLE_SIGNUP = 26;
    const CLAIMER_SIGNUP = 27;
    const CLAIM_AUTOMATICALLY_APPROVED = 28;
    const CLAIM_APPROVED = 29;
    const CLAIM_DENIED = 30;
    const APPROVE_REPLAY = 31;
    const APPROVE_REVIEW = 32;
    const NEW_REVIEW = 33;
    const INVOICE_NOTIFICATION = 34;
    const VISITOR_ACCOUNT_CREATE = 35;
    const SPONSOR_STATS_ENGAGEMENT_EMAIL = 36;
    const DEAL_REDEEM_OWNER = 37;
    const DEAL_REDEEM_VISITOR = 38;
    const ACCOUNT_ACTIVATION = 39;
    const NEW_LEAD = 40;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var RequestStack
     */
    protected $request;

    /**
     * Email
     *
     * @var string
     */
    protected $to;

    /**
     * Email
     *
     * @var string
     */
    protected $from;

    /**
     * Placeholders allowed
     *
     * @var array
     */
    private $placeholdersDictionaries
        = [
            'ACCOUNT_LOGIN_INFORMATION',
            'ACCOUNT_NAME',
            'ACCOUNT_PASSWORD',
            'ACCOUNT_USERNAME',
            'ARTICLE_DEFAULT_URL',
            'CLASSIFIED_DEFAULT_URL',
            'CUSTOM_INVOICE_AMOUNT',
            'CUSTOM_INVOICE_TAX',
            'DAYS_INTERVAL',
            'DEFAULT_URL',
            'EDIRECTORY_TITLE',
            'EVENT_DEFAULT_URL',
            'ITEM_TITLE',
            'ITEM_URL',
            'KEY_ACCOUNT',
            'LEAD_MESSAGE',
            'LINK_ACTIVATE_ACCOUNT',
            'LISTING_DEFAULT_URL',
            'LISTING_RENEWAL_DATE',
            'LISTING_TITLE',
            'REDEEM_CODE',
            'SITEMGR_EMAIL',
            'TABLE_STATS',
            'MEMBERS_URL'
        ];

    /**
     * Message's body
     *
     * @var string
     */
    private $message;

    /**
     * Message's subject
     *
     * @var string
     */
    private $subject;

    /**
     * Message's BCC
     *
     * @var array
     */
    private $bcc;

    /**
     * Message's type
     *
     * Example: text/plain, text/html, etc
     *
     * @var string
     */
    private $contentType;

    /**
     * Added Placeholders
     *
     * @var array
     */
    private $placeholder = [];

    /**
     * @param ContainerInterface $container
     * @param RequestStack $request
     */
    public function __construct(ContainerInterface $container, RequestStack $request)
    {
        $this->container = $container;
        $this->request = $request;
        $this->populateCommonPlaceholders();
    }

    /**
     * Populate common placeholders
     *
     * @throws \Exception
     */
    private function populateCommonPlaceholders()
    {
        $user = $this->container->get('user')->getUser();

        if ($user) {
            $this->setPlaceholder('ACCOUNT_NAME', sprintf('%s %s', $user->getFirstName(), $user->getLastName()));
            $this->setPlaceholder('ACCOUNT_USERNAME', $user->getUsername());
        }

        $this->setPlaceholder('EDIRECTORY_TITLE', $this->container->get('multi_domain.information')->getTitle());
        $this->setPlaceholder('SITEMGR_EMAIL',
            $this->container->get('doctrine')->getRepository('WebBundle:Setting')->getSetting('sitemgr_email'));
        $this->setPlaceholder('DEFAULT_URL', $this->request->getCurrentRequest()->getSchemeAndHttpHost());
        $this->setPlaceholder('MEMBERS_URL', $this->container->getParameter('alias_members_module'));
        $this->setPlaceholder('ARTICLE_DEFAULT_URL', $this->container->get('router')->generate('article_homepage'));
        $this->setPlaceholder('CLASSIFIED_DEFAULT_URL',
            $this->container->get('router')->generate('classified_homepage'));
        $this->setPlaceholder('EVENT_DEFAULT_URL', $this->container->get('router')->generate('event_homepage'));
        $this->setPlaceholder('LISTING_DEFAULT_URL', $this->container->get('router')->generate('listing_homepage'));
    }

    /**
     * Get message row by message's ID
     *
     * @param int $type
     *
     * @return $this
     * @throws \Exception
     *
     */
    public function getEmailMessage($type = 0)
    {
        if (!is_numeric($type) && 0 === $type) {
            throw new \Exception('You must pass the message\'s number.');
        }

        $notification = $this->container->get('doctrine')->getRepository('WebBundle:EmailNotification')->findOneBy([
            'id' => $type,
            'deactivate' => 0
        ]);

        if (is_null($notification)) {
            throw new \Exception('Email notification not found.');
        }

        $this->setSubject($notification->getSubject())
            ->setBcc($notification->getBcc())
            ->setContentType($notification->getContentType())
            ->setMessage($notification->getBody());

        return $this;
    }

    /**
     * Send email
     *
     * @return bool|int
     */
    public function sendEmail()
    {
        $body = $this->replacePlaceholders($this->getMessage());
        $subject = $this->replacePlaceholders($this->getSubject());

        /* @var \Swift_Mime_Message $message */
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($this->getFrom(), $this->container->get('multi_domain.information')->getTitle())
            ->setTo($this->getTo())
            ->setBody($body, $this->getContentType());

        if ($this->getBcc()) {
            $message->setBcc($this->getBcc());
        }

        try {
            $errors = '';

            return $this->container->get('mailer')->send($message, $errors);
        } catch (\Swift_TransportException $e) {
            return false;
        }
    }

    /**
     * Replace added placeholders
     *
     * @param string $text
     *
     * @return mixed|string
     */
    private function replacePlaceholders($text = '')
    {
        foreach ($this->placeholder as $name => $value) {
            $text = str_replace($name, $value, $text);
        }

        return $text;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     *
     * @return EmailNotificationService
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     *
     * @return EmailNotificationService
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param string $from
     *
     * @return EmailNotificationService
     */
    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param mixed $to
     *
     * @return EmailNotificationService
     */
    public function setTo($to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @param mixed $contentType
     *
     * @return EmailNotificationService
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBcc()
    {
        return $this->bcc;
    }

    /**
     * @param mixed $bcc
     *
     * @return EmailNotificationService
     */
    public function setBcc($bcc)
    {
        $this->bcc = $bcc;

        return $this;
    }

    /**
     * @return array
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * Add a placeholder for replace
     *
     * @param string $placeholder
     * @param string $value
     *
     * @return $this
     * @throws \Exception
     */
    public function setPlaceholder($placeholder = '', $value = '')
    {
        if (empty($placeholder)) {
            throw new \Exception('You must pass a placeholder to set.');
        }

        if (!in_array($placeholder, $this->placeholdersDictionaries)) {
            throw new \Exception('Placeholder not found.');
        }

        $this->placeholder[$placeholder] = $value;

        return $this;
    }
}
