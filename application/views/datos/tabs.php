<div class="tabInfos">
    <!-- Navegacion tabs -->
    <ul class="nav nav-tabs" id="tabsTab">
        <li class="active">
            <a href="#home" data-toggle="tab">General</a>
        </li>
        <li>
            <a href="#infraestructura" data-toggle="tab">Infraestructura</a>
        </li>
        <li>
            <a href="#mas" data-toggle="tab">Algo más</a>
        </li>
    </ul>

    <!-- Tabs paneles -->
    <div class="tab-content">
        <div class="tab-pane fade in active" id="home"></div>
        <div class="tab-pane fade" id="infraestructura"></div>
        <div class="tab-pane fade" id="mas">Algo mas por acá</div>
    </div>
</div>
<script>
    $(function() {
        $('#home').load('<?php echo base_url() ?>home/general', function() {
            $('#tabsTab').tab();
        });

        $('#infraestructura').load('<?php echo base_url() ?>home/infraestructura', function() {
            $('#tabsTab').tab();
        });

        $('#tabsTab').bind('show', function(e) {
            var pattern = /#.+/gi;
            var contentID = e.target.toString().match(pattern)[0];
            $(contentID).load('<?php echo base_url() ?>' + contentID.replace('#', ''), function() {
                $('#tabsTab').tab();
            });
        });
    });
</script>