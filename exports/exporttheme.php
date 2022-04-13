<?php
class CloudwaysExporter_exporttheme
{

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
		$active_theme = wp_get_theme();
		$child_theme  = $active_theme->get_stylesheet();
		$parent_theme = $active_theme->get_template();

        $array = [];
		if ( $parent_theme !== $child_theme ) {
            $array['installed_theme'] = $parent_theme;
			
		}
        $array['activate_theme'] = $child_theme;
		
        $json = wp_json_encode($array, JSON_PRETTY_PRINT);
        echo $json;
        return;

	}
}