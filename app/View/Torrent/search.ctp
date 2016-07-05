<input id="title" name="title" class="search" type="text" placeholder="Title" value="<?php if (isset($title)){echo $title;} ?>">
<input id="year" name="year" class="search" type="text" placeholder="Year" value="<?php if (isset($year)){echo $year;} ?>">
<div id="results" class="searchResults"></div>

<script>
    $(document).keypress(function(e) {
        if(e.which === 13) {         
            search($('#title').val(), $('#year').val());
        }        
    });
    
    search($('#title').val(), $('#year').val());    
    
    function search(title, year){
        if (title === '')return;
        $.ajax({
            url: '<?php echo $this->Html->url(['controller' => 'Search', 'action' => 'search'], true);?>',
            type: 'POST',
            data: {title: title, year: year},
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
</script>
