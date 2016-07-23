(function () {
    var methods = {
        /**
         * Change checkboxes id after element was cloned (on 'Add Row')
         */
        changeCheckboxId: function ($table)
        {
            var uniqueID = Math.floor(Math.random() * 99999);

            $table.find('.tfbtq_first_body td[data-type=checkbox]').each(function(){
                var td = jQuery(this);
                var id = td.attr('data-id');

                td.find('[id^="' + id + '"],label[for^="' + id + '"]').each(function(){
                    var $this = jQuery(this);

                    if ($this.attr('for'))
                        $this.attr('for', id + '_' + (uniqueID));
                    else
                        $this.attr('id', id + '_' + uniqueID);
                });
                uniqueID = Math.floor(Math.random() * 99999);
            });
        },
        /**
         * Update on changes
         */
        update: function (event) {
            var  $table = event.data.$table;
            var tableId = $table.attr('id');

            if (methods.updateTimeouts[tableId] == undefined) {
                methods.updateTimeouts[tableId] = null;
            } else {
                clearTimeout(methods.updateTimeouts[tableId]);
            }

            // Set update function to fire on timeout in cases when it will be called very often
            methods.updateTimeouts[tableId] = setTimeout((function($table){
                return function(){
                    // Update input hidden
                    $table.parent().find('input[name="' + $table.attr('id') + '"]').val(JSON.stringify($table.find('.tfbtq_first_body input, .tfbtq_first_body textarea, .tfbtq_first_body select').serializeObject()));

                    { // Show/Hide checkboxes/buttons ...

                        var hasCheckboxes   = (jQuery('.tfbtq_first_body .tfbtq_checkbox_column:first', $table).length > 0);
                        var checkedCount    = jQuery('.tfbtq_first_body .tfbtq_checkbox_column:checked', $table).length;
                        var notChecked      = jQuery('.tfbtq_first_body .tfbtq_checkbox_column:not(:checked):first', $table).length;

                        var $selectAllCheckbox  = jQuery('.tfbtq_checkbox_column_all', $table);

                        // Show/Hide delte button
                        jQuery('.tfbtq_shopping_delete_rows', $table)[ checkedCount ? 'show' : 'hide' ]();

                        // Append 's' to delete button if there are more than one checked rows
                        jQuery('.tfbtq_shopping_delete_rows span', $table).text( checkedCount > 1 ? 's' : '' );

                        // Remove/Add checked to 'Check All' checkbox
                        if (!checkedCount) { // if no one checked or table is empty
                            $selectAllCheckbox.removeAttr('checked');
                        } else if (notChecked) { // has at least one not checked
                            $selectAllCheckbox.removeAttr('checked');
                        } else { // all is checked
                            $selectAllCheckbox.attr('checked', 'checked');
                        }
                        // Show 'Select all' checkbox, only if there some checkboxes
                        if (hasCheckboxes) {
                            $selectAllCheckbox.show().closest('td').removeAttr('style');
                        } else {
                            $selectAllCheckbox.hide().closest('td').css('padding', '0');
                        }
                    }
                };
            })($table), 100);
        },
        /**
         * Timeout for update (prevent update input hidden too many times, if many changes in table at the same time)
         */
        updateTimeouts: {},
        /**
         * Check all checkboxes
         */
        checkAllRows:function (event) {
           var $table = event.data.$table;
            if (jQuery(this).is(':checked'))
                $table.find('.tfbtq_first_body .tfbtq_checkbox_column').attr('checked', 'checked');
            else
                $table.find('.tfbtq_first_body .tfbtq_checkbox_column').removeAttr('checked');
        },
        /**
         * Prepend checkbox to every <tr>
         */
        addCheckboxToRow:function ($table) {
            $table.find('tr').not(".tfuse-not-tr").each(function () {
                var tr = jQuery(this);
                if (tr.parent().is('thead') || tr.parent().is('tfoot'))
                    tr.prepend('<td class="tf-table-checkox-control"><input class="tfbtq_checkbox_column_all" type="checkbox"/></td>');
                else
                    tr.prepend('<td class="tf-table-checkox-control"><input class="tfbtq_checkbox_column" type="checkbox"/></td>');
            });
        },
        /**
         * Delete checked rows
         */
        deleteRows:function (event) {
            var $table      = event.data.$table;
            var checkboxes  = $table.find('.tfbtq_first_body .tfbtq_checkbox_column');
            
            jQuery.each(checkboxes, function () {
                if (jQuery(this).is(':checked'))
                    jQuery(this).parents('tr').remove();
            });

            $table.find('.tfbtq_checkbox_column_all').removeAttr('checked');

            methods.update({data: {$table: $table}});

            return false;
        },
        /**
         * Add buttons to the end of the table
         */
        addButtons:function ($table) {
            var thLength = $table.find('thead tr').children().size();
            $table.find('.tfbtq_last_body').append('<tr class="tf-opt-table-add-row"><td colspan=' + thLength + '><span class="padd"><a class="add button tfbtq_shopping_add_row" href="#">Add Row</a></span><span class="padd"><a class="add button tfbtq_shopping_delete_rows" href="#">Delete Row<span></span></a></span></td></tr>');
        },
        /**
         * Add "Add" input text in selects
         */
        addInput:function (callback, id) {
            var id = '#' + id + '_chzn';

            jQuery(id).find('.chzn-drop').prepend(
                '<div class="tf_selectsearch_create_options_wrapper">' +
                    '<div class="tf_selectsearch_create_options_content">' +
                    '<input   type="text"/><a class="add button tfuse_selectsearch_create_option_action">Add</a>' +
                    '<div style="clear: both"></div> ' +
                    '</div>' +
                    '</div>'
            );

            jQuery('.tfuse_selectsearch_create_option_action').data('record', {'callback':callback, 'id':'#' + id});
        },
        /**
         * Add new row in table
         */
        addRow: function (event) {
            var $table  = event.data.$table;
            var row     = $table.find('.tfbtq_last_body .tfbtq-default-value-row:first').clone().removeClass();
            var $selectsearch = row.find('.tfuse-select');

            $table.find('.tfbtq_first_body').append(row.show());

            if ($selectsearch.length > 0) {
                $selectsearch.removeClass('chzn-done').removeAttr('id').next('div').remove();
                $selectsearch.tfuse_chosen();
            }
            methods.changeCheckboxId($table);

            methods.update({data: {$table: $table}});

            return false;
        }
    };

    jQuery.fn.extend({
        tfuseMakeTable: function () {
            jQuery(this).each(function () {
                var $this   = jQuery(this);
                var id      = $this.attr('id');

                $this.parent().siblings('.desc').remove();

                methods.changeCheckboxId($this);
                methods.addCheckboxToRow($this);
                methods.addButtons($this);

                jQuery(document).on('click',    '#' + id + ' .tfbtq_shopping_delete_rows',  {$table: $this}, methods.deleteRows);
                jQuery(document).on('change',   '#' + id + ' .tfbtq_checkbox_column_all',   {$table: $this}, methods.checkAllRows);
                jQuery(document).on('change',   '#' + id + ' input, #' + id + ' textarea, #' + id + ' select', {$table: $this}, methods.update);
                jQuery(document).on('click',    '#' + id + ' .tfbtq_shopping_add_row',      {$table: $this}, methods.addRow);

                methods.update({data: {$table: $this}});
            });
        }
    });
})();

jQuery(document).ready(function () {

    jQuery('.tfuse-tip-twitter').poshytip({
        className:'tip-twitter',
        showTimeout:1,
        alignTo:'target',
        alignX:'center',
        alignY:'bottom',
        allowTipHover:false,
        fade:false,
        slide:false
    });

});
