<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <title><?php e(utf8_encode($context->document()->title())); ?></title>
        <meta name="description" content="<?php e($context->document()->meta['description']); ?>" />
        <meta name="keywords" content="<?php e($context->document()->meta['keywords']); ?>" />
        <meta name="verify-v1" content="4r4MQ/SQvVdgtEm6Im+uaPclTV0YeQv8XGd7Mw24TTk=" />
        <style type="text/css">
            @import "layout.css";
        </style>

    </head>

    <body<?php if (!empty($body_class)) echo ' class="'.$body_class.'"'; ?>>

        <div id="container">

            <div id="branding">
                <h1><a href="./">Vejle Idrætshøjskoles Kursuscenter</a></h1>
                <div id="branding-logo">
                </div>
            </div>

            <div id="search">
            </div>

            <div id="navigation-main">
                <ul>
                <?php foreach ((array)$context->document()->navigation['toplevel'] as $navigation): ?>
                	<li><a href="<?php e(url($navigation['identifier'])); ?>"><?php e($navigation['navigation_name']); ?></a></li>
            	<?php endforeach; ?>
            	</ul>
            </div>

            <div id="navigation-section">
            </div>

            <div id="breadcrumb">
            </div>

            <div id="content">
                <div id="content-main">
                    <?php echo utf8_encode($content); ?>
                </div>
			</div>

            <div id="siteinfo">
                <div id="siteinfo-legal">
                    &copy; www.vih.dk/kursuscenter
                </div>
            </div>
        </div>
    </body>
</html>
