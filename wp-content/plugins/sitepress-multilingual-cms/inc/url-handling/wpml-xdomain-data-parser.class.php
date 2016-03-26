<?php

class WPML_XDomain_Data_Parser {

	public function __construct() {
		global $sitepress_settings;

		if ( ! isset( $sitepress_settings['xdomain_data'] ) || $sitepress_settings['xdomain_data'] != WPML_XDOMAIN_DATA_OFF ) {
			add_action( 'init', array( $this, 'init' ) );
			add_filter( 'wpml_get_cross_domain_language_data', array( $this, 'get_xdomain_data' ) );
		}
	}

	public function init() {
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			$nopriv = is_user_logged_in() ? '' : 'nopriv_';
			add_action( 'wp_ajax_' . $nopriv . 'switching_language', array( $this, 'xdomain_language_data_setup' ) );
		}
		add_action('wp_enqueue_scripts', array($this, 'register_scripts_action'), 100);
	}

	public function register_scripts_action() {
		if ( !defined( 'DOING_AJAX' ) || !DOING_AJAX ) {
			wp_enqueue_script( 'wpml-xdomain-data', ICL_PLUGIN_URL . '/res/js/xdomain-data.js', array( 'jquery', 'sitepress' ), ICL_SITEPRESS_VERSION );
		}
	}

	public function xdomain_language_data_setup() {
		global $sitepress_settings;

		$ret = array();

		$data = apply_filters( 'WPML_cross_domain_language_data', array() );
		$data = apply_filters( 'wpml_cross_domain_language_data', $data );

		if ( ! empty( $data ) ) {


			if( function_exists( 'mcrypt_encrypt' ) && function_exists( 'mcrypt_decrypt' ) ){

				$key = substr( NONCE_KEY, 0, 24 );
				$ret[ 'xdomain_data' ] = trim( base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, $key, json_encode( $data ),
					MCRYPT_MODE_ECB, mcrypt_create_iv( mcrypt_get_iv_size( MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB ), MCRYPT_RAND ) ) ) );

			}else{

				$ret[ 'xdomain_data' ] = urlencode( base64_encode( json_encode( $data ) ) );

			}

			$ret[ 'method' ] = $sitepress_settings['xdomain_data'] == WPML_XDOMAIN_DATA_POST ? 'post' : 'get';


		}

		echo json_encode( $ret );
		exit;
	}

	public function get_xdomain_data(){
		global $sitepress_settings;

		$xdomain_data = array();

		$xdomain_data_request = false;

		if( $sitepress_settings[ 'xdomain_data' ] == WPML_XDOMAIN_DATA_GET ){
			$xdomain_data_request = isset( $_GET['xdomain_data'] ) ? $_GET[ 'xdomain_data' ] : false;

		} elseif( $sitepress_settings[ 'xdomain_data' ] == WPML_XDOMAIN_DATA_POST ){
			$xdomain_data_request = isset( $_POST['xdomain_data'] ) ? $_POST[ 'xdomain_data' ] : false;
		}

		if( $xdomain_data_request ){
			$xdomain_data = (array) json_decode( base64_decode( $xdomain_data_request ), JSON_OBJECT_AS_ARRAY );

		}

		return $xdomain_data;
	}
}
