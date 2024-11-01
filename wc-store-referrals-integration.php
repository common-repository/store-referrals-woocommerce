<?php
if ( ! class_exists( 'WC_Store_Referrals_Integration' ) ) :
class WC_Store_Referrals_Integration extends WC_Integration {
	/**
	 * Init and hook in the integration.
	 */
	public function __construct() {
		$this->id                 = 'store-referrals-integration';
		$this->method_title       = __( 'Store Referrals', 'woocommerce-store-referrals-integration' );
		$this->method_description = __( '<b><a target="_blank" href="https://www.storereferrals.com/merchants">storereferrals.com</a> allows you to recruit people to spread the word about your store.  Sign up now for a free trial!</b>', 'woocommerce-store-referrals-integration' );
		// Load the settings.
		$this->init_form_fields();
		$this->init_settings();
		// Define user set variables.
		$this->subscribe_url      = $this->get_option( 'subscribe_url' );

		// Actions.
		add_action( 'woocommerce_update_options_integration_' .  $this->id, array( $this, 'process_admin_options' ) );
    add_action( 'admin_menu', array( $this, 'admin_menu' ),  15);
    add_action( 'wp_footer', array( $this, 'store_referrals_tracking_object' ) );
    add_action( 'woocommerce_thankyou', array( $this, 'wc_store_referrals_thankyou' ) );
	}

  public function admin_menu( ) {
    add_submenu_page( 'woocommerce', __( 'Store Referrals', 'woocommerce' ), __( 'Store Referrals', 'woocommerce' ) , 'manage_woocommerce', 'admin.php?page=wc-settings&tab=integration&section=store-referrals-integration' );
  }

  public function wc_store_referrals_thankyou( $order_id ) {
    $order = new WC_Order( $order_id );
    $total = $order->get_total();
    ?>
      <script type="text/javascript">
      document.addEventListener("DOMContentLoaded", function(event) {
        sro('convert', '<?php echo $order_id; ?>', '<?php echo $total; ?>');
      });
      </script>
    <?php
    if (!empty($this->settings['subscribe_url'])) {
      ?>
        <b><a target='_blank' href='<?php echo $this->settings['subscribe_url'] ?>'>Earn rewards with our referral program!</a></b>
      <?
    }
  }

  public function store_referrals_tracking_object() {
  ?>
    <script type="text/javascript">
    (function(i,s,o,g,r,a,m){i['StoreReferralsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.storereferrals.com/client/client.min.js','sro');
    sro('click');
    </script>
  <?php
  }

	public function init_form_fields() {
		$this->form_fields = array(
			'subscribe_url' => array(
				'title'             => 'Campagin URL',
				'type'              => 'text',
				'description'       => 'Display a prompt on your "Thank you" page after checkout for customers to join a referral campaign.<br>You can get your referrer signup URLs <a href="https://goo.gl/B0HjQj" target="_blank">from your dashboard</a><br><br><b>Note</b> - Be sure to enter the entire subscription URL. it will look something like:<br>https://www.storereferrals.com/campaigns/123/subscribe', 'store-referrals-integration',
				'default'           => ''
			)
		);
	}
}
endif;
