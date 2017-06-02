<div class="content">
    <h2>Torrent Clients</h2>
    <ul>
        <li><a href="<?= $this->Url->build(['controller' => 'Download', 'action' => 'deluge'])?>">Deluge</a></li>
        <li><a href="#" onclick="loadPage('<?= $this->Url->build(['controller' => 'Download', 'action' => 'deluge'])?>', )">Deluge - broken</a></li>
        <li><a href="#" onclick="loadPage('<?= $this->Url->build(['controller' => 'Download', 'action' => 'transmission'])?>')">Transmission</a></li>
    </ul>
</div>