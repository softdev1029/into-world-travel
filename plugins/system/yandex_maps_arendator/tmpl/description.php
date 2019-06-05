<?php
defined('_JEXEC') or die;
$params = json_decode($object->params ?: '{}');
if (jFactory::getUser()->get('isRoot')) { ?>
    <div class="info">
        <table class="table_days_render table table-stripped table-hover table-bordered table-condensed">
            <tr>
                <th>Информация для админа:</th>
                <td>Объект - <?php echo $object->active ? 'Опубликован' : 'Не опубликован'?></td>
                <td>
                    <a href="<?php echo   JURI::root().'plugins/system/yandex_maps_arendator/connector.php?action='.(!$object->active ? 'public' : 'unpublic').'&id='.$object->id?>"><?php echo !$object->active ? 'Опубликовать' : 'Снять с публикации'?></a>
                    <br><a href="<?php echo   JURI::root().'plugins/system/yandex_maps_arendator/connector.php?action=delete&id='.$object->id?>">Удалить</a>
                </td>
            </tr>
        </table>
    </div>
<?php }

if (!$ballon and $params->images && count($params->images)) { ?>
    <div id="owl-example" class="owl-carousel">
    <?php foreach ($params->images as $image) { ?>
        <div><img src="<?php echo JURI::root().jhtml::_('xdwork.thumb','images/'.$image, 300, 300, 1);?>" alt=""></div>
    <?php } ?>
    </div>
<?php }

$db = jFactory::getDBO();
if (!isset($params->time_variant) or $params->time_variant === 0) {    
    $datetimes = $db->setQuery(
    $q = 'select 
        id,  date_value, time_value, object_id, price,
        (select count(dt2.id) from #__yandex_maps_datetimes as dt2 where dt.date_value = dt2.date_value and dt.time_value = dt2.time_value and dt2.status = 1) as cnt,
        if ((select count(dt4.id) from #__yandex_maps_datetimes as dt4 where dt.date_value = dt4.date_value and dt.time_value = dt4.time_value and dt4.status = 1) > 0 , 1, 0) as status,
        (select count(dt3.id) from #__yandex_maps_datetimes as dt3 where dt.date_value = dt3.date_value and dt.time_value = dt3.time_value and dt3.status = 1 and dt3.book_user='.((int)jFactory::getUser()->id).') as is_my_book

    from #__yandex_maps_datetimes as dt
 
    where dt.object_id='.((int)$object->id).' and dt.date_value > now()
    group by CONCAT(dt.date_value, " ",dt.time_value)
    order by dt.date_value, dt.time_value'
    )->loadObjectList();
} else {
    $periods = $db->setQuery('select * from #__yandex_maps_periods_object where object_id='.((int)$object->id).' order by period_start')->loadObjectList();
    $now = time();
    while($now - time() < 24 * 7 * 3600) {
        $now += 3600;
        foreach($periods as $period) {
            if ($period->{'day'.date('N', $now)}) {
                for ($j = $period->period_start; $j < $period->period_end; $j +=1 ) {

                    $dt = $db->setQuery(
                        'select 
                            dt.*, 
                            (select count(dt2.id) from #__yandex_maps_datetimes as dt2 where dt.date_value = dt2.date_value and dt.time_value = dt2.time_value and dt2.status = 1) as cnt,
                            (select count(dt3.id) from #__yandex_maps_datetimes as dt3 where dt.date_value = dt3.date_value and dt.time_value = dt3.time_value and dt3.status = 1 and dt3.book_user='.((int)jFactory::getUser()->id).') as is_my_book
                        from #__yandex_maps_datetimes as dt
                        where dt.object_id='.((int)$object->id).' and dt.time_value="'.$j.':00" and dt.date_value="'.(date('Y-m-d', $now)).'"
                        group by CONCAT(dt.date_value, " ",dt.time_value)
                        order by dt.date_value, dt.time_value'
                    )->loadObject();

                    $datetimes[date('d.m.Y', $now).'-'.$j] = (object)array(
                        'id' => $dt->id ?: 0,
                        'price' => $params->price,
                        'date_value' => date('d.m.Y', $now),
                        'time_value' => $j.':00',
                        'status' => $dt->status ?: 0,
                        'is_my_book' => $dt->is_my_book,
                        'cnt' => $dt->cnt,
                        'book_user' => $dt->book_user ?: 0,
                    );
                }
            }
        }
    }
}
if (count($datetimes)) { ?>
    <table class="table_days_render table table-stripped table-hover table-bordered table-condensed">
        <tbody>
        <?php
        $dt = '';
        setlocale(LC_ALL, jFactory::getlanguage()->getTag().'.UTF-8');
        foreach ($datetimes as $times) {
            if ($dt !== $times->date_value) {
                $dt = $times->date_value;
                ?>
                <tr>
                    <th colspan="4" class="day"><?php echo JHTML::_('date', strtotime($times->date_value), 'l, j F')?></th>
                </tr>
                <?php
            } ?>
            <tr>
                <td class="time"><?php echo date('H:i', strtotime($times->time_value))?></td>
                <td class="time_status time_price time_status<?php echo $times->status?>"><?php echo !$times->status ? ($times->price ?: $params->price).' '.JText::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_CURRENCY') : '-'?></td>
                <td class="time_status time_status<?php echo $times->status?>"><?php echo jtext::sprintf($statuses[$times->status], !$times->status ? $params->placecount - $times->cnt : $times->cnt, $params->placecount)?></td>
                <td class="time_manage">
                    <?php if (!jFactory::getUser()->id) { 
                        $joomlaLoginUrl = 'index.php?option=com_users&view=login';
                        $finalUrl = JRoute::_($joomlaLoginUrl . '&return='.urlencode(base64_encode(jURI::current())));
                    ?>
                        <a href="<?php echo $finalUrl?>"><?php echo jtext::sprintf('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_LOGIN', $times->price)?></a>
                    <?php } elseif (!$times->status || (!$times->is_my_book and $times->cnt < $params->placecount)) { ?>
                        <a onclick="bookDialog(<?php echo $times->id?>,'<?php echo (int)$object->id?>', '<?php echo $times->date_value?>','<?php echo $times->time_value?>')" href="javascript:void(0)"><?php echo jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_BOOK')?></a>
                    <?php } elseif ($times->is_my_book) { ?>
                        <a onclick="deleteBook('<?php echo $times->object_id?>', '<?php echo $times->date_value?>', '<?php echo $times->time_value?>')" href="javascript:void(0)"><?php echo jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_DELETE_BOOK')?></a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php } ?>