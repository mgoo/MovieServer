<div class="side_bar">
    <ul>
        <li>Movies<br></li>
        <ul>
            <li id="movies_button">View</li>            
        </ul>
        <li>Imdb</li>
        <ul>
            <li id="serch_movies_button">Search</li>
        </ul>
        <li>Torrents<br></li>
        <ul>
            <li id="search_torrent_button">Search<br></li>
            <li id="torrents_button">Current</li>
        </ul>
    </ul>    
</div>
<div class="middle_div" id="middle_div">
</div>
<div class="right_bar" id="right_bar">
    
</div>
<script>
    $(document).on('load', loadMovies());    
    $('#movies_button').click(function(){loadMovies();});
    
    function loadMovies(){
        $.ajax({
            url: '<?php echo $this->Html->url(['controller' => 'Movie', 'action' => 'scanDir'], true);?>',
            type: 'POST',
            data: {dir: '<?php echo 'files/'; ?>', first: true}
        })
                .done(function(data){
                    $('#middle_div').html(data);
                })
                .fail(function(msg, status, reason){
                    alert('Something went wrong');
                });
    }
    
    $('#search_torrent_button').click(function(){
        $.ajax({
            url: '<?php echo $this->Html->url(['controller' => 'Torrent', 'action' => 'search'], true);?>',
            type: 'POST'
        })
                .done(function(data){
                    $('#middle_div').html(data);
                })
                .fail(function(msg, status, reason){
                    alert('Something went wrong');
                });
    });
    $('#torrents_button').click(function(){
        $.ajax({
            url: '<?php echo $this->Html->url(['controller' => 'Torrent', 'action' => 'index'], true);?>',
            type: 'POST'
        })
                .done(function(data){
                    $('#middle_div').html('<iframe src="http://<?php echo Configure::read('ServerName') ?>:9091" style="width: 100%;height: 100%"></iframe>');
                })
                .fail(function(msg, status, reason){
                    alert('Something went wrong');
                });
    });
    $('#serch_movies_button').click(function(){
        $.ajax({
            url: '<?php echo $this->Html->url(['controller' => 'Movie', 'action' => 'Search'], true);?>',
            type: 'POST'
        })
                .done(function(data){
                    $('#middle_div').html(data);
                })
                .fail(function(msg, status, reason){
                    alert('Something went wrong');
                });
    });
  
    /*$('#torrents_button').click(function(){ FOR TESTING TRANSMISSION RCP
        $.ajax({
            url: 'http://mgoopc:9091/transmission/rpc/',
            type: 'POST',
            dataType: 'jsonp',
            crossDomain: true,
            data: {method: 'torrent_get', arguments:{fields: ["id", "name", "totalSize"], ids: [1,2,3,4,5]}, tag: 39021}
        })
                .done(function(data){
                    $('#middle_div').html(data);
                })
                .fail(function(msg, status, reason){
                    alert(status);
                });
    });*/
</script>