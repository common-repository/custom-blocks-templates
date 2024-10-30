=== Custom Blocks Templates ===
Contributors: sirvelia
Donate link: https://sirvelia.com/
Tags: block, template, gutenberg, fontawesome, dynamic
Requires at least: 5.0
Tested up to: 6.2
Requires PHP: 7.2
Stable tag: trunk
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Create and set Gutenberg blocks templates for posts, pages and custom post types

== Description ==

Create and set Gutenberg blocks templates for your posts, pages and custom post types.

1. Go to <strong>Blocks Templates</strong>->Create Template in your admin panel.
2. Start creating your template, adding any blocks you'd like with the Gutenberg editor.
3. Assign your newly created template to any post type (post, page or custom).
4. The template will be set as the default content of new posts of that type.

<strong>CBT also includes some blocks ;)</strong>

<ul>
<li><strong>Private Block</strong>: A block that helps you protect your content and control its visibility. You can protect anything inside this "block container" with a password, allow only logged-in members to see the contents, filter by user role and display only in single or archive pages.</li>
<li><strong>Accordion</strong>: An accordion-like drop down with a header and InnerBlocks, so you can create multiple accordions inside.</li>
<li><strong>CSV Tables</strong>: Allows you to import a CSV file and show its contents in a table with search and order functionality.</b></li>
<li><strong>Card</strong>: A simple bordered box with a header and custom content (Inner Blocks).</li>
<li><strong>Social share</strong>: Choose your favorite social media platforms and allow visitors to share your content easily. Supports: Buffer, Diaspora, Douban, Evernote, Facebook, Flipboard, Hacker News, Hatena, Kakao Story, LINE, LinkedIn, Menéame, Mixi, Pinterest, Pocket, Qzone, Reddit, Renren, Telegram, Tumblr, Twitter, VK, Weibo, WhatsApp and Xing</li>
</ul>

<strong>And new controls for any blocks with rich text!</strong>

<ul>
<li><strong>Font Awesome Icons</strong>: Search Font Awesome 5 icons and include it in your posts as inline elements.</li>
<li><strong>Dynamic Text</strong>: Display the author name, post title, published date, categories and/or tags anywhere on your posts.</li>
</ul>

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload `custom-blocks-templates` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= How are blocks templates useful? =

If your posts have some common structure, having a template will save you a lot of time. An author block, social share buttons, a column layout, a review box, related posts, some logos... You can put as many blocks as you like and set that as your default template for any post type.


== Screenshots ==

1. There is a menu on the admin area called "Custom Blocks Templates". You will be able to create and edit your Templates from this page.
2. Creating a Template is similar than the process of a post creation.
3. You can add as any blocks as you want.
4. Then, you can assign Templates to any Post Type on your site.
5. And you can start creating content with the structure from the Template

== Changelog ==

= 1.3.1 =
* Fix: Templates locked/orderable/editable

= 1.3 =
* New format: Font awesome icons
* CBT blocks list: Easy insertion from Inspector Panel
* New attribute: Card background color
* Add example previews to CBT blocks
* Fix: Accordion block (Set a unique id to avoid conflicts with same-name headings)
* Fix: Private Blocks (Add support for all user roles)
* Fix: Dynamic Text (PHP error with empty content)

= 1.2 =
* New block: Social share (with 25 social networks to choose from)
* New format: Dynamic text (author, date, title, categories and tags)
* Visual improvements in admin area
* Block list tree in edit Inspector panel
* Fix: Accordion block (position relative)

= 1.1.1 =
* Fix: Card and Accordion blocks RichText controls
* Private Block visual improvements

= 1.1 =
* Import/Export templates in JSON
* Preview Templates
* Fix: Database prefix

= 1.0 =
* Initial release.
