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
        private $post_types_a;
        private $post_types_b;
        private $tax_name_a;
        private $tax_name_b;

        /**
         * Create taxonomies to host the terms a-z
         *
         * @param string $tax_name_a
         * @param string $tax_name_b
         * @param array $post_types_a
         * @param array $post_types_b
         * @param string $slug_rewrite_a
         * @param string $slug_rewrite_b
         */
        public function __construct(
            string $tax_name_a = null,
            string $tax_name_b = null,
            array $post_types_a = array('post'),
            array $post_types_b = array('post'),
            string $slug_rewrite_a = null,
            string $slug_rewrite_b = null) {
            if (!taxonomy_exists($tax_name_a) && $tax_name_a != null) {
            string $tax_name_a = NULL,
            string $tax_name_b = NULL,
            array $post_types_a = array('post'), 
            array $post_types_b = array('post'), 
            string $slug_rewrite_a = NULL, 
            string $slug_rewrite_b = NULL,
            bool $show_ui)
        {
            if (!taxonomy_exists( $tax_name_a ) && $tax_name_a != NULL ) {
                register_taxonomy(
                    $tax_name_a,
                    $post_types_a,
                    array(
                        'public' => true,
                        'show_ui' => $show_ui,
                        'rewrite' => array('slug' => $slug_rewrite_a),
                        'hierarchical' => true,
                    )
                );
                //return $post_types_a;
                //add_action('save_post', array($this, 'auto_glossary_on_save'));
            }

            if (!taxonomy_exists($tax_name_b) && $tax_name_b != null) {
                register_taxonomy(
                    $tax_name_b,
                    $post_types_b,
                    array(
                        'public' => true,
                        'show_ui' => $show_ui,
                        'rewrite' => array('slug' => $slug_rewrite_b),
                        'hierarchical' => true,
                    )
                );
                //return $post_types_b;
                //add_action('save_post', array($this, 'auto_glossary_on_save'));
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
         * @param string $tax_name_a
         * @return void
         */
        public function recursive_glossary_post_a()
        {
            if (!has_term('', 'autor_a_z')) {
                $taxonomy = 'autor_a_z';
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
         * @param string $tax_name_b
         * @return void
         */
        public function recursive_glossary_post_b()
        {
            if (!has_term('', 'obra_a_z')) {
                $taxonomy = 'obra_a_z';
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
         * @param string $tax_name_a
         * @param string $tax_name_b
         * @return void
         */
        public function glossary_menu_front_end(
            string $tax_name_a = null,
            string $tax_name_b = null) {
            /**
             * If the taxonomy A parameter is passed then create the alphabetical menu
             */
            if ($tax_name_a != null) {
                $terms = get_terms($tax_name_a);
                $alphabet = array();
                if ($terms) {
                    foreach ($terms as $term) {
                        $alphabet[] = $term->slug;
                    }
                }
                ?>
                <div id="alphabet-menu" class="pagination d-flex justify-content-center">
                    <ul class="pagination d-flex">
                        <?php
foreach (range('a', 'z') as $i):
                    $current = ($i == get_query_var($tax_name_a)) ? "current-menu-item" : "menu-item";
                    if (in_array($i, $alphabet)) {
                        printf('<li class="page-item az-char %s"><a href="%s" class="page-link">%s</a></li>', $current, get_term_link($i, $tax_name_a), strtoupper($i));
                    } else {
                        printf('<li class="page-item az-char %s disabled"><span class="page-link">%s</span></li>', $current, strtoupper($i));
                    }
                endforeach;
                ?>
                    </ul>
                </div>
                <?php
}

            /**
             * If the taxonomy B parameter is passed then create the alphabetical menu
             */
            if ($tax_name_b != null) {
                $terms = get_terms($tax_name_b);
                $alphabet = array();
                if ($terms) {
                    foreach ($terms as $term) {
                        $alphabet[] = $term->slug;
                    }
                }
                ?>
<div id="alphabet-menu" class="pagination d-flex justify-content-center">
    <ul class="pagination">
        <?php
foreach (range('a', 'z') as $i):
                    $current = ($i == get_query_var($tax_name_b)) ? "current-menu-item" : "menu-item";
                    if (in_array($i, $alphabet)) {
                        printf('<li class="page-item az-char %s"><a href="%s" class="page-link">%s</a></li>', $current, get_term_link($i, $tax_name_b), strtoupper($i));
                    } else {
                        printf('<li class="page-item az-char %s disabled"><span class="page-link">%s</span></li>', $current, strtoupper($i));
                    }
                endforeach;
                ?>
    </ul>
</div>
<?php
}
        }
    }
}