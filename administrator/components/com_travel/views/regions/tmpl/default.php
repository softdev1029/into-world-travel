<?php defined('_JEXEC') or die;
 
$hash = md5(time());
$def = 'index.php?option=com_travel';
$ext_list = 'xls,xlsx'; 
  

JHtml::_('behavior.tooltip');
 
JHTML::_('script','system/multiselect.js',false,true);
$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$canOrder	= $user->authorise('core.edit.state', 'com_travel.region');
$saveOrder	= 'a.ordering';
$saveOrder	= $listOrder == 'a.ordering';
if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_travel&task=regions.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
?>
<script type="text/javascript">

Joomla.submitbutton = function(task)
{
    if (task=='regions.import') return false;
   
   Joomla.submitform(task, document.getElementById('adminForm'));  
}

	Joomla.orderTable = function()
	{
		table = document.getElementById("sortTable");
		direction = document.getElementById("directionTable");
		order = table.options[table.selectedIndex].value;
		if (order != '<?php echo $listOrder; ?>')
		{
			dirn = 'asc';
		}
		else
		{
			dirn = direction.options[direction.selectedIndex].value;
		}
		Joomla.tableOrdering(order, dirn, '');
	}
</script>
   <link rel="stylesheet" href="<?php echo aurl()?>modal.css" />
<script src="<?php echo aurl()?>modal.js"></script> 
<script type="text/javascript" src="<?php echo JURI::root()?>administrator/components/com_travel/assets/plupload-2.1.1/js/moxie.js"></script>
<script type="text/javascript" src="<?php echo JURI::root()?>administrator/components/com_travel/assets/plupload-2.1.1/js/plupload.dev.js"></script>

<style type="text/css">

.info_r {
    font-size: 13px;
    padding: 0px 0 8px 0;
    display: block;
    font-weight: bold;
}

#info {background: #04934B;
    border: 1px solid #036835;
    border-radius: 4px;
    color: #73FBB7;
    display: inline-block;
    text-align: center;
    padding: 2px 7px 1px 7px;
      margin-left: 6px;
    float: left;
}
#info span {color:#fff;}

.procent { border: 1px solid #CCCCCC;
    border-radius: 7px;
    height: 29px;
    position: relative;
    width: 200px;
    display:none;
}
.procent span {display:block;    
 border-radius: 4px; height:29px; position:absolute;
  top:0px; left:0px; background-color: #0483B1; width:10px}
.procent i { display: block;
    font-size: 15px;
    font-style: normal;
    font-weight: bold;
    position: relative;
    text-align: center;
    top: 5px;}
    #toolbar-export .icon-export 
  #toolbar-import .icon-import{  
        font-size: 15px;
        }
    
#toolbar-import .icon-import:before {
    content: "\27";
    position: relative;
    top: 2px;
    
    }
    #toolbar-export .icon-export:before {
    content: "\28";
    position: relative;
    top: 2px;
    
    }
 
#filelist {
    
        display: inline-block;
    padding: 3px 10px;
    border-radius: 7px;
   
    left: 118px;
    height: 15px;
    min-width: 100px;
    
background-color: #fff;
    border: 1px solid #ccc;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
    -moz-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
    -webkit-transition: border linear .2s, box-shadow linear .2s;
    -moz-transition: border linear .2s, box-shadow linear .2s;
    -o-transition: border linear .2s, box-shadow linear .2s;
    transition: border linear .2s, box-shadow linear .2s;
}
#container {
      position: relative;
    float: left;
    min-width: 200px; 
}
   
  .info_pan
  {
    color: #545455;
    font-size: 12px;
    font-style: italic;
    padding: 1px;
  } 
   .info_pan a {
      color: #545455;
    font-size: 12px;
    font-style: italic;
    text-decoration:underline;
   }
</style>  

<form action="<?php echo JRoute::_('index.php?option=com_travel&view=regions'); ?>" method="post" name="adminForm" id="adminForm">
	
    
<div id="j-main-container">
 	<div id="filter-bar" class="btn-toolbar">
    
		 
         <div class="filter-search btn-group pull-left">
				<label for="filter_search" class="element-invisible">Поиск по названию</label>
				<input type="text" name="filter_search" placeholder="Поиск по названию" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_CONTENT_FILTER_SEARCH_DESC'); ?>" />
			</div>
               
       	<div class="btn-group pull-left hidden-phone">
				<button class="btn tip hasTooltip" type="submit" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
				<button class="btn tip hasTooltip" type="button" onclick="document.id('filter_search').value='';this.form.submit();" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>"><i class="icon-remove"></i></button>
			</div> 
         
	 <div class="btn-group pull-right hidden-phone">
				<select name="filter_pol" class="inputbox" onchange="this.form.submit()">
				<option value="">Все</option>
				<?php echo JHtml::_('select.options',  FILTER_HTML::type(), 'value', 'text', $this->state->get('filter.pol'), true);?>
			</select>
			<select name="filter_published" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions', array('archived' => 0, 'trash' => 0)), 'value', 'text', $this->state->get('filter.state'), true);?>
			</select>
				<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
				<?php echo $this->pagination->getLimitBox(); ?>
		 

		</div>
        
         
	</div>
    
	<div class="clr"> </div>
	<table class="table table-striped" id="articleList">
<thead>
	<tr>
		 <th width="1%" class="hidden-phone">
			   <input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
		       </th><th width="1%" nowrap="nowrap">
			<?php echo JHtml::_('grid.sort', 'ID', 'a.id', $listDirn, $listOrder); ?>
		    </th>

     	<th width="1%"  class="nowrap center hidden-phone">
	    <?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'a.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
	    </th>
<th width="20%" align="center" style='text-align:center'>
	   <?php echo JHtml::_('grid.sort', 'title', 'a.title', $listDirn, $listOrder); ?>
       </th>
       <th width="20%" align="center" style='text-align:center'>
	   <?php echo JHtml::_('grid.sort', 'Страна', 'a.country', $listDirn, $listOrder); ?>
       </th>
<th width="20%" align="center" style='text-align:center'>
	   <?php echo JHtml::_('grid.sort', 'published', 'a.published', $listDirn, $listOrder); ?>
       </th>
	</tr>
</thead>

<tbody>
<?php foreach ($this->items as $i => $item) {
    
   
    
$ordering	= ($listOrder == 'a.ordering');
$linkEdit	= JRoute::_('index.php?option=com_travel&task=region.edit&id='.$item->id);

$canCheckin	= $user->authorise('core.manage',		'com_checkin') || $item->checked_out==$user->get('id') || $item->checked_out==0;
$canChange	= $user->authorise('core.edit.state',	'com_travel.region'.$item->id);
$canCreate	= $user->authorise('core.create',		'com_travel.region'.$item->id);
?>
<tr class="row<?php echo $i % 2; ?>" sortable-group-id="0">
	
     <td>
		   <?php echo JHtml::_('grid.id', $i, $item->id); ?>
	       </td><td class="center"><?php echo (int) $item->id; ?></td>
<td class="order nowrap center hidden-phone">
					<?php if ($canChange) :
						$disableClassName ='';
						$disabledLabel	  = '';

						if (!$saveOrder) :
							$disabledLabel    = JText::_('JORDERINGDISABLED');
							$disableClassName = 'inactive tip-top';
						endif; ?>
						<span class="sortable-handler hasTooltip <?php echo $disableClassName; ?>" title="<?php echo $disabledLabel; ?>">
							<i class="icon-menu"></i>
						</span>
						<input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->ordering; ?>" class="width-20 text-area-order " />
					<?php else : ?>
						<span class="sortable-handler inactive" >
							<i class="icon-menu"></i>
						</span>
					<?php endif; ?>
					</td>

     <td><center>
	<?php  
		echo '<a href="'. JRoute::_($linkEdit).'">'. $this->escape($item->title).'</a>';
        
        
        if ($item->proc){
        
        $p = $item->proc;
        if (strpos($item->proc,'%')===false)
        {
           $p =  travel::pr($item->proc, '', false);
        }
        
        
        
        
        echo "<span style='    margin-left: 16px;
    background: ".( (float)$item->proc >0 ? '#35633f' : '#ec1616').";
    color: #fff;
        padding: 3px 9px;
    border-radius: 10px;'>Наценка: ".$p."</span>";
        }
	  ?></center>
	</td>
    
    
    <td>
    <?=$item->country_title?>
    </td>
    
 <td class="center"><?php echo JHtml::_('jgrid.published', $item->published, $i, 'regions.', $canChange); ?></td>
	 
</tr>
<?php } ?>
</tbody>
			
<tfoot>
	<tr>
		<td colspan="11">
			<?php echo $this->pagination->getListFooter(); ?>
		</td>
	</tr>
</tfoot>
</table>

<input type="hidden" name="task" value="" />
<input type="hidden" name="option" value="com_travel" />
 
 
 
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
<?php echo JHtml::_('form.token'); ?>
</form>



<div id="layer-create-popup" style="max-width:700px"  class="white-popup mfp-hide">
  <div class="reg_form">
  
  <form action="index.php" class="content-form" method="post" id="uploadform" 
onsubmit="return false;"  >
  
  <h2 style="margin: 0px;">Импорт Регионов из MS EXCEL</h2>
  <span class="info_r"></span>
 
 <?php
  $db=JFactory::getDBO();
  $q = 'SELECT data FROM #__travel_hash WHERE t=3 ORDER BY data DESC';
  $db->setQuery($q);
  $row = $db->LoadObject();
  
 
   $q = 'SELECT COUNT(*) FROM #__travel_region';
   $db->setQuery($q);
   $kol = $db->LoadResult();
 
 ?>
 
  <p style="line-height: 0.96;">
 
   В базе присутствует <strong style="<?=($kol) ? 'color:red' : ''?>"><?=$kol?></strong> регионов <br />
   <?php if ($row): ?>
   Последний импорт был произведён <?=date('d.m.Y H:i',$row->data)?>
   <?php else: ?>
 Импорт ещё ни разу не был произведён
   <?php endif; ?>
   </p>
 

 	<div class="row-fluid">
 <div class="span5">
 
   <div style="position: relative;">
    <label>Выберите файл:</label>
    <div id="container">
    <div style="    position: relative;
    z-index: 1;
    float: left;
    margin-right: 5px;" id="pickfiles" class="btn btn-small">Выбрать</div>
    <div id="filelist" style="margin-right: 5;">&nbsp;</div> 
    </div>
    
    <div id="info">
    <span id="was">0</span> / 
    <span id="max">0</span>
    </div>
     <div style="clear: both;"></div>
   </div> 
  
    <div class="info_pan"  >
  Максимальный размер файла 50мб. <br />
  Допустимые форматы файлов xls, xlsx
  <br />
  Пример <a href="<?=JURI::root()?>administrator/components/com_travel/assets/primer2.xlsx">файла для импорта</a>
  </div>

<br />
  <div style="margin-bottom: 0px;"> 
<div id="procent" class='procent'>

<span  id='s'></span>
<i id='pr'>1</i>
</div>
     </div>
<pre style="display: none;" id="console"></pre>
 
<div class="error_info" style="    color: red;
    margin: 0px;
    padding: 0px;">
 
</div>

   <button   id="subr"   class="btn btn-small">
	<span class="icon-publish"></span>
	Импортировать</button>
    
    <button id="close_open" class="btn btn-small">
	<span class="icon-unpublish"></span>
Закрыть</button>
</div>


 
</div>

</form>


  </div>
  </div>
<!------------------------------------------>


<script type="text/javascript">


 jQuery(document).ready(function(){
    
    
     
    
    
    
    jQuery(document).on('click', '#close_open', function () {
    jQuery.magnificPopup.close();
    return false;
    });
    
     jQuery(document).on('click', '#close_open2', function () {
    jQuery.magnificPopup.close();
    return false;
    });
    
     
     
    jQuery(document).on('click', '#delete_save', function () { 
     var file = jQuery('#file').val('');
   
    
    var btn = jQuery('#delete_save').html();
    
jQuery('#delete_save').html('<span class="icon-delete"></span> Удаление...');

    	
    
  var m_data = 'file='+file;
   jQuery.ajax({
   type: "GET",
   url:  '<?php echo $def."&task=deletesave&t=3"?>',
   data: m_data, 
   success: function(html){
    var res = JSON.parse(html);
    jQuery('#delete_save').html(btn);   
   
    }
    
 }); 
 
    return false;   
    });
    
    
 //Вызвать окно 
  jQuery(document).on('click', '#toolbar-import', function () { 
   
   
   jQuery.magnificPopup.open({
  items: {
    src:  '#layer-create-popup'
  },
  type: 'inline',
  callbacks: {
    open: function() {
   
    
    
    },
    close: function() {
    
 
    
    }
    // e.t.c.
  }
 });
     return false;
  });//======================================================  
  
   });


    function trim( str, charlist ) { 
 
 
	charlist = !charlist ? ' \s\xA0' : charlist.replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g, '\$1');
	var re = new RegExp('^[' + charlist + ']+|[' + charlist + ']+$', 'g');
	return str.replace(re, '');
 }

var uploader = new plupload.Uploader({
	runtimes : 'html5,flash,silverlight,html4',
	browse_button : 'pickfiles', // you can pass in id...
	container: document.getElementById('container'), // ... or DOM Element itself
	url : '<?php echo $def."&task=upload&t=3&hash=".$hash?>',
	flash_swf_url : '<?=URL?>plupload-2.1.1/js/Moxie.swf',
	silverlight_xap_url : '<?=URL?>plupload-2.1.1/js/Moxie.xap',
	
	filters : {
		max_file_size : '50mb',
		mime_types: [
			{title : "Видео", extensions : "<?php echo $ext_list ?>"}
		]
	},

	init: {
		PostInit: function() {
    
			document.getElementById('filelist').innerHTML = '';


//Два иморта в одном
   document.getElementById('subr').onclick = function() {
	 
     
     //var filetext = document.getElementById('file').value;
     
     
     
     if (document.getElementById('filelist').innerHTML==''  )
     {
        alert('Выберите файл');
     }
     else if (document.getElementById('filelist').innerHTML!='') {
    document.getElementById('procent').style.display = 'block';
    document.getElementById('subr').value = '...'
    
    	document.getElementById('s').style.width = '0px';
            document.getElementById('pr').innerHTML = '0%';
    
             document.getElementById('subr').disabled = true;
				uploader.start();
    
				return false;
                }
                else
                {
                    
  
                    
                  
                }
                
                
                
			};
		},

		FilesAdded: function(up, files) {
			plupload.each(files, function(file) {
				document.getElementById('filelist').innerHTML = '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
			});
		},

FileUploaded:function(up, file) {
    
    
    document.getElementById('procent').style.display = 'none';
     start_import();
       // document.getElementById('rolik').submit();
    
},

		UploadProgress: function(up, file) {
		  
          	document.getElementById('s').style.width = file.percent*2+'px';
            document.getElementById('pr').innerHTML = file.percent+'%';
            
             
		},

		Error: function(up, err) {
			document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
		}
	}
});

uploader.init();


function start_import()
{
    jQuery('#max').html('..');
   m_data = '';
   jQuery.ajax({
   type: "GET",
   url:  '<?php echo $def."&task=import2&start=1&hash=".$hash?>',
   data: m_data, 
   success: function(html){
    var res = JSON.parse(html);
   
    if (res.status==0)
    {alert(res.error);}
   else {
   jQuery('#was').html(0);  
   jQuery('#max').html(res.max);
   jQuery('.info_r').html('Идёт импорт данных');
  
   
   	repeat_import();
  
   }
   
    }
    
 }); 
}
// использование Math.round() даст неравномерное распределение!
function getRandomInt(min, max)
{
  return Math.floor(Math.random() * (max - min + 1)) + min;
}

function repeat_import() {
    
    
    var rand = getRandomInt(9999,99999999);
	jQuery.ajax({
			url: "<?php echo $def."&task=import2&start=0&hash=".$hash?>&rand"+rand,
			timeout: 50000,
			success: function(data, textStatus){
					  var res = JSON.parse(data);
				 	if (res.end == 1) {
				 	  
                       jQuery('#was').html(res.kol);
                      jQuery('.info_r').css('color','green')
				 	    jQuery('.info_r').html('Импорт успешно выполнен');
                        
                        jQuery('#subr').removeAttr('disabled');
                         jQuery('#filelist').html('');
                        
                       }
                      else
                      {
                       jQuery('#was').html(res.kol);
                       repeat_import();   
                      }
						//jQuery("#content").html("<h2>Импорт завершен!</h2>");
					//	}
					//	else {
						//jQuery("#content").html("<p>" + data + "</p>");
							//repeat_import();
					//	}	
                    
                  
                    
                    	
					},
			complete: function(xhr, textStatus){
						if (textStatus != "success") {
						    repeat_import();		
                        }
					}
	});
 }

 
 
</script>