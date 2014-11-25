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

<form name="ranker" method="post" action="">


    <label><?php _e("Title:", 'menu-test' ); ?> 
        <input type="text" name="title" value="" size="20">
    </label>
    <br />
    <label><?php _e("Type:", 'menu-test' ); ?> 
        <select name="type">
            <option>Equtities</option>
            <option>Commodities</option>
        </select>
    </label>
    <br />
    
    <label><?php _e("Bank:", 'menu-test' ); ?> 
        <input type="text" name="bank" value="" size="20">
    </label>
    <br />
    <label><?php _e("Analyst:", 'menu-test' ); ?> 
        <input type="text" name="analyst" value="" size="20">
    </label>
    <br />
    <label><?php _e("Ranking:", 'menu-test' ); ?> 
        <input type="text" name="ranking" value="" size="20">
    </label>

<hr />

<button id="submit-js" class="button-primary">
<?php esc_attr_e('Save Changes') ?>
</button>

</form>

<script type="text/javascript">



jQuery("#submit-js").on("click", function() {
    jQuery.ajax({
      type: 'GET',
      url:  '/some/url/title/' + jQuery("[name=title]").val() + '/bank/' + jQuery("[name=bank]").val() + '/analyst/' + jQuery("[name=analyst]").val() + '/ranking/' + jQuery("[name=ranking]").val(),
      contentType: 'application/json',
      success: function() {console.log('success')},
      error: function(req, status, ex) {console.log(status)},
      timeout:60000
    });
return false;
});


</script>

</div>
