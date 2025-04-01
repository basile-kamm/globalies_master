<?php
/**
 * Timber starter-theme
 * https://github.com/timber/starter-theme
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

/**
 * If you are installing Timber as a Composer dependency in your theme, you'll need this block
 * to load your dependencies and initialize Timber. If you are using Timber via the WordPress.org
 * plug-in, you can safely delete this block.
 */
$composer_autoload = __DIR__ . '/vendor/autoload.php';
if ( file_exists( $composer_autoload ) ) {
	require_once $composer_autoload;
	$timber = new Timber\Timber();
}

/**
 * This ensures that Timber is loaded and available as a PHP class.
 * If not, it gives an error message to help direct developers on where to activate
 */
if ( ! class_exists( 'Timber' ) ) {

	add_action(
		'admin_notices',
		function() {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
		}
	);

	add_filter(
		'template_include',
		function( $template ) {
			return get_stylesheet_directory() . '/static/no-timber.html';
		}
	);
	return;
}

function globalies_theme_load_assets() {
	// Chemin absolu vers le dossier dist
	$dist_dir = get_template_directory() . '/dist';
	$dist_uri = get_template_directory_uri() . '/dist';

	// Initialiser les chemins des fichiers CSS et JS
	$css_file = '';
	$js_file = '';

	// Lire les fichiers du dossier dist/css, vérifier qu'ils sont présent
	if (is_dir($dist_dir . '/css')) {
			$css_files = glob($dist_dir . '/css/index.*.css');
			if (!empty($css_files)) {
					// Prend le premier fichier trouvé et l'assigne à la variable $css_file
					$css_file = basename($css_files[0]);
			}
	}

	// Lire les fichiers du dossier dist/js, vérifier qu'ils sont présent
	if (is_dir($dist_dir . '/js')) {
		$js_files = glob($dist_dir . '/js/index.*.js');
		if (!empty($js_files)) {
				
					// Prend le premier fichier trouvé et l'assigne à la variable $js_file
					$js_file = basename($js_files[0]);
			}
	}

	// Mise en file d'attente des fichiers si trouvés
	if ($css_file) {
			wp_enqueue_style('globalies_theme-style', $dist_uri . '/css/' . $css_file, [], null);
	}

	if ($js_file) {
		
			wp_enqueue_script('globalies_theme-js', $dist_uri . '/js/' . $js_file, [], null, true);
	}
}
add_action('wp_enqueue_scripts', 'globalies_theme_load_assets');

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = array( 'templates', 'views' );

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;


/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
class StarterSite extends Timber\Site {
	/** Add timber support. */
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action('init', [$this, 'add_custom_query_var']);
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		parent::__construct();
	}
	/** This is where you can register custom post types. */
	public function register_post_types() {
		require_once get_template_directory() . '/timber-context.php';
	}
	/** This is where you can register custom taxonomies. */
	public function register_taxonomies() {

	}

	public function add_custom_query_var()
    {
        global $wp;

        // Ajout d'une variable pour filtrer par "score" (champ ACF personnalisé).
        $wp->add_query_var('sort');
        $wp->add_query_var('filter');
        $wp->add_query_var('search');
    }

	/** This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context( $context ) {
		$context['foo']   = 'bar';
		$context['stuff'] = 'I am a value set in your functions.php file';
		$context['notes'] = 'These values are available everytime you call Timber::context();';
		$context['menu']  = new Timber\Menu(); 
		$context['theme_uri']  = get_template_directory_uri(); 
		$context['page_blank']  = get_permalink(346); 
		$context['site']  = $this;
		return $context;
	}


	public function theme_supports() {
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);

		add_theme_support( 'menus' );
		
	}


	function get_score_category($value) {
    if ($value > 65) {
        return 'high';
    } elseif ($value < 36) {
        return 'low';
    } else {
        return 'mid';
    }
	}

	


	/** This Would return 'foo bar!'.
	 *
	 * @param string $text being 'foo', then returned 'foo bar!'.
	 */
	public function myfoo( $text ) {
		$text .= ' bar!';
		return $text;
	}

	/** This is where you can add your own functions to twig.
	 *
	 * @param string $twig get extension.
	 */
	public function add_to_twig( $twig ) {
		parent::add_to_twig($twig);
		
		$twig->addExtension( new Twig\Extension\StringLoaderExtension() );
		$twig->addFunction(new Twig\TwigFunction('get_score_category', [$this, 'get_score_category']));
		$twig->addFunction(new Twig\TwigFunction('get_template_directory_uri', [$this, 'get_template_directory_uri']));
		$twig->addFilter( new Twig\TwigFilter( 'myfoo', array( $this, 'myfoo' ) ) );
		return $twig;
	}

}

new StarterSite();
