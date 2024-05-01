<?php
/*------------------------------------------------------------------------
# advSearchForm.php - Ossolution Property
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2017 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/
$rowFluidClass      = $bootstrapHelper->getClassMapping('row-fluid');
$span12Class        = $bootstrapHelper->getClassMapping('span12');
$span10Class        = $bootstrapHelper->getClassMapping('span10');
$span4Class         = $bootstrapHelper->getClassMapping('span4');
$span3Class         = $bootstrapHelper->getClassMapping('span3');
$span2Class         = $bootstrapHelper->getClassMapping('span2');
$inputMediumClass	= $bootstrapHelper->getClassMapping('input-medium');
$inputLargeClass	= $bootstrapHelper->getClassMapping('input-large');
$inputSmallClass	= $bootstrapHelper->getClassMapping('input-small');
?>
<div class="<?php echo $rowFluidClass; ?>" id="ospropertyadvsearch">
	<div class="<?php echo $span12Class; ?>">
		<div class="tab-content margintop10">
			<?php
			echo JHtml::_('bootstrap.startTabSet', 'advsearch', array('active' => 'general-information'));
			?>
			<?php
			echo JHtml::_('bootstrap.addTab', 'advsearch', 'general-information', JText::_('OS_GENERAL_INFORMATION', true));
			?>
			<div class="tab-pane active" id="general-information" >
				<fieldset>
					<div class="<?php echo $rowFluidClass; ?>">
						<?php $increase_div = 0; ?>
						<div class="<?php echo $span4Class; ?> searchfields">
							<strong>
								<?php echo JText::_('OS_CATEGORY')?>
							</strong>
							<div class="clearfix"></div>
							<?php echo $lists['category']; ?>
							<?php $increase_div++;?>
						</div>
						<?php
						if(($configClass['adv_type_ids'] == "0") or ($configClass['adv_type_ids'] == ""))
						{
						$increase_div++;
						?>
                            <div class="<?php echo $span4Class; ?> searchfields">
                                <strong>
                                    <?php echo JText::_('OS_PROPERTY_TYPE')?>
                                </strong>
                                <div class="clearfix"></div>
                                <?php echo $lists['type'];?>
                            </div>
						<?php
						}
						else
						{
							?>
							<input type="hidden" name="property_type" id="property_type" value="<?php echo $type_id_search?>" />
							<?php
						}
						if(OSPHelper::checkOwnerExisting())
						{
                            $increase_div++;
                            ?>
                            <div class="<?php echo $span4Class; ?> searchfields">
                                <strong>
                                    <?php echo JText::_('OS_PROPERTIES_POSTED_BY')?>:
                                </strong>
                                <div class="clearfix"></div>
                                <?php echo $lists['agenttype']; ?>
                            </div>
						    <?php
						}
						?>
						<?php
						if($increase_div == 3)
						{
							$increase_div = 0;
							?>
							</div>
							<div class="<?php echo $rowFluidClass; ?>">
							<?php
						}
						?>
						<div class="<?php echo $span4Class; ?> ">
							<strong>
								<?php echo JText::_('OS_PRICE_RANGE')?>
							</strong>
							<BR />
							<?php //echo $lists['price']; 
							OSPHelper::showPriceFilter($lists['price_value'],$lists['min_price'],$lists['max_price'],$lists['adv_type'],'','adv');
							?>
						</div>
						<?php $increase_div++;?>
						<?php
						if($increase_div == 3)
						{
							$increase_div = 0;
							?>
							</div>
							<div class="<?php echo $rowFluidClass; ?>">
							<?php
						}
						?>							
						<div class="<?php echo $span4Class; ?> searchfields">
							<strong>
								<?php echo JText::_('OS_KEYWORD');?>
							</strong>
							<div class="clearfix"></div>
							<input type="text" class="<?php echo $inputLargeClass; ?>" value="<?php echo htmlspecialchars($lists['keyword_value'])?>" name="keyword"/>
						</div>
						<?php $increase_div++;?>
						<?php
						if($increase_div == 3)
						{
							$increase_div = 0;
							?>
							</div>
							<div class="<?php echo $rowFluidClass; ?>">
							<?php
						}
						?>
						<div class="<?php echo $span4Class; ?> searchfields">
							<strong>
								<?php echo JText::_('OS_SORTBY')?>
							</strong>
							<div class="clearfix"></div>
							<?php echo $lists['sortby'];?>
						</div>
						<?php $increase_div++;?>
						<?php
						if($increase_div == 3){
							$increase_div = 0;
							?>
							</div>
							<div class="<?php echo $rowFluidClass; ?>">
							<?php
						}
						?>


						<div class="<?php echo $span4Class; ?> searchfields">
							<strong>
								<?php echo JText::_('OS_ORDERBY')?>
							</strong>
							<div class="clearfix"></div>
							<?php echo $lists['orderby'];?>
						</div>
						<?php $increase_div++;?>
						<?php
						if($increase_div == 3){
							$increase_div = 0;
							?>
							</div>
							<div class="<?php echo $rowFluidClass; ?>">
							<?php
						}
						?>
					</div>
				</fieldset>
			</div>
			<?php
			echo JHtml::_('bootstrap.endTab');
			?>
			<?php
			echo JHtml::_('bootstrap.addTab', 'advsearch', 'location-tab', JText::_('OS_LOCATION', true));
			?>
			<div class="tab-pane" id="location-tab" >
				<fieldset>
					<?php $increase_div = 0; ?>
					<div class="<?php echo $rowFluidClass; ?>">
						<?php $increase_div++;?>
						<div class="<?php echo $span4Class; ?> searchfields">
							<strong>
								<?php echo JText::_('OS_ADDRESS');?>
							</strong>
							<div class="clearfix"></div>
							<input type="text" class="<?php echo $inputMediumClass; ?>" value="<?php echo htmlspecialchars($lists['address_value']);?>" name="address" />
						</div>
						<?php
						if(HelperOspropertyCommon::checkCountry()){
							$increase_div++;
						?>
							<div class="<?php echo $span4Class; ?> searchfields">
								<strong>
									<?php echo JText::_('OS_COUNTRY')?>
								</strong>
								<div class="clearfix"></div>
								<?php echo $lists['country']?>
							</div>
						<?php
						}

                        if(OSPHelper::userOneState())
                        {
							echo $lists['state'];
						}
						else
						{
							$increase_div++; //state
						?>
							<div class="<?php echo $span4Class; ?> searchfields">
								<strong>
									<?php echo JText::_('OS_STATE')?>
								</strong>
								<div class="clearfix"></div>
								<div id="country_state">
									<?php echo $lists['state']?>
								</div>
							</div>
						<?php
						}
						if($increase_div == 3)
						{
							$increase_div = 0;
							?>
							</div>
							<div class="<?php echo $rowFluidClass; ?>">
							<?php
						}
						$increase_div++; //city
						?>
						<div class="<?php echo $span4Class; ?> searchfields">
							<strong>
								<?php echo JText::_('OS_CITY')?>
							</strong>
							<div class="clearfix"></div>
							<div id="city_div">
							<?php echo $lists['city']?>
							</div>
						</div>
						<?php
						if($increase_div == 3)
						{
							$increase_div = 0;
							?>
							</div>
							<div class="<?php echo $rowFluidClass; ?>">
							<?php
						}
						$increase_div++;
						?>
						<div class="<?php echo $bootstrapHelper->getClassMapping('span8'); ?>">
							<strong>
								<?php echo JText::_('OS_POSTCODE')?>
							</strong>
							<div class="clearfix"></div>
							<input type="text" class="<?php echo $inputSmallClass; ?> ishort" value="<?php echo $lists['postcode'];?>" id="postcode" name="postcode" placeholder="<?php echo JText::_('OS_POSTCODE');?>" />
							<?php 
							if($configClass['show_my_location'] == 1)
							{
							?>
							<?php echo JText::_('OS_OR');?>
							<span class="adv_geoloc_icon button" onclick="javascript:updateMyLocation();" id="se_geoloc_icon" title="<?php echo JText::_('OS_SEARCH_GEOLOC_TOOLTIP_INFO'); ?>" ></span>
							<?php } ?>
							<input type="hidden" name="se_geoloc" id="se_geoloc" value="<?php echo $lists['se_geoloc'];?>" />
							&nbsp;
							<?php echo $lists['radius']; ?>
						</div>
						<?php
						if($increase_div == 3)
						{
							$increase_div = 0;
							?>
							</div>
							<div class="<?php echo $rowFluidClass; ?>">
							<?php
						}
						?>
					</div>
				</fieldset>
			</div>
			<?php
			echo JHtml::_('bootstrap.endTab');
			?>
			<?php
            if(count($amenities) > 0)
			{
                echo JHtml::_('bootstrap.addTab', 'advsearch', 'amenities-tab', JText::_('OS_AMENITIES', true));
                ?>
                <div class="tab-pane" id="amenities-tab">
                    <fieldset>
                        <div class="<?php echo $rowFluidClass; ?>">
                            <div class="<?php echo $span12Class; ?>">
                                <?php
                                $optionArr = array();
                                $optionArr[] = JText::_('OS_GENERAL_AMENITIES');
                                $optionArr[] = JText::_('OS_ACCESSIBILITY_AMENITIES');
                                $optionArr[] = JText::_('OS_APPLIANCE_AMENITIES');
                                $optionArr[] = JText::_('OS_COMMUNITY_AMENITIES');
                                $optionArr[] = JText::_('OS_ENERGY_SAVINGS_AMENITIES');
                                $optionArr[] = JText::_('OS_EXTERIOR_AMENITIES');
                                $optionArr[] = JText::_('OS_INTERIOR_AMENITIES');
                                $optionArr[] = JText::_('OS_LANDSCAPE_AMENITIES');
                                $optionArr[] = JText::_('OS_SECURITY_AMENITIES');

                                $amenities_post = $jinput->get('amenities', array(), 'ARRAY');
                                $j = 0;
                                for ($k = 0; $k < count($optionArr); $k++) {
                                    $j++;
                                    $db->setQuery("Select * from #__osrs_amenities where category_id = '" . $k . "' and published = '1'");
                                    $amenities = $db->loadObjectList();
                                    if (count($amenities) > 0) {
                                        ?>
                                        <div class="<?php echo $rowFluidClass; ?>">
                                            <div class="<?php echo $span12Class; ?>">
                                                <strong>
                                                    <?php echo $optionArr[$k]; ?>
                                                </strong>
                                            </div>
                                        </div>
                                    <div class="<?php echo $rowFluidClass; ?>">
                                        <?php
                                        $j = 0;
                                        for ($i = 0; $i < count($amenities); $i++)
                                        {
                                            $j++;
                                            if (isset($amenities_post))
                                            {
                                                if (in_array($amenities[$i]->id, $amenities_post))
                                                {
                                                    $checked = "checked";
                                                }
                                                else
                                                {
                                                    $checked = "";
                                                }
                                            }
                                            else
                                            {
                                                $checked = "";
                                            }
                                            ?>
                                            <div class="<?php echo $span3Class; ?>">
                                                <label for="amenities<?php echo $amenities[$i]->id; ?>">
                                                    <input type="checkbox" name="amenities[]"
                                                           id="amenities<?php echo $amenities[$i]->id; ?>" <?php echo $checked ?>
                                                           value="<?php echo $amenities[$i]->id; ?>"/> <?php echo OSPHelper::getLanguageFieldValue($amenities[$i], 'amenities'); ?>
                                                </label>
                                            </div>
                                            <?php
                                            if ($j == 4)
                                            {
                                                $j = 0;
                                                ?>
                                                </div><div class="<?php echo $rowFluidClass; ?>">
                                                <?php
                                            }
                                        }
                                        ?>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <?php
                echo JHtml::_('bootstrap.endTab');
            }
			echo JHtml::_('bootstrap.addTab', 'advsearch', 'other-tab', JText::_('OS_OTHER', true));
			?>
			<div class="tab-pane" id="other-tab" >
				<div class="<?php echo $rowFluidClass; ?>">
					<?php $increase_div = 0; ?>
					<div class="<?php echo $span4Class; ?>">
						<?php
						$isFeatured = $jinput->getInt('isFeatured',0);
						if($isFeatured == 1)
						{
							$checked = "checked";
						}
						else
						{
							$checked = "";
						}
						?>
						<input type="checkbox" name="isFeatured" id="isFeatured" value="<?php echo $isFeatured;?>" <?php echo $checked;?> onclick="javascript:changeValue('isFeatured')" />
						&nbsp;
						<strong>
							<?php echo JText::_('OS_SHOW_ONLY_FEATURED_PROPERTIES');?> 
						</strong>
					</div>
					<?php $increase_div++;?>
					<?php
					if($increase_div == 3)
					{
						$increase_div = 0;
						?>
						</div>
						<div class="<?php echo $rowFluidClass; ?>">
						<?php
					}

                    if($configClass['active_market_status'] == 1)
					{
					?>
					<div class="<?php echo $span4Class; ?> searchfields">
						<strong>
							<?php echo JText::_('OS_MARKET_STATUS');?> 
						</strong>
						<?php
						echo $lists['marketstatus'];
						?>
					</div>
					<?php $increase_div++;?>
					<?php } ?>
					<?php
					if($increase_div == 3)
					{
						$increase_div = 0;
						?>
						</div>
						<div class="<?php echo $rowFluidClass; ?>">
						<?php
					}
					?>
					<?php
					if($configClass['use_bathrooms'] == 1)
					{
						$increase_div++;
					    ?>
						<div class="<?php echo $span4Class; ?> searchfields">
							<strong>
								<?php echo JText::_('OS_BATHROOMS')?>
							</strong>
							<div class="clearfix"></div>
							<?php echo $lists['nbath'];?>
						</div>
					    <?php
					}
					if($increase_div == 3)
					{
						$increase_div = 0;
						?>
						</div>
						<div class="<?php echo $rowFluidClass; ?>">
						<?php
					}
					if($configClass['use_bedrooms'] == 1)
					{
						$increase_div++;
					    ?>
						<div class="<?php echo $span4Class; ?> searchfields">
							<strong>
								<?php echo JText::_('OS_BEDROOMS')?>
							</strong>
							<div class="clearfix"></div>
							<?php echo $lists['nbed'];?>
						</div>
					    <?php
					}
					if($increase_div == 3)
					{
						$increase_div = 0;
						?>
						</div>
						<div class="<?php echo $rowFluidClass; ?>">
						<?php
					}
					if($configClass['use_nfloors'] == 1)
					{
						$increase_div++;
					    ?>
						<div class="<?php echo $span4Class; ?> searchfields">
							<strong>
								<?php echo JText::_('OS_FLOORS')?>
							</strong>
							<div class="clearfix"></div>
							<?php echo $lists['nfloor']; ?>
						</div>
					    <?php
					}
					if($increase_div == 3)
					{
						$increase_div = 0;
						?>
						</div>
						<div class="<?php echo $rowFluidClass; ?>">
						<?php
					}
					if($configClass['use_rooms'] == 1)
					{
						$increase_div++;
					    ?>
						<div class="<?php echo $span4Class; ?> searchfields">
							<strong>
								<?php echo JText::_('OS_ROOMS')?>
							</strong>
						<div class="clearfix"></div>
						<?php echo $lists['nroom']; ?>
						</div>
					<?php
					}

					if($increase_div == 3)
					{
						$increase_div = 0;
						?>
						</div>
						<div class="<?php echo $rowFluidClass; ?>">
						<?php
					}
                    if($configClass['use_squarefeet'] == 1)
                    {
                        $increase_div++;
                        ?>
                        <div class="<?php echo $span4Class; ?> searchfields squaresearch">
                            <strong>
                                <?php
                                if($configClass['use_square'] == 0){
                                    echo JText::_('OS_SQUARE_FEET');
                                }else{
                                    echo JText::_('OS_SQUARE_METER');
                                }
                                ?>
                                <?php
                                echo "(";
                                echo OSPHelper::showSquareSymbol();
                                echo ")";
                                ?>
                            </strong>
                            <div class="clearfix"></div>
                            <input type="text" class="input-mini form-control ishort" name="sqft_min" id="sqft_min" placeholder="<?php echo JText::_('OS_MIN')?>" value="<?php echo isset($lists['sqft_min']) ? $lists['sqft_min']:"";?>" />
                            &nbsp;-&nbsp;
                            <input type="text" class="input-mini form-control ishort" name="sqft_max" id="sqft_max" placeholder="<?php echo JText::_('OS_MAX')?>" value="<?php echo isset($lists['sqft_max']) ? $lists['sqft_max']:"";?>"/>
                        </div>
                        <?php
                        if($increase_div == 3){
                            $increase_div = 0;
                            ?>
                            </div>
                            <div class="<?php echo $rowFluidClass; ?>">
                            <?php
                        }
                        ?>
                        <div class="<?php echo $span4Class; ?> searchfields squaresearch">
                            <strong>
                                <?php
                                    echo JText::_('OS_LOT_SIZE');
                                ?>
                                (<?php echo OSPHelper::showSquareSymbol();?>)
                            </strong>
                            <div class="clearfix"></div>
                            <input type="text" class="input-mini form-control ishort" name="lotsize_min" id="lotsize_min" placeholder="<?php echo JText::_('OS_MIN')?>" value="<?php echo isset($lists['lotsize_min']) ? $lists['lotsize_min']:"";?>" />
                            &nbsp;-&nbsp;
                            <input type="text" class="input-mini form-control ishort" name="lotsize_max" id="lotsize_max" placeholder="<?php echo JText::_('OS_MAX')?>" value="<?php echo isset($lists['lotsize_max']) ? $lists['lotsize_max']:"";?>"/>
                        </div>
						<?php
                        if($increase_div == 3){
                            $increase_div = 0;
                            ?>
                            </div>
                            <div class="<?php echo $rowFluidClass; ?>">
                            <?php
                        }
                        ?>
						<div class="<?php echo $span4Class; ?> searchfields posteddatesearch">
                            <strong>
                                <?php
                                    echo JText::_('OS_CREATED_ON');
                                ?>
                            </strong>
                            <div class="clearfix"></div>
                            <?php echo JHTML::calendar($lists['created_from'],'created_from','created_from',"%Y-%m-%d", array('placeholder' => JText::_('OS_FROM'), 'class' => $bootstrapHelper->getClassMapping('input-medium')));?>
                            <?php echo JHTML::calendar($lists['created_to'],'created_to','created_to',"%Y-%m-%d", array('placeholder' => JText::_('OS_TO') , 'class' => $bootstrapHelper->getClassMapping('input-medium') ));?>
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
			echo JHtml::_('bootstrap.endTabSet');
			?>
		</div>
		<div class="clearfix"></div>
		<?php
		$db->setQuery("Select count(id) from #__osrs_extra_fields where published = '1' and searchable = '1'");
		$countfields = $db->loadResult();
		if(($countfields > 0) and ($configClass['show_more'])){
		?>
		<span class="more_option" id="more_option_span"><?php echo JText::_('OS_MORE_OPTION')?>&nbsp; <i class="osicon-chevron-down"></i></span>
		<div id="more_option_div" class="nodisplay">
			<?php
			$fieldLists = array();
			for($i=0;$i<count($groups);$i++){
				$group = $groups[$i];
				if(count($group->fields) > 0){
					?>
					<div class="<?php echo $span12Class; ?> noleftmargin">
						<div class="block_caption">
							<?php echo OSPHelper::getLanguageFieldValue($group,'group_name');?>
						</div>
						<?php
						$fields = $group->fields;
						for($j=0;$j<count($fields);$j++){
							$field = $fields[$j];
							$fieldLists[] = $field->id;
							?>
							<div class="<?php echo $rowFluidClass; ?>" id="advextrafield_<?php echo $field->id;?>">
							<?php 
							HelperOspropertyFields::showFieldinAdvSearch($field,1);
							?>
							</div>
							<div class="clearfix"></div>
							<?php
						}
						?>
					</div>		
					<div class="clearfix"></div>
					<?php
				}
			}
			?>
		</div>
		<?php } ?>
	</div>
	<input type="hidden" name="advfieldLists" id="advfieldLists" value="<?php echo implode(",",(array)$fieldLists)?>" />
</div>
<div class="<?php echo $rowFluidClass; ?>">
	<div class="<?php echo $span12Class; ?> alignright noleftmargin">
		<input type="submit" class="btn btn-info" value="<?php echo JText::_('OS_SEARCH')?>" id="btnSubmit"/>
		<?php
		$needs = array();
		$needs[] = "ladvsearch";
		$needs[] = "property_advsearch";
		$itemid = OSPRoute::getItemid($needs);	
		?>
		<a href="<?php echo JRoute::_('index.php?option=com_osproperty&view=ladvsearch&Itemid='.$itemid);?>" class="btn btn-secondary"><?php echo JText::_('OS_RESET')?></a>
		<?php
		if(!$ismobile){
			$user = JFactory::getUser();
			if(intval($user->id) > 0){
				?>
				<input type="button" class="btn btn-warning" value="<?php echo JText::_('OS_SAVE_TO_SEARCH_LIST_ADDNEW')?>" onclick="javascript:saveSearchList();"  id="btnSaveSearchList"/>
				<?php
			}

			if($jinput->getInt('list_id',0) > 0){
				?>
				<input type="button" class="btn btn-success" value="<?php echo JText::_('OS_SAVE_TO_SEARCH_LIST_UPDATE')?>" onclick="javascript:updateSearchList();" id="btnUpdateSearchList"/>
				<?php
			}
		}
		//}
		?>
	</div>
</div>
<script type="text/javascript">
function updateMyLocation(){
	if(navigator.geolocation){
		navigator.geolocation.getCurrentPosition(advSearchShowPosition,
			function(error){
				alert("<?php echo str_ireplace('"', "'",JText::_(''));?>");

			}, {
				timeout: 30000, enableHighAccuracy: true, maximumAge: 90000
			});
	}
}

function advSearchShowPosition(position){
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + 1);
	var ll = position.coords.latitude+'_'+position.coords.longitude;
	document.cookie = "djcf_latlon=" + ll + "; expires=" + exdate.toUTCString()+";path=/";
	document.getElementById('se_geoloc').value = '1';
	document.getElementById('ftForm').submit();
}
jQuery("#property_types").change(function(){
	var fields = jQuery("#advfieldLists").val();
	var fieldArr = fields.split(",");
	if(fieldArr.length > 0){
		for(i=0;i<fieldArr.length;i++){
			jQuery("#advextrafield_" + fieldArr[i]).hide("fast");
		}
	}
	//var selected_value = jQuery("#propserty_types").val();
	var selected_value = []; 
	var property_types = document.getElementById('property_types');
	var j = 0;
	for(i=0;i<property_types.length;i++){
		if(property_types.options[i].selected == true){
			selected_value[j] =  property_types.options[i].value;
			j++;
		}
	}
	if(selected_value.length > 0){
		
		for(j=0;j < selected_value.length;j++){
			var selected_fields = jQuery("#advtype_id_" + selected_value[j]).val();
			//alert(selected_fields);
			var fieldArr = selected_fields.split(",");
			if(fieldArr.length > 0){
				for(i=0;i<fieldArr.length;i++){
					jQuery("#advextrafield_" + fieldArr[i]).show("slow");
				}
			}
		}
	}
});
</script>