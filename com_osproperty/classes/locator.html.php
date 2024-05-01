<?php



/*------------------------------------------------------------------------



# locator.html.php - Ossolution Property



# ------------------------------------------------------------------------



# author    Dang Thuc Dam



# copyright Copyright (C) 2023 joomdonation.com. All Rights Reserved.



# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL



# Websites: http://www.joomdonation.com



# Technical Support:  Forum - http://www.joomdonation.com/forum.html



*/







// No direct access.



defined('_JEXEC') or die;







class HTML_OspropertyLocator

{

    /**



     * Locator Search Html



     *



     * @param unknown_type $option



     * @param unknown_type $agent



     */



    public static function locatorSearchHtml($option, $rows, $lists, $locator_type, $search_lat, $search_long, $style)

    {

        $host = JUri::base();

        $db = JFactory::getDbo();

        HelperOspropertyGoogleMap::loadGoogleScript('libraries=places,geometry');

        JFactory::getDocument()->addStyleSheet('https://fonts.googleapis.com/css2?family=Poppins:wght@200;400;500;600&display=swap');



		//print_r($rows);exit;

?>





		<!-- CSS -->

		<style>

			/* Hide google maps footer */

			.gm-style-cc {

				display: none;

			}

			/* Hide google maps footer */



			#__app {

				direction: ltr;

				display: grid;

				grid-template-columns: 2fr 1fr;

				font-family: 'poppins', sans-serif;

			}



			#__app #__map_container {

				height: calc(100vh - 70px);

				position: sticky;

				background-color: #F1F3F4;

				top: 70px;

				z-index: 999;



			}



			#__app #__map_container #__not_found {

				position: absolute;

				inset: 0 0 auto 0;

				margin: 10px auto;

				background: white;

				padding: 0.5rem 1rem;

				border-radius: 4px;

				max-width: fit-content;

				display: none;

			}



			#__app #__map_container #__map {

				height: 100%;

			}



			#__app #__search_form {

				position: sticky;

				top: 70px;

				padding: 1rem .5rem 0 .5rem;

				background: #FFF;

				z-index: 999;

			}



			#__app #__search_form input {

				box-sizing: border-box;

				padding: 0 2.5rem;

				height: 48px;

				line-height: 100%;

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

				line-height: 100%;

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

				background: #53B7D0;

				display: flex;

				align-items: center;

				gap: 0.5rem;

				border-radius: 1rem;

				color: #FFF;

			}



			#__app #__search_form #__select_category .__dropdown {

				position: absolute;

				background: #FFF;

				box-shadow: 0 3px 6px 0 #0002;

				padding: 1rem 0.5rem;

				top: 110%;

				left: 0;

				width: 100%;

				margin: 0;

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



			#__app #__search_form #__count {

				text-align: center;

				padding: 1rem 0;

				margin: 0;

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

			

			#__app #__dog_sitters ul .__item.active{

				border-left: 8px solid #53B7D0;

			}



			/* #__app #__dog_sitters ul .__item:hover {

			} */



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

				/* z-index: 1; */

			}



			#__app #__dog_sitters .__content .__title:hover {

				/* text-decoration: 1px solid black underline; */

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



			/* responsive layout */

			@media(max-width: 992px) {

				#__app {

					grid-template-columns: repeat(2, 1fr);

				}

			}



			@media(max-width: 768px) {

				#__app {

					grid-template-columns: 1fr;

				}



				#__app #__map_container {

					position: static;

				}



				#__app #__search_form {

					position: static;

				}

			}



			/* responsive layout */
			/* google maps override*/
			.gm-style-iw.gm-style-iw-c{
				min-width: auto !important;
				height: auto !important;
				border: none !important;
			}
			/* google maps override*/

		</style>

		<!-- CSS -->



		<!-- HTML -->



		<div id="__app">

			<div id="__map_container">

				<div id="__map"></div>

				<div id="__not_found">No dog sitters found</div>

			</div>

			<div id="__list_container">

				<div id="__search_form">

					<div class="position-relative mb-2">

						<input type="text" id="__search_location" placeholder="Search dog sitters">

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

					<div id="__dog_sitter__category">

						<?php

                        $types = $db->setQuery("SELECT * from #__osrs_types")->loadObjectList();

        foreach ($types as $type) {

            echo "<button id='$type->id'>$type->type_name</button>";

        }

        ?>

					</div>

					<p id="__count">

						dog sitters (<span><?php echo count($rows) ?></span>)

					</p>

				</div>

				<div id="__dog_sitters">

					<ul>

						<?php foreach ($rows as $row) : ?>

							<li class="__item" data-city="<?php echo $row->city_name?>" data-id="<?php echo $row->id ?>" data-category="<?php echo $row->category_id ?>" data-type="<?php echo $row->pro_type ?>">

								<div class="__media">

									<?php

                    			$db->setQuery("SELECT * FROM #__osrs_photos WHERE pro_id = '$row->id' ORDER BY ordering LIMIT 1");

						    $photo = $db->loadObjectList();



						    if (count($photo) > 0) {

						        $photo = $photo[0];

						        OSPHelper::showPropertyPhoto($photo->image, 'thumb', $row->id, '', '', '', 0);

						    } else {

						        echo '<img src="' . JURI::root() . 'media/com_osproperty/assets/images/nopropertyphoto.png" width="90" />';

						    }

						    ?>



								</div>

								<div class="__content">

									<div class="__title">

										<span> <?php echo $row->pro_name ?></span>

										<!-- ·<span style="font-weight: normal; font-size:15px"><?php echo number_format(floatval($row->price), 2, ',') ?></span> -->

									</div>

									<div class="__rating mb-2">

										<?php

						        $points = 0;

						    $votes = $row->number_votes;

						    $evaluation_score = 0;

						    if ($row->number_votes > 0) {

						        $points = round($row->total_points / $row->number_votes);

						        $evaluation_score = number_format($row->total_points / $row->number_votes, 1);

						    } ?>



										<div class="__stars">

											<?php

						        for ($point = 0; $point < $points; $point++) {

						            echo '<svg width="1em" height="1em" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" color="#F9B342" font-size="1em">

													<defs>

														<path d="M1.456 5.051H5.07a.453.453 0 00.43-.318l1.118-3.47c.435-1.35 2.331-1.35 2.766 0l1.117 3.47c.06.19.235.318.43.318h3.615c1.408 0 1.99 1.812.856 2.645l-2.924 2.145a.466.466 0 00-.166.52l1.117 3.471c.432 1.346-1.1 2.47-2.24 1.633L8.265 13.32a.445.445 0 00-.528 0l-2.925 2.145c-1.14.836-2.672-.287-2.239-1.633l1.117-3.471a.468.468 0 00-.166-.52L.6 7.696c-1.135-.833-.553-2.645.856-2.645z" id="star-on_svg__a"></path>

													</defs>

													<g fill="none" fill-rule="evenodd">

														<mask id="star-on_svg__b" fill="#fff">

															<use xlink:href="#star-on_svg__a"></use>

														</mask>

														<g mask="url(#star-on_svg__b)" fill="#F9B342" opacity="0.9">

															<path d="M0 0h16v15.964H0z"></path>

														</g>

													</g>

												</svg>';

						        }



						        for ($point = 0; $point < 5 - $points; $point++) {

						            echo '<svg width="1em" height="1em" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" color="#F9B342" font-size="1em">

													<defs>

														<path d="M1.456 5.051H5.07a.453.453 0 00.43-.318l1.118-3.47c.435-1.35 2.331-1.35 2.766 0l1.117 3.47c.06.19.235.318.43.318h3.615c1.408 0 1.99 1.812.856 2.645l-2.924 2.145a.466.466 0 00-.166.52l1.117 3.471c.432 1.346-1.1 2.47-2.24 1.633L8.265 13.32a.445.445 0 00-.528 0l-2.925 2.145c-1.14.836-2.672-.287-2.239-1.633l1.117-3.471a.468.468 0 00-.166-.52L.6 7.696c-1.135-.833-.553-2.645.856-2.645z" id="star-on_svg__a"></path>

													</defs>

													<g fill="none" fill-rule="evenodd">

														<mask id="star-on_svg__b" fill="#fff">

															<use xlink:href="#star-on_svg__a"></use>

														</mask>

														<g mask="url(#star-on_svg__b)" fill="#DDDDDD" opacity="0.9">

															<path d="M0 0h16v15.964H0z"></path>

														</g>

													</g>

												</svg>';

						        }

						    ?>



										</div>

										<div class="__points">

											<span style="color: #000;"><?php echo $evaluation_score ?></span>

											(<?php echo $votes ?>)

										</div>

									</div>

									<div class="__tag">

										<span><?php echo $row->category_name ?></span>

										<span>

											<?php echo OSPHelper::generateAddress($row) ?>

											<svg width="1em" height="1em" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" color="#9A9A9A" font-size="1em">

												<defs>

													<path d="M13 6A5 5 0 003 6c0 2.418 1.655 5.358 5 8.788C11.345 11.36 13 8.42 13 6zm-4.646 9.854a.5.5 0 01-.708 0C3.895 12.098 2 8.825 2 6a6 6 0 1112 0c0 2.829-1.895 6.102-5.646 9.854zM8 9a3 3 0 110-6 3 3 0 010 6zm0-1a2 2 0 100-4 2 2 0 000 4z" id="marker_svg__a"></path>

												</defs>

												<g fill="none" fill-rule="evenodd">

													<mask id="marker_svg__b" fill="#fff">

														<use xlink:href="#marker_svg__a"></use>

													</mask>

													<use fill="#9A9A9A" fill-rule="nonzero" xlink:href="#marker_svg__a"></use>

													<g mask="url(#marker_svg__b)" fill="#9A9A9A" opacity="0.9">

														<path d="M0 0h16v15.964H0z"></path>

													</g>

												</g>

											</svg>

										</span>

									</div>

									<div class="__comment">

										<?php

						                $db->setQuery("Select content, MAX(rate1 + rate2 + rate3 + rate4 + rate) from #__osrs_comments where pro_id = '$row->id' AND published = 1");

						    $comment = $db->loadResult();

						    echo $comment ? "“{$comment}”" : '';

						    ?>

									</div>

								</div>

								<?php echo "<a class='__link' href=" . Jroute::_('prop-listing/' . $row->pro_alias) . " target='_blank'></a>" ?>

							</li>

						<?php endforeach ?>

					</ul>

					<div id="__pagination_container"></div>

				</div>

			</div>

		</div>



		<!-- HTML -->

		<!-- Container fluid -->

		<script>

			jQuery(document).ready(() => {

				jQuery('.t4-section-inner.container')
				
				.removeClass('container')
				
				.addClass('container-fluid')
				
				jQuery('.t4-col.col-12.col-xl').css('padding',0)
			})

		</script>





		<!-- Search Form -->

		<script>

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

				searchDogSittersByCategory()

			});







			jQuery('#__select_category #__categories li').click(function() {



				if (!jQuery(this).hasClass('disabled')) {

					const categoryId = jQuery(this).attr('id');

					const category = jQuery(this).text();

					jQuery('#__select_category')

						.append(`<span class="__tag" id="${categoryId}">${jQuery(this).text()}<span class="__remove" style="cursor: pointer;"><svg height="1em" viewBox="0 0 512 512"><path fill="#2c89a0" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z"/></svg></span></span>`)

						.find('#__placeholder').hide()

					jQuery(this).addClass('disabled');



					searchDogSittersByCategory(categoryId)



				}

			})

		</script>



		<!-- Category type search -->

		<script>

			function searchByDogsittersType(id) {

				let searchResults = items

				if (city_search) {
					searchResults = items.filter(item => city_search.match(new RegExp(item.dataset.city,'i')))
				}
				if (categories.length !== 0) {
					searchResults = searchResults.filter(dogSitter => categories.includes(Number(dogSitter.getAttribute('data-category'))))
				}
				// const filteredItems = (locator_search == true) ? searchResults.filter(dogSitter => dogSitter.getAttribute('data-type') === id) : items.filter(dogSitter => dogSitter.getAttribute('data-type') === id)
				
				if (id != type) {
					searchResults = searchResults.filter(dogSitter => dogSitter.getAttribute('data-type') === id);
					type = id
				}else{
					type = null
				}

				// paginate(1, filteredItems)
				paginate(1, searchResults)



				for (const marker of markers) {

					// marker.setMap(null)

				}

				for (const marker of markers) {

					if (marker.type == Number(id)) {

						// marker.setMap(map)

					}

				}



			}



			jQuery('#__dog_sitter__category').on('click', 'button', function() {

				if (jQuery(this).hasClass('active')) {
					jQuery(this).removeClass('active');
				}else{
					jQuery('#__dog_sitter__category button').removeClass('active');
					jQuery(this).addClass('active');

				}
				searchByDogsittersType(jQuery(this).attr('id'))

				

			});

		</script>



		<!-- Padination -->

		<script>

			let paginationContainer = document.querySelector('#__pagination_container');

			let container = document.querySelector('#__dog_sitters ul');

			let items = [...document.querySelectorAll('#__dog_sitters .__item')];

			let currentPage = 1;

			let itemsPerPage = 20;

			let totalItems = items.length;

			let totalPages = Math.ceil(totalItems / itemsPerPage);



			function paginate(page, src = items) {

				var offset = (page - 1) * itemsPerPage;

				var limit = offset + itemsPerPage;

				var slice = src.slice(offset, limit);



				paginate.src = src



				totalItems = src.length;

				totalPages = Math.ceil(totalItems / itemsPerPage);



				container.innerHTML = null;



				slice.forEach(function(ele) {

					container.appendChild(ele);

				});



				currentPage = page;





				if (totalPages > 1) {

					generatePaginationLinks()

				} else {

					removePaginationLinks()

				}



				jQuery('#__count span').html(paginate.src.length);

				jQuery('#__not_found').toggle(paginate.src.length === 0);

			}



			function next() {

				if (currentPage < totalPages) {

					paginate(currentPage + 1, paginate.src);

				}

			}



			function prev() {

				if (currentPage > 1) {

					paginate(currentPage - 1, paginate.src);

				}

			}



			function gotoPage(page) {

				paginate(page, paginate.src);

			}



			function generatePaginationLinks() {



				let range = 3;

				let start = Math.max(1, currentPage - range);

				// let end = Math.min(totalPages, currentPage + range);

				let end = Math.min(totalPages, start + range + 1);

				let html = "";

				let prev_btn_icon = '<svg width="1em" height="1em" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" color="#010101" font-size="12"><defs><path d="M.167 7.627l7.05-7.05a.5.5 0 11.708.707L1.708 7.5H15.5a.5.5 0 110 1H1.707l6.218 6.218a.5.5 0 01-.707.707L.167 8.374A.508.508 0 010 8l.167-.373z" id="prev_svg__a"></path></defs><use fill="#010101" fill-rule="nonzero" xlink:href="#prev_svg__a"></use></svg>'

				let next_btn_icon = '<svg width="1em" height="1em" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" color="#010101" font-size="12"><defs><path d="M.167 7.627l7.05-7.05a.5.5 0 11.708.707L1.708 7.5H15.5a.5.5 0 110 1H1.707l6.218 6.218a.5.5 0 01-.707.707L.167 8.374A.508.508 0 010 8l.167-.373z" id="next_svg__a"></path></defs><use fill="#010101" fill-rule="nonzero" transform="rotate(-180 8 8)" xlink:href="#next_svg__a"></use></svg>'





				html += currentPage > 1 ? `<button type='button' onclick="prev()">${prev_btn_icon}</button>` : `<button type='button' onclick="prev()" disabled>${prev_btn_icon}</button>`;



				for (let i = start; i <= end; i++) {

					html += i == currentPage ? `<button class='active' onclick="gotoPage(${i})">${i}</button>` : `<button onclick="gotoPage(${i})">${i}</button>`

				}



				html += currentPage < totalPages ? `<button type='button' onclick="next()">${next_btn_icon}</button>` : `<button type='button' id='next_btn' onclick="next()" disabled>${next_btn_icon}</button>`;



				paginationContainer.innerHTML = totalPages !== 0 ? html : null;

			}



			function removePaginationLinks() {

				paginationContainer.innerHTML = null

			}

		</script>



		<!-- Google Maps -->

		<script>

			let currentInfoWindow = null;

			let currentMarker = null;

			let currentDogsitter = null;

			let map = null

			let markers = []

			let categories = []

			let type = null

			let searchResults = []

			let locator_search = false

			let city_search = false




			async function fetchAllCoordinates() {

				const respone = await fetch('<?php echo "$host/components/com_osproperty/api/map.php?coordinates=all" ?>')

				const coordianates = await respone.json()

				console.log(coordianates);

				return coordianates

			}



			function resetMarkers() {



				for (const marker of markers) {

					marker.setMap(map)

				}



			}



			function searchDogSittersByCategory(categoryId) {
				let searchResults = items
				type = null // reseting search type

				// if (categoryId)
				// 	categories.push(+categoryId);


				if (categoryId) categories.push(+categoryId);
							
							
				if (city_search) {
					searchResults = searchResults.filter(item => city_search.match(new RegExp(item.dataset.city, 'i')))
				}
				
				if (categories.length !== 0) {
					searchResults = searchResults.filter(dogSitter => categories.includes(Number(dogSitter.getAttribute('data-category'))))
				}

				
				
				
				
				paginate(1,searchResults)



				// if (locator_search === true) {

				// 	if (categories.length > 0) {

				// 		const filteredItems = searchResults.filter(dogSitter => categories.includes(Number(dogSitter.getAttribute('data-category'))))

				// 		paginate(1, filteredItems)

				// 	} else {

				// 		paginate(1, searchResults)

				// 	}

				// } else {

				// 	if (categories.length > 0) {

				// 		const filteredItems = items.filter(dogSitter => categories.includes(Number(dogSitter.getAttribute('data-category'))))

				// 		paginate(1, filteredItems)

				// 	} else {

				// 		paginate(1, items)

				// 	}

				// }



				// filterMarkers()

				jQuery('#__dog_sitter__category button').removeClass('active');



			}



			function placeAllMarkers(map, coords, markers = []) {

				for (const coord of coords) {

					const marker = new google.maps.Marker({

						position: coord,

						map: map,

						title: coord.name,

						id: coord.id,

						category_id: coord.category_id,

						category: coord.category,

						type: coord.type,

						desc:coord.short_desc,

						price:coord.mprice,

						icon: {

							url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 59.49 82.76"><path fill="#54b8d1" d="M59.49 29.75c0 16.43-29.75 53.02-29.75 53.02S0 46.18 0 29.75s13.32-29.75 29.75-29.75 29.74 13.32 29.74 29.75z"/><circle fill="#026b82" cx="29.75" cy="26.8" r="13.68"/></svg>'),
							scaledSize: new google.maps.Size(35, 35),

						},

					});





					markers.push(marker)

				}



			}



			function focusMarker(map, markers, markerId) {

				const marker = markers.find(marker => marker.id === markerId);

				if (marker)

					google.maps.event.trigger(marker, 'click');

			}



			function createCircle(map, center, radius) {

				if (createCircle.circle)

					createCircle.circle.setMap(null)

				createCircle.circle = new google.maps.Circle({

					strokeColor: '#53B7D0',

					strokeOpacity: 0.5,

					strokeWeight: 2,

					fillColor: '#53B7D0',

					fillOpacity: 0.35,

					map: map,

					center: center,

					radius: radius,

				});

			}



			function removeAllCircle(map) {

				createCircle.circle.setMap(null)

			}



			function searchDogSittersByCity(city) {
				city_search = city
				searchResults = []
				searchResults = items.filter(item => city.match(new RegExp(item.dataset.city,'i')))
				if (categories.length !== 0) {
					searchResults = searchResults.filter(dogSitter => categories.includes(Number(dogSitter.getAttribute('data-category'))))
				}
				paginate(1,searchResults)
				jQuery('#__dog_sitter__category button').removeClass('active');

			}



			function searchDogSitters(map, coord, markers = [], json=false) {



				const coordinate = json?{

					lat: coord.lat,

					lng: coord.lng

				} : {

					lat: coord.lat(),

					lng: coord.lng()

				}



				if (markers.length > 0) {

					searchResults = []

					// createCircle(map, coord, 500)

					map.setCenter(coord)

					// for (const marker of markers) {

					// 	if (google.maps.geometry.spherical.computeDistanceBetween(coordinate, marker.getPosition()) <= 500) {

					// 		searchResults.push(items.find(item => Number(item.getAttribute('data-id')) === marker.id))

					// 	}

					// }



					// if (categories.length > 0) {

					// 	searchResults = searchResults.filter(dogSitter => categories.includes(+dogSitter.getAttribute('data-category')))

					// }



					//paginate(1, searchResults)

					//filterMarkers()

					//locator_search = true

					//jQuery('#__dog_sitter__category button').removeClass('active');

				}



			}



			function filterMarkers() {



				for (const marker of markers) {

					marker.setMap(map)

				}

				if (categories.length > 0) {

					for (const marker of markers) {

						if (!categories.includes(marker.category_id)) {

							marker.setMap(null)

						}

					}

				}

			}



			jQuery(document).ready(async () => {



				const coordinates = await fetchAllCoordinates()



				if (coordinates.length === 0) {

					alert("No dog sitters data found try to add first")

					return

				}



				const styledMapType = new google.maps.StyledMapType([{

					featureType: 'poi',

					elementType: 'labels',

					stylers: [{

						visibility: 'off'

					}],

				}, ]);



				const options = {

					center: {

						lat: 32.08678,

						lng: 34.78961

					},

					mapTypeControlOptions: {

						mapTypeIds: ['roadmap', 'styled_map'],

					},

					zoom: 10,

					streetViewControl: false,

					mapTypeControl: false,

				}

				const map_holder = document.getElementById('__map')

				map = new google.maps.Map(map_holder, options)

				map.mapTypes.set('styled_map', styledMapType);

				map.setMapTypeId('styled_map');

				placeAllMarkers(map, coordinates, markers)





			// Search & location
				
			const searchInput = document.getElementById('__search_location');

			const autocomplete = new google.maps.places.Autocomplete(searchInput);



			// adding autocomplete input change listener 

			test = autocomplete.addListener('place_changed', async function() {

    		const currentLocation = this.getPlace().geometry.location;

    		searchDogSitters(map, currentLocation, markers);

			searchDogSittersByCity(searchInput.value)



			

			// TODO
			const place = this.getPlace();
			
			if (place && place.address_components) {
        		let city = '';
				
        		// Iterate through address components to find the city
        		for (let i = 0; i < place.address_components.length; i++) {
        		    const component = place.address_components[i];
        		    // Check if the type is 'locality' (which represents the city)
        		    if (component.types.includes('locality')) {
						city = component.long_name;
        		        break; // Exit loop once city is found
        		    }
        		}
				
        		// Use the 'city' variable as the city name
        		console.log('City:', city);
        		// You can further use the 'city' variable as needed in your code
    		}
			
			// TODO

			

			



			

});



<?php

if (isset($_GET['kutta'])) {
	if (isset($_GET['search_main'])) {
        $search_main_value = $_GET['search_main'];
        echo "jQuery('#__search_location').val('{$search_main_value}');";
		echo "const city1 = '{$search_main_value}';";

    }
    $coords = json_encode($_GET['coords']);

    echo "jQuery(document).ready(() => {";

    if (isset($_GET['dog_sitter__category'])) {
        $dog_sitter__category = $_GET['dog_sitter__category'];

        echo "setTimeout(() => {
            jQuery('#__dog_sitter__category [id={$dog_sitter__category}]').click()
        }, 1000);";
    }

    if (isset($_GET['categories'])) {
        $categoryArray = explode(',', $_GET['categories']);
        $hasCategories = false;

        foreach ($categoryArray as $category) {
            if (is_numeric($category)) {
                echo "jQuery('#__categories li[id={$category}]').click();";
                $hasCategories = true;
            }
        }

		if ($hasCategories) {
			echo "const coords_map = JSON.parse($coords);";

            echo "searchDogSitters(map, coords_map, markers, true);";
			echo "searchDogSittersByCity(city1)";
			
        } else {
			echo "const coords_map = JSON.parse($coords);";

            echo "searchDogSitters(map, coords_map, markers, true);";
			echo "searchDogSittersByCity(city1)";
        }
		
		
		
    }

    echo "});"; 



	
   

	

    
}



?>


			

				

			

				// checking for empty input value

				searchInput.addEventListener('input', function() {

					let searchResults = items

					if (this.value === ""){
						if (categories.length !== 0) {
							searchResults = searchResults.filter(dogSitter => categories.includes(Number(dogSitter.getAttribute('data-category'))))
						}
						paginate(1, searchResults)
						locator_search = false
						city_search = false
						jQuery('#__dog_sitter__category button').removeClass('active');
					}
					if (this.value === "" && locator_search) {

						// if (categories.length > 0) {

						// 	const filteredItems = searchResults.filter(dogSitter => categories.includes(+dogSitter.getAttribute('data-category')))

						// 	paginate(1, filteredItems)

						// } else {

						// 	paginate(1)

						// }

						// removeAllCircle()

						// jQuery('#__not_found').hide();

						// jQuery('#__dog_sitter__category button').removeClass('active');

						// map.setCenter(markers[0].getPosition())

						// filterMarkers()

						locator_search = false

					}

				})



				// jQuery('.__title').click(function() {

				// 	const markerId = jQuery(this).closest('.__item').data('id')

				// 	focusMarker(map, markers, markerId)

				// });



				// bouncing effect

				// jQuery('.__item').hover(function() {

				// 	const markerId = jQuery(this).closest('.__item').data('id');

				// 	const marker = markers.find(marker => marker.id === markerId);

				// 	marker ? marker.setAnimation(google.maps.Animation.BOUNCE) : null;

				// }, function() {

				// 	const markerId = jQuery(this).closest('.__item').data('id');

				// 	const marker = markers.find(marker => marker.id === markerId);

				// 	marker ? marker.setAnimation(null) : null;

				// });

				

				jQuery('.__item').mouseenter(function() {

					const markerId = jQuery(this).closest('.__item').data('id');

					const marker = markers.find(marker => marker.id === markerId);

					marker?.setAnimation(google.maps.Animation.BOUNCE);
					marker?.setIcon({
    						url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 59.49 82.76"><path fill="#54b8d1" stroke-width="3" stroke="#026b82" d="M59.49 29.75c0 16.43-29.75 53.02-29.75 53.02S0 46.18 0 29.75s13.32-29.75 29.75-29.75 29.74 13.32 29.74 29.75z"/><circle fill="#026b82" cx="29.75" cy="26.8" r="13.68"/></svg>'),
							scaledSize: new google.maps.Size(35, 35),
					})
					
					currentMarker?.setAnimation(null)
					currentMarker?.setIcon({
    						url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 59.49 82.76"><path fill="#54b8d1" d="M59.49 29.75c0 16.43-29.75 53.02-29.75 53.02S0 46.18 0 29.75s13.32-29.75 29.75-29.75 29.74 13.32 29.74 29.75z"/><circle fill="#026b82" cx="29.75" cy="26.8" r="13.68"/></svg>'),
							scaledSize: new google.maps.Size(35, 35),
					})

					currentMarker = marker

					jQuery(this).addClass('active')

					jQuery(currentDogsitter).removeClass('active')

					currentDogsitter = this

				});



				// Adding listeners to markers

				for (const marker of markers) {



					const image = jQuery(`.__item[data-id="${marker.id}"] img`)[0]?.src

					const stars = jQuery(`.__item[data-id="${marker.id}"] .__rating .__stars`).html()
					const points = jQuery(`.__item[data-id="${marker.id}"] .__rating .__points`).html()
					const link =  document.querySelector(`[data-id='${marker.id}'] .__link`).href

					const html = `<div class='d-flex align-items-center' style='margin:0 0 0 12px; gap:0.2rem;'>

									<div class="d-flex flex-column">
										
										<div class="d-flex align-items-center justify-content-center" style="gap:0.3rem">
										<span>${marker.desc}</span> | <a href='${link}' target="_blank" class="text-muted m-0 font-weight-bold">${marker.title}</a>
										</div>
										<div>₪${marker.price.replace(/\./g,',')}&nbsp;&nbsp;&nbsp;${marker.category}</div>
										<div class="d-flex g-1 align-items-center justify-content-end">
											<div class="ml-1">${points}</div>
											<div>${stars}</div>
										</div>


									</div>

									<div class="p-1">

										<a href='${link}' target="_blank">
											<img class="rounded-circle" src=${image} style="width:50px; height:50px; object-fit:cover">
										</a>

									</div>

  								  </div>`

					const infoWindow = new google.maps.InfoWindow({

						content: html,

					});

					marker.addListener('click', () => {

						if (currentInfoWindow) {

							currentInfoWindow.close();

						}

						infoWindow.open(map, marker);

						map.panTo(marker.getPosition(), 500);

						currentInfoWindow = infoWindow;

					})



				}





				// paginate

				paginate(1)



			})

		</script>







<?php



    }

}



?>





