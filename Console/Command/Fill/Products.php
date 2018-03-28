<?php
/**
 *
 */

namespace Praxigento\Mage2Theme\Console\Command\Fill;

use Magento\Framework\ObjectManagerInterface;
use Magento\Setup\Model\ObjectManagerProvider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Products extends Command
{
    /** @var ObjectManagerInterface */
    protected $_manObj;

    public function __construct(
        ObjectManagerInterface $manObj
    )
    {
        parent::__construct();
        $this->_manObj = $manObj;
    }

    /**
     * Sets area code to start a session for replication.
     */
    private function _setAreaCode()
    {
        $areaCode = 'adminhtml';
        /** @var \Magento\Framework\App\State $appState */
        $appState = $this->_manObj->get(\Magento\Framework\App\State::class);
        $appState->setAreaCode($areaCode);
        /** @var \Magento\Framework\ObjectManager\ConfigLoaderInterface $configLoader */
        $configLoader = $this->_manObj->get(\Magento\Framework\ObjectManager\ConfigLoaderInterface::class);
        $config = $configLoader->load($areaCode);
        $this->_manObj->configure($config);
    }

    protected function configure()
    {
        $this->setName('prxgt:theme:fill-some-products');
        $this->setDescription('Fill Magento with some products and categories.');
        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Filling some Products<info>');
        /* setup session */
        $this->_setAreaCode();
        /** @var  $loader \Praxigento\Mage2Theme\Console\Command\Fill\Products\Load */
        $loader = $this->_manObj->get(\Praxigento\Mage2Theme\Console\Command\Fill\Products\Load::class);
        $loader->execute();
        $output->writeln('<info>Store filled with Products for Magento 2 Theme.<info>');
    }
}