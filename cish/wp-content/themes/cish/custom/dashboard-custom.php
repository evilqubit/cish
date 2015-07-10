<?php
function remove_default_post_type() {
	remove_menu_page('edit.php');
}

add_action('login_form','my_added_login_field');
function my_added_login_field()
{
	$num1 = rand(1, 10);
	$num2 = rand(1, 10);
	$sum = $num1+$num2;
?>
	<p>
			<label for="sum_field"><?php echo $num1.'+'.$num2.'=';?>
				<input type="text" value="" class="input" id="sum_field" name="sum_field"/>
		</label>
		<input type="hidden" name="ans" value="<?php echo $sum;?>" />
	</p>
<?php
}
function my_check_login($user, $password)
{
	$sum_check = ( isset($_POST['sum_field']) && ($_POST['sum_field'] == $_POST['ans'])) ? 1 : 0;
	if( !$sum_check ){
		remove_action('authenticate', 'wp_authenticate_username_password', 20);
		$user = new WP_Error( 'denied', __("<strong>ERROR</strong>: Wrong sum.") );
	}

	return $user;
}
add_filter( 'wp_authenticate_user', 'my_check_login', 10, 3 );

function my_login_stylesheet() {?>
	<link rel="stylesheet" id="custom_wp_admin_css"  href="<?php echo get_bloginfo( 'stylesheet_directory' ) . '/custom/style-login.css'; ?>" type="text/css" media="all" />
<?php }
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );

if (!function_exists('my_login_logo_url')){
	function my_login_logo_url() {
		 return get_bloginfo( 'url' );
	}
	add_filter( 'login_headerurl', 'my_login_logo_url' );
}

if (!function_exists('my_dashboard_stylesheet')){
	function my_login_logo_url_title() {
		return get_bloginfo( 'title' ).' CMS';
	}
	add_filter( 'login_headertitle', 'my_login_logo_url_title' );
}

if (!function_exists('my_dashboard_stylesheet')){
	function my_dashboard_stylesheet(){
		echo '<link rel="stylesheet" type="text/css" href="' .get_bloginfo('template_url'). '/custom/psettings.css">';
	}
	add_action('admin_head', 'my_dashboard_stylesheet');
}

if (!function_exists('dashboard_footer')){
	function dashboard_footer () {
		echo 'Created by <a target="_blank" href="http://a-ps-z.com">ps</a>';
	}
	add_filter('admin_footer_text', 'dashboard_footer');
}
?>