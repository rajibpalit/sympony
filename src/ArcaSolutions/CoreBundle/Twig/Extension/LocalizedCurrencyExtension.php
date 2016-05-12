<?php

namespace ArcaSolutions\CoreBundle\Twig\Extension;

use ArcaSolutions\CoreBundle\Services\Settings;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class LocalizedCurrencyExtension
 *
 * Adds a filter as a shortcut to twig's localized function
 *
 * @package ArcaSolutions\CoreBundle\Twig\Extension
 */
class LocalizedCurrencyExtension extends \Twig_Extension
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var Settings
     */
    private $settings;

    /**
     * LocalizedCurrencyExtension constructor.
     *
     * @param Container $container
     * @param Settings $settings
     */
    public function __construct(Container $container, Settings $settings)
    {
        $this->container = $container;
        $this->settings = $settings;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter(
                'localized_currency',
                [$this, 'localized_currency'],
                ['is_safe' => ['html']]
            )
        ];
    }

    /**
     * Shortcut to the twig's localized function
     *
     * @param $number
     *
     * @param bool $withHTML
     * @return bool|string
     */
    public function localized_currency($number, $withHTML = true)
    {
        $translator = $this->container->get("translator");
        $thousandSeparator = $translator->trans("thousands.separator", [], "units");
        $decimalSeparator = $translator->trans("decimal.separator", [], "units");
        $symbol = $this->container->get("settings")->getSettingPayment(Settings::PAYMENT_CURRENCY_SYMBOL);

        $wholePart = floor($number);
        $decimalPart = $number - $wholePart;

        if ($withHTML) {
            $wholePart = number_format($wholePart, 0, $decimalSeparator, $thousandSeparator);
            $decimalPart = substr((string)floor(($decimalPart) * 100), 0, 2);

            $arguments = [
                "{symbol}" => "<em>{$symbol}</em>",
                "{value}"  => "{$wholePart}" . ($decimalPart ? "{$decimalSeparator}<small>{$decimalPart}</small>" : ""),
            ];

            $return = "<mark>" . $translator->trans("monetary.format", $arguments, "units") . "</mark>";
        } else {
            if ($decimalPart) {
                $number = number_format($number, 2, $decimalSeparator, $thousandSeparator);
            }

            $arguments = [
                "{symbol}" => $symbol,
                "{value}"  => $number,
            ];

            $return = $translator->trans("monetary.format", $arguments, "units");
        }


        return $return;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'localized_currency';
    }
}
