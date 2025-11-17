<?php
/**
 * Template padrão de categoria
 * Exibe posts da categoria atual com paginação universal
 * Totalmente otimizado (SEO + performance + organização)
 *
 * @package Eachline
 */

get_header();

// Hero antes do conteúdo (padrão do tema)
get_template_part('template-parts/section/hero');

/**
 * Objeto da categoria atual
 */
$category      = get_queried_object();
$cat_id        = $category->term_id ?? 0;
$cat_title     = $category->name ?? 'Categoria';
$cat_desc      = $category->description ?? '';

/**
 * Página atual
 */
$paged = max(1, get_query_var('paged'));

/**
 * Query da categoria
 */
$category_query = new WP_Query([
    'post_type'           => 'post',
    'cat'                 => $cat_id,
    'posts_per_page'      => get_option('posts_per_page'),
    'paged'               => $paged,
    'ignore_sticky_posts' => true,
]);
?>

<section id="content" class="section-container container <?php echo is_archive() ? 'py-5' : ''; ?> my-5">

    <!-- Cabeçalho da categoria -->
    <?php if (!is_archive()): ?>
        <header class="d-flex flex-column mb-4">
            <h1 class="section-title mb-2"><?php echo esc_html($cat_title); ?></h1>

            <?php if ($cat_desc): ?>
                <p class="section-description text-muted">
                    <?php echo wp_kses_post($cat_desc); ?>
                </p>
            <?php endif; ?>
        </header>
    <?php endif; ?>



    <!-- Bloco específico para categoria "cases" -->
    <?php if (is_category('cases')): ?>
        <?php
        get_template_part(
            'template-parts/section/section-links',
            null,
            [
                'link_category_slug' => 'parceiros',
                'section_id'         => 'partners',
                'custom_title'       => 'Convira quem confia em nós!',
                'custom_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor...',
            ]
        );
        ?>
    <?php endif; ?>


    <?php if ($category_query->have_posts()): ?>

        <!-- Títulos especiais para categorias específicas -->
        <?php if (is_category('cases')): ?>
            <header class="section-header mb-5">
                <h2 class="section-title mb-0">Histórias de Sucesso</h2>
                <div class="section-description my-0">
                    Nossa coleção de resultados reais construídos com nossos clientes.
                </div>
            </header>
        <?php endif; ?>

        <?php if (is_category('artigos')): ?>
            <header class="section-header mb-5">
                <h2 class="section-title mb-0">Confira nossos textos</h2>
                <div class="section-description my-0">
                    Conteúdos sobre acessibilidade, design e tecnologia.
                </div>
            </header>
        <?php endif; ?>


        <!-- LISTA DE POSTS -->
        <div class="post-list row">
            <?php while ($category_query->have_posts()): $category_query->the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class('col-md-4 mb-4'); ?>>
                    <div class="card h-100 border-0">

                        <?php if (has_post_thumbnail()): ?>
                            <a href="<?php the_permalink(); ?>" class="d-block overflow-hidden ratio ratio-16x9">
                                <?php the_post_thumbnail('large', [
                                    'class'       => 'h-100 object-fit-cover card-img img-fluid',
                                    'alt'         => esc_attr(get_the_title()),
                                    'loading'     => 'lazy',
                                    'decoding'    => 'async',
                                ]); ?>
                            </a>
                        <?php endif; ?>

                        <div class="card-body">
                            <header>
                                <h3 class="card-title h5 mb-2">
                                    <a href="<?php the_permalink(); ?>" class="link-text link-primary">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                            </header>

                            <p class="card-text text-muted small mb-3">
                                <?php echo wp_trim_words(get_the_excerpt(), 25, '...'); ?>
                            </p>

                            <footer class="footer-card">
                                <a href="<?php the_permalink(); ?>" class="link-text link-primary">
                                    Continue lendo <i class="fa-solid fa-arrow-right ms-1"></i>
                                </a>
                            </footer>
                        </div>

                    </div>
                </article>

            <?php endwhile; ?>
        </div>


        <!-- PAGINAÇÃO UNIVERSAL -->
        <?php
        /**
         * A paginação universal usa o WP_Query atual
         * e detecta automaticamente que é category
         */
        $wp_query = $category_query;
        get_template_part('template-parts/pagination');
        ?>

    <?php else: ?>

        <p class="text-center text-muted">Nenhum post encontrado nesta categoria.</p>

    <?php endif; ?>

</section>

<?php
wp_reset_postdata();
get_footer();
?>
