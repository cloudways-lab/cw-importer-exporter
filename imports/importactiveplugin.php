<?php
class CloudwaysImporter_importactiveplugin
{
    /**
	 * Plugin slug to activate.
	 *
	 * @var string
	 */
	private $plugin;

	/**
	 * ActivatePlugin constructor.
	 *
	 * @param string $plugin Plugin slug to activate.
	 */
	public function __construct( $plugin ) {
        if(isset($plugin['plugin_name']) && $plugin['plugin_name']){
            $this->plugin = $plugin['plugin_name'];
            $this->process();
        }
		
	}

	/**
	 * Process the step.
	 *
	 * @return int Number of items that were successfully processed.
	 *             Returns -1 for failure.
	 */
	public function process() {
		WP_CLI::log(
			WP_CLI::colorize(
				"Installing and activating plugin %G'{$this->plugin}'%n..."
			)
		);

		$result = WP_CLI::runcommand(
			"plugin install {$this->plugin} --activate",
			[ 'return' => 'return_code' ]
		);

		return 0 === $result ? 1 : -1;
	}
}