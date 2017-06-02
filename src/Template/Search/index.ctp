<form class="form-inline content" action="<?= $this->Url->build(['controller' => 'Search', 'action' => 'search']) ?>" method="post">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
        <input id="search" type="text" class="form-control" name="search">
    </div>
    <div class="input-group">
        <select class="form-control" name="category" id="category">
            <option value="all">All</option>
            <option value="videos">Videos</option>
            <option value="applications">Applications</option>
            <option value="games">Games</option>
            <option value="audio">Audio</option>
            <option value="other">Other</option>
        </select>
    </div>
    <div class="input-group">
        <select class="form-control" name="order" id="order">
            <option value="default">Default</option>
            <option value="seeders">Seeders</option>
            <option value="leachers">leachers</option>
        </select>
    </div>
    <div class="input-group">
        <button class="form-control btn btn-success"
                type="button"
                onclick="$('#search_results').slideUp(400, function(){
                    $('#search_results').html('');
                    submit_form($('form').attr('action'), function(data) {
                        $('#search_results').html(data).hide().slideDown(400);
                    })
                });return false;"
        >Search</button>
    </div>
</form>
<div class="container content" id="search_results"></div>
