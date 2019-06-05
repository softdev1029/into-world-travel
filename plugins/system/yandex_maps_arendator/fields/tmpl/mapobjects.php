<?php
defined('JPATH_PLATFORM') or die;
JHtml::addIncludePath(JPATH_ROOT.'/components/com_yandex_maps/helpers');

JHtml::_('jquery.framework');
JHtml::_('xdwork.dialog');
jhtml::_('xdwork.datetimepicker');

Jhtml::_('xdwork.includejs', JURI::root().'plugins/system/yandex_maps_arendator/assets/jodit/jodit.min.js');
Jhtml::_('xdwork.includejs', JURI::root().'plugins/system/yandex_maps_arendator/assets/profile.js');


Jhtml::_('xdwork.includecss', JURI::root().'plugins/system/yandex_maps_arendator/assets/jodit/jodit.min.css');
Jhtml::_('xdwork.includecss', JURI::root().'plugins/system/yandex_maps_arendator/assets/style.css');

if (!jFactory::getApplication()->isAdmin()) {
Jhtml::_('xdwork.includecss',JURI::root().'plugins/system/yandex_maps_arendator/assets/chosen/chosen.css');
Jhtml::_('xdwork.includejs',JURI::root().'plugins/system/yandex_maps_arendator/assets/chosen/chosen.jquery.js');
}

include_once JPATH_ROOT.'/administrator/components/com_yandex_maps/helpers/CModel.php';
JModelLegacy::addIncludePath(JPATH_ROOT.'/administrator/components/com_yandex_maps/models/');
$categories = JModelLegacy::getInstance('Maps', 'Yandex_MapsModel')->model(1)->categories;
?>

<div style="margin:10px 0;">
    <button type="button" onclick="addObject()" class="btn btn-primary"><?php echo jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_ADD_OBJECT');?></button>
</div>

<table id="objects" class="table table-stripped table-hover table-bordered">
    <thead>
        <tr>
            <th><?php echo jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_OBJECT_NAME');?></th>
            <th><?php echo jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_OPERATION');?></th>
        </tr>
    </thead>
    <tbody>
        
    </tbody>
</table>

<div id="objectappenddialog">
    <fieldset>
        <div class="control-group">
            <label><?php echo jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_OBJECT_NAME');?></label>
            <input class="like" id="object_title" name="object[title]" type="text" placeholder="<?php echo jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_ENTER_OBJECT_NAME');?>">
        </div>
        <div class="control-group">
            <label><?php echo jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_OBJECT_DESCRIPTION');?></label>
            <textarea id="object_description" name="object[description]" placeholder="<?php echo jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_ENTER_OBJECT_DESCRIPTION');?>" type="text"></textarea>
         </div>
        <div class="control-group">
            <div id="uploaderbox"><?php echo jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_DRAG_AND_DROP_FILES_HERE');?><input accept="image/*" tabindex="-1" dir="auto" multiple="" type="file"/></div>
            <div id="images" class="images"></div>
        </div>
        <div class="control-group">
            <label><?php echo jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_TAGS');?></label>
            <?php
            $form = new JForm('name');
            $media = JFormHelper::loadFieldType('tag', true);
            $media->setForm($form); // $this->form можно заменить на new JForm('name')
            $media->setup(simplexml_load_string('<field name="tags" type="tag" class="span6" multiple="true"/>'), null);
            echo $media->getInput();
            ?>
        </div>
        <div class="control-group">
            <label><?php echo jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_OBJECT_PRICE');?></label>
            <input class="like" id="object_price" name="object[price]" type="text" placeholder="<?php echo jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_ENTER_OBJECT_PRICE');?>">
            <span class="help-block"><?php echo jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_ENTER_OBJECT_PRICE_HINT');?></span>
        </div>
        <div class="control-group">
            <label><?php echo jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_OBJECT_PLACECOUNT');?></label>
            <input class="like" id="object_placecount" name="object[placecount]" type="text" placeholder="<?php echo jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_ENTER_OBJECT_PLACECOUNT');?>">
            <span class="help-block"><?php echo jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_ENTER_OBJECT_PLACECOUNT_HINT');?></span>
        </div>
        <?php if ($params->get('time_variant' , 1) == 2) { ?>
        <div class="control-group">
            <label><?php echo jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_TIME_VARIANT_PERIODS_AND_DATETIMES_LABEL');?></label>
            <select id="time_variant">
                <option value="0"><?php echo jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_TIME_VARIANT_DATETIMES_OPTION');?></option>
                <option value="1"><?php echo jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_TIME_VARIANT_PERIODS_OPTION');?></option>
            </select>
        </div>
        <?php } ?>
        <?php if ($params->get('time_variant' , 1) == 0 || $params->get('time_variant' , 1) == 2) { ?>
        <div id="time_variant0" class="control-group">
            <label><?php echo jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_OBJECT_HOURS');?></label>
            <div id="timer" class="timer">
                <a class="timer_add_day" href="javascript:void(0)"><?php echo jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_ADD_DAY');?></a>
                <div class="timer_popap">
                    <div class="input-append">
                        <input class="span2 datepicker" type="text">
                        <button type="button" class="btn addday"><?php echo jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_ADD');?></button>
                    </div>
                </div>
                <table class="table_days table table-stripped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th><?php echo jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_DAY');?></th>
                            <th><?php echo jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_HOURS');?></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <?php } ?>
        <?php if ($params->get('time_variant' , 1) == 1 || $params->get('time_variant' , 1) == 2) { ?>
        <div id="time_variant1" class="control-group">
            <label><?php echo jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_PERIOD_TABLE');?></label>
            <div class="yma_periods_info"><?php echo jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_PERIOD_INFO');?></div>
            <table id="periods" class="yma_periods">
                <?php for ($i = 1; $i <= 7; $i +=1) { ?>
                <tr class="<?php echo $i < 6 ? 'yma_periods_workdays' : 'yma_periods_weekends' ?>">
                    <td class="yma_periods_select_all_of_day">
                        <span><?php echo jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_PERIOD_TABLE_DAY_'.$i);?></span>
                        <input type="checkbox"/>
                    </td>
                    <?php for ($j = 0; $j < 24; $j +=1) { ?>
                    <td class="yma_periods_time"><input class="yma_periods_time<?php echo $i.'_'.$j; ?>" value="<?php echo $i.'-'.$j; ?>" type="checkbox"/></td>
                    <?php } ?>
                </tr>
                <?php } ?>
                <tr class="yma_periods_select_all_of_time">
                    <td>
                        <span><?php echo jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_PERIOD_ALL');?></span>
                        <input class="yma_periods_select_all" type="checkbox"/>
                    </td>
                    <?php for ($j = 0; $j < 24; $j +=1) { ?>
                    <td class="yma_periods_select_all_of_time_full">
                        <input value="<?php echo $j; ?>" type="checkbox"/>
                        <span><?php echo $j < 10 ? '0'.$j : $j; ?></span>
                        <span><?php echo $j + 1 < 10 ? '0'.($j + 1) : $j + 1; ?></span>
                    </td>
                    <?php } ?>
                </tr>
            </table>
        </div>
        <?php } ?>
        <?php if ($params->get('types')) { ?>
        <div class="control-group">
            <label><?php echo jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_TYPES');?></label>
            <select name="types"  data-placeholder="<?php echo JText::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_SELECT_TYPE')?>" class="<?php echo !jFactory::getApplication()->isAdmin() ? 'notadmin' : ''?>" id="types">
                <?php 
                    $types = preg_split('/[\n\r]+/', $params->get('types'));
                    foreach ($types as $type) {
                        $type = explode('%%', $type);
                        ?>
                        <option value="<?php echo $type[1]?>"><?php echo $type[0]?></option>
                        <?php
                    }
                ?>
            </select>
        </div>
        <?php } ?>
        <div class="control-group">
            <label><?php echo jtext::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_CATEGORY');?></label>
            <select name="categories" multiple  data-placeholder="<?php echo JText::_('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_SELECT_CATEGORIES')?>" class="<?php echo !jFactory::getApplication()->isAdmin() ? 'notadmin' : ''?>" id="categories">
                <?php 
                    foreach ($categories as $category) { ?>
                        <option value="<?php echo $category->id?>"><?php echo $category->title?></option>
                    <?php }
                ?>
            </select>
        </div>
        <div class="control-group">
            <?php echo jhtml::_('xdwork.address', 'location', 'null', array('autocomplete'=>0, 'autoinit'=> 0, 'width' => 500));?>
        </div>
        <input type="hidden" id="object_id" name="object[id]"/>
        <input type="hidden" id="user_id" value="<?php echo $user_id?>" name="object[user_id]"/>
    </fieldset>
</div>
<script>saveHtml();</script>