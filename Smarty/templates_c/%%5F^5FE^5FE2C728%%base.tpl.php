<?php /* Smarty version 2.6.26, created on 2010-02-15 15:48:08
         compiled from javascript/base.tpl */ ?>


// It sometimes makes things easier being able to use CSS attributes for changing
// things depending on whether or not javascript support is enabled. At this
// point we allow just that by including a CSS file using JS code.
var jsOnlyCss = document.createElement("link");

jsOnlyCss.setAttribute("type", "text/css");
jsOnlyCss.setAttribute("rel", "stylesheet");
jsOnlyCss.setAttribute("href", "<?php echo $this->_tpl_vars['url_base']; ?>
ui/elements/javascript.css");

// This URL is used a the basis for internal links.
var baseUrl = "<?php echo $this->_tpl_vars['url_base']; ?>
";

<?php echo '

document.getElementsByTagName("head")[0].appendChild(jsOnlyCss);

// Global initialization
$(document).ready(function(){
    
    // Initializing the inline login form. Although it might seem to be out of
    // the scope of this funtion, in reality the form is present on every page
    // accessed until the user logs in, so place works well enough.
    
    $("#login_link").click(function(event){
	$("#login_form").show("fast");
         event.preventDefault();
	 document.getElementById(\'loginUsernameInput\').focus();
       });
    $("#loginform_x").click(function(event){
	$("#login_form").hide("fast");
         event.preventDefault();
       });
    
    // Hilighting table rows on mouseover
    $(".hilightrows tr").hover(
      function () {
        
        $(this).addClass(\'hilightedrow\');
      }, 
      function () {
        $(this).removeClass(\'hilightedrow\');
      }
    );
    
    $(".oddrows > tr:even").addClass(\'evenrow\');
    $(".oddrows > tr:odd").addClass(\'oddrow\');
    
    $(".oddrows > li:even").addClass(\'evenrow\');
    $(".oddrows > li:odd").addClass(\'oddrow\');
    
    $(".row_col_tracking td").mouseenter(row_col_enter);
    $(".row_col_tracking td").mouseleave(row_col_leave);
    
    $("#helplink").click(toggleHelp);
    
    defaultHelpFile = $("#helpfile").text();
	 
    ConnectHelpLinks();
    
    var inputs = $("#content input");
    try {
	for (var ind = 0; ind < inputs.length; ++ind) {
	    var input = inputs[ind];
	    if (input.type == "text") {
		input.focus();
		break;
	    }
	}
    } catch(e) {
	// could not focus, doesn\'t really matter
    }
    
});

function ConnectHelpLinks() {

    $(".helplink").click(ShowHelp);
}

function row_col_enter() {
    var col = getColumnOf(this);
    var row = getRowOf(this);
   
    $(".row_col_tracking tr:eq(" +  row +")").addClass("doubleHilight");
    $(".row_col_tracking tr").each(function(){
	$(this).find("td:eq(" +  col +")").addClass("doubleHilight");
    });
}

function row_col_leave() {
    var col = getColumnOf(this);
    var row = getRowOf(this);
   
    $(".row_col_tracking tr:eq(" +  row +")").removeClass("doubleHilight");
    $(".row_col_tracking tr").each(function(){
	$(this).find("td:eq(" +  col +")").removeClass("doubleHilight");
    });
}

function getColumnOf(td) {
    var tr = td.parentNode;
    var typeind = 0;
    for (var ind = 0; ind < tr.childNodes.length; ++ind) {
	if (tr.childNodes[ind].tagName && tr.childNodes[ind].tagName.match(/^td$/i)) typeind++;
	if (tr.childNodes[ind] == td) return typeind - 1;
    }
    return -1;
    
}

function getRowOf(td) {
    var tr = td.parentNode;
    var typeind = 0;
    var container = tr.parentNode;
    for (var ind = 0; ind < container.childNodes.length; ++ind) {
	if (container.childNodes[ind].tagName && container.childNodes[ind].tagName.match(/^tr$/i)) typeind++;
	if (container.childNodes[ind] == tr) return typeind - 1;
    }
    return -1;
    
}
    // This function is used merely for debugging. Typical usage is
    // alert(dumpObj(someObject))
    
       function dumpObj(obj, name, indent, depth) {
	var MAX_DUMP_DEPTH = 10;
              if (depth > MAX_DUMP_DEPTH) {

                     return indent + name + ": <Maximum Depth Reached>\\n";

              }

              if (typeof obj == "object") {

                     var child = null;

                     var output = indent + name + "\\n";

                     indent += "\\t";

                     for (var item in obj)

                     {

                           try {

                                  child = obj[item];

                           } catch (e) {

                                  child = "<Unable to Evaluate>";

                           }

                           if (typeof child == "object") {

                                  output += dumpObj(child, item, indent, depth + 1);

                           } else {

                                  output += indent + item + ": " + child + "\\n";

                           }

                     }

                     return output;

              } else {

                     return obj;

              }

       }
       

// This function returns the table cell specified by a row object and the
// column index.
// @param row 	TR-object 	row from which the cell is to be retreived
// @param colIn integer		0-based index of the column
// @return TD-object		The function returns the matching TD object.
function getTableCell(row, colInd) {
    return $(row).children("td").get(colInd);
}

// This function returns the text of the selected option in a <SELECT> element.
// @param select SELECT-object	The element to test
// @return string		The text of the selected option
function GetSelectText(select) {
    var value = select.value;
    return GetSelectOptionText(select, value);
}

// This function returns the text of the specified option in a <SELECT> element.
// @param select SELECT-object	The element to test
// @param string Value of the option
// @return string		The text of the selected option
function GetSelectOptionText(select, value) {    
    var e = $(select).find("option[value=\'" + value + "\']");
    return e.text();
}


// This function returns GET parameter by the given name.
// @param name	Name of the parameter
// @return value of the parameter, or an empty string if there is none
function gup( name )
{
  name = name.replace(/[\\[]/,"\\\\\\[").replace(/[\\]]/,"\\\\\\]");
  var regexS = "[\\\\?&]"+name+"=([^&#]*)";
  var regex = new RegExp( regexS );
  var results = regex.exec( window.location.href );
  if( results == null ) {
    return "";
  }
  else {
    return results[1];
  }
}

var currentHelpFile = null;
function toggleHelp() {
    $("#helpcontainer").toggle();
    $("#adbannercontainer").toggle();
    
    if (currentHelpFile) {
	currentHelpFile = null;
    } else {
	ShowHelp(defaultHelpFile);
    }
    
    return false;
}

function ShowHelp() {
     var c;
     
     if (this.firstChild) c = this.firstChild;
     else c = $("#helplink").get(0).firstChild;
     
     
    var helpfile = c.textContent || c.innerText;
    
    
    jQuery.get('; ?>
"<?php echo $this->_tpl_vars['url_base']; ?>
help/" <?php echo ', {showhelp: helpfile, inline: 1},
		   DisplayHelp, \'xml\'
		   );
    
    
    return false;
}




function DisplayHelp(data) {
    
    $("#helpcontainer").empty();
    $("#helpcontainer").get(0).appendChild(elementsFromXml(data.lastChild));
    ConnectHelpLinks();
}

function elementsFromXml(xmlnode) {
    if (xmlnode.nodeType == 3) {
	return document.createTextNode(xmlnode.textContent);
    }
    
    var mynode = document.createElement(xmlnode.tagName);
    
    if (xmlnode.attributes) {
	for (var i = 0; i < xmlnode.attributes.length; ++i) {
	    var a = xmlnode.attributes[i];
	    if (a.name == \'style\' && a.value ==\'display: none\') {
		mynode.style.display = \'none\';
		continue;
	    } else if (a.name == \'class\') {
		mynode.className = a.value;
		continue;
	    }
	    try {
		mynode[a.name] = a.value;
	    } catch (e) {
		//alert(a.name);
	    }
	}
    }
    
    var child = xmlnode.firstChild;
    while (child != undefined) {
    
	var subnode = elementsFromXml(child);
	child = child.nextSibling;
	
	if (!subnode) continue;
	mynode.appendChild(subnode);
	
	
    }
    
    return mynode;
}

'; ?>


// Including some other files implementing parts of the functionality

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'javascript/tablesort.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'javascript/tablesearch.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'javascript/formvalidation.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'javascript/quicksort.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>