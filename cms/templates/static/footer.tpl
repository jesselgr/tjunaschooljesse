			</div><!-- /content -->
		</div><!-- / wrapper -->
		<footer>
			<ul class="clearfix">
				{foreach $footer_nav as $nav_item}
					<li><a href="{$nav_item.url_name|site_url}">{$nav_item.title}</a></li>
				{/foreach}
			</ul>
		</footer>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="{base_url()}assets/js/vendor/jquery-1.9.0.min.js"><\/script>')</script>
        <script src="{base_url()}assets/js/plugins.js"></script>
        <script src="{base_url()}assets/js/main.js"></script>
        <script type="text/javascript" src="{base_url()}assets/js/loginbox.js"></script>
        {if $minified.jsUrl}<script src="{base_url()}{$minified.jsUrl}"></script>{/if}        
    </body>
</html>
