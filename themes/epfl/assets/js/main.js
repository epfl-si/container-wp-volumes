jQuery(document).ready(function($){
  
  $('html').addClass('redpandas-will-rule-the-world');
  
  // Toggle box 
  
  $(".collapsible:not(.open) .collapsible-content").hide();
  
  $(".collapsible .collapse-link").click(function(event){
    event.preventDefault();
    $(this).parents(".collapsible").find(".collapsible-content").slideToggle("fast");
    $(this).parents(".collapsible").toggleClass("open");
  });
  
  // Secondary navigation
  
  function secondaryNavigation() {
      
    // Add sub-menu control
    $('.sidebar .sub-menu li.menu-item-has-children').each( function(){
      $(this).prepend('<button class="sub-menu-control"></button>');
      $(this).addClass('open');
    });
    
    $('.sidebar .nav').find('button.sub-menu-control').click(function(){
      $(this).siblings('.sub-menu').toggle();
      $(this).parent('.menu-item-has-children').toggleClass('open');
    });
  
  } secondaryNavigation();
  
  
});