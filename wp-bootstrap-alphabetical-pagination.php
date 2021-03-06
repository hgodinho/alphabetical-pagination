<?php
/**
 * Wordpress Bootstrap Alphabetical Pagination
 *
 * Based on 'Kathy Is Awesome' tutorial
 * @source https://www.kathyisawesome.com/alphabetical-posts-glossary/
 *
 * This class does not import the bootstrap necessary files, you have
 * to do this by yourself on functions.php
 *
 * @version 0.1
 *
 * @package Wordpress
 * @package Bootstrap
 *
 * @author hgodinho <ola@hgodinho.com>
 */

if (!class_exists('WP_Glossary_Bootstrap')) {

    class WP_Glossary_Bootstrap
    {
        private $post_types_1;
        private $post_types_2;
        private $tax_name_1;
        private $tax_name_2;

        /**
         * Create taxonomies to host the terms a-z
         *
         * @param string $tax_name_1
         * @param string $tax_name_2
         * @param array $post_types_1
         * @param array $post_types_3
         * @param string $slug_rewrite_1
         * @param string $slug_rewrite_2
         * @param bool $show_ui
         */
        public function __construct(
            string $tax_name_1 = null,
            string $tax_name_2 = null,
            array $post_types_1 = null,
            array $post_types_2 = null,
            string $slug_rewrite_1 = null,
            string $slug_rewrite_2 = null,
            bool $show_ui = null) {
            if (!taxonomy_exists($tax_name_1) && $tax_name_1 != null) {
                register_taxonomy(
                    $tax_name_1,
                    $post_types_1
                    ,
                    array(
                        'public' => true,
                        'show_ui' => $show_ui,
                        'rewrite' => array('slug' => $slug_rewrite_1),
                        'hierarchical' => true,
                    )
                );
            }

            if (!taxonomy_exists($tax_name_2) && $tax_name_2 != null) {
                register_taxonomy(
                    $tax_name_2,
                    $post_types_2,
                    array(
                        'public' => true,
                        'show_ui' => $show_ui,
                        'rewrite' => array('slug' => $slug_rewrite_2),
                        'hierarchical' => true,
                    )
                );
            }
        }

        /**
         * Create taxonomies on post save
         *
         * @param [type] $post_id
         * @return void
         */
        public function auto_glossary_on_save($post_id)
        {
            // verify if this is an auto save routine.
            // If it is our form has not been submitted, so we dont want to do anything
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return $post_id;
            }
            //check location
            if (!in_array($_POST['post_type'], $post->post_types)) {
                return $post_id;
            }
            // Check permissions
            if (!current_user_can('edit_post', $post_id)) {
                return $post_id;
            }
            //set term as first letter of post title, lower case
            $letra = strtolower(substr($_POST['post_title'], 0, 1));
            wp_set_object_terms($post_id, $letra, 'glossario');
        }

        /**
         * Goes thru all the posts and create term from the firt letter of the post_title
         *
         * @param string $tax_name_1
         * @return void
         */
        public function recursive_glossary_post_1()
        {
            if (!has_term('', 'autor_az')) {
                $taxonomy = 'autor_az';
                $alphabet = array();
                $args = array(
                    'post_type' => 'autores',
                    'posts_per_page' => -1,
                );
                $posts = get_posts($args);

                foreach ($posts as $post):
                    //set term as first letter of post title, lower case
                    //echo $post->ID;
                    $letra = strtolower(substr($post->post_title, 0, 1));
                    wp_set_object_terms($post->ID, $letra, $taxonomy, true);
                endforeach;

            }
        }

        /**
         * Goes thru all the posts and create terms from the firt letter of the post_title
         *
         * @param string $tax_name_2
         * @return void
         */
        public function recursive_glossary_post_2()
        {
            if (!has_term('', 'obra_az')) {
                $taxonomy = 'obra_az';
                $alphabet = array();
                $args = array(
                    'post_type' => 'obras',
                    'posts_per_page' => -1,
                );
                $posts = get_posts($args);

                foreach ($posts as $post):
                    //set term as first letter of post title, lower case
                    //echo $post->ID;
                    $letra = strtolower(substr($post->post_title, 0, 1));
                    wp_set_object_terms($post->ID, $letra, $taxonomy, true);
                endforeach;

            }
        }

        /**
         * Create bootstrap alphabetical menu
         *
         * @param string $tax_name_1
         * @param string $tax_name_2
         * @return void
         */
        public function glossary_menu_front_end(
            string $tax_name_1 = null,
            string $tax_name_2 = null) {

            /**
             * If the $tax_name_1 parameter is passed then create the alphabetical menu based on bootstrap button group
             */
            if ($tax_name_1 != null) {
                $terms = get_terms($tax_name_1);
                $alphabet = array();
                if ($terms) {
                    foreach ($terms as $term) {
                        $alphabet[] = $term->slug;
                    }
                }
                ?>
<div id="alphabet-menu" class="justify-content-center shadow hidden rounded-0" role="group" aria-label="glossario">
    <?php
foreach (range('a', 'z') as $i):
                    $current = ($i == get_query_var($tax_name_1)) ? "current-menu-item active" : "menu-item";
                    if (in_array($i, $alphabet)) {
                        printf('<a class="btn-az-single btn btn-outline-secondary ' . $tax_name_1 . ' %s"  href="%s" >%s</a>', $current, get_term_link($i, $tax_name_1), strtoupper($i) );
                    } else {
                        printf('<a class="btn-az-single btn btn-outline-secondary ' . $tax_name_1 . ' %s disabled" tabindex="-1" aria-disabled="true">%s</a>', $current, strtoupper($i) );
                    }
                endforeach;
                ?>
</div>
<?php
}

            /**
             * If the $tax_name_1 parameter is passed then create the alphabetical menu based on bootstrap button group
             */
            if ($tax_name_2 != null) {
                $terms = get_terms($tax_name_2);
                $alphabet = array();
                if ($terms) {
                    foreach ($terms as $term) {
                        $alphabet[] = $term->slug;
                    }
                }
                ?>
<div id="alphabet-menu" class="justify-content-center shadow hidden rounded-0" role="group" aria-label="glossario">
    <?php
foreach (range('a', 'z') as $i):
                    $current = ($i == get_query_var($tax_name_2)) ? "current-menu-item active" : "menu-item";
                    if (in_array($i, $alphabet)) {
                        printf('<a class="btn-az-single btn btn-outline-secondary ' . $tax_name_2 . ' %s" href="%s">%s</a>', $current, get_term_link($i, $tax_name_2), strtoupper($i));
                    } else {
                        printf('<a class="btn-az-single btn btn-outline-secondary ' . $tax_name_2 . ' %s disabled" tabindex="-1" aria-disabled="true">%s</a>', $current, strtoupper($i));
                    }
                endforeach;
                ?>
</div>
<?php
}

        }
    }
}