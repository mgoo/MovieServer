<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Html->charset(); ?>
    <title>
        Movie Server
    </title>
    <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css(['Normalize', 'main', 'search', 'movies', 'torrents']);
        echo $this->Html->script(array('jquery-3.0.0.min'), array('inline' => false));        
        
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        
    ?>
</head>
<body>
    <div id="container" style="display: inline-table;">
    <?php echo $this->fetch('content'); ?>
    </div>
</body>
</html>
