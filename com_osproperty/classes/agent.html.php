<?php
/*------------------------------------------------------------------------
# agent.html.php - Ossolution Property
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2023 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/

// No direct access.
defined('_JEXEC') or die;

class HTML_OspropertyAgent{
	/**
	 * Agent layout
	 *
	 * @param unknown_type $option
	 */
	static function agentLayout($option,$rows,$pageNav,$alphabet,$rows1,$lists)
	{
		global $bootstrapHelper, $mainframe,$jinput,$configClass,$ismobile,$bootstrapHelper;

		$db = JFactory::getDbo();
		//JHTML::_('behavior.modal');
		$page = $jinput->getString('page','');
		?>
		<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>" id="agentlisting">
			<?php 
			OSPHelper::generateHeading(2,JText::_('OS_LIST_AGENTS'));
			?>
			<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?> noleftmargin noleftpadding">
				<?php
				if(($page == "") or ($page == "alb")){
					echo JHtml::_('bootstrap.startTabSet', 'agentlist', array('active' => 'panel1'));
				}else{
					echo JHtml::_('bootstrap.startTabSet', 'agentlist', array('active' => 'panel2'));
				}
				?>
				<?php
				echo JHtml::_('bootstrap.addTab', 'agentlist', 'panel1', JText::_('OS_ALPHABIC', true));
				?>
					<div class="tab-pane" id="panel1">
						<form method="POST" action="<?php echo JRoute::_('index.php?option=com_osproperty&task=agent_layout&Itemid='.$jinput->getInt('Itemid',0))?>" name="ftForm" id="ftForm">
							<?php
							jimport('joomla.filesystem.file');
							if(JFile::exists(JPATH_ROOT.'/templates/'.$mainframe->getTemplate().'/html/com_osproperty/layouts/agentslist.php'))
							{
								$tpl = new OspropertyTemplate(JPATH_ROOT.'/templates/'.$mainframe->getTemplate().'/html/com_osproperty/layouts/');
							}
							else
							{
								$tpl = new OspropertyTemplate(JPATH_COMPONENT.'/helpers/layouts/');
							}
							$tpl->set('mainframe',$mainframe);
							$tpl->set('lists',$lists);
							$tpl->set('option',$option);
							$tpl->set('configClass',$configClass);
							$tpl->set('rows',$rows);
							$tpl->set('pageNav',$pageNav);
							$tpl->set('alphabet',$alphabet);
							$tpl->set('bootstrapHelper',$bootstrapHelper);
							$body = $tpl->fetch("agentslist.php");
							echo $body;
							?>
                            <input type="hidden" name="option" value="com_osproperty" />
                            <input type="hidden" name="task" value="agent_layout" />
                            <input type="hidden" name="alphabet" id="alphabet" value="" />
                            <input type="hidden" name="Itemid" value="<?php echo $jinput->getInt('Itemid',0)?>" />
                            <input type="hidden" name="page" value="alb" />
                            <input type="hidden" name="usertype" id="usertype" value="<?php echo $lists['agenttype']?>" />
						</form>
					</div>
				<?php
				echo JHtml::_('bootstrap.endTab');
				?>
				<?php if($configClass['show_agent_search_tab'] == 1){ ?>
				<?php
				echo JHtml::_('bootstrap.addTab', 'agentlist', 'panel2', JText::_('OS_SEARCH', true));
				?>
                    <div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>" id="panel2">
                        <div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?>">
                            <?php
                            $db = JFactory::getDbo();
                            ?>
                            <form method="POST"
                                  action="<?php echo JRoute::_('index.php?option=com_osproperty&view=lagents&Itemid=' . $jinput->getInt('Itemid', 0)) ?>"
                                  name="ftForm1" id="ftForm1">

                                <div class="block_caption">
                                    <strong><?php echo JText::_('OS_ADV_SEARCH') ?></strong>
                                </div>

                                <div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
                                    <div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?>">
                                        <?php
                                        if (HelperOspropertyCommon::checkCountry())
                                        {
                                            ?>
                                            <div class="<?php echo $bootstrapHelper->getClassMapping('control-group'); ?>">
                                                <label class="<?php echo $bootstrapHelper->getClassMapping('control-label'); ?>">
                                                    <?php echo JText::_('OS_COUNTRY') ?>:
                                                </label>
                                                <div class="<?php echo $bootstrapHelper->getClassMapping('controls'); ?>">
                                                    <?php echo $lists['country']; ?>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        else
                                        {
                                            echo $lists['country'];
                                        }
                                        ?>
                                        <?php
                                        if (OSPHelper::userOneState())
                                        {
                                            echo $lists['state'];
                                        }
                                        else
                                        {
                                            ?>
                                            <div class="<?php echo $bootstrapHelper->getClassMapping('control-group'); ?>">
                                                <label class="<?php echo $bootstrapHelper->getClassMapping('control-label'); ?>">
                                                    <?php echo JText::_('OS_STATE') ?>:
                                                </label>
                                                <div id="country_state" class="<?php echo $bootstrapHelper->getClassMapping('controls'); ?>">
                                                    <?php echo $lists['state']; ?>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <div class="<?php echo $bootstrapHelper->getClassMapping('control-group'); ?>">
                                            <label class="<?php echo $bootstrapHelper->getClassMapping('control-label'); ?>">
                                                <?php echo JText::_('OS_CITY'); ?>:
                                            </label>
                                            <div id="city_div" class="<?php echo $bootstrapHelper->getClassMapping('controls'); ?>">
                                                <?php echo $lists['city']; ?>
                                            </div>
                                        </div>
                                        <div class="<?php echo $bootstrapHelper->getClassMapping('control-group'); ?>">
                                            <label class="<?php echo $bootstrapHelper->getClassMapping('control-label'); ?>">
                                                <?php echo JText::_('OS_ADDRESS'); ?>:
                                            </label>
                                            <div id="city_div" class="<?php echo $bootstrapHelper->getClassMapping('controls'); ?>">
                                                <input type="text" name="address" id="address"
                                                   value="<?php echo OSPHelper::getStringRequest('address', '') ?>"
                                                   class="input-large form-control ilarge"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input class="btn btn-info" value="<?php echo JText::_('OS_SEARCH') ?>" type="submit"
                                       id="submit"/>
                                <BR/>
                                <?php
                                if (count($rows1) > 0) {
                                    ?>
                                    <BR/>
                                    <div class="block_caption">
                                        <strong><?php echo JText::_('OS_SEARCH_RESULT') ?></strong>
                                        &nbsp;&nbsp;
                                        <?php
                                        echo JText::_('OS_RESULTS_AGENTS_FOR');
                                        if ($jinput->getString('address', '') != "") {
                                            echo " " . OSPHelper::getStringRequest('address', '', '');
                                        }
                                        if ($jinput->getInt('city', 0) > 0) {
                                            echo " " . HelperOspropertyCommon::loadCityName($jinput->getInt('city', 0));
                                        }
                                        if ($jinput->getInt('state_id', 0) > 0) {
                                            $db->setQuery("Select state_name from #__osrs_states where id = '" . $jinput->getInt('state_id', 0) . "'");
                                            echo ", " . $db->loadResult();
                                        }

                                        if (!HelperOspropertyCommon::checkCountry()) {
                                            $db->setQuery("Select country_name from #__osrs_countries where id = '" . $configClass['show_country_id'] . "'");
                                            echo ", " . $db->loadResult();
                                        } elseif ($jinput->getInt('country_id', 0) > 0) {
                                            $db->setQuery("Select country_name from #__osrs_countries where id = '" . $jinput->getInt('country_id', 0) . "'");
                                            echo ", " . $db->loadResult();
                                        }
                                        if (OSPHelper::getStringRequest('address', '', '') != "") {
                                            echo " <strong>" . JText::_('OS_DISTANCE') . ": </strong>";
                                            echo $jinput->getString('distance', '') . " " . JText::_('OS_MILES');
                                        }
                                        ?>
                                    </div>
                                    <?php
                                    if ($lists['show_over'] == 1) {
                                        ?>
                                        <div class="resultheader">
                                            <?php
                                            printf(JText::_('OS_OVER_RESULTS'), 24);
                                            ?>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <div class="clearfix"></div>
                                    <div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
                                        <div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?>">
                                            <table width="100%" class="admintable border0">
                                                <?php
                                                $link = JURI::root() . "media/com_osproperty/assets/images/";
                                                for ($i = 0; $i < count($rows1); $i++) {
                                                    $row = $rows1[$i];
                                                    ?>
                                                    <tr>
                                                        <td width="100%" class="paddingtopbottom5 border0 borderbottom1">
                                                            <table width="100%">
                                                                <tr>
                                                                    <td align="left" width="80%" valign="top">
                                                                        <div class="info">
                                                                            <div class="floatleft">
                                                                                <img
                                                                                    src="<?php echo JURI::root() ?>media/com_osproperty/assets/images/mapicon/i<?php echo $i + 1 ?>.png" width="38" height="40" class="icon"/>
                                                                            </div>
                                                                            <strong>
                                                                                <u><?php echo $row->name ?></u>
                                                                            </strong>
                                                                            <?php
                                                                            if ($configClass['show_agent_address'] == 1) {
                                                                                ?>
                                                                                <BR/>
                                                                                <span class="colorgray">
                                                                                    <?php
                                                                                    echo OSPHelper::generateAddress($row);
                                                                                    ?>
                                                                                </span>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                        <?php
                                                                        if ($configClass['show_agent_email'] == 1)
                                                                        {
																			?>
																			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
																			  <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
																			</svg>
																			<?php
                                                                            //echo JText::_('OS_EMAIL').":";
                                                                            //echo "&nbsp;";
                                                                            echo "&nbsp;";
                                                                            echo "<a href='mailto:$row->email'>$row->email</a>";
                                                                            echo "<BR />";
                                                                        }
                                                                        if (($configClass['show_agent_phone'] == 1) and ($row->phone != ""))
                                                                        {
																			?>
																			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
																			  <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
																			</svg>
																			<?php
                                                                            //echo JText::_('OS_PHONE').":";
                                                                            //echo "&nbsp;";
                                                                            echo "&nbsp;";
                                                                            echo $row->phone;
                                                                            echo "<BR />";
                                                                        }
                                                                        if (($configClass['show_agent_mobile'] == 1) and ($row->mobile != ""))
                                                                        {
																			?>
																			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-phone-fill" viewBox="0 0 16 16">
																			  <path d="M3 2a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V2zm6 11a1 1 0 1 0-2 0 1 1 0 0 0 2 0z"/>
																			</svg>
																			<?php
                                                                            //echo JText::_('OS_MOBILE').":";
                                                                            //echo "&nbsp;";
                                                                            echo "&nbsp;";
                                                                            echo $row->mobile;
                                                                            echo "<BR />";
                                                                        }
                                                                        ?>

                                                                        <BR/>
                                                                        <a href="index.php?option=com_osproperty&task=agent_info&id=<?php echo $row->id ?>&Itemid=<?php echo $jinput->getInt('Itemid', 0) ?>">
                                                                            <?php echo JText::_('OS_LISTING') ?>
                                                                            (<?php echo $row->countlisting ?>)
                                                                        </a>
                                                                        &nbsp;&nbsp;|&nbsp;&nbsp;
                                                                        <a href="index.php?option=com_osproperty&task=agent_info&id=<?php echo $row->id ?>&Itemid=<?php echo $jinput->getInt('Itemid', 0) ?>">
                                                                            <?php echo JText::_('OS_VIEW_AGENCY_PROFILE') ?>
                                                                        </a>
                                                                    </td>
                                                                    <td align="right" valign="top" class="<?php echo $bootstrapHelper->getClassMapping('hidden-phone'); ?>">
                                                                        <div class="agent_photo marginbottom10">
                                                                            <?php
                                                                            if ($row->photo != "") {
                                                                                ?>
                                                                                <img
                                                                                    src='<?php echo JURI::root() ?>images/osproperty/agent/thumbnail/<?php echo $row->photo ?>'
                                                                                    border="0" width="90"/>
                                                                            <?php
                                                                            } else {
                                                                                ?>
                                                                                <img
                                                                                    src='<?php echo JURI::root() ?>media/com_osproperty/assets/images/noimage.jpg'
                                                                                    border="0" width="90"/>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                                <input type="hidden" name="option" value="com_osproperty"/>
                                <input type="hidden" name="task" value="agent_layout"/>
                                <input type="hidden" name="Itemid" value="<?php echo $jinput->getInt('Itemid', 0) ?>"/>
                                <input type="hidden" name="page" value="adv"/>
                                <input type="hidden" name="usertype" id="usertype"
                                       value="<?php echo $lists['agenttype'] ?>"/>
                            </form>
                        </div>
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
		<script type="text/javascript">
		function change_country_company(country_id,state_id,city_id){
			var live_site = '<?php echo JURI::root()?>';
			loadLocationInfoStateCityLocator(country_id,state_id,city_id,'country','state_id',live_site);
		}
		function change_state(state_id,city_id){
			var live_site = '<?php echo JURI::root()?>';
			loadLocationInfoCity(state_id,city_id,'state_id',live_site);
		}
		</script>
		<?php
	}

    /**
     * This function is used to show Most Viewed Properties
     * @param $option
     * @param $rows
     */
	static function showMostViewProperties($option,$rows)
    {
		global $bootstrapHelper, $mainframe,$jinput,$configClass;
        if(JFile::exists(JPATH_ROOT.'/templates/'.$mainframe->getTemplate().'/html/com_osproperty/layouts/mostviewed.php'))
        {
            $tpl = new OspropertyTemplate(JPATH_ROOT.'/templates/'.$mainframe->getTemplate().'/html/com_osproperty/layouts/');
        }
        else
        {
            $tpl = new OspropertyTemplate(JPATH_COMPONENT.'/helpers/layouts/');
        }
        $tpl->set('option',$option);
        $tpl->set('rows',$rows);
        $tpl->set('configClass',$configClass);
        $tpl->set('bootstrapHelper',$bootstrapHelper);
        $body = $tpl->fetch("mostviewed.php");
        echo $body;
	}

    /**
     * This function is used to show Most Rated Properties
     * @param $option
     * @param $rows
     */
	static function showMostRatedProperties($option,$rows)
    {
        global $bootstrapHelper, $mainframe,$jinput,$configClass;
        if(JFile::exists(JPATH_ROOT.'/templates/'.$mainframe->getTemplate().'/html/com_osproperty/layouts/mostrated.php'))
        {
            $tpl = new OspropertyTemplate(JPATH_ROOT.'/templates/'.$mainframe->getTemplate().'/html/com_osproperty/layouts/');
        }
        else
        {
            $tpl = new OspropertyTemplate(JPATH_COMPONENT.'/helpers/layouts/');
        }
        $tpl->set('option',$option);
        $tpl->set('rows',$rows);
        $tpl->set('configClass',$configClass);
        $tpl->set('bootstrapHelper',$bootstrapHelper);
        $body = $tpl->fetch("mostrated.php");
        echo $body;
	}
	/**
	 * Edit profile
	 *
	 * @param unknown_type $option
	 * @param unknown_type $agent
	 */
	static function editProfile($option,$agent,$lists,$rows,$pageNav){
		global $bootstrapHelper, $mainframe,$jinput,$configClass,$ismobile;
		//JHTML::_('behavior.modal','a.osmodal');
		OSPHelper::loadTooltip();
		jimport('joomla.filesystem.folder');
		//jimport('joomla.html.pane');
		//$panetab =& JPane::getInstance('Tabs');
		$db = JFactory::getDbo();
		?>
		<script type="text/javascript">
		function submitAgentForm(form_name)
        {
		    var form = document.getElementById(form_name);
			var temp1,temp2;
			var cansubmit = 1;
			var require_field = document.getElementById('require_field_' + form_name);
			require_field = require_field.value;
			var require_label = document.getElementById('require_label_' + form_name);
			require_label = require_label.value;
			var require_fieldArr = require_field.split(",");
			var require_labelArr = require_label.split(",");
			for(i=0;i<require_fieldArr.length;i++)
			{
				temp1 = require_fieldArr[i];
				temp2 = form[temp1]; // hungvd repair
				//temp2 = document.getElementById(temp1);
				if(temp2 != null)
				{
					if((temp2.value == "") && (cansubmit == 1))
					{
						//alert(require_labelArr[i] + " <?php echo JText::_('OS_IS_MANDATORY_FIELD')?>");
						alert(require_labelArr[i] + " " + Joomla.JText._('<?php echo JText::plural("OS_IS_MANDATORY_FIELD", 1, array("script"=>true));?>'));
						temp2.focus();
						cansubmit = 0;
					}
				}
			}
			
			// hungvd modify
			if ((form_name == 'profileForm') && (cansubmit = 1)){
				password 	= form['password'];
				password2 	= form['password2'];
				if (password.value != '' && password.value != password2.value){
//					alert("<?php echo JText::_('OS_NEW_PASSWORD_IS_NOT_CORRECT')?>");
					alert(Joomla.JText._('<?php echo JText::plural("OS_NEW_PASSWORD_IS_NOT_CORRECT", 1, array("script"=>true));?>'));
					cansubmit = 0;
				}
			}
			
			
			if(cansubmit == 1){
				form.submit();
			}
		}
		function loadState(country_id,state_id,city_id){
			var live_site = '<?php echo JURI::root()?>';
			loadLocationInfoStateCity(country_id,state_id,city_id,'country','state',live_site);
		}
		function loadCity(state_id,city_id){
			var live_site = '<?php echo JURI::root()?>';
			loadLocationInfoCityAddProperty(state_id,city_id,'state',live_site);
		}
		function savePassword(){
			var form = document.passwordForm;
			new_password = form.new_password;
			new_password1 = form.new_password1;
			if((new_password1.value == "")&&(new_password.value!="")){
				alert("<?php echo JText::_('Please re-enter new password')?>");
				new_password1.focus();
			}else if(new_password1.value != new_password.value){
				//alert("<?php echo JText::_('OS_NEW_PASSWORD_IS_NOT_CORRECT')?>");
				alert(Joomla.JText._('<?php echo JText::plural("OS_NEW_PASSWORD_IS_NOT_CORRECT", 1, array("script"=>true));?>'));
			}else{
				form.submit();
			}
			
		}
		function submitForm(t){
			var total = 0;
			var temp;
			total = <?php echo count($rows)?>;
            if(t == "new"){
                document.ftForm.task.value = "property_new";
                document.ftForm.submit();
                return false;
            }
			if(total > 0){
				var check = 0;
				for(i=0;i<total;i++){
					temp = document.getElementById('cb' + i);
					if(temp != null){
						if(temp.checked == true){
							check = 1;
						}
					}
				}
				if(check == 0)
				{
					alert("<?php echo JText::_('OS_PLEASE_ITEM');?>");
				}
				else
				{
					if(t == "deleteproperties"){
						var answer = confirm("<?php echo JText::_('OS_DO_YOU_WANT_TO_REMOVE_ITEMS')?>");
						if(answer == 1){
							document.ftForm.task.value = "agent_deleteproperties";
							document.ftForm.submit();
						}
					}else{
						if(t != "property_upgrade"){
							document.ftForm.task.value = "agent_" + t;
							document.ftForm.submit();
						}else{
							document.ftForm.task.value = t;
							document.ftForm.submit();
						}
					}
				}
			}
		}
		
		function openDiv(id){
			var atag = document.getElementById('a' + id);
			var divtag = document.getElementById('div' + id);
			if(atag.innerHTML == "[+]"){
				atag.innerHTML = "[-]";
				divtag.style.display = "block";
			}else{
				atag.innerHTML = "[+]"
				divtag.style.display = "none";
			}
		}

		function unfeaturedproperty(pro_id){
			var answer = confirm("<?php echo JText::_('OS_ARE_YOU_SURE_YOU_WANT_TO_UNFEATURED_PROPERTY');?>");
			if(answer == 1){
				location.href = "<?php echo JUri::root()?>index.php?option=com_osproperty&task=property_unfeatured&id=" + pro_id + "&Itemid=<?php echo $jinput->getInt('Itemid',0);?>";
			}
		}
		</script>
		<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>" id="editprofile">
			<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?>">
				<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
					<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?>">
						<h1 class="componentheading">
							<?php echo JText::_('OS_MY_PROFILE')?>
						</h1>
					</div>
				</div>
				<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
					<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?> <?php echo $bootstrapHelper->getClassMapping('hidden-phone'); ?>">
					<?php
					if((count((array)$lists['mostview']) > 0) || (count((array)$lists['mostrate']) > 0))
					{
						if($configClass['agent_mostrated'] == 1 && $configClass['agent_mostviewed'] == 1 && count($lists['mostview']) > 0 && count($lists['mostrate']) > 0)
						{
							$class = $bootstrapHelper->getClassMapping('span6');
							?>
							<!-- show the most view -->
							<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
								<?php
								if(count($lists['mostview']) > 0)
								{
									?>
									<div class="<?php echo $class; ?>">
										<?php
										HTML_OspropertyAgent::showMostViewProperties($option, $lists['mostview']);
										?>
									</div>
									<?php
								}
								if(count($lists['mostrate']) > 0)
								{
									?>
									<div class="<?php echo $class; ?>">
										<?php
										HTML_OspropertyAgent::showMostRatedProperties($option, $lists['mostrate']);
										?>
									</div>
									<?php
								}
								?>
							</div>
							<?php
						}
						else
						{
                            $class = $bootstrapHelper->getClassMapping('span12');
						}
					}
					?>
					</div>
                </div>
                <div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
					<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?> margintop10">
						<div class="tab-content">
							<?php
							echo JHtml::_('bootstrap.startTabSet', 'agentprofile', array('active' => 'panel3'));
							echo JHtml::_('bootstrap.addTab', 'agentprofile', 'panel3', JText::_('OS_YOUR_PROPERTIES', true));
							?>
							<div class="tab-pane active" id="panel3">
								<form method="POST" action="<?php echo JRoute::_('index.php?option=com_osproperty&view=aeditdetails');?>" name="ftForm" id="ftForm" class="form-horizontal">
								<?php
									if(JFile::exists(JPATH_ROOT.'/templates/'.$mainframe->getTemplate().'/html/com_osproperty/layouts/manageproperties.php')){
										$tpl = new OspropertyTemplate(JPATH_ROOT.'/templates/'.$mainframe->getTemplate().'/html/com_osproperty/layouts/');
									}else{
										$tpl = new OspropertyTemplate(JPATH_COMPONENT.'/helpers/layouts/');
									}
									$tpl->set('option',$option);
									$tpl->set('rows',$rows);
									$tpl->set('lists',$lists);
									$tpl->set('pageNav',$pageNav);	
									$tpl->set('itemid',$jinput->getInt('Itemid',0));
									$tpl->set('configClass',$configClass);
									$tpl->set('jinput',$jinput);
									$tpl->set('supervisor',0);
									$tpl->set('bootstrapHelper',$bootstrapHelper);
									$body = $tpl->fetch("manageproperties.php");
									echo $body;
								?>
								<input type="hidden" name="option" value="com_osproperty" />
								<input type="hidden" name="task" value="agent_default" />
								<input type="hidden" name="Itemid" value="<?php echo $jinput->getInt('Itemid',0)?>" />
								<input type="hidden" name="view" value="aeditdetails" />
								</form>
								<script type="text/javascript">
								function allCheck(id){
									var temp = document.getElementById(id);
									var count = "<?php echo count($rows)?>";
									if(temp.value == 0){
										temp.value = 1;
										for(i=0;i<count;i++){
											cb = document.getElementById('cb'+ i);
											if(cb != null){
												cb.checked = true;
											}
										}
									}else{
										temp.value = 0;
										for(i=0;i<count;i++){
											cb = document.getElementById('cb'+ i);
											if(cb != null){
												cb.checked = false;
											}
										}
									}
								}
								</script>
							</div>
							<?php
							echo JHtml::_('bootstrap.endTab');
                            if($configClass['integrate_membership'] == 1 && JFolder::exists(JPATH_ROOT.'/components/com_osmembership'))
                            {
                                $planArr    = array();
                                OSMembershipHelper::loadLanguage();
                                $plans      = OspropertyMembership::getAllPlans();
                                $usertype   = $agent->agent_type;
                                foreach($plans as $plan)
                                {
                                    $params         = new JRegistry() ;
                                    $params->loadString($plan->params);
                                    $plan_type      = $params->get('isospplugin',0);
                                    if($plan_type == 1)
                                    {
                                        $plan_usertype = $params->get('usertype','');
                                        $pu = 1;
                                        if(trim($usertype) == '0' || trim($usertype) == '2')
                                        {
                                            if($usertype != $plan_usertype){
                                                $pu = 0;
                                            }
                                        }
                                        if($pu == 1)
                                        {
                                            $planArr[] = $plan->id;
                                        }
                                    }
                                }
                                if(count($planArr) > 0)
                                {
                                    echo JHtml::_('bootstrap.addTab', 'agentprofile', 'panel4', JText::_('OS_YOUR_ORDERS_HISTORY', true));
                                    ?>
                                    <div class="tab-pane" id="panel4">
                                        <?php
                                        //OspropertyPayment::ordersHistory($lists['orders']);
                                        jimport('joomla.filesystem.file');
                                        $request = array('option' => 'com_osmembership', 'view' => 'subscriptions', 'layout' => 'default', 'filter_plan_ids' => implode(",", $planArr), 'limit' => 0, 'hmvc_call' => 1, 'Itemid' => OSMembershipHelper::getItemid());
                                        $input = new MPFInput($request);
                                        $config = array(
                                            'default_controller_class' => 'OSMembershipController',
                                            'default_view' => 'plans',
                                            'class_prefix' => 'OSMembership',
                                            'language_prefix' => 'OSM',
                                            'remember_states' => false,
                                            'ignore_request' => false,
                                        );
                                        MPFController::getInstance('com_osmembership', $input, $config)
                                            ->execute();
                                        ?>
                                    </div>
                                    <?php
                                    echo JHtml::_('bootstrap.endTab');
                                }
                            }
							elseif($configClass['active_payment'] == 1)
                            {
								echo JHtml::_('bootstrap.addTab', 'agentprofile', 'panel4', JText::_('OS_YOUR_ORDERS_HISTORY', true));
								?>
									<div class="tab-pane" id="panel4">
										<?php
                                        OspropertyPayment::ordersHistory($lists['orders']);
										?>
									</div>
								<?php
								echo JHtml::_('bootstrap.endTab');
							}
							?>
							<?php
								if($configClass['integrate_membership'] == 1 && JFolder::exists(JPATH_ROOT.'/components/com_osmembership'))
								{
									echo JHtml::_('bootstrap.addTab', 'agentprofile', 'panel3a', JText::_('OS_YOUR_CREDITS', true));
									?>
									<div class="tab-pane" id="panel3a">
                                        <?php
                                        $db = JFactory::getDbo();
                                        if(file_exists(JPATH_ROOT.DS."components/com_osmembership/helper/helper.php"))
										{
                                            include_once(JPATH_ROOT.DS."components/com_osmembership/helper/helper.php");
                                        }
                                        if(JFile::exists(JPATH_ROOT.'/templates/'.$mainframe->getTemplate().'/html/com_osproperty/layouts/usercredits.php'))
										{
                                            $tpl = new OspropertyTemplate(JPATH_ROOT.'/templates/'.$mainframe->getTemplate().'/html/com_osproperty/layouts/');
                                        }
										else
										{
                                            $tpl = new OspropertyTemplate(JPATH_COMPONENT.'/helpers/layouts/');
                                        }
                                        $userCredits = OspropertyMembership::getUserCredit();
                                        $tpl->set('agentAcc',$userCredits);
										$tpl->set('usertype',$usertype);
                                        $body = $tpl->fetch("usercredits.php");
                                        echo $body;
                                        ?>
									</div>
									<?php
									echo JHtml::_('bootstrap.endTab');
								}
								/*
								echo JHtml::_('bootstrap.addTab', 'agentprofile', 'panel1', JText::_('OS_PROFILE_INFO', true));
								?>
								<div class="tab-pane" id="panel1">
									<?php
									$user = JFactory::getUser();
									?>
									<form method="POST" action="<?php echo JRoute::_('index.php?option=com_osproperty&task=agent_saveprofile&Itemid='.$jinput->getInt('Itemid',0))?>" name="profileForm" id="profileForm" class="form-horizontal">
									<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
										<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?> noleftmargin">
											<div class="block_caption">
												<strong><?php echo JText::_('OS_PROFILE_INFO')?></strong>
											</div>
											<div class="clearfix"></div>
											<div class="blue_middle"><?php echo Jtext::_('OS_FIELDS_MARKED')?> <span class="red">*</span> <?php echo JText::_('OS_ARE_REQUIRED')?></div>
											<div class="<?php echo $bootstrapHelper->getClassMapping('control-group'); ?>">
												<label class="<?php echo $bootstrapHelper->getClassMapping('control-label'); ?>" ><?php echo JText::_('OS_NAME')?> *</label>
												<div class="<?php echo $bootstrapHelper->getClassMapping('controls'); ?>">
													<input type="text" name="name" id="name" size="30" value="<?php echo $user->name?>" class="input-large" placeholder="<?php echo JText::_('OS_NAME')?>"/>
												</div>
											</div>
											<div class="<?php echo $bootstrapHelper->getClassMapping('control-group'); ?>">
												<label class="<?php echo $bootstrapHelper->getClassMapping('control-label'); ?>" ><?php echo JText::_('OS_LOGIN_NAME')?> *</label>
												<div class="<?php echo $bootstrapHelper->getClassMapping('controls'); ?>">
													<input type="text" name="username" id="username" size="30" value="<?php echo $user->username?>" class="input-large" placeholder="<?php echo JText::_('OS_LOGIN_NAME')?>"/>
												</div>
											</div>
											<div class="<?php echo $bootstrapHelper->getClassMapping('control-group'); ?>">
												<label class="<?php echo $bootstrapHelper->getClassMapping('control-label'); ?>"><?php echo JText::_('OS_PASSWORD')?>  *</label>
												<div class="<?php echo $bootstrapHelper->getClassMapping('controls'); ?>">
													<input type="password" name="password" id="password" size="30" class="input-large" autocomplete="off" />
												</div>
											</div>
											<div class="<?php echo $bootstrapHelper->getClassMapping('control-group'); ?>">
												<label class="<?php echo $bootstrapHelper->getClassMapping('control-label'); ?>"><?php echo JText::_('OS_CONFIRM_PASSWORD')?> *</label>
												<div class="<?php echo $bootstrapHelper->getClassMapping('controls'); ?>">
													<input type="password" name="password2" id="password2" size="30" class="input-large" autocomplete="off" />
												</div>
											</div>
											<div class="<?php echo $bootstrapHelper->getClassMapping('control-group'); ?>">
												<label class="<?php echo $bootstrapHelper->getClassMapping('control-label'); ?>" ><?php echo JText::_('OS_EMAIL')?> *</label>
												<div class="<?php echo $bootstrapHelper->getClassMapping('controls'); ?>">
													<input type="text" name="email" id="email" size="30" value="<?php echo $user->email?>" class="input-large" placeholder="<?php echo JText::_('OS_EMAIL')?>"/>
												</div>
											</div>
											<div class="clearfix"></div>
											<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?> noleftmargin">
												<input type="button" class="btn btn-info" value="<?php echo JText::_("OS_SAVE")?>" onclick="javascript:submitAgentForm('profileForm')" />
												<input type="reset" class="btn btn-danger" value="<?php echo JText::_("OS_CLEAR")?>" />
											</div>
										</div>
									</div>
									<input type="hidden" name="option" value="com_osproperty" />
									<input type="hidden" name="task" value="agent_saveprofile" />
									<input type="hidden" name="require_field_profileForm" id="require_field_profileForm" value="name,username,email" />
									<input type="hidden" name="require_label_profileForm" id="require_label_profileForm" value="<?php echo JText::_("Name")?>,<?php echo JText::_('OS_LOGIN_NAME')?>,<?php echo JText::_("OS_EMAIL")?>" />
									<input type="hidden" name="MAX_FILE_SIZE" value="9000000000" />
									<input type="hidden" name="Itemid" value="<?php echo $jinput->getInt('Itemid',0)?>" />
									</form>
								</div>
								<?php
								echo JHtml::_('bootstrap.endTab');
								*/
								echo JHtml::_('bootstrap.addTab', 'agentprofile', 'panel2', JText::_('OS_ACCOUNT_INFO', true));
								?>
								<div class="tab-pane" id="panel2">
									<form method="POST" action="<?php echo JUri::root();?>index.php?option=com_osproperty" name="accountForm" id="accountForm" enctype="multipart/form-data" class="form-horizontal">
									<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
										<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?> noleftmargin">
											<div class="block_caption">
												<strong><?php echo JText::_('OS_ACCOUNT_INFO')?></strong>
											</div>
                                        </div>
                                    </div>
                                    <div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
                                        <div class="<?php echo $bootstrapHelper->getClassMapping('span6'); ?> agentprofilebox">
                                            <div class="blue_middle"><?php echo Jtext::_('OS_FIELDS_MARKED')?> <span class="red">*</span> <?php echo JText::_('OS_ARE_REQUIRED')?></div>
                                            <?php
                                            if($configClass['show_agent_image'] == 1){
                                            ?>
                                            <div class="<?php echo $bootstrapHelper->getClassMapping('control-group'); ?>">
                                                <label class="<?php echo $bootstrapHelper->getClassMapping('control-label'); ?>" ><?php echo JText::_('OS_PHOTO')?></label>
                                                <div class="<?php echo $bootstrapHelper->getClassMapping('controls'); ?>">
                                                    <?php
                                                    if($agent->photo != "")
                                                    {
                                                        ?>
                                                        <img src="<?php echo JURI::root()?>images/osproperty/agent/<?php echo $agent->photo?>" width="100" />
                                                        <div class="clearfix"></div>
                                                        <input type="checkbox" name="remove_photo" id="remove_photo" onclick="javascript:changeValue('remove_photo')" value="0"/> <?php echo JText::_('OS_REMOVE_PHOTO');?>
                                                        <div class="clearfix"></div>
                                                    <?php
                                                    }
                                                    ?>
                                                    <span id="photodiv">
                                                    <input type="file" name="photo" id="photo" class="input-medium form-control" onchange="javascript:checkUploadPhotoFiles('photo')" />
                                                    <div class="clearfix"></div>
                                                    <?php echo JText::_('OS_ONLY_SUPPORT_JPG_IMAGES');?>
                                                    </span>
                                                </div>
                                            </div>
                                            <?php
                                            }
                                            ?>
                                            <div class="<?php echo $bootstrapHelper->getClassMapping('control-group'); ?>">
                                                <label class="<?php echo $bootstrapHelper->getClassMapping('control-label'); ?>" ><?php echo JText::_('OS_AGENT_NAME')?> *</label>
                                                <div class="<?php echo $bootstrapHelper->getClassMapping('controls'); ?>">
                                                    <input type="text" name="name" id="name" size="30" value="<?php echo htmlspecialchars($agent->name);?>" class="input-large form-control" placeholder="<?php echo JText::_('OS_AGENT_NAME')?>"/>
                                                    <input type="hidden" name="alias" value="<?php echo htmlspecialchars($agent->alias);?>" />
                                                </div>
                                            </div>
                                            <div class="<?php echo $bootstrapHelper->getClassMapping('control-group'); ?>">
                                                <label class="<?php echo $bootstrapHelper->getClassMapping('control-label'); ?>" ><?php echo JText::_('OS_AGENT_EMAIL')?> *</label>
                                                <div class="<?php echo $bootstrapHelper->getClassMapping('controls'); ?>">
                                                    <input type="text" name="email" id="email" size="30" value="<?php echo $agent->email?>" class="input-large form-control" placeholder="<?php echo JText::_('OS_AGENT_EMAIL')?>"/>
                                                </div>
                                            </div>
                                            <div class="<?php echo $bootstrapHelper->getClassMapping('control-group'); ?>">
                                                <label class="<?php echo $bootstrapHelper->getClassMapping('control-label'); ?>" ><?php echo JText::_('OS_COMPANY');?></label>
                                                <div class="<?php echo $bootstrapHelper->getClassMapping('controls'); ?>">
                                                    <?php echo $lists['company'];?>
                                                </div>
                                            </div>
                                            <div class="<?php echo $bootstrapHelper->getClassMapping('control-group'); ?>">
                                                <label class="<?php echo $bootstrapHelper->getClassMapping('control-label'); ?>" ><?php echo JText::_('OS_ADDRESS')?></label>
                                                <div class="<?php echo $bootstrapHelper->getClassMapping('controls'); ?>">
                                                    <input type="text" name="address" id="address" size="30" value="<?php echo htmlspecialchars($agent->address);?>" class="input-large form-control" placeholder="<?php echo JText::_('OS_ADDRESS')?>"/>
                                                </div>
                                            </div>
                                            <?php
                                            if(HelperOspropertyCommon::checkCountry())
                                            {
                                            ?>
                                                <div class="<?php echo $bootstrapHelper->getClassMapping('control-group'); ?>">
                                                    <label class="<?php echo $bootstrapHelper->getClassMapping('control-label'); ?>" ><?php echo JText::_('OS_COUNTRY')?> *</label>
                                                    <div class="<?php echo $bootstrapHelper->getClassMapping('controls'); ?>">
                                                        <?php echo $lists['country']?>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            else
                                            {
                                                echo $lists['country'];
                                            }
                                            if(OSPHelper::userOneState())
                                            {
                                                echo $lists['state'];
                                            }
                                            else
                                            {
                                            ?>
                                                <div class="<?php echo $bootstrapHelper->getClassMapping('control-group'); ?>">
                                                    <label class="<?php echo $bootstrapHelper->getClassMapping('control-label'); ?>" ><?php echo JText::_('OS_STATE')?> *</label>
                                                    <div class="<?php echo $bootstrapHelper->getClassMapping('controls'); ?>" id="country_state">
                                                        <?php
                                                        echo $lists['state'];
                                                        ?>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                            <div class="<?php echo $bootstrapHelper->getClassMapping('control-group'); ?>">
                                                <label class="<?php echo $bootstrapHelper->getClassMapping('control-label'); ?>" ><?php echo JText::_('OS_CITY')?> *</label>
                                                <div class="<?php echo $bootstrapHelper->getClassMapping('controls'); ?>" id="city_div">
                                                    <?php
                                                    echo $lists['city'];
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="<?php echo $bootstrapHelper->getClassMapping('span6'); ?> agentprofilebox">
                                            <?php
                                            if($configClass['show_agent_phone'] == 1)
                                            {
                                            ?>
                                                <div class="<?php echo $bootstrapHelper->getClassMapping('control-group'); ?>">
                                                    <label class="<?php echo $bootstrapHelper->getClassMapping('control-label'); ?>"><?php echo JText::_('OS_PHONE')?></label>
                                                    <div class="<?php echo $bootstrapHelper->getClassMapping('controls'); ?>">
                                                        <input type="text" name="phone" id="phone" size="30" value="<?php echo htmlspecialchars($agent->phone);?>" class="input-large form-control" placeholder="<?php echo JText::_('OS_PHONE')?>"/>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            if($configClass['show_agent_mobile'] == 1)
                                            {
                                            ?>
                                                <div class="<?php echo $bootstrapHelper->getClassMapping('control-group'); ?>">
                                                    <label class="<?php echo $bootstrapHelper->getClassMapping('control-label'); ?>"><?php echo JText::_('OS_MOBILE')?></label>
                                                    <div class="<?php echo $bootstrapHelper->getClassMapping('controls'); ?>">
                                                        <input type="text" name="mobile" id="mobile" size="30" value="<?php echo htmlspecialchars($agent->mobile);?>" class="input-large form-control" placeholder="<?php echo JText::_('OS_MOBILE')?>"/>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            if($configClass['show_agent_fax'] == 1)
                                            {
                                            ?>
                                                <div class="<?php echo $bootstrapHelper->getClassMapping('control-group'); ?>">
                                                    <label class="<?php echo $bootstrapHelper->getClassMapping('control-label'); ?>"><?php echo JText::_('OS_FAX')?></label>
                                                    <div class="<?php echo $bootstrapHelper->getClassMapping('controls'); ?>">
                                                        <input type="text" name="fax" id="fax" size="30" value="<?php echo htmlspecialchars($agent->fax);?>" class="input-large form-control" placeholder="<?php echo JText::_('OS_FAX')?>"/>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            if($configClass['show_agent_skype'] == 1)
                                            {
                                            ?>
                                                <div class="<?php echo $bootstrapHelper->getClassMapping('control-group'); ?>">
                                                    <label class="<?php echo $bootstrapHelper->getClassMapping('control-label'); ?>"><?php echo JText::_('Skype')?></label>
                                                    <div class="<?php echo $bootstrapHelper->getClassMapping('controls'); ?>">
                                                        <input type="text" name="skype" id="skype" size="30" value="<?php echo htmlspecialchars($agent->skype);?>" class="input-large form-control" placeholder="<?php echo JText::_('Skype')?>"/>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            if($configClass['show_agent_linkin'] == 1)
                                            {
                                            ?>
                                                <div class="<?php echo $bootstrapHelper->getClassMapping('control-group'); ?>">
                                                    <label class="<?php echo $bootstrapHelper->getClassMapping('control-label'); ?>"><?php echo JText::_('OS_LINKEDIN')?></label>
                                                    <div class="<?php echo $bootstrapHelper->getClassMapping('controls'); ?>">
                                                        <input type="text" name="yahoo" id="yahoo" size="30" value="<?php echo htmlspecialchars($agent->yahoo);?>" class="input-large form-control" placeholder="<?php echo JText::_('OS_LINKEDIN')?>"/>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            if($configClass['show_agent_gplus'] == 1)
                                            {
                                            ?>
                                                <div class="<?php echo $bootstrapHelper->getClassMapping('control-group'); ?>">
                                                    <label class="<?php echo $bootstrapHelper->getClassMapping('control-label'); ?>"><?php echo JText::_('Google Plus')?></label>
                                                    <div class="<?php echo $bootstrapHelper->getClassMapping('controls'); ?>">
                                                        <input type="text" name="gtalk" id="gtalk" size="30" value="<?php echo htmlspecialchars($agent->gtalk);?>" class="input-large form-control" placeholder="<?php echo JText::_('Google Plus')?>"/>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            if($configClass['show_agent_msn'] == 1)
                                            {
                                            ?>
                                                <div class="<?php echo $bootstrapHelper->getClassMapping('control-group'); ?>">
                                                    <label class="<?php echo $bootstrapHelper->getClassMapping('control-label'); ?>"><?php echo JText::_('Line messasges')?></label>
                                                    <div class="<?php echo $bootstrapHelper->getClassMapping('controls'); ?>">
                                                        <input type="text" name="msn" id="msn" size="30" value="<?php echo htmlspecialchars($agent->msn);?>" class="input-large form-control" placeholder="<?php echo JText::_('Line messasges')?>"/>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            if($configClass['show_agent_facebook'] == 1)
                                            {
                                            ?>
                                                <div class="<?php echo $bootstrapHelper->getClassMapping('control-group'); ?>">
                                                    <label class="<?php echo $bootstrapHelper->getClassMapping('control-label'); ?>"><?php echo JText::_('Facebook')?></label>
                                                    <div class="<?php echo $bootstrapHelper->getClassMapping('controls'); ?>">
                                                        <input type="text" name="facebook" id="facebook" size="30" value="<?php echo htmlspecialchars($agent->facebook);?>" class="input-large form-control" placeholder="<?php echo JText::_('Facebook')?>"/>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            if($configClass['show_agent_twitter'] == 1)
                                            {
                                            ?>
                                                <div class="<?php echo $bootstrapHelper->getClassMapping('control-group'); ?>">
                                                    <label class="<?php echo $bootstrapHelper->getClassMapping('control-label'); ?>"><?php echo JText::_('Twitter')?></label>
                                                    <div class="<?php echo $bootstrapHelper->getClassMapping('controls'); ?>">
                                                        <input type="text" name="aim" id="aim" size="30" value="<?php echo htmlspecialchars($agent->aim);?>" class="input-large form-control" placeholder="<?php echo JText::_('Twitter')?>"/>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            if($configClass['show_license'] == 1)
                                            {
                                            ?>
                                                <div class="<?php echo $bootstrapHelper->getClassMapping('control-group'); ?>">
                                                    <label class="<?php echo $bootstrapHelper->getClassMapping('control-label'); ?>"><?php echo JText::_('OS_LICENSE')?></label>
                                                    <div class="<?php echo $bootstrapHelper->getClassMapping('controls'); ?>">
                                                        <input type="text" name="license" id="license" size="30" value="<?php echo htmlspecialchars($agent->license);?>" class="input-large form-control" placeholder="<?php echo JText::_('OS_LICENSE')?>"/>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
                                        <div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?> agentprofilebox">
                                            <div class="<?php echo $bootstrapHelper->getClassMapping('control-group'); ?>">
                                                <label class="<?php echo $bootstrapHelper->getClassMapping('control-label'); ?>"><?php echo JText::_('OS_BIO')?></label>
                                                <div class="<?php echo $bootstrapHelper->getClassMapping('controls'); ?>">
                                                    <?php
                                                    $editor = JEditor::getInstance(JFactory::getConfig()->get('editor'));
                                                    echo $editor->display( 'bio',  htmlspecialchars($agent->bio, ENT_QUOTES), '250', '200', '60', '20',false ) ;
                                                    ?>
                                                </div>
                                            </div>
                                            <?php
                                            if($configClass['use_privacy_policy'] && $configClass['allow_user_profile_optin'])
                                            {
                                            ?>
                                                <div class="<?php echo $bootstrapHelper->getClassMapping('control-group'); ?>">
                                                    <label class="<?php echo $bootstrapHelper->getClassMapping('control-label'); ?>" ><?php echo JText::_('OS_PUBLIC_MY_PROFILE')?></label>
                                                    <div class="<?php echo $bootstrapHelper->getClassMapping('controls'); ?>">
                                                        <?php echo $lists['optin']; ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="clearfix"></div>
                                            <div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?> noleftmargin">
                                                <input type="button" class="btn btn-info" value="<?php echo JText::_("OS_SAVE")?>" onclick="javascript:submitAgentForm('accountForm')" />
                                                <input type="reset" class="btn btn-danger" value="<?php echo JText::_("OS_RESET")?>" />
                                            </div>
                                        </div>
                                    </div>
									<input type="hidden" name="option" value="com_osproperty" />
									<input type="hidden" name="task" value="agent_saveaccount" />
									<?php
									$require_fields = "name,email,country,";
									$require_labels = JText::_("OS_NAME").",".JText::_("OS_EMAIL").",".JText::_("OS_COUNTRY").",";
									if($configClass['require_state']==1){
										$require_fields .= "state,";
										$require_labels .= JText::_("OS_STATE").",";
									}
									if($configClass['require_city']==1){
										$require_fields .= "city,";
										$require_labels .= JText::_("OS_CITY").",";
									}
									?>
									<input type="hidden" name="require_field_accountForm" id="require_field_accountForm" value="<?php echo $require_fields;?>" />
									<input type="hidden" name="require_label_accountForm" id="require_label_accountForm" value="<?php echo $require_labels;?>" />
									<input type="hidden" name="MAX_FILE_SIZE" value="9000000000" />
									<input type="hidden" name="Itemid" value="<?php echo $jinput->getInt('Itemid',0)?>" />
								</form>
							</div>
							<?php
							echo JHtml::_('bootstrap.endTab');
							echo JHtml::_('bootstrap.endTabSet');
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
	
	/**
	 * Agent infor
	 *
	 * @param unknown_type $option
	 * @param unknown_type $agent
	 */
	static function agentInfoForm($option,$agent,$lists)
    {
		global $bootstrapHelper, $mainframe,$jinput,$configClass,$languages,$lang_suffix;
		$document = JFactory::getDocument();
		$document->addStyleSheet(JURI::root()."components/com_osproperty/templates/theme2/style/font.css");
		?>
		<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>" id="agentdetails">
			<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?>">
				<?php 
				jimport('joomla.filesystem.file');
				if(JFile::exists(JPATH_ROOT.'/templates/'.$mainframe->getTemplate().'/html/com_osproperty/layouts/agentdetails.php'))
				{
					$tpl = new OspropertyTemplate(JPATH_ROOT.'/templates/'.$mainframe->getTemplate().'/html/com_osproperty/layouts/');
				}
				else
				{
					$tpl = new OspropertyTemplate(JPATH_COMPONENT.'/helpers/layouts/');
				}
				$tpl->set('mainframe',$mainframe);
				$tpl->set('lists',$lists);
				$tpl->set('option',$option);
				$tpl->set('configClass',$configClass);
				$tpl->set('bootstrapHelper',$bootstrapHelper);
				$tpl->set('agent',$agent);
				$tpl->set('jinput', $jinput);
				$body = $tpl->fetch("agentdetails.php");
				echo $body;
				?>
				<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
					<div class="tab-content <?php echo $bootstrapHelper->getClassMapping('span12'); ?>">
						<?php
						if ($configClass['show_agent_properties'] == 1)
						{
							?>
                            <form method="POST" action="<?php echo JRoute::_('index.php?Itemid='.$jinput->getInt('Itemid',0))?>" name="ftForm" id="ftForm">
                            <div class="block_caption">
                                <strong><?php echo JText::_('OS_AGENT_PROPERTIES')?></strong>
                            </div>
                            <?php
                            $filterParams       = array();
                            //show cat
                            $filterParams[0]    = 1;
                            //agent
                            $filterParams[1]    = 0;
                            //keyword
                            $filterParams[2]    = 1;
                            //bed
                            $filterParams[3]    = 1;
                            //bath
                            $filterParams[4]    = 1;
                            //rooms
                            $filterParams[5]    = 1;
                            //price
                            $filterParams[6]    = 1;

                            $category_id 	    = $jinput->get('category_id',array(),'ARRAY');
                            $property_type	    = $jinput->getInt('property_type',0);
                            $keyword		    = OSPHelper::getStringRequest('keyword','','');
                            $nbed			    = $jinput->getInt('nbed','');
                            $nbath			    = $jinput->getInt('nbath','');
                            $isfeatured		    = $jinput->getInt('isfeatured','');
                            $nrooms			    = $jinput->getInt('nrooms','');
                            $orderby		    = $jinput->getString('orderby','a.id');
                            $ordertype		    = $jinput->getString('ordertype','desc');
                            $limitstart		    = OSPHelper::getLimitStart();
                            $limit			    = $jinput->getInt('limit',$configClass['general_number_properties_per_page']);
                            $favorites		    = $jinput->getInt('favorites',0);
                            $price			    = $jinput->getInt('price',0);
                            $city_id		    = $jinput->getInt('city',0);
                            $state_id		    = $jinput->getInt('state_id',0);
                            $country_id		    = $jinput->getInt('country_id',HelperOspropertyCommon::getDefaultCountry());
                            OspropertyListing::listProperties($option,'',null,$agent->id,$property_type,$keyword,$nbed,$nbath,0,0,$nrooms,$orderby,$ordertype,$limitstart,$limit,'',$price,$filterParams,$city_id,$state_id,$country_id,0,1,-1);
                            ?>
                            <input type="hidden" name="option" value="com_osproperty" />
                            <input type="hidden" name="task" value="agent_info" />
                            <input type="hidden" name="Itemid" value="<?php echo $jinput->getInt('Itemid',0)?>" />
                            <input type="hidden" name="id" value="<?php echo $agent->id?>" />
                            </form>
							<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
	
	/**
	 * Agent register form
	 *
	 * @param unknown_type $option
	 * @param unknown_type $user
	 */
	static function agentRegisterForm($user,$lists,$companies)
    {
		global $bootstrapHelper, $mainframe,$jinput,$configClass;
		$itemid = $jinput->getInt('Itemid',0);
		$user = JFactory::getUser();
		OSPHelper::generateHeading(2,JText::_('OS_AGENT_REGISTER'));
		jimport('joomla.filesystem.file');
		if(JFile::exists(JPATH_ROOT.'/templates/'.$mainframe->getTemplate().'/html/com_osproperty/layouts/agentregistration.php')){
			$tpl = new OspropertyTemplate(JPATH_ROOT.'/templates/'.$mainframe->getTemplate().'/html/com_osproperty/layouts/');
		}else{
			$tpl = new OspropertyTemplate(JPATH_COMPONENT.'/helpers/layouts/');
		}
		$tpl->set('itemid',$itemid);
		$tpl->set('user',$user);
		$tpl->set('companies',$companies);
		$tpl->set('lists',$lists);
		$tpl->set('configClass',$configClass);
		$tpl->set('bootstrapHelper',$bootstrapHelper);
		$body = $tpl->fetch("agentregistration.php");	
		echo $body;	
	}
}

?>