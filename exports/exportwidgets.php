<?php

class CloudwaysExporter_exportwidgets {

    public function __construct()
    {
        $this->process();
    }
    /**
	 * Process the export step.
	 *
	 * @param ExportResult $export_result Export result to adapt.
	 *
	 * @return ExportResult Adapted export result.
	 */
	public function process() {
		$exported_widgets = [];

		foreach ( wp_get_sidebars_widgets() as $sidebar => $widgets ) {
			$exported_widgets[ $sidebar ] = [];
			foreach ( $widgets as $widget_instance_id ) {
				// Get id_base (remove -# from end) and instance ID number.
				$id_base        = preg_replace( '/-[0-9]+$/', '', $widget_instance_id );
				$instance       = preg_replace( '/^' . preg_quote( $id_base, '/' ) . '-/', '', $widget_instance_id );
				$widget_options = get_option( 'widget_' . $id_base, [] );
				$exported_widgets[ $sidebar ][ $widget_instance_id ] = $widget_options[ (int) $instance ];
			}
		}
        $array = [];
        $array['widgets'] = $exported_widgets;
		$json = wp_json_encode($array, JSON_PRETTY_PRINT);
        echo $json;
        return;
	}
}