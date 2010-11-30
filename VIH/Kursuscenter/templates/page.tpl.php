<?php if (!empty($picture['file_uri'])): ?>
    <img src="<?php e($picture['file_uri']); ?>" width="<?php e($picture['width']); ?>" height="<?php e($picture['height']); ?>" alt="" />
<?php endif; ?>

<h1><?php e($headline); ?></h1>

<?php echo $html; ?>
