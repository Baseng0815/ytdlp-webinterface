<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="style.css" rel="stylesheet">
        <script src="script.js"></script>
    </head>
    <body>
        <div class="content">
            <form enctype="multipart/form-data" action="form.php" method="post">
                <div class="row" id="div-urls">
                    <label for="url[]">URL</label>
                    <input class="input-pad" type="url" name="url[]" placeholder="Please enter a file URL">
                </div>
                <div class="row">
                    <button type="button" onclick="addRow()">Add URL</button>
                </div>
                <div class="row">
                    <label for="batch">Batch file upload</label><br>
                    <input type="file" name="batch">
                </div>
                <div class="row">
                    <input type="checkbox" name="audio">
                    <label for="audio">Extract and download audio only</label>
                </div>
                <div class="row">
                    <button type="submit">Submit</button>
                </div>
            </form>
        </div>
    </body>
</html>
