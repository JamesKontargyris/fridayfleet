=== Genesis Custom Blocks Pro ===

Contributors: lukecarbis, ryankienstra, Stino11, rheinardkorf, studiopress, wpengine
Tags: gutenberg, blocks, block editor, fields, template
Requires at least: 5.4
Tested up to: 5.6
Stable tag: 1.1.0
Requires PHP: 5.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl

Custom blocks for WordPress made easy.

== Description ==

Genesis Custom Blocks Pro provides WordPress developers with the tools they need to take control of the block-first reality of modern WordPress.

The WordPress block editor (AKA Gutenberg) opens up a whole new world for the way we build pages, posts, and websites with WordPress. Genesis Custom Blocks Pro makes it easy to harness this and build custom blocks the way you want them to be built. Whether you want to implement a custom design, deliver unique functionality, or even remove your dependence on other plugins, Genesis Custom Blocks Pro equips you with the tools you need to hit “Publish” sooner.

**Take control of design** - Implement beautiful, custom designs with fine-tuned front-end templating control.

**Build unique functionality** - Build blocks that function and behave exactly as you need.

**Extend & Integrate** - Easily extend your custom blocks to integrate with third-party apps and plugins.

== Features ==

= A Familiar Experience =
Work within the WordPress admin with an interface you already know.

= Block Fields =
Add from a growing list of available fields to your custom blocks.

= Simple Templating =
Let the plugin do the heavy lifting so you can use familiar WordPress development practices to build block templates.

= Developer Friendly Functions =
Simple to use functions, ready to render and work with the data stored through your custom block fields.

= Block-level Import & Export =
Easily export and import individual blocks to better share block assets between projects.

== Currently available block fields ==
* Text Field
* Image Field
* URL Field
* Toggle Field
* Textarea Field
* Select Field
* Range Rield
* Radio Field
* Number Field
* Multi-select Field
* Email Field
* Color Field
* Checkbox Field
* Repeater Field
* Taxonomy Field
* Post Field
* User Field
* Rich Text Field
* Classic Text Field

== Developer docs you can rely on. ==

Developer tools are only as good as their docs. That's why we take them seriously. Here are a few links to get you started:

== Links ==
* [Getting Started](https://developer.wpengine.com/genesis-custom-blocks/get-started/)
* [FAQs](https://developer.wpengine.com/genesis-custom-blocks/faqs/)
* [Block Fields](https://developer.wpengine.com/genesis-custom-blocks/fields/)
* [PHP Functions](https://developer.wpengine.com/genesis-custom-blocks/functions/)

== Installation ==
* Upload the plugin directory to `/wp-content/plugins/`
* Activate this plugin via `/wp-admin` > Plugins
* There's no need to also install the [free Genesis Custom Blocks plugin](https://wordpress.org/plugins/genesis-custom-blocks)

== Frequently Asked Questions ==
**Q: Do I need to work with the Genesis Framework or any of the other Genesis plugins/themes to use this plugin?**
A: No. You can use this plugin completely independently. All you need is to have the block editor enabled on your WordPress site.

**Q: Do I need to have the free Genesis Custom Blocks Pro plugin installed (from wordpress.org) to be able to use Pro?**
A: No. The Pro plugin contains all the features of the free plugin as well as the advanced features. This is the only plugin you need installed/active.

== Changelog ==

= 1.1.0 - 2020-01-27 =

Completely redesigned, more effortless editor! With undo/redo buttons and a separate editor/inspector.

* Restore and update e2e tests. [PR 24](https://github.com/studiopress/genesis-custom-blocks-pro/pull/24)
* Add settings components for pro fields. [PR 55](https://github.com/studiopress/genesis-custom-blocks-pro/pull/16)
* Repeater improvements for new editor. [PR 23](https://github.com/studiopress/genesis-custom-blocks-pro/pull/23)

= 1.0.4 - 2020-12-09 =

More reliable checks for subscription key, bump 'Tested up to' to 5.6

* Improve checks for subscription key. [PR 18](https://github.com/studiopress/genesis-custom-blocks-pro/pull/18)
* Bump the 'Tested up to' version to 5.6. [PR 21](https://github.com/studiopress/genesis-custom-blocks-pro/pull/21)

= 1.0.3 - 2020-10-21 =

Allow more text and improve activation experience

* Allow fields with a huge amount of text. [PR 39](https://github.com/studiopress/genesis-custom-blocks/pull/39)
* Ensure that all submenus appear on first installation. [PR 40](https://github.com/studiopress/genesis-custom-blocks/pull/40)

= 1.0.2 - 2020-09-16 =

Bugfixes, including saving the subscription key

* Fix an error in saving the subscription key. [PR 11](https://github.com/studiopress/genesis-custom-blocks-pro/pull/11)
* Fix a PHP notice on /wp-admin > Plugins > Add New. [PR 12](https://github.com/studiopress/genesis-custom-blocks-pro/pull/12)

= 1.0.1 - 2020-09-01 =

Fix an error if Block Lab 1.5.6 is also active

* Fixes an error with Block Lab 1.5.6, where it defines functions twice
* Error does not occur with latest Block Lab

= 1.0.0 - 2020-09-01 =

Plugin released!

* 19 fields, including a Repeater, Post, and User.
* Easy templating, with PHP files.
* Block-level importing and exporting.
