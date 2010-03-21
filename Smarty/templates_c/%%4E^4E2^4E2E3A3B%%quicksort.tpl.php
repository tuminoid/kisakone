<?php /* Smarty version 2.6.26, created on 2010-02-15 15:48:08
         compiled from javascript/quicksort.tpl */ ?>

<?php echo '
/*
Modifications Copyright 2009-2010 Kisakone projektiryhmä
Original copyright holders unknown
Obtained from http://en.literateprograms.org/Quicksort_(JavaScript)

Permission is hereby granted, free of charge, to any person
 obtaining a copy of this software and associated documentation
 files (the "Software"), to deal in the Software without
 restriction, including without limitation the rights to use,
 copy, modify, merge, publish, distribute, sublicense, and/or sell
 copies of the Software, and to permit persons to whom the
 Software is furnished to do so, subject to the following
 conditions:

 The above copyright notice and this permission notice shall be
 included in all copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 OTHER DEALINGS IN THE SOFTWARE.
 */

// Quicksort partition function. Internal to this module, understanding
// should be trivial however if the quicksort algorithm itself is understood.
function partition(array, begin, end, pivot, comparer)
{
	var piv=array[pivot];
	array.swap(pivot, end-1);
	var store=begin;
	var ix;
	for(ix=begin; ix<end-1; ++ix) {
		if(comparer(array[ix], piv) <= 0) {
			array.swap(store, ix);
			++store;
		}
	}
	array.swap(end-1, store);

	return store;
}

// This function extends the javascript array object by including swap operation.
// The function swaps the places of 2 items in the array.
// Paramters:
// a: index of one of the items to swap
// b: index of the other item
Array.prototype.swap=function(a, b)
{
	var tmp=this[a];
	this[a]=this[b];
	this[b]=tmp;
}

// This function implements the basic quicksort algorithm. Users will want to
// use the quick_sort function instead, as this is internal to this module,
function qsort(array, begin, end, comparer)
{
	if(end-1>begin) {
		var pivot=begin+Math.floor(Math.random()*(end-begin));

		pivot=partition(array, begin, end, pivot, comparer);

		qsort(array, begin, pivot, comparer);
		qsort(array, pivot+1, end, comparer);
	}
}

// Sorts an array using quicksort algorithm, utilizing a callback for comparing
// items.
//
// Pivot is randomized, so there is no obvious case where the function
// performs badly.
//
// Prrameters:
// array: the array to sort
// callback: function used for comparing items. The function is provided two
//   parameters, A and B. If A should be before B, a negative integer must be returned.
//   If the opposite is true, a positive integer must be returned. If there is no
//   clear order between the two, 0 must be returned.

function quick_sort(array, comparer)
{
	qsort(array, 0, array.length, comparer);
}


'; ?>