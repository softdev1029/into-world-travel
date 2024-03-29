<?php
/**
 * sh404SEF - SEO extension for Joomla!
 *
 * @author      Yannick Gaultier
 * @copyright   (c) Yannick Gaultier - Weeblr llc - 2018
 * @package     sh404SEF
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     4.14.0.3812
 * @date		2018-05-16
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

?>
  <?php if (!empty($this->analytics->analyticsData->topSocialPlusOne)) : ?>

   <h2><?php echo JText::_('COM_SH404SEF_ANALYTICS_SOCIAL_PLUSONE_ENGAGEMENT'); ?></h2>

 	<table class="table table-striped" >
    <thead>
      <tr>
        <th>
          <?php echo '#'; ?>
        </th>

        <th rel="tooltip" <?php echo Sh404sefHelperHtml::wrapBootstrapTipTitle(JText::_('COM_SH404SEF_ANALYTICS_TOP5_URL'), JText::_('COM_SH404SEF_ANALYTICS_TT_URL_DESC'));?>>
        <?php echo JText::_( 'COM_SH404SEF_ANALYTICS_TOP5_URL' ); ?>
        </th>

        <th>
        <?php echo JText::_( 'COM_SH404SEF_ANALYTICS_SOCIAL_TYPE' ); ?>
        </th>

        <th rel="tooltip" <?php echo Sh404sefHelperHtml::wrapBootstrapTipTitle(JText::_('COM_SH404SEF_ANALYTICS_TOTAL_PLUSONE_ENGAGEMENT'), JText::_('COM_SH404SEF_ANALYTICS_TOTAL_PLUSONE_ENGAGEMENT_DESC'));?>>
        <?php echo JText::_( 'COM_SH404SEF_ANALYTICS_TOTAL_PLUSONE_ENGAGEMENT' ); ?>
        </th>

        <th>
        <?php echo '%'; ?>
        </th>

      </tr>
    </thead>


 	 <tbody>
        <?php
          $k = 0;
          $i = 1;
          foreach($this->analytics->analyticsData->topSocialPlusOne as $entry) :
        ?>

        <tr class="<?php echo "row$k"; ?>">

          <td class="shl-centered" width="3%">
            <?php echo $i; ?>
          </td>

          <td width="62%">
            <?php
            $path = str_replace( JURI::root(),'',  $entry->dimension['eventLabel']);
              echo $this->escape( $path);
            ?>
          </td>

          <td class="shl-centered" width="10%">
            <?php
            switch ($entry->dimension['eventAction']) {
              case 'on':
                $action = 'COM_SH404SEF_ANALYTICS_SOCIAL_PLUS_ONE_ON';
                break;
              case 'off':
                $action = 'COM_SH404SEF_ANALYTICS_SOCIAL_PLUS_ONE_OFF';
                break;
              default:
                $action = '-';
                break;
            }
              echo $this->escape( JText::_($action));
            ?>
          </td>

          <td class="shl-centered" width="15%">
            <?php echo $this->escape( $entry->totalEvents); ?>
          </td>

          <td class="shl-centered" width="10%">
            <?php
              echo $this->escape( sprintf( '%0.1f', $entry->eventsPerCent*100));
            ?>
          </td>

        </tr>
        <?php
        $k = 1 - $k;
        $i++;
      endforeach;

 	    ?>

 	  </tbody>
  </table>

 	<?php else : ?>
 	  <h4 class="muted"><?php echo JText::_('COM_SH404SEF_ANALYTICS_SOCIAL_NO_PLUS_ONE_ENGAGEMENT'); ?></h4>
 	<?php endif; ?>

