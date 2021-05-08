$(document).ready(function(){
		// when the user clicks on like
		$('.like').on('click', function(){
			var videoid = $(this).data('id');
			    $video = $(this);

			$.ajax({
				url: 'http://localhost/SEX/Public/Videos/SetLikeForVideo',
				type: 'POST',
				data: {
					'liked': 1,
					'videoid': videoid
				},
				success: function(response){
					if (response != -1) {
						$video.parent().find('span.likes_count').text(response);
						$video.addClass('hide');
						$video.siblings().removeClass('hide');
						console.log(response);
					}
					else{
						$('#staticBackdrop').modal('show');
					}
				}
			});
		});

		// when the user clicks on unlike
		$('.unlike').on('click', function(){
      var videoid = $(this).data('id');
			    $video = $(this);

			$.ajax({
				url: 'http://localhost/SEX/Public/Videos/DeleteLikeForVideo',
				type: 'POST',
				data: {
					'unliked': 1,
					'videoid': videoid
				},
				success: function(response){
          $video.parent().find('span.likes_count').text(response);
          $video.addClass('hide');
          $video.siblings().removeClass('hide');
          console.log(response);
				}
			});
		});

		// when the user clicks on like
		$('.baraction').on('click', function(){
			var userid = $(this).data('id');
					$user = $(this);

			$.ajax({
				url: 'http://localhost/SEX/Public/Dashboard/BarredtheUser',
				type: 'POST',
				data: {
					'userid': userid
				},
				success: function(response){
					if (response != -1) {
						$(".User_Status").text(response);
						//$user.parent().find('span.User_Status').text(response);
						$user.addClass('hide');
						$user.siblings().removeClass('hide');
						console.log(response);
					}
					else{
						$('#staticBackdrop').modal('show');
					}
				}
			});
		});

		// when the user clicks on unlike
		$('.unbaraction').on('click', function(){
			var userid = $(this).data('id');
					$user = $(this);

			$.ajax({
				url: 'http://localhost/SEX/Public/Dashboard/UnbarTheUser',
				type: 'POST',
				data: {
					'userid': userid
				},
				success: function(response){
					$(".User_Status").text(response);
					//$user.parent().find('span.User_Status').text(response);
					$user.addClass('hide');
					$user.siblings().removeClass('hide');
					console.log(response);
				}
			});
		});

		function updateUserStatus(){
			jQuery.ajax({
				url:'http://localhost/SEX/Public/Dashboard/GettheUserStatus',
				success:function(){

				}
			});
		}

		function getUserStatus(){
			jQuery.ajax({
				url:'http://localhost/SEX/Public/Dashboard/GettheUserStatus',
				success:function(result){
					jQuery('#user_grid').html(result);
				}
			});
		}

		setInterval(function(){
			updateUserStatus();
		},3000);

		setInterval(function(){
			getUserStatus();
		},7000);

		function Updatelogintracking(){
			$.ajax({
				url: 'http://localhost/Protorype1/Public/Authenticate/UserUpdateTracking',
			});
		}
		Updatelogintracking();
		//This is where End the user session
		function GetUserDuration(){
			$.ajax({
				url: 'http://localhost/Protorype1/Public/Authenticate/GetUserDuration',
				success:function(response){
					$('.alert').html(response);
				}
			});
		}
		//Check every 2 mins
		setInterval(function(){
			GetUserDuration();
		},1000);

	});
