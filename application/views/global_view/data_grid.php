<?php
$table_template = array (
    'table_open'          => '<table border="1" cellpadding="4" cellspacing="0" id="'.$table_name.'">',

    'heading_row_start'   => '<tr>',
    'heading_row_end'     => '</tr>',
    'heading_cell_start'  => '<th>',
    'heading_cell_end'    => '</th>',

    'row_start'           => '<tr>',
    'row_end'             => '</tr>',
    'cell_start'          => '<td><div class="editable_table_cell">',
    'cell_end'            => '</div></td>',

    'row_alt_start'       => '<tr>',
    'row_alt_end'         => '</tr>',
    'cell_alt_start'      => '<td><div class="editable_table_cell">',
    'cell_alt_end'        => '</div></td>',

    'table_close'         => '</table>'
);


$this->table->set_template($table_template);
$this->table->set_heading($data_table_heading);
echo $this->table->generate($data_table);
?>



<script language="JavaScript" src="<?= base_url()?>assets/js/jquery/jquery.jeditable.js"></script>
<script type="text/javascript" language="JavaScript">
    var table_name = "<?= $table_name ?>";

    function initEditableTableCell(){
        var arr = [];
        jQuery("#"+ table_name +" th").each(function(){
            arr.push(jQuery(this).html());
        });

        var r, c = 0, node = null;
        var f = function(i){
            if( (i + arr.length) % arr.length == 0){
                r = (jQuery(this).find("div[class='editable_table_cell']").html());
                c = 0;
            }
            var id = table_name+"-"+r+"-"+arr[c++];
            node = jQuery(this).find("div[class='editable_table_cell']");
            jQuery(node).attr("id",id);
            setEditableTableCell(node);          
        };
        jQuery("#"+ table_name +" td").each(f);
    }

    function setEditableTableCell(node){
        jQuery(node).editable("<?php echo site_url($edit_in_place_uri); ?>", {
            type      : 'textarea',
            cancel    : 'Cancel',
            submit    : 'Save',
            indicator : "<span style='color:red;font-weight:bold;'>Saving...</span>",
            tooltip   : 'Click to edit',
            id   : 'editable_field_name',
            name : 'editable_field_value'
        });
    }

    jQuery(document).ready(function() {
        initEditableTableCell();
    });

</script>