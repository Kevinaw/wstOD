<html>
<head>
    <style type="text/css">
    <!--
        body,
        table {
            font-family: Verdana;
            font-size: 10pt;
            margin: 0px;
        }

        th {
            background-color: #dedede;
            border: #aaaaaa 1px solid;
            text-align: left;
            vertical-align: top;
            padding: 2px;
            padding-left: 10px;
            padding-right: 10px;
            white-space: nowrap;
        }

        .altRow {
            background-color: #eeeeee;
        }

        .highlightedRow {
            background-color: orange;
        }

        .error {
            background-color: #dddddd;
            color: red;
            border: 1px dotted #aaaaaa;
            padding: 2px;
            padding-left: 10px;
            margin-bottom: 5px;
            font-style: italic;
        }

        .nextBackLink,
        .ascDescIndicator {
            font-family: webdings;
            font-size: 12pt;
            text-decoration: none;
        }

        .actionButton {
            width: 65px;
        }

        .headerBar {
            background-color: orange;
            border-bottom: 3px solid #777777;
            text-align: right;
            font-size: 24pt;
            font-family: Arial;
            font-style: italic;
            height: 55px;
            padding-top: 5px;
            padding-right: 10px;
            margin-bottom: 20px;
        }

        .mainbody {
            margin-left: 10px;
            margin-right: 10px;
        }

        .copyright {
            text-align: right;
            font-size: 8pt;
        }

        .contextError,
        .requiredAsterisk,
        .searchHighlight {
            font-weight: bold;
            color: red;
        }

        fieldset {
            padding: 10px;
            padding-top: 0px;
        }

        legend {
            font-weight: bold;
        }
        
        #csvDownloadLayer {
            background-color: #d4d0c8;
            padding: 5px;
            border: 2px white outset;
            position: absolute;
            visibility: hidden;
        }
    // -->
    </style>

    <link rel="stylesheet" href="./style.css">

    <script language="javascript" type="text/javascript">
    <!--
        /**
        * Gets left coord of given element
        */
        function GetLeft(element)
        {
            var curNode = element;
            var left    = 0;
    
            do {
                left += curNode.offsetLeft;
                curNode = curNode.offsetParent;
    
            } while(curNode.tagName.toLowerCase() != 'body');
    
            return left;
        }
        
        
        /**
        * Gets top coord of given element
        */
        function GetTop(element)
        {
            var curNode = element;
            var top    = 0;
    
            do {
                top += curNode.offsetTop;
                curNode = curNode.offsetParent;
    
            } while(curNode.tagName.toLowerCase() != 'body');
    
            return top;
        }


        /**
        * Onload event handler
        */
        function onload_handler()
        {
            if (document.getElementById('csvDownloadLayer') && document.getElementById('actionCSV')) {
                positionCSVLayer();
                document.getElementById('csvDownloadLayer').style.visibility = 'hidden';
                
                document.onclick = function ()
                {
                    Fade(document.getElementById('csvDownloadLayer'), false);
                }
            }
        }
        
        
        /**
        * Creates the CSV download layer
        */
        function positionCSVLayer()
        {
            /**
            * Positions the CSV download layer
            */
            var csvDiv        = document.getElementById('csvDownloadLayer');
            csvDiv.style.left = GetLeft(document.getElementById('actionCSV')) + 'px';
            csvDiv.style.top  = GetTop(document.getElementById('actionCSV')) + 1 + document.getElementById('actionCSV').offsetHeight + 'px';
        }


        /**
        * Returns ids of rows which are highlighted
        */
        function getSelectedRows()
        {
            var checkboxes = document.getElementsByTagName('input');
            var selected   = new Array();

            for (var i=0; i<checkboxes.length; ++i) {
                if (   checkboxes[i].getAttribute('type') == 'checkbox'
                    && checkboxes[i].getAttribute('id') == 'rowSelector'
                    && checkboxes[i].checked) {

                    selected[selected.length] = checkboxes[i].value;
                }
            }
            
            return selected;
        }


        /**
        * Initiates a CSV download
        */
        function csv_download()
        {
            var selectObj  = document.getElementById('csvdownload_what');
            var incHeaders = document.getElementById('include_headers').checked ? '1' : '0';
            
            switch (selectObj.options[selectObj.selectedIndex].value) {
            
                // Download selected rows as CSV
                case 'selected':
                    var selectedRows = getSelectedRows();
                    
                    if (selectedRows.length == 0) {
                        alert('Please select some rows to download!');
                        return;
                    }
                    
                    for (var i=0; i<selectedRows.length; ++i) {
                        selectedRows[i] = 'rows[]=' + selectedRows[i];
                    }
                    
                    var rows = selectedRows.join('&');
                    
                    location.href = location.href + (location.search.length ? '&' : '?') + 'csvdownload=1&type=selected&headers=' + incHeaders + '&' + rows;
                    break;


                // Download current page as CSV
                case 'page':
                    var checkboxes = document.getElementsByTagName('input');
                    var rows       = new Array();
        
                    for (var i=0; i<checkboxes.length; ++i) {
                        if (   checkboxes[i].getAttribute('type') == 'checkbox'
                            && checkboxes[i].getAttribute('id') == 'rowSelector') {
        
                            rows[rows.length] = 'rows[]=' + checkboxes[i].value;
                        }
                    }
                    
                    rows = rows.join('&');
                    location.href = location.href + (location.search.length ? '&' : '?') + 'csvdownload=1&type=selected&headers=' + incHeaders + '&' + rows; // type as selected is correct
                    break;


                // Download entire table as csv
                case 'table':
                    location.href = location.href + (location.search.length ? '&' : '?') + 'csvdownload=1&type=table&headers=' + incHeaders;
                    break;

                default:
                    alert('Please select which rows to download!');
                    break;
            }
            
            Fade(document.getElementById('csvDownloadLayer'), false);
        }


        /**
        * Handles row highlighting
        */
        // FIXME: Broken in FF
        /*
        function deleteCheckboxClicked(checkbox) {
              el = checkbox.parentNode;
              while (el && el.nodeName != "TR") {
                el = el.parentNode;
              }
              if (el && el.nodeName == "TR") {
                if (checkbox.checked) {
                  el.oldClassName = el.className;
                  el.className = "delete";
                } else {
                  el.className = el.oldClassName;
                  el.oldClassName = "";
                }
              }
            } 
        */
        function row_highlight(event, trObj, checkboxObj, origClass)
        {
            var srcElement = event.srcElement || event.target;

            if (srcElement.tagName.toLowerCase() == 'td' || srcElement.tagName.toLowerCase() == 'tr') {
                checkboxObj.checked = !checkboxObj.checked;
            
            } else if (srcElement.tagName.toLowerCase() == 'input') {
                event.cancelBubble = true;
            }

            if (trObj.className == 'highlightedRow') {
                trObj.className = origClass;
            } else {
                trObj.className = 'highlightedRow';
            }
        }


        /**
        * Handles redirecting for viewing a row
        */
        function row_view()
        {
            var selectedRows = getSelectedRows();
            var view         = '';

            if (selectedRows.length == 0) {
                alert('You must select a row to view!');
                return;
            }

            if (selectedRows.length > 1) {
                alert('You can only select one row at a time to view');
                return;

            } else {
                view = 'view=' + encodeURIComponent(selectedRows[0]);
            }

            location.href = location.href + (location.search.length ? '&' : '?') + view;
        }


        /**
        * Handles redirecting for deleting rows
        */
        function row_delete()
        {
            var selectedRows = getSelectedRows();
            var deletes      = new Array();
            
            if (selectedRows.length == 0) {
                alert('You must select one or more rows to delete!');
                return;
            }

            for (var i=0; i<selectedRows.length; ++i) {
                deletes[deletes.length] = 'delete[]=' + encodeURIComponent(selectedRows[i]);
            }

            if (confirm('Are you sure you wish to delete the selected row(s)? ' + (deletes.length > 1 ? '\nWARNING: Multiple rows selected!' : ''))) {
                location.href = location.href + (location.search.length ? '&' : '?') + deletes.join('&');
            }
        }


        /**
        * Handles redirecting for editing rows
        */
        function row_edit()
        {
            var selectedRows = getSelectedRows();
            var edit         = '';

            if (selectedRows.length == 0) {
                alert('You must select a row to edit!');
                return;
            }

            if (selectedRows.length > 1) {
                alert('You can only select one row at a time to edit');
                return;

            } else {
                edit = 'edit=' + encodeURIComponent(selectedRows[0]);
            }

            location.href = location.href + (location.search.length ? '&' : '?') + edit;
        }


        /**
        * Handles redirecting for copying a row
        */
        function row_copy()
        {
            var selectedRows = getSelectedRows();
            var copy         = '';

            if (selectedRows.length == 0) {
                alert('You must select a row to copy!');
                return;
            }

            if (selectedRows.length > 1) {
                alert('You can only select one row at a time to copy');
                return;

            } else {
                copy = 'copy=' + encodeURIComponent(selectedRows[0]);
            }

            location.href = location.href + (location.search.length ? '&amp;' : '?') + copy;
        }


        /**
        * Handles redirecting for adding a row
        */
        function row_add()
        {
            location.href = location.href + (location.search.length ? '&' : '?') + 'add=1';
        }


        /**
        * Handles the search button
        */
        function search()
        {
            var searchStr = document.getElementById('searchInput').value;

            location.href = location.href + (location.search.length ? '&' : '?') + 'search=' + encodeURIComponent(searchStr);
        }


        /**
        * Handles ordering links
        */
        function orderBy(field)
        {
            location.href = location.href + (location.search.length ? '&' : '?') + 'orderby=' + encodeURIComponent(field);
        }


        /**
        * Enables the apply button on the edit form
        */
        function enableApply()
        {
            document.forms[0].elements['action'][2].disabled = false;
        }


        /**
        * Returns the current date and time in ISO8660 format (YYYY-MM-DD HH:MM:SS)
        */
        function currentDateTime()
        {
            return currentDate() + ' ' + currentTime();
        }


        /**
        * Returns the current date in ISO8660 format
        */
        function currentDate()
        {
            var d = new Date();

            var date  = d.getDate() > 9 ? d.getDate() : '0' + String(d.getDate());
            var month = (d.getMonth() + 1) > 9 ? (d.getMonth() + 1) : '0' + (d.getMonth() + 1);
            var year  = d.getFullYear();

            return year + '-' + month + '-' + date;
        }


        /**
        * Returns the current time in ISO8660 format
        */
        function currentTime()
        {
            var d = new Date();

            var hours   = d.getHours() > 9 ? d.getHours() : '0' + d.getHours();
            var minutes = d.getMinutes() > 9 ? d.getMinutes() : '0' + d.getMinutes();
            var seconds = d.getSeconds() > 9 ? d.getSeconds() : '0' + d.getSeconds();

            return hours + ':' + minutes + ':' + seconds;
        }
        
        ///////////////////////////////////////////////////////////////////////
        //     This fade library was designed by Erik Arvidsson for WebFX    //
        //                                                                   //
        //     For more info and examples see: http://webfx.eae.net          //
        //     or contact Erik at http://webfx.eae.net/contact.html#erik     //
        //                                                                   //
        //     Feel free to use this code as lomg as this disclaimer is      //
        //     intact.                                                       //
        ///////////////////////////////////////////////////////////////////////
        
        
        var __fadeArray = new Array();	// Needed to keep track of wich elements are animating
        
        //////////////////  fade  ////////////////////////////////////////////////////////////
        //                                                                                  //
        //   parameter: fadeIn                                                              //
        // description: A boolean value. If true the element fades in, otherwise fades out  //
        //              The steps and msec are optional. If not provided the default        //
        //              values are used                                                     //
        //                                                                                  //
        //////////////////////////////////////////////////////////////////////////////////////
        
        function Fade(el, fadeIn, steps, msec)
        {
            if (steps == null) steps = 4;
            if (msec  == null) msec  = 25;
            
            if (el.fadeIndex == null) {
                el.fadeIndex = __fadeArray.length;
            }
            
            __fadeArray[el.fadeIndex] = el;

            if (el.fadeStepNumber == null) {
                if (el.style.visibility == "hidden") {
                    el.fadeStepNumber = 0;
                } else {
                    el.fadeStepNumber = steps;
                }
                
                if (fadeIn) {
                    el.style.filter = "Alpha(Opacity=0)";
                    el.style.MozOpacity = '0';
                } else {
                    el.style.filter = "Alpha(Opacity=100)";
                    el.style.MozOpacity = '1';
                }
            }
                    
            window.setTimeout("RepeatFade(" + fadeIn + "," + el.fadeIndex + "," + steps + "," + msec + ")", msec);
        }
        
        //////////////////////////////////////////////////////////////////////////////////////
        //  Used to iterate the fading                                                      //
        //////////////////////////////////////////////////////////////////////////////////////
        function RepeatFade(fadeIn, index, steps, msec)
        {
            el = __fadeArray[index];
            
            c = el.fadeStepNumber;
            if (el.fadeTimer != null) {
                window.clearTimeout(el.fadeTimer);
            }
                
            if ((c == 0) && (!fadeIn)) {			// Done fading out!
                el.style.visibility = "hidden";		// If the platform doesn't support filter it will hide anyway
        //		el.style.filter = "";
                return;
            
            } else if ((c==steps) && (fadeIn)) {	//Done fading in!
                el.style.filter = "";
                el.style.MozOpacity = '1';
                el.style.visibility = "visible";
                return;
            
            } else {
                (fadeIn) ? 	c++ : c--;
                el.style.visibility = "visible";
                el.style.filter = "Alpha(Opacity=" + 100*c/steps + ")";
                el.style.MozOpacity = c/steps;
        
                el.fadeStepNumber = c;
                el.fadeTimer = window.setTimeout("RepeatFade(" + fadeIn + "," + index + "," + steps + "," + msec + ")", msec);
            }
        }
    // -->
    </script>
</head>
<body onload="onload_handler()">

<div class="headerBar">
    <?=$this->getConfig('title')?>
</div>

<div class="mainbody">
    <?if($this->errors):?>
        <?foreach($this->errors as $e):?>
            <div class="error">ERROR: <?=htmlspecialchars($e)?></div>
        <?endforeach?>
    <?endif?>