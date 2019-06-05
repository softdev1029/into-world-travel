<?php
/**
 * Tag Meta Community component for Joomla
 *
 * @author selfget.com (info@selfget.com)
 * @package TagMeta
 * @copyright Copyright 2009 - 2017
 * @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link http://www.selfget.com
 * @version 1.9.0
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');

// Load the tooltip behavior
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

// Define robots option labels
$robotsOption = array('0' => JText::_('COM_TAGMETA_FIELD_RULE_ROBOTS_OPTION_NO'), '1' => JText::_('COM_TAGMETA_FIELD_RULE_ROBOTS_OPTION_YES'), '2' => JText::_('COM_TAGMETA_FIELD_RULE_ROBOTS_OPTION_SKIP'));

// Add tooltip style
$document = JFactory::getDocument();
$document->addStyleDeclaration( '.tip-text {word-wrap: break-word !important; word-break: break-all !important;}' );
$document->addStyleDeclaration( '.jrules td {padding: 0 10px 2px 0 !important; border: none !important;}' );

$user = JFactory::getUser();
$userId = $user->get('id');
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));
$canOrder = $user->authorise('core.edit.state');
$saveOrder = $listOrder=='a.ordering';
if ($saveOrder)
{
  $saveOrderingUrl = 'index.php?option=com_tagmeta&task=rules.saveOrderAjax&tmpl=component';
  JHtml::_('sortablelist.sortable', 'ruleList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
$sortFields = $this->getSortFields();
?>
<script type="text/javascript">
  Joomla.orderTable = function() {
    table = document.getElementById("sortTable");
    direction = document.getElementById("directionTable");
    order = table.options[table.selectedIndex].value;
    if (order != '<?php echo $listOrder; ?>') {
      dirn = 'asc';
    } else {
      dirn = direction.options[direction.selectedIndex].value;
    }
    Joomla.tableOrdering(order, dirn, '');
  }
  Joomla.submitbutton = function(pressbutton) {
  var form = document.adminForm;
    if (pressbutton == 'rules.resetstats') {
        if ( confirm("<?php echo JText::_('COM_TAGMETA_RESET_STATS_CONFIRM', false); ?>") ) {
            Joomla.submitform('rules.resetstats');
        }
    } else {
        Joomla.submitform(pressbutton);
    }
  }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_tagmeta&view=rules'); ?>" method="post" name="adminForm" id="adminForm">
  <?php if (!empty( $this->sidebar)) : ?>
    <div id="j-sidebar-container" class="span2">
    <?php echo $this->sidebar; ?>
    </div>
    <div id="j-main-container" class="span10">
  <?php else : ?>
    <div id="j-main-container">
  <?php endif;?>
    <?php
    // Search tools bar
    echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this));
    ?>
    <table class="table table-striped" id="ruleList">
      <thead>
        <tr>
          <th width="5%" class="center hidden-phone">
            <?php echo JText::_('COM_TAGMETA_NUM'); ?>
          </th>
          <th width="5%" class="nowrap center hidden-phone">
            <?php if ($canOrder && $saveOrder): ?>
            <?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'a.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
            <?php endif; ?>
          </th>
          <th width="5%" class="center hidden-phone">
            <input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
          </th>
          <th width="5%" class="nowrap center">
            <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_PUBLISHED', 'a.published', $listDirn, $listOrder); ?>
          </th>
          <th width="15%">
            <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_URL', 'a.url', $listDirn, $listOrder); ?>
            <br />
            <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_SKIP', 'a.skip', $listDirn, $listOrder); ?>
            <br />
            <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_COMMENT', 'a.comment', $listDirn, $listOrder); ?>
          </th>
          <th width="15%" class="center">
            <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_CASE_SENSITIVE', 'a.case_sensitive', $listDirn, $listOrder); ?>
            <br />
            <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_REQUEST_ONLY', 'a.request_only', $listDirn, $listOrder); ?>
            <br />
            <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_DECODE_URL', 'a.decode_url', $listDirn, $listOrder); ?>
            <br />
            <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_LAST_RULE', 'a.last_rule', $listDirn, $listOrder); ?>
            <br />
            <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_PRESERVE_TITLE', 'a.preserve_title', $listDirn, $listOrder); ?>
            <br />
            <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_SYNONYMS', 'a.synonyms', $listDirn, $listOrder); ?>
          </th>
          <th width="20%" class="center">
            <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_TITLE', 'a.title', $listDirn, $listOrder); ?>
            /
            <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_DESCRIPTION', 'a.description', $listDirn, $listOrder); ?>
            <br />
            <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_AUTHOR', 'a.author', $listDirn, $listOrder); ?>
            /
            <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_KEYWORDS', 'a.keywords', $listDirn, $listOrder); ?>
            <br />
            <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_RIGHTS', 'a.rights', $listDirn, $listOrder); ?>
            /
            <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_XREFERENCE', 'a.xreference', $listDirn, $listOrder); ?>
            <br />
            <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_CANONICAL', 'a.canonical', $listDirn, $listOrder); ?>
            /
            <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_CUSTOM_HEADER', 'a.custom_header', $listDirn, $listOrder); ?>
          </th>
          <th width="10%" class="center">
            <?php echo JText::_('COM_TAGMETA_HEADING_RULES_ROBOTS'); ?>
          </th>
          <th width="5%" class="center">
            <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_HITS', 'a.hits', $listDirn, $listOrder); ?>
          </th>
          <th width="10%" class="center">
            <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_LAST_VISIT', 'a.last_visit', $listDirn, $listOrder); ?>
          </th>
          <th width="5%" class="nowrap center hidden-phone">
            <?php echo JHTML::_('grid.sort', 'COM_TAGMETA_HEADING_RULES_ID', 'a.id', $listDirn, $listOrder); ?>
          </th>
        </tr>
      </thead>
      <tbody>
      <?php
        if( count( $this->items ) > 0 ) {
          foreach ($this->items as $i => $item) :
            $ordering   = ($listOrder == 'a.ordering');
            $canCreate  = $user->authorise('core.create',     'com_tagmeta.rule');
            $canEdit    = $user->authorise('core.edit',       'com_tagmeta.rule.'.$item->id);
            $canCheckin = $user->authorise('core.manage',     'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
            $canChange  = $user->authorise('core.edit.state', 'com_tagmeta.rule.'.$item->id) && $canCheckin;
            $item_link = JRoute::_('index.php?option=com_tagmeta&task=rule.edit&id='.(int)$item->id);
      ?>
        <tr class="row<?php echo $i % 2; ?>" sortable-group-id="<?php echo $item->ordering; ?>">
          <td class="center hidden-phone">
            <?php echo $this->pagination->getRowOffset( $i ); ?>
          </td>
          <td class="order nowrap center hidden-phone">
          <?php if ($canChange) :
            $disableClassName = '';
            $disabledLabel    = '';

            if (!$saveOrder) :
              $disabledLabel    = JText::_('JORDERINGDISABLED');
              $disableClassName = 'inactive tip-top';
            endif;
          ?>
            <span class="sortable-handler hasTooltip <?php echo $disableClassName; ?>" title="<?php echo $disabledLabel; ?>">
              <i class="icon-menu"></i>
            </span>
            <input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->ordering; ?>" class="width-20 text-area-order" />
          <?php else : ?>
            <span class="sortable-handler inactive" >
              <i class="icon-menu"></i>
            </span>
          <?php endif; ?>
          </td>
          <td class="center hidden-phone">
            <?php echo JHtml::_('grid.id', $i, $item->id); ?>
          </td>
          <td class="center">
            <div class="btn-group">
              <?php echo JHtml::_('jgrid.published', $item->published, $i, 'rules.', $canChange, 'cb'); ?>
            </div>
          </td>
          <td class="small">
            <span style="display:block; word-wrap:break-word; word-break: break-all;">
            <?php if ($item->checked_out) : ?>
              <?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'rules.', $canCheckin); ?>
            <?php endif; ?>
            <?php
              $max_chars = 100;
              $item_url = TagMetaHelper::trimText($item->url, $max_chars);
              if ($canEdit) : ?>
                <a href="<?php echo $item_link; ?>" title="<?php echo JText::_('COM_TAGMETA_EDIT_ITEM'); ?>"><?php echo $this->escape($item_url); ?></a>
              <?php else : ?>
                <span title="<?php echo JText::sprintf('COM_TAGMETA_HEADING_RULES_URL', $this->escape($item_url)); ?>"><?php echo $this->escape($item_url); ?></span>
              <?php endif; ?>
            </span>
            <span style="display:block; word-wrap:break-word; word-break: break-all;">
            <?php
              $max_chars = 100;
              $item_skip = TagMetaHelper::trimText($item->skip, $max_chars);
              if ($canEdit) : ?>
                <a href="<?php echo $item_skip; ?>" title="<?php echo JText::_('COM_TAGMETA_EDIT_ITEM'); ?>"><?php echo $this->escape($item_skip); ?></a>
              <?php else : ?>
                <span title="<?php echo JText::sprintf('COM_TAGMETA_HEADING_RULES_SKIP', $this->escape($item_skip)); ?>"><?php echo $this->escape($item_skip); ?></span>
              <?php endif; ?>
            </span>
            <br />
            <div style="border: 1px dashed silver; min-height: 30px; word-wrap: break-word; word-break: break-all;" class="hasTooltip" title="<?php echo JHtml::tooltipText('COM_TAGMETA_FIELD_RULES_COMMENT_LABEL', $item->comment); ?>">
              <?php
                $max_chars = 100;
                echo TagMetaHelper::trimText(htmlspecialchars($item->comment, ENT_QUOTES), $max_chars);
              ?>
            </div>
          </td>
          <td class="small">
            <table class="jrules">
            <?php echo '<tr><td>'.JText::_('COM_TAGMETA_FIELD_RULES_CASE_SENSITIVE_LABEL').'</td>';
            if ($item->case_sensitive) {
              $jtask = 'rules.case_off'; $jtext = JText::_( 'JYES' ); $jstate = 'publish';
            } else {
              $jtask = 'rules.case_on'; $jtext = JText::_( 'JNO' ); $jstate = 'unpublish';
            } ?>
            <td><div class="btn-group"><a class="btn btn-micro active" href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i; ?>','<?php echo $jtask; ?>')" title="<?php echo $jtext; ?>"><i class="icon-<?php echo $jstate; ?>"></i></a></div></td></tr>
            <?php echo '<tr><td>'.JText::_('COM_TAGMETA_FIELD_RULES_REQUEST_ONLY_LABEL').'</td>';
            if ($item->request_only) {
              $jtask = 'rules.request_off'; $jtext = JText::_( 'JYES' ); $jstate = 'publish';
            } else {
              $jtask = 'rules.request_on'; $jtext = JText::_( 'JNO' ); $jstate = 'unpublish';
            } ?>
            <td><div class="btn-group"><a class="btn btn-micro active" href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i; ?>','<?php echo $jtask; ?>')" title="<?php echo $jtext; ?>"><i class="icon-<?php echo $jstate; ?>"></i></a></div></td></tr>
            <?php echo '<tr><td>'.JText::_('COM_TAGMETA_FIELD_RULES_DECODE_URL_LABEL').'</td>';
            if ($item->decode_url) {
              $jtask = 'rules.decode_off'; $jtext = JText::_( 'JYES' ); $jstate = 'publish';
            } else {
              $jtask = 'rules.decode_on'; $jtext = JText::_( 'JNO' ); $jstate = 'unpublish';
            } ?>
            <td><div class="btn-group"><a class="btn btn-micro active" href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i; ?>','<?php echo $jtask; ?>')" title="<?php echo $jtext; ?>"><i class="icon-<?php echo $jstate; ?>"></i></a></div></td></tr>
            <?php echo '<tr><td>'.JText::_('COM_TAGMETA_FIELD_RULES_LAST_RULE_LABEL').'</td>';
            if ($item->last_rule) {
              $jtask = 'rules.last_off'; $jtext = JText::_( 'JYES' ); $jstate = 'publish';
            } else {
              $jtask = 'rules.last_on'; $jtext = JText::_( 'JNO' ); $jstate = 'unpublish';
            } ?>
            <td><div class="btn-group"><a class="btn btn-micro active" href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i; ?>','<?php echo $jtask; ?>')" title="<?php echo $jtext; ?>"><i class="icon-<?php echo $jstate; ?>"></i></a></div></td></tr>
            <?php echo '<tr><td>'.JText::_('COM_TAGMETA_FIELD_RULES_PRESERVE_TITLE_LABEL').'</td>';
            if ($item->preserve_title) {
              $jtask = 'rules.preserve_off'; $jtext = JText::_( 'JYES' ); $jstate = 'publish';
            } else {
              $jtask = 'rules.preserve_on'; $jtext = JText::_( 'JNO' ); $jstate = 'unpublish';
            } ?>
            <td><div class="btn-group"><a class="btn btn-micro active" href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i; ?>','<?php echo $jtask; ?>')" title="<?php echo $jtext; ?>"><i class="icon-<?php echo $jstate; ?>"></i></a></div></td></tr>
            <tr><td><?php echo JText::_('COM_TAGMETA_FIELD_RULES_PLACEHOLDERS_LABEL') . '&nbsp;' . JHTML::tooltip(nl2br($item->placeholders), JText::_('COM_TAGMETA_FIELD_RULES_PLACEHOLDERS_LABEL'), 'tooltip.png', '', ''); ?></td><td><?php echo count(array_filter(explode("\n", trim($item->placeholders)))); ?></td></tr>
            <?php $synonyms_settings = JText::_('COM_TAGMETA_FIELD_RULES_SYNONYMS_MAX_LABEL') . ' ' . $item->synonmax . ' / ' . (($item->synonweight) ? JText::_('COM_TAGMETA_FIELD_RULES_SYNONYMS_WEIGHT_LABEL') : JText::_('COM_TAGMETA_FIELD_RULES_SYNONYMS_ORDERING_LABEL'));
            echo '<tr><td>'.JText::_('COM_TAGMETA_FIELD_RULES_SYNONYMS_LABEL').'&nbsp;'.JHTML::tooltip($synonyms_settings, JText::_('COM_TAGMETA_FIELD_RULES_SYNONYMS_SETTINGS_LABEL'), 'tooltip.png', '', '').'</td>';
            switch ($item->synonyms) {
              case 0:
                $jtask = 'rules.synonyms_on';
                $jtext = JText::_( 'JNO' );
                $jtext2 = '';
                $jstate = 'unpublish';
                break;
              case 1:
                $jtask = 'rules.synonyms_on_cs';
                $jtext = JText::_( 'JYES' );
                $jtext2 = '';
                $jstate = 'publish';
                break;
              case 2:
              default:
                $jtask = 'rules.synonyms_off';
                $jtext = JText::_('JYES' ) . ' (' . JText::_('COM_TAGMETA_FIELD_RULES_SYNONYMS_CASE_SENSITIVE_LABEL') . ')';
                $jtext2 = '&nbsp;(' . JText::_('COM_TAGMETA_FIELD_RULES_SYNONYMS_CASE_SENSITIVE_LABEL') . ')';
                $jstate = 'publish';
            } ?>
            <td><div class="btn-group"><a class="btn btn-micro active" href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i; ?>','<?php echo $jtask; ?>')" title="<?php echo $jtext; ?>"><i class="icon-<?php echo $jstate; ?>"></i></a></div></td></tr>
            </table>
          </td>
          <td class="small">
            <table class="jrules">
              <tr>
                <td>
                  <div class="btn-group hasTooltip" title="<?php echo htmlspecialchars($item->title, ENT_QUOTES); ?>">
                    <a href="#" class="btn btn-small dropdown-toggle" data-toggle="dropdown"><?php echo JText::_('COM_TAGMETA_FIELD_RULES_TITLE_LABEL'); ?>&nbsp;<b class="caret"></b></a>
                    <div class="dropdown-menu">
                      <small><?php echo htmlspecialchars($item->title, ENT_QUOTES); ?></small>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="btn-group hasTooltip" title="<?php echo htmlspecialchars($item->description, ENT_QUOTES); ?>">
                    <a href="#" class="btn btn-small dropdown-toggle" data-toggle="dropdown"><?php echo JText::_('COM_TAGMETA_FIELD_RULES_DESCRIPTION_LABEL'); ?>&nbsp;<b class="caret"></b></a>
                    <div class="dropdown-menu">
                      <small><?php echo htmlspecialchars($item->description, ENT_QUOTES); ?></small>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="btn-group hasTooltip" title="<?php echo htmlspecialchars($item->author, ENT_QUOTES); ?>">
                    <a href="#" class="btn btn-small dropdown-toggle" data-toggle="dropdown"><?php echo JText::_('COM_TAGMETA_FIELD_RULES_AUTHOR_LABEL'); ?>&nbsp;<b class="caret"></b></a>
                    <div class="dropdown-menu">
                      <small><?php echo htmlspecialchars($item->author, ENT_QUOTES); ?></small>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="btn-group hasTooltip" title="<?php echo htmlspecialchars($item->keywords, ENT_QUOTES); ?>">
                    <a href="#" class="btn btn-small dropdown-toggle" data-toggle="dropdown"><?php echo JText::_('COM_TAGMETA_FIELD_RULES_KEYWORDS_LABEL'); ?>&nbsp;<b class="caret"></b></a>
                    <div class="dropdown-menu">
                      <small><?php echo htmlspecialchars($item->keywords, ENT_QUOTES); ?></small>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="btn-group hasTooltip" title="<?php echo htmlspecialchars($item->rights, ENT_QUOTES); ?>">
                    <a href="#" class="btn btn-small dropdown-toggle" data-toggle="dropdown"><?php echo JText::_('COM_TAGMETA_FIELD_RULES_RIGHTS_LABEL'); ?>&nbsp;<b class="caret"></b></a>
                    <div class="dropdown-menu">
                      <small><?php echo htmlspecialchars($item->rights, ENT_QUOTES); ?></small>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="btn-group hasTooltip" title="<?php echo htmlspecialchars($item->xreference, ENT_QUOTES); ?>">
                    <a href="#" class="btn btn-small dropdown-toggle" data-toggle="dropdown"><?php echo JText::_('COM_TAGMETA_FIELD_RULES_XREFERENCE_LABEL'); ?>&nbsp;<b class="caret"></b></a>
                    <div class="dropdown-menu">
                      <small><?php echo htmlspecialchars($item->xreference, ENT_QUOTES); ?></small>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="btn-group hasTooltip" title="<?php echo htmlspecialchars($item->canonical, ENT_QUOTES); ?>">
                    <a href="#" class="btn btn-small dropdown-toggle" data-toggle="dropdown"><?php echo JText::_('COM_TAGMETA_FIELD_RULES_CANONICAL_LABEL'); ?>&nbsp;<b class="caret"></b></a>
                    <div class="dropdown-menu">
                      <small><?php echo htmlspecialchars($item->canonical, ENT_QUOTES); ?></small>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="btn-group hasTooltip" title="<?php echo htmlspecialchars($item->custom_header, ENT_QUOTES); ?>">
                    <a href="#" class="btn btn-small dropdown-toggle" data-toggle="dropdown"><?php echo JText::_('COM_TAGMETA_FIELD_RULES_CUSTOM_HEADER_LABEL'); ?>&nbsp;<b class="caret"></b></a>
                    <div class="dropdown-menu">
                      <small><?php echo htmlspecialchars($item->custom_header, ENT_QUOTES); ?></small>
                    </div>
                  </div>
                </td>
              </tr>
            </table>
          </td>
          <td class="center">
            <table class="jrules small">
              <tr><td><?php echo JText::_('COM_TAGMETA_FIELD_RULE_RINDEX_LABEL'); ?></td><td><?php echo $robotsOption[$item->rindex]; ?></td></tr>
              <tr><td><?php echo JText::_('COM_TAGMETA_FIELD_RULE_RFOLLOW_LABEL'); ?></td><td><?php echo $robotsOption[$item->rfollow]; ?></td></tr>
              <tr><td><?php echo JText::_('COM_TAGMETA_FIELD_RULE_RSNIPPET_LABEL'); ?></td><td><?php echo $robotsOption[$item->rsnippet]; ?></td></tr>
              <tr><td><?php echo JText::_('COM_TAGMETA_FIELD_RULE_RARCHIVE_LABEL'); ?></td><td><?php echo $robotsOption[$item->rarchive]; ?></td></tr>
              <tr><td><?php echo JText::_('COM_TAGMETA_FIELD_RULE_RODP_LABEL'); ?></td><td><?php echo $robotsOption[$item->rodp]; ?></td></tr>
              <tr><td><?php echo JText::_('COM_TAGMETA_FIELD_RULE_RYDIR_LABEL'); ?></td><td><?php echo $robotsOption[$item->rydir]; ?></td></tr>
              <tr><td><?php echo JText::_('COM_TAGMETA_FIELD_RULE_RIMAGEINDEX_LABEL'); ?></td><td><?php echo $robotsOption[$item->rimageindex]; ?></td></tr>
            </table>
          </td>
          <td class="center">
            <?php echo $item->hits; ?>
          </td>
          <td class="center">
            <?php echo $item->last_visit; ?>
          </td>
          <td class="center hidden-phone">
            <?php echo $item->id; ?>
          </td>
        </tr>
      <?php
          endforeach;
        } else {
      ?>
        <tr>
          <td colspan="11">
            <?php echo JText::_('COM_TAGMETA_LIST_NO_ITEMS'); ?>
          </td>
        </tr>
      <?php
        }
      ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="11">
            <?php echo $this->pagination->getListFooter(); ?>
            <p class="footer-tip">
              <?php if ($this->enabled) : ?>
                <span class="enabled"><?php echo JText::sprintf('COM_TAGMETA_PLUGIN_ENABLED', JText::_('COM_TAGMETA_PLG_SYSTEM_TAGMETA')); ?></span>
              <?php else : ?>
                <span class="disabled"><?php echo JText::sprintf('COM_TAGMETA_PLUGIN_DISABLED', JText::_('COM_TAGMETA_PLG_SYSTEM_TAGMETA')); ?></span>
              <?php endif; ?>
            </p>
          </td>
        </tr>
      </tfoot>
    </table>

    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <?php echo JHtml::_('form.token'); ?>
  </div>
</form>
