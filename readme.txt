=== ACF Beautiful Flexible ===
Contributors: maximeculea
Donate link: https://www.paypal.com/paypalme/MaximeCulea
Tags: Advanced Custom Fields, ACF, ACF Addon, Flexible, Fields
Requires at least: 4.7
Requires php: 7.4
Tested up to: 5.9
Stable tag: 1.0.1
License: GPL v2 or later
License URI: https://github.com/MaximeCulea/acf-beautiful-flexible/blob/master/LICENSE.md

ACF Beautiful Flexible : Transform ACF's flexible layouts list into a beautiful popup.

== Description ==

To use ACF Beautiful Flexible, simply activate the plugin to improve the ACF flexible UI. By default, it uses random images, but the idea is to customize them by adding your own.

# Image convention

* The size of image should be 366x150 or bigger 732x300.
* They should be named based on the flexible key (`push_2_light`) with no underscores but dashes (`push-2-light.[extension]`).
* The following extensions will be resolved in that order: `.jpg`, `.jpeg`, `.png` and `.gif`.

# Where images should be situated

They should more likely be situated into your theme `wp-content\themes\my-theme\assets\acf-beautiful-flexible\`. But if you have a child-theme and added images into it, these will overwrite those from parent-theme.
The following directories will be solved according to order: plugin's folder, child theme's folder, theme's folder.

Also note that you can filter this path to gather all your images into a same folder :
`add_filter( 'acf_beautiful_flexible.images_path', $path );`

Finally, you could filter all images like this :
`add_filter( 'acf_beautiful_flexible.images', $images );`

# About ACF Beautiful Flexible

I, [Maxime Culea](https://profiles.wordpress.org/MaximeCulea), have created this plugin which I only maintain, which means I do not guarantee some free support. Consider reporting an issue and be patient.
Any code suggestions? I am on [GitHub](https://github.com/maximeculea/acf-beautiful-flexible) as well!

## Credits

Special thanks to HWK, from his [blogpost](https://hwk.fr/blog/acf-transformer-la-selection-des-layouts-du-contenu-flexible-en-modal), I created a WordPress plugin with custom tunings (js+css).
Couldn't contribute anymore to the [my first version](https://wordpress.org/plugins/bea-beautiful-flexible/) which was then abandoned.
Finally, created [my own plugin](https://wordpress.org/plugins/acf-beautiful-flexible) for prosperity and to personally follow plugin' support.

== Installation ==

This plugin works only if the [ACF Pro](https://www.advancedcustomfields.com/) plugin is installed and activated.

# Requirements

- [ACF Pro](https://www.advancedcustomfields.com/) plugin 5.6+
- WordPress 4.7+ because of `[get_theme_file_uri()](https://developer.wordpress.org/reference/functions/get_theme_file_uri)`
- Tested up to WordPress 5.9

# WordPress

- Download and install using the built-in WordPress plugin installer.
- Site activate in the "Plugins" area of the admin.
- Then [add](#details) your awesome layouts images.

== Screenshots ==

1. Show how ACF Beautiful Flexible improve the ACF's layouts UI.

== Changelog ==

= 1.0.1 - 30 April 2022 =
- Compatibility with latest versions of ACF and WordPress.
- Look for nested fields into repeaters and flexibles.

= 1.0.0 =
- FIX [#10](https://github.com/BeAPI/acf-beautiful-flexible/issues/10): fix warning
- Update readme with new requirements.
- FEATURE [#11](https://github.com/BeAPI/acf-beautiful-flexible/issues/11): add more filetype.
- FIX [#10](https://github.com/BeAPI/acf-beautiful-flexible/issues/10): fix warning.
- FIX [#8](https://github.com/BeAPI/acf-beautiful-flexible/issues/8): breaking changes with ACF 5.7.0 by adding new JS.
- Refactor way requirements are loaded by adding dedicated class.
- [#6](https://github.com/BeAPI/acf-beautiful-flexible/issues/6): fix title display.
- First version of the plugin.
- Dynamically get flexible layouts.
- Finish readme.
- Add screenshot.
- Add composer.json.
- Init plugin.
