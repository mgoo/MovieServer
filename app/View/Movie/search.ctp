<div id="search_bar_imdb">
    <form class="col s12">
        <div class="row">
            <div class="input-field col s4">
                <i class="material-icons prefix">search</i>
                <input id="title" name="title" class="search" type="text" placeholder="Title">
                <label for="title">Title</label>
            </div>

            <div class="input-field col s4">
                <input id="year" name="year" class="search" type="text" placeholder="Year">
                <label for="year">Year</label>
            </div>
            
            <div class="input-field col s4">
                <select id="type" class="icon">
                    <option value="movie">Movie</option>
                    <option value="series">Series</option>
                    <option value="episode">Episode</option>
                </select>
                <label>Year</label>
            </div>
        </div>
    </form>

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
    