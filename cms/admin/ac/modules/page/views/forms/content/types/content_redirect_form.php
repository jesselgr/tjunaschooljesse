	<script>
		$(function() {
			$("#tabs").tabs();
		});
	</script>	
	<section class="contentMain odd">
		<?$pages = $this->db->order_by('title asc')->join('page_description d','page.page_id = d.page_id')->get('page')->result();?>
		<?$this->load->helper('list')?>
		<?=form_dropdown('title', select_list_items($pages, 'url_name', 'title'), $fields['title']);?>
	</section>

