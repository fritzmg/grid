<?php

/**
 * @package    contao-bootstrap
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

namespace ContaoBootstrap\Grid\Dca;

use Contao\DataContainer;
use ContaoBootstrap\Core\Environment;
use ContaoBootstrap\Grid\Model\GridModel;

/**
 * GridOptionsProvider provides grid related options callbacks.
 *
 * @package ContaoBootstrap\Grid\Dca
 */
abstract class AbstractDcaHelper
{
    /**
     * Bootstrap environment.
     *
     * @var Environment
     */
    private $environment;

    /**
     * Form constructor.
     *
     * @param Environment $environment Bootstrap environment.
     */
    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * Get range of grid columns.
     *
     * @return array
     */
    public function getGridColumns()
    {
        return range(
            1,
            (int) $this->environment->getConfig()->get('grid.columns', 12)
        );
    }

    /**
     * Get all available grids.
     *
     * @return array
     */
    public function getGridOptions()
    {
        $collection = GridModel::findAll();
        $options    = [];

        if ($collection) {
            foreach ($collection as $model) {
                $parent = sprintf(
                    '%s [ID %s]',
                    $model->getRelated('pid')->name,
                    $model->pid
                );

                $options[$parent][$model->id] = sprintf('%s [ID %s]', $model->title, $model->id);
            }
        }

        return $options;
    }

    /**
     * Generate a grid name if not given.
     *
     * @param string        $value         Grid name.
     * @param DataContainer $dataContainer Data container driver.
     *
     * @return string
     */
    public function generateGridName($value, $dataContainer)
    {
        if (!$value) {
            $value = 'grid_' . $dataContainer->activeRecord->id;
        }

        return $value;
    }
}
