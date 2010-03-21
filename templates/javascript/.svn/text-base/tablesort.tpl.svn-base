{**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 *
 * Client-size HTML table sorting
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
This file implements dynamic sortable HTML tables.

The file is used primarily through the custom template function sortheading, and
no other initialization is needed.

*}

{literal}


// This function is called to initialize a sortable table. The table itself does
// not need to be defined; it is the one with elements or SortHeading class.
function SortableTable() {
    var headings = $(".SortHeading");
    var table = $(headings.closest("table").get(0));
    
    headings.click(function(event){ SortTable(table, sortFields[$(this).text()]);
		   event.preventDefault();
		   });
}



// Index of the last sortable heading that was added. Not necessarily column
// (when not all of them are searchable), but often the two match.
var lastHandledHeading = -1;

// List of sortable fields. The text of the heading is the key, values are objects
// with the following fields:
// - column:    column this is applied for
// - by:        callback function for sorting
var sortFields = new Array();

// List of current sorting. The first item is used primarily, 2nd used as tie
// breaker for that, 3rd for that and so on.
// Each item is an object with the following fields:
// - column     column this is applied for
// - by         callback function for sorting
// - ascending  if true, sort is ascending, otherwise descending
var sortedBy = new Array();

// Initializes a sortable column to a table
// @param column    0-based index of the column
// @param by        Callback function used for comparison in this column
function SortField(column, by) {
    var headings = $(".SortHeading");
    var heading = headings.get(++lastHandledHeading);
    
    var entry = new Object();
    entry.column = column;
    entry.by = by;
    sortFields[$(heading).text()] = entry;
    
}

// Sorts the table immediately based primarily on provided criteria
// @param table table being sorted
// @param data sortField entry for the sorting
function SortTable(table, data) {
    
	var entry = new Object();
	entry.column = data.column;
	entry.by = data.by;
	
        // Initializing? if so, only store the data and don't sort
	if (sortedBy.length == 0) {
		entry.ascending = true;
		sortedBy.push(entry);
		return;
	}
	
        // The order is reverse if the list is already being sorted by the same column	
	entry.ascending = sortedBy[0].by != entry.by || sortedBy[0].column != entry.column;
	
        // Ascending, simply add the sort entry
	if (entry.ascending) {
            sortedBy.unshift(entry);
            if (sortedBy.length > 4) sortedBy.pop();
	} else {
            // (probably) descending, alter the first entry
            if (!sortedBy[0].ascending) entry.ascending = true;
            sortedBy[0] = entry;
        }
	
        // And sort the table
	SortNow();
	
	SortDoneCallback();
	
	
}

function SortDoneCallback() {}

// Sorts the table based on pre-entered criteria
function SortNow() {
	var headings = $(".SortHeading");
	var table = headings.closest("table");
        
        // Find all rows with no heading cells
	var rows = table.find("tr").filter(function() { return $(this).find("th").length == 0 });
	var parent = rows.parent();
	
	// Remove the rwos from the table for now
	rows.remove();
        
        // Sort them
	var rarray = rows.get();        
	quick_sort(rarray, SortCompare);
	

        // And add them back to the table, in right order
	for (var i = 0; i < rarray.length; ++i) {		
            table.get(0).appendChild(rarray[i]);
	}

}

// This function performs comparison of two rows, based on pre-defined criteria.
// a: first row to compare
// b: second row to compare
// If a should be before, negative integer is returned, in opposite case positive integer,
// in case of tie, 0.
function SortCompare(a, b) {    
	//for (var i in sortedBy)  {
    for (var i = 0; i < sortedBy.length; ++i) {
		var e = sortedBy[i];
                
                // Get the cells for this sort criteria
		var ca = getTableCell(a, e.column);
		var cb = getTableCell(b, e.column);

                // Get the result for this particular test
		var r = e.by(ca, cb);
	
                // Does it make a difference?
		if (r != 0) {
                    // Reverse the outcome if we're using descending sorting
                    if (!e.ascending) r *= -1;
                    return r;
		}			
	}
	return 0;
}


// Callback for sorting rows in an alphabetical fashion
function alphabeticalSort(a, b) {
    var at = $(a).text();
    var bt = $(b).text();
    
    if (at < bt) return -1;
    if (at > bt) return 1;
    return 0;
}

// Callback for sorting rows as integers
function integerSort(a, b) {    
    var ai = parseInt($(a).text());
    var bi = parseInt($(b).text());
	
	//alert((a).text());
	
    if (ai < bi) return -1;
    if (ai > bi) return 1;
    return 0;
}

function checkboxcheckedSort(a, b) {
	var cb1 = $(a).find("input[type='checkbox']").get(0);
	var cb2 = $(b).find("input[type='checkbox']").get(0);
	
	//alert($(a).find("input[type='checkbox']").length);
	
	if (!cb1 && !cb2) return 0;
	if (!cb1) return 1;
	if (!cb2) return -1;
	
	if (cb1.checked == cb2.checked) return 0;
	if (cb1.checked) return -1;
	else return 1;
}


function dateSort(a,b) {
    var bi = parseInt( $(a).find("input").get(0).value);
    var ai = parseInt($(b).find("input").get(0).value);
   	
    if (ai < bi) return -1;
    if (ai > bi) return 1;
    return 0;
}
var test = 5;

function selectTextSort(a,b) {
    var text1 = GetSelectText($(a).find("select").get(0));
    var text2 = GetSelectText($(b).find("select").get(0));
    
   if (text1 < text2) return -1;
   if (text2 < text1) return 1;
   return 0;
}
{/literal}