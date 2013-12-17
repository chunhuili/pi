<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt New BSD License
 */

namespace   Module\System\Installer\Schema;

use Pi;
use Pi\Application\Installer\Action\Update as UpdateAction;
use Pi\Application\Installer\SqlSchema;

/**
 * System schema update handler
 *
 * @author Taiwen Jiang <taiwenjiang@tsinghua.org.cn>
 */
class AbstractUpdator
{
    /** @var UpdateAction */
    protected $handler;

    /**
     * Constructor
     *
     * @param UpdateAction $handler
     */
    public function __constructor(UpdateAction $handler)
    {
        $this->handler = $handler;
    }

    /**
     * Alter system table schema
     *
     * @param string $sql
     *
     * @return bool
     */
    protected function queryTable($sql)
    {
        $adapter = Pi::db()->getAdapter();
        try {
            $adapter->query($sql, 'execute');
        } catch (\Exception $exception) {
            $this->handler->setResult('db', array(
                'status'    => false,
                'message'   => 'Table alter query failed: '
                    . $exception->getMessage(),
            ));

            return false;
        }

        return true;
    }

    /**
     * Update system table schema
     *
     * @param string $sql
     *
     * @return bool
     */
    protected function querySchema($sql)
    {
        $sqlHandler = new SqlSchema;
        try {
            $sqlHandler->queryContent($sql);
        } catch (\Exception $exception) {
            $this->handler->setResult('db', array(
                'status'    => false,
                'message'   => 'SQL schema query failed: '
                    . $exception->getMessage(),
            ));

            return false;
        }

        return true;
    }

    /**
     * Update system table schema
     *
     * @param string       $version
     *
     * @throws \Exception
     * @return bool
     */
    public function upgrade($version)
    {
        throw new \Exception('Method not implemented yet.');
    }
}