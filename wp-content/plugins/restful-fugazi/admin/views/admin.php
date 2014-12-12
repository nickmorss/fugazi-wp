<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   RESTful_Fugazi
 * @author    Nick Morss <mail@nickmorss.com>
 * @license   GPL-2.0+
 * @link      
 * @copyright 2014 Nick Morss
 */
?>

<div class="wrap">
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	<!-- @TODO: Provide markup for your options page here. -->

<form method="post" action="/fugazi-wp/wp-admin/admin.php?page=restful-fugazi">


    <label><?php _e("Title:", 'menu-test' ); ?> 
        <input type="text" name="title" value="" size="20"/>
    </label>
    <br />
    <label><?php _e("Type:", 'menu-test' ); ?> 
        <select name="type">
            <option>Equtities</option>
            <option>Commodities</option>
        </select>
    </label>
    <br />
<?php
 $tags = get_tags();
$html = "<select name='bank'>";
foreach ( $tags as $tag ) {
    $tag_link = get_tag_link( $tag->term_id );
            
    $html .= "<option value='{$tag->slug}'>{$tag->name}</option>";
}
$html .= '</select>';
echo $html;
?><br />
<!--?php
($taxonomy = 'banks';
$limit = 10;
$queried_term = get_term_by( 'slug', get_query_var($taxonomy) );
$terms = get_terms($taxonomy);
shuffle($terms);
if ($terms) {
  foreach($terms as $term) {
    if ( ++$count > $limit) break;
    echo $sep . '<a href="' . $term->slug . '">' . $term->name .'</a>';
$sep = ', ';  // Put your separator here.
  }
}
?-->
    <br />
    <label><?php _e("Analyst:", 'menu-test' ); ?> 
        <input type="text" name="analyst" value="" size="20"/>
    </label>
    <br />
    <label><?php _e("Ranking:", 'menu-test' ); ?> 
        <input type="text" name="ranking" value="" size="20"/>
    </label>

    <input type="hidden" name="submit_ranking" value="submit_ranking" />

<hr />

<input type="submit" name="ranker" class="button-primary" value="Submit">

</form>

</div>



