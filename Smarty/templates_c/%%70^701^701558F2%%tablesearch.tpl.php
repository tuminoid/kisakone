<?php /* Smarty version 2.6.26, created on 2010-02-15 15:48:08
         compiled from javascript/tablesearch.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'javascript/tablesearch.tpl', 51, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%70^701^701558F2%%tablesearch.tpl.inc'] = '0187971e7d3d7c7c4bb07e9bad949eb2'; ?> <?php echo '

/** This function initializes the table search functionality
 * @param searchField   The INPUT element, which is used for entering the search
 *                      keywords.
 * @param table         The TABLE object which is to be made sortable
 * @param emptyListMessage  The message that is to be shown, if there are no search results
 */
function TableSearch(searchField, table, emptyListMessage) {
     // If the search has been done manually (as opposed to being dynamic), the dynamic
     // search can not show items that have already been filtered out. In that case the
     // dynamic search is disables.
     
     var initialSearch = gup(searchField.name);     
     if (initialSearch != "") {
        
        // No dynamic search; let the user know why.
	var message = '; ?>
"<?php if ($this->caching && !$this->_cache_including): echo '{nocache:0187971e7d3d7c7c4bb07e9bad949eb2#0}'; endif;echo translate_smarty(array('id' => 'Restore_AutoSearch'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:0187971e7d3d7c7c4bb07e9bad949eb2#0}'; endif;?>
"<?php echo ';
	var form = $(searchField.form);
	var statusDiv = form.find(".SearchStatus");
	if (statusDiv.length == 0) {
            statusDiv = form.next(".SearchStatus");
	}
	 
	statusDiv.text(message);
     } else {
        // The search is to be used.
          
        // Apply event handlers to refresh the list whenever the contents of the
        // search field change.
	$(searchField).keyup(function(){DoTableSearch(searchField, table, emptyListMessage)});
	$(searchField).change(function(){DoTableSearch(searchField, table, emptyListMessage)});
    }
}

 // If set to true, at least one row is shown, otherwise none.    
 var anyRowsShown = false;
 
/**
 * Performs the actual dynamic search of the table.
 * @param field The input element used for searching
 * @param table The table being searched
 * @param message   Message to show if there are no search results
 */
 function DoTableSearch(field, table, message) {
     // Separate all the words within the search query
     var searchWords = field.value.split(" ");
     
     // Assume none are shown; fix later if necessary
     anyRowsShown = false;
          
     $(table).find("tr").each(function(row){
        // Ignore heading row(s)
	 if ($(this).find("th").length != 0) return;
         
         // Either show or hide the row depending on if it\'s a match or not
	 if (searchMatch(this, searchWords))
	 {
	     $(this).show(); }
	 else $(this).hide();
	 });
     
     // If any where shown, clear the message
     if (anyRowsShown) {
	 message = "";
     }
     
     // Show the message, if any
     $(table).next(".SearchStatus").text(message);
 }
 
 // See if the given row matches the provided search query
 // @param row   TR object of the row
 // @param words  Array of search queries
 function searchMatch(row, words) {
     var text = $(row).text();
	 
     
     // Make sure all words in the search query are found
	 
     for (var ind = 0; ind < words.length; ++ind) {
		  var word = words[ind];
		  
		  if (!text.match(new RegExp(word, "i"))) return false;
     }
     
     // All were found
     anyRowsShown = true;
     return true;
 }
 

'; ?>