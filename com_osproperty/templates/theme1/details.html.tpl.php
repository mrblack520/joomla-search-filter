<?php
/*------------------------------------------------------------------------
# details.html.tpl.php - Ossolution Property
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2023 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/
// No direct access.
defined('_JEXEC') or die;
$document = JFactory::getDocument();
$document->addStyleSheet('//fonts.googleapis.com/css?family=Oswald:700');
$document->addStyleSheet(JURI::root()."components/com_osproperty/templates/".$themename."/style/style.css");
$document->addStyleSheet(JURI::root()."components/com_osproperty/templates/".$themename."/style/slide.css");
$document->addStyleSheet(JURI::root()."components/com_osproperty/templates/".$themename."/style/font.css");
$show_request = $params->get('show_request_more_details','top');
$show_location = $params->get('show_location',1);
$show_createddate = $params->get('show_createddate',0);
$titleColor = $params->get('titleColor','#03b4ea');
OSPHelperJquery::colorbox('a.osmodal');
OSPHelperJquery::colorbox('a.reportmodal');

?>
<style>
.detailsView .row-fluid .span12 h1,.detailsView .row .col-md-12 h1{
	color:<?php echo $titleColor;?> !important;
}

.os_property-item .status-price, .os_property-item .status-price_rtl{
	background:<?php echo $titleColor;?> !important;
}
@media (min-width: 1280px) {
	.os_property-item .status-type:after {
    border-right: 9px solid <?php echo $titleColor;?> !important;
}
#main ul{
	margin:0px;
}
</style>
<div id="notice" style="display:none;">
</div>
<?php
if(count($topPlugin) > 0){
	for($i=0;$i<count($topPlugin);$i++){
		echo $topPlugin[$i];
	}
}
?>
<input type="hidden" name="process_element" id="process_element" value="" />
<!--- wrap content -->
<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>" id="propertydetails">
	<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?>">
		<div class="lightGrad detailsView clearfix">
			<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
				<?php
				$language = JFactory::getLanguage(); 
				$csssuffix = "";
				if($language->isRTL()){
					$csssuffix = "_rtl";
				?>
					<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?> property-title" style="border-right:10px solid <?php echo $titleColor;?>;">
				<?php
				}else{
				?>
					<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?> property-title" style="border-left:10px solid <?php echo $titleColor;?>;">
				<?php 
				}
				?>
					<h1>
					<?php
					if(($row->ref != "") and ($configClass['show_ref'] == 1)){
						?>
							<?php echo $row->ref?>,&nbsp;
						<?php
					}
					?>
					<?php echo $row->pro_name?>
					<?php
						if($row->isFeatured == 1){
							?>
							<span class="featuredpropertydetails"><?php echo JText::_('OS_FEATURED');?></span>
							<?php
						}
						if(($configClass['active_market_status'] == 1)&&($row->isSold > 0)){
							?>
							<span class="marketstatuspropertydetails"><?php echo OSPHelper::returnMarketStatus($row->isSold);?></span>
							<?php
						}
						$created_on = $row->created;
						$modified_on = $row->modified;
						$created_on = strtotime($created_on);
						$modified_on = strtotime($modified_on);
						if($created_on > time() - 3*24*3600){ //new
							if($configClass['show_just_add_icon'] == 1){
								?>
								<span class="justaddedpropertydetails"><?php echo JText::_('OS_JUSTADDED');?></span>
								<?php
							}
						}elseif($modified_on > time() - 2*24*3600){
							if($configClass['show_just_update_icon'] == 1){
								?>
								<span class="justupdatedpropertydetails"><?php echo JText::_('OS_JUSTUPDATED');?></span>
								<?php
							}
						}
						if($configClass['enable_report'] == 1)
						{
							OSPHelperJquery::colorbox('a.reportmodal');
						?>
							<a href="<?php echo JURI::root()?>index.php?option=com_osproperty&tmpl=component&item_type=0&task=property_reportForm&id=<?php echo $row->id?>" class="reportmodal reportlink" rel="{handler: 'iframe', size: {x: 350, y: 600}}" title="<?php echo JText::_('OS_REPORT_LISTING');?>">
								<span class="reportitem">
									<?php echo JText::_('OS_REPORT');?>
								</span>
							</a>
						<?php
						}
						?>
					</h1>
					<span>
						<?php 
						$sold_property_types = $configClass['sold_property_types'];
						$show_sold = 0;
						if($sold_property_types != ""){
							$sold_property_typesArr = explode("|",$sold_property_types);
							if(in_array($row->pro_type, $sold_property_typesArr)){
								$show_sold = 1;
							}
						}
						?>
						<?php if(($configClass['use_sold'] == 1) and ($row->isSold == 1) and ($show_sold == 1)){
							?>
							<span class="badge badge-warning"><strong><?php echo JText::_('OS_SOLD')?></strong></span> <?php echo JText::_('OS_ON');?>: <?php echo $row->soldOn;?>
							<div class="clearfix"></div>
							<?php
						}
						?>
					</span>
					<?php if($row->show_address == 1){?>
					<span class="address_details">
						<?php echo OSPHelper::generateAddress($row);?>
					</span>
					<?php }?>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
				<!-- content -->
				<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?>">
					<!-- tab1 -->
					<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">    
						<div class="<?php echo $bootstrapHelper->getClassMapping('span7'); ?>">
							<?php
							if(count($photos) > 0)
							{
							  // HelperOspropertyCommon::propertyGallery($row,$photos);
							  ?>
							  <script type="text/javascript">
							  //var heightOfMainPhoto = <?php echo $configClass['images_large_height'];?>;
							  //jQuery('#thumbPhotos').css("height",heightOfMainPhoto);
							  </script>
							  <script type="text/javascript" src="<?php echo JUri::root(true)?>/media/com_osproperty/assets/js/colorbox/jquery.colorbox.js"></script>
							  <link rel="stylesheet" href="<?php echo JUri::root()?>media/com_osproperty/assets/js/colorbox/colorbox.css" type="text/css" media="screen" />
							  <script type="text/javascript">
							  jQuery(document).ready(function(){
								  jQuery(".propertyphotogroup").colorbox({rel:'colorbox',maxWidth:'95%', maxHeight:'95%'});
							  });
							  </script>
							  <?php
								$slidertype		= 'slidernav';
								$animation		= 'slide';
								$slideshow		= 'true';
								$slideshowspeed = 5000;
								$arrownav		= 'true';
								$controlnav		= 'true' ;
								$keyboardnav	= 'true';
								$mousewheel		= 'false';
								$randomize		=  'false';
								$animationloop	=  'true';
								$pauseonhover	=  'true' ;
								$target			= 'self';
								$jquery			= 'noconflict';
								
								if ($jquery != 0) {JHTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js');}
								echo '<script type="text/javascript" src="'.Juri::root().'components/com_osproperty/templates/default/js/jquery.flexslider.js"></script>';
								JHTML::stylesheet(Juri::root().'components/com_osproperty/templates/default/style/favslider.css');
								
								if ($jquery == 1 || $jquery == 0) { $noconflict = ''; $varj = '$';}
								if ($jquery == "noconflict") {$noconflict = 'jQuery.noConflict();'; $varj = 'jQuery';}
								if ($slidertype == "slidernav") 
								{
									echo '<style type= text/css>#carousel1 {margin-top: 3px;}</style><script type="text/javascript">
									'.$noconflict.'
										'.$varj.'(document).ready(function(){
										  '.$varj.'(\'#carousel1\').favslider({
											animation: "slide",
											controlNav: false,
											directionNav: '.$arrownav.',
											mousewheel: '.$mousewheel.',
											animationLoop: false,
											slideshow: false,
											itemWidth: 120,
											asNavFor: \'#slider1\'
										  });
										  
										  '.$varj.'(\'#slider1\').favslider({
											animation: "'.$animation.'",
											directionNav: '.$arrownav.',
											mousewheel: '.$mousewheel.',
											slideshow: '.$slideshow.',
											slideshowSpeed: '.$slideshowspeed.',
											randomize: '.$randomize.',
											animationLoop: '.$animationloop.',
											pauseOnHover: '.$pauseonhover.',
											controlNav: false,
											sync: "#carousel1",
											start: function(slider){
											'.$varj.'(\'body\').removeClass(\'loading\');
											}
										  });
										});
									</script>'; 
								} 
								?>
					
							 <div id="slider1" class="favslider1 margin0">
								<ul class="favs">
								<?php
								   for($i=0;$i<count($photos);$i++){
									if($photos[$i]->image != "")
									{
										if(JPATH_ROOT.'/images/osproperty/properties/'.$row->id.'/medium/'.$photos[$i]->image)
										{
											?>
											<li><a class="propertyphotogroup" href="<?php echo JURI::root()?>images/osproperty/properties/<?php echo $row->id;?>/<?php echo $photos[$i]->image?>"><img src="<?php echo JURI::root()?>images/osproperty/properties/<?php echo $row->id;?>/medium/<?php echo $photos[$i]->image?>" alt="<?php echo $photos[$i]->image_desc;?>" title="<?php echo $photos[$i]->image_desc;?>"/></a></li>
											<?php
										}
										else
										{
											?>
											<li><img src="<?php echo JURI::root()?>media/com_osproperty/assets/images/nopropertyphoto.png" alt="<?php echo $photos[$i]->image_desc;?>" title="<?php echo $photos[$i]->image_desc;?>"/></li>
											<?php
										}
									}
									else
									{
										?>
										<li><img src="<?php echo JURI::root()?>media/com_osproperty/assets/images/nopropertyphoto.png" alt="<?php echo $photos[$i]->image_desc;?>" title="<?php echo $photos[$i]->image_desc;?>"/></li>
										<?php
									}
								   }
								   ?>
								</ul>
							</div>
							<?php if(count($photos) > 1){?>
							<div id="carousel1" class="favslider1 hidden-phone">
								<ul class="favs">
								<?php 
								for($i=0;$i<count($photos);$i++)
								{
									if($photos[$i]->image != "")
									{
										if(JPATH_ROOT.'/images/osproperty/properties/'.$row->id.'/thumb/'.$photos[$i]->image)
										{
											?>
											<li <?php if ($i>0) {?>style="margin-left: 3px;width:120px !important;"<?php }else{ ?>style="width:120px !important;; "<?php } ?>><img class="detailwidth" alt="<?php echo $photos[$i]->image_desc;?>" title="<?php echo $photos[$i]->image_desc;?>" src="<?php echo JURI::root()?>images/osproperty/properties/<?php echo $row->id;?>/thumb/<?php echo $photos[$i]->image?>" /></li>
											<?php
										}
										else
										{
											?>
											<li <?php if ($i>0) {?>style="margin-left: 3px;width:120px !important;"<?php }else{ ?>style="width:120px; !important;"<?php } ?>><img src="<?php echo JURI::root()?>media/com_osproperty/assets/images/nopropertyphoto.png" /></li>
											<?php
										}
									}
									else
									{
										?>
										<li <?php if ($i>0) {?>style="margin-left: 3px;width:120px !important;"<?php }else{ ?>style="width:120px !important;;"<?php } ?>><img src="<?php echo JURI::root()?>media/com_osproperty/assets/images/nopropertyphoto.png" /></li>
										<?php
									}
								}
								?>
								</ul>
							</div>
							<?php } 
							}else{
								?>
								<img src="<?php echo JURI::root()?>media/com_osproperty/assets/images/nopropertyphoto.png"/>
								<?php 
							}
							?>
						</div>
						<div class="<?php echo $bootstrapHelper->getClassMapping('span5'); ?>">
							<div class="descriptionWrap">
								<ul class="attribute-list">
									<?php
									if($show_createddate == 1){
									?>
									<li class="property-icon-square meta-block">
										<?php echo JText::_('OS_CREATED_ON');?>:
									   <span>
										<?php
										echo JHTML::_('date', $row->created , $configClass['general_date_format']);
										?>
									   </span>
									</li>
									<?php
									}
									if($configClass['use_squarefeet'] == 1 && $row->square_feet > 0)
									{
									   ?>
										<li class="property-icon-square meta-block">
											<?php echo OSPHelper::showSquareLabels();?>:
										<span>
											<?php
											echo OSPHelper::showSquare($row->square_feet);
											echo "&nbsp;";
											echo OSPHelper::showSquareSymbol();
											?>
										</span></li>
										<?php 
										if($row->lot_size > 0){
										?>
										<li class="property-icon-square meta-block">
											<?php echo JText::_('OS_LOT_SIZE');?>:
										<span>
											<?php
											echo OSPHelper::showSquare($row->lot_size);
											echo "&nbsp;";
											echo OSPHelper::showSquareSymbol();
											?>
										</span></li>
										<?php
										}
									 }
									 ?>
									 <?php
									 if(($configClass['use_bedrooms'] == 1) and ($row->bed_room > 0)){
									 ?>
										<li class="property-icon-bed meta-block">
										<?php echo JText::_('OS_BEDROOM');?>:
										<span><?php echo $row->bed_room;?></span></li>
										<?php 
										}
										?>
										<?php
										if(($configClass['use_bathrooms'] == 1) and ($row->bath_room > 0)){
										?><li class="property-icon-bath meta-block"><?php echo JText::_('OS_BATHROOM');?>:
										<span><?php echo OSPHelper::showBath($row->bath_room);?></span></li>
									 <?php 
									 }
									 ?>
									 <?php
									 if(($configClass['use_rooms'] == 1) and ($row->rooms > 0)){
									 ?>
										<li class="property-icon-parking meta-block"><?php echo JText::_('OS_ROOMS');?>:
											<span><?php echo $row->rooms;?></span></li>
									 <?php 
									 }
									 ?>
									 <?php
									 if(($configClass['use_parking'] == 1) and ($row->parking != "")){
									 ?>
										<li class="property-icon-parking meta-block"><?php echo JText::_('OS_PARKING');?>:
											<span><?php echo $row->parking;?></span></li>
									 <?php 
									 }
									 ?>
									 <?php
									 if($configClass['show_feature_group'] == 1){
										if(($configClass['use_nfloors'] == 1) and ($row->number_of_floors != "")){
										?>
											<li class="propertyinfoli meta-block"><strong><?php echo JText::_('OS_FLOORS')?>: </strong><span><?php echo $row->number_of_floors;?></span></li>
										<?php
										}
										?>
									<?php
									}
									?>
									<?php
									if(($configClass['show_rating'] == 1) && ($configClass['active_comment'] == 1)){
									?>
										<li class="propertyinfoli meta-block"><?php echo JText::_('OS_RATING')?>: <span><?php echo $row->ratingvalue?></span></li>
									<?php
									}
									?>
									<li class="propertyinfoli meta-block"><strong><?php echo JText::_('OS_CATEGORY')?>: </strong><span><?php echo $row->category_name?></span></li>
									<?php
									if(count((array)$tagArr) > 0)
									{
										?>
										<li class="propertyinfoli meta-block"><strong><?php echo JText::_('OS_TAGS')?>: </strong>
											<span>
												<?php echo implode(" ",$tagArr);?>
											</span>
										</li>
										<?php
									}
									?>
								</ul>
							</div>
						</div>                    
					</div>
				</div>
				<!-- end content -->
			</div>
		</div>
		<?php

		?>
		<div class="os_property-item clearfix">
			<div class="wrap clearfix">
				<h4 class="title">
					<?php 
					if(($row->ref != "") && ($configClass['show_ref'] == 1)){
						echo JText::_('Ref #')?> : 
						<?php
						echo $row->ref;
					}
					?> 
				</h4>
				<h5 class="price<?php echo $csssuffix;?>">
					<span class="status-type<?php echo $csssuffix;?>">
						<?php echo $row->type_name?>
					</span>
					<span class="status-price<?php echo $csssuffix;?>" id="currency_div">
						<?php echo $row->price_raw;?>
						<?php 
						if($configClass['show_convert_currency'] == 1 && $row->price_call == 0){
							echo $lists['curr_default'];
						}
						?>
					</span>
					<input type="hidden" name="live_site" id="live_site" value="<?php echo JUri::root(); ?>" />
					<input type="hidden" name="currency_item" id="currency_item" value="" />
				</h5>
			</div>
			<!--property-meta -->
			<div class="property-meta clearfix">
				<ul class="listingActions-list">
					<?php
					$user = JFactory::getUser();
					if(HelperOspropertyCommon::isAgent()){
						$my_agent_id = HelperOspropertyCommon::getAgentID();
						if($my_agent_id == $row->agent_id){
							$link = JURI::root()."index.php?option=com_osproperty&task=property_edit&id=".$row->id;
							?>
							 <li class="propertyinfoli">
								<i class="osicon-edit"></i>
								<a href="<?php echo $link?>" title="<?php echo JText::_('OS_EDIT_PROPERTY')?>">
									<?php echo JText::_('OS_EDIT_PROPERTY')?>
								</a>
							</li>
							<?php
						}
					}
					if(($configClass['show_getdirection'] == 1) and ($row->show_address == 1)){
					?>
					<li class="propertyinfoli">
						<i class="osicon-move"></i>
						<a href="<?php echo JRoute::_("index.php?option=com_osproperty&task=direction_map&id=".$row->id)?>" title="<?php echo JText::_('OS_GET_DIRECTIONS')?>">
							<?php echo JText::_('OS_GET_DIRECTIONS')?>
						</a>
					</li>
					<?php
					}
					if($configClass['show_compare_task'] == 1){

						if(! OSPHelper::isInCompareList($row->id)) {
							?>
							<li class="propertyinfoli">
								<?php
								$msg = JText::_('OS_DO_YOU_WANT_TO_ADD_PROPERTY_TO_YOUR_COMPARE_LIST');
								$msg = str_replace("'", "\'", $msg);
								?>
								<i class="osicon-list"></i>
								<span id="compare<?php echo $row->id; ?>">
									<a onclick="javascript:osConfirmExtend('<?php echo $msg;?>','ajax_addCompare','<?php echo $row->id?>','<?php echo JURI::root()?>','compare<?php echo $row->id?>','theme1','details')" href="javascript:void(0)">
										<?php echo JText::_('OS_ADD_TO_COMPARE_LIST')?>
									</a>
								</span>
							</li>
							<?php
						}else{
							?>
							<li class="propertyinfoli">
								<?php
								$msg = JText::_('OS_DO_YOU_WANT_TO_REMOVE_PROPERTY_OUT_OF_COMPARE_LIST');
								$msg = str_replace("'", "\'", $msg);
								?>
								<i class="osicon-list"></i>
								<span id="compare<?php echo $row->id; ?>">
									<a onclick="javascript:osConfirmExtend('<?php echo $msg;?>','ajax_removeCompare','<?php echo $row->id?>','<?php echo JURI::root()?>','compare<?php echo $row->id?>','theme1','details')" href="javascript:void(0)">
										<?php echo JText::_('OS_REMOVE_FROM_COMPARE_LIST')?>
									</a>
								</span>
							</li>
						<?php
						}
					}
					if(($configClass['property_save_to_favories'] == 1) and ($user->id > 0)){
						
						if($inFav == 0){
							?>
							<li class="propertyinfoli">
								<?php
								$msg = JText::_('OS_DO_YOU_WANT_TO_ADD_PROPERTY_TO_YOUR_FAVORITE_LISTS');
								$msg = str_replace("'","\'",$msg);
								?>

								<i class="osicon-star"></i>
								<span id="fav<?php echo $row->id; ?>">
									<a onclick="javascript:osConfirmExtend('<?php echo $msg;?>','ajax_addFavorites','<?php echo $row->id?>','<?php echo JURI::root()?>','fav<?php echo $row->id; ?>','theme1','details')" href="javascript:void(0)" class="_saveListingLink save has icon s_16">
										<?php echo JText::_('OS_ADD_TO_FAVORITES');?>
									</a>
								</span>
							</li class="propertyinfoli">
							<?php
						}else{
							?>
							<li class="propertyinfoli">
								<?php
								$msg = JText::_('OS_DO_YOU_WANT_TO_ADD_PROPERTY_TO_YOUR_FAVORITE_LISTS');
								$msg = str_replace("'","\'",$msg);
								?>

								<i class="osicon-star"></i>
								<span id="fav<?php echo $row->id; ?>">
									<a onclick="javascript:osConfirmExtend('<?php echo $msg;?>','ajax_removeFavorites','<?php echo $row->id?>','<?php echo JURI::root()?>','fav<?php echo $row->id; ?>','theme1','details')" href="javascript:void(0)" class="_saveListingLink save has icon s_16">
										<?php echo JText::_('OS_REMOVE_FAVORITES');?>
									</a>
								</span>
							</li class="propertyinfoli">
							<?php 
						}
					}
					if($configClass['property_pdf_layout'] == 1){
					?>
					<li class="propertyinfoli">
						<img src="<?php echo JUri::root()?>media/com_osproperty/assets/images/pdf16.png" />
						<a href="<?php echo JURI::root()?>index.php?option=com_osproperty&no_html=1&task=property_pdf&id=<?php echo $row->id?>" title="<?php echo JText::_('OS_EXPORT_PDF')?>"  rel="nofollow" target="_blank">
						PDF
						</a>
					</li>
					<?php
					}
					if($configClass['property_show_print'] == 1){
					?>
					<li class="propertyinfoli">
						<i class="osicon-print"></i>
						<a target="_blank" href="<?php echo JURI::root()?>index.php?option=com_osproperty&tmpl=component&no_html=1&task=property_print&id=<?php echo $row->id?>">
						   <?php echo JText::_('OS_PRINT_THIS_PAGE')?>
						   </a>
					   </li>
					   <?php
					}
					if($row->panorama != ""){
						?>
						<li class="propertyinfoli">
							<i class="osicon-picture"></i>
							<a href="<?php echo JUri::root(); ?>index.php?option=com_osproperty&task=property_showpano&id=<?php echo $row->id?>&tmpl=component" class="reportmodal" rel="{handler: 'iframe', size: {x: 650, y: 420}}">
								<?php echo JText::_('OS_PANORAMA')?>
							</a>
						</li>
						<?php
					}
					?>

				</ul> 
			</div>
			
			<!-- end property-meta -->
			<!-- os_property_content -->
			<div class="os_property_content clearfix">
				<div>
					<?php
					if($configClass['use_open_house'] == 1){
						?>
						<div class="floatright">
							<?php echo $row->open_hours;?>
						</div>
						<?php 
					}
					?>
					<?php echo OSPHelper::getLanguageFieldValue($row,'pro_small_desc');?>
					<?php 
					if(OSPHelper::getLanguageFieldValue($row,'pro_full_desc') != ""){
						echo OSPHelper::getLanguageFieldValue($row,'pro_full_desc');
					}
					?>
				</div>
				<?php 
				if(count($row->extra_field_groups) > 0){
					$extra_field_groups = $row->extra_field_groups;
					?>
					<div class="clearfix"></div>
					<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
						<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?>">
							<h4 class="additional-title"><?php echo JText::_('OS_PROPERTY_INFORMATION');?></h4>
							<ul class="additional-details clearfix">
							<?php 
							for($i=0;$i<count($extra_field_groups);$i++){
								$group = $extra_field_groups[$i];
								$group_name = $group->group_name;
								$fields = $group->fields;
								if(count($fields)> 0){
									?>  
									<li><strong><?php echo $group_name;?></strong></li>
									<?php 
									$k = 0;
									for($j=0;$j<count($fields);$j++){
										$field = $fields[$j];
										if($field->value != ""){
										?> 
										<li>
											<strong>
												<?php
												if(($field->displaytitle == 1) or ($field->displaytitle == 2)){
												?>
													<?php echo $field->field_label;?>
												<?php } ?>
												<?php
												if($field->displaytitle == 1){
													?>
													:
												<?php } ?>
											</strong>
											<?php
											if(($field->displaytitle == 1) or ($field->displaytitle == 3)){?>
											<span><?php echo $field->value;?></span> <?php } ?>
										</li>
										<?php 
										}
									}
								}
							} ?>
							</ul>
						 </div>
					 </div>
				 <?php }?>
				 <?php 
				 $db = JFactory::getDbo();
				 $query = "Select count(a.id)from #__osrs_neighborhood as a"
						." inner join #__osrs_neighborhoodname as b on b.id = a.neighbor_id"
						." where a.pid = '$row->id'";
				$db->setQuery($query);
				$count_neighborhood = $db->loadResult();
				if($count_neighborhood > 0){
					?>
					<div class="clearfix"></div>
					<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
						<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?> margintop20">
							<h4 class="additional-title"><?php echo JText::_('OS_NEIGHBORHOOD');?></h4>
							<ul class="additional-details clearfix">
							<?php 
							$query = "Select a.*,b.neighborhood from #__osrs_neighborhood as a"
									." inner join #__osrs_neighborhoodname as b on b.id = a.neighbor_id"
									." where a.pid = '$row->id'";
							$db->setQuery($query);
							$neighbodhoods = $db->loadObjectList();
							for($j=0;$j<count($neighbodhoods);$j++){
								$neighbodhood = $neighbodhoods[$j];
								$k = 0;
								?>
								<li>
									<strong><?php echo JText::_($neighbodhood->neighborhood)?>:</strong>
									<span><?php echo $neighbodhood->mins?> <?php echo JText::_('OS_MINS')?> <?php echo JText::_('OS_BY')?> 
									<?php
									switch ($neighbodhood->traffic_type){
										case "1":
											echo JText::_('OS_WALK');
										break;
										case "2":
											echo JText::_('OS_CAR');
										break;
										case "3":
											echo JText::_('OS_TRAIN');
										break;
									}
									?></span>
								</li>
								<?php 
							} ?>
							</ul>
						 </div>
					 </div>
					<?php 
				}
				?>
			</div>
			<!-- end os_property_content-->
			<!-- features-->
			<?php
			if((($configClass['show_amenity_group'] == 1) and ($row->amens_str1 != "")) || ($row->core_fields != "")){
			?>
				<div class="features">
					<h4 class="title"><?php echo JText::_('OS_FEATURES')?></h4>
					<div class="arrow-bullet-list">
						<div class="listing-features">
							<?php
							if($configClass['show_feature_group'] == 1){
								echo $row->core_fields;
							}
							?>
							<?php
							if(($configClass['show_amenity_group'] == 1) and ($row->amens_str1 != "")){
							?>
								<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
									<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?>">
										<?php echo $row->amens_str1;?>
									</div>
								</div>
							<?php
							}
							?>
						</div>
					</div>
				</div>
			<?php
			}
			?>
			<!-- end features -->
			<?php
			if(count($middlePlugin) > 0){
				for($i=0;$i<count($middlePlugin);$i++){
					echo $middlePlugin[$i];
				}
			}
			?>

			<!-- end des -->
			<?php
			if(($configClass['goole_use_map'] == 1) and ($row->lat_add != "") and ($row->long_add != "")){
			$address = OSPHelper::generateAddress($row);
			?>
			<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
				<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?>">
					<div class="features">
						<h4 class="title"><?php echo JText::_('OS_LOCATION')?></h4>
						<?php 
						if($show_location == 1){
							OSPHelper::showLocationAboveGoogle($address);
						}
                        if($configClass['map_type'] == 1)
                        {
                            HelperOspropertyOpenStreetMap::loadOpenStreetMapDetails($row, $configClass, '', 1);
                        }
                        else
                        {
                            HelperOspropertyGoogleMap::loadGoogleMapDetails($row, $configClass);
                        }
						?>
					</div>
				</div>
			</div>
		<?php
		}
		?>
			<div class="property-meta clearfix margintop15">
				<ul class="listingActions-list">
					<li class="propertyinfoli" style="background-color:#586162;">
						<span><?php echo JText::_('OS_SHARE_THIS');?></span>
					</li>
					<?php
					if($configClass['social_sharing']== 1){
							
						$url = JRoute::_("index.php?option=com_osproperty&task=property_details&id=$row->id");
						$url = JUri::getInstance()->toString(array('scheme', 'user', 'pass', 'host')).$url;
						?>
						<li class="propertyinfoli">
							<img src="<?php echo JUri::root()?>media/com_osproperty/assets/images/facebook_icon.png" />
							<a href="http://www.facebook.com/share.php?u=<?php echo $url;?>" target="_blank"  title="<?php echo JText::_('OS_ASK_YOUR_FACEBOOK_FRIENDS');?>" id="link2Listing" rel="canonical">
								<?php echo JText::_('OS_FACEBOOK')?>
							</a>
						</li>
						<li class="propertyinfoli">
							<img src="<?php echo JUri::root()?>media/com_osproperty/assets/images/twitter_icon.png" />
							<a href="https://twitter.com/intent/tweet?original_referer=<?php echo $url;?>&tw_p=tweetbutton&url=<?php echo $url;?>" target="_blank"  title="<?php echo JText::_('OS_ASK_YOUR_TWITTER_FRIENDS');?>" id="link2Listing" rel="canonical">
							<?php echo JText::_('OS_TWEET')?>
							</a>
						</li>
						<?php
					}
					?>
				</ul> 
			</div>
			<?php 
			if(($row->pro_pdf != "") or ($row->pro_pdf_file != "")){
			?>
			<div class="property-attachment clearfix">
				<span class="attachment-label"><?php echo JText::_('OS_PROPERTY_ATTACHMENT');?></span>            
				<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
					<?php 
					if($row->pro_pdf != ""){
						?>
						<div class="<?php echo $bootstrapHelper->getClassMapping('span6'); ?>">
							<img src="<?php echo JUri::root()?>media/com_osproperty/assets/images/link.png" />
							<a href="<?php echo $row->pro_pdf?>" title="<?php echo JText::_('OS_PROPERTY_DOCUMENT')?>" alt="<?php echo JText::_('OS_PROPERTY_DOCUMENT')?>" target="_blank">
								<?php echo $row->pro_pdf?>
							</a>
						</div>
						<?php 
					}
					
					if($row->pro_pdf_file != "")
					{
						if(file_exists(JPATH_ROOT.'/media/com_osproperty/document/'.$row->pro_pdf_file))
						{
							$fileUrl = JUri::root().'media/com_osproperty/document/'.$row->pro_pdf_file;
						}
						else
						{
							$fileUrl = JUri::root().'components/com_osproperty/document/'.$row->pro_pdf_file;
						}
						?>
						<div class="<?php echo $bootstrapHelper->getClassMapping('span6'); ?>">
							<img src="<?php echo JUri::root(true)?>/media/com_osproperty/assets/images/attach.png" />
							<a href="<?php echo $fileUrl; ?>" title="<?php echo JText::_('OS_PROPERTY_DOCUMENT')?>" alt="<?php echo JText::_('OS_PROPERTY_DOCUMENT')?>" target="_blank">
								<?php echo $row->pro_pdf_file?>
							</a>
						</div>
					<?php }
					?>
				</div>
			</div>
			<?php } ?>

			<!-- agent-detail -->
			<?php
			if($configClass['show_agent_details'] == 1){

				$link = Jroute::_('index.php?option=com_osproperty&task=agent_info&id='.$row->agent_id.'&Itemid='.OSPRoute::getAgentItemid($row->agent_id));
					$db->setQuery("Select * from #__osrs_agents where id = '$row->agent_id'");
					$agentdetails = $db->loadObject();
					?>
					<div class="agent-detail clearfix">
						<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?> margin0 padding10">
							<div class="<?php echo $bootstrapHelper->getClassMapping('span7'); ?>">
								<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?> agent-name">
									<a href="<?php echo $link;?>">
										<strong><?php echo $row->agent_name;?></strong>
									</a>
								</div>
                                <?php
                                if(OSPHelper::allowShowingProfile($agentdetails->optin)){
                                ?>
                                    <?php if($configClass['show_agent_address'] == 1){ ?>
                                        <div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?> agent-address">
                                            <?php echo OSPHelper::generateAddress($agentdetails);?>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                                <div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
                                    <?php if($configClass['show_agent_image'] == 1){ ?>
                                        <div class="<?php echo $bootstrapHelper->getClassMapping('span4'); ?>">
                                            <?php
                                            if(OSPHelper::allowShowingProfile($agentdetails->optin)) {
                                                ?>
                                                <?php
                                                $agent_photo = $agentdetails->photo;
                                                $agent_photo_array = explode(".", $agent_photo);
                                                $ext = $agent_photo_array[count($agent_photo_array) - 1];
                                                if ($agent_photo != "") {
                                                    ?>
                                                    <a href="<?php echo $link; ?>">
                                                        <img src="<?php echo JURI::root() ?>images/osproperty/agent/<?php echo $agent_photo; ?>"
                                                             class="<?php echo $bootstrapHelper->getClassMapping('img-polaroid'); ?>"/>
                                                    </a>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <img src="<?php echo JURI::root() ?>media/com_osproperty/assets/images/user.jpg"
                                                         class="border1"
                                                         class="<?php echo $bootstrapHelper->getClassMapping('img-polaroid'); ?>"/>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                    <?php } ?>
                                        <div class="<?php echo $bootstrapHelper->getClassMapping('span8'); ?>">
                                            <?php
                                            if(OSPHelper::allowShowingProfile($agentdetails->optin)){
                                            ?>
                                                <ul class="attribute-list">
                                                    <?php
                                                    if(($agentdetails->phone != "") and ($configClass['show_agent_phone'] == 1)){
                                                    ?>
                                                       <li class="property-icon-square meta-block">
                                                        <?php echo JText::_('OS_PHONE');?>:
                                                       <span>
                                                           <?php echo $agentdetails->phone;?>
                                                       </span></li>
                                                    <?php
                                                    }
                                                    ?>
                                                    <?php
                                                    if(($agentdetails->mobile != "") and ($configClass['show_agent_mobile'] == 1)){
                                                    ?>
                                                       <li class="property-icon-square meta-block">
                                                        <?php echo JText::_('OS_MOBILE');?>:
                                                       <span>
                                                           <?php echo $agentdetails->mobile;?>
                                                       </span></li>
                                                    <?php
                                                    }
                                                    ?>
                                                    <?php
                                                    if(($agentdetails->fax != "") and ($configClass['show_agent_fax'] == 1)){
                                                    ?>
                                                       <li class="property-icon-square meta-block">
                                                        <?php echo JText::_('OS_FAX');?>:
                                                       <span>
                                                           <?php echo $agentdetails->fax;?>
                                                       </span></li>
                                                    <?php
                                                    }
                                                    ?>
                                                    <?php
                                                    if(($agentdetails->yahoo != "") and ($configClass['show_agent_linkin'] == 1)){
                                                    ?>
                                                       <li class="property-icon-square meta-block">
                                                        <?php echo JText::_('OS_LINKEDIN');?>:
                                                       <span>
                                                           <?php echo $agentdetails->yahoo;?>
                                                       </span></li>
                                                    <?php
                                                    }
                                                    ?>
                                                    <?php
                                                    if(($agentdetails->gtalk != "") and ($configClass['show_agent_gplus'] == 1)){
                                                    ?>
                                                       <li class="property-icon-square meta-block">
                                                        <?php echo JText::_('Gplus');?>:
                                                       <span>
                                                           <?php echo $agentdetails->gtalk;?>
                                                       </span></li>
                                                    <?php
                                                    }
                                                    ?>
                                                    <?php
                                                    if(($agentdetails->skype != "") and ($configClass['show_agent_skype'] == 1)){
                                                    ?>
                                                       <li class="property-icon-square meta-block">
                                                        <?php echo JText::_('OS_SKYPE');?>:
                                                       <span>
                                                           <?php echo $agentdetails->skype;?>
                                                       </span></li>
                                                    <?php
                                                    }
                                                    ?>
                                                    <?php
                                                    if(($agentdetails->msn != "") and ($configClass['show_agent_msn'] == 1)){
                                                    ?>
                                                       <li class="property-icon-square meta-block">
                                                        <?php echo JText::_('Line messasges');?>:
                                                       <span>
                                                           <?php echo $agentdetails->msn;?>
                                                       </span></li>
                                                    <?php
                                                    }
                                                    ?>
                                                    <?php
                                                    if(($agentdetails->facebook != "") and ($configClass['show_agent_facebook'] == 1)){
                                                    ?>
                                                       <li class="property-icon-square meta-block">
                                                        <?php echo JText::_('OS_FACEBOOK');?>:
                                                       <span>
                                                           <?php echo $agentdetails->facebook;?>
                                                       </span></li>
                                                    <?php
                                                    }
                                                    if(($agentdetails->aim != "") and ($configClass['show_agent_twitter'] == 1)){
                                                    ?>
                                                       <li class="property-icon-square meta-block">
                                                        <?php echo JText::_('Twitter');?>:
                                                       <span>
                                                           <?php echo $agentdetails->aim;?>
                                                       </span></li>
                                                    <?php
                                                    }
                                                    ?>
                                                    <?php
                                                    if($configClass['show_license'] == 1){
                                                    ?>
                                                       <li class="property-icon-square meta-block">
                                                        <?php echo JText::_('OS_LICENSE');?>:
                                                       <span>
                                                           <?php echo $agentdetails->license;?>
                                                       </span>
                                                       </li>
                                                    <?php
                                                    }
                                                    ?>
                                                </ul>
                                            <?php } ?>
                                        </div>
								</div>
							</div>
							<div class="<?php echo $bootstrapHelper->getClassMapping('span5'); ?>">
							<!-- request -->
								<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
									<strong>
										<?php echo JText::_('OS_REQUEST_MORE_INFOR')?>
									</strong>
								</div>
								<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
									<?php HelperOspropertyCommon::requestMoreDetailsTop($row,$itemid,'input-large form-control ilarge'); ?>
								</div>
								<!-- end request -->
							</div>
						</div>
					</div>
			<?php } ?>
		</div>
		<div class="detailsBar clearfix">
			<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
				<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?>">
					<div class="shell">
						<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
							<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?>">
								<div class="tabs clearfix">
									<!-- tab1 -->
									<?php
									$walkscore_div	= "";
									$gallery_div	= "";
									$comment_div	= "";
									$video_div		= "";
									$energy_div		= "";
									$sharing_div	= "";
									$request_div	= "";
									$education_div	= "";
									$history_div	= "";
									
									if(($configClass['show_gallery_tab'] == 1) and (count($photos) > 0))
									{
										$activate_tab = "gallery";
									}
									elseif(($configClass['show_walkscore'] == 1) and ($configClass['ws_id'] != ""))
									{
										$activate_tab = "walkscore";
									}
									elseif($configClass['comment_active_comment'] == 1)
									{
										$activate_tab = "comment";
									}
									elseif($row->pro_video != "")
									{
										$activate_tab = "video";
									}
									elseif(($configClass['energy'] == 1) and (($row->energy > 0) or ($row->climate > 0)))
									{
										$activate_tab = "epc";
									}
									elseif($configClass['property_mail_to_friends'] == 1)
									{
										$activate_tab = "tellafriend";
									}
									elseif(($configClass['show_request_more_details'] == 1) and ($configClass['show_agent_details'] == 0))
									{
										$activate_tab = "requestmoredetailsform";
									}
									elseif($configClass['integrate_education'] == 1)
									{
										$activate_tab = "education";
									}
									elseif(($configClass['use_property_history'] == 1) and (($row->price_history != "") or ($row->tax != "")))
									{
										$activate_tab = "historytab";
									}
								   
									echo JHtml::_('bootstrap.startTabSet', 'propertyinformation', array('active' => $activate_tab));

									
									
									if($configClass['show_gallery_tab'] == 1)
									{
										echo JHtml::_('bootstrap.addTab', 'propertyinformation', 'gallery', JText::_('OS_GALLERY', true));
											HelperOspropertyCommon::slimboxGallery($row->id,$photos);
										echo JHtml::_('bootstrap.endTab');
									}

									if(($configClass['show_walkscore'] == 1) and ($configClass['ws_id'] != ""))
									{
										if($configClass['ws_id'] != "")
										{
											echo JHtml::_('bootstrap.addTab', 'propertyinformation', 'walkscore', JText::_('OS_WALK_SCORE', true));
											echo $row->ws;
											echo JHtml::_('bootstrap.endTab');
										}
									}
									?>
									<?php
									if($configClass['comment_active_comment'] == 1)
									{
										echo JHtml::_('bootstrap.addTab', 'propertyinformation', 'comment', JText::_('OS_COMMENTS', true));
										echo $row->comments;
										if(($owner == 0) and ($can_add_cmt == 1)){
											HelperOspropertyCommon::reviewForm($row,$itemid,$configClass);
										}
										echo JHtml::_('bootstrap.endTab');
									}
									if($row->pro_video != "")
									{
										echo JHtml::_('bootstrap.addTab', 'propertyinformation', 'video', JText::_('OS_VIRTUAL_TOUR', true));
										echo stripslashes($row->pro_video);
										echo JHtml::_('bootstrap.endTab');
										?>
									<?php
									}
									?>
									<?php
									if(($configClass['energy'] == 1) and (($row->energy > 0) || ($row->climate > 0) || ($row->e_class != "") || ($row->c_class != "")))
									{
										echo JHtml::_('bootstrap.addTab', 'propertyinformation', 'epc', JText::_('OS_EPC', true));
										echo HelperOspropertyCommon::drawGraph($row->energy, $row->climate,$row->e_class,$row->c_class);
										echo JHtml::_('bootstrap.endTab');
									}
									if($configClass['property_mail_to_friends'] == 1)
									{
										echo JHtml::_('bootstrap.addTab', 'propertyinformation', 'tellafriend', JText::_('OS_SHARING', true));
										echo HelperOspropertyCommon::sharingForm($row,$itemid); 
										echo JHtml::_('bootstrap.endTab');
									}
									
									if(($configClass['show_request_more_details'] == 1) and ($configClass['show_agent_details'] == 0))
									{
										echo JHtml::_('bootstrap.addTab', 'propertyinformation', 'requestmoredetailsform', JText::_('OS_REQUEST_MORE_INFOR', true));
										echo HelperOspropertyCommon::requestMoreDetails($row,$itemid); 
										echo JHtml::_('bootstrap.endTab');
									}
									if($configClass['integrate_education'] == 1)
									{
										echo JHtml::_('bootstrap.addTab', 'propertyinformation', 'educationtab', JText::_('OS_EDUCATION', true));
										echo stripslashes($row->education);
										echo JHtml::_('bootstrap.endTab');
									}
									if(($configClass['use_property_history'] == 1) and (($row->price_history != "") or ($row->tax != "")))
									{
										echo JHtml::_('bootstrap.addTab', 'propertyinformation', 'historytab', JText::_('OS_HISTORY_TAX', true));
										if($row->price_history != "")
										{
											echo $row->price_history;
											echo "<BR />";
										}
										if($row->tax != "")
										{
											echo $row->tax;
										}
										echo JHtml::_('bootstrap.endTab');
									}
									echo JHtml::_('bootstrap.endTabSet');
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- tabs bottom -->
		<?php
		if(file_exists(JPATH_ROOT.DS."components/com_oscalendar/oscalendar.php")){
			if(($configClass['integrate_oscalendar'] == 1) and (in_array($row->pro_type,explode("|",$configClass['show_date_search_in'])))){
				?>
				<div class="detailsBar clearfix <?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?> calendar-detail">
					<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
						<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?>">
							<div class="property-calendar">
							<?php
							require_once(JPATH_ROOT.DS."components/com_oscalendar/classes/default.php");
							require_once(JPATH_ROOT.DS."components/com_oscalendar/classes/default.html.php");
							$otherlanguage =& JFactory::getLanguage();
							$otherlanguage->load( 'com_oscalendar', JPATH_SITE );
							OsCalendarDefault::calendarForm($row->id);
							?>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
		}
		?>
		<?php
		if(($configClass['relate_properties'] == 1) and ($row->relate != "")){
		?>
		<div class="detailsBar clearfix">
			<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
				<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?>">
					<div class="shell">
						<fieldset><legend><span><?php echo JText::_('OS_RELATE_PROPERTY')?></span></legend></fieldset>
						<?php
						echo $row->relate;
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
		}
		?>
		<?php
		if($integrateJComments == 1){
		?>
		<div class="detailsBar clearfix">
			<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
				<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?>">
					<div class="shell">
						<fieldset><legend><span><?php echo JText::_('OS_JCOMMENTS')?></span></legend></fieldset>
						<?php
						$comments = JPATH_SITE . DS .'components' . DS . 'com_jcomments' . DS . 'jcomments.php';
						if (file_exists($comments)) {
							require_once($comments);
							echo JComments::showComments($row->id, 'com_osproperty', $row->pro_name);
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
		}

		if(count($bottomPlugin) > 0){
			for($i=0;$i<count($bottomPlugin);$i++){
				echo $bottomPlugin[$i];
			}
		}
		if($configClass['social_sharing'] == 1){
		?>
		<div class="clearfix"></div>
		<?php
		echo $row->social_sharing;
		}
		?>
		<!-- end tabs bottom -->

		<!-- end wrap content -->
	</div>
</div>