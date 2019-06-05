<?php
defined('_JEXEC') or die;
Jhtml::_('xdwork.includecss', JURI::root().'plugins/system/yandex_maps_arendator/assets/periodpicker/jquery.timepicker.min.css');
Jhtml::_('xdwork.includecss',JURI::root().'plugins/system/yandex_maps_arendator/assets/periodpicker/jquery.periodpicker.min.css');
Jhtml::_('xdwork.includejs',JURI::root().'plugins/system/yandex_maps_arendator/assets/periodpicker/jquery.periodpicker.full.with.tp.min.js');

Jhtml::_('xdwork.includecss',JURI::root().'plugins/system/yandex_maps_arendator/assets/chosen/chosen.css');
Jhtml::_('xdwork.includejs',JURI::root().'plugins/system/yandex_maps_arendator/assets/chosen/chosen.jquery.js');

$input = jFactory::getApplication()->input;
$id = uniqid();
$yma_start_period = '';
if (preg_match('#^[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{2,4}$#', $input->get('yma_start_period'))) {
    $yma_start_period = $input->get('yma_start_period');
}
$yma_end_period = '';
if (preg_match('#^[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{2,4}$#', $input->get('yma_end_period'))) {
    $yma_end_period = $input->get('yma_end_period');
}
?>
<div class="xdsoft_filter_element">
    <label><?php echo JText::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_TAGS_SELECT')?></label>
    <select data-placeholder="<?php echo JText::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_TAGS_SELECT')?>" id="plg_s_yma_tags<?php echo $id?>" multiple=true name="tags">
        <?php
        $db = jFactory::getDBO();
        $type_id = $db->setQuery('select type_id from `#__content_types` where type_alias="com_yandex_maps.object"')->loadResult() ?: 100000;
        $tags = $db->setQuery('select * from #__tags where id in (select tag_id from #__contentitem_tag_map where type_id='.$type_id.')')->loadObjectList();
        foreach ($tags as $tag) { ?>
            <option value="<?php echo $tag->id?>"><?php echo $tag->title?></option>
        <?php } ?>
    </select>
</div>
<div class="xdsoft_filter_element">
    <label><?php echo JText::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_PERIOD')?></label>
    <input value="<?php echo $yma_start_period?>" type="text" id="plg_s_yma_start_period<?php echo $id?>"/>
    <input value="<?php echo $yma_end_period?>"  type="text" id="plg_s_yma_end_period<?php echo $id?>"/>
</div>
<?php if ($params->get('show_filter_times', 1)) { ?>
<div class="xdsoft_filter_element">
    <label><?php echo JText::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_TIMES')?></label>
    <select multiple  data-placeholder="<?php echo JText::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_TIMES')?>" id="plg_s_yma_times<?php echo $id?>"></select>
</div>
<?php } ?>
<script>
(function($){
	var timer,
        loadAffordTime = function (periods) {
            $.post(window.connectorPathURL + 'connector.php', {lang: window.currentLanguage, action: 'affordtime', periods: periods}, function (resp) {
                if (!resp.error) {
                    var select = $('#plg_s_yma_times<?php echo $id?>'),
                        val = select.val();

                    select.empty();
                    resp.data.forEach(function (item) {
                        select.append('<option ' + (val && val.indexOf(item) !== -1 ? 'selected' : '') + ' value="' + item + '">' + item + '</option>');
                    });
                    select.trigger("chosen:updated");
                } else {
                    jAlert(resp.msg);
                }
            }, 'json');
        };
    if (window.map<?php echo $map->id?> === undefined) {
        map<?php echo $map->id?> = new XDsoftMap(<?php echo JHtml::_('map.getOptions', $map, $map->settings)?>);
        var map  = {id : parseInt(<?php echo $map->id?>,10)};
        map<?php echo $map->id?>.setMap(map);
    }
	$('#plg_s_yma_start_period<?php echo $id?>').periodpicker({
        end: '#plg_s_yma_end_period<?php echo $id?>',
        formatDate: 'D.MM.YYYY',
        formatDateTime: 'D.MM.YYYY HH:mm',
        cells: [1, 2],
        timepicker: false,
        lang: '<?php list($lang) = explode('-', jFactory::getLanguage()->getTag()); echo $lang;?>'
    });
    $('#plg_s_yma_start_period<?php echo $id?>,#plg_s_yma_end_period<?php echo $id?>').on('change', function () {
        var periods = [document.getElementById('plg_s_yma_start_period<?php echo $id?>').value, document.getElementById('plg_s_yma_end_period<?php echo $id?>').value];
        map<?php echo $map->id?>.setExtendedFilter('yma_start_period', periods[0]);
        map<?php echo $map->id?>.setExtendedFilter('yma_end_period', (periods[1] && periods[1] !== periods[0]) ? periods[1] : null);
        loadAffordTime(periods);
    });
    
    $('#plg_s_yma_times<?php echo $id?>')
        .chosen()
        .on('change', function () {
            map<?php echo $map->id?>.setExtendedFilter('yma_times', $(this).val());
        });
    
    $('#plg_s_yma_tags<?php echo $id?>')
        .chosen()
        .on('change', function () {
            map<?php echo $map->id?>.setExtendedFilter('yma_tags', $(this).val());
        });

    <?php if ($yma_start_period) { ?>
        map<?php echo $map->id?>.setExtendedFilter('yma_start_period', '<?php echo $yma_start_period?>');
    <?php } ?>
     <?php if ($yma_end_period) { ?>
        map<?php echo $map->id?>.setExtendedFilter('yma_end_period', '<?php echo $yma_end_period?>');
    <?php } ?>
    loadAffordTime(['<?php echo $yma_start_period;?>', '<?php echo $yma_end_period;?>']);
}(window.XDjQuery || window.jQ || window.jQuery))
</script>