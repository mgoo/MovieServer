<?php if(!isset($data['Error'])): ?>
<h1><?php echo utf8_decode($data['Title']).' '.  utf8_decode($data['Year']); ?></h1>
<?php elseif (isset($is_file) && $is_file == true): ?>
    <h1><?php echo $title ?></h1>      
<?php endif; ?>
    <?php if(isset($is_file) && $is_file == true): ?>
        <?php if (isset($quality)): ?><span>Quality: <?php echo $quality; ?></span><br><?php endif; ?>
        <?php if (isset($episode)): ?><span><?php echo $episode; ?></span><br><?php endif; ?>  
        <?php if($ext == 'mp4' || $ext == 'm4v'): ?><a class="imgButton" href="<?php echo $location ?>" target="_blank"><?php echo $this->Html->image('play.png'); ?></a><?php endif; ?>
        <a class="imgButton" href="<?php echo $location ?>" target="_blank"><?php echo $this->Html->image('download.png'); ?></a>
        <span class="imgButton" id="copy"><?php echo $this->Html->image('copy.png'); ?><input style="display: none;" id="location" type="text" value="<?php echo $network_location; ?>"></span>    
    <?php endif; ?>
<?php if(!isset($data['Error'])): ?>
    <h2>ImdbRating: <?php echo $data['imdbRating']; ?></h2>    
    <h3>Actors: <?php echo utf8_decode($data['Actors']); ?></h3>
    <span>Type: <?php echo $data['Type']; ?> <br></span>
    <span>Genre: <?php echo $data['Genre']; ?> <br></span>
    <p><?php echo $data['Plot'];?></p>
    <img src='<?php echo $data['Poster']; ?>' alt="Poster">
<?php elseif (!isset($is_file) || $is_file == false): ?>
    Could not find the movie
<?php endif; ?>

    <script>
    $('#copy').click(function(){
        $('#location').show();
        $('#location').select();
        document.execCommand("copy");
        $('#location').hide();
    });
    
    </script>

