
<script src="<?=base_url()?>assets/js/libs/ui_multiselect/js/ui.multiselect.js"></script>
<script src="<?=base_url()?>assets/js/call_multiselect.js"></script>

<?=form_multiselect($key.'[]', $list,$values, 'class = multiselect')?>