<?php
/*------------------------------------------------------------------------
# agent.php - Ossolution Property
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2023 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/
// No direct access.
defined('_JEXEC') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

class OspropertyAgent
{
	/**
	 * Display Default agent layout
	 *
	 * @param unknown_type $option
	 * @param unknown_type $task
	 */
	static function display($option,$task)
    {
		global $mainframe,$jinput,$configClass;
		$document = JFactory::getDocument();
		$cid = $jinput->get('cid',array(),'ARRAY');
		$cid = \Joomla\Utilities\ArrayHelper::toInteger($cid);
		$id = $jinput->getInt('id');
		$show_top_menus_in = $configClass['show_top_menus_in'];
		$show_top_menus_in = explode("|",$show_top_menus_in);
		if(in_array('agent',$show_top_menus_in))
		{
			echo HelperOspropertyCommon::buildToolbar('agent');
		}
		switch ($task){
			case "agent_listing":
			case "agent_layout":
				OspropertyAgent::agentLayout($option);
			break;
			default:
			case "agent_default":
			case "agent_editprofile":
				OspropertyAgent::editProfile($option);
			break;
			case "agent_saveprofile":
				OspropertyAgent::saveProfile($option);
			break;
			case "agent_saveaccount":
				OspropertyAgent::saveAccount($option);
			break;
			case "agent_savepassword":
				OspropertyAgent::savePassword($option);
			break;
			case "agent_editproperty":
				OspropertyAgent::editProperties($option,$cid[0]);
			break;
			case "agent_publishproperties":
				OspropertyListing::propertyChange($option,$cid,1);
			break;
			case "agent_unpublishproperties":
				OspropertyListing::propertyChange($option,$cid,0);
			break;
			case "agent_deleteproperties":
				OspropertyListing::deleteProperties($option,$cid);
			break;
			case "agent_details":
			case "agent_info":
				OspropertyAgent::agentInfo($option,$id);
			break;
			case "agent_submitcontact":
				OspropertyAgent::submitContact($option,$id);
			break;
			case "agent_requestapproval":
				OspropertyListing::requestApproval($option,$cid);
			break;
			case "agent_register":
				OspropertyAgent::agentRegister($option);
			break;
			case "agent_completeregistration":
				OspropertyAgent::completeRegistration($option);
			break;
            case "agent_testlogin":
                OspropertyAgent::testLogin($option);
            break;
		}
		HelperOspropertyCommon::loadFooter($option);
	}
	
	
	static function insertDB($option)
    {
		global $mainframe,$jinput;
		$db = JFactory::getDbo();
		$state = "";
		$stateArr = explode("\n",$state);
		for($i=0;$i<count($stateArr);$i++)
		{
			$state = $stateArr[$i];
			$db->setQuery("INSERT INTO #__osrs_states values (null,66,'$state','$state',0)");
			$db->execute();
		}
	}

	/**
	 * Agent Layout
	 * Show the search and list agents
	 * @param unknown_type $option
	 */
	static function agentLayout($option)
    {
		global $mainframe,$jinput,$configClass,$lang_suffix;
		OSPHelper::generateHeading(1,$configClass['general_bussiness_name']." - ".JText::_('OS_LIST_AGENTS'));
		$db                     = JFactory::getDbo();
		$limit                  = $jinput->getInt('limit',$configClass['general_number_properties_per_page']);
		$limitstart	            = OSPHelper::getLimitStart();
        $show_agent_with_properties = $configClass['show_agent_with_properties'];
		$state                  = $jinput->getInt('state',0);
		$agenttype              = $jinput->getInt('usertype',-1);
		$default_sortby         = OSPHelper::getStringRequest('default_sortby','a.ordering');
		$default_orderby        = OSPHelper::getStringRequest('default_orderby','asc');
		$alphabet               = OSPHelper::getStringRequest('alphabet','','');
		$general_default_agents_sort = $default_sortby;
		$general_default_agents_order = $default_orderby;
		$connector				= ($configClass['joomlauser'] == 1) ? 'left' : 'inner';
		$query                  = "Select count(a.id) from #__osrs_agents as a ".$connector." join #__users as b on b.id = a.user_id ";
		if ($show_agent_with_properties == 1)
        {
            $query              .= " inner join #__osrs_properties as c on a.id = c.agent_id";
        }
		$query                  .= " where a.published = '1'";
        if($configClass['use_privacy_policy'] == 1)
        {
            $query              .= " and a.optin= '0'";
        }
        if ($show_agent_with_properties == 1)
        {
            $query              .= " and c.approved = '1' and c.published = '1'";
        }
		if($alphabet != "")
		{
			switch ($alphabet)
            {
				default:
					$query      .= " and (a.name like '".strtoupper($alphabet)."%' or a.name like '".strtolower($alphabet)."%')";
				break;
				case "0-9":
					$query      .= "and (";
					for($i=0;$i<10;$i++)
					{
						$query .= " a.name like '".$alphabet."%' or";
					}
					$query      = substr($query,0,strlen($query)-2);
					$query      .= ")";
				break;
			}
		}
		if($agenttype >= 0)
		{
			$query              .= " and a.agent_type = '$agenttype'";
		}
        $query                  .= " group by a.id" ;
		$db->setQuery($query);
		$total                  = $db->loadResult();

		if($configClass['overrides_pagination'] == 1)
		{
			$pageNav            = new OSPJPagination($total,$limitstart,$limit);
		}
		else
		{
			$pageNav            = new JPagination($total,$limitstart,$limit);
		}
        if($configClass['use_privacy_policy'] == 1)
        {
            $opinSql            = " and a.optin= '0'";
        }
        else
        {
            $opinSql            = "";
        }
		$connector				= ($configClass['joomlauser'] == 1) ? 'left' : 'inner';
		$query                  = "Select a.* from #__osrs_agents as a ".$connector." join #__users as b on b.id = a.user_id " ;
        if ($show_agent_with_properties == 1)
        {
            $query              .= " inner join #__osrs_properties as c on a.id = c.agent_id";
        }
		$query                  .= " where a.published = '1' ".$opinSql;
        if ($show_agent_with_properties == 1)
        {
            $query              .= " and c.approved = '1' and c.published = '1'";
        }
		if($alphabet != "")
		{
			switch ($alphabet)
            {
				default:
					$query      .= " and (a.name like '".strtoupper($alphabet)."%' or a.name like '".strtolower($alphabet)."%')";
				break;
				case "0-9":
					$query      .= "and (";
					for($i=0;$i<10;$i++)
					{
						$query .= " a.name like '".$alphabet."%' or";
					}
					$query      = substr($query,0,strlen($query)-2);
					$query      .= ")";
				break;
			}
		}
		if($agenttype >= 0)
		{
			$query              .= " and a.agent_type = '$agenttype'";
		}
		$query                  .= " group by a.id order by ".$general_default_agents_sort." ".$general_default_agents_order;
		$db->setQuery($query,$pageNav->limitstart,$pageNav->limit);
		$rows                   = $db->loadObjectList();
		
		if(count($rows) > 0)
		{
			$access             = ' and `access` IN (' . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ')';
			for($i=0;$i<count($rows);$i++)
			{
				$row            = $rows[$i];
				$db->setQuery("Select count(id) from #__osrs_properties where agent_id = '$row->id' and approved = '1' and published = '1' ".$access);
				$countlisting   = $db->loadResult();
				$row->countlisting = intval($countlisting);
				
				$db->setQuery("Select state_name$lang_suffix as state_name from #__osrs_states where id = '$row->state'");
				$row->state_name = $db->loadResult();
				$db->setQuery("Select country_name from #__osrs_countries where id = '$row->country'");
				$row->country_name = $db->loadResult();
			}
		}
		
		$agent_id               = $jinput->getInt('agent_id',0);
		if(HelperOspropertyCommon::checkCountry())
		{
			$country_id         = $jinput->getInt('country_id',0);
		}
		else
		{
			$country_id         = intval(HelperOspropertyCommon::getDefaultCountry());
		}
		
		$state_id               = $jinput->getInt('state_id',0);
		$city 	                = $jinput->getInt('city',0);
		$address                = OSPHelper::getStringRequest('address','','post');
		$distance               = $jinput->getInt('distance',5);

        if($address != "")
        {
            $google_address_search = $address;
        }
        if($city > 0)
        {
            $city_name          = HelperOspropertyCommon::loadCityName($city);
            $google_address_search .= ", ".$city_name;
        }
        if(intval($state_id) > 0)
        {
            $db->setQuery("Select state_name$lang_suffix as state_name from #__osrs_states where id = '$state_id'");
            $state_name         = $db->loadResult();
            if($state_name != "")
            {
                $google_address_search .= ", ".$state_name;
            }
        }

        if(intval($country_id) > 0)
        {
            $db->setQuery("Select country_name from #__osrs_countries where id = '$country_id'");
            $country_name       = $db->loadResult();
            if($country_name != "")
            {
                $google_address_search .= ", ".$country_name;
            }
        }

        $count  = "Select count(a.id) from #__osrs_agents as a";
        $select = "Select a.*,b.state_name$lang_suffix as state_name,c.city$lang_suffix as city_name,d.country_name from #__osrs_agents as a"
                ." left join #__osrs_states as b on b.id = a.state"
                ." left join #__osrs_cities as c on c.id = a.city"
                ." inner join #__osrs_countries as d on d.id = a.country";
        $where                  = " WHERE a.published = '1'";
        if($address != "")
        {
            $where .= " AND a.address like '%$address%'";
        }
        if($city > 0)
        {
            $where .= " AND a.city = '$city'";
        }
        if($state_id > 0)
        {
            $where .= " AND a.state = '$state_id'";
        }
        if($country_id > 0)
        {
            $where .= " AND a.country = '$country_id'";
        }
        if($agenttype >= 0)
        {
            $where .= " AND a.agent_type = '$agenttype'";
        }

        if($configClass['use_privacy_policy'] == 1)
        {
            $where .= " and a.optin= '0'";
        }

        $Order_by = " order by ".$general_default_agents_sort." ".$general_default_agents_order;

        $db->setQuery($count.' '.$where);
        $total = $db->loadResult();
        if($total > 24)
        {
            $lists['show_over'] = 1;
            $limit = " LIMIT 24";
        }
        else
        {
            $lists['show_over'] = 0;
            $limit = "";
        }
        $db->setQuery($select.' '.$where.' '.$Order_by.' '.$limit);
        $rows1 = $db->loadObjectList();
        if(count($rows1) > 0)
        {
            //check the google lat long addresses and show them in the google map and num listing
            for($i=0;$i<count($rows1);$i++)
            {
                $row = $rows1[$i];
                $db->setQuery("Select count(id) from #__osrs_properties where agent_id = '$row->id' and approved = '1'");
                $countlisting = $db->loadResult();
                $row->countlisting = intval($countlisting);

                $address = $row->address;
                if($row->city != "")
                {
                    $address .= " ".$row->city;
                }
                if($row->state_name != "")
                {
                    $address .= " ".$state_name;
                }
                if($row->country_name != "")
                {
                    $address .= " ".$country_name;
                }
            }
        }
		
		$lists['country'] = HelperOspropertyCommon::makeCountryList($country_id,'country_id','onchange="change_country_company(this.value,'.$state_id.','.$city.')"',JText::_('OS_ANY'),'','input-medium form-select ilarge');
		if(OSPHelper::userOneState())
		{
			$lists['state'] = "<input type='hidden' name='state_id' id='state_id' value='".OSPHelper::returnDefaultState()."'/>";
		}
		else
		{
			$lists['state'] = HelperOspropertyCommon::makeStateList($country_id,$state_id,'state_id','onchange="change_state(this.value,'.intval($city).')" class="input-medium form-select ilarge"',JText::_('OS_ANY'),'');
		}
			
		//list city
		//$lists['city'] = HelperOspropertyCommon::loadCity(option,$state_id, $city);
		$default_state = 0;
		if(OSPHelper::userOneState())
		{
			$default_state = OSPHelper::returnDefaultState();
		}
		else
		{
			$default_state = $state_id;
		}
		$lists['city'] = HelperOspropertyCommon::loadCity($option,$default_state, $city);
		
		$radius_arr = array(5,10,20,50,100,200);
		$radiusArr = array();
		$radiusArr[] = JHTML::_('select.option','',JText::_('OS_SELECT_RADIUS'));
		foreach ($radius_arr as $radius)
		{
			$radiusArr[] = JHtml::_('select.option',$radius, $radius. ' '. JText::_('OS_MILES'));
		}
		$lists['radius'] = JHtml::_('select.genericlist',$radiusArr,'distance','class="input-small ilarge form-select"', 'value', 'text',$distance);
		$lists['agenttype'] = $agenttype;
		HTML_OspropertyAgent::agentLayout($option,$rows,$pageNav,$alphabet,$rows1,$lists);
	}

	
	/**
	 * Agent Info
	 * Show the details of one agent
	 *
	 * @param unknown_type $option
	 * @param unknown_type $id
	 */
	static function agentInfo($option,$id){
		global $mainframe,$jinput,$configClass,$lang_suffix;
		$db                 = JFactory::getDbo();

		OSPHelper::loadTooltip();
		if(intval($id) == 0){
			throw new Exception(JText::_('OS_AGENT_NOT_AVAILABLE'), 404);
		}
		$db->setQuery("Select * from #__osrs_agents where id = '$id'");
		$agent              = $db->loadObject();

		$itemid             = OSPRoute::getAgentItemid($id);
		if($agent->published == 0){
			throw new Exception(JText::_('OS_AGENT_NOT_AVAILABLE'), 404);
		}
        $session            = JFactory::getSession();
        $session->set('agent_id',$id);
		//pathway
		$pathway            = $mainframe->getPathway();
		$pathway->addItem(JText::_('OS_AGENT'),JRoute::_('index.php?option=com_osproperty&view=lagents&Itemid='.$itemid));
		$pathway->addItem($agent->name,JRoute::_('index.php?option=com_osproperty&task=agent_info&id='.$agent->id.'&Itemid='.$jinput->getInt('Itemid',0)));
		
		$document           = JFactory::getDocument();
		$document->setTitle($configClass['general_bussiness_name']." - ".JText::_('OS_AGENT_DETAILS')." - ".$agent->name);
		$db->setQuery("Select id,company_name,photo from #__osrs_companies where id = '$agent->company_id'");
		$company            = $db->loadObject();
		$agent->company_name = $company->company_name;
		$agent->company_photo = $company->photo;
		if($agent->company_photo != "")
		{
			$agent->company_photo = JURI::root()."images/osproperty/company/thumbnail/".$agent->company_photo;
		}else{
			$agent->company_photo = JURI::root()."media/com_osproperty/assets/images/nopropertyphoto.png";
		}
		$db->setQuery("Select state_name$lang_suffix as state_name from #__osrs_states where id = '$agent->state'");
		$agent->state_name = $db->loadResult();
		$db->setQuery("Select country_name from #__osrs_countries where id = '$agent->country'");
		$agent->country_name = $db->loadResult();
		
		$db->setQuery("Select count(id) from #__osrs_properties where agent_id = '$id' and published = '1' and approved = '1'");
		$countpro           = $db->loadResult();
		$lists['countpro']  = $countpro;
		if($countpro > 0)
		{ // have the properties
			$db->setQuery("Select id,pro_name$lang_suffix,hits from #__osrs_properties where hits > 0  and agent_id = '$id' and published = '1' and approved = '1' order by hits desc limit 5");
			$lists['mostview'] = $db->loadObjectList();
			
			$db->setQuery("Select id,pro_name$lang_suffix,(total_points/number_votes) as rated from #__osrs_properties where agent_id = '$id' and published = '1' and approved = '1' and number_votes > 0 order by (total_points/number_votes) desc limit 5");
			$lists['mostrate'] = $db->loadObjectList();
		}
		HTML_OspropertyAgent::agentInfoForm($option,$agent,$lists);
	}
	
	/**
	 * Edit profile layout
	 *
	 * @param unknown_type $option
	 */
	static function editProfile($option){
		global $mainframe,$jinput,$configClass,$languages;
		$config         = new JConfig();
		$translatable   = JLanguageMultilang::isEnabled() && count($languages);
		$sef			= OSPHelper::getFieldSuffix();

		$list_limit     = $config->list_limit;
		JHtml::_('behavior.keepalive');
		$db             = JFactory::getDBO();
		$user           = JFactory::getUser();
		if($user->id == 0){
			OSPHelper::redirect(JURI::root(),JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA'));
		}
		if(!HelperOspropertyCommon::isRegisteredAgent()){
			$agent_id   = OSPHelper::registerNewAgent($user,$configClass['default_user_type']);
		}
		$document       = JFactory::getDocument();
		$document->setTitle($configClass['general_bussiness_name']." - ".JText::_('OS_EDIT_MY_PROFILE'));

		$limit			= $jinput->getInt('limit',$list_limit);
		$limitstart     = OSPHelper::getLimitStartPost();

		$db->setQuery("Select * from #__osrs_agents where user_id = '$user->id'");
		$agent = $db->loadObject();

		$category_id    = $jinput->getInt('category_id',0);
		$catIds 	    = array();
		$catIds[]	    = $category_id;
		$type_id        = $jinput->getInt('type_id',0);
		$status         = $jinput->getString('status','');
        $featured       = $jinput->getInt('featured_stt',-1);
        $approved       = $jinput->getInt('approved',-1);
		//country

		$lists['country'] = HelperOspropertyCommon::makeCountryList($agent->country,'country','onChange="javascript:loadState(this.value,\''.$agent->state.'\',\''.$agent->city.'\')"',JText::_('OS_SELECT_COUNTRY'),'','input-large form-select');

		if(OSPHelper::userOneState()){
			$lists['state'] = "<input type='hidden' name='state' id='state' value='".$agent->state."'/>";
		}else{
			$lists['state'] = HelperOspropertyCommon::makeStateListAddProperty($agent->country,$agent->state,'state','onChange="javascript:loadCity(this.value,\''.$agent->city.'\')"',JText::_('OS_SELECT_STATE'),'class="input-large form-select"');
		}
		if(intval($agent->state) == 0){
			$agent->state = OSPHelper::returnDefaultState();
		}
		$lists['city']  = HelperOspropertyCommon::loadCityAddProperty($option,$agent->state,$agent->city,"input-large form-select");

		$keyword        = OSPHelper::getStringRequest('filter_search','','post');
		$orderby        = OSPHelper::getStringRequest('orderby','desc','post');
		$sortby         = OSPHelper::getStringRequest('sortby','a.id','post');

		$query = "Select count(a.id) from #__osrs_properties as a"
				." INNER JOIN #__osrs_agents as g on g.id = a.agent_id"
				." LEFT  JOIN #__osrs_types as d on d.id = a.pro_type"
				." INNER JOIN #__osrs_countries as e on e.id = a.country"
				." LEFT JOIN #__osrs_states as s on s.id = a.state"
				." LEFT JOIN #__osrs_cities as c on c.id = a.city"
				." LEFT join #__osrs_expired as ex on ex.pid = a.id"
				." WHERE a.agent_id = '$agent->id'";
		if($keyword != ""){
			$query .= " AND (a.pro_name LIKE '%$keyword%'";
			$query .= " OR a.ref like '%$keyword%'";
			$query .= " OR g.name like '%$keyword%'";
			$query .= " OR d.type_name like '%$keyword%'";
			$query .= " OR s.state_name like '%$keyword%'";
			$query .= " OR c.city like '%$keyword%'";
			$query .= ")";
		}
		if($category_id > 0){
			$query .= " AND a.id in (Select pid from #__osrs_property_categories where category_id = '$category_id')";
		}
		if($type_id > 0){
			$query .= " AND a.pro_type = '$type_id'";
		}
		if($status != ""){
			$query .= " AND a.published = '$status'";
		}
        if($featured > -1){
            $query .= " AND a.isFeatured = '$featured'";
        }
        if($approved > -1){
            $query .= " AND a.approved = '$approved'";
        }
		$db->setQuery($query);
		$count = $db->loadResult();
		
		$pageNav = new OSPJPagination($count,$limitstart,$limit);
		if($translatable)
		{
			$query = "Select a.id, a.ref, a.pro_name".$sef.",a.posted_by,a.company_id, d.id as typeid,d.type_name".$sef." as type_name,g.name as agent_name,a.published,a.approved, a.isFeatured,a.curr,a.price,a.price_call,a.rent_time,a.show_address,a.hits,c.city".$sef." as city,s.state_name".$sef." as state_name,a.address, ex.expired_time,ex.expired_feature_time,a.total_request_info,a.total_points,a.number_votes,a.agent_id from #__osrs_properties as a"
					." INNER JOIN #__osrs_agents as g on g.id = a.agent_id"
					." LEFT  JOIN #__osrs_types as d on d.id = a.pro_type"
					." INNER JOIN #__osrs_countries as e on e.id = a.country"
					." LEFT JOIN #__osrs_states as s on s.id = a.state"
					." LEFT JOIN #__osrs_cities as c on c.id = a.city"
					." LEFT JOIN #__osrs_expired as ex on ex.pid = a.id"
					." WHERE a.agent_id = '$agent->id'";
		}
		else
		{
			$query = "Select a.id, a.ref, a.pro_name,a.posted_by,a.company_id, d.id as typeid,d.type_name as type_name,g.name as agent_name,a.published,a.approved, a.isFeatured,a.curr,a.price,a.price_call,a.rent_time,a.show_address,a.hits,c.city,s.state_name as state_name,a.address, ex.expired_time,ex.expired_feature_time,a.total_request_info,a.total_points,a.number_votes,a.agent_id from #__osrs_properties as a"
					." INNER JOIN #__osrs_agents as g on g.id = a.agent_id"
					." LEFT  JOIN #__osrs_types as d on d.id = a.pro_type"
					." INNER JOIN #__osrs_countries as e on e.id = a.country"
					." LEFT JOIN #__osrs_states as s on s.id = a.state"
					." LEFT JOIN #__osrs_cities as c on c.id = a.city"
					." LEFT JOIN #__osrs_expired as ex on ex.pid = a.id"
					." WHERE a.agent_id = '$agent->id'";
		}
		if($keyword != ""){
			$query .= " AND (a.pro_name LIKE '%$keyword%'";
			$query .= " OR a.ref like '%$keyword%'";
			$query .= " OR g.name like '%$keyword%'";
			$query .= " OR d.type_name like '%$keyword%'";
			$query .= " OR s.state_name like '%$keyword%'";
			$query .= " OR c.city like '%$keyword%'";
			$query .= ")";
		}
		if($category_id > 0){
			$query .= " AND a.id in (Select pid from #__osrs_property_categories where category_id = '$category_id')";
		}
		if($type_id > 0){
			$query .= " AND a.pro_type = '$type_id'";
		}
		if($status != ""){
			$query .= " AND a.published = '$status'";
		}
        if($featured > -1){
            $query .= " AND a.isFeatured = '$featured'";
        }
        if($approved > -1){
            $query .= " AND a.approved = '$approved'";
        }
		$query .= " ORDER BY $sortby $orderby";
		
		$db->setQuery($query,$pageNav->limitstart,$pageNav->limit);
		//echo $db->getQuery();
		$rows = $db->loadObjectList();
		if(count($rows) > 0)
		{
			for($i=0;$i<count($rows);$i++)
			{
				$row = $rows[$i];
				$db->setQuery("select count(id) from #__osrs_photos where pro_id = '$row->id'");
				$count = $db->loadResult();
				if($count > 0)
				{
					$row->count_photo = $count;
					$db->setQuery("select image from #__osrs_photos where pro_id = '$row->id' order by ordering");	
					$photo = $db->loadResult();
					if($photo != "")
					{
						if(file_exists(JPATH_ROOT.'/images/osproperty/properties/'.$row->id.'/thumb/'.$photo))
						{
							$row->photo = JURI::root(true)."/images/osproperty/properties/".$row->id."/thumb/".$photo;
						}
						else
						{
							$row->photo = JURI::root(true)."/media/com_osproperty/assets/images/nopropertyphoto.png";
						}
					}else{
						$row->photo = JURI::root(true)."/media/com_osproperty/assets/images/nopropertyphoto.png";
					}
				}
				else
				{
					$row->count_photo = 0;
					$row->photo = JURI::root(true)."/media/com_osproperty/assets/images/nopropertyphoto.png";
				}//end photo
			}
		}

		if($configClass['active_payment'] == 1)
		{
			$db->setQuery("Select * from #__osrs_orders where agent_id = '$agent->id' and created_by = '0' order by created_on desc");
			$orders = $db->loadObjectList();
			$lists['orders'] = $orders;
		}
		
		$db->setQuery("Select count(id) from #__osrs_properties where agent_id = '$agent->id' and published = '1' and approved = '1'");
		$countpro = $db->loadResult();
		$lists['countpro'] = $countpro;
		if($countpro > 0)
		{ // have the properties
			$db->setQuery("Select id,pro_name,hits from #__osrs_properties where hits > 0  and agent_id = '$agent->id' and published = '1' and approved = '1' order by hits desc limit 5");
			$lists['mostview'] = $db->loadObjectList();
			
			$db->setQuery("Select id,pro_name,(total_points/number_votes) as rated from #__osrs_properties where agent_id = '$agent->id' and published = '1' and approved = '1' and number_votes > 0 order by (total_points/number_votes) desc limit 5");
			$lists['mostrate'] = $db->loadObjectList();
		}
		
		$orderbyArr[] = JHTML::_('select.option','',JText::_('OS_ORDERBY'));
		$orderbyArr[] = JHTML::_('select.option','asc',JText::_('OS_ASC'));
		$orderbyArr[] = JHTML::_('select.option','desc',JText::_('OS_DESC'));
		$lists['orderby'] = JHTML::_('select.genericlist',$orderbyArr,'orderby','class="input-medium form-select" onchange="javascript:this.form.submit();"','value','text',$orderby);
		
		$sortbyArr[] = JHTML::_('select.option','',JText::_('OS_SORTBY'));
		$sortbyArr[] = JHTML::_('select.option','a.ref',JText::_('Ref #'));
		$sortbyArr[] = JHTML::_('select.option','a.pro_name',JText::_('OS_TITLE'));
		$sortbyArr[] = JHTML::_('select.option','a.address',JText::_('OS_ADDRESS'));
		$sortbyArr[] = JHTML::_('select.option','a.state',JText::_('OS_STATE'));
		$sortbyArr[] = JHTML::_('select.option','a.city',JText::_('OS_CITY'));
		$sortbyArr[] = JHTML::_('select.option','a.published',JText::_('OS_PUBLISHED'));
		$sortbyArr[] = JHTML::_('select.option','a.isFeatured',JText::_('OS_FEATURED'));
		$sortbyArr[] = JHTML::_('select.option','a.id',JText::_('ID'));
		$sortbyArr[] = JHTML::_('select.option','a.price',JText::_('OS_PRICE'));
		$lists['sortby'] = JHTML::_('select.genericlist',$sortbyArr,'sortby','class="input-medium form-select" onchange="javascript:this.form.submit();"','value','text',$sortby);
		
		$lists['category'] = OSPHelper::listCategories($category_id,'onChange="this.form.submit();"');
		
		//property types
		$typeArr[] = JHTML::_('select.option','',JText::_('OS_ALL_PROPERTY_TYPES'));
		if($translatable)
		{
			$db->setQuery("SELECT id as value,type_name".$sef." as text FROM #__osrs_types where published = '1' ORDER BY type_name");
		}
		else
		{
			$db->setQuery("SELECT id as value,type_name as text FROM #__osrs_types where published = '1' ORDER BY type_name");
		}
		$protypes = $db->loadObjectList();
		$typeArr   = array_merge($typeArr,$protypes);
		$lists['type'] = JHTML::_('select.genericlist',$typeArr,'type_id','class="input-large" onChange="this.form.submit();"','value','text',$type_id);
		
		$statusArr = array();
		$statusArr[] = JHTML::_('select.option','',JText::_('OS_ALL_STATUS'));
		$statusArr[] = JHTML::_('select.option',0,JText::_('OS_UNPUBLISHED'));
		$statusArr[] = JHTML::_('select.option',1,JText::_('OS_PUBLISHED'));
		$lists['status'] = JHTML::_('select.genericlist',$statusArr,'status','class="input-medium form-select" onChange="this.form.submit();"','value','text',$status);

		$optArr = array();
        $optArr[] = JHTML::_('select.option',0,JText::_('OS_YES'));
        $optArr[] = JHTML::_('select.option',1,JText::_('OS_NO'));
        $lists['optin'] = JHTML::_('select.genericlist',$optArr,'optin','class="input-medium form-select"','value','text',(int)$agent->optin);

        $featuredArr = array();
        $featuredArr[] = JHtml::_('select.option','-1',JText::_('OS_FEATURED_STATUS'));
        $featuredArr[] = JHtml::_('select.option','0',JText::_('OS_NON_FEATURED_PROPERTIES'));
        $featuredArr[] = JHtml::_('select.option','1',JText::_('OS_FEATURED_PROPERTIES'));
        $lists['featured'] = JHTML::_('select.genericlist',$featuredArr,'featured_stt','class="input-medium form-select" onChange="this.form.submit();"','value','text',$featured);

        $approvedArr = array();
        $approvedArr[] = JHtml::_('select.option','-1',JText::_('OS_APPROVAL_STATUS'));
        $approvedArr[] = JHtml::_('select.option','0',JText::_('OS_UNAPPROVED'));
        $approvedArr[] = JHtml::_('select.option','1',JText::_('OS_APPROVED'));
        $lists['approved'] = JHTML::_('select.genericlist',$approvedArr,'approved','class="input-medium form-select" onChange="this.form.submit();"','value','text',$approved);
		
		$db->setQuery("select id as value, company_name as text from #__osrs_companies where published = '1' order by company_name");
		$companies 	  = $db->loadObjectList();
		$companyArr[] = JHTML::_('select.option','',JText::_('OS_SELECT_COMPANY'));
		$companyArr   = array_merge($companyArr,$companies);
		$lists['company'] = JHTML::_('select.genericlist',$companyArr,'company_id','class="input-large form-select"','value','text',$agent->company_id);
		
		HTML_OspropertyAgent::editProfile($option,$agent,$lists,$rows,$pageNav);
	}
	
	/**
	 * Save profile
	 *
	 * @param unknown_type $option
	 */
	static function saveProfile($option){
		global $mainframe,$jinput;
		$db = JFactory::getDBO();
		if(!HelperOspropertyCommon::isAgent()){
			OSPHelper::redirect(JURI::root(),JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA'));
		}
		$msg = JText::_('OS_YOUR_PROFILE_HAS_BEEN_SAVED');
		$user = JFactory::getUser();
		
		$post = $jinput->post->getArray();
		$post['name']		= OSPHelper::getStringRequest('name', '', 'post');
        $post['username']	= $jinput->getString('username', '');
        $post['password']	= $jinput->getString('password', '');
        $post['password2']	= $jinput->getString('password2', '');
        $post['email']		= $jinput->getString('email', '');
		if (!$user->bind($post)) {
			$msg = $user->getError();
		}
		if (!$user->save()) {
			$msg = $user->getError();
		}
		$needs = array();
		$needs[] = "aeditdetails";
		$needs[] = "agent_default";
		$needs[] = "agent_editprofile";
		$itemid = OSPRoute::getItemid($needs);
		OSPHelper::redirect(JRoute::_("index.php?option=com_osproperty&task=agent_default&Itemid=".$itemid),$msg);
	}
	
	/**
	 * Save Account
	 *
	 * @param unknown_type $option
	 */
	static function saveAccount($option){
		global $mainframe,$jinput,$configClass,$languages;
		$db = JFactory::getDBO();
		jimport('joomla.filesystem.file');
		if(!HelperOspropertyCommon::isAgent()){
			OSPHelper::redirect(JURI::root(),JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA'));
		}
		
		$user = JFactory::getUser();
		$db->setQuery("Select id from #__osrs_agents where user_id = '$user->id'");
		$agent_id = $db->loadResult();
		
		$row = &JTable::getInstance('Agent','OspropertyTable');
		$post = $jinput->post->getArray();
		$row->bind($post);
		$row->bio = $_POST['bio'];
		$row->id = $agent_id;
		//store into database
		if (!$row->store()) 
		{
			throw new Exception($row->getError(), 500);
		}
		
		//update for other languages
		$translatable = JLanguageMultilang::isEnabled() && count($languages);
		if($translatable){
			foreach ($languages as $language) {	
				$sef = $language->sef;
				$bio_language = $row->bio;
				if($bio_language != ""){
					$row = &JTable::getInstance('Agent','OspropertyTable');
					$row->id = $agent_id;
					$row->{'bio_'.$sef} = $bio_language;
					$row->store();
				}
			}
		}
		
		$remove_photo = $jinput->getInt('remove_photo',0);
		
		if($configClass['show_agent_image'] == 1){
			if(is_uploaded_file($_FILES['photo']['tmp_name'])){
				if(!HelperOspropertyCommon::checkIsPhotoFileUploaded('photo')){
					$needs = array();
					$needs[] = "agent_editprofile";
					$needs[] = "agent_default";
					$needs[] = "aeditdetails";
					$itemid = OSPRoute::getItemid($needs);
					OSPHelper::redirect(JRoute::_("index.php?option=com_osproperty&task=agent_editprofile&Itemid=".$itemid),JText::_('OS_ONLY_SUPPORT_JPG_IMAGES'));
				}
                $filename = OSPHelper::uploadAndResizePicture($_FILES['photo'],"agent","");
				//save into db
				$db->setQuery("UPDATE #__osrs_agents SET photo = '$filename' WHERE id = '$agent_id'");
				$db->execute();
			}elseif($remove_photo == 1){
				HelperOspropertyCommon::removePhoto($agent_id,2);
				$db->setQuery("UPDATE #__osrs_agents SET photo = '' WHERE id = '$agent_id'");
				$db->execute();
			}
		}
		
		$alias = OSPHelper::getStringRequest('alias','','post');
		$agent_alias = OSPHelper::generateAlias('agent',$agent_id,$alias);
		$db->setQuery("Update #__osrs_agents set alias = '$agent_alias' where id = '$agent_id'");
		$db->execute();
		
		if(intval($row->company_id) > 0){
			$db->setQuery("SELECT COUNT(id) FROM #__osrs_company_agents where agent_id = '$agent_id' AND company_id = '$row->company_id'");
			$count = $db->loadResult();
			if($count == 0){
				$db->setQuery("INSERT INTO #__osrs_company_agents (id, company_id,agent_id) VALUES (NULL,'$row->company_id','$agent_id')");
				$db->execute();
			}
		}else{
			$db->setQuery("DELETE FROM #__osrs_company_agents WHERE agent_id = '$agent_id'");
			$db->execute();
		}
		$needs = array();
		$needs[] = "agent_editprofile";
		$needs[] = "agent_default";
		$needs[] = "aeditdetails";
		$itemid = OSPRoute::getItemid($needs);
		OSPHelper::redirect(JRoute::_("index.php?option=com_osproperty&task=agent_default&Itemid=".$itemid),JText::_('OS_YOUR_ACCOUNT_HAS_BEEN_SAVED'));
	}
	
	/**
	 * Save Password
	 *
	 * @param unknown_type $option
	 */
	static function savePassword($option){
		global $mainframe,$jinput;
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$user_id = $user->id;
		$password = $jinput->getString('password', '');
		$post = $jinput->post->getArray();
		$post['password'] = $password;
		$post['password_clear'] = $password;
		if (!$user->bind($post)){
			//$this->setError($this->_db->getErrorMsg());
			return false;
		}
		$user->id = $user_id;
		//print_r($user);
		if ( !$user->save() )
		{	
			throw new Exception(JText::_( $user->getError()), 500);

			return false;
		}
		$needs = array();
		$needs[] = "agent_editprofile";
		$needs[] = "agent_default";
		$needs[] = "aeditdetails";
		$itemid = OSPRoute::getItemid($needs);
		OSPHelper::redirect(JRoute::_("index.php?option=$option&task=agent_default&Itemid=".$itemid),JText::_("New password has been saved"));
	}
	
	
	/**
	 * Show agent listing
	 *
	 * @param unknown_type $option
	 */
	static function agentListing($option){
		global $mainframe,$jinput,$configClass,$lang_suffix;
		$config = new JConfig();
		$list_limit = $config->list_limit;
		$db = JFactory::getDBO();
		//check to see if this is agent
		
		if(!HelperOspropertyCommon::isAgent()){
			OSPHelper::redirect(JURI::root(),JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA'));
		}
		$document = JFactory::getDocument();
		$document->setTitle($configClass['general_bussiness_name']." - ".JText::_('My properties'));
		$user = JFactory::getUser();
		//get agent id
		$db->setQuery("Select id from #__osrs_agents where user_id = '$user->id'");
		$agent_id = $db->loadResult();
		
		$limit = $jinput->getInt('limit',$list_limit);
		$limitstart = $jinput->getInt('limitstart',0);
		$orderby = OSPHelper::getStringRequest('orderby','a.created');
		$ordertype = OSPHelper::getStringRequest('ordertype','desc');
		$query = "Select count(a.id) from #__osrs_properties as a"
				." LEFT JOIN #__osrs_types as d on d.id = a.pro_type"
				." INNER JOIN #__osrs_countries as e on e.id = a.country"
				." WHERE a.agent_id = '$agent_id'";
		$db->setQuery($query);
		$total = $db->loadResult();
		$pageNav = new OSPJPagination($total,$limitstart,$limit);
		
		$query = "Select a.*,d.type_name,e.country_name from #__osrs_properties as a"
				." LEFT JOIN #__osrs_types as d on d.id = a.pro_type"
				." INNER JOIN #__osrs_countries as e on e.id = a.country"
				." WHERE a.agent_id = '$agent_id'"
				." ORDER BY $orderby";
		$db->setQuery($query,$pageNav->limitstart,$pageNav->limit);
		$rows = $db->loadObjectList();
		
		if(count($rows) > 0){
			for($i=0;$i<count($rows);$i++){//for
				$row = $rows[$i];
				//process photo
				$db->setQuery("select count(id) from #__osrs_photos where pro_id = '$row->id'");
				$count = $db->loadResult();
				if($count > 0){
					$row->count_photo = $count;
					$db->setQuery("select image from #__osrs_photos where pro_id = '$row->id' order by ordering limit 1");	
					$row->photo = JURI::root()."images/osproperty/properties/thumb/".$db->loadResult();
				}else{
					$row->count_photo = 0;
					$row->photo = JURI::root()."media/com_osproperty/assets/images/noimage.png";
				}//end photo
				
				//get state
				$db->setQuery("Select state_name$lang_suffix as state_name from #__osrs_states where id = '$row->state'");
				$row->state_name = $db->loadResult();
				
				//rating
				if($row->number_votes > 0){
					$points = round($row->total_points/$row->number_votes);
					ob_start();
					?>
					
					<?php
					for($j=1;$j<=$points;$j++){
						?>
						<img src="<?php echo JURI::root()?>media/com_osproperty/assets/images/star1.png">
						<?php
					}
					for($j=$points+1;$j<=5;$j++){
						?>
						<img src="<?php echo JURI::root()?>media/com_osproperty/assets/images/star2.png">
						<?php
					}
					?>
							
					
					<?php
					$row->rating = ob_get_contents();
					ob_end_clean();
					
				}else{
					ob_start();
					for($j=1;$j<=5;$j++){
						?>
						<img src="<?php echo JURI::root()?>media/com_osproperty/assets/images/star2.png">
						<?php
					}
					$row->rating = ob_get_contents();
					ob_end_clean();
				} //end rating
				
				//comments
				$db->setQuery("Select count(id) from #__osrs_comments where pro_id = '$row->id'");
				$ncomment = $db->loadResult();
				if($ncomment > 0){
					$row->comment = $ncomment;
				}else{
					$row->comment = 0;
				}
				
			}//for
		}//if rows > 0
		
		
		$orderbyArr[] = JHTML::_('select.option','',JText::_('Select order by'));
		$orderbyArr[] = JHTML::_('select.option','b.category_name',JText::_('Category name'));
		$orderbyArr[] = JHTML::_('select.option','a.published',JText::_('Status'));
		$orderbyArr[] = JHTML::_('select.option','a.approved',JText::_('Approval'));
		$orderbyArr[] = JHTML::_('select.option','a.publish_down',JText::_('Expired date'));
		$lists['orderby'] = JHTML::_('select.genericlist',$orderbyArr,'orderby','onChange="javascript:document.ftForm.submit()" class="input-small"','value','text',$orderby);
		
		
		$ordertypeArr[] = JHTML::_('select.option','desc',JText::_('Descending'));
		$ordertypeArr[] = JHTML::_('select.option','asc',JText::_('Ascending'));
		$lists['ordertype'] = JHTML::_('select.genericlist',$ordertypeArr,'ordertype','onChange="javascript:document.ftForm.submit()" class="input-small"','value','text',$ordertype);
		
		HTML_OspropertyAgent::agentListing($option,$rows,$pageNav,$lists);
	}
	
	/**
	 * Edit properties
	 *
	 * @param unknown_type $option
	 * @param unknown_type $id
	 */
	static function editProperties($option,$id){
		global $mainframe,$jinput;
		OSPHelper::redirect(JRoute::_("index.php?option=com_osproperty&task=property_edit&id=$id&Itemid=".$jinput->getInt('Itemid',0)));
	}
	
	
	/**
	 * Submit contact
	 *
	 * @param unknown_type $option
	 * @param unknown_type $id
	 */
	static function submitContact($option,$id){
		global $mainframe,$jinput,$configClass;
		$db = JFactory::getDbo();
		
		if($configClass['show_agent_contact'] == 0){
			$msg = JText::_('OS_THIS_static functionALITY_DOES_NOT_BE_ACTIVATED');
			$itemid = $jinput->getInt('Itemid',0);
			OSPHelper::redirect(JRoute::_("index.php?option=com_osproperty&task=agent_info&id=".$id."&Itemid=".$jinput->getInt('Itemid')),$msg);
		}

		/*
		$captcha_str = $_POST['captcha_str'];
		$comment_security_code = $jinput->getString('comment_security_code','');
		if($comment_security_code == ''){
			$msg = JText::_('OS_SECURITY_CODE_IS_WRONG');
			$itemid = $jinput->getInt('Itemid',0);
			OSPHelper::redirect(JRoute::_("index.php?option=com_osproperty&task=agent_info&id=".$id."&Itemid=".$jinput->getInt('Itemid')),$msg);
			//OSPHelper::redirect($url,$msg);
		}
		if($captcha_str == ''){
			$msg = JText::_('OS_SECURITY_CODE_IS_WRONG');
			$itemid = $jinput->getInt('Itemid',0);
			OSPHelper::redirect(JRoute::_("index.php?option=com_osproperty&task=agent_info&id=".$id."&Itemid=".$jinput->getInt('Itemid')),$msg);
			//OSPHelper::redirect($url,$msg);
		}
		if($comment_security_code != $captcha_str){
			$msg = JText::_('OS_SECURITY_CODE_IS_WRONG');
			$itemid = $jinput->getInt('Itemid',0);
			OSPHelper::redirect(JRoute::_("index.php?option=com_osproperty&task=agent_info&id=".$id."&Itemid=".$jinput->getInt('Itemid')),$msg);
			//OSPHelper::redirect($url,$msg);
		}
		*/
		if($configClass['integrate_stopspamforum'] == 1){
			if(OSPHelper::spamChecking()){
				$msg = JText::_('OS_EMAIL_CANT_BE_SENT');
                OSPHelper::redirect(JRoute::_("index.php?option=com_osproperty&task=agent_info&id=".$id."&Itemid=".$jinput->getInt('Itemid')),$msg);
			}
		}

        $session = JFactory::getSession();
        $agent_id = $session->get('agent_id',0);
        if(($agent_id == 0) or ($agent_id != $id)){
            $msg = JText::_('OS_SECURITY_CODE_IS_WRONG');
            OSPHelper::redirect(JRoute::_("index.php?option=com_osproperty&task=agent_info&id=".$id."&Itemid=".$jinput->getInt('Itemid')),$msg);
        }

		$date = date("j",time());
		$comment_author = $jinput->getString('comment_author'.$date,'');
		$comment_email = $jinput->getString('comment_email'.$date,'');
		if(($comment_author == "") or ($comment_email == "")){
			$msg = JText::_('OS_EMAIL_CANT_BE_SENT');
			OSPHelper::redirect(JRoute::_("index.php?option=com_osproperty&task=agent_info&id=".$id."&Itemid=".$jinput->getInt('Itemid')),$msg);
		}
		$comment_title  = OSPHelper::getStringRequest('comment_title','','post');
		$message		= $_POST['message'];
		
		$contact['author']  = $comment_author;
		$contact['email']   = $comment_email;
		$contact['title']   = $comment_title;
		$contact['message'] = $message;
		
		//send contact email
		$db->setQuery("Select * from #__osrs_agents where id = '$id'");
		$agent  = $db->loadObject();
		$emailto  = $agent->email;
		$contact['emailto'] = $emailto;
		$receiver =	$agent->name;
		$contact['receiver'] = $receiver;
		
		OspropertyEmail::sendContactEmail($option,$contact);
		
		OSPHelper::redirect(JRoute::_("index.php?option=com_osproperty&task=agent_info&id=".$id."&Itemid=".$jinput->getInt('Itemid')),JText::_('OS_EMAIL_HAS_BEEN_SENT'));
	}
	
	/**
	 * Agent register
	 *
	 * @param unknown_type $option
	 */
	static function agentRegister($option)
	{
		global $mainframe,$jinput,$configClass,$bootstrapHelper;
		$db = JFactory::getDbo();
		$user = JFactory::getUser();
		$session = JFactory::getSession();
		if($configClass['allow_agent_registration'] == 0){
			OSPHelper::redirect(JURI::root(),JText::_('OS_YOU_DO_NOT_HAVE_PERMISION_TO_GO_TO_THIS_AREA'));
		}
		if(HelperOspropertyCommon::isCompanyAdmin())
		{
			$needs = array();
			$needs[] = "company_edit";
			$needs[] = "ccompanydetails";
			$itemid = OSPRoute::getItemid($needs);
			$itemid = OSPRoute::confirmItemidArr($itemid,$needs);
			if(!OSPRoute::reCheckItemid($itemid,$needs))
			{
				$itemid = 9999;
			}
			OSPHelper::redirect(JRoute::_('index.php?option=com_osproperty&task=company_edit&Itemid='.$itemid));
		}
		if(HelperOspropertyCommon::isAgent())
		{
			$needs = array();
			$needs[] = "agent_editprofile";
			$needs[] = "agent_default";
			$needs[] = "aeditdetails";
			$itemid = OSPRoute::getItemid($needs);
			$itemid = OSPRoute::confirmItemidArr($itemid,$needs);
			if(!OSPRoute::reCheckItemid($itemid,$needs)){
				$itemid = 9999;
			}
			OSPHelper::redirect(JRoute::_('index.php?option=com_osproperty&task=agent_editprofile&Itemid='.$itemid));
		}
		OSPHelper::generateHeading(1,$configClass['general_bussiness_name']." - ".JText::_('OS_AGENT_REGISTER'));

		$companyregister= $session->get('companyregister');
		if($companyregister == 1){
			$session->set('post',array());
		}
		$inputLargeClass	= $bootstrapHelper->getClassMapping('input-large');
		$inputMediumClass	= $bootstrapHelper->getClassMapping('input-medium');
		$inputSmallClass	= $bootstrapHelper->getClassMapping('input-small');
		$inputMiniClass		= $bootstrapHelper->getClassMapping('input-mini');
		$menus = JFactory::getApplication()->getMenu();
		$menu = $menus->getActive();
		if (is_object($menu)) {
			$params = new JRegistry() ;
	        $params->loadString($menu->getParams());
			$lists['company_id_selected'] = $params->get('company_id',0);
		}

		$post			= $session->get('post');
		$state			= $post['state'];
		$city			= $post['city'];
		$country		= $post['country'];
		$company_id		= $post['company_id'];

		$db->setQuery("select id as value, company_name as text from #__osrs_companies where published = '1' order by company_name");
		$companies 	  = $db->loadObjectList();
		$companyArr[] = JHTML::_('select.option','',JText::_('OS_SELECT_COMPANY'));
		$companyArr   = array_merge($companyArr,$companies);
		$lists['company'] = JHTML::_('select.genericlist',$companyArr,'company_id','class="'.$inputLargeClass.'"','value','text',$company_id);

		$lists['country'] = HelperOspropertyCommon::makeCountryList($country,'country','onchange="change_country_company(this.value,0,0)"',JText::_('OS_SELECT_COUNTRY'),'',$inputLargeClass);
		
		if(OSPHelper::userOneState())
		{
			$lists['state'] = "<input type='hidden' name='state' id='state' value='".OSPHelper::returnDefaultState()."'/>".OSPHelper::returnDefaultStateName();
		}
		else
		{
			$lists['state'] = HelperOspropertyCommon::makeStateListAddProperty('',$state,'state','onchange="loadCity(this.value,0)"',JText::_('OS_SELECT_STATE'),'class="'.$inputLargeClass.' form-select"');
		}
		if(OSPHelper::userOneState())
		{
			$default_state = OSPHelper::returnDefaultState();
		}
		else
		{
			$default_state = $state;
		}
		$lists['city'] = HelperOspropertyCommon::loadCity($option,$default_state,$city,$inputLargeClass);
		
		HTML_OspropertyAgent::agentRegisterForm($user,$lists,$companies);
	}
	
	/**
	 * Complete registration
	 *
	 * @param unknown_type $option
	 */
	static function completeRegistration($option)
	{
		global $mainframe,$jinput,$configClass,$languages;
        $msg = array();
		$db = JFactory::getDbo();

		OSPHelper::antiSpam();

		if($configClass['captcha_agent_register'] == 1)
		{
			$captchaPlugin = JFactory::getApplication()->getParams()->get('captcha', JFactory::getConfig()->get('captcha'));
			$plugin		   = JPluginHelper::getPlugin('captcha', $captchaPlugin);
			if ($plugin)
			{
				try
				{
					$res   = JCaptcha::getInstance($captchaPlugin)->checkAnswer($jinput->post->get('recaptcha_response_field', '', 'string'));
					if (!$res)
					{
						OSPHelper::redirect(JRoute::_('index.php?option=com_osproperty&task=agent_register&Itemid='.$jinput->getInt('Itemid',0)),JText::_('OS_SECURITY_CODE_IS_WRONG'));
					}
				}
				catch (Exception $e)
				{
					//do the same with case !$res
					OSPHelper::redirect(JRoute::_('index.php?option=com_osproperty&task=agent_register&Itemid='.$jinput->getInt('Itemid',0)),JText::_('OS_SECURITY_CODE_IS_WRONG'));
				}
			}
		}

		//process session
		$session = JFactory::getSession();
		$post	 = $jinput->post->getArray();
		$session->set('post',$post);
		$session->set('agentregister',1);
		$session->set('companyregister',0);
		
		$user 		= clone(JFactory::getUser());
		$needs = array();
		$needs[] = "aagentregistration";
		$needs[] = "agent_register";
		$itemid = OSPRoute::getItemid($needs);
			
		$userid = $jinput->getInt( 'id', 0, 'post', 'int' );
		$errors = [];
		if(intval($user->id) == 0)
		{
			// Validate username and password
			//if (!$user->id && $config->user_registration)
			//{
			$errors = array_merge($errors, OSPHelper::validateUsername($jinput->post->get('username', '', 'raw')));
			$errors = array_merge($errors, OSPHelper::validatePassword($jinput->post->get('password', '', 'raw')));
			if(count($errors))
			{
				OSPHelper::redirect(JRoute::_("index.php?option=com_osproperty&task=agent_register&Itemid=".$itemid),implode("<BR />", $errors));
			}
		
			//}
            $email = OSPHelper::getStringRequest('email','','post');
            $db->setQuery("Select count(id) from #__users where email like '$email'");
            $countemail = $db->loadResult();
            if($countemail > 0)
			{
                OSPHelper::redirect(JRoute::_("index.php?option=com_osproperty&task=agent_register&Itemid=".$itemid),JText::_('OS_EMAIL_IS_ALREADY_EXISTS'));
            }
			else
			{
				$domains = ComponentHelper::getParams('com_users')->get('domains');

				if ($domains)
				{
					$emailDomain = explode('@', $email);
					$emailDomain = $emailDomain[1];
					$emailParts  = array_reverse(explode('.', $emailDomain));
					$emailCount  = count($emailParts);
					$allowed     = true;

					foreach ($domains as $domain)
					{
						$domainParts = array_reverse(explode('.', $domain->name));
						$status      = 0;

						// Don't run if the email has less segments than the rule.
						if ($emailCount < count($domainParts))
						{
							continue;
						}

						foreach ($emailParts as $key => $emailPart)
						{
							if (!isset($domainParts[$key]) || $domainParts[$key] == $emailPart || $domainParts[$key] == '*')
							{
								$status++;
							}
						}

						// All segments match, check whether to allow the domain or not.
						if ($status === $emailCount)
						{
							if ($domain->rule == 0)
							{
								$allowed = false;
							}
							else
							{
								$allowed = true;
							}
						}
					}

					// If domain is not allowed, fail validation. Otherwise continue.
					if (!$allowed)
					{
						//$result['success'] = false;
						//$result['message'] = Text::sprintf('JGLOBAL_EMAIL_DOMAIN_NOT_ALLOWED', $emailDomain);
						OSPHelper::redirect(JRoute::_("index.php?option=com_osproperty&task=agent_register&Itemid=".$itemid),Text::sprintf('JGLOBAL_EMAIL_DOMAIN_NOT_ALLOWED', $emailDomain));
					}
				}
			}

			//clean request
			if($configClass['use_email_as_agent_username'] == 1)
			{
				$username = $email;
			}
			else
			{	
				$username = $jinput->getString('username', $email);
			}
			
			$db->setQuery("Select count(id) from #__users where username like '$username'");
			$countuser = $db->loadResult();
			if($countuser > 0)
			{
				OSPHelper::redirect(JRoute::_("index.php?option=com_osproperty&task=agent_register&Itemid=".$itemid), JText::_('OS_USER_IS_ALREADY_EXISTS'));
			}
			// Prepare the data for the user object.
			$data['username']	= $username;
			$data['email']		= $email;
			$data['email2']		= $email;
            $data['password']	= $jinput->getString('password','');
            $data['password2']	= $jinput->getString('password2','');
            $data['name']		= $jinput->getString('name','');

            $registerReturn		= OSPHelper::registration($data,0);
            $msg = $registerReturn[0]->message;
            $user = $registerReturn[0]->user;
            //login?
            $data['return_url'] = "";
            OSPHelper::login($data);

		}//end check user_id > 0 
		
		// Register new agent account
		$agent_id = OSPHelper::registerNewAgent($user, $jinput->getInt('agent_type',-1));
		
        $emailOpt = array();
		if($configClass['auto_approval_agent_registration'] == 0){
			//send email to admin
			$tmp			= new StdClass();
			$tmp->customer	= $user->name;
			$tmp->agent_id	= $agent_id;
			
			$emailOpt[0]	= $tmps;
			OspropertyEmail::sendAgentApprovalRequest($option,$emailOpt);

			$msg[] = JText::_('OS_THANKYOU_TO_BECOME_AGENT1');
            for($i=0;$i<count($msg);$i++)
			{
                $msg[$i] = "<i class='osicon-ok'></i>&nbsp;".$msg[$i];
            }
            $msg = implode("<BR />",$msg);
			$redirect_url = $configClass['agent_redirect_link'];
			if($redirect_url == "")
			{
				$redirect_url = JUri::root();
			}
			OSPHelper::redirect($redirect_url,$msg);
		}
		else
		{
			$emailOpt['agentid'] = $agent_id;
			$db->setQuery("Select * from #__osrs_agents where id = '$agent_id'");
			$agent = $db->loadObject();
			$emailOpt['agentname'] = $agent->name;
			$emailOpt['agentemail'] = $agent->email;
			OspropertyEmail::sendAgentActiveEmail($option,$emailOpt);
            $msg[] = JText::_('OS_THANKYOU_TO_BECOME_AGENT2');
            for($i=0;$i<count($msg);$i++){
                $msg[$i] = "<i class='osicon-ok'></i>&nbsp;".$msg[$i];
            }
            $msg = implode("<BR />",$msg);
			$redirect_url = $configClass['agent_redirect_link'];
			if($redirect_url == ""){
				$redirect_url = JUri::root();
			}
			OSPHelper::redirect($redirect_url,$msg);
		}
	}
	
	/**
	 * send activation email
	 *
	 * @param unknown_type $user
	 * @param unknown_type $password
	 */
	static function _sendMail(&$user, $password)
	{
		global $mainframe,$jinput;
		$db		=& JFactory::getDBO();
		$name 		= $user->get('name');
		$email 		= $user->get('email');
		$username 	= $user->get('username');

		$usersConfig 	= &JComponentHelper::getParams( 'com_users' );
		$sitename 		= $mainframe->getCfg( 'sitename' );
		$useractivation = $usersConfig->get( 'useractivation' );
		$mailfrom 		= $mainframe->getCfg( 'mailfrom' );
		$fromname 		= $mainframe->getCfg( 'fromname' );
		$siteURL		= JURI::base();

		$subject 	= sprintf ( JText::_( 'OS_ACCOUNT_DETAILS_FOR' ), $name, $sitename);
		$subject 	= html_entity_decode($subject, ENT_QUOTES);

		if ( $useractivation == 1 ){
			$message = sprintf ( JText::_( 'OS_COM_USERS_EMAIL_REGISTERED_WITH_ACTIVATION_BODY' ), $name, $sitename, $siteURL."index.php?option=com_user&task=activate&activation=".$user->get('activation'), $siteURL, $username, $password);
		} else {
			$message = sprintf ( JText::_( 'OS_COM_USERS_EMAIL_REGISTERED_BODY_NOPW' ), $name, $sitename, $siteURL);
		}

		$message = html_entity_decode($message, ENT_QUOTES);

		//get all super administrator
		$query = 'SELECT name, email, sendEmail' .
				' FROM #__users' .
				' WHERE LOWER( usertype ) = "super administrator"';
		$db->setQuery( $query );
		$rows = $db->loadObjectList();

		// Send email to user
		if ( ! $mailfrom  || ! $fromname ) {
			$fromname = $rows[0]->name;
			$mailfrom = $rows[0]->email;
		}
		$mailer = JFactory::getMailer();
		try
		{
			$mailer->sendMail($mailfrom, $fromname, $email, $subject, $message);
		}
		catch (Exception $e)
		{
			JFactory::getApplication()->enqueueMessage($e->getMessage(), 'warning');
		}

		// Send notification to all administrators
		$subject2 = sprintf ( JText::_( 'OS_ACCOUNT_DETAILS_FOR' ), $name, $sitename);
		$subject2 = html_entity_decode($subject2, ENT_QUOTES);

		// get superadministrators id
		foreach ( $rows as $row )
		{
			if ($row->sendEmail)
			{
				$message2 = sprintf ( JText::_( 'OS_COM_USERS_EMAIL_ACTIVATE_WITH_ADMIN_ACTIVATION_BODY' ), $row->name, $sitename, $name, $email, $username);
				$message2 = html_entity_decode($message2, ENT_QUOTES);
				$mailer = JFactory::getMailer();
				try
				{
					$mailer->sendMail($mailfrom, $fromname, $row->email, $subject2, $message2);
				}
				catch (Exception $e)
				{
					JFactory::getApplication()->enqueueMessage($e->getMessage(), 'warning');
				}
			}
		}
	}

    static function testLogin($option){
        $data = array();
        $data['username'] = "agent";
        $data['password'] = "agent";
        $data['return']   = JUri::root();
        OSPHelper::login($data);
    }
}

?>