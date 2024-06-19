<?php
// Funzione per eseguire la query e ottenere il primo post di una pagina padre specificata
//Esempio: Pagina GENITORE: pagina3, pagina2, pagina1 --> verrà presa la pagina3 (perche ultima inserita)

// Definire una variabile globale per il contatore (fuori dalla funzione)
// Il contatore mi serve perche i post pari hanno un colore diverso da quelli dispari
global $global_post_counter;
$global_post_counter = 0;

function get_first_post_of_page( $parent_id ) {
    global $global_post_counter; // Usa la variabile globale

    $args = array(
        'post_type'      => 'page',
        'post_parent'    => $parent_id,
        'posts_per_page' => 1,
        'orderby'        => 'date',
        'order'          => 'DESC',
    );

    $query = new WP_Query( $args );

    $output = '';

    if ( $query->have_posts() ) {
        
        while ( $query->have_posts() ) {
            $query->the_post();
            // Salva l'output desiderato in una variabile
            ob_start(); // Inizia la memorizzazione dell'output
            $global_post_counter++; // Incrementa il contatore globale dei post
            ?>
            <!--singola card da 4 colonne-->
            <div class="col-3 flex-card center card watch fade-in">
              <a href="<?php the_permalink(); ?>" title="Vai al progetto <?php the_permalink(); ?>" target="_self">

                <!-- immagine in evidenza con condizione se cè o meno -->
                <?php 
                $has_thumbnail = has_post_thumbnail();
                if ( $has_thumbnail ) : ?>
                  <figure>
                    <?php the_post_thumbnail('large', array('class' => 'responsive')); ?>
                  </figure>
                <?php endif; ?> 

                <!-- titolo articolo e contenuto formatatto nel functions -->
                <!-- nella classe del testo gli dico che se c'è l'immagine, allora la classe è text-card, altrimenti text-card-noimg -->
                <div class="<?php
                echo $has_thumbnail ? 'text-card' : 'text-card-noimg';
                echo (!$has_thumbnail && $global_post_counter % 2 == 0) ? ' opacity' : ''; ?>">
                  <h3><?php the_title(); ?></h3>
                  <p><?php the_excerpt(); ?></p>
                  <div class="divider"></div>

                  <div class="nobutton"><?php esc_html_e('scopri','aipd-theme') ?><i class="fa-solid fa-chevron-right"></i></div>
                </div> <!--end text-card-->
              </a>
            </div><!--col-3 flex-card center-->
            <?php
            $output = ob_get_clean(); // Ottiene l'output e termina la memorizzazione
        }
    } else {
        $output = '<p>No posts found for parent ID ' . $parent_id . '</p>';
    }

    wp_reset_postdata();

    return $output;
}
?>


<?php
// Aggiungere pagine figlie ai menu di navigazione
add_filter('wp_nav_menu_objects', 'add_child_pages_to_menu', 10, 2);
//add_filter aggiunge una funzione personalizzata alle impostazioni predefinite degli Hook di WP
//primo parametro: nome dell'Hook
//secondo parametro: è la funzione personalizzata che vogliamo aggiungere
//terzo parametro: è la priorità della funzione
//quarto parametro: argomenti che accetta la funzione


function add_child_pages_to_menu($items, $args) {
    // Array degli ID delle pagine padre
    $parent_ids = array(283, 282, 280, 17);

    $new_items = array();
    foreach ($items as $item) {
        $new_items[] = $item;

        // Controlla se l'elemento del menu è una pagina e se è una delle pagine padre
        if ($item->type == 'post_type' && $item->object == 'page' && in_array($item->object_id, $parent_ids)) {
            // Ottieni le pagine figlie di questa pagina
            $child_pages = get_pages(array(
                'child_of' => $item->object_id,
                'posts_per_page' => -1,
                'sort_column' => 'ID', //i nuovi progetti hanno sempre ID maggiore
                'sort_order' => 'DESC'
            ));

            // Aggiungi ciascuna pagina figlia come nuovo elemento del menu
            foreach ($child_pages as $child_page) {
                $child_item = clone $item;
                $child_item->ID = $child_page->ID;
                $child_item->title = $child_page->post_title;
                $child_item->url = get_permalink($child_page->ID);
                $child_item->menu_item_parent = $item->ID;
                $child_item->db_id = $child_page->ID;
                $child_item->post_type = 'nav_menu_item';
                $child_item->object_id = $child_page->ID;
                $child_item->type = 'post_type';
                $child_item->object = 'page';
                $child_item->type_label = 'Page';
                $child_item->classes = array();
                $new_items[] = $child_item;
            }
        }
    }
    return $new_items;
}
?>