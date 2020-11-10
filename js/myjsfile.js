$(document).ready(function(){
	var widget = $('.main');
	var tabs = widget.find('ul a');
	var content = $('.content');
	tabs.on('click', function(){
		var index = $(this).data('index');
		tabs.removeClass('onlink');
		$(this).addClass('onlink');
	});

	var arrow = $('.arrow-up1');
	var content1 = $('.list-contents1');
	var status = false;
	$('#notif').click(function(event){
		event.preventDefault();
		if(status == false){
			arrow.fadeIn();
			content1.fadeIn();
			status = true;
		}else{
			arrow.fadeOut();
			content1.fadeOut();
			status = false;
		}
	});

	$(document).mouseup(function(e){
		var arrow = $('.arrow-up1');
		var content1 = $('.list-contents1');
		if(!content1.is(e.target) && content1.has(e.target).length == 0){
			content1.fadeOut();
			arrow.fadeOut();
		}
	});

	var arrow2 = $('.arrow-up2');
	var content2 = $('.list-contents2');
	var status = false;
	$('#notif2').click(function(event){
		event.preventDefault();
		if(status == false){
			arrow2.fadeIn();
			content2.fadeIn();
			status = true;
		}else{
			arrow2.fadeOut();
			content2.fadeOut();
			status = false;
		}
	});

	$(document).mouseup(function(e){
			var arrow2 = $('.arrow-up2');
			var content2 = $('.list-contents2');
			if(!content2.is(e.target) && content2.has(e.target).length == 0){
				content2.fadeOut();
				arrow2.fadeOut();
			}
		});

	var sarrow = $('.setting-arrow');
	var ppanel = $('.setting-panel');
	pose = false;
	
	$('#sett').click(function(e){
		e.preventDefault();
		if(pose == false){
			sarrow.fadeIn();
			ppanel.fadeIn();
			pose = true;
		}else{
			sarrow.fadeOut();
			ppanel.fadeOut();
			pose = false;
		}
	});

	$(document).mouseup(function(e){
		if(!ppanel.is(e.target) && ppanel.has(e.target).length == 0){
			sarrow.fadeOut();
			ppanel.fadeOut();
		}
	});

	$('.menu-toggle').click(function(){
		$('.notifications').slideToggle('slow');
	});

	$('#search-button').click(function(){
		$('.form-input').slideToggle();
	});

	$('.detials').click(function(){
		$('.chat-box').fadeIn(1000);
		arrow2.fadeOut();
		content2.fadeOut();
	});

	$('.user').click(function(){
		$('.chat-box').fadeIn(1000);
		$('.chat-list-body').slideToggle();
	});

	$('.exit').click(function(){
		$('.chat-box').fadeOut(1000);
	});

	$('.chat-head2').click(function(){
		$('.chat-body2').slideToggle();
		$('.chat-footer').slideToggle();
	});

	$('.chat-list-body').hide();
	$('.chat-list-head').click(function(){
		$('.chat-list-body').slideToggle();
	});

	$('.clickable-1').click(function(){
		$('.time-contents').slideToggle(1000);
	});

	$('.clickable-2').click(function(){
		$('.remarks-contents').slideToggle(1000);
	});

	// Remarks
	$('.rema').click(function(e){
		e.preventDefault();
		$tr = $(this).closest('tr');
		var data = $tr.children("td").map(function(){
			return $(this).text();
		}).get();
		console.log(data);

		$('#re-app').val(data[1]);
	});

	// Forward
	$('.sss').click(function(e){
		e.preventDefault();
		$tr = $(this).closest('tr');
		var data = $tr.children("td").map(function(){
			return $(this).text();
		}).get();

		console.log(data);

		$('#applli_no').val(data[1]);
	});

	// Assigning
	$('.aaa').click(function(e){
		e.preventDefault();
		$tr = $(this).closest('tr');
		var data = $tr.children("td").map(function(){
			return $(this).text();
		}).get();

		console.log(data);

		$('#app').val(data[1]);
	});

	// View Details
	$('.view_data').click(function(e){
		e.preventDefault();
		var appli_id = $(this).attr("id");
				
		$.ajax({
			url:"modaldata.php",
			method:"POST",
			data:{appli_id:appli_id},
			success:function(data){
				$('#e_details').html(data);
				$('#application-details').modal("show");
			}
		});
	});
	
	$('#selectallboxes').click(function(event){
		if(this.checked){
			$('.checkboxes').each(function(){
				this.checked = true;
			});
		}else{
			$('.checkboxes').each(function(){
				this.checked = false;
			});
		}
	});

	$('.edt').click(function(event){
		event.preventDefault();
		var user_id = $(this).attr("id");

		$.ajax({
			url:"modaldata.php",
			method:"POST",
			data:{user_id:user_id},
			success:function(data){
				$("#applicant_data").html(data);
				$('#edit-modal').modal("show");
			}
		});
		
	});

	$('.o-edt').click(function(e){
		e.preventDefault();
		var office_id = $(this).attr("id");

		$.ajax({
			url:'modaldata.php',
			method:'POST',
			data:{office_id:office_id},
			success:function(data){
				$('#office_data').html(data);
				$('#office-edit').modal('show');
			}
		});
		
	});

	$('.noti-view').click(function(event){
		event.preventDefault();
		var notification_id = $(this).attr("id");
		
		$.ajax({
			url:'modaldata.php',
			method:'post',
			data:{notification_id:notification_id},
			success:function(data){
				$('#notification-data').html(data);
				$('#notification').modal('show');
			}
		});
		
	});

	$('.edit-noti').click(function(event){
		event.preventDefault();
		var edit_noti_id = $(this).attr("id");

		$.ajax({
			url:'modaldata.php',
			method:'post',
			data:{edit_noti_id:edit_noti_id},
			success:function(data){
				$('#edit-not').html(data);
				$('#edit-noti').modal('show');
			}
		});

	});

	$('.choice-form').click(function(){
		$('.appli-form').slideToggle(2000);
		$('.choice-file').slideToggle(2000);
		$('.choice-form').slideToggle(2000);
		$('.captions').slideToggle(2000);
	});

	$('.choice-file').click(function(){
		$('.form-attach').slideToggle(2000);
		$('.choice-form').slideToggle(2000);
		$('.choice-file').slideToggle(2000);
		$('.captions').slideToggle(2000);
	});

	$('#search_apps').keyup(function(){
		var txt = $(this).val();
		if(txt != ''){

		}else{
			$('#searchresult').html('');
			$.ajax({
				url:"modaldata.php",
				method:"post",
				data:{search:txt},
				dataType:"text",
				success:function(data)
				{
					$('#searchresult').html(data);
				}
			});
		}
	});


});