<?php
	namespace sv100;

	class sv_archive extends init {
		private $archive_types	= array();

		public function init() {
			// set available
			$this->set_archive_types(array(
				'archive'		=> __('Archive', 'sv100'),
				'home'			=> __('Home', 'sv100'),
				'category'		=> __('Category', 'sv100'),
				'tag'			=> __('Tag', 'sv100'),
			));

			// load & register default archive template class
			require_once($this->get_path('lib/template_sv_archive_list/template_sv_archive_list.php'));

			$this->set_module_title( 'SV Archive' )
				->set_module_desc( __( 'Archive Template and Settings', $this->get_module_name() ) )
				->load_settings()
				->set_section_title( $this->get_module_title() )
				->set_section_desc( $this->get_module_desc() )
				->set_section_template_path()
				->set_section_order(3100)
				->set_section_icon('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M20.822 18.096c-3.439-.794-6.64-1.49-5.09-4.418 4.72-8.912 1.251-13.678-3.732-13.678-5.082 0-8.464 4.949-3.732 13.678 1.597 2.945-1.725 3.641-5.09 4.418-3.073.71-3.188 2.236-3.178 4.904l.004 1h23.99l.004-.969c.012-2.688-.092-4.222-3.176-4.935z"/></svg>')
				->get_root()
				->add_section( $this );
		}
		public function get_archive_types(): array{
			return $this->archive_types;
		}
		public function set_archive_types(array $archive_types): sv_archive{
			$this->archive_types	= $archive_types;

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
				$this->get_setting($slug.'_template')
					->set_title( __( 'Template', 'sv100' ) )
					->set_description( __( 'Choose a visual style for this archive type', 'sv100' ) )
					->set_options( $templates )
					->set_default_value('template_sv_archive_list')
					->load_type( 'select' );

				$this->get_setting($slug.'_show_featured_image')
					->set_title( __( 'Show Featured Image', 'sv100' ) )
					->set_description( __( 'Show or Hide this Template Part', 'sv100' ) )
					->set_default_value(1)
					->load_type( 'checkbox' );

				$this->get_setting($slug.'_show_title')
					->set_title( __( 'Show Title', 'sv100' ) )
					->set_description( __( 'Show or Hide this Template Part', 'sv100' ) )
					->set_default_value(1)
					->load_type( 'checkbox' );

				$this->get_setting($slug.'_show_excerpt')
					->set_title( __( 'Show Excerpt', 'sv100' ) )
					->set_description( __( 'Show or Hide this Template Part', 'sv100' ) )
					->set_default_value(1)
					->load_type( 'checkbox' );

				$this->get_setting($slug.'_show_read_more')
					->set_title( __( 'Show Read More', 'sv100' ) )
					->set_description( __( 'Show or Hide this Template Part', 'sv100' ) )
					->set_default_value(1)
					->load_type( 'checkbox' );

				$this->get_setting($slug.'_show_date')
					->set_title( __( 'Show Date', 'sv100' ) )
					->set_description( __( 'Show or Hide this Template Part', 'sv100' ) )
					->set_default_value(1)
					->load_type( 'checkbox' );

				$this->get_setting($slug.'_show_date_modified')
					->set_title( __( 'Show Date Modified', 'sv100' ) )
					->set_description( __( 'Show or Hide this Template Part', 'sv100' ) )
					->set_default_value(0)
					->load_type( 'checkbox' );

				$this->get_setting($slug.'_show_categories')
					->set_title( __( 'Show Categories', 'sv100' ) )
					->set_description( __( 'Show or Hide this Template Part', 'sv100' ) )
					->set_default_value(1)
					->load_type( 'checkbox' );
			}

			return $this;
		}

		public function load(string $archive_type = 'archive') {
			if(!$this->has_archive_type($archive_type)){
				$output				= '<p>'.__('Section', 'sv100').' <strong>'.$archive_type.'</strong> '.__('not found.','sv100').'</p>';
			}else {
				// Load Styles
				$this->get_script('common')
					->set_is_enqueued();

				// Load Template
				$template_class_name = $this->get_setting($archive_type . '_template')->get_data();

				// set template properties
				$template = new $template_class_name($this, array(
					'show_featured_image' => boolval($this->get_setting($archive_type . '_show_featured_image')->get_data()),
					'show_title' => boolval($this->get_setting($archive_type . '_show_title')->get_data()),
					'show_excerpt' => boolval($this->get_setting($archive_type . '_show_excerpt')->get_data()),
					'show_read_more' => boolval($this->get_setting($archive_type . '_show_read_more')->get_data()),
					'show_date' => boolval($this->get_setting($archive_type . '_show_date')->get_data()),
					'show_date_modified' => boolval($this->get_setting($archive_type . '_show_date_modified')->get_data()),
					'show_categories' => boolval($this->get_setting($archive_type . '_show_categories')->get_data())
				));

				// get output
				$archive = $template->get_output();

				$pagination = $this->get_module('sv_pagination') ? $this->get_module('sv_pagination')->load() : '';

				$output = $archive . $pagination;
			}

			return $this->get_header().$output.$this->get_footer();
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
		protected function get_category(){
			if(is_category()) {
				return get_category(get_query_var('cat'));
			} elseif(isset(get_the_category()[0])) {
				return get_the_category()[0];
			}else{
				return false;
			}
		}
		protected function get_category_field(string $field): string{
			if(!$this->get_category()){
				return '';
			}

			return $this->get_category()->$field;
		}
		protected function get_category_image(): string{
			if(!function_exists('z_taxonomy_image_url')){
				return '';
			}

			if(!$this->get_category()){
				return '';
			}

			return '<img src="'.z_taxonomy_image_url($this->get_category()->term_id, 'full', true).'" alt="" />"';
		}
	}