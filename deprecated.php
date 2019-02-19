<?php

            /**
             * If the $tax_name_2 parameter is passed then create the alphabetical menu based on bootstrap pagination
             */
            /*
            if ($tax_name_2 != null) {
                $terms = get_terms($tax_name_2);
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
                    $current = ($i == get_query_var($tax_name_2)) ? "current-menu-item" : "menu-item";
                    if (in_array($i, $alphabet)) {
                        printf('<li class="page-item ' . $tax_name_2 . ' %s"><a href="%s" class="page-link">%s</a></li>', $current, get_term_link($i, $tax_name_2), strtoupper($i));
                    } else {
                        printf('<li class="page-item ' . $tax_name_2 . ' %s disabled"><span class="page-link">%s</span></li>', $current, strtoupper($i));
                    }
                endforeach;
                ?>
    </ul>
</div>
<?php
}
*/


            /**
             * If the $tax_name_1 parameter is passed then create the alphabetical menu based on bootstrap pagination
             */
            /*
            if ($tax_name_1 != null) {
            $terms = get_terms($tax_name_1);
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
            $current = ($i == get_query_var($tax_name_1)) ? "current-menu-item" : "menu-item";
            if (in_array($i, $alphabet)) {
            printf('<li class="page-item ' . $tax_name_1 . ' %s"><a href="%s" class="page-link">%s</a></li>', $current, get_term_link($i, $tax_name_1), strtoupper($i));
            } else {
            printf('<li class="page-item ' . $tax_name_1 . ' %s disabled"><span class="page-link">%s</span></li>', $current, strtoupper($i));
            }
            endforeach;
            ?>
    </ul>
</div>
<?php
            }
             */