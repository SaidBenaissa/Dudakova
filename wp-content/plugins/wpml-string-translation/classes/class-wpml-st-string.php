<?php

/**
 * WPML_ST_String class
 *
 * Low level access to string in Database
 *
 * NOTE: Don't use this class to process a large amount of strings as it doesn't
 * do any caching, etc.
 *
 */
class WPML_ST_String extends WPML_WPDB_User {

	private $string_id;

	/**
	 * @param int $string_id
	 * @param wpdb $wpdb
	 */
	public function __construct( $string_id, &$wpdb ) {
		parent::__construct( $wpdb );

		$this->string_id = $string_id;
	}

	/**
	 * @return string|null
	 */
	public function get_language() {

		return $this->wpdb->get_var( "SELECT language " . $this->from_where_snippet() . " LIMIT 1" );
	}

	/**
	 * @param string $language
	 */
	public function set_language( $language ) {
		$this->set_property( 'language', $language );
	}

	/**
	 * @return object[]
	 */
	public function get_translation_statuses() {

		return $this->wpdb->get_results( "SELECT language, status " . $this->from_where_snippet( true ) );
	}

	/**
	 * @param int $status
	 */
	public function set_status( $status ) {
		$this->set_property( 'status', $status );
	}

	/**
	 * @param string          $language
	 * @param string|null     $value
	 * @param int|bool|false  $status
	 * @param int|null        $translator_id
	 * @param string|int|null $translation_service
	 * @param int|null        $batch_id
	 *
	 * @return bool|int id of the translation
	 */
	public function set_translation( $language, $value = null, $status = false, $translator_id = null, $translation_service = null, $batch_id = null ) {
		/** @var $ICL_Pro_Translation WPML_Pro_Translation */
		global $sitepress, $ICL_Pro_Translation;

		$res          = $this->wpdb->get_row( $this->wpdb->prepare( "SELECT id, value, status
                                          " . $this->from_where_snippet( true )
		                                                            . " AND language=%s", $language ) );
		if ( isset( $res->status ) && $res->status == ICL_TM_WAITING_FOR_TRANSLATOR && is_null( $value ) ) {

			return false;
		}

		$translation_data = array();
		if ( $translation_service ) {
			$translation_data['translation_service'] = $translation_service;
		}
		if ( $batch_id ) {
			$translation_data['batch_id'] = $batch_id;
		}
		if ( ! is_null( $value ) ) {
			$translation_data['value'] = $value;
		}
		if ( $res ) {
			$st_id = $res->id;
			if ( $status ) {
				$translation_data['status'] = $status;
			} elseif ( $status === ICL_TM_NOT_TRANSLATED ) {
				$translation_data['status'] = ICL_TM_NOT_TRANSLATED;
			}

			if ( ! is_null( $translator_id ) ) {
				$translation_data['translator_id'] = $sitepress->get_current_user()->ID;
			}

			if ( ! empty( $translation_data ) ) {
				$st_update['translation_date'] = current_time( "mysql" );
				$this->wpdb->update( $this->wpdb->prefix . 'icl_string_translations', $translation_data, array( 'id' => $st_id ) );
			}
		} else {
			$translation_data = array_merge( $translation_data, array(
				'string_id'     => $this->string_id,
				'language'      => $language,
				'status'        => ( $status ? $status : ICL_TM_NOT_TRANSLATED ),
				'translator_id' => ( $translator_id ? $translator_id : $sitepress->get_current_user()->ID )
			) );

			$this->wpdb->insert( $this->wpdb->prefix . 'icl_string_translations', $translation_data );
			$st_id = $this->wpdb->insert_id;
		}

		if ( $ICL_Pro_Translation ) {
			$ICL_Pro_Translation->_content_fix_links_to_translated_content( $st_id, $language, 'string' );
		}

		icl_update_string_status( $this->string_id );
		do_action( 'icl_st_add_string_translation', $st_id );

		return $st_id;
	}

	private function set_property( $property, $value ) {
		$this->wpdb->update( $this->wpdb->prefix . 'icl_strings', array( $property => $value ), array( 'id' => $this->string_id ) );
	}

	/**
	 * @param bool $translations sets whether to use original or translations table
	 *
	 * @return string
	 */
	private function from_where_snippet( $translations = false ) {

		if ( $translations ) {
			$id_column = 'string_id';
			$table     = 'icl_string_translations';
		} else {
			$id_column = 'id';
			$table     = 'icl_strings';
		}

		return $this->wpdb->prepare( "FROM {$this->wpdb->prefix}{$table} WHERE {$id_column}=%d", $this->string_id );
	}
}