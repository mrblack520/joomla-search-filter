<?php 
/**
 * OSPROPERTY locator SEARCH
 * 
 * @package    mod_serachlocator
 * @subpackage Modules
 * 
 * 
 */
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

	<style>
#btn_search{
    float: left;
    
    text-align: center;
    cursor: pointer;
    font-weight: 700;
    color: gray;
    background-color: #FFF;
    border-radius: 4px;
    border: 1px solid #53B7D0;
    font-size: 18px;
    line-height: 24px;
    padding: 0px 16px;
    min-height: 40px;
    outline: none;
    transition: 0.3s ease;
}
#__app #__list_container{ 
    z-index: 900;
    position: relative;
    width: 40%;
    margin: 0px 40px;
 
    

}

 #__search_form {
    margin-top: -300px;
    position: sticky;
    top: 70px;
    padding: 2rem 1rem 3rem 1rem;
    z-index: 600;
    height: 300px;
}

#__app #__search_form input {
    box-sizing: border-box;
    padding:  1rem 2.5rem;
    height: 48px;
    font-size: 16px;
    border-radius: 4px;
    width: 100%;
    border: 1px solid #53B7D0;
    outline: none;
}

#__app #__search_form .__icon {
    position: absolute;
    inset: 0;
    margin: auto 1rem;
}

#__app #__search_form #__select_category {
    box-sizing: border-box;
    padding: 0 1rem;
    height: 48px;
    font-size: 16px;
    border-radius: 4px;
    width: 100%;
    border: 1px solid #53B7D0;
    display: flex;
    align-items: center;
    gap: 1rem;
    position: relative;
    cursor: pointer;
}

#__app #__search_form #__select_category .__tag {
    padding: 0.5rem 1rem;
    display: flex;
    align-items: center;
    background:#53b7d0;
    gap: 0.5rem;
    border-radius: 1rem;
}

#__app #__search_form #__select_category .__dropdown {
    position: absolute;
    background: white;
    color:black;
    box-shadow: 0 3px 6px 0 #0002;
    padding: 1rem 0.5rem;
    top: 110%;
    left: 0;
    width: 100%;
    list-style: none;
    visibility: hidden;
    translate: 0 -10px;
    opacity: 0;
}

#__app #__search_form #__select_category:hover .__dropdown {
    visibility: visible;
    translate: 0 0;
    transition: .3s;
    opacity: 1;
}

#__app #__search_form #__select_category .__dropdown li {
    padding: 0.5rem;
    
    border-radius: 4px;
    cursor: pointer;
    transition: .3s;
}

#__app #__search_form #__select_category .__dropdown li:hover {
    background: #DDDDDD;
}

#__app #__search_form #__select_category .__dropdown li.disabled {
    color: lightgray;
}

#__app #__dog_sitters ul {
    list-style: none;
    padding: 0;
}

#__app #__dog_sitters ul .__item {
    display: flex;
    gap: 1rem;
    text-align: left;
    padding: 1rem 0.5rem;
    border-left: 8px solid transparent;
    border-bottom: 1px solid #DDDDDD;
    direction: rtl;
    text-align: right;
    position: relative;
}

#__app #__dog_sitters ul .__item.active {
    border-left: 8px solid #53B7D0;
}

#__app #__dog_sitters .__media {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    overflow: hidden;
}

#__app #__dog_sitters .__media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
}

#__app #__dog_sitters .__content {
    flex: 1;
}

#__app #__dog_sitters .__content .__title {
    font-weight: 500;
    font-size: 18px;
    display: flex;
    align-items: center;
    gap: 5px;
    cursor: pointer;
    position: relative;
    width: fit-content;
}

#__app #__dog_sitters .__content .__rating {
    display: flex;
    gap: 0.5rem;
}

#__app #__dog_sitters .__content .__tag span {
    line-height: 1.43;
    cursor: pointer;
    box-sizing: border-box;
    margin: 0px;
    min-width: 0px;
    display: inline-block;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    color: rgb(154, 154, 154);
    font-size: 14px;
    border: 1px solid #DDDDDD;
    border-radius: 4px;
    height: 24px;
    padding-left: 8px;
    padding-right: 8px;
}

#__app #__dog_sitters .__content .__tag span a {
    text-decoration: none;
    color: inherit;
}

#__app #__dog_sitters .__content .__comment {
    font-size: 16px;
    line-height: 1.43;
    box-sizing: border-box;
    margin: 0px;
    min-width: 0px;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    flex: 1 1 0%;
    color: #9A9A9A;
}

#__app #__dog_sitters .__item a.__link::after {
    position: absolute;
    content: "";
    inset: 0;
}

#__app #__dog_sitter__category {
    display: flex;
    gap: 0.5rem;
}

#__app #__dog_sitter__category button {
    text-align: center;
    cursor: pointer;
    font-weight: 700;
    color: gray;
    background-color: #FFF;
    border-radius: 4px;
    border: 1px solid #53B7D0;
    font-size: 18px;
    line-height: 24px;
    padding: 0px 16px;
    min-height: 40px;
    outline: none;
    transition: 0.3s ease;
}

#__app #__dog_sitter__category button:hover {
    scale: 0.9;
}

#__app #__dog_sitter__category button.active {
    color: #FFF;
    background: #53B7D0;
}

/* Pagination */
#__pagination_container {
    margin: 2rem auto 0 auto;
    width: fit-content;
    direction: ltr;
}

#__pagination_container button {
    line-height: 1.43;
    margin: 0px;
    min-width: 0px;
    border: none;
    width: 48px;
    height: 48px;
    box-sizing: border-box;
    text-align: center;
    font-size: 1rem;
    background: white;
    border: 1px solid #dddddd;
}

#__pagination_container button:first-child {
    border-radius: 50% 0 0 50%;
}

#__pagination_container button:last-child {
    border-radius: 0 50% 50% 0;
}

#__pagination_container button.active {
    background-color: #49b3cd;
    color: white;
    border-inline-color: transparent;
}

/* Pagination */

/* Responsive Styles for Mobile Devices */
@media screen and (min-width: 770px) and (max-width: 1100px) {
    #__search_form {
    margin-top: 8px;
    position: sticky;
    top: 70px;
    padding: 2rem 1rem 3rem 1rem;
    z-index: 600;
    height: 157px;
}
#__app #__list_container {
       
       width: 100%;
       margin: 0;
   }
}
@media (max-width: 768px) {
    #btn_search {
      
        float: none;
    }

    #__app #__list_container {
       
        width: 100%;
        margin: 0;
    }

    #__search_form {
        
        margin-top: 0;
        position: static;
        top: auto;
        height: auto;
    }

    #__app #__search_form input {
       
        padding: 1rem 1rem; 
    }
}

</style>
<div id="__app">
			
			<div id="__list_container" class="nma">
				<div id="__search_form">
					<div class="position-relative mb-2">
						<input type="text" id="__search_main" placeholder="Search dog sitters">
						<svg class="__icon" width="18" height="18" viewbox="0 0 24 24" fill-rule="evenodd" clip-rule="evenodd">
							<path d="M15.853 16.56c-1.683 1.517-3.911 2.44-6.353 2.44-5.243 0-9.5-4.257-9.5-9.5s4.257-9.5 9.5-9.5 9.5 4.257 9.5 9.5c0 2.442-.923 4.67-2.44 6.353l7.44 7.44-.707.707-7.44-7.44zm-6.353-15.56c4.691 0 8.5 3.809 8.5 8.5s-3.809 8.5-8.5 8.5-8.5-3.809-8.5-8.5 3.809-8.5 8.5-8.5z" />
						</svg>
					</div>
                   
					<div id="__select_category" class="mb-2">
						<span id="__placeholder">Select a category</span>
						<ul id="__categories" class="__dropdown z-1">
							<?php
							$categories = $db->setQuery("SELECT id, category_name as name from #__osrs_categories")->loadObjectList();
							foreach ($categories as $category) {
								echo "<li id='$category->id'>$category->name</li>";
							}
							?>
						</ul>
					</div>
                    

                        <button id="btn_search">Search</button>
                    
					<div id="__dog_sitter__category">
						<?php
						$types = $db->setQuery("SELECT * from #__osrs_types")->loadObjectList();
						foreach ($types as $type) {
							echo "<button id='$type->id'>$type->type_name</button>";
						}
						?>
					</div>
                   
                    <div>
                        <input type="hidden" name="kutta" value="true" id="hidden_value">
                    </div>
				
			
	        </div>


</div>				
						
						
					

<script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCdnc_ajbCbaokL69YrB11WT0lvhFSWBFI&token=93297&callback=myMap&libraries=places,geometry"></script>
<script>
    
let selectedPlace = null;

input = document.querySelector("#__search_main");
function myMap() {
  const auto_complete = new google.maps.places.Autocomplete(input);

  auto_complete.addListener('place_changed', () => {
    const place = auto_complete.getPlace();
    if (place.geometry && place.geometry.location) {
      selectedPlace = place;
    } else {
      selectedPlace = null;
    }
  });

  const searchButton = document.querySelector("#btn_search");
  searchButton.addEventListener("click", () => {
    const selectedDogSitterCategory = getSelectedDogSitterCategory();
    const hiddenvalueid = hiddenid();

    if (selectedPlace) {
      const lat = selectedPlace.geometry.location.lat();
      const lng = selectedPlace.geometry.location.lng();
      const categoriesString = getSelectedCategories(); 
      const value = document.getElementById("__search_main").value;
      const coordinates = `{"lat":${lat},"lng":${lng}}`;
      const redirectToURL = `https://www.petzelsitter.com/index.php/property/locator-search?coords=${encodeURIComponent(coordinates)}&categories=${categoriesString}&dog_sitter__category=${selectedDogSitterCategory}&kutta&search_main=${value}`;
      window.location.href = redirectToURL;
    }else if (selectedDogSitterCategory){
    

        const redirectToURL = `https://www.petzelsitter.com/index.php/property/locator-search?dog_sitter__category=${selectedDogSitterCategory}&kutta`;
      window.location.href = redirectToURL;
    }
 else if(selectedDogSitterCategory && categoriesString ) {
    const redirectToURL = `https://www.petzelsitter.com/index.php/property/locator-search?categories=${categoriesString}&dog_sitter__category=${selectedDogSitterCategory}&kutta&search_main=${value}`;
      window.location.href = redirectToURL;
}else {
     
      const categoriesString = getSelectedCategories(); 

      const redirectToURL = `https://www.petzelsitter.com/index.php/property/locator-search?categories=${encodeURIComponent(categoriesString)}&kutta`;
      window.location.href = redirectToURL;
    }
  });
}
</script>
<script>

    
  function getSelectedCategories() {
    const selectedCategories = [];
    jQuery('#__select_category .__tag').each(function () {
      selectedCategories.push(jQuery(this).attr('id'));
    });
    return selectedCategories.join(',');
  }

 
			jQuery('#__select_category').on('click', '.__remove', function() {
				const category = jQuery(this).parent().text().trim();
				const categoryId = jQuery(this).parent().attr('id');

				jQuery(this).parent().remove();
				jQuery('#__categories li').each(function() {
					if (jQuery(this).text() === category) {
						jQuery(this).removeClass('disabled');
						return false;
					}
				});
				if (jQuery('#__select_category').children('span:not(#__placeholder)').length === 0)
					jQuery('#__placeholder').show()

				categories = categories.filter(category => category != categoryId)
				
			});



			jQuery('#__select_category #__categories li').click(function() {

				if (!jQuery(this).hasClass('disabled')) {
					const categoryId = jQuery(this).attr('id');
					const category = jQuery(this).text();
					jQuery('#__select_category')
						.append(`<span class="__tag" id="${categoryId}">${jQuery(this).text()}<span class="__remove" style="cursor: pointer;"><svg height="1em" viewBox="0 0 512 512"><path fill="#2c89a0" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z"/></svg></span></span>`)
						.find('#__placeholder').hide()
					jQuery(this).addClass('disabled');

				

				}
			})
		</script>
	<!-- Category type search -->
  <script>
   
			
			jQuery('#__dog_sitter__category').on('click', 'button', function() {
             const isActive = jQuery(this).hasClass('active');
				jQuery('#__dog_sitter__category button').removeClass('active');
				jQuery(this).addClass('active');
                if (!isActive) {
        jQuery(this).addClass('active');
    }
			});
            function getSelectedDogSitterCategory() {
    const selectedDogSitterCategory = jQuery('#__dog_sitter__category button.active').attr('id');
    return selectedDogSitterCategory || '';
  }

  function hiddenid(){
    const hiddenid=document.querySelector('#hidden_value').value
    return hiddenid;

  }
		</script>


