# How to use
This plugin created to explore JetWooBuilder Add to Cart buttons functionality.
With the help of this plugin you will be able to add custom icons to Add to cart buttons,
setup their position and some basic styles.

### Products Grid widget
To use this plugin with Products Grid widget you need rewrite `item-button.php` template in your child theme:
1. In your child theme root folder create `jet-woo-builder/jet-woo-products/global` folders;
1. Find this template in the plugin here - `wp-content/plugins/jet-woo-builder/templates/jet-woo-products/global/item-button.php`
copy it and paste to your child theme created folder;
1. Open this template and paste this line of code `do_action( 'jet-woo-builder/templates/jet-woo-products/custom-button-icon', $settings );`
after line 21.

### Products List widget
To use this plugin with Products Grid widget you need rewrite `item-button.php` template in your child theme:
1. In your child theme root folder create `jet-woo-builder/jet-woo-products-list/global` folders;
1. Find this template in the plugin here - `wp-content/plugins/jet-woo-builder/templates/jet-woo-products-list/global/item-button.php`
   copy it and paste to your child theme created folder;
1. Open this template and paste this line of code `do_action( 'jet-woo-builder/templates/jet-woo-products-list/custom-button-icon', $settings );`
   after line 19.

### Archive Add to Cart & Single Add to Cart widgets
Just activate plugin.