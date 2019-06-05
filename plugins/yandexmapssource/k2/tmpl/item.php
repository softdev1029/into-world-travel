<h2 class="genericItemTitle">
	<?php if ($item->params->get('genericItemTitleLinked')): ?>
		<a target="<?php echo $params->get('how_open_link','_self')?>" href="<?php echo $item->link; ?>">
            <?php echo $item->title; ?>
        </a>
	<?php else: ?>
	<?php echo $item->title; ?>
	<?php endif; ?>
  </h2>
<?php 
if($item->params->get('itemImage') && !empty($item->image)): ?>
<!-- Item Image -->
<div class="itemImageBlock">
  <span class="itemImage">
	<a target="<?php echo $params->get('how_open_link','_self')?>" href="<?php echo $item->link; ?>">
		<img src="<?php echo $item->image; ?>" alt="<?php if(!empty($item->image_caption)) echo K2HelperUtilities::cleanHtml($item->image_caption); else echo K2HelperUtilities::cleanHtml($item->title); ?>" style="width:<?php echo $item->imageWidth; ?>px; height:auto;" />
	</a>
  </span>

  <?php if($item->params->get('itemImageMainCaption') && !empty($item->image_caption)): ?>
  <!-- Image caption -->
  <span class="itemImageCaption"><?php echo $item->image_caption; ?></span>
  <?php endif; ?>

  <?php if($item->params->get('itemImageMainCredits') && !empty($item->image_credits)): ?>
  <!-- Image credits -->
  <span class="itemImageCredits"><?php echo $item->image_credits; ?></span>
  <?php endif; ?>

  <div class="clr"></div>
</div>
<?php endif; ?>
<div class="itemIntroText">
	<?php echo $item->introtext?:$item->fulltext; ?>
</div>