<?php 
/**
 * Template Name: Styleguide
 * The template is for rendering the above template.
 *
 * @package 	WordPress
 * @subpackage 	WPS
 * @version 	1.0
*/
?>

<?php 

// password protected
if ( post_password_required( $post ) ) :
	echo get_the_password_form();
else :


	if ( have_posts() ) :

		while ( have_posts() ) : the_post(); ?>

			<section class="styleguide__section">
				<div class="container">
					<h2><?php echo bloginfo('name'); ?> Styleguide</h2>
				</div>
			</section>

			<section class="styleguide__section">
				<div class="container">

					<h2 class="styleguide__heading">Brand Colors</h2>

					<h3 class="styleguide__subheading">Base</h3>

					<div class="styleguide-module__subgroup">
						<p class="sg-copy">Base colors are used for backgrounds, etc.</p>
					</div>

					<ul class="styleguide__colors">
						
						<li class="bg--base-white">
							<span>
								base-white / #ffffff
							</span>
						</li>

						<li class="bg--base-light">
							<span class="text--base-black">
								base-light / #f5f5f5
							</span>
						</li>
						<li class="bg--base-medium">
							<span>
								base-medium / #5e5e5e
							</span>
						</li>
						<li class="bg--base-dark">
							<span>
								base-dark / #323232
							</span>
						</li>
						<li class="bg--base-black">
							<span>
								base-black / #000000
							</span>
						</li>

					</ul>

					<h3 class="styleguide__subheading">Brand</h3>

					<div class="styleguide-module__subgroup">
						<p class="sg-copy">Brand colors are used for most UI; e.g. module backgrounds, buttons, callouts, etc.</p>
					</div>

					<ul class="styleguide__colors">

						<li class="bg--brand-bg-light">
							<span class="text--base-black">
								brand-bg-light / #f3f0ea
							</span>
						</li>
						<li class="bg--brand-bg-medium">
							<span class="text--base-black">
								brand-bg-medium / #ebe8e1
							</span>
						</li>
						<li class="bg--brand-primary">
							<span>
								brand-primary / #428959
							</span>
						</li>
						<li class="bg--brand-secondary">
							<span>
								brand-secondary / #225733
							</span>
						</li>

						<hr>

						<li class="bg--brand-divider">
							<span class="text--base-black">
								brand-divider / #ddd9d6
							</span>
						</li>
						<li class="bg--brand-text">
							<span>
								brand-text / #5e5e5e
							</span>
						</li>

					</ul>

					<h3 class="styleguide__subheading">States</h3>

					<div class="styleguide-module__subgroup">
						<p class="sg-copy">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae sunt unde quasi, itaque adipisci impedit repellendus architecto incidunt enim accusamus tenetur natus labore voluptatum minima, aperiam! Maxime unde animi explicabo.</p>
					</div>

					<ul class="styleguide__colors">

						<li class="bg--state-success">
							<span>
								state-success / #428959
							</span>
						</li>
						<li class="bg--state-error">
							<span>
								state-error / #de1818
							</span>
						</li>

					</ul>

					<h3 class="styleguide__subheading">Social</h3>

					<div class="styleguide-module__subgroup">
						<p class="sg-copy">Social colors are used for representation of social channels on the site.</p>
					</div>

					<ul class="styleguide__colors">

						<li class="bg--social-facebook">
							<span>
								social-facebook / #3b5998
							</span>
						</li>
						<li class="bg--social-instagram">
							<span>
								social-instagram / #405de6
							</span>
						</li>
						<li class="bg--social-linkedin">
							<span>
								social-linkedin / #0077b5
							</span>
						</li>
						<li class="bg--social-twitter">
							<span>
								social-twitter / #1da1f2
							</span>
						</li>
						<li class="bg--social-pinterest">
							<span>
								social-pinterest / #bd081c
							</span>
						</li>

					</ul>

				</div>
			</section>

			<section class="styleguide__section">
				<div class="container">

					<h2 class="styleguide__heading">Brand Typography</h2>

					<?php

						$typography = [
							'Headings' => [
								'h1 class="sg-heading"' => [
									'font-name' => 'Circular Regular',
									'font-size' => '80px',
									'font-weight' => '700',
									'line-height' => '90px',
									'letter-spacing' => '-1.2px',
									'usage' => 'h1',
									'value' => 'abcdefghijklmnopqrstuvwxyz<br>1234567890'
								],
								'h2 class="sg-heading"' => [
									'font-name' => 'Circular Regular',
									'font-size' => '60px',
									'font-weight' => '700',
									'line-height' => '70px',
									'letter-spacing' => '-.9px',
									'usage' => 'h2',
									'value' => 'abcdefghijklmnopqrstuvwxyz<br>1234567890'
								],
								'h3 class="sg-heading"' => [
									'font-name' => 'Circular Regular',
									'font-size' => '48px',
									'font-weight' => '700',
									'line-height' => '58px',
									'letter-spacing' => '0px',
									'usage' => 'h3',
									'value' => 'abcdefghijklmnopqrstuvwxyz<br>1234567890'
								],
								'h4 class="sg-heading"' => [
									'font-name' => 'Circular Regular',
									'font-size' => '19px',
									'font-weight' => '700',
									'line-height' => '24px',
									'letter-spacing' => '-0.2px',
									'usage' => 'h4',
									'value' => 'abcdefghijklmnopqrstuvwxyz<br>1234567890'
								],
								'h5 class="sg-heading"' => [
									'font-name' => 'Circular Regular',
									'font-size' => '32.5px',
									'font-weight' => '700',
									'line-height' => '41.6px',
									'letter-spacing' => '-0.5px',
									'usage' => 'h5',
									'value' => 'abcdefghijklmnopqrstuvwxyz<br>1234567890'
								],
								'h6 class="sg-heading"' => [
									'font-name' => 'Circular Regular',
									'font-size' => '28px',
									'font-weight' => '700',
									'line-height' => '38px',
									'letter-spacing' => '-0.28px',
									'usage' => 'h6',
									'value' => 'abcdefghijklmnopqrstuvwxyz<br>1234567890'
								],
							],
							'Paragraphs' => [
								'p class="sg-copy"' => [
									'font-name' => 'Circular Regular',
									'font-size' => '18px',
									'font-weight' => '400',
									'line-height' => '28px',
									'letter-spacing' => '.09px',
									'usage' => 'Standard body copy + Long Form',
									'value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Tortor consequat id porta nibh venenatis cras sed felis. Elit at imperdiet dui accumsan sit amet nulla facilisi. Integer enim neque volutpat ac tincidunt vitae semper quis lectus. Imperdiet sed euismod nisi porta. Erat nam at lectus urna duis convallis. Sit amet justo donec enim diam. Sed nisi lacus sed viverra tellus. Sodales neque sodales ut etiam sit amet nisl. Viverra suspendisse potenti nullam ac tortor vitae purus faucibus ornare.'
								],
								'p class="sg-copy blog-snippet"' => [
									'font-name' => 'Circular Regular',
									'font-size' => '19px',
									'font-weight' => '500',
									'line-height' => '29px',
									'letter-spacing' => '1px',
									'usage' => 'Blog Detail Snippet (after post title)',
									'value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'
								]
							],
							'Other' => [
								'p class="sg-copy pullquote"' => [
									'font-name' => 'Circular Regular',
									'font-size' => '38px',
									'font-weight' => '700',
									'line-height' => '48px',
									'letter-spacing' => '-0.57px',
									'usage' => 'Pullquote / Blockquote?',
									'value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'
								],
								'span class="sg-copy eyebrow"' => [
									'font-name' => 'Circular Regular',
									'font-size' => '12px',
									'font-weight' => '500',
									'line-height' => '24px',
									'letter-spacing' => '0.35px',
									'usage' => 'Eyebrow',
									'value' => 'Lorem Ipsum Dolor'
								],
								'p class="sg-copy byline"' => [
									'font-name' => 'Circular Regular',
									'font-size' => '12px',
									'font-weight' => '700',
									'line-height' => '24px',
									'letter-spacing' => '0.35px',
									'usage' => 'Blog Byline',
									'value' => 'Maecenas faucibus mollis interdum. Maecenas sed diam eget risus varius blandit sit amet non magna. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh.'
								],
							],
						];

						foreach ($typography as $key => $value) {
							echo '<h5 class="styleguide-module__title--small">'. $key .'</h5>';
							echo '<div class="styleguide-module__subgroup">';
								foreach ($value as $k => $v) {
									// sp([$k, $v]);

									echo '<' . $k . ' contenteditable="true">';
									echo $v['value'];
									echo '</' . $k . '>';

									echo '<span class="styleguide-module__title--light">Usage: '. $v['usage'] .'</span>';

									echo '<span class="styleguide-module__title--light">';

										echo 'Font: '. $v['font-name'] .
											' - FW: '. $v['font-weight'] .
											' / FS: '. $v['font-size'] .
											' / LH: '. $v['line-height'] .
											' / LS: '. $v['letter-spacing'];

									echo '</span>';

									echo '<br>';

								}
							echo '</div>';
						}

					?>

				</div>
			</section>

			<div class="styleguide__section">
				<div class="container">
					<h2 class="styleguide__heading">UI</h2>
					<div class="styleguide-module__subgroup">
						<h5 class="styleguide-module__title--small">Links</h5>
						<div class="styleguide-module__subgroup">
							<a href="javascript:;" class="link">
								<div class="link__label">
									A link
								</div>
								<span class="link__icon"></span>
							</a>
						</div>
						
						<h5 class="styleguide-module__title--small">Buttons</h5>
						<div class="styleguide-module__subgroup buttons">
							<a href="javascript:;" class="button">Get Started Now</a>
							<a href="javascript:;" class="button button--ghost">Get Started Now</a>
						</div>

						<h5 class="styleguide-module__title--small">Buttons on Pale?</h5>
						<div class="styleguide-module__subgroup buttons other">
							<a href="javascript:;" class="button button--inverted">Get Started Now</a>
						</div>

						<h5 class="styleguide-module__title--small">Buttons on Dark / Dash</h5>
						<div class="styleguide-module__subgroup buttons dark">
							<a href="javascript:;" class="button">Get Started Now</a>
							<a href="javascript:;" class="button button--ghost">Get Started Now</a>
						</div>

						<h5 class="styleguide-module__title--small">Forms</h5>
						<br>
						<div class="styleguide-module__subgroup">
							<form action="">
								<fieldset>
									<div class="group">
										<input required type="text" name="email">
										<span class="bar"></span>
										<label for="email">Email</label>
									</div>
									<div class="group">
										<input required type="password" name="password">
										<span class="bar"></span>
										<label for="password">Password</label>
									</div>
								</fieldset>
								<br>
								<input type="submit" class="button" value="Submit">
							</form>
						</div>

					</div>
				</div>
			</div>

			<div class="styleguide__section">
				<div class="container">
					<h2 class="styleguide__heading">Banners</h2>
					<div class="styleguide-module__subgroup">

					</div>
				</div>
			</div>

		<?php endwhile; 

	endif; wp_reset_postdata();


endif; // password protected

?>