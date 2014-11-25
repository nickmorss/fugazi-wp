<?php

add_action( 'wp_enqueue_scripts', 'enqueue_child_theme_styles', PHP_INT_MAX);
function enqueue_child_theme_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
    wp_enqueue_style( 'child-style', get_stylesheet_uri(), array('parent-style')  );
}


function my_connection_types() {
    p2p_register_connection_type( array(
        'name' => 'snippets_to_posts',
        'from' => 'snippet',
        'to' => 'post'
    ) );
}
add_action( 'p2p_init', 'my_connection_types' );



add_filter( 'benchmarkemaillite_compile_email_theme', 'fugazi_email_filter', 10, 1 );

function fugazi_email_filter( $data ) {

	$data = str_replace( 'FOOTER', 'filterd!!!', $data );
	$data .= implode("|",$data);
	$data .= "Hello ";
	$data .= "World!";
	
	
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
	
	
    return $data;
}





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


?>