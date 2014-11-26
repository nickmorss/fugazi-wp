<?php

/* Child Theme */

add_action( 'wp_enqueue_scripts', 'enqueue_child_theme_styles', PHP_INT_MAX);
function enqueue_child_theme_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
    wp_enqueue_style( 'child-style', get_stylesheet_uri(), array('parent-style')  );
}


/* Register Connection types - relies on Post @ Post plugin */

function my_connection_types() {
    p2p_register_connection_type( array(
        'name' => 'snippets_to_posts',
        'from' => 'snippet',
        'to' => 'post'
    ) );
}
add_action( 'p2p_init', 'my_connection_types' );


/* custom Post 2 post filter template */

add_filter( 'p2p_widget_html', 'my_p2p_template_handling', 10, 4 );
add_filter( 'p2p_shortcode_html', 'my_p2p_template_handling', 10, 4 );

function my_p2p_template_handling( $html, $connected, $ctype, $mode ) {
    $template = locate_template( "p2p-{$ctype->name}.php" );

    if ( !$template )
        return $html;

    ob_start();

    $_post = $GLOBALS['post'];

    foreach ( $connected->items as $item ) {
        $GLOBALS['post'] = $item;

        load_template( $template, false );
    }

    $GLOBALS['post'] = $_post;

    return ob_get_clean();
}


function add_snippets_to_posts( $content ) {
    if ( get_post_type() != 'snippet') {
        $quote = get_post_meta( get_the_ID(), 'quote', true);

        if( ! empty( $quote ) ) {
            $content .= '<h3>Quote: ' . $quote . '</h3>';
        }

        $forcasts = get_post_meta( get_the_ID(), 'forcasts', true);

        if( ! empty( $quote ) ) {
            $content .= '<h3>Forcasts: ' . $forcasts . '</h3>';
        }

      $content .= "[p2p_connected type=snippets_to_posts]";
      //$content .= '[cf-shortcode plugin="generic" field="quote"]';
    }
    return $content;
}
//Insert function using a filter
add_filter('the_content','add_snippets_to_posts');



/* try to filter the Benchmark Email 
 # Currenlty not working well


//add_filter( 'benchmarkemaillite_compile_email_theme', 'fugazi_email_filter', 10, 1 );

function fugazi_email_filter( $data ) {

//  $data .= "World!";
    
    global $post;
    // Find connected pages
    $connected = new WP_Query( array(
      'connected_type' => 'snippets_to_posts',
      'connected_items' => get_queried_object(),
      'nopaging' => true,
    ) );
    // Display connected pages
    if ( $connected->have_posts() ) {
        $sb = "<h3>by func</h3><ul>";
        while ( $connected->have_posts() ) : $connected->the_post(); 
            $sb .= '<li><a href="' . the_permalink() . '">' . the_title() . '</a></li>';
        endwhile;
        $sb .= '</ul>';
        $data .= $sb;
    }
    $data .= $connected->have_posts();
    
    
    return $data;
}
*/

?>