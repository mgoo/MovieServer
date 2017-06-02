<?php if (isset($results)): ?>
    <?php foreach($results as $result):?>
        <div class="result-item">
            <h3><?= $result['extracted_name'][0] ?></h3>
            <h5><?= $result['name'] ?></h5>
            <a class="button-sml" href="<?= $result['magnet'] ?>"><i class="glyphicon glyphicon-magnet"></i></a>
            <a class="button-sml" href="<?= $this->Url->build(['controller' => 'download', 'action' => 'add', '?' => ['magnet' => $result['magnet']]]) ?>"><i class="glyphicon glyphicon-plus"></i></a>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
