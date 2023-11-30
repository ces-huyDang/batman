# Quicktabs

This module provides a form for admins to create a block of tabbed content by
selecting a view, a node, a block or an existing Quicktabs instance as the
content of each tab. The module can be extended to display other types of
content.

## Requirements

The main Quicktabs module does not require any additional modules. However, use
of the submodules Quicktabs Accordion and Quicktabs jQuery UI require
jquery_ui_accordion and jquery_ui_tabs modules respectively. By including this
module through composer, those modules will be downloaded as well. You must
enable the ones you need.

## Installation & Use:

1.  Enable module in module list located at administer > structure > modules.
2.  Go to admin/structure/quicktabs and click on "Add Quicktabs Instance".
3.  Add a title (this will be the block title) and start entering information
    for your tabs
4.  Use the Add another tab button to add more tabs.
5.  Tab titles can use a minimal set of HTML tags, specifically _img_, _em_,
    _strong_, _h2_, _h3_, _h4_, _h5_, _h6_, _small_, _span_, _i_ and _br_.
6.  Use the drag handles on the left to re-arrange tabs.
7.  Once you have defined all the tabs, click 'Save'.
8.  Be sure to FLUSH THE CACHE - when working with blocks you need to flush the
    cache whenever you make a change
9.  Your new block will be available at admin/structure/blocks.
10.  Configure & enable it as required.

## Note:

Because Quicktabs allows your tabbed content to be pulled via ajax, it has its
own menu callback for getting this content and returning it in JSON format. For
node content, it uses the standard node_access check to make sure the user has
access to this content. It is important to note that ANY node can be viewed
from this menu callback; if you go to it directly at quicktabs/ajax/node/[nid]
it will return a JSON text string of the node information. If there are certain
fields in ANY of your nodes that are supposed to be private, these MUST be
controlled at admin/content/node-type/MY_NODE_TYPE/display by setting them to
be excluded on teaser and node view. Setting them as private through some other
mechanism, e.g., Panels, will not prevent them from being displayed in an ajax
Quicktab.

## For Developers:

One way to extend Quicktabs is to add a renderer plugin. Quicktabs comes with
3 renderer plugins: jQuery UI Tabs, jQuery UI Accordion, and classic Quicktabs.
A renderer plugin is a class that extends the QuickRenderer class and implements
the render() method, returning a render array that can be passed to
drupal_render(). See any of the existing renderer plugins for examples. Also see
Quicktabs' implementation of hook_quicktabs_renderers().

Lastly, Quicktabs can be extended by adding new types of entities that can be
loaded as tab content. Quicktabs itself provides the node, block, view, qtabs
and callback tab content types. Your contents plugins should extend the
QuickContent class. See the existing plugins and the hook_quicktabs_contents
implementation for guidance.


## Author:

Mike Garthwaite <michael@systemick.co.uk>
https://www.drupal.org/u/systemick

## Maintainers

Mike Garthwaite <michael@systemick.co.uk>
https://www.drupal.org/u/systemick

Shelane French
https://www.drupal.org/u/shelane

Nick Dickinson-Wilde
https://www.drupal.org/u/nickdickinsonwilde
