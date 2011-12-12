jQuery.fn.userHome = function() {

	
	jQuery( "#tabs" ).tabs({
			spinner: 'Retrieving data...',
			ajaxOptions: {
				success: function(){
					//Makes the website lis draggable
					jQuery( ".website_drag" ).draggable({
						revert: true, helper: "clone"
					});

								jQuery( "#selectable" ).selectable();
				},
				error: function( xhr, status, index, anchor ) {
					jQuery( anchor.hash ).html(
						"Couldn't load this tab. We'll try to fix this as soon as possible. " +
						"If this wouldn't be a demo." );
				}
			}
		});
		

		//Makes the website lis draggable
		jQuery( ".website_drag" ).draggable({
			revert: true, helper: "clone"
		});

		//Allows category to accept the dropped website
		jQuery( ".website_drop" ).droppable({
			drop: function( event, ui ) {
					jQuery.post(
					"websites.php?act=add_website&request=js",
					{ category_id: jQuery('#tabs ul li.ui-state-active').attr('id'), website_id: jQuery(jQuery(ui.draggable)).attr("id")},
					function(data){
						jQuery('#tabs div').not('.ui-tabs-hide').html(data);
						jQuery( ".website_drag" ).draggable({
							revert: true, helper: "clone"
						});
					}
		
				);
			}
		});

	//Allows category to accept the dropped website
		jQuery( "#website_trash" ).droppable({
			drop: function( event, ui ) {
				jQuery.post(
					"websites.php?act=remove_website&request=js",
					{ category_id: jQuery('#tabs ul li.ui-state-active').attr('id'), website_id: jQuery(jQuery(ui.draggable)).attr("id")},
					function(data){				
						jQuery('#tabs div').not('.ui-tabs-hide').html(data);
						jQuery( ".website_drag" ).draggable({
							revert: true, helper: "clone"
						});
					}
				);
			}
		});

		jQuery( "#suggested_categories" ).change(function(){
			jQuery("#category_title").val(jQuery(this).val());
		});


		jQuery( "#add-a-category" )
			.button()
			.attr("href", "#")
			.click(function() {
				jQuery( "#category-form" ).dialog( "open" );
			});


		var title = jQuery( "#category_title" ),
			allFields = jQuery( [] ).add( title ),
			tips = jQuery( ".validateTips" );

		function updateTips( t ) {
			tips
				.text( t )
				.addClass( "ui-state-highlight" );
			setTimeout(function() {
				tips.removeClass( "ui-state-highlight", 1500 );
			}, 500 );
		}

		function checkLength( o, n, min, max ) {
			if ( o.val().length > max || o.val().length < min ) {
				o.addClass( "ui-state-error" );
				updateTips( "Length of " + n + " must be between " +
					min + " and " + max + "." );
				return false;
			} else {
				return true;
			}
		}

		function checkRegexp( o, regexp, n ) {
			if ( !( regexp.test( o.val() ) ) ) {
				o.addClass( "ui-state-error" );
				updateTips( n );
				return false;
			} else {
				return true;
			}
		}
		
		jQuery( "#category-form" ).dialog({
			autoOpen: false,
			height: 300,
			width: 350,
			modal: true,
			buttons: {
				"Create a category": function() {
					var bValid = true;
					allFields.removeClass( "ui-state-error" );

					bValid = bValid && checkLength( title, "title", 3, 16 );

					bValid = bValid && checkRegexp( title, /^[a-z]([0-9a-z_])+$/i, "Username may consist of a-z, 0-9, underscores, begin with a letter." );
					
					if ( bValid ) {
						var catName = title.val();
						jQuery.ajax({
							url: "category.php",
							method: "PUT",
							data: { title: title.val(), act: "create", request : "js"},
							success: function(data){
								jQuery("#tabs").tabs("add", data, catName);
								var id = data.split("id=")[1];
								jQuery("#tabs ul li").last().attr("id", id);
							}
						});
						//jQuery("#tabs").html();
						jQuery( this ).dialog( "close" );
					}
				},
				Cancel: function() {
					jQuery( this ).dialog( "close" );
				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});

		jQuery( "#add-a-website" )
			.button()
			.attr("href", "#")
			.click(function() {
				jQuery( "#website-form" ).dialog( "open" );
			});


		var websiteTitle = jQuery(" #website_title "), websiteUrl = jQuery(" #website_url ");

		function findURLForWebsite(){
			jQuery.ajax({
							url: "websites.php",
              dataType: 'json',
							method: "GET",
							data: { website_title: jQuery( "#website_title" ).val(), act: "search", request : "js"},
							success: function(data){
								if(data){
									jQuery( "#website_url" ).attr('readonly', 'readonly');
								}				
								jQuery( "#website_url" ).val(data.url);
								jQuery( "#website_id" ).val(data.id);
							}
				})
		}

		jQuery(" #website_title ").autocomplete(
		{
				source: 'search.php',
				select: function( event, ui ) {
					jQuery( "#website_title" ).val( ui.item.label );
					jQuery( "#website_url" ).val( ui.item.url ).attr('readonly', 'readonly');
					jQuery( "#website_id" ).val( ui.item.id );
				return false;
				}
			}
		).change(function(){
			jQuery( "#website_url" ).removeAttr('readonly');
			jQuery( "#website_id" ).val('');
			findURLForWebsite();
		});

		websiteUrl.change(function(){
			findURLForWebsite();
		});		

		jQuery( "#website-form" ).dialog({
			autoOpen: false,
			height: 300,
			width: 350,
			modal: true,
			buttons: {
				"Add Website": function() {
					var webTitle = websiteTitle.val();
					var webURL = websiteUrl.val();
					if((webURL != "" )&&(webTitle != "")){				
						if(jQuery("#website_id").val() != ""){
							var params = { category_id: jQuery('#tabs ul li.ui-state-active').attr('id'), website_id: jQuery("#website_id").val()};
						}else{
							var params = { category_id: jQuery('#tabs ul li.ui-state-active').attr('id'), website_title: webTitle, website_url: webURL};
						}
						jQuery.post(
							"websites.php?act=add_website&request=js",
							params,
							function(data){
								jQuery('#tabs div').not('.ui-tabs-hide').html(data);
								jQuery( ".website_drag" ).draggable({
									revert: true, helper: "clone"
								});
								
								jQuery( "#selectable" ).selectable();
							}
						);
						//jQuery("#tabs").html();
						jQuery( this ).dialog( "close" );
					}else{
						alert("Invalid Title or URL");
					}
					
				},
				Cancel: function() {
					jQuery( this ).dialog( "close" );
				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});
		jQuery( ".selectable" ).selectable();

};

