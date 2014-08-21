
    <!-- End of mainbody div -->
</div>

<div id="csvDownloadLayer" onclick="event.cancelBubble = true">
    <fieldset style="width: 265px; text-align: right">
        <legend>Download CSV </legend>
        
        <table border="0">
            <tr>
                <td>Download what:</td>
                <td>
                    <select id="csvdownload_what" align="absmiddle">
                        <option value="">Select...</option>
                        <option value="selected">Selected Rows</option>
                        <option value="page">This Page</option>
                        <option value="table">Entire Table</option>
                    </select>
                </td>
            </tr>
        
            <tr>
                <td><label for="include_headers">Include headers?</label></td>
                <td><input type="checkbox" id="include_headers" checked></td>
            </tr>
        </table>
        
        <button onclick="csv_download()">Download</button>
    </fieldset>
</div>

</body>
</html>