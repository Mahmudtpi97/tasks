<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset') ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/assets/fontawesome/css/all.min.css"> 
    <!-- https://fontawesome.com/ -->
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet"> 
    <!-- https://fonts.google.com/ -->
    <link href="<?php echo get_template_directory_uri();?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri();?>/assets/css/style.css" rel="stylesheet">
    <link href="<?php echo get_stylesheet_uri();?>" rel="stylesheet">
    <?php wp_head(); ?>
</head>
<body>
<!-- Container Area  -->
<div class="container-fluid">
    <main class="p-3">
         <!-- Search form -->
         <div class="row">
            <div class="col-12">


                <div class="form-inline tm-mb-80 tm-search-form justify-content-start">  

                    <input type="text" class="form-control tm-search-input" id="keyword" onkeyup="myFunction()" placeholder="Search...." name="s" aria-label="Search" >

                    <button class="tm-search-button" type="submit">
                        <i class="fas fa-search tm-search-icon" aria-hidden="true"></i>
                    </button>               
                </div>
                <div class="search_result" id="datafetch">
                        <ul>
                            <li>Please wait..</li>
                        </ul>
                    </div> 

            </div>                
        </div> 
    <!-- Blog Area    -->
    <div class="row mt-3">
        <?php 
          $tasks = new WP_Query(array(
                  'post_type'       => 'tasks',
                  'posts_per_page'  => 6,
                  'order'           =>'DESC',
               ));
               while($tasks->have_posts()) : $tasks->the_post();
             ?>
                <article class="col-12 col-md-6 tm-post card p-3 shadow mr-2 tasks">
                     <div class="tm-post-image d-flex justify-content-between mr-2 ml-2">
                        <?php  the_post_thumbnail('thumbnail');?>
                        <!-- <span class="favorite-button mr-2">
                            <i class="far fa-star"></i>
                        </span>  -->
                        
                        <?php 
                            $post_id = get_the_ID(); 
                            $site_id = get_main_site_id();
                            echo the_favorites_button($post_id, $site_id);
                         ?>
                    </div>
                    <h2 class="tm-post-title mt-2 title" id="title"><?php the_title();?></h2>  
                    <p> <?php echo wp_trim_words(get_the_content(),20);?> </p>
                    
                </article>
            <?php endwhile; ?>
            <div class="error-box">
                <h3 class="text-danger text-center" id="error"></h3>
            </div>
    </div>
    <footer class="row">
        <hr class="col-12">
        <div class="col-md-6 col-12 tm-color-gray">
            Develop by: <a rel="nofollow" target="_parent" href="#" class="tm-external-link">Mahmudul Hasan</a>
        </div>
        <div class="col-md-6 col-12 tm-color-gray tm-copyright">
            Copyright 2023 Blog Company Co. Ltd.
        </div>
    </footer>
 </main>
</div>

<?php wp_footer(); ?>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

<script>
    function myFunction(){
        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'post',
            data: { action: 'data_fetch', keyword: jQuery('#keyword').val() },
            success: function(data) {
                console.log(data);
                jQuery('#datafetch').html(data);
            }
        });
    }

  jQuery(document).ready(function($) {
        function myFunction() {
            var input, filter, articles, i, txtValue;
            input = document.getElementById("keyword");
            filter = input.value.toLowerCase();
            articles = document.getElementsByClassName("tasks");
            // title = document.getElementsByClassName("title");
            
            for (i = 0; i < articles.length; i++) {
                txtValue = articles[i].textContent || articles[i].innerText;
                if (txtValue.toLowerCase().indexOf(filter) > -1) {
                    articles[i].style.display = "block"; // Show the article
                    $('#error').text(' ');
                } else {
                    articles[i].style.display = "none"; // Hide the article
                    $('#error').text('Item Not Found');
                }
            }
        }

        // Attach the myFunction() to the input event
        document.getElementById("keyword").addEventListener("input", myFunction);
        // Handle click event on search results
            $("#keyword").keyup(function() {
                if ($(this).val().length > 0) {
                    $("#datafetch").show();
                } else {
                    $("#datafetch").hide();
                }
            });

        // Click handler for #title element
        $(document).on('click', '#title, #datafetch li', function() {
            var clickedTitle = $(this).text();
            $("#keyword").val(clickedTitle);
            $(".tasks").hide();
            $("#datafetch").hide();
            $(".tasks:contains('" + clickedTitle + "')").show();
        });
    });

</script>
</body>
</html>

    
