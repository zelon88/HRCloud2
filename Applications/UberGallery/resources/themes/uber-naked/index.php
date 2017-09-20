<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>UberGallery</title>
    <link rel="shortcut icon" href="<?php echo THEMEPATH; ?>/images/favicon.png" />

    <link rel="stylesheet" type="text/css" href="<?php echo THEMEPATH; ?>/style.css" />
    <?php echo $gallery->getColorboxStyles(1); ?>

    <script type="text/javascript" src="resources/jquery-2.1.4.js"></script>
    <?php echo $gallery->getColorboxScripts(); ?>

</head>

<body>

    <h1>UberGallery</h1>

    <?php
        $galleryArray['relText'] = 'colorbox';
        echo $gallery->readTemplate('templates/defaultGallery.php', $galleryArray);
    ?>

</body>

</html>
