<?php
namespace Craft;

/**
 * SupercoolFields by Supercool
 *
 * @package   SupercoolFields
 * @author    Josh Angell
 * @copyright Copyright (c) 2014, Supercool Ltd
 * @link      http://www.supercooldesign.co.uk
 */

/**
 *
 */
class SupercoolFields_ColoursFieldType extends BaseOptionsFieldType
{
	/**
	 * Returns the type of field this is.
	 *
	 * @return string
	 */
	public function getName()
	{
		return Craft::t('Colours');
	}


	/**
	 * Returns the field's input HTML.
	 *
	 * @param string $name
	 * @param mixed  $value
	 * @return string
	 */
	public function getInputHtml($name, $value)
	{
		$options = $this->getTranslatedOptions();

		// If this is a new entry, look for a default option
		if ($this->isFresh())
		{
			$value = $this->getDefaultValue();
		}

		craft()->templates->includeCssResource('supercoolfields/css/supercoolfields.css');
		craft()->templates->includeJsResource('supercoolfields/js/supercoolfields.js');

		craft()->templates->includeJs('new Craft.SupercoolFieldsFancyOptions("'.craft()->templates->namespaceInputId($name).'");');

		return craft()->templates->render('supercoolfields/colours/field', array(
			'name'    => $name,
			'value'   => $value,
			'options' => $options
		));
	}


	/**
	* @inheritDoc BaseElementFieldType::getSettingsHtml()
	*
	* @return string|null
	*/
	public function getSettingsHtml()
	{
		$options = $this->getOptions();

		if (!$options)
		{
			// Give it a default row
			$options = array(
				array(
					'label'     => 'Red',
					'value'     => 'red',
					'cssColour' => '#d9603b'
				),
				array(
					'label'     => 'Green',
					'value'     => 'green',
					'cssColour' => '#328d7e',
					'default'   => true
				),
				array(
					'label'     => 'Navy',
					'value'     => 'navy',
					'cssColour' => '#17333a'
				),
				array(
					'label'     => 'Brown',
					'value'     => 'brown',
					'cssColour' => '#818b80'
				)
			);
		}

		return craft()->templates->renderMacro('_includes/forms', 'editableTableField', array(
			array(
				'label'        => $this->getOptionsSettingsLabel(),
				'instructions' => Craft::t('Define the available options.'),
				'id'           => 'options',
				'name'         => 'options',
				'addRowLabel'  => Craft::t('Add an option'),
				'cols'         => array(
					'label' => array(
						'heading'      => Craft::t('Option Label'),
						'type'         => 'singleline',
						'autopopulate' => 'value'
					),
					'value' => array(
						'heading'      => Craft::t('Value'),
						'type'         => 'singleline',
						'class'        => 'code'
					),
					'cssColour' => array(
						'heading'      => Craft::t('Valid CSS Colour'),
						'type'         => 'singleline',
						'class'        => 'code'
					),
					'default' => array(
						'heading'      => Craft::t('Default?'),
						'type'         => 'checkbox',
						'class'        => 'thin'
					),
				),
				'rows' => $options
			)
		));
	}



	// Protected Methods
	// =========================================================================

	/**
	* @inheritDoc BaseOptionsFieldType::getOptionsSettingsLabel()
	*
	* @return string
	*/
	protected function getOptionsSettingsLabel()
	{
		return Craft::t('Colour Options');
	}


	/**
	* @inheritDoc BaseSavableComponentType::defineSettings()
	*
	* @return array
	*/
	protected function defineSettings()
	{
		return array(
			'options' => array(AttributeType::Mixed, 'default' => array())
		);
	}

}
