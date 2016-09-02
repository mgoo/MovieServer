<?php if (!isset($data['error'])):?>
<ul class="results_list">
    <?php print_r($data); ?>
    <?php foreach ($data as $torrent): ?>
    <?php if (!isset($torrent['title'])){echo $torrent.' Results<br>';continue;} ?>
    <li><span class="title"><?php echo $torrent['title']; ?></span></li>
    <ul>
        <li>Seeds: <?php echo $torrent['seeds']; ?> Leechs: <?php echo $torrent['leechs'];?> Size: <?php echo $this->Torrent->formatBytes($torrent['torrent_size']);?></li>
        <li>
            <span class="imgButton" id="<?php echo $torrent['torrent_hash']; ?>"><?php echo $this->Html->image('add.png', ['alt' => 'Add Torrent']);?></span>
            <a class="imgButton" href='<?php echo $this->Torrent->hash_to_magnet($torrent['torrent_hash'], $torrent['title']); ?>' target="_blank">
                <?php echo $this->Html->image('magnet.png', ['alt' => 'Magnet Link']) ?>
            </a>
        </li>
        <script>
            $('#<?php echo $torrent['torrent_hash'];?>').click(function(){
                    $.ajax({
                        url: '<?php echo $this->Html->url(['controller' => 'Torrent', 'action' => 'add'], true);?>',
                        type: 'POST',
                        data: {hash: '<?php echo $torrent['torrent_hash']; ?>', title: '<?php echo $torrent['title']; ?>'}
                    })
                            .done(function(data){
                                alert('The torrent was added');
                            })
                            .fail(function(msg, status, reason){
                                alert('Something went wrong')
                            }); 
            });
        </script>
    </ul>
    <?php endforeach; ?>    
</ul>
<?php else: ?>
<h3><?php echo $data['error']; ?></h3>
<br>
<p><?php echo $data['reason']; ?></p>

<?php endif;?>
