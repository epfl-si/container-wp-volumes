<?php get_header(); ?>

<?php if($GLOBALS['type'] == 'insidesidebar-left') get_sidebar(); ?>

<section id="content-111" role="main" style="<?php if($GLOBALS['type'] == '') echo 'width:96% !important;'?>">
<?php

$name = '404';
if(is_home())
    $name = 'index';
if(is_single())
    $name='single';
if(is_archive())
    $name = 'archive';
if(is_search())
    $name = 'search';
if(is_page())
    $name = 'page';
if(is_author())
    $name = 'author';
if(is_category())
    $name = 'category';
if(is_attachment())
    $name = 'attachment';

get_template_part( 'loop', $name);

?>
</section>

<?php if($GLOBALS['type'] == 'insidesidebar-right') get_sidebar(); ?>

<?php get_footer(); ?>
