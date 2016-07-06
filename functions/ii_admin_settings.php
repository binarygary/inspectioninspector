<?php
defined('ABSPATH') or die("No script kiddies please!");

//settings page
add_action( 'admin_menu', 'ii_admin_menu' );

function ii_admin_menu() { 
  add_submenu_page( 'options-general.php', 'Inspections Inspector Settings', 'II Settings', 'edit_plugins', 'ii-settings', 'ii_admin_settings' );
}

function ii_admin_settings() {
  if ( !current_user_can( 'manage_options' ) ) {
    wp_die( __('You do not have sufficient permissions to access this page.') );
  }
  if( isset( $_POST['URLS'] ) ) {
    if ( !check_admin_referer( 'update_ii_settings' ) ) {
      wp_die( __('You seem lost...') );
    }
    update_option( 'ii_urls', sanitize_ii_urls($_POST['URLS']) );
    update_option( 'ii_restaurants' , sanitize_ii_urls($_POST['RESTAURANTS']) );
    echo "<div class=\"updated\"><p><strong>" . __( 'settings saved.' , 'ii_admin_settings') . "</strong></p></div>";
  }
  echo '<div class="wrap">';
  echo "<h2>" . __( 'Inspections Inspector Settings', 'ii_admin_settings' ) . "</h2>";
  $opt_val=get_option( 'ii_urls' );
  $res_val=get_option( 'ii_restaurants' );
  ?>
  <form name="form1" method="post" action="">
    <?php wp_nonce_field('update_ii_settings'); ?>
    <p>
      <?php _e("Inspection URLS:", 'ii_admin_settings' ); ?> <em>enter a comma seperated list of <b>Inspection</b> URLs you are pulling inspection info from...</em>
      <textarea name="URLS" class="large-text code"><?php echo $opt_val; ?></textarea>
    </p>
    <hr />
    <p>
      <?php _e("Restaurant URLS:", 'ii_admin_settings' ); ?> <em>enter a comma seperated list of <b>Restaurant</b> URLs you are pulling inspection info from...</em>
      <textarea name="RESTAURANTS" class="large-text code"><?php echo $res_val; ?></textarea>
    </p>
    <hr />
    <p class="submit">
      <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
    </p>
  </form>
  </div>

  <div class=wrap>
    
    <?php
      
    ?>
    
</div>


  <?php
 }




function sanitize_ii_urls( $urls ) {
  if ( !is_string( $urls ) ) {
    return;
  } else {
    return sanitize_text_field( $urls );
  }
}