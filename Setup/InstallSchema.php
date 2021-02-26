<?php
namespace Lof\Pos\Setup;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{

    public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('lof_pos_order')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('lof_pos_order')
            )
                ->addColumn(
                    'pos_order_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true,
                    ],
                    'Post ID'
                )
                ->addColumn(
                    'sales_order_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => false'],
                    'Sales Order Id'
                )
//                ->addColumn(
//                    'outlet_id',
//                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
//                    11,
//                    ['nullable => false'],
//                    'Outlet Id'
//                )
                ->addColumn(
                    'user_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    ['nullable => false'],
                    'user Id'
                )
//                ->addColumn(
//                    'cashier_id',
//                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
//                    11,
//                    ['nullable => false'],
//                    'Cashier Id'
//                )
                ->addColumn(
                    'cashier_name',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Cashier Name'
                )
                ->addColumn(
                    'cashier_phone',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Cashier Phone'
                )
                ->addColumn(
                    'cashier_email',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Cashier Email'
                )
                ->addColumn(
                    'cashier_address',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Cashier Address'
                )
                ->addColumn(
                    'grand_total',
                    \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    20.4,
                    [],
                    'Grand Total'
                )
                ->addColumn(
                    'created_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'Created At'
                );
            $installer->getConnection()->createTable($table);

            $installer->getConnection()->addIndex(
                $installer->getTable('lof_pos_order'),
                $setup->getIdxName(
                    $installer->getTable('lof_pos_order'),
                    ['cashier_name','cashier_phone','cashier_email','cashier_address'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['cashier_name','cashier_phone','cashier_email','cashier_address'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
            );
        }
        $installer->endSetup();
    }
}
