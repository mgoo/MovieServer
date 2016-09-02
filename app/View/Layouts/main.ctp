<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Html->charset(); ?>
    <title>
        Movie Server
    </title>
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css(['Normalize', 'main', 'search', 'movies', 'torrents', 'materialize.min.css']);
        echo $this->Html->script(array('jquery-3.0.0.min', 'materialize.min.js'), array('inline' => false));        
        
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>
    <div id="container" style="display: inline-table;">
    <?php echo $this->fetch('content'); ?>
    </div>
    <script>
        $(document).ready(function() {
            $('select').material_select();
        });
    </script>
</body>
</html>
