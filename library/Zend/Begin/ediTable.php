<?php
	
 $array['0'] =  'Citado'; 
 $array['1'] =  'Notificar'; 
 $array['2'] =  'Apresentante'; 

?>

<script>
$('.editableLang_con').editable('update.php', {                    // processing code in update.php see below
	data       : <?php
          $list_lang = str_replace("}","",json_encode($array)); // $tab_lang = array, list of languages
          print $list_lang.$selectLANG; ?>,
  id         : 'cellid',
  name       : 'cellvalue',
  event      : 'dblclick',
  tooltip     : 'Double click to edit...',
  placeholder  : '<b style="color:#AAA">Edit</b>',
  submitdata   : function(value, setting) {
    var array_val = new Array();
    array_val['id'] = "<?php echo $id_contact; ?>";
    var values = $(this).find('select').val();
    array_val['cellvalue'] = values.join();
    return array_val;
  },
  type       : 'selectmulti',
  style    : 'display: inline',
  submit     : 'Save',
  onblur     : 'ignore',
  cancel     : 'Cancel'
});  

</script>