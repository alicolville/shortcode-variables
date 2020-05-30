<?php

	defined('ABSPATH') or die("Jog on!");

	abstract class SV_Preset {

		private $args = [];
		protected $escape_method = 'esc_html';

		public function init() {

			$this->auto_set_escape();
		}

		public function set_arguments( $args ) {
			$this->args = ( false === empty( $args ) && true === is_array( $args ) ) ? $args : [];
		}

		public function get_arguments() {
			return $this->args;
		}

		/**
		 * Be clever and try and auto detect the escape method that should be used.
		 */
		private function auto_set_escape() {

			$args = $this->get_arguments();

			// if _sh_cd_func argument has been specified, then dynamically set escape type
			if ( false === empty( $args['_sh_cd_func'] ) ) {

				switch ( $args['_sh_cd_func'] ) {

					case 'wpurl':
					case 'url':
					case 'stylesheet_url':
					case 'template_url':
					case 'pingback_url':
					case 'atom_url':
					case 'atom_url':
					case 'rdf_url':
					case 'rss_url':
					case 'rss2_url':
					case 'comments_atom_url':
					case 'comments_rss2_url':
					case 'registration_url':
					case 'current_url':

						$this->escape_method = 'esc_url_raw';

						break;
					default:
						$this->escape_method = 'esc_html';
				}
			} else {

			}
		}

		abstract protected function unsanitised();

		public function sanitised() {

			$escape_function = $this->escape_method;

			return ( false !== $escape_function ) ?
					$escape_function( $this->unsanitised() ) :
						$this->unsanitised();
		}
	}
