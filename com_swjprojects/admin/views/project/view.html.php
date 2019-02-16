<?php
/**
 * @package    SW JProjects Component
 * @version    1.0.2
 * @author     Septdir Workshop - www.septdir.com
 * @copyright  Copyright (c) 2018 - 2018 Septdir Workshop. All rights reserved.
 * @license    GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link       https://www.septdir.com/
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Toolbar\ToolbarHelper;

class SWJProjectsViewProject extends HtmlView
{
	/**
	 * Model state variables.
	 *
	 * @var  Joomla\CMS\Object\CMSObject
	 *
	 * @since  1.0.0
	 */
	protected $state;

	/**
	 * Form object.
	 *
	 * @var  \Joomla\CMS\Form\Form
	 *
	 * @since  1.0.0
	 */
	protected $form;

	/**
	 * Translates forms array.
	 *
	 * @var  array
	 *
	 * @since  1.0.0
	 */
	protected $translateForms;

	/**
	 * Project object.
	 *
	 * @var  object
	 *
	 * @since  1.0.0
	 */
	protected $item;

	/**
	 * Execute and display a template script.
	 *
	 * @param  string $tpl The name of the template file to parse.
	 *
	 * @return  mixed  A string if successful, otherwise an Error object.
	 *
	 * @throws  Exception
	 *
	 * @since  1.0.0
	 */
	public function display($tpl = null)
	{
		$this->state          = $this->get('State');
		$this->form           = $this->get('Form');
		$this->translateForms = $this->get('TranslateForms');
		$this->item           = $this->get('Item');

		// Check for errors
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode('\n', $errors), 500);
		}

		// Add title and toolbar
		$this->addToolbar();

		return parent::display($tpl);
	}

	/**
	 * Add title and toolbar.
	 *
	 * @throws  Exception
	 *
	 * @since  1.0.0
	 */
	protected function addToolbar()
	{
		$isNew   = ($this->item->id == 0);
		$canDo   = SWJProjectsHelper::getActions('com_swjprojects', 'project', $this->item->id);
		$toolbar = Toolbar::getInstance('toolbar');

		// Disable menu
		Factory::getApplication()->input->set('hidemainmenu', true);

		// Set page title
		$title = ($isNew) ? Text::_('COM_SWJPROJECTS_PROJECT_ADD') : Text::_('COM_SWJPROJECTS_PROJECT_EDIT');
		ToolbarHelper::title(Text::_('COM_SWJPROJECTS') . ': ' . $title, 'cube');

		// Add apply & save buttons
		if ($canDo->get('core.edit'))
		{
			ToolbarHelper::apply('project.apply');
			ToolbarHelper::save('project.save');
		}

		// Add save new button
		if ($canDo->get('core.create'))
		{
			ToolbarHelper::save2new('project.save2new');
		}

		// Add cancel button
		ToolbarHelper::cancel('project.cancel', 'JTOOLBAR_CLOSE');

		// Add preview & joomla update server buttons
		if ($this->item->id)
		{
			// Preview button
			$link    = 'index.php?option=com_swjprojects&task=siteRedirect&page=project&debug=1&id=' . $this->item->id
				. '&catid=' . $this->item->catid;
			$preview = LayoutHelper::render('components.swjprojects.toolbar.link',
				array('link' => $link, 'text' => 'JGLOBAL_PREVIEW', 'icon' => 'eye'));
			$toolbar->appendButton('Custom', $preview, 'preview');

			// Joomla update server button
			$link    = 'index.php?option=com_swjprojects&task=siteRedirect&page=jupdate&debug=1&element=' . $this->item->element;
			$jupdate = LayoutHelper::render('components.swjprojects.toolbar.link',
				array('link' => $link, 'text' => 'COM_SWJPROJECTS_JOOMLA_UPDATE_SERVER', 'icon' => 'joomla'));
			$toolbar->appendButton('Custom', $jupdate, 'joomla');
		}

		// Add translate switcher
		$switcher = LayoutHelper::render('components.swjprojects.translate.switcher');
		$toolbar->appendButton('Custom', $switcher, 'translate-switcher');
	}
}