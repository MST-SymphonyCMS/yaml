<?php

	Class formatterYAML extends TextFormatter{

		private static $_parser;

		public function about(){
			return array(
				'name' => 'YAML',
				'version' => '1.0',
				'release-date' => '2016-07-17',
				'author' => array(
					'name' => 'Jon Mifsud',
					'website' => 'https://maze.digital',
					'email' => 'jon@maze.digital'
				),
				'description' => 'Write entries in the YAML + Markdown. Supports YAML on top of your standard markdown formatters.'
			);
		}

		public function run($string){

			require_once( EXTENSIONS . '/yaml/vendor/autoload.php');

			// set a symphony formatter if available
			$markdownParser = null;
			$formatter = Symphony::Configuration()->get('formatter', 'yaml');
			if (!empty($formatter)){
				require_once( EXTENSIONS . '/yaml/lib/class.yaml_symphony_formatter.php');
				$markdownParser = new YAML_Symphony_Formatter();
			}

			// create parser with custom symphony formatter
			$parser = new Mni\FrontYAML\Parser(null,$markdownParser);

			// parse with YAML
			$document = $parser->parse($string);

			$yaml = $document->getYAML();
			$html = $document->getContent();

			$yamlXML = new XMLElement('yaml');

			foreach ($yaml as $key => $value) {
				$yamlXML->appendChild( new XMLElement($key,$value));
			}

			// append YAML as xml inside XML for parsing
			$html = $yamlXML->generate(true) . $html;

			// Markdown transformation
			$result = stripslashes($html);

			return $result;
		}

	}

