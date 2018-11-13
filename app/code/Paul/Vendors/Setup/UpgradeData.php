<?php

namespace Paul\Vendors\Setup;

use Paul\Vendors\Model\Vendors;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class UpgradeData implements UpgradeDataInterface
{

    protected $_vendors;

    public function __construct(Vendors $vendors)
    {
        $this->_vendors = $vendors;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        // Action to do if module version is less than 1.0.0.1
        if (version_compare($context->getVersion(), '1.0.0.1') < 0) {
            $vendors = [
                [
                    'name' => 'Nike',
                    'description' => 'Sed cautela nimia in peiores haeserat plagas, ut narrabimus postea,
                aemulis consarcinantibus insidias graves apud Constantium, cetera medium principem sed
                siquid auribus eius huius modi quivis infudisset ignotus, acerbum et inplacabilem et in
                hoc causarum titulo dissimilem sui.',
                    'logo' => '/n/i/nike.gif'
                ],
                [
                    'name' => 'Vaz',
                    'description' => 'Post hanc adclinis Libano monti Phoenice, regio plena gratiarum et
                venustatis, urbibus decorata magnis et pulchris; in quibus amoenitate celebritateque
                nominum Tyros excellit, Sidon et Berytus isdemque pares Emissa et Damascus saeculis condita
                priscis.',
                    'logo' => '/v/a/vaz_1.jpg'
                ],
                [
                    'name' => 'Kraz',
                    'description' => 'Duplexque isdem diebus acciderat malum, quod et Theophilum insontem atrox
                interceperat casus, et Serenianus dignus exsecratione cunctorum, innoxius, modo non reclamante publico vigore,
                discessit.',
                    'logo' => '/k/r/kraz_7.png'
                ]
            ];

            /**
             * Insert vendors
             */
            foreach ($vendors as $data) {
                $this->_vendors->setData($data)->save();
            }
        }

        $installer->endSetup();
    }
}