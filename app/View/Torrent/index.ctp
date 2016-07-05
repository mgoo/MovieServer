<?php// print_r($data); ?>
<ul class="moive_list">
    
<?php foreach ($data as $TorrentData):?>
    <li><?php echo $TorrentData['name']; ?></li>   
    <ul>
            <li><progress class="progress_bar" value="<?php echo $TorrentData['done']; ?>" max="100"></progress><?php echo $TorrentData['have']; ?></li>        
            <li>Down: <?php echo $TorrentData['down']; ?> Up: <?php echo $TorrentData['up']; ?> ETA: <?php echo $TorrentData['ETA'];?></li>
    </ul>
<?php endforeach; ?>
</ul>

<script>

</script>