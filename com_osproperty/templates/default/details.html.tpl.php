<?php

/*------------------------------------------------------------------------
# details.html.tpl.php - Ossolution Property
# ------------------------------------------------------------------------
# author     Ossolution
# copyright  Copyright (C) 2023 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites:  https://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/

// No direct access.
defined('_JEXEC') or die;
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::root()."components/com_osproperty/templates/".$themename."/style/style.css");
$document->addStyleSheet(JURI::root()."components/com_osproperty/templates/".$themename."/style/font.css");
$extrafieldncolumns = $params->get('extrafieldncolumns',3);
OSPHelperJquery::colorbox('osmodal');
?>
<style>
#main ul{
	margin:0px;
}
</style>
<script type="text/javascript">
function showhideDiv(id){
	var temp1 = document.getElementById('fs_' + id);
	var temp2 = document.getElementById('fsb_' + id);
	if(temp1.style.display == "block"){
		temp1.style.display = "none";
		temp2.innerHTML = "[+]";
	}else{
		temp1.style.display = "block";
		temp2.innerHTML = "[-]";
	}
	
}
</script>
<div id="notice" style="display:none;">
</div>
<?php
$db = JFactory::getDbo();
if(count($topPlugin) > 0)
{
	for($i=0;$i<count($topPlugin);$i++)
	{
		echo $topPlugin[$i];
	}
}
?>
<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>" id="propertydetails">
	<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?>">
		<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
			<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?>">
				<div class="floatleft width100">
					<h1 class="inlineblockdisplay">
						<?php
						if(($row->ref != "")  and ($configClass['show_ref'] == 1))
						{
							echo $row->ref.", ";
						}
						?>
						<?php echo $row->pro_name?>
						<?php
						if($row->isFeatured == 1)
						{
							?>
							<span class="featuredpropertydetails"><?php echo JText::_('OS_FEATURED');?></span>
							<?php
						}
						if(($configClass['active_market_status'] == 1) && ($row->isSold > 0))
						{
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
                        if(HelperOspropertyCommon::isAgent())
                        {
                            $my_agent_id = HelperOspropertyCommon::getAgentID();
                            if($my_agent_id == $row->agent_id){
                                $link = JURI::root()."index.php?option=com_osproperty&task=property_edit&id=".$row->id;
                                ?>
                                <a href="<?php echo $link?>" title="<?php echo JText::_('OS_EDIT_PROPERTY')?>" class="editproperty">
                                    <i class="edicon edicon-pencil"></i>
                                </a>
                                <?php
                            }
                        }
						?>
					</h1>
                    <?php
                    if($row->show_address == 1)
                    {
                        ?>
                        <div class="clearfix"></div>
                        <div class="address_details">
                            <?php echo OSPHelper::generateAddress($row);?>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="clearfix heightspace"></div>
                    <div class="property_statistic">
                        <?php
                        if($configClass['listing_show_rating'] == 1)
                        {
                            ?>
                            <i class="osicon-chart"></i>&nbsp;
                            <?php
                            $points = 0;
                            if($row->number_votes > 0)
                            {
                                $points = round($row->total_points/$row->number_votes);
                                for($i=1;$i<=$points;$i++){
                                    ?>
                                    <img src="<?php echo JURI::root(true)?>/media/com_osproperty/assets/images/star1.jpg" />
                                    <?php
                                }
                            }
                            for($i=$points+1;$i<=5;$i++)
                            {
                                ?>
                                <img src="<?php echo JURI::root(true)?>/media/com_osproperty/assets/images/star2.png" />
                                <?php
                            }
                            echo " <strong>(".$points."/5)</strong>";
                            ?>
                            <?php
                        }
                        ?>
                        /
                        <span class="osicon-eye"></span>
                        <?php echo $row->hits;?>
                    </div>
				</div>
			</div>
		</div>
		<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
			<div class="<?php echo $bootstrapHelper->getClassMapping('span8'); ?>">
				<?php
				if(OSPHelper::isJoomla4())
				{
				?>
					<div class="property-details-main-div">
						<?php echo JHtml::_('bootstrap.startTabSet', 'propertyDetailsTab', array('active' => 'tabphoto')); ?>
							<?php echo JHtml::_('bootstrap.addTab', 'propertyDetailsTab', 'tabphoto', JText::_('OS_PHOTO')); ?>
								<div class="tab-pane active">
								  <?php
								  if(count($photos) > 0)
								  {
								  ?>
									  <script type="text/javascript" src="<?php echo JUri::root()?>media/com_osproperty/assets/js/colorbox/jquery.colorbox.js"></script>
									  <script type="text/javascript">
									  jQuery(document).ready(function(){
										  jQuery(".propertyphotogroup").colorbox({rel:'colorbox',maxWidth:'95%', maxHeight:'95%'});
									  });
									  </script>
									  <?php
										$slidertype = 'slidernav';
										$animation = 'slide';
										$slideshow = 'true';
										$slideshowspeed = 5000;
										$arrownav = 'true';
										$controlnav = 'true' ;
										$keyboardnav = 'true';
										$mousewheel = 'false';
										$randomize =  'false';
										$animationloop =  'true';
										$pauseonhover =  'true' ;
										$target = 'self';
										$jquery = 'noconflict';
										
										JHTML::script('//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js');
										JHTML::script(Juri::root().'components/com_osproperty/templates/'.$themename.'/js/jquery.flexslider.js');
										JHTML::script(Juri::root().'components/com_osproperty/templates/'.$themename.'/js/jquery.mousewheel.js');

										//JHTML::stylesheet(Juri::root().'components/com_osproperty/templates/'.$themename.'/style/favslider.css');
										
										if ($jquery == 1 || $jquery == 0) { $noconflict = ''; $varj = '$';}
										
										if ($jquery == "noconflict") {$noconflict = 'jQuery.noConflict();'; $varj = 'jQuery';}
										
										if ($slidertype == "slidernav") 
										{
										
											echo '<style type= text/css>#carousel1 {margin-top: 3px;}</style>';
											$document->addScriptDeclaration('
											'.$noconflict.'
												jQuery(function () {
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
											'); 
										} 
										?>

									 <div id="slider1" class="favslider1 margin0">
										 <div class="property_type">
											 <?php
											 $needs = array();
											 $needs[] = "property_type";
											 $needs[] = "ltype";
											 $needs[] = "type_id=".$row->pro_type;
											 $itemid  = OSPRoute::getItemid($needle);
											 $link    = JRoute::_('index.php?option=com_osproperty&task=property_type&type_id='.$row->pro_type.'&Itemid='.$itemid);
											 echo "<a href='$link' title='$row->type_name'>".$row->type_name."</a>";
											 ?>
										 </div>
										 <div class="category_information">
											 <?php echo OSPHelper::getCategoryNamesOfPropertyWithLinks($row->id);?>
										 </div>
										 <?php
										 if($row->isFeatured == 1)
										 {
										 ?>
										 <div class="featured_property_sign">
											 <?php echo JText::_('OS_FEATURED');?>
										 </div>
										 <?php } ?>
										<ul class="favs">
										<?php
										   for($i=0;$i<count($photos);$i++)
										   {
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
									<div id="carousel1" class="favslider1">
										<ul class="favs">
										<?php 
										for($i=0;$i<count($photos);$i++)
										{
											if($photos[$i]->image != "")
											{
												if(JPATH_ROOT.'/images/osproperty/properties/'.$row->id.'/thumb/'.$photos[$i]->image)
												{
													?>
													<li <?php if ($i>0) {?>style="margin-left: 3px;width:120px !important;"<?php }else{ ?>style="width:120px !important; "<?php } ?>><img class="detailwidth" alt="<?php echo $photos[$i]->image_desc;?>" title="<?php echo $photos[$i]->image_desc;?>" src="<?php echo JURI::root()?>images/osproperty/properties/<?php echo $row->id;?>/thumb/<?php echo $photos[$i]->image?>" /></li>
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
												<li <?php if ($i>0) {?>style="margin-left: 3px;width:120px !important;"<?php }else{ ?>style="width:120px !important;"<?php } ?>><img src="<?php echo JURI::root()?>media/com_osproperty/assets/images/nopropertyphoto.png" /></li>
												<?php
											}
										}
										?>
										</ul>
									</div>
									<?php } 
									}
									else
									{
										?>
										<img src="<?php echo JUri::root(true)?>/media/com_osproperty/assets/images/nopropertyphoto.png" />
										<?php
									}
									?>
									
								</div>
							<?php echo JHtml::_('bootstrap.endTab') ?>
							<?php
							if ($configClass['goole_use_map'] == 1)
							{
								?>
								<?php echo JHtml::_('bootstrap.addTab', 'propertyDetailsTab', 'tabgoogle', JText::_('OS_MAP')); ?>
									<div class="tab-pane" id="tabgoogle">
										<div id="map_canvas" style="height: <?php echo $configClass['property_map_height'] ?>px; width: <?php echo $mapwidth ?>px;"></div>
									</div>
								<?php echo JHtml::_('bootstrap.endTab') ?>
								<?php
								if($configClass['map_type'] == 0)
								{
									if ($configClass['show_streetview'] == 1 && $row->show_address == 1) 
									{
										echo JHtml::_('bootstrap.addTab', 'propertyDetailsTab', 'tabstreet', JText::_('OS_STREET_VIEW'));
										?>
										<div class="tab-pane" id="tabstreet">
											<div id="pano" style="height: <?php echo $configClass['property_map_height']?>px; width: 100%;"></div>
										</div>
										<?php
										echo JHtml::_('bootstrap.endTab');
									}
								}
							}
							if($row->pro_video != "")
							{
								echo JHtml::_('bootstrap.addTab', 'propertyDetailsTab', 'avideo', JText::_('OS_VIDEO'));
								?>
								<div class="tab-pane" id="tabvideo">
									<?php
									echo stripslashes($row->pro_video);
									?>
								</div>
								<?php
								echo JHtml::_('bootstrap.endTab');
							}
							?>
						 <?php echo JHtml::_('bootstrap.endTabSet'); ?>
					</div>
				</div>
			<?php
			}
			else
			{
			?>
				<div class="property-details-main-div">
					<ul class="nav nav-tabs marginbottom0">
						<li class="active" id="liaphoto"><a href="#tabphoto" id="aphoto" data-toggle="tab"><?php echo JText::_('OS_PHOTO');?></a></li>
						<?php
                        if ($configClass['goole_use_map'] == 1)
                        {
                            if($configClass['map_type'] == 0)
                            {
                                ?>
                                <li id="liagooglemap"><a href="#tabgoogle" data-toggle="tab"
                                       id="agooglemap"><?php echo JText::_('OS_MAP'); ?></a></li>
                                <?php
                                if ($configClass['show_streetview'] == 1 && $row->show_address == 1) {
                                    ?>
                                    <li id="liastreetview"><a href="#tabstreet" data-toggle="tab"
                                           id="astreetview"><?php echo JText::_('OS_STREET_VIEW'); ?></a></li>
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
                                <li id="liagooglemap"><a href="#tabgoogle" data-toggle="tab"
                                       id="agooglemap"><?php echo JText::_('OS_MAP'); ?></a></li>
                                <?php
                            }
                        }
						if($row->pro_video != "")
						{
							?>
							<li id="liavideo"><a href="#tabvideo" data-toggle="tab" id="avideo"><?php echo JText::_('OS_VIDEO');?></a></li>
							<?php
						}
						?>
					</ul>
					 
					<div class="tab-content">
						<div class="tab-pane active" id="tabphoto">
						  <?php
						  if(count($photos) > 0)
						  {
						  ?>
							  <script type="text/javascript" src="<?php echo JUri::root()?>media/com_osproperty/assets/js/colorbox/jquery.colorbox.js"></script>
							  <script type="text/javascript">
							  jQuery(document).ready(function(){
								  jQuery(".propertyphotogroup").colorbox({rel:'colorbox',maxWidth:'95%', maxHeight:'95%'});
							  });
							  </script>
							  <?php
								$slidertype = 'slidernav';
								$animation = 'slide';
								$slideshow = 'true';
								$slideshowspeed = 5000;
								$arrownav = 'true';
								$controlnav = 'true' ;
								$keyboardnav = 'true';
								$mousewheel = 'false';
								$randomize =  'false';
								$animationloop =  'true';
								$pauseonhover =  'true' ;
								$target = 'self';
								$jquery = 'noconflict';
								
								if ($jquery != 0) {JHTML::script('//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js');}
								$document->addScript(Juri::root().'components/com_osproperty/templates/'.$themename.'/js/jquery.flexslider.js','text/javascript',true);
								$document->addScript(Juri::root().'components/com_osproperty/templates/'.$themename.'/js/jquery.mousewheel.js','text/javascript',true);

								//JHTML::stylesheet(Juri::root().'components/com_osproperty/templates/'.$themename.'/style/favslider.css');
								
								if ($jquery == 1 || $jquery == 0) { $noconflict = ''; $varj = '$';}
								
								if ($jquery == "noconflict") {$noconflict = 'jQuery.noConflict();'; $varj = 'jQuery';}
								
								if ($slidertype == "slidernav") {
								
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
								</script>'; } 
								?>

							 <div id="slider1" class="favslider1 margin0">
                                 <div class="property_type">
                                     <?php
                                     $needs = array();
                                     $needs[] = "property_type";
                                     $needs[] = "ltype";
                                     $needs[] = "type_id=".$row->pro_type;
                                     $itemid  = OSPRoute::getItemid($needle);
                                     $link    = JRoute::_('index.php?option=com_osproperty&task=property_type&type_id='.$row->pro_type.'&Itemid='.$itemid);
                                     echo "<a href='$link' title='$row->type_name'>".$row->type_name."</a>";
                                     ?>
                                 </div>
                                 <div class="category_information">
                                     <?php echo OSPHelper::getCategoryNamesOfPropertyWithLinks($row->id);?>
                                 </div>
                                 <?php
                                 if($row->isFeatured == 1)
                                 {
                                 ?>
                                 <div class="featured_property_sign">
                                     <?php echo JText::_('OS_FEATURED');?>
                                 </div>
                                 <?php } ?>
								<ul class="favs">
								<?php
								   for($i=0;$i<count($photos);$i++)
								   {
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
							<div id="carousel1" class="favslider1">
								<ul class="favs">
								<?php 
								for($i=0;$i<count($photos);$i++)
								{
									if($photos[$i]->image != "")
									{
										if(JPATH_ROOT.'/images/osproperty/properties/'.$row->id.'/thumb/'.$photos[$i]->image)
										{
											?>
											<li <?php if ($i>0) {?>style="margin-left: 3px;width:120px !important;"<?php }else{ ?>style="width:120px !important; "<?php } ?>><img class="detailwidth" alt="<?php echo $photos[$i]->image_desc;?>" title="<?php echo $photos[$i]->image_desc;?>" src="<?php echo JURI::root()?>images/osproperty/properties/<?php echo $row->id;?>/thumb/<?php echo $photos[$i]->image?>" /></li>
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
										<li <?php if ($i>0) {?>style="margin-left: 3px;width:120px !important;"<?php }else{ ?>style="width:120px !important;"<?php } ?>><img src="<?php echo JURI::root()?>media/com_osproperty/assets/images/nopropertyphoto.png" /></li>
										<?php
									}
								}
								?>
								</ul>
							</div>
							<?php } 
							}
							else
							{
								?>
								<img src="<?php echo JUri::root(true)?>/media/com_osproperty/assets/images/nopropertyphoto.png" />
								<?php
							}
							?>
							
						</div>
						<div class="tab-pane" id="tabgoogle">
                            <div id="map_canvas"
                                 style="height: <?php echo $configClass['property_map_height'] ?>px; width: <?php echo $mapwidth ?>px;"></div>
						</div>
						<?php 
						if(($configClass['show_streetview'] == 1) and ($row->show_address == 1))
						{
						?>
							<div class="tab-pane" id="tabstreet">
								<div id="pano" style="height: <?php echo $configClass['property_map_height']?>px; width: <?php echo $mapwidth?>px;"></div>
							</div>
						<?php
						}
						if($row->pro_video != "")
						{
						?>
							<div class="tab-pane" id="tabvideo">
								<?php
								echo stripslashes($row->pro_video);
								?>
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
			<div class="<?php echo $bootstrapHelper->getClassMapping('span4'); ?>">
				<div class="themedefault-box1 <?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
					<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?>">
						<?php echo $row->price?>
					</div>
				</div>
				<?php
                $db->setQuery("Select * from #__osrs_agents where id = '$row->agent_id'");
                $agentdetails = $db->loadObject();
				if(OSPHelper::allowShowingProfile($agentdetails->optin)){
					?>
                    <div class=" themedefault-box<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
                        <?php
                        if($configClass['show_agent_details'] == 1)
                        {
                            ?>
                            <div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?> agentinformation">
                                <div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
                                    <div class="<?php echo $bootstrapHelper->getClassMapping('span3'); ?>">
                                        <?php
                                        if(($configClass['show_agent_image'] == 1) && ($row->agentdetails->photo != "") && file_exists(JPATH_ROOT.'/images/osproperty/agent/thumbnail/'.$row->agentdetails->photo))
                                        {
                                            $link = JRoute::_("index.php?option=com_osproperty&task=agent_info&id=".$row->agent_id."&Itemid=".OSPRoute::getAgentItemid($row->agent_id));
                                            ?>
                                            <a href="<?php echo $link; ?>">
                                                <img class="img img-polaroid" src="<?php echo JUri::root()."images/osproperty/agent/thumbnail/".$row->agentdetails->photo ?>" alt="<?php echo $row->agentdetails->name;?>" />
                                            </a>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="<?php echo $bootstrapHelper->getClassMapping('span9'); ?>">
                                        <div class="agentName">
                                            <?php
                                            $link = JRoute::_("index.php?option=com_osproperty&task=agent_info&id=".$row->agent_id."&Itemid=".OSPRoute::getAgentItemid());
                                            ?>
                                            <a href="<?php echo $link;?>" title="<?php echo $row->agentdetails->name;?>">
                                                <?php echo $row->agentdetails->name;?>
                                            </a>
                                        </div>

                                        <?php
                                        if(($row->agentdetails->phone != "") && ($configClass['show_agent_phone'] == 1))
                                        {
                                            ?>
                                            <div class="headerphone">
                                                <i class="edicon edicon-phone"></i>
                                                <span id="phone_number">
                                            <?php
                                            echo JText::_('OS_PHONE');
                                            ?>
                                        </span>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <script type="text/javascript">
                                            jQuery(".headerphone").click(function(){
                                                jQuery("#phone_number").text('<?php echo $row->agentdetails->phone;?>');
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
                        <div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?> requestmoredetails">
                            <?php echo HelperOspropertyCommon::requestMoreDetailsTop($row,$itemid); ?>
                        </div>
                    </div>
				<?php } ?>
			</div>
		</div>
		<?php
		if(count($middlePlugin) > 0)
		{
			?>
			<div class="clearfix"></div>
			<?php
			for($i=0;$i<count($middlePlugin);$i++)
			{
				echo $middlePlugin[$i];
			}
		}
		?>
        <div class="clearfix"></div>
        <div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
            <div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?> sharebox">
                <?php
                if($configClass['social_sharing']== 1)
                {
                ?>
                    <ul class="pf-sharebar-icons">
                        <li>
                            <?php
                            $url = JRoute::_("index.php?option=com_osproperty&task=property_details&id=$row->id");
                            $url = JUri::getInstance()->toString(array('scheme', 'user', 'pass', 'host')).$url;
                            ?>
                            <a href="http://www.facebook.com/share.php?u=<?php echo $url;?>" target="_blank" class="btn btn-sm btn-o btn-facebook" title="<?php echo JText::_('OS_ASK_YOUR_FACEBOOK_FRIENDS');?>" id="link2Listing" rel="canonical">
                                <i class="edicon edicon-facebook"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://twitter.com/intent/tweet?original_referer=<?php echo $url;?>&tw_p=tweetbutton&url=<?php echo $url;?>" target="_blank" class="btn btn-sm btn-o btn-twitter" title="<?php echo JText::_('OS_ASK_YOUR_TWITTER_FRIENDS');?>" id="link2Listing" rel="canonical">
                                <i class="edicon edicon-twitter"></i>
                            </a>
                        </li>
                    </ul>
                <?php
                }
                ?>

                <ul class="pf-sharebar-others">
                    <?php
                    if($row->panorama != "")
                    {
                        ?>
                        <li>
                            <a rel="{handler: 'iframe', size: {x: 650, y: 420}}" href="<?php echo JURI::root()?>index.php?option=com_osproperty&tmpl=component&no_html=1&task=property_showpano&tmpl=component&id=<?php echo $row->id?>" title="<?php echo JText::_('OS_SHOW_PANORAMA_PICTURE')?>" class="osmodal">
                                <i class="osicon-picture"></i>
                                <?php
                                echo JText::_('OS_PANORAMA');
                                ?>
                            </a>
                        </li>
                        <?php
                    }
					$user = JFactory::getUser();
					if(($configClass['property_save_to_favories'] == 1) && ($user->id > 0))
					{
					?>
                    <li>
                        <?php
                        if($inFav == 0)
                        {
                            $msg = JText::_('OS_DO_YOU_WANT_TO_ADD_PROPERTY_TO_YOUR_FAVORITE_LISTS');
                            $msg = str_replace("'","\'",$msg);
                            ?>
                            <span id="fav<?php echo $row->id;?>">
								<a class="inactivated" onclick="javascript:osConfirmExtend('<?php echo $msg;?>','ajax_addFavorites','<?php echo $row->id?>','<?php echo JURI::root()?>','fav<?php echo $row->id; ?>','default','details')" href="javascript:void(0)" title="<?php echo JText::_('OS_ADD_TO_FAVORITES')?>">
									<i class="edicon edicon-heart"></i>
                                    <?php
                                    echo JText::_('OS_FAVORITE');
                                    ?>
								</a>
								</span>
                            <?php
                        }
                        else
                        {
                            $msg = JText::_('OS_DO_YOU_WANT_TO_REMOVE_PROPERTY_OUT_OF_YOUR_FAVORITE_LISTS');
                            $msg = str_replace("'","\'",$msg);
                            ?>
                            <span id="fav<?php echo $row->id;?>">
								<a onclick="javascript:osConfirmExtend('<?php echo $msg;?>','ajax_removeFavorites','<?php echo $row->id?>','<?php echo JURI::root()?>','fav<?php echo $row->id; ?>','default','details')" href="javascript:void(0)" title="<?php echo JText::_('OS_REMOVE_FAVORITES')?>">
									<I class="edicon edicon-heart"></I>
                                    <?php
                                    echo JText::_('OS_FAVORITE');
                                    ?>
								</a>
								</span>
                            <?php
                        }?>
                    </li>
                    <?php
                    }
                    if($configClass['show_compare_task'] == 1)
                    {
                        ?>
                        <li>
                            <?php
                            if(! OSPHelper::isInCompareList($row->id))
                            {
                                $msg = JText::_('OS_DO_YOU_WANT_TO_ADD_PROPERTY_TO_YOUR_COMPARE_LIST');
                                $msg = str_replace("'","\'",$msg);
                                ?>
                                <span id="compare<?php echo $row->id;?>">
									<a class="inactivated" onclick="javascript:osConfirmExtend('<?php echo $msg; ?>','ajax_addCompare','<?php echo $row->id ?>','<?php echo JURI::root() ?>','compare<?php echo $row->id;?>','default','details')" href="javascript:void(0)" title="<?php echo JText::_('OS_ADD_TO_COMPARE_LIST')?>">
										<i class="edicon edicon-copy"></i>
                                        <?php
                                        echo JText::_('OS_COMPARISON');
                                        ?>
									</a>
								</span>
                                <?php
                            }
                            else
                            {
                                $msg = JText::_('OS_DO_YOU_WANT_TO_REMOVE_PROPERTY_OUT_OF_COMPARE_LIST');
                                $msg = str_replace("'","\'",$msg);
                                ?>
                                <span id="compare<?php echo $row->id;?>">
                                <a class="activated" onclick="javascript:osConfirmExtend('<?php echo $msg; ?>','ajax_removeCompare','<?php echo $row->id ?>','<?php echo JURI::root() ?>','compare<?php echo $row->id;?>','default','details')" href="javascript:void(0)" title="<?php echo JText::_('OS_REMOVE_FROM_COMPARE_LIST');?>">
										<i class="edicon edicon-copy"></i>
                                    <?php
                                    echo JText::_('OS_COMPARISON');
                                    ?>
                                </a>
                                </span><?php
                            }
                            ?>
                        </li>
                        <?php
                    }
                    if($row->pro_pdf != "")
                    {
                        ?>
                        <li>
                            <a href="<?php echo $row->pro_pdf?>" title="<?php echo JText::_('OS_OPEN_PROPERTY_DOCUMENT')?>" alt="<?php echo JText::_('OS_OPEN_PROPERTY_DOCUMENT')?>" target="_blank">
                                <span class="edicon edicon-link"></span>
                                <?php echo strtoupper(JText::_('OS_DOCUMENT')); ?>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                    <?php
                    if($row->pro_pdf_file != "")
                    {
                        ?>
                        <li>
                            <?php
                            if(file_exists(JPATH_ROOT.'/media/com_osproperty/document/'.$row->pro_pdf_file))
                            {
                                $fileUrl = JUri::root().'media/com_osproperty/document/'.$row->pro_pdf_file;
                            }
                            else
                            {
                                $fileUrl = JUri::root().'components/com_osproperty/document/'.$row->pro_pdf_file;
                            }
                            ?>
                            <a href="<?php echo $fileUrl ;?>" title="<?php echo JText::_('OS_DOWNLOAD_PROPERTY_DOCUMENT')?>" alt="<?php echo JText::_('OS_DOWNLOAD_PROPERTY_DOCUMENT')?>" target="_blank">
                                <span class="edicon edicon-download"></span>
                                &nbsp;
                                <?php echo strtoupper(JText::_('OS_DOWNLOAD_DOCUMENT')); ?>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                    <?php
                    if($configClass['property_show_print'] == 1)
                    {
                        ?>
                        <li>
                            <a target="_blank" href="<?php echo JURI::root()?>index.php?option=com_osproperty&tmpl=component&no_html=1&task=property_print&id=<?php echo $row->id?>">
                                <span class="edicon edicon-printer"></span>
                                &nbsp;
                                <?php echo strtoupper(JText::_('OS_PRINT'));?>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                    <?php
                    if($configClass['property_pdf_layout'] == 1)
                    {
                        ?>
                        <li>
                            <a href="<?php echo JURI::root()?>index.php?option=com_osproperty&no_html=1&task=property_pdf&id=<?php echo $row->id?>" title="<?php echo JText::_('OS_EXPORT_PDF')?>"  rel="nofollow" target="_blank">
                                <span class="edicon edicon-file-pdf"></span>
                                &nbsp;
                                <?php echo strtoupper(JText::_('OS_PDF'));?>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                    <?php
                    if($configClass['enable_report'] == 1)
                    {
						OSPHelperJquery::colorbox('a.reportmodal');
                        ?>
                        <li>
                            <a class="reportmodal" href="<?php echo JURI::root()?>index.php?option=com_osproperty&tmpl=component&item_type=0&task=property_reportForm&id=<?php echo $row->id?>" title="<?php echo JText::_('OS_REPORT_LISTING');?>">
                                <span class="edicon edicon-warning"></span>
                                &nbsp
                                <?php echo strtoupper(JText::_('OS_REPORT'));?>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
		<div class="clearfix"></div>
		<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>" id="propertydetailspage">
			<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?> margintop10">
				<div class="tab-content padding0 margin0">
					<?php
					echo JHtml::_('bootstrap.startTabSet', 'property', array('active' => 'overviewtab'));
					?>
					<?php
					echo JHtml::_('bootstrap.addTab', 'property', 'overviewtab', JText::_('OS_OVERVIEW', true));
					?>
					<div id="overviewtab" class="tab-pane active <?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
						<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?> noleftmargin ">
                            <div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
                                <div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?>">
									<h4>
										<?php echo JText::_('OS_DESCRIPTION')?>
									</h4>
                                    <?php
                                    if($row->open_hours != "")
                                    {
                                        ?>
                                        <div class="openhours">
                                            <?php
                                            echo $row->open_hours;
                                            ?>
                                        </div>
                                        <?php
                                    }
                                    $row->pro_small_desc = OSPHelper::getLanguageFieldValue($row,'pro_small_desc');
                                    if($row->pro_small_desc != "")
                                    {
                                        echo stripslashes($row->pro_small_desc);
                                        echo "<BR />";
                                    }
                                    $pro_full_desc = OSPHelper::getLanguageFieldValue($row,'pro_full_desc');
                                    $row->pro_full_desc =  JHtml::_('content.prepare', $pro_full_desc);
                                    echo stripslashes($row->pro_full_desc);
                                    ?>
                                </div>
                            </div>
                            <div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?> noleftmargin marginbottom10">
                                <div class="<?php echo $bootstrapHelper->getClassMapping('span6'); ?> noleftmargin padding0">
                                    <?php
                                    if(count((array)$tagArr) > 0)
									{
                                        ?>
                                        <div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
                                            <div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?>">
                                                <i class="osicon-comments"></i>&nbsp;
                                                <?php
                                                echo JText::_('OS_TAGS').":";
                                                ?>
                                                <?php
                                                echo implode(" ",$tagArr);
                                                ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?> noleftmargin">
                                <div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?> noleftpadding">
                                    <?php
                                    echo $row->core_fields1;
                                    ?>
                                </div>
                            </div>

                            <div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?> noleftmargin">
                                <div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?> noleftpadding">
                                    <?php
                                    if($configClass['energy'] == 1)
									{
                                        if(($row->energy > 0) || ($row->climate > 0) || ($row->e_class != "") || ($row->c_class != ""))
										{
                                            if($row->energy == "0.00")
											{
                                                $row->energy = "null";
                                            }
                                            if($row->climate == "0.00")
											{
                                                $row->climate = "null";
                                            }
                                            ?>
                                            <div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
                                                <div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?>">
                                                    <strong>
                                                        <?php
                                                        echo JText::_('OS_DPE').":";
                                                        ?>
                                                    </strong>
                                                </div>
                                            </div>
                                            <div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
                                                <div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?>">
                                                    <?php
                                                    echo HelperOspropertyCommon::drawGraph($row->energy, $row->climate,$row->e_class,$row->c_class);
                                                    ?>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>

							<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?> noleftmargin">
								<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?> noleftmargin">
									<?php
									if(($configClass['show_amenity_group'] == 1) and ($row->amens_str1 != ""))
									{
									?>
										<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
											<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?> noleftpadding paddingtop20">
												<h4>
                                                    <?php echo JText::_('OS_AMENITIES')?>
												</h4>
											</div>
										</div>
										<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
											<?php echo $row->amens_str1;?>
										</div>
									<?php
									}
									?>
								</div>
							</div>
							<?php
							if(($configClass['show_neighborhood_group'] == 1) and ($row->neighborhood != ""))
							{
							?>
                                <div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?> noleftmargin">
                                    <div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?> noleftpadding paddingtop20">
                                        <h4>
                                            <?php echo JText::_('OS_NEIGHBORHOOD')?>
                                        </h4>
                                    </div>
                                </div>
                                <div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
                                    <?php
                                    echo $row->neighborhood2;
                                    ?>
                                </div>
							<?php 
							}
							if(count($row->extra_field_groups) > 0)
							{
								if($extrafieldncolumns == 2)
								{
									$span = $bootstrapHelper->getClassMapping('span6');
									$jump = 2;
								}
								else
								{
									$span = $bootstrapHelper->getClassMapping('span4');
									$jump = 3;
								}
								$extra_field_groups = $row->extra_field_groups;
								for($i=0;$i<count($extra_field_groups);$i++)
								{
									$group = $extra_field_groups[$i];
									$group_name = $group->group_name;
									$fields = $group->fields;
									if(count($fields)> 0){
									?>
									<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?> noleftmargin paddingtop20">
										<h4>
											<?php echo $group_name;?>
										</h4>
									</div>
									<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
										<?php
										$k = 0;
										for($j=0;$j<count($fields);$j++)
										{
											$field = $fields[$j];
											if($field->field_type != "textarea")
											{
												$k++;
												?>
												<div class="<?php echo $span; ?>">
													<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
  <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
</svg>
													<?php
													if(($field->displaytitle == 1) || ($field->displaytitle == 2)){
														?>
														<?php
														if($field->field_description != ""){
															?>
															<span class="editlinktip hasTip" title="<?php echo $field->field_label;?>::<?php echo $field->field_description?>">
																<?php echo $field->field_label;?>
															</span>
														<?php
														}else{
															?>
															<?php echo $field->field_label;?>
														<?php
														}
													}
													?>
													<?php
													if($field->displaytitle == 1){
														?>
														:&nbsp;
													<?php } ?>
													<?php if(($field->displaytitle == 1) || ($field->displaytitle == 3)){?>
														<?php echo $field->value;?> <?php } ?>
												</div>
												<?php
												if($k == $jump)
												{
													?>
													</div><div class='<?php echo $bootstrapHelper->getClassMapping('row-fluid');?> minheight0'>
													<?php
													$k = 0;
												}
											}
										}
										?>
									</div>
									<?php
										for($j=0;$j<count($fields);$j++) 
										{
											$field = $fields[$j];
											if ($field->field_type == "textarea") 
											{
												?>
												<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
													<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?>">
														<?php
														if (($field->displaytitle == 1) or ($field->displaytitle == 2)) 
														{
															?>
															<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
  <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
</svg>
															<?php
															if ($field->field_description != "") 
															{
																?>
																<span class="editlinktip hasTip"
																	  title="<?php echo $field->field_label;?>::<?php echo $field->field_description?>">
																	<strong><?php echo $field->field_label;?></strong>
																</span>
																<BR/>
															<?php
															} 
															else 
															{
																?>
																<strong><?php echo $field->field_label;?></strong>
															<?php
															}
														}
														?>
														<?php if (($field->displaytitle == 1) or ($field->displaytitle == 3)) { ?>
															<?php echo $field->value; ?>
														<?php } ?>
													</div>
												</div>
											<?php
											}
										}
									}
								}
							}
							?>
							<?php
							if($row->price_history != "" || $row->tax != "")
							{
								?>
								<div id="historytab" class="paddingtop20">
									<?php
									if($row->price_history != "")
									{
										echo $row->price_history;
									}
									if($row->tax != "")
									{
										echo $row->tax;
									}
									?>
								</div>
							    <?php
							}
							?>
						</div>
					</div>
					<?php
					echo JHtml::_('bootstrap.endTab');
					?>
					<?php
					if($configClass['show_agent_details'] == 1)
					{
					?>
						<?php
						echo JHtml::_('bootstrap.addTab', 'property', 'agenttab', OSPHelper::loadAgentType($row->agent_id));
						?>
						<div id="agenttab" class="tab-pane">
							<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
								<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?> margintop10">
									<?php
									echo $row->agent;
									?>
								</div>
							</div>
						</div>
						<?php
						echo JHtml::_('bootstrap.endTab');
					}
					if(($configClass['show_walkscore'] == 1) and ($configClass['ws_id'] != "")){
					?>
						<?php
						echo JHtml::_('bootstrap.addTab', 'property', 'walkscoretab',JText::_('OS_WALK_SCORE'));
						?>
						<div id="walkscoretab" class="tab-pane">
							<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
								<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?> margintop10">
									<?php
									echo $row->ws;
									?>
								</div>
							</div>
						</div>
						<?php
						echo JHtml::_('bootstrap.endTab');
						?>
					<?php
					}
					if($configClass['property_mail_to_friends'] == 1){
					?>
						<?php
						echo JHtml::_('bootstrap.addTab', 'property', 'sharingtab',JText::_('OS_SHARING'));
						?>
						<div id="sharingtab" class="tab-pane">
							<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
								<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?> margintop10">
									<?php HelperOspropertyCommon::sharingForm($row,$itemid) ; ?>
								</div>
							</div>
						</div>
						<?php
						echo JHtml::_('bootstrap.endTab');
						?>
					<?php }
					if($configClass['show_request_more_details'] == 1){
					?>
						<?php
						echo JHtml::_('bootstrap.addTab', 'property', 'request_more_details_tab',JText::_('OS_REQUEST_MORE_INFOR'));
						?>
						<div id="request_more_details_tab" class="tab-pane">
							<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
								<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?> margintop10">
									<?php HelperOspropertyCommon::requestMoreDetails($row,$itemid) ;?>
								</div>
							</div>
						</div>
						<?php
						echo JHtml::_('bootstrap.endTab');
						?>
					<?php
					}
					if($configClass['comment_active_comment'] == 1){
					?>
						<?php
						echo JHtml::_('bootstrap.addTab', 'property', 'reviewtab',JText::_('OS_REVIEW'));
						?>
						<div id="reviewtab" class="tab-pane">
							<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
								<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?> margintop10">
									<?php
									echo $row->comments;
									if(($owner == 0) and ($can_add_cmt == 1)){
										HelperOspropertyCommon::reviewForm($row,$itemid,$configClass);
									}
									?>
								</div>
							</div>
						</div>
						<?php
						echo JHtml::_('bootstrap.endTab');
						?>
					<?php
					}
					if($configClass['integrate_education'] == 1){
					?>
						<?php
						echo JHtml::_('bootstrap.addTab', 'property', 'educationtab',JText::_('OS_EDUCATION'));
						?>
							<div class="tab-pane" id="educationtab">
								<?php
								echo stripslashes($row->education);
								?>
							</div>
						<?php
						echo JHtml::_('bootstrap.endTab');
						?>
					<?php
					}
					?>
				<?php
				echo JHtml::_('bootstrap.endTabSet');
				?>
				</div>
			</div>
		</div>
		<?php
		if(file_exists(JPATH_ROOT.DS."components".DS."com_oscalendar".DS."oscalendar.php"))
		{
			if(($configClass['integrate_oscalendar'] == 1) && (in_array($row->pro_type,explode("|",$configClass['show_date_search_in']))))
			{
				require_once(JPATH_ROOT.DS."components".DS."com_oscalendar".DS."classes".DS."default.php");
				require_once(JPATH_ROOT.DS."components".DS."com_oscalendar".DS."classes".DS."default.html.php");
				$otherlanguage =& JFactory::getLanguage();
				$otherlanguage->load( 'com_oscalendar', JPATH_SITE );
				?>
				<div class="detailsBar clearfix">
					<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
						<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?> paddingtop20">
							<h4><i class="edicon edicon-calendar"></i>&nbsp;<?php echo JText::_('OS_AVAILABILITY')?></h4>
							<?php
							OsCalendarDefault::calendarForm($row->id);
							?>
						</div>
					</div>
				</div>
				<?php
			}
		}

		if($row->relate != "" && $configClass['relate_properties'] == 1)
		{
            ?>
            <div class="detailsBar clearfix">
                <div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
                    <div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?> paddingtop20">
                        <h4><i class="edicon edicon-home2"></i>&nbsp;<?php echo JText::_('OS_RELATE_PROPERTY')?></h4>
                        <?php
                        echo $row->relate;
                        ?>
                    </div>
                </div>
            </div>
            <?php
		}
		?>

		<div class="jwts_clr"></div>
		<?php
		if($integrateJComments == 1)
		{
		?>
			<div class="detailsBar clearfix">
				<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
					<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?>">
						<div class="shell">
							<fieldset><legend><span><i class="edicon edicon-bubbles3"></i>&nbsp;<?php echo JText::_('OS_JCOMMENTS')?></span></legend></fieldset>
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
		?>
	</div>
</div>
<input type="hidden" name="process_element" id="process_element" value="" />