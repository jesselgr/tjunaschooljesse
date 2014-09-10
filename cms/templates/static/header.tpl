<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
		<head>
				<meta charset="utf-8">
				<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
				<title>{$title} - {$site.sitetitle}</title>
				<meta name="description" content="{$meta.description}">
				<meta name="viewport" content="width=device-width">
				<META name="Content-Language" Content="{$translation.code}">
				<meta name="author" content="Tjuna. Awesome Webs & Apps" />
					
					<!--
					
					Hi there human code crawler!
					
					This site is made by Tjuna. We produce awesome Webs & Apps.
					Looking for a job? Please send a mail to codingfishes@tjuna.com or visit our website http://www.tjuna.com
			
								ooooooooooooooo/   .ooo                                                                    
								++++++yyys+++++:   .+++                                                                    
											 yyy/                                                                         
											 yyy/       ://///    .///       ///.    :///////:-.`       -/////:-.           
											 yyy/      -ossyyy    -yyy       yyy-    syysssssyyys:     `osssssyys+.          
											 yyy/       ``:yyy    -yyy       yyy-    syy/`````:yyy:     ``````.+yys`              
											 yyy/         -yyy    -yyy       yyy-    syy/      +yyo      `.-::::yyy:              
											 yyy/         -yyy    -yyy       yyy-    syy/      /yys    .+syyssssyyy/              
											 yyy/         -yyy    -yyy`      yyy-    syy/      /yys   `syy/.````syy/              
											 yyy/         -yyy    `yyy:      yyy-    syy/      /yys   -yyy`     syy/              
											 yyy/         -yyy     :yyy+::---yyy-    syy/      /yys   `syyo:----syy/              
											 sss:         /yys      ./osssssssss-    oss:      :sso    `:osssssssss:              
																	 -yyy-         `````````     ````      ````        `````````              
																 `/yyo.                                                                     
															 `./ss/.                                    Awesome Webs & Apps.                               
															:+:.                                                                    
																																																							
					-->
					
				<meta property="og:title" content="{$title}"/>
				<meta property="og:image" content="{$meta.thumb}"/>
				<meta property="og:site_name" content="{$site.sitetitle}"/>
				<meta property="og:description" content="{$meta.description}"/>

		<link href='http://fonts.googleapis.com/css?family=Unica+One' rel='stylesheet' type='text/css'>
				<link rel="stylesheet" href="{base_url()}assets/css/normalize.css">
				<link rel="stylesheet" href="{base_url()}assets/css/main.css">
				<link rel="stylesheet" href="{base_url()}assets/css/style.css">
				{if $minified.cssUrl}<link rel="stylesheet" href="{base_url()}{$minified.cssUrl}">{/if}


				<script>var base_url = '{base_url()}';</script>
				<script src="{base_url()}assets/js/vendor/modernizr-2.6.2.min.js"></script>
		</head>
		<body>
			<div class="headerWrapper">
				<header>
				
						<h1 class="ir logo">{$site.sitetitle}</h1>
						<nav>
							{$page_nav.html}
						</nav>
						<div class="languageSelectBox">
							<p class="currentLang">Language</p>
								<ul>
							{foreach $translation.list as $language key=i}
								<li><a href="{base_url()}{if $language->code != $translation.default_code}{$language->code}{/if}">{$language->name}</a></li>
							{/foreach}
							</ul>
						</div>
				</header>
			</div>
			<div class="wrapper">
				
				<div class="content" role="main">