<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?> agentdetails osp-container">
	<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?>">
		<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
			<div class="<?php echo $bootstrapHelper->getClassMapping('span4'); ?>">
                <div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
                    <div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?> agentphotobox1">
                        <?php
                        if(($agent->photo != "") && ($configClass['show_agent_image'] == 1)){
                            ?>
                            <img src='<?php echo JURI::root()?>images/osproperty/agent/<?php echo $agent->photo?>' border="0" />
                            <?php
                        }else{
                            ?>
                            <img src='<?php echo JURI::root()?>media/com_osproperty/assets/images/noimage.jpg' border="0" />
                            <?php
                        }
                        if($agent->featured == 1)
						{
                        ?>
                            <img alt="<?php echo JText::_('OS_FEATURED');?>" class="spotlight_watermark" src="<?php echo Juri::root()?>media/com_osproperty/assets/images/featured_medium.png" />
                         <?php
                        }

						?>
						<span class="agentType">
							<?php
							echo OSPHelper::loadAgentType($agent->id);
							?>
						</span>
						<?php
                        ?>
                    </div>
                </div>
			</div>
			<div class="<?php echo $bootstrapHelper->getClassMapping('span4'); ?>">
                <h1 class="componentheading agent_title">
                    <?php echo $agent->name?>
                    <?php
                    if($configClass['enable_report'] == 1)
                    {
						OSPHelperJquery::colorbox('a.reportmodal');
                        ?>
                        &nbsp;
                        <a href="<?php echo JURI::root()?>index.php?option=com_osproperty&tmpl=component&task=property_reportForm&item_type=1&id=<?php echo $agent->id?>" class="reportmodal reportlink" rel="{handler: 'iframe', size: {x: 350, y: 600}}" title="<?php echo JText::_('OS_REPORT_AGENT');?>">
							<i class="edicon edicon-flag"></i>
                        </a>
                        <?php
                    }
                    if(JFactory::getUser()->id == $agent->user_id && JFactory::getUser()->id > 0)
                    {
                        ?>
                        &nbsp;
                        <a href="<?php echo JRoute::_('index.php?option=com_osproperty&task=agent_editprofile');?>" title="<?php echo JText::_('OS_EDIT_PROFILE');?>" class="editprofilelink">
                             <i class="edicon edicon-pencil"></i>
                        </a>
                        <?php
                    }
                    ?>
                </h1>
				<?php
				if($configClass['show_agent_address'] == 1){
					$address = OSPHelper::generateAddress($agent);
					if($address != ""){
						?>
						<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
							<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?> address">
							<?php
							echo "<i class='edicon edicon-location'></i>&nbsp;";
							echo $address;
							?>
							</div>
						</div>
						<?php
					}
				}
				?>
				<?php
				if(($configClass['show_agent_email'] == 1) and ($agent->email != ""))
				{
				?>
					<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
						<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?>"> 
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
						  <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
						</svg>
						&nbsp;<a href="mailto:<?php echo $agent->email;?>" target="_blank"><?php echo $agent->email;?></a></div>
					</div>
				<?php
				}
				?>
				<?php
				if(($configClass['show_license'] == 1) and ($agent->license != ""))
				{
					
					?>
					<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
						<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?>">
							<i class="edicon edicon-bookmark"></i>&nbsp;
							<?php
							echo $agent->license;
							?>
						</div>
					</div>
					<?php
				}
				?>
				<?php
				if(($configClass['show_company_details'] == 1) and ($agent->company_id > 0))
				{
				?>
					<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
						<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?>">
							<i class="edicon edicon-office"></i>&nbsp;
							<?php
							$link = JRoute::_('index.php?option=com_osproperty&task=company_info&id='.$agent->company_id.'&Itemid='.OSPRoute::getCompanyItemid());
							if(!OSPHelper::isJoomla4()){
							?>
							<span class="hasTip" title="&lt;img src=&quot;<?php echo $agent->company_photo;?>&quot; alt=&quot;<?php echo str_replace("'","",$agent->company_name);?>&quot; width=&quot;100&quot; /&gt;">
								<i class="osicon-camera"></i>
							</span>
							&nbsp;|&nbsp;
							<?php
							}
							echo "<a href='".$link."' title='".$agent->company_name."'>".$agent->company_name."</a>";
							?>
						</div>
					</div>
				<?php
				}
				?>
                <?php
                if(($configClass['show_agent_fax'] == 1) and ($agent->fax != ""))
                {
                    ?>
                    <div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
                        <div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?>"> <i class="edicon edicon-printer"></i>&nbsp;<?php echo $agent->fax;?></div>
                    </div>
                    <?php
                }
                ?>
                
                <div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
                    <div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?>">
                        <ul class="social marT15 marL0">
                            <?php
                            if(($configClass['show_agent_mobile'] == 1) and ($agent->mobile != ""))
                            {
                                ?>
                                <li class="mobile">
                                    <a href="tel:<?php echo $agent->mobile; ?>" target="_blank">
                                        <i class="edicon edicon-mobile"></i>
                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                            <?php
                            if(($configClass['show_agent_phone'] == 1) and ($agent->phone != ""))
                            {
                                ?>
                                <li class="phone">
                                    <a href="tel:<?php echo $agent->phone; ?>" target="_blank">
                                        <i class="edicon edicon-phone"></i>
                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                            <?php
                            if(($configClass['show_agent_skype'] == 1) and ($agent->skype != ""))
                            {
                                ?>
                                <li class="skype">
                                    <a href="skype:<?php echo $agent->skype; ?>" target="_blank">
                                        <i class="edicon edicon-skype"></i>
                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                            <?php
                            if(($agent->facebook != "") and ($configClass['show_agent_facebook'] == 1)){
                                ?>
                                <li class="facebook">
                                    <a href="<?php echo $agent->facebook; ?>" target="_blank">
                                        <i class="edicon edicon-facebook"></i>
                                    </a>
                                </li>
                            <?php }
                            if(($agent->aim != "") and ($configClass['show_agent_twitter'] == 1)){
                                ?>
                                <li class="twitter">
                                    <a href="<?php echo $agent->aim; ?>" target="_blank">
                                        <i class="edicon edicon-twitter"></i>
                                    </a>
                                </li>
                            <?php }
                            if(($agent->yahoo != "") and ($configClass['show_agent_linkin'] == 1)){
                                ?>
                                <li class="linkin">
                                    <a href="<?php echo $agent->yahoo; ?>" target="_blank">
                                        <i class="edicon edicon-linkedin2"></i>
                                    </a>
                                </li>
                            <?php }
                            if(($agent->gtalk != "") and ($configClass['show_agent_gplus'] == 1)){
                                ?>
                                <li class="gplus">
                                    <a href="<?php echo $agent->gtalk; ?>" target="_blank">
                                        <i class="edicon edicon-google-plus"></i>
                                    </a>
                                </li>
                            <?php }
                            ?>
							<?php
                            if(($configClass['show_agent_msn'] == 1) and ($agent->msn != ""))
                            {
                                ?>
                                 <li class="line">
                                    <a href="https://line.me/R/home/public/main?id=<?php echo $agent->msn; ?>" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-line" viewBox="0 0 16 16">
										  <path d="M8 0c4.411 0 8 2.912 8 6.492 0 1.433-.555 2.723-1.715 3.994-1.678 1.932-5.431 4.285-6.285 4.645-.83.35-.734-.197-.696-.413l.003-.018.114-.685c.027-.204.055-.521-.026-.723-.09-.223-.444-.339-.704-.395C2.846 12.39 0 9.701 0 6.492 0 2.912 3.59 0 8 0ZM5.022 7.686H3.497V4.918a.156.156 0 0 0-.155-.156H2.78a.156.156 0 0 0-.156.156v3.486c0 .041.017.08.044.107v.001l.002.002.002.002a.154.154 0 0 0 .108.043h2.242c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157Zm.791-2.924a.156.156 0 0 0-.156.156v3.486c0 .086.07.155.156.155h.562c.086 0 .155-.07.155-.155V4.918a.156.156 0 0 0-.155-.156h-.562Zm3.863 0a.156.156 0 0 0-.156.156v2.07L7.923 4.832a.17.17 0 0 0-.013-.015v-.001a.139.139 0 0 0-.01-.01l-.003-.003a.092.092 0 0 0-.011-.009h-.001L7.88 4.79l-.003-.002a.029.029 0 0 0-.005-.003l-.008-.005h-.002l-.003-.002-.01-.004-.004-.002a.093.093 0 0 0-.01-.003h-.002l-.003-.001-.009-.002h-.006l-.003-.001h-.004l-.002-.001h-.574a.156.156 0 0 0-.156.155v3.486c0 .086.07.155.156.155h.56c.087 0 .157-.07.157-.155v-2.07l1.6 2.16a.154.154 0 0 0 .039.038l.001.001.01.006.004.002a.066.066 0 0 0 .008.004l.007.003.005.002a.168.168 0 0 0 .01.003h.003a.155.155 0 0 0 .04.006h.56c.087 0 .157-.07.157-.155V4.918a.156.156 0 0 0-.156-.156h-.561Zm3.815.717v-.56a.156.156 0 0 0-.155-.157h-2.242a.155.155 0 0 0-.108.044h-.001l-.001.002-.002.003a.155.155 0 0 0-.044.107v3.486c0 .041.017.08.044.107l.002.003.002.002a.155.155 0 0 0 .108.043h2.242c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157H11.81v-.589h1.525c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157H11.81v-.589h1.525c.086 0 .155-.07.155-.156Z"/>
										</svg>
                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
			</div>
            <?php
            if ($configClass['show_agent_contact'] == 1)
            {
            ?>
			<div class="<?php echo $bootstrapHelper->getClassMapping('span4'); ?>">
                <form method="POST" action="<?php echo JRoute::_('index.php?option=com_osproperty&task=agent_submitcontact')?>" name="contactForm" id="contactForm">
                    <?php
                    HelperOspropertyCommon::contactForm('contactForm', $configClass['general_bussiness_name'], $agent->name);
                    ?>
                    <input type="hidden" name="option" value="com_osproperty" />
                    <input type="hidden" name="task" value="agent_submitcontact" />
                    <input type="hidden" name="id" value="<?php echo $agent->id?>" />
                    <input type="hidden" name="Itemid" value="<?php echo $jinput->getInt('Itemid',0)?>" />
                </form>
			</div>
            <?php } ?>
		</div>
        <?php
        $bio = OSPHelper::getLanguageFieldValue($agent,'bio');
        if($bio != "")
        {
            ?>
            <div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
                <div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?> agentbio">
                    <span class="agentbioheading">
                        <?php echo JText::_('OS_ABOUT');?>  <?php echo $agent->name?>
                    </span>
                    <?php
                    echo stripslashes($bio);
                    ?>
                </div>
            </div>
            <div class="clearfix"></div>
        <?php } ?>
	</div>
</div>