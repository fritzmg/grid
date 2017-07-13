<?php

/**
 * @package    contao-bootstrap
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

namespace ContaoBootstrap\Grid\Component\FormField;

/**
 * Class GridFormField.
 *
 * @package ContaoBootstrap\Grid\Component
 */
class GridStartFormField extends AbstractFormField
{
    /**
     * Template name.
     *
     * @var string
     */
    protected $strTemplate = 'form_grid_start';

    /**
     * @inheritDoc
     */
    protected function getIterator()
    {
        try {
            $provider = $this->getGridProvider();
            $iterator = $provider->getIterator('ffl:' . $this->id, $this->bootstrap_grid);

            return $iterator;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @inheritDoc
     */
    public function generate()
    {
    }

    public function parse($attributes = null)
    {
        $iterator = $this->getIterator();

        if ($this->isBackendRequest()) {


            return $this->renderBackendView($this, $iterator);
        }

        if ($iterator) {
            $this->rowClasses    = $iterator->row();
            $this->columnClasses = $iterator->current();
        }

        return parent::parse($attributes);
    }
}
