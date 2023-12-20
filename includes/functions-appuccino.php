<?php

/**
 * The file that contains some functions
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://myappuccino.com/
 * @since      1.0.0
 *
 * @package    Appuccino
 * @subpackage Appuccino/includes
 */

  function appuccino_custom_post_type_app_pages() {

    $labels = array(
      'name'                  => _x( 'App Pages', 'Post Type General Name', 'text_domain' ),
      'singular_name'         => _x( 'App Page', 'Post Type Singular Name', 'text_domain' ),
      'menu_name'             => __( 'App Pages', 'text_domain' ),
      'name_admin_bar'        => __( 'App Page', 'text_domain' ),
      'archives'              => __( 'Item Archives', 'text_domain' ),
      'attributes'            => __( 'Item Attributes', 'text_domain' ),
      'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
      'all_items'             => __( 'All Items', 'text_domain' ),
      'add_new_item'          => __( 'Add New Item', 'text_domain' ),
      'add_new'               => __( 'Add New', 'text_domain' ),
      'new_item'              => __( 'New Item', 'text_domain' ),
      'edit_item'             => __( 'Edit Item', 'text_domain' ),
      'update_item'           => __( 'Update Item', 'text_domain' ),
      'view_item'             => __( 'View Item', 'text_domain' ),
      'view_items'            => __( 'View Items', 'text_domain' ),
      'search_items'          => __( 'Search Item', 'text_domain' ),
      'not_found'             => __( 'Not found', 'text_domain' ),
      'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
      'featured_image'        => __( 'Featured Image', 'text_domain' ),
      'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
      'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
      'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
      'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
      'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
      'items_list'            => __( 'Items list', 'text_domain' ),
      'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
      'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
    );
    $args = array(
      'label'                 => __( 'App Page', 'text_domain' ),
      'description'           => __( 'App Pages are used in Appuccino', 'text_domain' ),
      'labels'                => $labels,
      'supports'              => array( 'title', 'editor', 'thumbnail', 'comments', 'revisions', 'custom-fields', 'page-attributes'),
      'taxonomies'            => array( 'category', 'post_tag' ),
      'hierarchical'          => true,
      'public'                => true,
      'show_ui'               => true,
      'show_in_menu'          => true,
      'menu_position'         => 5,
      'menu_icon'             => 'dashicons-text',
      'show_in_admin_bar'     => true,
      'show_in_nav_menus'     => true,
      'can_export'            => true,
      'has_archive'           => true,
      'exclude_from_search'   => true,
      'publicly_queryable'    => true,
      'capability_type'       => 'page',
      'show_in_rest'          => true,
      'register_meta_box_cb'  => 'register_appuccino_meta_box',
    );

    register_post_type( 'app_pages', $args );

  }

  add_action( 'init', 'appuccino_custom_post_type_app_pages', 0 );

  // Modify how hyperlinks work for this Post type
  function appuccino_wpq_link_query( $results, $query ) {
    $parts = parse_url(wp_get_referer());
    parse_str($parts['query'], $url_params);

    if(isset($url_params['post'])) {
      if(get_post_type(intval($url_params['post'])) == 'app_pages') {

        $new_results = array();

        $homepage_id = appuccino_get_pages(TRUE);

        foreach($results as $i => $result) {

          $result['permalink'] = basename($result['permalink']);
          if(get_post_type($result['ID']) == 'app_pages') {
            $result['permalink'] = '#' . ($homepage_id == $result['ID'] ? '/' : rtrim(str_replace(home_url(), false, get_page_link($result['ID'])), '/'));
            $new_results[] = $result;
          }
        }

        return $new_results;
      }
    }

    return $results;
  }


  // Add API Endpoints
  function appuccino_get_pages($return_homepage = false, $return_page_by_id = false) {

          $template_value = 'appuccino_meta_box_body_template_value';

          $args = array(
            'post_type'       => 'app_pages',
            'posts_per_page'  => -1,
            'orderby'         => 'title',
            'order'           => 'ASC'
          );

          $get = new WP_Query( $args );
          $response = array('posts' => array(), 'data' => array());

          $homepage_id = false;

          foreach($get->posts as $i => $post) {
            $post->uri = rtrim(str_replace(home_url(), false, get_page_link($post->ID)), '/');
            if(!$post->post_parent && !$homepage_id) {
              $post->uri = '/';
              $post->homepage = true;
              $homepage_id = $post->ID;
            }

            $post->image_encode   = get_post_meta($post->ID, 'image_encode', true) == 'false' ? false : true;
            $post->post_content   = do_shortcode(appuccino_strip_tags($post->post_content));
            $post->categories     = get_categories($post->ID);
            $post->meta_data      = get_post_meta($post->ID);
            $post->settings       = appuccino_post_settings($post->meta_data);
            $post->template       = @$post->meta_data[$template_value][0];

            if(isset($post->settings['parameters']) 
            && is_string($post->settings['parameters']) 
            && !empty($post->settings['parameters'])) {
              $post->uri = implode('/', array(
                rtrim($post->uri, '/'),
                ltrim($post->settings['parameters'], '/')
              ));
            }

            if($post->image_encode) {
              $post->post_content = appuccino_encode_images($post->post_content);
            }

            $post->meta_data = false;
            $post->categories = false;

            if($return_page_by_id && $return_page_by_id == $post->ID) {
              return $post;
            }

            $response['posts'][] = $post;

          }

          if($return_homepage) {
            return $homepage_id;
          }

          if(has_filter('appuccino_get_pages_response')) {
            return apply_filters('appuccino_get_pages_response', $response);
          }

          return $response;
  }

  function appuccino_strip_tags($string, $tags = array('script')) {
    foreach ($tags as $tag){
        @preg_replace('/<'.$tag.'[^>]*>(.*)</'.$tag.'>/iU', '', $string);
    }

    return $string;
  }

  /**
   * @info {type}:{key}
   * @demo float:latitude
   */
  function appuccino_post_settings($settings) {
    $output_settings = array();
    foreach($settings as $key => $setting) {

      if(strpos($key, ':') !== false) {

        $explode_key = explode(':', $key);
        if(count($explode_key) == 2) {

          $option = trim($explode_key[0]);
          $keyname = trim($explode_key[1]);
          $value = !empty($setting) ? $setting[0] : '';

          switch ($option) {
            case 'string':
              $output_settings[$keyname] = strval($value);
              break;
          
            case 'int':
              $output_settings[$keyname] = intval($value);
              break;

            case 'float':
              $output_settings[$keyname] = floatval($value);
              break;

            case 'bool':
              $output_settings[$keyname] = boolval($value);
              break;
          }
        }
      }
    }

    return $output_settings;

  }

  function appuccino_encode_images($content, $max_file_size_kb = 1024) {

    if(defined('APPUCCINO_ENCODE_IMAGES') && !APPUCCINO_ENCODE_IMAGES) {
      return $content;
    }
    
    if(defined('APPUCCINO_IMAGE_MAX_SIZE')) {
      $max_file_size_kb = APPUCCINO_IMAGE_MAX_SIZE;
    }

    preg_match_all( '@src="([^"]+)"@' , $content, $match );
    $src = array_pop($match);
    $seen = array();

    $image_types = explode('|', APPUCCINO_ENCODE_FILE_TYPES);
    foreach($image_types as $type_index => $type) {
      $image[$type_index] = strtolower(trim($type));
    }
 
    foreach($src as $i => $url) {

      // If the same image is in the page twice, let's not 
      // download it twice.
      if(in_array($url, $seen)) {
        continue;
      }

      $type = pathinfo($url, PATHINFO_EXTENSION);

      if(in_array(strtolower($type), $image_types)) {

        $data = file_get_contents($url);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        if(is_numeric($max_file_size_kb) && $max_file_size_kb){
          $headers = get_headers($url, TRUE);
          $filesize = isset($headers['content-length']) ? $headers['content-length'] : $headers['Content-Length'];
          if(is_numeric($filesize) && $filesize > $max_file_size_kb && $max_file_size_kb) {
            $base64 = 'about:blank';
          }
        }

        $content = str_replace($url, $base64, $content);

        $seen[] = $url;

      }
    }

    return $content;

  }

  function appuccino_get_manifest(WP_REST_Request $request) {

      $manifest = array();

      $manifest[] = array(
        'file' => 'posts.json',
        'md5' => md5(json_encode(appuccino_get_pages()))
      );

      // Get template files
      $template_files = glob(dirname(__DIR__) . '/' . APPUCCINO_TEMPLATE_RESOURCE_DIR . '*.php');
      $partials_files = glob(dirname(__DIR__) . '/' . APPUCCINO_PARTIALS_RESOURCE_DIR . '*.php');

      $javascript_files = glob(dirname(__DIR__) . '/' . APPUCCINO_JS_RESOURCE_DIR . '*.js');
      $css_files = glob(dirname(__DIR__) . '/' . APPUCCINO_CSS_RESOURCE_DIR . '*.css');

      $enqueue_js = apply_filters('appuccino_enqueue_js', array());
      $enqueue_css = apply_filters('appuccino_enqueue_css', array());


      //Add JS files
      foreach($javascript_files as $template_file) {
        $manifest[] = array(
          'type' => 'js',
          'file' => 'resources/js/' . basename($template_file),
          'md5' => sha1_file($template_file)
        );
      }

      //Add CSS files
      foreach($css_files as $template_file) {
        $manifest[] = array(
          'type' => 'css',
          'file' => 'resources/css/' . basename($template_file),
          'md5' => sha1_file($template_file)
        );
      }

      // Add template files
      foreach($template_files as $template_file) {
        $manifest[] = array(
          'file' => 'templates/' . str_replace('.php', '.html', basename($template_file)),
          'md5' => sha1_file($template_file)
        );
      }

      // Add partial files
      foreach($partials_files as $partials_file) {
        $manifest[] = array(
          'file' => 'partials/' . str_replace('.php', '.html', basename($partials_file)),
          'md5' => sha1_file($partials_file)
        );
      }

      // Add enqueued JS
      if(!empty($enqueue_js)) {
        foreach($enqueue_js as $xjs) {
          $manifest[] = array(
            'type' => 'js-x',
            'file' => $xjs,
            'md5' => sha1_file($xjs)
          );
        }
      }

      // Add enqueued CSS
      if(!empty($enqueue_css)) {
        foreach($enqueue_css as $xcss) {
          $manifest[] = array(
            'type' => 'css-x',
            'file' => $xcss,
            'md5' => sha1_file($xcss)
          );
        }
      }

      return $manifest;


  }

  function appuccino_get_files() {

    $mime_types = new Appuccino_MIME();

    $request = (object) $_GET;
    $noexist = '<!-- File does not exist -->';
    $header_filetypes = explode('|', APPUCCINO_HEADER_FILE_TYPES);
    foreach($header_filetypes as $type_index => $type) {
      $header_filetypes[$type_index] = strtolower(trim($type));
    }

    if(isset($request->file)) {
      $filename = str_replace('.html', '.php', $request->file);

      if(strpos($filename, '..') !== false) {
        die($noexist);
      }

      if(strtolower($filename) == 'posts.json') {
        return appuccino_get_pages();
      }

      if(file_exists(dirname(__DIR__) . '/view/' . $filename)) {
        if(isset($request->mime)) {
          $file_path = dirname(__DIR__) . '/view/' . $filename;
          $file_extension = strtolower(trim(pathinfo($file_path, PATHINFO_EXTENSION)));
          $file_mime = mime_content_type($file_path);


          if(in_array($file_extension, $header_filetypes) 
          && isset($mime_types->types[$file_extension])) {


            $content_type = is_array($mime_types->types[$file_extension]) ? $mime_types->types[$file_extension][0] : $mime_types->types[$file_extension];

            header('Content-Type: ' . $content_type);
          }
        }

        ob_start();
        require dirname(__DIR__) . '/view/' . $filename;
        $response = ob_get_contents();
        ob_end_clean();

        die($response);

      }


    }

    die($noexist);

  }

  function appuccino_custom_rest_cors() {
    if(defined('APPUCCINO_V2_CORS_HEADERS') && APPUCCINO_V2_CORS_HEADERS) {
      
      remove_filter( 'rest_pre_serve_request', 'rest_send_cors_headers' );

      add_filter( 'rest_pre_serve_request', function( $value ) {
        header( 'Access-Control-Allow-Origin: *' );
        header( 'Access-Control-Allow-Methods: GET' );
        header( 'Access-Control-Allow-Credentials: true' );
        header( 'Access-Control-Expose-Headers: Link', false );

        return $value;
      })
      ;
    }
  }

  add_action('rest_api_init', 'appuccino_custom_rest_cors', 15);

  add_filter( 'wp_link_query', 'appuccino_wpq_link_query', 10, 2 );

  add_action( 'rest_api_init', function () {

        register_rest_route( 'appuccino/v1', '/manifest.json', array(
                'methods'   => 'GET',
                'callback'  => 'appuccino_get_manifest'
        ));

        register_rest_route( 'appuccino/v1', '/file.json', array(
                'methods'   => 'GET',
                'callback'  => 'appuccino_get_files'
        ));
  });
