<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Converter || Convert Image from JPG to WebP</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
    <h2 class="title">Upload Images to Convert to WebP</h2>

    <form id="uploadForm" action="upload.php" method="post" enctype="multipart/form-data">
        <div class="border-dashed">
            <label for="images" class="browse-image">Select images:</label>
        </div>
        <input type="file" name="images[]" id="images" multiple accept="image/jpeg">

        <div class="d-flex">
            <div class="quality">
                <label for="quality">Quality (1-100):</label>
                <input type="number" name="quality" id="quality" min="1" max="100" value="80">
            </div>
            <input type="submit" value="Convert Images" name="submit">
        </div>
        
    </form>
    <div id="imageBox"></div>

    <script>
        $(document).ready(function() {
            $('#images').on('change', function() {
                const $input = $(this);
                const $fileNamesDiv = $('#imageBox');
                $fileNamesDiv.empty(); // Clear previous file names

                $.each($input[0].files, function(i, file) {
                    let fileSize = (file.size / 1024); // Convert file size to KB
                    let sizeUnit = 'KB';
                    if (fileSize > 1024) {
                        fileSize = (fileSize / 1024).toFixed(2);
                        sizeUnit = 'MB';
                    } else {
                        fileSize = fileSize.toFixed(2);
                    }
                    const fileUrl = URL.createObjectURL(file); // Create a temporary URL for the file

                    const fileHtml = `
                    <div class="preview-image" id="file-${i}">
                        <div class="image loading" id="image-${i}">
                            <img src="${fileUrl}" alt="${file.name}">
                        </div>
                        <div class="image-info">
                            <div class="image-name">
                                <p class="mb-2 text-truncate">${file.name}</p>
                                <p>${fileSize} ${sizeUnit}</p>
                            </div>
                            <p class="status loading">loading</p>
                        </div>
                    </div>`;
                    
                    $fileNamesDiv.append(fileHtml);

                    // Simulate loading effect and then update status to uploaded
                    setTimeout(function() {
                        $(`#file-${i} .status`).removeClass('loading').addClass('uploaded');
                        $(`#image-${i}.image`).removeClass('loading');
                    }, 2000);
                });
            });
        });
    </script>
</body>
</html>