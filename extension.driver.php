<?php

	Class extension_Yaml extends Extension{

		public function getSubscribedDelegates(){
			return array(
				array(
					'page' => '/system/preferences/',
					'delegate' => 'AddCustomPreferenceFieldsets',
					'callback' => 'appendPreferences'
				),
			);
		}
		public function appendPreferences($context){
			$group = new XMLElement('fieldset');
			$group->setAttribute('class', 'settings');
			$group->appendChild(new XMLElement('legend', 'YAML'));
			$div = new XMLElement('div', NULL, array('class' => 'group'));
			$label = Widget::Label('Underlying Markdown Formatter');

			// get all text formatter options
			$options = TextformatterManager::listAll();

			//we do not want an infinite YAML Loop so remove yaml as an option
			unset($options['yaml']);

			// insert options in correct array format
			$selectOptions = array();
			foreach ($options as $key => $value) {
				$selectOptions[] = array($key, Symphony::Configuration()->get('formatter', 'yaml') == $key, $value['name']);
			}

			$label->appendChild(Widget::Select('settings[yaml][formatter]', $selectOptions));
			$div->appendChild($label);
			$group->appendChild($div);
			$group->appendChild(new XMLElement('p', 'Set the default Symphony formatter to use with YAML', array('class' => 'help')));
			$context['wrapper']->appendChild($group);


		}
	}
