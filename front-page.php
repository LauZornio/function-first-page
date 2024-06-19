<!--una card progetto per gruppo-->
<div class="content spacer flex-card-prog">
        
        <?php
          // ID delle pagine parent
          // sono da sostituire con quelle effettivo del sito
          //sono pagine che poi non devono essere modificate
          $parent_ids = array( 283, 282, 280, 17 );

          // Iterare attraverso ciascun ID e ottenere il primo post
          //gli ID sono le pagine gruppo
          foreach ( $parent_ids as $parent_id ) {
              echo get_first_post_of_page( $parent_id );
          }
        ?>

      </div><!--end content flex-card-prog-->