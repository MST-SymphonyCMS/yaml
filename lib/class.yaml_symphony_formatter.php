<?php

	Class YAML_Symphony_Formatter implements Mni\FrontYAML\Markdown\MarkdownParser{

		public function parse($string){
			$formatter =  TextformatterManager::create(Symphony::Configuration()->get('formatter', 'yaml'));
			return $formatter->run($string);
		}

	}
 