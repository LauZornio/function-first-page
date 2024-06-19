# Funzione per prendere la prima pagina di una pagina genitore

## Panoramica del Progetto
Questo progetto è solo una piccola parte di un tema custom per Wordpress.
Per necessità progetturali, ho dinamicizzato e automatizzato la comparsa delle pagine, riuscendo a selezionare quelle di mio interesse.
 - Avendo una Pagina GENITORE con diverse Pagine FIGLIE
 - Seleziono solo l'ultima pagina inserita per Pagina GENITORE.
   Questo perché, essendoci più gruppi con molti progetti per ogni gruppo, avevo la necessità di selezionare solo l'ultimo progetto di ogni gruppo ed esporlo in     front-page

## Caratteristiche
- **Template della Home Page Personalizzata (`front-page.php`):**
  - Visualizza i progetti raggruppati per pagine genitore.
  - Recupera e visualizza dinamicamente l'ultimo progetto di ciascun gruppo, facendo appello alla funzione nel file functions.php
  - Supporta il design responsivo per una migliore esperienza utente su diversi dispositivi (essendo un esercizio estrapolato da un contesto, non si vedrà la card)
  - Importante: inserire gli ID corretti delle pagine GENITORE

- **Funzioni Personalizzate get_first_post_of_page( $parent_id ) (`functions.php`):**
  - Include una funzione per recuperare l'ultimo post dalle pagine genitore specificate.
  - Garantisce stili alternati per i post pari e dispari: con un contatore globale è possibile stabilire i post pari e quelli dispari dando una colorazione diversa.      In questo esempio c'è anche la variante della presenza o meno dell'immagine (data dall'immagine in evidenza della pagina stessa).
  - Utilizzo della funzione ob_start() per il buffering dell'output
    
- **Funzioni Personalizzate add_child_pages_to_menu($items, $args) (`functions.php`):**
  - Per una migliore efficienza di automatizzazione, ho creato una funzione per aggiungere in modo automatico, le pagine figlie al menu principale di navigazione.
  - aggiugere la funzionalità aggiuntiva di WP con **add_filter('wp_nav_menu_objects', 'add_child_pages_to_menu', 10, 2);**, che consente di aggiungere una       
    funzione custom all'hook **wp_nav_menu_objects**
  - Importante: inserire gli ID delle pagine GENITORE corretti.

## Licenza
Questo progetto è distribuito sotto la licenza MIT. Vedi il file LICENSE per i dettagli.
