
	<script>
		$(function() {
			$("#tabs").tabs();
		});
	</script>	
	<div class="contentMain odd">
		<div id="tabs" class="ambLangTab">
			<ul>
				<?foreach($languages as $language):?>
					<li>
						<a class="ambLangTab" href="#tabs-<?=($language->language_id)?>" title="<?=$language->name?>">
							<span class="flag flag-<?=$language->code?>">&nbsp;</span>
						</a>
					</li> 
				<?endforeach;?>
			</ul>
			
			
			<?foreach($languages as $language_row):?>
				<?$lang_id = $language_row -> language_id;?>
				
				<div id="tabs-<?=($lang_id)?>">					
					<div class="inputContainer">
						<?= form_label('Titel:', 'title')?>
						<p><?=form_input('title['.$lang_id.']', $fields[$lang_id]['title'], 'class= "inputField"')?></p>
					</div>
					
					<div class="inputContainer">
					    <label for="YouTubePickerQuery">Youtube zoeken: </label>
					    <input class="YouTubePickerQuery inputField" type="text" />
					     <input class="YouTubePickerSearch buttonContent small" type="button" value="Search" />
					</div>
					
					<div class="YouTubePickerHolder odd clearfix">
					    <div class="YouTubePickerVideoPlayer"></div>
					    <a class="navigation prev">Previous page</a> -- <a class="navigation next">Next page</a>
					    <ul class="YouTubePickerVideoList"></ul>
					</div>
					
					<div class="inputContainer odd">
						<p><?=form_label(lang('editor_vid_form_content'), 'content');?></p>
						<p><?=form_input('sub_title['.$lang_id.']', $fields[$lang_id]['sub_title'], 'class ="inputField YouTubePickerSelectedUrl" id="urlField"')?></p>
						<?=form_input('content['.$lang_id.']', $fields[$lang_id]['content'], 'class="YouTubePickerIdUrl visuallyhidden"');?>
					</div>
				</div>
			
			<?endforeach;?>
		
		</div>
	
	</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".YouTubePickerHolder").YouTubePicker({
            ControlIdSuffix: '',

            ControlQueryHolder: '.YouTubePickerQuery',
            ControlSearchButton: '.YouTubePickerSearch',
            ControlVideoPlayerHolder: '.YouTubePickerVideoPlayer',
            ControlSelectedUrlHolder: '.YouTubePickerSelectedUrl',
            ControlVideoList: '.YouTubePickerVideoList',

            Thumbnail: 'small',
            MaxResults: 5,
            AutoPlay: false,
            InitVideoUrl: $('.YouTubePickerSelectedUrl').attr('value'),
            ShowRelated: false
        });
    });
</script>
