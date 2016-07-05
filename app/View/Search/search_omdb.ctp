<?php if ($data['Response'] != 'False'): ?>
Total Results: <?php echo $data['totalResults']; ?> <br>
    <ul class="omdb_results">
    <?php foreach ($data['Search'] as $search_result): ?>
        <li>
            <span onclick="loadMovie('<?php echo addslashes($search_result['Title']); ?>', '<?php echo addslashes($search_result['Year']); ?>')"><?php echo $search_result['Title']; ?></span>
            <ul>
                <li><span onclick="torrentSearch('<?php echo addslashes($search_result['Title']) ?>', '<?php echo addslashes($search_result['Year']); ?>')" class="imgButton"><?php echo $this->Html->image('torrent_project.png'); ?></span>
                    <span ><a href="http://www.imdb.com/title/<?php echo $search_result['imdbID']; ?>/" target="_blank" class="imgButton"><?php echo $this->Html->image('imdb.png'); ?></a></span></li>
            </ul>
        </li>
    <?php endforeach; ?>
    </ul>  
<?php else: ?>
        <script>
            loadPage(<?php echo $page -1; ?>);
        </script>
<?php endif; ?>

<div class="page_number_container">
    <?php if ($page != 1): ?>
        <span class="page_number" onclick="loadPage(<?php echo $page - 1; ?>)">Pre</span>        
    <?php endif; ?>
    <?php if ($page > 2): ?>
        <span class="page_number" onclick="loadPage(<?php echo $page - 2; ?>)"><?php echo $page - 2; ?></span>
    <?php endif; ?> 
    <?php if ($page != 1): ?>
        <span class="page_number" onclick="loadPage(<?php echo $page - 1; ?>)"><?php echo $page - 1; ?></span>
    <?php endif; ?>    
        <span class="page_current"><?php echo $page; ?></span>
    <?php if ($page < 100): ?>
        <span class="page_number" onclick="loadPage(<?php echo $page + 1; ?>)"><?php echo $page + 1; ?></span>
    <?php endif; ?> 
    <?php if ($page < 99): ?>
        <span class="page_number" onclick="loadPage(<?php echo $page + 2; ?>)"><?php echo $page + 2; ?></span>
    <?php endif; ?> 
    <?php if ($page != 100): ?>
        <span class="page_number" onclick="loadPage(<?php echo $page + 1; ?>)">Next</span>
    <?php endif; ?>
</div>
    
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


