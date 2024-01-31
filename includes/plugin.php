<?php

add_action('admin_enqueue_scripts', 'PTGold_init');
function PTGold_init(){

    wp_enqueue_style(
        'Admin-style-Gold',
        PTGold_ASSETS_URL . 'css/admin-style-gold.css',
    );

}

// /**
//  * Add documentation link into plugin page
// */
// add_filter( 'plugin_row_meta', 'PTGOLD_plugin_row_meta', 10, 2 );
// function PTGOLD_plugin_row_meta( $links, $file ) {
//     if ( 'gold-price-based-on-weight/gold-price.php' == $file ) {
//         $row_meta = array(
//           'docs'    => '<a href="' . esc_url( '#' ) . '" target="_blank" aria-label="' . esc_attr__( 'Plugin Additional Links', 'gold-price-based-on-weight' ) . '" style="color:green;">' . esc_html__( 'Documentation', 'gold-price-based-on-weight' ) . '</a>'
//         );

//         return array_merge( $links, $row_meta );
//     }
//     return (array) $links;
// }

add_action( 'woocommerce_product_options_general_product_data', 'woo_add_jewellery_field' );
function woo_add_jewellery_field(){
    $field = array(
        'id' => 'jewellery_field',
        'label' => __( 'Select Gold 18K / Gold 22K / Gold 24K / Silver / Platinum', 'store' ),
        'desc_tip' => true,
        'description' => __( 'Select an option.', 'ctwc' ),
        'options'     => array(
            '0'        => __( 'Select Option', 'woocommerce' ),
            '1'       => __('Gold 18K', 'woocommerce' ),
            '2'       => __('Gold 22K', 'woocommerce' ),
            '3'       => __('Gold 24K', 'woocommerce' ),
            '4'       => __('Silver', 'woocommerce' ),
            '5'       => __('Platinum', 'woocommerce' ),
        ),
    ); 
    
    woocommerce_wp_select( $field );
}

add_action( 'woocommerce_process_product_meta', 'woo_add_jewellery_field_save' );
function woo_add_jewellery_field_save( $post_id ){

  $jewellery_field  = $_POST['jewellery_field'];
  if( !empty( $jewellery_field ) )
      update_post_meta( $post_id, 'jewellery_field', esc_attr( $jewellery_field ) );
  else {
      update_post_meta( $post_id, 'jewellery_field',  '' );
  }
}

// Add gemstone price field to product general settings
add_action( 'woocommerce_product_options_general_product_data', 'woo_add_gemstone_price_field' );
function woo_add_gemstone_price_field(){
    $field = array(
        'id' => 'gemstone_price_field',
        'label' => __( 'Gemstone Price', 'store' ),
        'desc_tip' => true,
        'description' => __( 'Enter the gemstone price.', 'ctwc' ),
    ); 
    
    woocommerce_wp_text_input( $field );
}

// Save gemstone price field value
add_action( 'woocommerce_process_product_meta', 'woo_save_gemstone_price_field' );
function woo_save_gemstone_price_field( $post_id ){

  $gemstone_price_field  = $_POST['gemstone_price_field'];
  if( !empty( $gemstone_price_field ) )
      update_post_meta( $post_id, 'gemstone_price_field', esc_attr( $gemstone_price_field ) );
  else {
      update_post_meta( $post_id, 'gemstone_price_field',  '' );
  }
}

// making charge filed in percentage
add_action( 'woocommerce_product_options_general_product_data', 'woo_add_making_charges_percentage_field' );
function woo_add_making_charges_percentage_field() {
    woocommerce_wp_text_input( array(
        'id' => 'making_charges_percentage_field',
        'label' => __( 'Making Charges (%)', 'store' ),
        'desc_tip' => 'true',
        'description' => __( 'Enter the making charges as a percentage of the gold price.', 'store' ),
        'type' => 'number',
        'custom_attributes' => array(
            'step' => 'any',
            'min' => '0'
        ),
    ));
}

// save making charge field
add_action( 'woocommerce_process_product_meta', 'woo_save_making_charges_percentage_field' );
function woo_save_making_charges_percentage_field( $post_id ) {
    $making_charges_percentage = isset( $_POST['making_charges_percentage_field'] ) ? $_POST['making_charges_percentage_field'] : '';
    update_post_meta( $post_id, 'making_charges_percentage_field', sanitize_text_field( $making_charges_percentage ) );
}

function GoldPriceMenu() {
    add_menu_page(
        __( 'Gold Price', 'my-textdomain' ),
        __( 'Gold Price', 'my-textdomain' ),
        'manage_options',
        'gold-price',
        'GoldPricePageMenu',
        'dashicons-money-alt',
        3
    );
}
add_action( 'admin_menu', 'GoldPriceMenu' );

function GoldPricePageMenu() {
    ?>
    <div class="infinity-gold-price">
        <div class="infinity-wrapper">
            <div class="infinity-boxes infinity-header">
                <div class="infinity-box infinity-page-title">
                    <h1>
                        <?php esc_html_e( 'Gold Price : Based On Weight'); ?>
                    </h1>
                </div>
                <div class="infinity-box infinity-logo">
                    <a href="https://www.buildyourinnovation.com/" target="_blank"><img src="https://buildyourinnovation.com/images/byi.png" alt="BYI Logo"></a>
                </div>
            </div>
            
            <div class="infinity form-wrap">
                <div id="infinity-container" class="wp-clearfix">
                    <div class="infinity-sub-title">
                        <h2><span><img src="<?= PTGold_ASSETS_URL; ?>uploads/check-mark.png" alt="Check Mark"></span><?php esc_html_e( 'Gold Price: Based On Weight'); ?></h2>
                        <p><?php esc_html_e( "- Establishing a global price per gram of Gold, Silver, and Platinum and utilizing the weight of each product, the price can be automatically calculated based on this rate, making the pricing process more efficient and accurate for all Woo-Commerce simple products and variable products."); ?></p>
                    </div>
                    <form method="POST" action="options.php" class="infinity-form">
                        <?php
                            settings_fields( 'gold-price' );
                            do_settings_sections( 'gold-price' );
                            submit_button();
                        ?>
                    </form>
                    <div class="infinity-sub-title">
                        <h2><span><img src="<?= PTGold_ASSETS_URL; ?>uploads/check-mark.png" alt="Check Mark"></span><?php esc_html_e( "Contact Us !"); ?></h2>
                        <p><?php esc_html_e( "- If you require assistance with customizations or wish to hire a developer, please feel free to contact us via email."); ?></p>
                        <p>- Email : <a href="mailto:mohammed@buildyourinnovation.com" class="link-yellow"><?php esc_html_e( "mohammed@buildyourinnovation.com"); ?></a></p>
                    </div>
                </div>
            </div>
            
            <div class="infinity-footer">
                <div class="infinity-box infinity-page-title">
                    <h3>
                        <?php esc_html_e( 'Gold Price : Based On Weight'); ?>
                    </h3>
                </div>
                <div class="infinity-box infinity-logo">
                    <label>Developed By - <a href="https://www.buildyourinnovation.com/" target="_blank">Build Your Innovation</a></label>
                </div>
            </div>
        </div>
    </div>
    <?php
}

add_action( 'admin_init', 'GoldPriceInit' );

function GoldPriceInit() {

    add_settings_section(
        'gold_price_setting_section',
        __( "", 'my-textdomain' ),
        'GoldPriceCBFun',
        'gold-price'
    );
    add_settings_field( 
        'gold-18k',
        'Gold Price 18K', 
        'GoldPriceSetting', 
        'gold-price', 
        'gold_price_setting_section', 
        array( 
            'gold-18k' 
        )  
    ); 
	add_settings_field( 
        'gold-22k',
        'Gold Price 22K', 
        'GoldPriceSetting', 
        'gold-price', 
        'gold_price_setting_section', 
        array( 
            'gold-22k' 
        )  
    );
	add_settings_field( 
        'gold-24k',
        'Gold Price 24K', 
        'GoldPriceSetting', 
        'gold-price', 
        'gold_price_setting_section', 
        array( 
            'gold-24k' 
        )  
    );
    add_settings_field( 
        'silver', 
        'Silver Price',
        'GoldPriceSetting',
        'gold-price', 
        'gold_price_setting_section', 
        array( 
            'silver' 
        )  
    ); 
    add_settings_field( 
        'platinum', 
        'Platinum Price',
        'GoldPriceSetting',
        'gold-price', 
        'gold_price_setting_section', 
        array( 
            'platinum' 
        )  
    ); 
    register_setting('gold-price','gold-18k', 'esc_attr');
    register_setting('gold-price','gold-22k', 'esc_attr');
    register_setting('gold-price','gold-24k', 'esc_attr');
    register_setting('gold-price','silver', 'esc_attr');
    register_setting('gold-price','platinum', 'esc_attr');
}
function GoldPriceCBFun() {
    esc_html_e( '', 'my-textdomain' );
}
function GoldPriceSetting($args) {  // Textbox Callback
    $option = get_option($args[0]);
    echo '<input type="text" id="'. $args[0] .'" name="'. $args[0] .'" value="' . $option . '" />';
}

function GoldPriceCalc($metals) {
    if($metals == '1'){
        return get_option('gold-18k');
    }
	if($metals == '2'){
        return get_option('gold-22k');
    }
	if($metals == '3'){
        return get_option('gold-24k');
    }
    if($metals == '4'){
        return get_option('silver');
    }
     if($metals == '5'){
        return get_option('platinum');
    }
}

// Simple, grouped and external products
add_filter('woocommerce_product_get_price', 'GoldPrice', 99, 2 );
add_filter('woocommerce_product_get_regular_price', 'GoldPrice', 99, 2 );
// Variations
add_filter('woocommerce_product_variation_get_regular_price', 'GoldPrice', 99, 2 );
add_filter('woocommerce_product_variation_get_price', 'GoldPrice', 99, 2 );
function GoldPrice( $price, $product ) {
    $data_value = '';
    $gemstone_price = get_post_meta( $product->get_id(), 'gemstone_price_field', true );
    
    $meta_value = get_post_meta( $product->get_id(), '', true );
    foreach ($meta_value as $key => $value) {
       if($key == 'jewellery_field'){
            $data_value = $value[0];
       }  
    }
	
	$making_charges_percentage = (float) get_post_meta( $product->get_id(), 'making_charges_percentage_field', true );

    if ($data_value == 1 || $data_value == 2 || $data_value == 3) {
        $gold_price = (float) $product->weight * GoldPriceCalc($data_value);
        $making_charges = ($gold_price * $making_charges_percentage) / 100;
        return $gold_price + $making_charges + (float) $gemstone_price;
    } else {
        return (float) $price + (float) $gemstone_price;
    }
}
add_filter('woocommerce_product_get_price', 'GoldPrice', 99, 2 );
add_filter('woocommerce_product_get_regular_price', 'GoldPrice', 99, 2 );


add_action( 'woocommerce_variation_options_pricing', 'bbloomer_add_custom_field_to_variations', 90, 3 );
function bbloomer_add_custom_field_to_variations( $loop, $variation_data, $variation ) {
    $jewellery_field = array(
        'id' => 'jewellery_field_variation[' . $loop . ']',
        'label' => __( 'Select any of this Gold / Silver / Platinum', 'store' ),
        'desc_tip' => true,
        'options'     => array(
            '0'        => __( 'Select Option', 'woocommerce' ),
            '1'       => __('Gold 18K', 'woocommerce' ),
            '2'       => __('Gold 22K', 'woocommerce' ),
            '3'       => __('Gold 24K', 'woocommerce' ),
            '4'       => __('Silver', 'woocommerce' ),
            '5'       => __('Platinum', 'woocommerce' ),
        ),
        'value' => get_post_meta( $variation->ID, 'jewellery_field_variation', true )
    ); 
    woocommerce_wp_select( $jewellery_field );
}

add_action( 'woocommerce_save_product_variation', 'bbloomer_save_custom_field_variations', 10, 2 );
function bbloomer_save_custom_field_variations( $variation_id, $i ) {
   $jewellery_field_variation = $_POST['jewellery_field_variation'][$i];
   if ( isset( $jewellery_field_variation ) ) update_post_meta( $variation_id, 'jewellery_field_variation', esc_attr( $jewellery_field_variation ) );
}


// Variable
add_filter('woocommerce_product_variation_get_regular_price', 'custom_price', 99, 2 );
add_filter('woocommerce_product_variation_get_price', 'custom_price' , 99, 2 );

// Variations (of a variable product)
add_filter('woocommerce_variation_prices_price', 'custom_price', 99, 3 );
add_filter('woocommerce_variation_prices_regular_price', 'custom_price', 99, 3 );

function custom_price( $price, $product ) {
    $data_value = '';
    $gemstone_price = get_post_meta( $product->get_id(), 'gemstone_price_field', true );
    
    $meta_value = get_post_meta( $product->get_id(), '', true );
    foreach ($meta_value as $key => $value) {
       if($key == 'jewellery_field_variation'){
            $data_value = $value[0];
       } 
    }
    if($data_value == 1 || $data_value == 2 || $data_value == 3 || $data_value == 4 || $data_value == 5){
        return (float) GoldPriceCalc($data_value) * $product->weight + (float) $gemstone_price;
    } else {
        return (float) $price + (float) $gemstone_price; 
    }
}


add_action('admin_head','my_custom_css');
function my_custom_css(){

    echo '<style>

    .variable_pricing {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }
    .variable_pricing p {
        float: none !important;
        display: block;
        width: 100%;
    }
    .variable_pricing p select{
        width: 100%;
        max-width:100%;
        height: 44px;
        margin-top: 5px;
    }
    </style>';

}