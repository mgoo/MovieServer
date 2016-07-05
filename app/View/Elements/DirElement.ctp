<ul class="moive_list">
    <?php if($folders != []): ?>
        <?php foreach($folders as $folder): ?>  
            <?php if($folder['connected'] === true): ?>
                <li onclick="openFolder('<?php echo addslashes($folder['dir'])?>', '<?php echo addslashes($folder['name']);?>', this)" 
                    ondblclick="editFolder('<?php echo addslashes($folder['dir'])?>', '<?php echo addslashes($folder['name']);?>', this)">
                    <span>></span><?php echo $folder['name'];?>
                </li>
            <?php elseif($folder['connected'] === false): ?>
                <li><?php echo $folder['name']; ?></li>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php if($files != []): ?>
        <?php foreach($files as $file): ?>
            <li onclick="openFile('<?php echo addslashes($file['dir'].$file['name']);?>', this)" 
                ondblclick="editFile('<?php echo addslashes($file['dir']);?>', '<?php echo addslashes($file['name']); ?>', this)"><?php echo addslashes($file['name']); ?></li>
        <?php endforeach; ?>
    <?php endif; ?>
</ul>