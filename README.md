To view all the options in WPCLI

```
wp cw-importer
```

This will show all the available options in this package

```
	imports           Show availabled imports
     exports           Show availabled exports
     do-import         Do selected import
     do-export         Do selected export
```

To view all imports

```
wp cw-importer imports
```

Which shows available imports

```
     importwidgets             Imports wordpress widgets, use params: --sidebar_id='sidebar-id' --widget_instance_id='recent-comments' --widget_name='Recent Comments'
     importcustomizersetting   Import customizer setting, use params: --astra-settings  or --custom-css
     importwxrfile             Import WXR file, use params: --file_path
     importoptions             Import options, use params: --options='{"optionname":"value1", "optionname":"value2"}'  json key value pair strings
     importtheme               Import theme, use params: --theme_name
     importthememods           Import theme mods, use params: --theme_mods='{"nav_menu_locations":"value1"}'  json key value pair strings
     importplugin              Import wordpress plugin, use params: --plugin_name
```

To run specific imports . For eg.

```
wp cw-importer do-import importactiveplugin --plugin_name=eventon-api 
```

use the arguments as shown in help

To view all exports

```
wp cw-importer exports
```

Which shows all exports

```
	exportactiveplugin        Export active plugin
     exportcustomizersetting   Export customizer setting
     exportoptions             Export Options
     exporttheme               Export Themes
     exportthememods           Export Theme Mods
     exportwidgets             Export Widgets
```

To run specific exports. For eg.

```
wp cw-importer do-export exportactiveplugin
```