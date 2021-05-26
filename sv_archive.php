<?php
	namespace sv100;

	class sv_archive extends init {
		private $archive_types				= array();
		private $active_archive_type		= '';
		private static $loaded_templates	= array();

		public function init() {
			// set available
			$this->set_archive_types(array(
				'archive'		=> __('Archive', 'sv100'),
				'home'			=> __('Home', 'sv100'),
				'category'		=> __('Category', 'sv100'),
				'tag'			=> __('Tag', 'sv100')
			));

			// load & register default archive template class
			require_once($this->get_path('lib/template_sv_archive_list/template_sv_archive_list.php'));

			$this->set_module_title( 'SV Archive' )
				->set_module_desc( __( 'Archive Template and Settings', $this->get_module_name() ) )
				->set_section_title( $this->get_module_title() )
				->set_section_desc( $this->get_module_desc() )
				->set_section_template_path()
				->set_section_order(3100)
				->set_section_icon('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M1.8 9l-.8-4h22l-.8 4h-2.029l.39-2h-17.122l.414 2h-2.053zm18.575-6l.604-2h-17.979l.688 2h16.687zm3.625 8l-2 13h-20l-2-13h24zm-8 4c0-.552-.447-1-1-1h-6c-.553 0-1 .448-1 1s.447 1 1 1h6c.553 0 1-.448 1-1z"/></svg>')
				->register_sidebars()
				->get_root()
				->add_section( $this );

			// remove prefixes from archive titles
			add_filter( 'get_the_archive_title', function ($title) {
				if ( is_category() ) {
					$title = single_cat_title( '', false );
				} elseif ( is_tag() ) {
					$title = single_tag_title( '', false );
				} elseif ( is_author() ) {
					$title = '<span class="vcard">' . get_the_author() . '</span>' ;
				} elseif ( is_tax() ) { //for custom post types
					$title = sprintf( __( '%1$s' ), single_term_title( '', false ) );
				} elseif (is_post_type_archive()) {
					$title = post_type_archive_title( '', false );
				}
				return $title;
			});

			$this->load_settings();
		}
		public function go(): sv_archive{
			$this->load_settings();

			return $this;
		}
		public function set_active_archive_type(string $archive_type): sv_archive{
			$this->active_archive_type		= $archive_type;

			return $this;
		}
		public function get_active_archive_type(): string{
			return $this->active_archive_type;
		}
		public function get_archive_types(): array{
			return $this->archive_types;
		}
		public function set_archive_types(array $archive_types): sv_archive{
			$this->archive_types	= $archive_types;

			return $this;
		}
		public function get_loaded_templates(): array{
			return self::$loaded_templates;
		}
		public function get_loaded_template(string $slug){
			return $this->get_loaded_templates()[$slug];
		}
		private function add_loaded_template($slug, $template): sv_archive{
			self::$loaded_templates[$slug]	= $template;

			return $this;
		}
		public function has_archive_type(string $archive_type): bool{
			if(isset($this->get_archive_types()[$archive_type])){
				return true;
			}

			return false;
		}

		protected function load_settings(): sv_archive {
			$templates	= array();
			foreach($this->get_templates_archive() as $slug => $props){
				$templates[$slug]	= $props['label'];
			}

			foreach($this->get_archive_types() as $slug => $label){
				$this->get_setting($slug.'_template', __('Common', 'sv100'))
					->set_title( __( 'Template', 'sv100' ) )
					->set_description( __( 'Choose a visual style for this archive type', 'sv100' ) )
					->set_options( $templates )
					->set_default_value('template_sv_archive_list')
					->load_type( 'select' );

				$this->get_setting($slug.'_max_width_wrapper_outer', __('Common', 'sv100'))
					->set_title( __( 'Max Width Outer Wrapper', 'sv100' ) )
					->set_description( __( 'Set the max width of the outer archive wrapper.', 'sv100' ) )
					->set_options( $this->get_module('sv_common') ? $this->get_module('sv_common')->get_max_width_options() : array('' => __('Please activate module SV Common for this Feature.', 'sv100')) )
					->set_default_value( $this->get_module('sv_common')->get_setting('max_width_alignfull')->get_data() )
					->set_is_responsive(true)
					->load_type( 'select' );

				$this->get_setting($slug.'_max_width_wrapper_inner', __('Common', 'sv100'))
					->set_title( __( 'Max Width Inner Wrapper', 'sv100' ) )
					->set_description( __( 'Set the max width of the inner archive wrapper.', 'sv100' ) )
					->set_options( $this->get_module('sv_common') ? $this->get_module('sv_common')->get_max_width_options() : array('' => __('Please activate module SV Common for this Feature.', 'sv100')) )
					->set_default_value( $this->get_module('sv_common')->get_setting('max_width_alignwide')->get_data() )
					->set_is_responsive(true)
					->load_type( 'select' );

				$this->get_setting($slug.'_show_sidebar_top', __('Parts', 'sv100'))
					->set_title( __( 'Show Top Archive Sidebar', 'sv100' ) )
					->set_description( __( 'Show or Hide this Template Part', 'sv100' ) )
					->set_default_value(0)
					->load_type( 'checkbox' );

				$this->get_setting($slug.'_show_sidebar_right', __('Parts', 'sv100'))
					->set_title( __( 'Show Right Archive Sidebar', 'sv100' ) )
					->set_description( __( 'Show or Hide this Template Part', 'sv100' ) )
					->set_default_value(0)
					->load_type( 'checkbox' );

				$this->get_setting($slug.'_show_sidebar_bottom', __('Parts', 'sv100'))
					->set_title( __( 'Show Bottom Archive Sidebar', 'sv100' ) )
					->set_description( __( 'Show or Hide this Template Part', 'sv100' ) )
					->set_default_value(0)
					->load_type( 'checkbox' );

				$this->get_setting($slug.'_show_sidebar_left', __('Parts', 'sv100'))
					->set_title( __( 'Show Left Archive Sidebar', 'sv100' ) )
					->set_description( __( 'Show or Hide this Template Part', 'sv100' ) )
					->set_default_value(0)
					->load_type( 'checkbox' );

				$template_class_name	= $this->get_setting($slug.'_template')->get_data();

				if(class_exists($template_class_name)){
					$this->add_loaded_template($slug, new $template_class_name($this, $slug));
				}else{
					echo '<div class="notice">'.__('Template Class "'.var_export($template_class_name,true).'" not found', 'sv100').'</div>';
				}
			}

			// Extra Style selected for this category?
			if($this->get_instance('sv100_companion')) {
				$cat_template_style		= $this->get_instance('sv100_companion')->modules->sv_categories->get_template_style();

				if(strlen($cat_template_style) > 0) {
					$extra_styles		= $this->get_setting('extra_styles')->get_data();

					if ($extra_styles && is_array($extra_styles) && count($extra_styles) > 0) {
						foreach ($extra_styles as $extra_style) {
							$template_class_name	= $extra_style['archive_template'];
							$instance				= new $template_class_name($this, 'archive');

							// load extra style settings
							foreach($instance->get_settings() as $setting){
								$setting->set_data($extra_style[$setting->get_ID()]);
							}

							$this->add_loaded_template($extra_style['slug'], $instance);
						}
					}
				}
			}

			return $this;
		}

		public function has_extra_style(string $extra_style){
			$extra_styles		= $this->get_setting('extra_styles')->get_data();

			if(!$extra_styles || !is_array($extra_styles) | !count($extra_styles) === 0){
				return false;
			}

			foreach($extra_styles as $style){
				if($style['slug'] == $extra_style){
					return true;
				}
			}

			return false;
		}

		public function load(string $archive_type = 'archive') {
			$this->set_active_archive_type($archive_type);

			$header		= $this->get_header();

			// Extra Style selected for this category?
			if($this->get_instance('sv100_companion')) {
				$cat_template_style = $this->get_instance('sv100_companion')->modules->sv_categories->get_template_style();

				if(strlen($cat_template_style) > 0 && $this->has_extra_style($cat_template_style)){
					$archive_type	= 'extra_style';
				}
			}else{
				$cat_template_style	= false;
			}

			if($archive_type != 'extra_style' && !$this->has_archive_type($archive_type)){
				$output				= '<p>'.__('Section', 'sv100').' <strong>'.$archive_type.'</strong> '.__('not found.','sv100').'</p>';
			}else {
				// Load Styles
				$this->get_script('common')
					->set_is_enqueued();

				// get output
				$archive = $this->get_loaded_template($archive_type == 'extra_style' ? $cat_template_style : $archive_type)->get_output();

				$pagination = $this->get_module('sv_pagination') ? $this->get_module('sv_pagination')->load() : '';

				$output = '<div class="'.$this->get_prefix().'">'.$archive . $pagination.'</div>';
			}

			$footer		= $this->get_footer();

			return $header.$output.$footer;
		}
		protected function get_header(): string {
			ob_start();
			get_header();
			$output		= ob_get_clean();

			return $output;
		}

		protected function get_footer(): string {
			ob_start();
			get_footer();
			$output		= ob_get_clean();

			return $output;
		}
		protected function register_sidebars(): sv_archive {
			if ( $this->get_module( 'sv_sidebar' ) ) {
				foreach($this->get_archive_types() as $slug => $label){
					foreach(array(
								'top'		=> __('Top', 'sv100'),
								'right'		=> __('Right', 'sv100'),
								'bottom'	=> __('Bottom', 'sv100'),
								'left'		=> __('left', 'sv100')
						) as $location => $location_label){
						if($this->get_setting($slug.'_show_sidebar_'.$location)->get_data()){
							$this->get_module( 'sv_sidebar' )
								->create( $this, $this->get_prefix($slug).'_'.$location )
								->set_title( $label . ' ' . $location_label )
								->load_sidebar();
						}
					}
				}
			}

			return $this;
		}
	}