<div id="search_bar_imdb">
<input id="title" name="title" class="search" type="text" placeholder="Title">
<input id="year" name="year" class="search" type="text" placeholder="Year">
<select id="type" class="search">
    <option value="movie">Movie</option>
    <option value="series">Series</option>
    <option value="episode">Episode</option>
</select>
</div>
<div id="results" class="searchResults"></div>

<script>
    $('#search_bar_imdb').keypress(function(e) {
        if(e.which === 13) {         
            $.ajax({
                url: '<?php echo $this->Html->url(['controller' => 'Search', 'action' => 'searchOmdb'], true);?>',
                type: 'POST',
                data: {title: $('#title').val(), year: $('#year').val(), type: $('#type').val(), page: 1},
                beforeSend: function(){
                    $('#results').html('<?php echo $this->Html->image('loading.gif', ['alt' => 'Loading', 'class' => 'loading']); ?>');
                }
            })
                    .done(function(data){
                        $('#results').html(data);
                    })
                    .fail(function(msg, status, reason){
                        alert('Something went wrong');
                        alert(reason);
                    });
                    
            $.ajax({
                url: '<?php echo $this->Html->url(['controller' => 'Search', 'action' => 'getInfo'], true);?>',
                type: 'POST',
                data: {title: $('#title').val(), year: $('#year').val()},
                beforeSend: function(){
                    $('#right_bar').html('<?php echo $this->Html->image('loading.gif', ['alt' => 'Loading', 'class' => 'loading']); ?>');
                }
            })
                    .done(function(data){
                        $('#right_bar').html(data);
                    })
                    .fail(function(msg, status, reason){
                        alert('Something went wrong');
                        alert(reason);
                    });
        }
        
    });
</script>
    