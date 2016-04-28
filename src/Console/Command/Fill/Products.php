<?php
/**
 *
 */

namespace Praxigento\Magento2Theme\Console\Command\Fill;
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
    ) {
        parent::__construct();
        $this->_manObj = $manObj;
    }

    protected function configure()
    {
        $this->setName('prxgt:theme:replicate-products');
        $this->setDescription('Fill Magento with some products and categories.');
        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Filling some Products/<info>');
        $output->writeln('<info>Store filled with Products for Magento 2 Theme.<info>');
    }
}