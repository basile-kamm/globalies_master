
<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.2
 */

$templates = array( 'archive.twig', 'index.twig' );

$context = Timber::context();


$context['title'] = 'Archive';
if ( is_day() ) {
	$context['title'] = 'Archive: ' . get_the_date( 'D M Y' );
} elseif ( is_month() ) {
	$context['title'] = 'Archive: ' . get_the_date( 'M Y' );
} elseif ( is_year() ) {
	$context['title'] = 'Archive: ' . get_the_date( 'Y' );
} elseif ( is_tag() ) {
	$context['title'] = single_tag_title( '', false );
} elseif ( is_category() ) {
	$context['title'] = single_cat_title( '', false );
	array_unshift( $templates, 'archive-' . get_query_var( 'cat' ) . '.twig' );
} elseif ( is_post_type_archive() ) {
	$context['title'] = post_type_archive_title( '', false );
	array_unshift( $templates, 'archive-' . get_post_type() . '.twig' );
}


// Base des paramètres pour la requête
$query_args = [
	'post_type'      => 'marque',
	'posts_per_page' => -1,
	'meta_query'     => []
];

// Récupérer les paramètres
$context["sorting_param"] = get_query_var("sort") ? get_query_var("sort") : NULL;
$context["filter_param"] = get_query_var("filter") ? get_query_var("filter") : "all";
$context["search"] = get_query_var("search") ? get_query_var("search") : "";

// Appliquer le filtre sur les multinationales
if ($context["filter_param"] === "inde") {
	$query_args['meta_query'][] = [
			'key'     => 'related_multinationale',
			'compare' => '', // Filtre les marques sans multinationale
	];
	$query_args['meta_query'][] = [
			'key'     => 'related_multinationale',
			'value'   => '',
			'compare' => '=', // Filtre aussi celles qui ont un champ vide
	];
} elseif ($context["filter_param"] === "sub") {
	$query_args['meta_query'][] = [
			'key'     => 'related_multinationale',
			'compare' => 'EXISTS', // Filtre les marques avec une multinationale
	];
	$query_args['meta_query'][] = [
			'key'     => 'related_multinationale',
			'value'   => '',
			'compare' => '!=', // Exclut celles qui ont un champ vide
	];
}

// Appliquer le tri en fonction du score
if ($context["sorting_param"]) {
	$query_args['meta_key'] = 'score';
	$query_args['orderby']  = 'meta_value_num';
	$query_args['order']    = $context["sorting_param"];
}

if ($context["sorting_param"] == "initial") {
	unset($query_args['meta_key']);
	unset($query_args['orderby']);
	unset($query_args['order']);
}

// Recherche dans le titre et le champ related_multinationale.title

$context["search"] = get_query_var("search") ? get_query_var("search") : "";

// Recherche dans le titre et le champ related_multinationale.title

if (!empty($context["search"])) {
	$query_args['s'] = $context["search"];
	// $query_args['meta_query'][] = [
	// 		'key'     => 'Post(related_multinationale.title)', // Assurez-vous que ce champ stocke bien le titre
	// 		'value'   => $context["search"],
	// 		'compare' => 'LIKE',
	// ];
}

// Exécuter la requête
$context['marques'] = new WP_Query($query_args);


$context['posts'] = Timber::get_posts($query_args);
$context['slug'] = get_post_type();


Timber::render( $templates, $context );
