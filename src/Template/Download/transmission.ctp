<?php if(isset($current_torrents)): ?>
    <?php foreach($current_torrents as $torrent): ?>
        <div id="torrentid-<?= $torrent->id ?>" class="download-item">
            <?= $this->element('torrent_downloading', ['torrent' => $torrent]) ?>
        </div>
        <script>
            setInterval(function(){
                    ajax_call_replace('<?= $this->Url->build(['controller' => 'Download', 'action' => 'get']) ?>',
                    {id: <?= $torrent->id ?>},
                    $('#torrentid-<?= $torrent->id ?>'));
                },
                3000);
        </script>
    <?php endforeach; ?>
    <script>
        function removeTorrent(id){
            ajax_call('<?= $this->Url->build(['controller' => 'Download', 'action' => 'remove']) ?>', {id: id}, function(){});
        }
        function stopTorrent(id){
            ajax_call('<?= $this->Url->build(['controller' => 'Download', 'action' => 'stop']) ?>', {id: id}, function(){});
        }
        function startTorrent(id) {
            ajax_call('<?= $this->Url->build(['controller' => 'Download', 'action' => 'start']) ?>', {id: id}, function(){});
        }
    </script>
<?php endif;?>
