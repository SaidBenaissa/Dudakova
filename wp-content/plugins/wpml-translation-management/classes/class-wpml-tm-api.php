<?php

class WPML_TM_API {
	/**
	 * @var TranslationManagement
	 */
	private $TranslationManagement;

	/**
	 * @var WPDB
	 */
	private $wpdb;

	/**
	 * WPML_TM_API constructor.
	 *
	 * @param TranslationManagement $TranslationManagement
	 * @param WPDB                  $wpdb
	 */
	public function __construct( &$TranslationManagement, &$wpdb ) {
		$this->wpdb                  = &$wpdb;
		$this->TranslationManagement = &$TranslationManagement;
		add_action( 'wpml_tm_loaded', array( $this, 'load_action' ) );
	}

	public function load_action() {
		add_filter( 'wpml_is_translator', array( $this, 'is_translator_filter' ), 10, 3 );
		add_filter( 'wpml_translator_languages_pairs', array( $this, 'translator_languages_pairs_filter' ), 10, 2 );
		add_action( 'wpml_edit_translator', array( $this, 'edit_translator_action' ), 10, 2 );
	}

	/**
	 * @param bool        $default
	 * @param int|WP_User $user
	 * @param array       $args
	 *
	 * @return bool
	 */
	public function is_translator_filter( $default, $user, $args ) {
		$blog_translators = new WPML_TM_Blog_Translators( $this->wpdb );

		$result  = $default;
		$user_id = $this->get_user_id( $user );
		if ( is_numeric( $user_id ) ) {
			$result = $blog_translators->is_translator( $user_id, $args );
		}

		return $result;
	}

	public function edit_translator_action( $user, $language_pairs ) {
		$user_id = $this->get_user_id( $user );
		if ( is_numeric( $user_id ) ) {
			$this->TranslationManagement->edit_translator( $user_id, $language_pairs );
		}
	}

	public function translator_languages_pairs_filter( $default, $user ) {
		$result  = $default;
		$user_id = $this->get_user_id( $user );
		if ( is_numeric( $user_id ) ) {
			$blog_translators = new WPML_TM_Blog_Translators( $this->wpdb );
			if ( $blog_translators->is_translator( $user_id ) ) {
				$result = get_user_meta( $user_id, $this->wpdb->prefix . 'language_pairs', true );
			}
		}

		return $result;
	}

	/**
	 * @param $user
	 *
	 * @return mixed
	 */
	private function get_user_id( $user ) {
		$user_id = $user;

		if ( is_a( $user, 'WP_User' ) ) {
			$user_id = $user->ID;

			return $user_id;
		}

		return $user_id;
	}
}