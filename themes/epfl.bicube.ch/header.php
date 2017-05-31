<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta name="viewport" content="width=device-width" />
  <title><?php wp_title( ' | ', true, 'right' ); ?></title>
  <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/style-base.css" />
  <?php wp_head(); ?>
  <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>" />
<base href="http://epfl.bicube.ch/">
	<link rel="shortcut" href="http://epfl.bicube.ch/wp-content/uploads/2016/12/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="http://epfl.bicube.ch/wp-content/uploads/2016/12/favicon.ico" type="image/x-icon">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1.0, maximum-scale=4.0, user-scalable=yes">	<link rel="alternate" type="application/rss+xml" title="EPFL RSS2 Feed" href="http://epfl.bicube.ch/feed/">
	<link rel="pingback" href="http://epfl.bicube.ch/xmlrpc.php">
  <link rel="stylesheet" href="/wp-content/themes/epfl_ultimatum/epfl-built.css">
	
		<link rel="dns-prefetch" href="//s.w.org">
		<script async src="//www.google-analytics.com/analytics.js"></script><script type="text/javascript">
			window._wpemojiSettings = {"baseUrl":"https:\/\/s.w.org\/images\/core\/emoji\/2.2.1\/72x72\/","ext":".png","svgUrl":"https:\/\/s.w.org\/images\/core\/emoji\/2.2.1\/svg\/","svgExt":".svg","source":{"concatemoji":"http:\/\/epfl.bicube.ch\/wp-includes\/js\/wp-emoji-release.min.js?ver=6f1ad6211ed7bfd7bdd8591e481e6fd7"}};
			!function(a,b,c){function d(a){var b,c,d,e,f=String.fromCharCode;if(!k||!k.fillText)return!1;switch(k.clearRect(0,0,j.width,j.height),k.textBaseline="top",k.font="600 32px Arial",a){case"flag":return k.fillText(f(55356,56826,55356,56819),0,0),!(j.toDataURL().length<3e3)&&(k.clearRect(0,0,j.width,j.height),k.fillText(f(55356,57331,65039,8205,55356,57096),0,0),b=j.toDataURL(),k.clearRect(0,0,j.width,j.height),k.fillText(f(55356,57331,55356,57096),0,0),c=j.toDataURL(),b!==c);case"emoji4":return k.fillText(f(55357,56425,55356,57341,8205,55357,56507),0,0),d=j.toDataURL(),k.clearRect(0,0,j.width,j.height),k.fillText(f(55357,56425,55356,57341,55357,56507),0,0),e=j.toDataURL(),d!==e}return!1}function e(a){var c=b.createElement("script");c.src=a,c.defer=c.type="text/javascript",b.getElementsByTagName("head")[0].appendChild(c)}var f,g,h,i,j=b.createElement("canvas"),k=j.getContext&&j.getContext("2d");for(i=Array("flag","emoji4"),c.supports={everything:!0,everythingExceptFlag:!0},h=0;h<i.length;h++)c.supports[i[h]]=d(i[h]),c.supports.everything=c.supports.everything&&c.supports[i[h]],"flag"!==i[h]&&(c.supports.everythingExceptFlag=c.supports.everythingExceptFlag&&c.supports[i[h]]);c.supports.everythingExceptFlag=c.supports.everythingExceptFlag&&!c.supports.flag,c.DOMReady=!1,c.readyCallback=function(){c.DOMReady=!0},c.supports.everything||(g=function(){c.readyCallback()},b.addEventListener?(b.addEventListener("DOMContentLoaded",g,!1),a.addEventListener("load",g,!1)):(a.attachEvent("onload",g),b.attachEvent("onreadystatechange",function(){"complete"===b.readyState&&c.readyCallback()})),f=c.source||{},f.concatemoji?e(f.concatemoji):f.wpemoji&&f.twemoji&&(e(f.twemoji),e(f.wpemoji)))}(window,document,window._wpemojiSettings);
		</script><script src="http://epfl.bicube.ch/wp-includes/js/wp-emoji-release.min.js?ver=6f1ad6211ed7bfd7bdd8591e481e6fd7" type="text/javascript" defer></script>
		<style type="text/css">
img.wp-smiley,
img.emoji {
	display: inline !important;
	border: none !important;
	box-shadow: none !important;
	height: 1em !important;
	width: 1em !important;
	margin: 0 .07em !important;
	vertical-align: -0.1em !important;
	background: none !important;
	padding: 0 !important;
}
</style>
<link rel="stylesheet" id="theme-global-css" href="http://epfl.bicube.ch/wp-content/themes/ultimatum/assets/css/theme.global.css?ver=6f1ad6211ed7bfd7bdd8591e481e6fd7" type="text/css" media="all">
<link rel="stylesheet" id="font-awesome-css" href="http://epfl.bicube.ch/wp-content/themes/ultimatum/assets/css/font-awesome.min.css?ver=6f1ad6211ed7bfd7bdd8591e481e6fd7" type="text/css" media="all">
<link rel="stylesheet" id="ult_core_template_1-css" href="http://epfl.bicube.ch/wp-content/uploads/epfl_ultimatum/template_1.css?ver=6f1ad6211ed7bfd7bdd8591e481e6fd7" type="text/css" media="all">
<link rel="stylesheet" id="ult_core_layout_26-css" href="http://epfl.bicube.ch/wp-content/uploads/epfl_ultimatum/layout_26.css?ver=6f1ad6211ed7bfd7bdd8591e481e6fd7" type="text/css" media="all">
<link rel="stylesheet" id="js_composer_front-css" href="http://epfl.bicube.ch/wp-content/plugins/js_composer/assets/css/js_composer.min.css?ver=5.1.1" type="text/css" media="all">
<link rel="stylesheet" id="template_custom_1-css" href="http://epfl.bicube.ch/wp-content/uploads/epfl_ultimatum/template_custom_1.css?ver=6f1ad6211ed7bfd7bdd8591e481e6fd7" type="text/css" media="all">
<link rel="stylesheet" id="bsf-Defaults-css" href="http://epfl.bicube.ch/wp-content/uploads/smile_fonts/Defaults/Defaults.css?ver=6f1ad6211ed7bfd7bdd8591e481e6fd7" type="text/css" media="all">
<script type="text/javascript" src="http://epfl.bicube.ch/wp-includes/js/jquery/jquery.js?ver=1.12.4"></script>
<script type="text/javascript" src="http://epfl.bicube.ch/wp-includes/js/jquery/jquery-migrate.min.js?ver=1.4.1"></script>
<link rel="https://api.w.org/" href="http://epfl.bicube.ch/wp-json/">
<link rel="EditURI" type="application/rsd+xml" title="RSD" href="http://epfl.bicube.ch/xmlrpc.php?rsd">
<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="http://epfl.bicube.ch/wp-includes/wlwmanifest.xml"> 

<link rel="canonical" href="http://epfl.bicube.ch/">
<link rel="shortlink" href="http://epfl.bicube.ch/">
<link rel="alternate" type="application/json+oembed" href="http://epfl.bicube.ch/wp-json/oembed/1.0/embed?url=http%3A%2F%2Fepfl.bicube.ch%2F">
<link rel="alternate" type="text/xml+oembed" href="http://epfl.bicube.ch/wp-json/oembed/1.0/embed?url=http%3A%2F%2Fepfl.bicube.ch%2F&amp;format=xml">
<meta name="generator" content="Powered by Visual Composer - drag and drop page builder for WordPress.">
<!--[if lte IE 9]><link rel="stylesheet" type="text/css" href="http://epfl.bicube.ch/wp-content/plugins/js_composer/assets/css/vc_lte_ie9.min.css" media="screen"><![endif]--><noscript><style type="text/css"> .wpb_animate_when_almost_visible { opacity: 1; }</style></noscript>	<script src="https://use.fontawesome.com/74546ab68b.js"></script><link href="https://use.fontawesome.com/74546ab68b.css" media="all" rel="stylesheet">
	<script type="text/javascript">
//<![CDATA[
var pptheme = 'facebook';
//]]>
</script>	 
<style id="fit-vids-style">.fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}</style>
  
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css"></head>
<body <?php body_class(); ?>>
  
  <div id="page" class="site site-wrapper" itemscope="" itemtype="http://schema.org/WebPage">

    <!-- The minimal EPFL header -->
    <header id="epfl-header" class="site-header epfl" role="banner" aria-label="Bandeau EPFL global" data-ajax-header="//static.epfl.ch/v0.22.15/includes/epfl-header.fr.html"><div class="logo">
    <a href="http://www.epfl.ch">
      <span class="visuallyhidden">Page d&apos;accueil EPFL</span>
      <object type="image/svg+xml" class="logo-object" data="//static.epfl.ch/latest/images/logo.svg">
        <img alt="Logo EPFL" width="95" height="46" src="//static.epfl.ch/latest/images/logo.png">
      </object>
    </a>
  </div><div class="epflnav">
    <a href="#epfl-navigation" id="epfl-navigation-label" class="icon icon-menu toggle-hidden ui-toggle" data-widget="toggle" tabindex="0" role="button" aria-controls="epfl-navigation">
      <span class="visuallyhidden">Navigation globale EPFL</span>
    </a>
    <nav id="epfl-navigation" class="nav visible-s visible-m visible-l visible-xl visible-xxl toggle-hidden" role="navigation" aria-labelledby="epfl-navigation-label" aria-hidden="true">
      <ul class="nav-list">
        <li class="nav-item public">
          <a id="public-link" href="http://www.epfl.ch/navigate.fr.shtml" class="nav-link toggle-hidden ui-toggle" data-widget="toggle" data-overlay="true" aria-controls="public-pane" tabindex="0" role="button">Par <span>public</span><span class="icon icon-arrow-bottom-right"></span></a>
        </li>
        <li class="nav-item school">
          <a id="school-link" href="http://www.epfl.ch/navigate.fr.shtml" class="nav-link toggle-hidden ui-toggle" data-widget="toggle" data-overlay="true" aria-controls="school-pane" tabindex="0" role="button">Par <span>facult&#xE9;</span><span class="icon icon-arrow-bottom-right"></span></a>
        </li>
        <li class="nav-item about">
          <a id="about-link" href="http://www.epfl.ch/navigate.fr.shtml" class="nav-link toggle-hidden ui-toggle" data-widget="toggle" data-overlay="true" aria-controls="about-pane" tabindex="0" role="button">EPFL <span>en bref</span><span class="icon icon-arrow-bottom-right"></span></a>
        </li>
      </ul>
    </nav>
  </div><div class="search">
    <a href="#search" class="icon icon-magnifier toggle-hidden ui-toggle" data-widget="toggle" tabindex="0" role="button" aria-controls="search">
      <span class="visuallyhidden">Recherche</span>
    </a>
    <div id="search" aria-hidden="true" role="search" class="toggle-hidden">
      <form id="search-form" class="form form-inline" action="//search.epfl.ch/psearch.action">
        <input type="hidden" name="request_locale" value="fr">
        <input type="hidden" name="site" value="" disabled="disabled">
        <div class="form-input-group">
          <div class="form-input">
            <label class="visuallyhidden" for="search-query">Requ&#xEA;te de recherche</label>
            <input id="search-query" class="search-query" type="text" placeholder="chercher&#x2026;" name="q" accesskey="4" autocomplete="off" aria-autocomplete="both" aria-expanded="false" aria-owns="search-suggestions" role="combobox">
          </div>
          <div class="form-select search-domain">
            <label class="visuallyhidden" for="search-domain">Domaine de recherche</label>
            <select id="search-domain" name="domain">
              <option value="directory" selected="selected">Personnes</option>
              <option value="epfl">Sites web EPFL</option>
              <option value="places">Lieux</option>
              <option value="site">Ce site</option>
              <option value="courses">Cours</option>
              <option value="publications">Publications</option>
              <option value="news">Actualit&#xE9;s</option>
              <option value="units">Unit&#xE9;s EPFL</option>
            </select>
          </div>
          <div class="form-input form-input-mini">
            <button class="themed search-submit" type="submit">
              <span class="icon icon-magnifier"></span><span class="visuallyhidden">Chercher</span>
            </button>
          </div>
        </div>
      <div class="autocomplete-suggestions" id="search-suggestions" role="listbox" style="position: absolute; display: none; max-height: 300px; z-index: 9999;"></div></form>
    </div>
  </div><div id="public-pane" class="pane public toggle-hidden ui-overlay" aria-hidden="true">
    <nav role="navigation" aria-labelledby="public-link">
      <h1 class="visuallyhidden">Navigation globale par public</h1>
      <section class="g-span-1_3 media nav nav-vertical">
        <header><h2 class="media-header epfl-color2"><a href="http://futuretudiant.epfl.ch/fr">Portail Futurs &#xC9;tudiants</a></h2></header>
        <ul class="nav-list media-content">
          <li class="nav-item"><a class="nav-link" href="http://bachelor.epfl.ch/etudes"><strong>Bachelor</strong></a>, <a class="nav-link" href="http://master.epfl.ch/fr"><strong>Master</strong></a>, <a class="nav-link" href="http://phd.epfl.ch/accueil"><strong>Doctorat</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://futuretudiant.epfl.ch/mobilite"><strong>&#xC9;tudiants en &#xE9;change</strong></a></li>
        </ul>
      </section>
      <section class="g-span-1_3 media nav nav-vertical">
        <header><h2 class="media-header epfl-color2"><a href="http://studying.epfl.ch/portail-etudiants">Portail &#xC9;tudiants</a></h2></header>
        <ul class="nav-list media-content">
          <li class="nav-item"><a class="nav-link" href="http://studying.epfl.ch/guichet_etudiants"><strong>Guichet &#xE9;tudiants</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://memento.epfl.ch/academic-calendar/"><strong>Calendrier acad&#xE9;mique</strong></a></li>
        </ul>
      </section>
      <section class="g-span-1_3 media nav nav-vertical">
        <header><h2 class="media-header epfl-color2"><a href="http://research.epfl.ch">Portail Chercheurs</a></h2></header>
        <ul class="nav-list media-content">
          <li class="nav-item"><a class="nav-link" href="http://research-office.epfl.ch/financements"><strong>Sources de financement</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://actu.epfl.ch/search/research_awards/"><strong>Prix et distinctions</strong></a></li>
        </ul>
      </section>
      <section class="g-span-1_3 media clear nav nav-vertical">
        <header><h2 class="media-header epfl-color2"><a href="http://working.epfl.ch/portail-collaborateurs">Portail Collaborateurs</a></h2></header>
        <ul class="nav-list media-content">
          <li class="nav-item"><a class="nav-link" href="http://rh.epfl.ch"><strong>Ressources humaines</strong></a></li>
          <li class="nav-item"><a class="nav-link" href=" http://polylex.epfl.ch/page-26060-fr.html"><strong>Polylex: lois, directives</strong></a></li>
        </ul>
      </section>
      <section class="g-span-1_3 media nav nav-vertical">
        <header><h2 class="media-header epfl-color2"><a href="http://entreprises.epfl.ch/fr">Portail Entreprises</a></h2></header>
        <ul class="nav-list media-content">
          <li class="nav-item"><a class="nav-link" href="http://vpi.epfl.ch/fr"><strong>Innovation &amp; valorisation</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://vpi.epfl.ch/innovationpark_fr"><strong>EPFL Innovation Park</strong></a></li>
        </ul>
      </section>
      <section class="g-span-1_3 media nav nav-vertical">
        <header><h2 class="media-header epfl-color2"><a href="http://medias.epfl.ch/fr">Portail M&#xE9;dias</a></h2></header>
        <ul class="nav-list media-content">
          <li class="nav-item"><a class="nav-link" href="http://actu.epfl.ch/search/mediacom/?keywords=&amp;date_filter=all&amp;projects=190&amp;search=Rechercher"><strong>Communiqu&#xE9;s de presse</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://mediacom.epfl.ch/epfl-magazine"><strong>EPFL Magazine</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://mediatheque.epfl.ch/"><strong>Banque d&apos;images</strong></a></li>
        </ul>
      </section>
      <section class="g-span-1_3 media clear nav nav-vertical">
        <header><h2 class="media-header epfl-color2"><a href="http://teaching.epfl.ch/fr">Portail Enseignants</a></h2></header>
        <ul class="nav-list media-content">
          <li class="nav-item">Gestion des <a class="nav-link" href="http://teaching.epfl.ch/cms/site/teaching/lang/fr/preparer-un-cours_1"><strong>cours</strong></a> et des <a class="nav-link" href="http://teaching.epfl.ch/mes-etudiants_1"><strong>&#xE9;tudiants</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://gymnases.epfl.ch/page-92859-fr.html"><strong>Interface Gymnases</strong></a></li>
        </ul>
      </section>

      <section class="g-span-1_3 media nav nav-vertical">
        <header><h2 class="media-header epfl-color2"><a href="http://www.epflalumni.ch/">Portail EPFL Alumni</a></h2></header>
        <ul class="nav-list media-content">
          <li class="nav-item"><a class="nav-link" href="https://www.epflalumni.ch/avantages/formulaire-de-demande/"><strong>Rejoindre la communaut&#xE9;</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://www.epflalumni.ch/nos-evenements/"><strong>Ev&#xE9;nements Alumni</strong></a></li>
        </ul>
      </section>
    </nav>
  </div><div id="school-pane" class="pane school toggle-hidden ui-overlay" aria-hidden="true">
    <nav role="navigation" aria-labelledby="school-link">
      <h1 class="visuallyhidden">Navigation globale par facult&#xE9;</h1>
      <section class="g-span-1_3 media nav nav-vertical">
        <header><h2 class="media-header enac-color"><a href="http://enac.epfl.ch/fr">Environnement Naturel, Architectural et Construit <abbr title="Environnement Naturel, Architectural et Construit">ENAC</abbr></a></h2></header>
        <ul class="nav-list media-content">
          <li class="nav-item"><a class="nav-link" href="http://enac.epfl.ch/architecture"><strong>Architecture</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://enac.epfl.ch/ingenierie-civile"><strong>Ing&#xE9;nierie civile</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://enac.epfl.ch/ingenierie-de-l-environnement"><strong>Ing&#xE9;nierie de l&apos;environnement</strong></a></li>
        </ul>
      </section>
      <section class="g-span-1_3 media nav nav-vertical">
        <header><h2 class="media-header sb-color"><a href="http://sb.epfl.ch/fr">Sciences de Base <abbr title="Sciences de Base">SB</abbr></a></h2></header>
        <ul class="nav-list media-content">
          <li class="nav-item"><a class="nav-link" href="http://sb.epfl.ch/chimie"><strong>Chimie</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://sb.epfl.ch/mathematiques"><strong>Math&#xE9;matiques</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://sb.epfl.ch/physique"><strong>Physique</strong></a></li>
        </ul>
      </section>
      <section class="g-span-1_3 media nav nav-vertical">
        <header><h2 class="media-header sti-color"><a href="http://sti.epfl.ch/fr">Sciences et Techniques de l&apos;Ing&#xE9;nieur <abbr title="Sciences &amp; Techniques de l&apos;Ing&#xE9;nieur">STI</abbr></a></h2></header>
        <ul class="nav-list media-content">
          <li class="nav-item"><a class="nav-link" href="http://sti.epfl.ch/genie-electrique-et-electronique"><strong>G&#xE9;nie &#xE9;lectrique et &#xE9;lectronique</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://sti.epfl.ch/genie-mecanique"><strong>G&#xE9;nie m&#xE9;canique</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://sti.epfl.ch/science-et-genie-des-materiaux"><strong>Science et g&#xE9;nie des mat&#xE9;riaux</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://sti.epfl.ch/microtechnique"><strong>Microtechnique</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://ibi.epfl.ch/"><strong>Bioengineering</strong></a></li>
        </ul>
      </section>
      <section class="g-span-1_3 media clear nav nav-vertical">
        <header><h2 class="media-header ic-color"><a href="http://ic.epfl.ch/fr">Informatique et Communications <abbr title="Informatique &amp; Communications">IC</abbr></a></h2></header>
        <ul class="nav-list media-content">
          <li class="nav-item"><a class="nav-link" href="http://ic.epfl.ch/informatique"><strong>Informatique</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://ic.epfl.ch/syscom"><strong>Syst&#xE8;mes de communication</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://ic.epfl.ch/science-donnees"><strong>Data Science</strong></a></li>
        </ul>
      </section>
      <section class="g-span-1_3 media nav nav-vertical">
        <header><h2 class="media-header sv-color"><a href="http://sv.epfl.ch/fr">Sciences de la Vie <abbr title="Sciences de la Vie">SV</abbr></a></h2></header>
        <ul class="nav-list media-content">
          <li class="nav-item"><a class="nav-link" href="http://bioengineering.epfl.ch"><strong>Bioing&#xE9;nierie</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://sv.epfl.ch/neurosciences"><strong>Neurosciences Brain Mind &amp; Blue Brain</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://sv.epfl.ch/infectiologie"><strong>Infectiologie</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://sv.epfl.ch/isrec"><strong>Cancer</strong></a></li>
        </ul>
      </section>
      <section class="g-span-1_3 media nav nav-vertical">
        <header><h2 class="media-header cdm-color"><a href="http://cdm.epfl.ch/accueil">Coll&#xE8;ge du Management de la Technologie <abbr title="Coll&#xE8;ge du Management de la Technologie">CDM</abbr></a></h2></header>
        <ul class="nav-list media-content">
          <li class="nav-item"><a class="nav-link" href="http://cdm.epfl.ch/page-116734-fr.html"><strong>Management de la Technologie</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://cdm.epfl.ch/page-116778-fr.html"><strong>Technologie et politiques publiques</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://sfi.epfl.ch"><strong>Ing&#xE9;nierie financi&#xE8;re</strong></a></li>
        </ul>
      </section>
      <section class="g-span-1_3 media clear nav nav-vertical">
        <header><h2 class="media-header cdh-color"><a href="http://cdh.epfl.ch/fr">Coll&#xE8;ge des Humanit&#xE9;s <abbr title="Coll&#xE8;ge des Humanit&#xE9;s">CDH</abbr></a></h2></header>
        <ul class="nav-list media-content">
          <li class="nav-item"><a class="nav-link" href="http://cdh.epfl.ch/shs"><strong>Sciences humaines et sociales</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://iags.epfl.ch"><strong>Area and Global Studies</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://dhi.epfl.ch/home-fr"><strong>Humanit&#xE9;s digitales</strong></a></li>
        </ul>
      </section>
    </nav>
  </div><div id="about-pane" class="pane about toggle-hidden ui-overlay" aria-hidden="true">
    <nav role="navigation" aria-labelledby="about-link">
      <h1 class="visuallyhidden">Global information links</h1>
      <section class="g-span-1_3 media nav nav-vertical">
        <header><h2 class="media-header"><a href="http://information.epfl.ch/presentation"><abbr style="color:#e2001a;" title="&#xC9;cole Polytechnique F&#xE9;d&#xE9;rale de Lausanne">EPFL</abbr></a></h2></header>
        <ul class="nav-list media-content">
          <li class="nav-item"><a class="nav-link" href="http://direction.epfl.ch/presentation"><strong>Direction</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://library.epfl.ch"><strong>Biblioth&#xE8;que</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://emploi.epfl.ch/fr"><strong>Offres d&apos;emploi</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://international.epfl.ch/accueil"><strong>Relations internationales</strong></a></li>
        </ul>
      </section>
      <section class="g-span-1_3 media nav nav-vertical">
        <header><h2 class="media-header epfl-color2"><a href="http://futuretudiant.epfl.ch/fr">Formations</a></h2></header>
        <ul class="nav-list media-content">
          <li class="nav-item"><a class="nav-link" href="http://cms.epfl.ch"><strong><abbr title="Cours de Math&#xE9;matiques Sp&#xE9;ciales">CMS</abbr> Cours Pr&#xE9;paratoire</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://bachelor.epfl.ch/etudes"><strong>Bachelor</strong></a>, <a class="nav-link" href="http://master.epfl.ch/fr"><strong>Master</strong></a>, <a class="nav-link" href="http://phd.epfl.ch/accueil"><strong>Ecole doctorale</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://www.formation-continue-unil-epfl.ch/"><strong>Formation continue</strong></a> (EPFL-UNIL)</li>
          <li class="nav-item"><a class="nav-link" href="http://moocs.epfl.ch/cede"><strong>MOOCs</strong></a></li>
        </ul>
      </section>
      <section class="g-span-1_3 media nav nav-vertical">
        <header><h2 class="media-header epfl-color2"><a href="http://research.epfl.ch/accueil">Recherche</a></h2></header>
        <ul class="nav-list media-content">
          <li class="nav-item"><a class="nav-link" href="http://research-office.epfl.ch/fr"><strong>Research Office</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://commission-recherche.epfl.ch/fr"><strong>Commission de la recherche</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://research.epfl.ch/centres"><strong>Centres de recherche</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://infoscience.epfl.ch/?ln=fr"><strong>Publications </strong><abbr title="&#xC9;cole polytechnique f&#xE9;d&#xE9;rale de Lausanne"><strong>EPFL</strong></abbr></a></li>
        </ul>
      </section>
      <section class="g-span-1_3 media clear nav nav-vertical">
        <header><h2 class="media-header epfl-color2"><a href="http://vpi.epfl.ch/fr">Innovation &amp; Valorisation</a></h2></header>
        <ul class="nav-list media-content">
          <li class="nav-item"><a class="nav-link" href="http://vpi.epfl.ch/partenariats"><strong>Partenariats</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://vpi.epfl.ch/innogrant"><strong>Soutien aux start-ups</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://www.alliance-tt.ch"><strong>Liaison industrielle</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://tto.epfl.ch/homepage"><strong>Transfert de technologies, brevets</strong></a></li>
        </ul>
      </section>
      <section class="g-span-1_3 media nav nav-vertical">
        <header><h2 class="media-header epfl-color2"><a href="http://information.epfl.ch/batiments">Campus EPFL</a></h2></header>
        <ul class="nav-list media-content">
          <li class="nav-item"><a class="nav-link" href="http://fribourg.epfl.ch/fr/home"><strong>Fribourg</strong></a>, <a class="nav-link" href="http://geneva.epfl.ch/page-121741-fr.html"><strong>Gen&#xE8;ve</strong></a>, <a class="nav-link" href="http://neuchatel.epfl.ch/page-121739-fr.html"><strong>Neuch&#xE2;tel</strong></a>, <a class="nav-link" href="http://valais.epfl.ch/Home"><strong>Valais</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://rolexlearningcenter.epfl.ch/presentation"><strong>Rolex Learning Center</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://www.stcc.ch/home/"><strong>SwissTech Convention Center</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="http://artlab.epfl.ch/accueil"><strong>ArtLab</strong></a></li>
        </ul>
      </section>
    </nav>
  </div></header>

  </div>
<div class="clear"></div>
<header class="headwrapper">
<div class="ult-wrapper wrapper" id="wrapper-53">

<div class="ult-container  container" id="container-53">
<div class="row">
		<div class="ult-column col-md-12" id="col-53-1">
			<div class="colwrapper"><div class="widget widget_ultimatumbcumb inner-container"><ul class="breadcrumb"><li><a href="http://epfl.bicube.ch/" title="View Home">Home</a></li></ul></div><div class="widget widget_text inner-container">			<div class="textwidget"><h1 class="site-title" itemprop="isPartOf" itemscope="" itemtype="http://schema.org/CollectionPage">
                    
                        <span itemprop="name">
                            <span class="adjustSize">ENVIRONMENTAL CHEMISTRY LABORATORY</span>
                            <abbr class="visuallyhidden-xs visuallyhidden-xxs" title="Facult&#xE9; de l&apos;environnement naturel, architectural et construit"> LCE </abbr></span>
                   

                        </h1>

</div>
		</div></div>
		</div>
		</div></div>
</div>
<div class="ult-wrapper wrapper" id="wrapper-55">

<div class="ult-container  container" id="container-55">
<div class="row">
		<div class="ult-column col-md-12" id="col-55-1">
			<div class="colwrapper"><div class="widget widget_ultimatummenu inner-container"><div class="ultimatum-menu-container" data-menureplacer="768"><div class="ultimatum-regular-menu"><script type="text/javascript">
	//<![CDATA[
	jQuery(document).ready(function($) {
				ddsmoothmenu.init({
			mainmenuid: "ultimatummenu-5-item",
			orientation: 'h',
			classname: 'ddsmoothmenuh',
			contentsource: "markup"
		})
	});
	//]]>
</script>
<style>.ddsmoothmenuh ul {float: left;}</style>
<div class="ultimatum-nav">
<div class="ddsmoothmenuh" id="ultimatummenu-5-item">
	<ul id="menu-niveau2" class="menu"><li id="menu-item-877" class="homelink menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-803 current_page_item menu-item-877"><a href="http://epfl.bicube.ch/"><span>LCE</span></a></li>
<li id="menu-item-827" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-827"><a href="http://epfl.bicube.ch/lce/people/">People</a></li>
<li id="menu-item-816" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-816"><a href="http://epfl.bicube.ch/lce/publications/">Publications</a></li>
<li id="menu-item-917" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-917" style="z-index: 100;"><a href="#">Research</a>
<ul class="sub-menu" style="display: none; top: 36px; visibility: visible;">
	<li id="menu-item-887" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-887"><a href="http://epfl.bicube.ch/research__trashed/virus-inactivation-and-resistance-mechanisms/">Virus inactivation and resistance mechanisms</a></li>
	<li id="menu-item-916" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-916"><a href="http://epfl.bicube.ch/research__trashed/linking-environmental-persistence-with-disinfection-resistance/">Linking environmental persistence with disinfection resistance</a></li>
	<li id="menu-item-915" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-915"><a href="http://epfl.bicube.ch/research__trashed/exploring-the-role-of-climate-in-the-evolution-of-waterborne-viruses/">Exploring the role of climate in the evolution of waterborne viruses</a></li>
	<li id="menu-item-914" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-914"><a href="http://epfl.bicube.ch/research__trashed/efficacy-of-wastewater-ozonation-for-virus-control/">Efficacy of (waste)water ozonation for virus control</a></li>
	<li id="menu-item-913" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-913"><a href="http://epfl.bicube.ch/research__trashed/virus-transfer-at-the-liquid-skin-interface/">Virus transfer at the liquid-skin interface</a></li>
	<li id="menu-item-912" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-912"><a href="http://epfl.bicube.ch/research__trashed/fate-of-pathogens-in-source-separated-urine/">Fate of pathogens in source-separated urine</a></li>
	<li id="menu-item-911" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-911"><a href="http://epfl.bicube.ch/research__trashed/norovirus-monitoring-for-direct-potable-reuse/">Norovirus monitoring for direct potable reuse</a></li>
	<li id="menu-item-910" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-910"><a href="http://epfl.bicube.ch/research__trashed/modeling-the-current-and-future-distribution-of-hepatitis-e-virus/">Modeling the current and future distribution of hepatitis E virus</a></li>
</ul>
</li>
<li id="menu-item-821" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-821"><a href="http://epfl.bicube.ch/lce/teaching/">Teaching</a></li>
<li id="menu-item-918" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-918" style="z-index: 99;"><a href="#">Open Positions</a>
<ul class="sub-menu" style="display: none; top: 36px; visibility: visible;">
	<li id="menu-item-834" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-834"><a href="http://epfl.bicube.ch/master-project/">Master project</a></li>
</ul>
</li>
<li id="menu-item-939" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-939"><a href="http://epfl.bicube.ch/page-de-tests/">Page de tests</a></li>
</ul></div>
</div>
</div><div class="ultimatum-responsive-menu" style="display: none;">
<a id="ultimatummenu-5-responsive" href="#ultimatummenu-5-resonsive-sidr" class="sidr-toggler"><i class="fa fa-bars"></i></a>

<div id="ultimatummenu-5-responsive-sidr" class="sidr left">
<ul id="ultimatummenu-5-resonsive" class="menu"><li class="homelink menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-803 current_page_item menu-item-877"><a href="http://epfl.bicube.ch/"><span>LCE</span></a></li>
<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-827"><a href="http://epfl.bicube.ch/lce/people/">People</a></li>
<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-816"><a href="http://epfl.bicube.ch/lce/publications/">Publications</a></li>
<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-917"><a href="#">Research</a>
<ul class="sub-menu">
	<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-887"><a href="http://epfl.bicube.ch/research__trashed/virus-inactivation-and-resistance-mechanisms/">Virus inactivation and resistance mechanisms</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-916"><a href="http://epfl.bicube.ch/research__trashed/linking-environmental-persistence-with-disinfection-resistance/">Linking environmental persistence with disinfection resistance</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-915"><a href="http://epfl.bicube.ch/research__trashed/exploring-the-role-of-climate-in-the-evolution-of-waterborne-viruses/">Exploring the role of climate in the evolution of waterborne viruses</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-914"><a href="http://epfl.bicube.ch/research__trashed/efficacy-of-wastewater-ozonation-for-virus-control/">Efficacy of (waste)water ozonation for virus control</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-913"><a href="http://epfl.bicube.ch/research__trashed/virus-transfer-at-the-liquid-skin-interface/">Virus transfer at the liquid-skin interface</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-912"><a href="http://epfl.bicube.ch/research__trashed/fate-of-pathogens-in-source-separated-urine/">Fate of pathogens in source-separated urine</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-911"><a href="http://epfl.bicube.ch/research__trashed/norovirus-monitoring-for-direct-potable-reuse/">Norovirus monitoring for direct potable reuse</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-910"><a href="http://epfl.bicube.ch/research__trashed/modeling-the-current-and-future-distribution-of-hepatitis-e-virus/">Modeling the current and future distribution of hepatitis E virus</a></li>
</ul>
</li>
<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-821"><a href="http://epfl.bicube.ch/lce/teaching/">Teaching</a></li>
<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-918"><a href="#">Open Positions</a>
<ul class="sub-menu">
	<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-834"><a href="http://epfl.bicube.ch/master-project/">Master project</a></li>
</ul>
</li>
<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-939"><a href="http://epfl.bicube.ch/page-de-tests/">Page de tests</a></li>
</ul></div>
</div>
<script type="text/javascript">
	//<![CDATA[
	jQuery(document).ready(function() {
		jQuery('#ultimatummenu-5-responsive').sidr({
		    name: "ultimatummenu-5-responsive-sidr",
		    		    side: "left" 
		    		  });

		});
	//]]>
</script>
</div></div><div class="clearfix"></div></div>
		</div>
		</div></div>
</div>
<div class="ult-wrapper wrapper" id="wrapper-56">

<div class="ult-container  container" id="container-56">
<div class="row">
		<div class="ult-column col-md-12" id="col-56-1">
			<div class="colwrapper"><div class="widget widget_text inner-container">			<div class="textwidget"><div id="tools" class="tools">
                <div role="toolbar" aria-label="Page tools">

                    <span class="secondary-content" data-role="label">Partager:</span>

                   <a class="share-link share-facebook" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fwww.themematcher.com%2Fget-html%3Fsite%3Dhttp%3A%2F%2Fepfl.bicube.ch%2F" target="_blank" title="Facebook"><span class="icon icon-share-facebook_button"></span><span class="visuallyhidden">Facebook</span></a><a class="share-link share-twitter" href="https://twitter.com/intent/tweet?url=http%3A%2F%2Fwww.themematcher.com%2Fget-html%3Fsite%3Dhttp%3A%2F%2Fepfl.bicube.ch%2F&amp;text=EPFL%20%7C%20Un%20prototype&amp;hashtags=epfl" target="_blank" title="Twitter"><span class="icon icon-share-twitter_button"></span><span class="visuallyhidden">Twitter</span></a><a class="share-link share-linkedin" href="https://www.linkedin.com/shareArticle?url=http%3A%2F%2Fwww.themematcher.com%2Fget-html%3Fsite%3Dhttp%3A%2F%2Fepfl.bicube.ch%2F&amp;title=EPFL%20%7C%20Un%20prototype%20%23epfl" target="_blank" title="LinkedIn"><span class="icon icon-share-linkedin_button"></span><span class="visuallyhidden">LinkedIn</span></a><a class="share-link share-googleplus" href="https://plus.google.com/share?url=http%3A%2F%2Fwww.themematcher.com%2Fget-html%3Fsite%3Dhttp%3A%2F%2Fepfl.bicube.ch%2F" target="_blank" title="Google+"><span class="icon icon-share-googleplus_button"></span><span class="visuallyhidden">Google+</span></a><a class="share-link share-mail" href="mailto:?subject=EPFL%20%7C%20Un%20prototype%20%23epfl&amp;body=http%3A%2F%2Fwww.themematcher.com%2Fget-html%3Fsite%3Dhttp%3A%2F%2Fepfl.bicube.ch%2F" target="_blank" title="Email"><span class="icon icon-share-mail_button"></span><span class="visuallyhidden">Email</span></a></div>

            </div></div>
		</div></div>
		</div>
		</div></div>
</div>
</header>
<script src="//static.epfl.ch/v0.22.15/scripts/epfl-jquery-built.js"></script><div class="bodywrapper" id="bodywrapper">
<div class="ult-wrapper wrapper tm-content-clicked" id="wrapper-57">
  <div id="wrapper-111" class="hfeed">
    <div id="container-111">
<?php $GLOBALS['type'] = 'insidesidebar-right'; ?>
