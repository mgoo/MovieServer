<form class="col s12">
<div class="row">
    <div class="input-field col s6">
        <i class="material-icons prefix">search</i>
        <input id="search_movie" class="search" type="text" placeholder="Search" >
        <label for="search_movie">Search</label>
    </div>
    
    <div class="input-field col s6">
        <select id="filter" class="icons">
            <option data-icon="img/copy.png" value="videos">Movie Files</option>
            <option data-icon="img/folder.png" value="folders">Folders</option>
            <option data-icon="img/sample-1.jpg" value="all">Everything</option>
            <option data-icon="img/download.png" value="downloading">Downloading</option>
        </select>
        <label>Filter</label>
    </div>
</div>
</form>
<div id="all">
    <?php echo $this->element('DirElement', ['folders' => $folders, 'files' => $files]);?>
</div>
<div id="results">
    
</div>

<script>
    $('#search_movie').keyup(function(e){
        if(e.which === 13) { 
            $.ajax({
                url: '<?php echo $this->Html->url(['controller' => 'Movie', 'action' => 'searchDir'], true);?>',
                type: 'POST',
                data: {search: $('#search_movie').val(), dir: 'files/', filter: $('#filter').val()}
            })
                    .done(function(data){
                        $('#results').html(data);
                        $('#all').fadeOut('400', function(){$('#results').fadeIn();});
                    })
                    .fail(function(msg, status, reason){
                        alert('Something went wrong');
                    }); 
        }
        if(e.which === 27){        
            $('#results').fadeOut(400, function(){$('#all').fadeIn();});
        }
    });
    
    
    function openFolder(dir, folder, event){
        if ($($(event).children()[0]).hasClass('down')){
            $(event).next().fadeOut();
            $($(event).children()[0]).removeClass('down').addClass('up');
            return;
        }
        if ($(event).next().is('ul') && $(event).next().is(':visible') !== true){
            $($(event).children()[0]).removeClass('up').addClass('down');
            $(event).next().fadeIn();
            return;
        }
        $.ajax({
            url: '<?php echo $this->Html->url(['controller' => 'Movie', 'action' => 'scanDir'], true);?>',
            type: 'POST',
            data: {dir: dir+folder+'/'}
        })
                .done(function(data){
                    $($(event).children()[0]).removeClass('up').addClass('down');
                    $(event).after(data);
                    $(event).next().hide().fadeIn();
                })
                .fail(function(msg, status, reason){
                    alert('Something went wrong')
                });
    }
    
    function openFile(dir, event){
        $.ajax({
                url: '<?php echo $this->Html->url(['controller' => 'Search', 'action' => 'quickOpen'], true);?>',
                type: 'POST',
                data: {title: $(event).html(), dir: dir}
            })
                    .done(function(data){
                        $('#right_bar').html(data);
                    })
                    .fail(function(msg, status, reason){
                        alert('Something went wrong');
                    });                  
        $.ajax({
                url: '<?php echo $this->Html->url(['controller' => 'Search', 'action' => 'getInfo'], true);?>',
                type: 'POST',
                data: {title: $(event).html(), dir: dir, isFile: true}
            })
                    .done(function(data){
                        $('#right_bar').html(data);
                    })
                    .fail(function(msg, status, reason){
                        alert('Something went wrong');
                    });
        
    }
    
    function editFile(dir, file, event){
        var oldName = $(event).text();
        
        $(event).prop('onclick', null).off('click');
        $(event).prop('ondblclick', null).off('dbclick');
        
        $(event).html('<input class="editing" type=text value="'+$(event).html()+'">');
                
        $(event).on("keyup",function(e){
             if(e.which === 13) {  
                $.ajax({
                    url: '<?php echo $this->Html->url(['controller' => 'Movie', 'action' => 'changeName'], true);?>',
                    type: 'POST',
                    data: {dir: dir, file: file, name: $($(event).children()[0]).val()}
                })
                    .done(function(data){
                        $(event).on('click', function(){openFile(dir+$($(event).children()[0]).val(), event);});                        
                        $(event).on('dblclick', function(){editFile(dir, $($(event).children()[0]).val(), event);});
                        $(event).html($($(event).children()[0]).val());
                        $(event).off('keyup');
                    })
                    .fail(function(msg, status, reason){
                        alert('Something went wrong')
                    });
            }
            if (e.which === 27) {
                $(event).append(oldName);
                
                $(event).on('click', function(){openFile(dir+oldName, event);});                        
                $(event).on('dblclick', function(){editFile(dir, oldName, event);});
                
                $($(event).children()[0]).remove();
                $(event).off('keyup');
            }
        });
    }
    
    function editFolder(dir, file, event){
        var span = $($(event).children()[0]);
        var oldName = $(event).text().substring(1, $(event).text().length);
        
        $(event).prop('onclick', null).off('click');
        $(event).prop('ondblclick', null).off('dbclick');
        
        if ($(event).next().is('ul')){
            $(event).next().hide();
        }
                
        $(event).html('<input class="editing" type=text value="'+oldName+'">');
        
        $(event).on('keyup',function(e){
             if(e.which === 13) {  
                $.ajax({
                    url: '<?php echo $this->Html->url(['controller' => 'Movie', 'action' => 'changeName'], true);?>',
                    type: 'POST',
                    data: {dir: dir, file: file, name: $($(event).children()[0]).val()}
                })
                    .done(function(data){  
                        var newName = $($(event).children()[0]).val();
                        $(event).append(span);
                        $(event).append(newName); 
                                                
                        $(event).on('click', function(){openFolder(dir, newName+'/', event);});                        
                        $(event).on('dblclick', function(){editFolder(dir, newName, event);});
                        
                        $($(event).children()[0]).remove();
                        $(event).off('keyup');
                    })
                    .fail(function(msg, status, reason){
                        alert('Something went wrong')
                    });
            }
            if (e.which === 27) {
                $(event).append(span);
                $(event).append(oldName);
                
                $(event).on('click', function(){openFolder(dir, oldName+'/', event);});                        
                $(event).on('dblclick', function(){editFolder(dir, oldName, event);});
                
                $($(event).children()[0]).remove();
                $(event).off('keyup');
            }
        });
    }
    
    </script>