# Semicolon theme for WordPress

Semicolon is a simple and clean magazine theme for WordPress. It has a 
responsive layout, clean and easy to read typography, a unique grid layout
with featured posts support, a few widget areas, a special menu for your
social profiles and much more.

FAQ: http://kovshenin.com/themes/semicolon/


# Featured Posts

Featured posts in Semicolon are a bit unique, and you’ll need the Jetpack plugin
installed and active on your site. To mark posts as featured, you’ll first have to configure
Jetpack’s Featured Content module from Appearance - Customize - Featured Content.
You’ll be able to select a tag for all your featured posts.

When tagging your posts with the selected featured tag, you’ll notice that some of
them double in size in the grid layout, and the latest two featured posts are also
bumped to the top of the front page.

If you’re wondering why a certain featured post hasn’t doubled in size, that’s probably
because it’s at a position which would cause it to wrap to the next row if doubled,
thus breaking the grid.

If you’re experiencing weird sizes with your thumbnails in Semicolon, you can use the
Regenerate Thumbnails or the Photon module from Jetpack to correct that.


# Custom Colors

The Custom Colors feature in Semicolon is powered by Jetpack's Custom CSS module.
After installing Jetpack and activating the module, you'll see several extra options
in the theme customizer (Appearance &rarr; Customize). There's also an "Auto Contrast"
switch that will make sure your text remains readable regardless of what colors
you have picked.


# Social Menu

Semicolon ships with support for over 20 social networking websites, including Twitter,
Facebook, Google+, YouTube, GitHub, Tumblr, and others. To add social profiles icons to
the theme, you’ll have to create a new menu under Appearance - Menus.

Hit “create a new menu” and add some items for your social profiles using Custom Links.
When you’re done, assign the newly created menu to the “Social Menu” theme location. Visit
your home page and you’ll see that your links are now icons. If you’re looking for the RSS
feed icon, simply use your feed address as the URL for a custom link,
such as http://kovshenin.com/feed.


# Related Posts

The magazine theme has a “related posts” section on single posts. By default, it uses a
simple algorithm to fetch recent posts in the same category. If you’d like more control
over related posts, Semicolon supports the popular YARPP plugin.


# Author Bios

The magazine theme has a “related posts” section on single posts. By default, it uses a
simple algorithm to fetch recent posts in the same category. If you’d like more control
over related posts, Semicolon supports the popular YARPP plugin.


# Widget Areas

Semicolon has four widget areas in total. Three on the side, and one at the bottom. The
three widget areas on the side differ only in background color, and you’ll usually want
to use just one widget in the primary section, which has a blue background to attract
attention. It’s pretty useful for things like newsletter subscriptions.

The footer widget area is less prominent and is useful mainly for links. Widgets in the
footer area are stacked horizontally and you shouldn’t be using more than three. Custom Menu
widgets work best in the footer area.


# Support

Please use the WordPress.org forums for support and feedback:
http://wordpress.org/support/theme/semicolon


# Changelog

= 0.9 =

* Feature: Inline controls to edit or feature posts
* Feature: Custom colors via Jetpack's Custom CSS module
* Feature: Auto contrast correction for custom colors
* Enhancement: Add an editor stylesheet
* Enhancement: Larger screenshot for hi-dpi devices
* Enhancement: Added a readme file with features descriptions
* Bug: Don't use core's bundled Open Sans declaration
* Bug: Fix YARPP posts per page and add a filter

= 0.8.1 =

* Initial public release