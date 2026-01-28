<?php

/**
 * Twenty Twenty-Five Child Theme Functions
 * 
 * @package TwentyTwentyFive-Child
 */
 
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}


function twentytwentyfive_child_enqueue_styles()
{
    wp_enqueue_style('twentytwentyfive-parent-style', get_template_directory_uri() . '/style.css');


    wp_enqueue_style(
        'twentytwentyfive-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('twentytwentyfive-parent-style'),
        wp_get_theme()->get('Version')
    );
 

    wp_enqueue_script(
        'twentytwentyfive-child-script',
        get_stylesheet_directory_uri() . '/js/custom.js',
        array('jquery'),
        wp_get_theme()->get('Version'),
        true
    );
}
add_action('wp_enqueue_scripts', 'twentytwentyfive_child_enqueue_styles');


function add_promo_banner()
{
    echo '<div class="site-header-promo">Free domestic shipping on orders over $100</div>';
}
add_action('wp_head', 'add_promo_banner', 1);

function custom_product_page_layout()
{
    if (is_product()) {

        remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);


        add_action('woocommerce_single_product_summary', 'custom_product_category', 3);
        add_action('woocommerce_single_product_summary', 'custom_product_price', 15);
        add_action('woocommerce_single_product_summary', 'custom_product_short_description', 17);
        add_action('woocommerce_single_product_summary', 'custom_size_selector', 28);
        add_action('woocommerce_after_add_to_cart_button', 'custom_wishlist_button', 10);
        add_action('woocommerce_after_add_to_cart_form', 'custom_shipping_info', 10);
        add_action('woocommerce_after_add_to_cart_form', 'custom_product_features', 15);
        add_action('woocommerce_after_add_to_cart_form', 'custom_product_full_description', 20);
    }
}
add_action('wp', 'custom_product_page_layout');


function custom_product_category()
{
    global $product;
    $categories = wp_get_post_terms($product->get_id(), 'product_cat');
    if (!empty($categories)) {
        echo '<div class="product-category">' . esc_html(strtoupper($categories[0]->name)) . '</div>';
    }
}


function custom_product_price()
{
    global $product;

    $regular_price = $product->get_regular_price();
    $sale_price = $product->get_sale_price();

    echo '<p class="price">';

    if ($sale_price) {
        $discount_percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
        echo '<del><span class="woocommerce-Price-amount amount">';
        echo '<span class="woocommerce-Price-currencySymbol">$</span>' . esc_html($regular_price);
        echo '</span></del> ';
        echo '<ins><span class="woocommerce-Price-amount amount">';
        echo '<span class="woocommerce-Price-currencySymbol">$</span>' . esc_html($sale_price);
        echo '</span></ins>';
        echo '<span class="price-discount">-' . esc_html($discount_percentage) . '%</span>';
    } else {
        echo '<span class="woocommerce-Price-amount amount">';
        echo '<span class="woocommerce-Price-currencySymbol">$</span>' . esc_html($regular_price);
        echo '</span>';
    }

    echo '</p>';
}


function custom_product_short_description()
{
    global $post;

    if (!$post->post_excerpt) {
        return;
    }

    echo '<div class="woocommerce-product-details__short-description wp-block-post-excerpt__excerpt">';
    echo apply_filters('woocommerce_short_description', $post->post_excerpt);
    echo '</div>';
}


function custom_product_full_description()
{
    global $post;

    if (!$post->post_content) {
        return;
    }

    echo '<div class="product-full-description wp-block-woocommerce-product-description">';
    echo '<h3 class="product-details-title">Product Details</h3>';
    echo '<div class="product-description-content">';
    echo apply_filters('the_content', $post->post_content);
    echo '</div>';
    echo '</div>';
}


function custom_size_selector()
{
?>
    <div class="product-size-options">
        <label for="product-size">Size:</label>
        <div class="size-options">
            <button type="button" class="size-option" data-size="50ml">50ml</button>
            <button type="button" class="size-option active" data-size="100ml">100ml</button>
        </div>
        <input type="hidden" name="product_size" id="product-size" value="100ml">
    </div>
<?php
}


function custom_wishlist_button()
{
?>
    <button type="button" class="product-wishlist-btn" aria-label="Add to wishlist">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.28 2 8.5C2 5.42 4.42 3 7.5 3C9.24 3 10.91 3.81 12 5.09C13.09 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5C22 12.28 18.6 15.36 13.45 20.04L12 21.35Z" stroke="currentColor" stroke-width="2" fill="none" />
        </svg>
    </button>
<?php
}


function custom_shipping_info()
{
?>
    <div class="product-shipping-info">
        Shop the rest of February 14th - 16
    </div>
<?php
}


function custom_product_features()
{
?>
    <div class="product-features">
        <div class="product-feature">
            <div class="product-feature-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21 10C21 17 12 23 12 23C12 23 3 17 3 10C3 7.61305 3.94821 5.32387 5.63604 3.63604C7.32387 1.94821 9.61305 1 12 1C14.3869 1 16.6761 1.94821 18.364 3.63604C20.0518 5.32387 21 7.61305 21 10Z" stroke="currentColor" stroke-width="2" />
                    <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="2" />
                </svg>
            </div>
            <div class="product-feature-title">safe &</div>
            <div class="product-feature-text">none Toxic</div>
        </div>

        <div class="product-feature">
            <div class="product-feature-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" stroke="currentColor" stroke-width="2" />
                </svg>
            </div>
            <div class="product-feature-title">Dermatologist</div>
            <div class="product-feature-text">Tested</div>
        </div>

        <div class="product-feature">
            <div class="product-feature-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" />
                    <path d="M12 6V12L16 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                </svg>
            </div>
            <div class="product-feature-title">Money-back</div>
            <div class="product-feature-text">Guarantee</div>
        </div>

        <div class="product-feature">
            <div class="product-feature-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 11L12 14L22 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M21 12V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <div class="product-feature-title">Cruelty &</div>
            <div class="product-feature-text">Paraben Free</div>
        </div>
    </div>
<?php
}

function woocommerce_product_container_start()
{
    echo '<div class="product-main-container">';
}

function woocommerce_product_container_end()
{
    echo '</div>';
}

add_action('woocommerce_before_single_product_summary', 'woocommerce_product_container_start', 5);
add_action('woocommerce_after_single_product_summary', 'woocommerce_product_container_end', 5);


add_filter('woocommerce_quantity_input_args', 'custom_quantity_input_args', 10, 2);
function custom_quantity_input_args($args, $product)
{
    $args['min_value'] = 1;
    $args['max_value'] = $product->get_max_purchase_quantity();
    $args['input_value'] = 1;
    return $args;
}


remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

function custom_product_tabs($tabs)
{

    if (isset($tabs['description'])) {
        $tabs['description']['title'] = 'Detail';
    }

    return $tabs;
}
add_filter('woocommerce_product_tabs', 'custom_product_tabs', 98);

add_action('wp_footer', function () {
    if (is_product()) {
        echo '<!-- SINGLE PRODUCT PAGE -->';
    }
});


function custom_header_navigation()
{
?>
    <header class="site-header">
        <div class="header-container">
            <div class="site-branding">
                <h1 class="site-title">
                    <a href="<?php echo esc_url(home_url('/')); ?>">Lumina</a>
                </h1>
            </div>

            <nav class="main-navigation">
                <ul>
                    <li><a href="#">SHOP ▼</a></li>
                    <li><a href="#">BRANDS ▼</a></li>
                    <li><a href="#">OFFERS</a></li>
                    <li><a href="#">BLOG</a></li>
                    <li><a href="#">ABOUT</a></li>
                </ul>
            </nav>

            <div class="header-icons">
                <a href="#" aria-label="Search">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                </a>
                <a href="<?php echo esc_url(wc_get_cart_url()); ?>" aria-label="Cart">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                    </svg>
                </a>
                <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" aria-label="Account">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </a>
            </div>
        </div>
    </header>
<?php
}

function remove_default_header()
{
    remove_action('wp_head', '_wp_render_title_tag', 1);
}
add_action('after_setup_theme', 'remove_default_header');


function redirect_home_to_product()
{
    if (is_front_page() && !is_admin()) {
        $product_id = 63; 
        $product_url = get_permalink($product_id);

        if ($product_url) {
            wp_redirect($product_url, 301);
            exit;
        }
    }
}
add_action('template_redirect', 'redirect_home_to_product');
