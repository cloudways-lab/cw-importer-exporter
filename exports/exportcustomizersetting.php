<?php

class CloudwaysExporter_exportcustomizersetting
{
	/**
	 * 
	 * 
	 */
	public function __construct()
	{
		$this->process();
	}
	
	public function process() {
		$settings = [];

		$astra_settings = get_option( 'astra-settings' );
		if ( ! empty( $astra_settings ) ) {
			$settings['astra-settings'] = $astra_settings;
		}

		$custom_css = wp_get_custom_css();
		if ( ! empty( $custom_css ) ) {
			$settings['custom-css'] = $custom_css;
		}
		$json = wp_json_encode($settings, JSON_PRETTY_PRINT);
        echo $json;
        return;

	}
}