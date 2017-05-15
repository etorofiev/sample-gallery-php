<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A sample gallery of images build with Slim and PureCSS">
    <title>Sample PHP Gallery</title>
    
    <link rel="stylesheet" href="https://unpkg.com/purecss@0.6.2/build/pure-min.css" integrity="sha384-" crossorigin="anonymous">

    <!--[if gt IE 8]><!-->
        <link rel="stylesheet" href="https://unpkg.com/purecss@0.6.2/build/grids-responsive-min.css">
    <!--<![endif]-->
        
    <!--[if gt IE 8]><!-->
        <link rel="stylesheet" href="/css/gallery.css">
    <!--<![endif]-->
</head>
<body>
<div id="layout" class="pure-g">
    <div class="sidebar pure-u-1 pure-u-md-1-4">
        <div class="header">
            <h1 class="brand-title">A Sample Gallery</h1>
            <h2 class="brand-tagline">Just a simple gallery application written in PHP</h2>

            <nav class="nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a class="pure-button" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="pure-button" href="/gallery">Browse</a>
                    </li>
                    <li class="nav-item">
                        <a class="pure-button" href="/upload">Upload</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <div class="content pure-u-1 pure-u-md-3-4">
        <div>
            <div class="posts">
                <h1 class="content-subhead">Upload</h1>

                <section class="post">
                    <header class="post-header">
                        <h2 class="post-title">Upload image</h2>
                    </header>

                    <div class="post-description">
                        <p>
                            Select an image you wish to upload and fill the details. To complete the upload, press the "Upload" button
                        </p>
                    </div>
                </section>
            </div>

            <form class="pure-form pure-form-aligned" action="/upload-image" method="post" enctype="multipart/form-data">
                <fieldset>
                    <div class="pure-control-group">
                        <label for="name">Name</label>
                        <input id="name" name="image_name" type="text" placeholder="Image name">
                        <span class="pure-form-message-inline">*</span>
                    </div>

                    <div class="pure-control-group">
                        <label for="password">Image</label>
                        <input id="file" name="image_upload" type="file" placeholder="Select file">
                        <span class="pure-form-message-inline">*</span>
                    </div>

                    <div class="pure-control-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="image_description" rows="4" cols="60" placeholder="Image description"></textarea>
                    </div>

                    <div class="pure-controls">
                        <button type="submit" class="pure-button pure-button-primary">Upload</button>
                    </div>
                </fieldset>
            </form>

            <div class="footer">
                <div class="pure-menu pure-menu-horizontal">
                    <ul>
                        <li class="pure-menu-item"><a href="https://github.com/etorofiev/sample-gallery-php" class="pure-menu-link">Github</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
