<?php

class CloudwaysImporter extends WP_CLI_Command {


	private $args;

	public function __invoke($args, $assoc_args)
	{
		$this->args = $args;
		
		if ($args && $args[0] == 'imports') {
			$this->imports();
			return;
		}

		if ($args && $args[0] == 'exports') {
			$this->exports();
			return;
		}

		if ($args && $args[0] == 'do-import' && $args[1]) {
			$this->doimports($assoc_args);	
			return;
		}

		if ($args && $args[0] == 'do-export' && $args['1']) {
			$this->doexports($assoc_args);
			return;
		}

		$commands = array(
			'imports' => __('Show availabled imports', 'wp-cloudways-import'),
			'exports' => __('Show availabled exports', 'wp-cloudways-import'),
			'do-import' => __('Do selected import', 'wp-cloudways-import'),
			'do-export' => __('Do selected export', 'wp-cloudways-import'),
		);

		foreach ($commands as $command => $description) {
			WP_CLI::log(sprintf("     %-25s %s", $this->colorize($command, 'bright'), $description));
		}
	}



	public function imports(){
		
		$array = [];
		$array['importwidgets'] = __('Imports wordpress widgets, use params: --sidebar_id=\'sidebar-id\' --widget_instance_id=\'recent-comments\' --widget_name=\'Recent Comments\'  ', 'wp-cloudways-import');
		$array['importcustomizersetting'] = __('Import customizer setting, use params: --astra-settings  or --custom-css');
		$array['importwxrfile'] = __('Import WXR file, use params: --file_path');
		$array['importoptions'] = __('Import options, use params: --options=\'{"optionname":"value1", "optionname":"value2"}\'  json key value pair strings');
		$array['importtheme'] = __('Import theme, use params: --theme_name ');
		$array['importthememods'] = __('Import theme mods, use params: --theme_mods=\'{"nav_menu_locations":"value1"}\'  json key value pair strings');
		$array['importactiveplugin'] = __('Import wordpress plugin, use params: --plugin_name');
		foreach($array as $id => $imports) {
			WP_CLI::log(sprintf("     %-25s %s", $id, $imports));
		}
		
	}
	public function exports(){
		
		$array = [];
		$array['exportactiveplugin'] = __('Export active plugin', 'wp-cloudways-import');
		$array['exportcustomizersetting'] = __('Export customizer setting', 'wp-cloudways-import');
		$array['exportoptions'] = __('Export Options', 'wp-cloudways-import');
		$array['exporttheme'] = __('Export Themes', 'wp-cloudways-import');
		$array['exportthememods'] = __('Export Theme Mods', 'wp-cloudways-import');
		$array['exportwidgets'] = __('Export Widgets', 'wp-cloudways-import');
		foreach($array as $id => $exports) {
			WP_CLI::log(sprintf("     %-25s %s", $id, $exports));
		}
		
	}

	public function doimports($assoc_args){
		$imports = array();
		$imports_dir = __DIR__.'/imports';
		
		   if ($dh = opendir($imports_dir)) {

			while (($file = readdir($dh)) !== false) {

				if ('.' == $file || '..' == $file || '.php' != substr($file, -4, 4) || !is_file($imports_dir.'/'.$file) || 'inactive-' == substr($file, 0, 9)) continue;
				$imports[] = substr($file, 0, (strlen($file) - 4));

			}
			closedir($dh);
			if (!in_array($this->args[1], $imports)){
				WP_CLI::error('No importer found');
				return;
			}
			foreach ($imports as $import) {
				
				if ($import == $this->args[1]) {
					
					$optimization_file = __DIR__.'/imports/'.$import.'.php';
					include_once($optimization_file);
					$class = "CloudwaysImporter_".$this->args[1];
					new $class($assoc_args);
				}
				
			}
			

			
		}
		
	}

	public function doexports($assoc_args){
		$exports = array();
		$exports_dir = __DIR__.'/exports';
		if ($dh = opendir($exports_dir)) {

			while (($file = readdir($dh)) !== false) {

				if ('.' == $file || '..' == $file || '.php' != substr($file, -4, 4) || !is_file($exports_dir.'/'.$file) || 'inactive-' == substr($file, 0, 9)) continue;
				$exports[] = substr($file, 0, (strlen($file) - 4));

			}
			closedir($dh);
			if (!in_array($this->args[1], $exports)){
				WP_CLI::error('No exporters found');
				return;
			}
			foreach ($exports as $export) {
				
				if ($export == $this->args[1]) {
					
					$optimization_file = __DIR__.'/exports/'.$export.'.php';
					include_once($optimization_file);
					$class = "CloudwaysExporter_".$this->args[1];
					new $class($assoc_args);
				}
				
			}
		}
	}


	private function colorize($string, $color) {
		$tokens = array(
			'yellow' => '%y', // ['color' => 'yellow',
			'green' => '%g', // ['color' => 'green'],
			'blue' => '%b', // ['color' => 'blue'],
			'red' => '%r', // ['color' => 'red'],
			'magenta' => '%p', // ['color' => 'magenta'],
			'magenta' => '%m', // ['color' => 'magenta',
			'cyan' => '%c', // ['color' => 'cyan',
			'grey' => '%w', // ['color' => 'grey',
			'black' => '%k', // ['color' => 'black',
			'reset' => '%n', // ['color' => 'reset',
			'yellow_bright' => '%Y', // ['color' => 'yellow', 'style' => 'bright',
			'green_bright' => '%G', // ['color' => 'green', 'style' => 'bright',
			'blue_bright' => '%B', // ['color' => 'blue', 'style' => 'bright',
			'red_bright' => '%R', // ['color' => 'red', 'style' => 'bright',
			'magenta_bright' => '%P', // ['color' => 'magenta', 'style' => 'bright',
			'magenta_bright_2' => '%M', // ['color' => 'magenta', 'style' => 'bright',
			'cyan_bright' => '%C', // ['color' => 'cyan', 'style' => 'bright',
			'grey_bright' => '%W', // ['color' => 'grey', 'style' => 'bright',
			'black_bright' => '%K', // ['color' => 'black', 'style' => 'bright',
			'reset_bright' => '%N', // ['color' => 'reset', 'style' => 'bright',
			'yellow_bg' => '%3', // ['background' => 'yellow',
			'green_bg' => '%2', // ['background' => 'green',
			'blue_bg' => '%4', // ['background' => 'blue',
			'red_bg' => '%1', // ['background' => 'red',
			'magenta_bg' => '%5', // ['background' => 'magenta',
			'cyan_bg' => '%6', // ['background' => 'cyan',
			'grey_bg' => '%7', // ['background' => 'grey',
			'black_bg' => '%0', // ['background' => 'black',
			'blink' => '%F', // ['style' => 'blink',
			'underline' => '%U', // ['style' => 'underline',
			'inverse' => '%8', // ['style' => 'inverse',
			'bright' => '%9', // ['style' => 'bright',
			'bright_2' => '%_' // ['style' => 'bright']
		);

		$token = isset($tokens[$color]) ? $tokens[$color] : $tokens['bright'];
		return WP_CLI::colorize($token.$string.'%n');
	}
}


WP_CLI::add_command( 'cw-importer', 'CloudwaysImporter' );
