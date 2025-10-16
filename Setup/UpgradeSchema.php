<?php
namespace Magiccart\Testimonial\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
	public function upgrade( SchemaSetupInterface $setup, ModuleContextInterface $context ) {
		$installer = $setup;

		$installer->startSetup();
		$connection = $installer->getConnection();

		if(version_compare($context->getVersion(), '2.1', '<')) {
			$connection->addColumn(
				$installer->getTable( 'magiccart_testimonial' ),
				'job',
				[
					'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					'nullable' => true,
					'length' => '255',
					'comment' => 'Job',
					'after' => 'company'
				]
			);
		}

		if(version_compare($context->getVersion(), '2.2', '<')) {
            $connection->addColumn(
                $installer->getTable('magiccart_testimonial'),
                'product',
                [
                    'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length'    => 255,
                    'nullable'  => true,
                    'default'   => NULL,
                    'comment'   => 'Product ID',
                ]
            );

            $connection->addColumn(
                $installer->getTable('magiccart_testimonial'),
                'config',
                [
                    'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length'    => '2M',
                    'nullable'  => true,
                    'default'   => NULL,
                    'comment'   => 'Config',
                ]
            );
		}

		$installer->endSetup();
	}
}