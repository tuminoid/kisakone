{**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 *
 * Client-side search from HTML tables
 * 
 * --
 *
 * This file is part of Kisakone.
 * Kisakone is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Kisakone is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with Kisakone.  If not, see <http://www.gnu.org/licenses/>.
 * *}
 {*
This file implements dynamic searchable HTML tables.

The functionality is initialized with code such as the following:
$(document).ready(function(){
    TableSearch(document.getElementById('searchField'), document.getElementById('theTable'),
                {/literal}"{translate id=No_Search_Results}"{literal}
                );       
    
});
*}
{literal}

/** This function initializes the table search functionality
 * @param searchField   The INPUT element, which is used for entering the search
 *                      keywords.
 * @param table         The TABLE object which is to be made
 * @param emptyListMessage  The message that is to be shown, if there are no search results
 */
function TableSearch(searchField, table, emptyListMessage) {
     // If the search has been done manually (as opposed to being dynamic), the dynamic
     // search can not show items that have already been filtered out. In that case the
     // dynamic search is disables.
     
     var initialSearch = gup(searchField.name);     
     if (initialSearch != "") {
        
        // No dynamic search; let the user know why.
	var message = {/literal}"{translate id='Restore_AutoSearch'}"{literal};
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
         
         // Either show or hide the row depending on if it's a match or not
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
 

{/literal}