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
                <h1 class="content-subhead">Browse Gallery</h1>

                <section class="post">
                    <header class="post-header">
                        <h2 class="post-title">Gallery</h2>
                    </header>

                    <div class="post-description">
                        <ul>
                            <li><strong>Name: </strong><?php echo htmlspecialchars($image->name); ?></li>
                            <li><strong>Description: </strong><?php echo htmlspecialchars($image->description); ?></li>
                            <li><strong>Date uploaded: </strong><?php echo $image->created_at; ?></li>
                        </ul>
                        <a class="button-error pure-button pure-button-error" href="/gallery/<?php echo $image->id; ?>/delete">Delete Image</a>
                    </div>
                </section>
            </div>

            <div class="pure-g">
                <div class="photo-box pure-u-1">
                    <img class="pure-img" src="<?php echo $image->path; ?>" alt="<?php echo htmlspecialchars($image->name); ?>">
                </div>
            </div>

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
