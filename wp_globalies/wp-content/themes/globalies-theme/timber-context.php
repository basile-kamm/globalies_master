<?php
add_filter('timber/context', function($context) {
  
  // $score = get_field('score'); // Fetch ACF or WP custom field

  // // Définition de la catégorie principale du score
  // if ($score > 65) {
  //     $context['score_category'] = 'high';
  // } elseif ($score < 35) {
  //     $context['score_category'] = 'low';
  // } else {
  //     $context['score_category'] = 'mid';
  // }

  // Vérifier si des posts sont présents

  $post = Timber::get_post();

  if ($post) {
      $criteria = ['impact_ecologique', 'produit_chimique', 'conditions_travail', 'influence_politique', 'impact_local'];

      // Initialize an empty array to store categories
      $categories = [];

      foreach ($criteria as $criterion) {
          $value = get_field($criterion, $post->ID); // Retrieve the ACF value

          if ($value !== false && $value !== null) {
              // Determine category based on value
              if ($value > 65) {
                  $category = 'high';
              } elseif ($value < 35) {
                  $category = 'low';
              } else {
                  $category = 'mid';
              }

              // Add the category to the array, using criterion as the key
              $categories[$criterion . '_category'] = $category;
          }
      }

      // Add the categories array to the context
      $context['categories'] = $categories;
  }

  // Make sure the post is added to the context as well
  $context['post'] = $post;
  
  return $context;

});
