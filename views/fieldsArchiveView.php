<?php get_header(); ?>
<div class="wrap">

	<?php if ( $results->have_posts() ) : ?>
		<header class="page-header">
			<?php
				the_archive_title( '<h1 class="page-title archive-description taxonomy-archive-description taxonomy-description">', '</h1>' );
				the_archive_description( '<div class="taxonomy-description archive-description">', '</div>' );
			?>
		</header><!-- .page-header -->
	<?php endif; ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( $results->have_posts() ) : ?>
			<?php
			/* Start the Loop */
			while ( $results->have_posts() ) : $results->the_post();?>
				<article class="entry">
					<header class="entry-header">
						<h2 class="entry-title" itemprop="headline">
							<a href="<?php the_permalink(); ?>" rel="bookmark">
							<?php the_title() ?></a>
						</h2>
						<p class="entry-meta">
							<time class="entry-time" itemprop="datePublished"><?php the_date(); ?></time> By <?php the_author() ?>
						</p>
					</header>
					<div class="entry-content" itemprop="text">
						<?php the_excerpt(); ?>
					</div>
				</article>
			<?php endwhile;

			the_posts_pagination( array(
				'prev_text' => twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
				'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span>' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
			) );

		else :

			echo 'No hay resultados con esa búsqueda.';

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->
	<?php get_sidebar('sidebar-primary'); genesis(); ?>
</div><!-- .wrap -->
