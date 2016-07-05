<?php if ($data['Response'] != 'False'): ?>
Total Results: <?php echo $data['totalResults']; ?> <br>
    <?php if ($page != 1): ?>
        <span onclick="loadPage(<?php echo $page - 1;?>)">Pre</span>
    <?php endif; ?>
        <span> Current Page: <?php echo $page; ?></span>
    <?php if ($page != 100): ?>
        <span onclick="loadPage(<?php echo $page + 1; ?>)">Next</span>
    <?php endif; ?>
    <ul>
    <?php foreach ($data['Search'] as $search_result): ?>
        <li><span onclick="loadMovie('<?php echo $search_result['Title']; ?>', '<?php echo $search_result['Year']; ?>')"><?php echo $search_result['Title']; ?></span><span onclick="torrentSearch('<?php echo $search_result['Title'] ?>', '<?php echo $search_result['Year'] ?>')" class="imgButton"><?php echo 'T' ?></span></li>
    <?php endforeach; ?>
    </ul>  
<?php else: ?>
        <script>
            loadPage(<?php echo $page -1; ?>);
        </script>
<?php endif; ?>
    
<script>
    function loadPage(page){
        $.ajax({
            url: '<?php echo $this->Html->url(['controller' => 'Search', 'action' => 'searchOmdb'], true);?>',
            type: 'POST',
            data: {title: '<?php echo $title ?>', year: '<?php echo $year; ?>', type: '<?php echo $type; ?>', page: page},
            beforeSend: function(){
                $('#results').html('<?php echo $this->Html->image('loading.gif', ['alt' => 'Loading', 'class' => 'loading']); ?>');
            }
        })
                .done(function(data){
                    $('#results').html(data);
                })
                .fail(function(msg, status, reason){
                    alert('Something went wrong');
                });
    }

    function loadMovie(title, year){
        $.ajax({
            url: '<?php echo $this->Html->url(['controller' => 'Search', 'action' => 'getInfo'], true);?>',
            type: 'POST',
            data: {title: title, year: year},
            beforeSend: function(){
                    $('#right_bar').html('<?php echo $this->Html->image('loading.gif', ['alt' => 'Loading', 'class' => 'loading']); ?>');
            }
        })
                .done(function(data){
                    $('#right_bar').html(data);
                })
                .fail(function(msg, status, reason){
                    alert('Something went wrong');
                });
    }
    
    function torrentSearch(title, year){
        $.ajax({
            url: '<?php echo $this->Html->url(['controller' => 'Torrent', 'action' => 'search'], true);?>',
            type: 'POST',
            data: {title: title, year: year},
            beforeSend: function(){
                    $('#middle_div').html('<?php echo $this->Html->image('loading.gif', ['alt' => 'Loading', 'class' => 'loading']); ?>');
            }
        })
                .done(function(data){
                    $('#middle_div').html(data);
                })
                .fail(function(msg, status, reason){
                    alert('Something went wrong');
                });
    }
</script>


