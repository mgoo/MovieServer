<?php $completed = $torrent->percentDone * 100; ?>
<?php
$progress_class = '';
if ($torrent->status == \Transmission\Model\Torrent::STATUS_DOWNLOAD)$progress_class = 'progress-bar-info progress-bar-striped active';
if ($torrent->status== \Transmission\Model\Torrent::STATUS_SEED)$progress_class = 'progress-bar-success progress-bar-striped active';
if ($torrent->status== \Transmission\Model\Torrent::STATUS_STOPPED)$progress_class = 'progress-bar-danger';
$downRate = $this->Download->bytesToReadable($torrent->rateDownload);
$uploadRate = $this->Download->bytesToReadable($torrent->rateUpload);
?>
<h3><?= $torrent->name ?></h3>
<a class="button-sml" onclick="stopTorrent(<?= $torrent->id ?>)"><i class="glyphicon glyphicon-pause"></i></a>
<a class="button-sml" onclick="removeTorrent(<?= $torrent->id ?>)"><i class="glyphicon glyphicon-remove"></i></a>
<a class="button-sml" onclick="startTorrent(<?= $torrent->id ?>)"><i class="glyphicon glyphicon-play"></i></a>
<span class="download-rate"><?= $downRate['amount']; ?><?= $downRate['units']; ?> / <?= $uploadRate['amount'];?><?= $uploadRate['units']; ?></span>
<div class="progress">
    <div class="progress-bar <?= $progress_class ?>" role="progressbar" aria-valuenow="<?= $completed ?>" aria-valuemin="0" aria-valuemax="100"
         style="width: <?= $completed ?>%"><?= $completed ?>%</div>
</div>