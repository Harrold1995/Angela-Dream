<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */


if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<?php wc_print_notices(); ?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

<div class="row" id="customer_login">

	<div class="col-md-offset-3 col-md-3">

<?php endif; ?>

		<h2><?php _e( 'Login', 'woocommerce' ); ?></h2>

		<form method="post" class="login">

			<?php do_action( 'woocommerce_login_form_start' ); ?>

			<p class="form-group form-row-wide">
				<input placeholder="<?php _e( 'Username or email address', 'woocommerce' ); ?> *" type="text" class="input-text" name="username" id="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
				<i class="fa fa-user"></i>
			</p>
			<p class="form-group form-row-wide">
				<input placeholder="<?php _e( 'Password', 'woocommerce' ); ?> *" class="input-text" type="password" name="password" id="password" />
				<i class="fa fa-lock"></i>
			</p>

			<?php do_action( 'woocommerce_login_form' ); ?>

			<p class="form-row">
				<?php wp_nonce_field( 'woocommerce-login' ); ?>
				<label for="rememberme" class="inline">
					<input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e( 'Remember me', 'woocommerce' ); ?>
				</label>
				<input type="submit" class="btn btn-md" name="login" value="<?php _e( 'Login', 'woocommerce' ); ?>" /> 
			</p>
			<p class="lost_password">
				<a href="<?php echo esc_url( wc_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'woocommerce' ); ?></a>
			</p>

			<?php do_action( 'woocommerce_login_form_end' ); ?>

		</form>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

	</div>

	<div class="col-md-3">

		<h2><?php _e( 'Register', 'woocommerce' ); ?></h2>

		<h3><?php _e( 'Creating an account is quick and easy, and will allow you to move through our checkout quicker.', 'woocommerce' ); ?></h3>

		<div class="btn btn-md show-register"><?php _e( 'Register', 'woocommerce' ); ?></div>

		<form method="post" class="register hidden">

			<?php do_action( 'woocommerce_register_form_start' ); ?>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

				<p class="form-group form-row-wide">
					<input placeholder="<?php _e( 'Username', 'woocommerce' ); ?> *" type="text" class="input-text" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
					<i class="fa fa-user"></i>
				</p>

			<?php endif; ?>

			<p class="form-group form-row-wide">
				<input placeholder="<?php _e( 'Email address', 'woocommerce' ); ?> *" type="email" class="input-text" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" />
				<i class="fa fa-envelope"></i>
			</p>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
	
				<p class="form-group form-row-wide">
					<input placeholder="<?php _e( 'Password', 'woocommerce' ); ?> *" type="password" class="input-text" name="password" id="reg_password" />
					<i class="fa fa-lock"></i>
				</p>

			<?php endif; ?>

			<!-- Spam Trap -->
			<div style="left:-999em; position:absolute;"><label for="trap"><?php _e( 'Anti-spam', 'woocommerce' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>

			<?php do_action( 'woocommerce_register_form' ); ?>
			<?php do_action( 'register_form' ); ?>

			<p class="form-row">
				<?php wp_nonce_field( 'woocommerce-register' ); ?>
				<input type="submit" class="btn btn-md" name="register" value="<?php _e( 'Register', 'woocommerce' ); ?>" />
			</p>

			<?php do_action( 'woocommerce_register_form_end' ); ?>

		</form>

	</div>

</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
